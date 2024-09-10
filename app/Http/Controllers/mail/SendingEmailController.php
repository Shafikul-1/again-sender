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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $request->validate([
            'mails' => 'required|string',
            'send_time' => 'required|string',
            'mail_subject' => 'required|string',
            'mail_body' => 'required|string',
            'mail_files' => 'required|array',
            'mail_files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $mailFileNames = [];
        if($request->has('mail_files')){
            $allFiles = $request->mail_files;
            foreach($allFiles as $files){
                $ext = $files->getClientOriginalExtension();
                // $ext = $request->file('mail_files')->extension();
                $rename = time() . '.' . $ext;
                $files->move(public_path() . '/mailFile' , $rename);
                $mailFileNames[] = $rename;
            }
        }

        $mailContent = MailContent::create([
            'mail_subject' => $request->mail_subject,
            'mail_body' => $request->mail_body,
            'mail_files' => $mailFileNames,
            'user_id' => $userId,
        ]);

        $sendingMails = explode(' ', $request->mails);
        $filterEmails = array_filter($sendingMails, function($value){
            return filter_var($value, FILTER_VALIDATE_EMAIL);  // Validate emails correctly
        });

        $send_time = $request->send_time;
        $sendingMail = array_map(function($data) use($mailContent,$send_time, $userId) {
            return [
                'mails' => $data,
                'send_time' => $send_time,
                'mail_content_id' => $mailContent->id,
                'user_id' => $userId,
            ];
        }, $filterEmails);

       $batchSize = 20;
       $chunks = array_chunk($sendingMail, $batchSize);
       foreach($chunks as $chunk){
        SendingEmail::insert($chunk);
       }

       return 'ok';
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
        //
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
