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
use Illuminate\Support\Facades\Auth;

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
        if($search = request()->input('search')){
            $query->where('mails', 'LIKE' , '%' . $search . '%');
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
        $userSetupEmails = MailSetup::pluck('mail_from');
        return view('mail.sendingEmails.add', compact('userSetupEmails'));
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
            'mail_files' => 'nullable|array',
            'mail_files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10100',
            'schedule_time' => ['required', 'regex:/^(\d+(\|\d+)*)?$/'],
        ]);

        // Handle file uploads
        $mailFileNames = [];
        if ($request->has('mail_files')) {
            foreach ($request->mail_files as $files) {
                $ext = $files->getClientOriginalExtension();
                $rename = time() . '_' . uniqid() . '.' . $ext;
                $files->move(public_path() . '/mailFile', $rename);
                $mailFileNames[] = $rename;
            }
        }

        // Create mail content record
        $mailContent = MailContent::create([
            'mail_subject' => $request->mail_subject,
            'mail_body' => $request->mail_body,
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
        $mailsetup_id = $mailsetupDetails->id;

        $send_time = $request->send_time;
        $mail_form = $request->mail_form;
        $schedule_time = explode('|', $request->schedule_time);
        // $randomMinute = $schedule_time[array_rand($schedule_time)];

        $sendingMail = array_map(function ($data) use ($mailContent, $send_time, $userId, $schedule_time, $mail_form, $mailsetup_id) {
            $randomMinute = $schedule_time[array_rand($schedule_time)];
            $newTime = Carbon::parse($send_time)->addMinutes((int)$randomMinute);
            return [
                'mails' => $data,
                'send_time' => $newTime,
                'wait_minute' => (int)$randomMinute,
                'mail_form' => $mail_form,
                'mailsetup_id' => $mailsetup_id,
                'mail_content_id' => $mailContent->id,
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => $userId,
            ];
        }, $filterEmails);

        // Batch insert emails
        $batchSize = 20;
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
        $sendingEmails = SendingEmail::with('mail_content')->find($id);
        // return $sendingEmails;
        return view('mail.sendingEmails.edit', compact('sendingEmails'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteSendingEmail = SendingEmail::find($id)->delete();
        return $deleteSendingEmail ? redirect()->back()->with('success', 'Mail Delete successful') :  redirect()->back()->with('error', 'someting went wrong');
    }

    /**
     * Current time less then equal `>=` all waiting sent emails add SendingEmailJob table
     */
    public function sendingEmails()
    {
        $currentTime = Carbon::now();
        $allEmails = SendingEmail::with('mail_content')->where('send_time', '<=', $currentTime)->where('status', 'noaction')->get();
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
    }

    /**
     * Check Sending Time to Create Time because Net or ElectryCity problem
     */
    public function checkTime()
    {
        $currentTime = now();
        $overSendTime  = SendingEmail::where('send_time', '<=', $currentTime)->get();
        foreach ($overSendTime as $key => $value) {
            try {
                SendingEmail::where('id', $value->id)->update(['send_time' => $currentTime->addMinutes($value->wait_minute)]);
            } catch (\Throwable $th) {
                Log::error('Check Time Error => ' . $th->getMessage());
            }
        }
        return "Time Update Successful";
    }
}
