<?php

namespace App\Http\Controllers\mail;

use App\Models\MailContent;
use App\Models\SendingEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SendingEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sendingEmails = SendingEmail::with('mail_content')->where('user_id', Auth::user()->id)->paginate(10);
        return view('mail.sendingEmails.all', compact('sendingEmails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mail.sendingEmails.add');
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
            'mail_files' => 'nullable|array',
            'mail_files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10100',
        ]);
        // return $request;

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
        $sendingMail = array_map(function ($data) use ($mailContent, $send_time, $userId) {
            return [
                'mails' => $data,
                'send_time' => $send_time,
                'mail_content_id' => $mailContent->id,
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
}
