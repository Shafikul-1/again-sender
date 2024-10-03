<?php

namespace App\Http\Controllers\mail;

use Throwable;
use Carbon\Carbon;
use App\Models\MailSetup;
use App\Models\MailContent;
use App\Models\SendingEmail;
use Illuminate\Http\Request;
use App\Jobs\SendingEmailJob;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\UserFiles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class SendingEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SendingEmail::query();

        if ($email = $request->query('email')) {
            $query->where('mail_form',  $email);
        }
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }
        if ($search = request()->input('search')) {
            $query->where('mails', 'LIKE', '%' . $search . '%');
        }
        $query->where('user_id', Auth::user()->id);

        $sendingEmails = $query->with('mail_content')->orderByDesc('id')->paginate(25)->appends(['email' => $email, 'status' => $status, 'search' => $search]);
        // return $sendingEmails;
        return view('mail.sendingEmails.all', compact('sendingEmails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userSetupEmails = MailSetup::where('user_id', Auth::user()->id)->pluck('mail_from');
        $allFiles = UserFiles::where('user_id', Auth::user()->id)->pluck('file_name');
        // return $userSetupEmails;
        $emailAndStatus = $userSetupEmails->map(function ($email) {
            $status = SendingEmail::where('mail_form', $email)
                ->where('user_id', Auth::id())
                ->where('status', 'noaction')
                ->exists(); // Use exists() for better performance

            return [
                'email' => $email,
                'status' => $status
            ];
        });
        // return $emailAndStatus;
        return view('mail.sendingEmails.add', compact('emailAndStatus', 'allFiles'));
        // $previseFiles = MailContent::where('user_id', Auth::user()->id)->pluck('mail_files');
        // $allFiles = $previseFiles->flatten();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $userId = Auth::user()->id;

        // Validate inputs
        $request->validate([
            'mails' => 'required|string',
            'send_time' => 'required|string',
            'mail_subject' => 'required|string',
            'mail_body' => 'required',
            'mail_form' => 'required|string|not_in:""',
            'schedule_time' => ['required', 'regex:/^(\d+(\|\d+)*)?$/'],
        ]);

        $content = $request->mail_body;
        // Regular expression to match base64-encoded images with specific formats
        // $pattern = '/data:image\/(jpeg|png|gif|avif|jpg|webp);base64,([^\"]*)/';
        // preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

        // foreach ($matches as $match) {
        //     $fileType = $match[1];
        //     $fileData = base64_decode($match[2]);
        //     $renameFile = uniqid() . time() . '.' . $fileType;

        //     $directory = public_path('mailFile');
        //     $filePath = $directory . '/' . $renameFile;

        //     if (!is_dir($directory)) {
        //         mkdir($directory, 0755, true);
        //     }

        //     file_put_contents($filePath, $fileData);

        //     UserFiles::create([
        //         'file_name' => $renameFile,
        //         'user_id' => Auth::user()->id,
        //     ]);

        //     $content = str_replace($match[0], asset('mailFile/' . $renameFile), $content);
        // }

        // Handle file uploads
        $mailFileNames = [];
        if ($request->has('mail_files')) {
            $request->validate([
                'mail_files' => 'required|array',
                'mail_files.*' => 'file|mimes:jpg,jpeg,png,pdf,webp,gif,avif,jfif|max:10100',
            ]);
            foreach ($request->mail_files as $files) {
                $ext = $files->getClientOriginalExtension();
                $rename = time() . '_' . uniqid() . '.' . $ext;
                $files->move(public_path() . '/mailFile', $rename);
                $mailFileNames[] = $rename;
            }

            $allFile = array_map(function ($data) {
                return [
                    'file_name' => $data,
                    'user_id' => Auth::user()->id,
                ];
            }, $mailFileNames);

            $arrayChunk = array_chunk($allFile, 20);
            foreach ($arrayChunk as $key => $value) {
                UserFiles::insert($value);
            }
        }

        if ($request->mail_previse_file != null) {
            $request->validate([
                'mail_previse_file' => 'nullable|string',
            ]);
            $getFileName = explode(',', $request->mail_previse_file);
            // $mailFilNames = array_merge($mailFileNames, $getFileName);
            foreach ($getFileName as $fileName) {
                $mailFileNames[] = $fileName;
            }
        }


        // Create mail content record
        $mailContent = MailContent::create([
            'mail_subject' => $request->mail_subject,
            'mail_body' => $content,
            'mail_files' => $mailFileNames,
            'user_id' => $userId,
        ]);

        // Filter and validate emails
        $sendingMails = preg_split('/[\s,]+/', $request->mails);
        $filterEmails = array_filter($sendingMails, function ($value) {
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        });

        // Prepare data for batch insertion
        $mailsetupDetails = MailSetup::where('mail_from', $request->mail_form)->where('user_id', Auth::user()->id)->first();
        if (!$mailsetupDetails) {
            return redirect()->back()->withErrors('Select email is not yours')->withInput();
        }

        $mailsetup_id = $mailsetupDetails->id;
        $mail_form = $request->mail_form;

        $schedule_time = explode('|', $request->schedule_time);
        $currentTime = Carbon::parse($request->send_time);

        $sendingMail = array_map(function ($data) use ($mailContent, $userId, $schedule_time, $mail_form, $mailsetup_id, &$currentTime) {
            $wait_minute = 0;

            if (count($schedule_time) === 1) {
                $randomMinute = (int)$schedule_time[0];
            } else {
                $randomMinute = (int)$schedule_time[array_rand($schedule_time)];
            }

            $wait_minute = $randomMinute;
            $newTime = $currentTime->copy()->addMinutes($randomMinute);
            $currentTime = $newTime;

            return [
                'mails' => $data,
                'send_time' => $newTime,
                'wait_minute' => $wait_minute,
                'mail_form' => $mail_form,
                'mailsetup_id' => $mailsetup_id,
                'mail_content_id' => $mailContent->id,
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => $userId,
            ];
        }, $filterEmails);

        // Batch insert emails
        $batchSize = 50;
        $chunks = array_chunk($sendingMail, $batchSize);

        foreach ($chunks as $chunk) {
            SendingEmail::insert($chunk);
        }

        // Redirect after successful insert
        return redirect()->route('sendingemails.index')->with('success', 'All Mail Added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sendingEmailEdit = SendingEmail::with('mail_content')->findOrFail($id);
        if ($sendingEmailEdit->status != 'noaction') {
            return redirect()->route('sendingemails.index')->with('error', 'Please check Email staus');
        }
        if (!Gate::allows('checkPermission', $sendingEmailEdit)) {
            abort(403, 'Not Permiton This Content');
        }
        $userSetupEmails = MailSetup::where('user_id', Auth::user()->id)->get(['id', 'mail_from']);
        $allFiles = UserFiles::where('user_id', Auth::user()->id)->pluck('file_name');
        // return $sendingEmailEdit;
        return view('mail.sendingEmails.edit', compact(['sendingEmailEdit', 'userSetupEmails', 'allFiles']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sendingEmailData = SendingEmail::with('mail_content')->findOrFail($id);
        if ($sendingEmailData->status != 'noaction') {
            return redirect()->route('sendingemails.index')->with('error', 'Please check Email staus');
        }
        if (!Gate::allows('checkPermission', $sendingEmailData)) {
            abort(403, 'Not Permiton This Content');
        }
        $request->validate([
            'mails' => 'required|string',
            'send_time' => 'required|string',
            'mail_subject' => 'required|string',
            'mail_body' => 'required',
            'mail_from' => 'required|string',
            'schedule_time' => ['required', 'regex:/^(\d+(\|\d+)*)?$/'],
        ]);

        $fileData = [];
        if ($request->has('mail_files')) {
            $request->validate([
                'mail_files' => 'required|array',
                'mail_files.*' => 'file|mimes:jpg,jpeg,png,pdf,webp,gif,avif,jfif|max:10100',
            ]);

            foreach ($request->mail_files as $files) {
                $ext = $files->getClientOriginalExtension();
                $rename = time() . '_' . uniqid() . '.' . $ext;
                $files->move(public_path() . '/mailFile', $rename);
                $fileData[] = $rename;
            }

            $allFile = array_map(function ($data) {
                return [
                    'file_name' => $data,
                    'user_id' => Auth::user()->id,
                ];
            }, $fileData);

            $arrayChunk = array_chunk($allFile, 20);
            foreach ($arrayChunk as $key => $value) {
                UserFiles::insert($value);
            }
        }

        if ($request->mail_previse_file != null) {
            $request->validate([
                'mail_previse_file' => 'required|string',
            ]);
            $getFileName = explode(',', $request->mail_previse_file);
            // $mailFilNames = array_merge($mailFileNames, $getFileName);
            foreach ($getFileName as $fileName) {
                $fileData[] = $fileName;
            }
        }

        MailContent::where('id', $sendingEmailData->mail_content_id)->update([
            'mail_subject' => $request->mail_subject,
            'mail_body' => $request->mail_body,
            'mail_files' => $fileData,
        ]);

        $setupEmailId = MailSetup::where('mail_from', $request->mail_from)->first();
        // return $request;
        SendingEmail::where('id', $id)->update([
            'mails' => $request->mails,
            'mail_form' => $request->mail_from,
            'send_time' => $request->send_time,
            'wait_minute' => $request->schedule_time,
            'mailsetup_id' => $setupEmailId['id'],
        ]);
        return redirect()->route('sendingemails.index')->with('success', 'Update Successful');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteSendingEmail = SendingEmail::findOrFail($id);
        if (Gate::allows('checkPermission', $deleteSendingEmail)) {
            $mailContentId = SendingEmail::where('mail_content_id', $deleteSendingEmail->mail_content_id)->get();
            $deleteAll = $this->deleteFile($mailContentId, $deleteSendingEmail);
            return $deleteAll ? redirect()->back()->with('success', 'Mail Delete successful') :  redirect()->back()->with('error', 'someting went wrong');
        } else {
            return  redirect()->back()->with('error', 'no permession delete this content');
        }
    }

    /**
     * Current time less then equal `>=` all waiting sent emails add SendingEmailJob table
     */
    public function sendingEmails()
    {
        $currentTime = Carbon::now();
        $allEmails = SendingEmail::with('mail_content')->where('send_time', '<=', $currentTime)->whereIn('status', ['noaction', 'fail'])->limit(10) ->get();
        // return $allEmails;
        try {
            if ($allEmails->isNotEmpty()) {
                SendingEmailJob::dispatch($allEmails);
                // Bulk update status to 'pending'
                $emailIds = $allEmails->pluck('id');
                SendingEmail::whereIn('id', $emailIds)->update(['status' => 'pending']);
                return "ok";
            }
        } catch (Throwable $th) {
            Log::error("Email Dispatch Error SendingEmailController => " . $th->getMessage());
        }
    }
    // SendingEmail::with('mail_content')
    //     ->where('send_time', '<=', $currentTime)
    //     ->where('status', 'noaction')
    //     ->chunk(100, function ($emails) {
    //         // Dispatch job for each chunk
    //         SendingEmailJob::dispatch($emails);

    //         // Bulk update status for each chunk
    //         $emailIds = $emails->pluck('id');
    //         SendingEmail::whereIn('id', $emailIds)->update(['status' => 'pending']);
    //     });



    /**
     * Check Sending Time to Create Time because Net or ElectryCity problem
     */
    public function checkTime()
    {
        $currentTime = Carbon::now();
        $overSendTime = SendingEmail::where('send_time', '<=', $currentTime)
            ->whereIn('status', ['noaction', 'fail'])
            ->get();

        DB::beginTransaction();
        $previseSenderEmail = null;
        $previseSendTime = null;

        try {
            foreach ($overSendTime as $email) {
                $currentSenderEmail = $email->mail_form;

                if ($previseSenderEmail === $currentSenderEmail && $previseSendTime) {
                    $newSendTime = $previseSendTime->copy()->addMinutes($email->wait_minute);
                } else {
                    $newSendTime = $currentTime->copy()->addMinutes($email->wait_minute);
                }

                $email->update(['send_time' => $newSendTime]);

                $previseSenderEmail = $currentSenderEmail;
                $previseSendTime = $newSendTime;
            }

            DB::commit();
            return "Time Update Successful";
        } catch (Throwable $th) {
            DB::rollBack();
            Log::error('Check Time Error => ' . $th->getMessage());
            return "Error occurred while updating send times.";
        }
    }

    /**
     * Multi work this delete ssending email
     */
    public function multiwork(Request $request)
    {
        $validated = $request->validate([
            'multiId' => 'required|string',
        ]);

        if ($request->multiId != null) {
            $allId = explode(',', $request->multiId);
            try {
                foreach ($allId as $id) {
                    $deleteSendingEmail = SendingEmail::findOrFail($id);
                    if (Gate::allows('checkPermission', $deleteSendingEmail)) {
                        $mailContentId = SendingEmail::where('mail_content_id', $deleteSendingEmail->mail_content_id)->get();
                        $this->deleteFile($mailContentId, $deleteSendingEmail);
                    }
                }
                return redirect()->back()->with('success', 'All Delete Successful');
            } catch (Throwable $th) {
                return redirect()->back()->with('error', 'Someting went wrong');
            }
        } else {
            return redirect()->back()->with('error', 'please select');
        }
    }

    /**
     * Private function file delete
     */
    private function deleteFile($content, $data)
    {
        try {
            if (count($content) > 1) {
                $data->delete();
            } else {
                $contentDelete = MailContent::findOrFail($data->mail_content_id);
                $contentDelete->delete();
            }
            return true;
        } catch (Throwable $th) {
            return false;
        }
    }

    /**
     *  only file delete
     */
    public function uploadFileDelete($name)
    {
        try {
            $deleteFileName = UserFiles::where('file_name', $name)->first();
            $filePath =  public_path() . '/mailFile/' . $name;
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            $deleteFileName->delete();
            return redirect()->back()->with('success', 'file Delete Successful');
        } catch (\Throwable $th) {
            Log::error('fileDeleteFailed => ' . $th->getMessage());
            return redirect()->back()->with('error', 'Someting went wrong');
        }

        // $mailContent  = MailContent::where('user_id', Auth::user()->id)->whereJsonContains('mail_files', $name)->first();
        // if ($mailContent) {
        //     $updateFiles = array_diff($mailContent->mail_files, [$name]);
        //     $mailContent->mail_files = array_values($updateFiles);
        //     $mailContent->save();

        //     $filePath =  public_path() . '/mailFile/' . $name;
        //     if (File::exists($filePath)) {
        //         File::delete($filePath);
        //     }
        //     return redirect()->back()->with('success', 'file Delete Successful');
        // } else {
        //     return redirect()->back()->with('error', 'No File Found');
        // }
    }
}
