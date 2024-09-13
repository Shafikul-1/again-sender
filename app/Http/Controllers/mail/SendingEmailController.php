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
    public function index()
    {
        $sendingEmails = SendingEmail::with('mail_content')->where('user_id', Auth::user()->id)->orderByDesc('id')->paginate(25);
        return view('mail.sendingEmails.all', compact('sendingEmails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userSetupEmails = MailSetup::pluck('mail_username');
        return view('mail.sendingEmails.add', compact('userSetupEmails'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::user()->id;

        // Validate inputs
        $request->validate([
            'mails' => 'required|string',
            'send_time' => 'required|string',
            'mail_subject' => 'required|string',
            'mail_body' => 'required|string',
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
        $send_time = $request->send_time;
        $mail_form = $request->mail_form;
        $schedule_time = explode('|', $request->schedule_time);
        // $randomMinute = $schedule_time[array_rand($schedule_time)];
        $sendingMail = array_map(function ($data) use ($mailContent, $send_time, $userId, $schedule_time, $mail_form) {
            $randomMinute = $schedule_time[array_rand($schedule_time)];
            $newTime = Carbon::parse($send_time)->addMinutes((int)$randomMinute);
            return [
                'mails' => $data,
                'send_time' => $newTime,
                'mail_form' => $mail_form,
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
        return $allEmails;
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
}
