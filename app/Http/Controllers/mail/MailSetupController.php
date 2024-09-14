<?php

namespace App\Http\Controllers\mail;

use App\Models\MailSetup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MailSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $allEmail = MailSetup::where('user_id', Auth::user()->id)->paginate(10);
        $allEmail = MailSetup::select(['id','mail_from'])->withCount([
            'sending_emails as noaction_count' => function ($query) {
                $query->where('status', 'noaction');
            },
            'sending_emails as pending_count' => function ($query) {
                $query->where('status', 'pending');
            },
            'sending_emails as netdisable_count' => function ($query) {
                $query->where('status', 'netdisable');
            },
            'sending_emails as fail_count' => function ($query) {
                $query->where('status', 'fail');
            },
            'sending_emails as success_count' => function ($query) {
                $query->where('status', 'success');
            },
        ])
        ->where('user_id', Auth::user()->id)->paginate(10);
        // return $allEmail;
        return view('mail.setup.all', compact('allEmail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mail.setup.mailSetup');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mail_transport' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|numeric',
            'mail_username' => 'required|string',
            'mail_password' => 'required|string',
            'mail_encryption' => 'required|string',
            'mail_from' => 'required|string',
            'mail_sender_name' => 'required|string',
        ]);

        $otherLinks = $request->other_links;
        $otherLink = json_decode($otherLinks, true);

        if ($request->sender_number) {
            $request->validate([
                'sender_number' => 'required|digits:11',
            ]);
        }

        $mailPass =  str_replace(' ', '', $request->mail_password);
        $insertData =  MailSetup::create([
            'mail_transport' => $request->mail_transport,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $mailPass,
            'mail_encryption' => $request->mail_encryption,
            'mail_from' => $request->mail_from,
            'mail_sender_name' => $request->mail_sender_name,
            'sender_department' => $request->sender_department,
            'other_links' => $otherLink,
            'sender_company_logo' => $request->sender_company_logo,
            'sender_website' => $request->sender_website,
            'sender_number' => $request->sender_number,
            'user_id' => Auth::user()->id,
        ]);

        return $insertData ? redirect()->route('mailsetup.index')->with('success', 'Mail Added Successful') :  redirect()->back()->with('error', 'someting went wrong');
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
        $editData = MailSetup::find($id);
        // return $editData;
        return view('mail.setup.edit', compact('editData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'mail_transport' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|numeric',
            'mail_username' => 'required|string',
            'mail_password' => 'required|string',
            'mail_encryption' => 'required|string',
            'mail_from' => 'required|string',
            'mail_sender_name' => 'required|string',
        ]);

        // $otherLinks = $request->other_links;
        // $otherLink = json_decode($otherLinks, true);

        if ($request->sender_number) {
            $request->validate([
                'sender_number' => 'required|numeric',
            ]);
        }

        $mailPass =  str_replace(' ', '', $request->mail_password);
        $updateMail =  MailSetup::where('id', $id)->update([
            'mail_transport' => $request->mail_transport,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $mailPass,
            'mail_encryption' => $request->mail_encryption,
            'mail_from' => $request->mail_from,
            'mail_sender_name' => $request->mail_sender_name,
            'sender_department' => $request->sender_department,
            // 'other_links' => $otherLink,
            'sender_company_logo' => $request->sender_company_logo,
            'sender_website' => $request->sender_website,
            'sender_number' => $request->sender_number,
        ]);

        return $updateMail ? redirect()->route('mailsetup.index')->with('success', 'Mail Added Successful') :  redirect()->back()->with('error', 'someting went wrong');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteMail = MailSetup::find($id)->delete();
        return $deleteMail ? redirect()->back()->with('success', 'Mail Delete Successful') :  redirect()->back()->with('error', 'someting went wrong');
    }
}
