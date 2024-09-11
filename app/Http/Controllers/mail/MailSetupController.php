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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mail.mailSetup');
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
            'mail_password' => 'required',
            'mail_encryption' => 'required|string',
            'mail_from' => 'required|string',
            'mail_sender_name' => 'required|string',
        ]);

        $otherLinks = $request->other_links;
        $otherLink = json_decode($otherLinks, true);

        MailSetup::create([
            'mail_transport' => $request->mail_transport,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_from' => $request->mail_from,
            'mail_sender_name' => $request->mail_sender_name,
            'other_links' => $otherLink,
            'user_id' => Auth::user()->id,
        ]);

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
        $request->validate([
            'mail_transport' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|integer',
            'mail_username' => 'required|string',
            'mail_password' => 'required',
            'mail_encryption' => 'required|string',
            'mail_from' => 'required|string',
            'mail_sender_name' => 'required|string',
            'department' => 'required|string',
            'whatsapp_link' => 'required|string',
            'instagram_link' => 'required|string',
            'website' => 'required|string',
            'profile_link' => 'required|string',
        ]);

        $updateMail =  MailSetup::where('id', $id)->update([
            'mail_transport' => $request->mail_transport,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_from' => $request->mail_from,
            'mail_sender_name' => $request->mail_sender_name,
            'department' => $request->department,
            'whatsapp_link' => $request->whatsapp_link,
            'instagram_link' => $request->instagram_link,
            'website' => $request->website,
            'profile_link' => $request->profile_link,
        ]);

        return 'ok';
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
