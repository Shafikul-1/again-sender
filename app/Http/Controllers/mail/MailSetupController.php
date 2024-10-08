<?php

namespace App\Http\Controllers\mail;

use App\Models\MailSetup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class MailSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $allEmail = MailSetup::where('user_id', Auth::user()->id)->paginate(5);
        $query = MailSetup::query();

        $query->select(['id', 'mail_from'])->withCount([
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
        ]);
        if ($search = request()->input('search')) {
            $query->where('mail_from', 'LIKE', '%' . $search . '%');
        }
        $allEmail = $query->where('user_id', Auth::user()->id)->paginate(25)->appends(['search', $search]);
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
            'mail_username' => 'required|email',
            'mail_password' => 'required|string',
            'mail_encryption' => 'required|string',
            'mail_from' => 'required|email',
            'mail_sender_name' => 'required|string',
        ]);
        $otherLink = [];
        if ($request->other_links != null) {
            $request->validate([
                'other_links' => 'required|json',
            ]);
            $jsonData = json_decode($request->other_links, true);
            foreach ($jsonData as $key => $item) {
                $validator = Validator::make($item, [
                    'iconLink' => 'required|string',
                    'yourLink' => 'required|string',
                    'linkIndex' => 'required|numeric',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $otherLink[] = $validator->validate();
            }
        }

        if ($request->sender_number) {
            $request->validate([
                'sender_number' => 'required|numeric',
                // 'sender_number' => 'required|digits:11',
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
        $editData = MailSetup::findOrFail($id);
        if(!Gate::allows('checkPermission', $editData)){
           abort(403, 'Not Permiton This Content');
        }
        // return $editData;
        return view('mail.setup.edit', compact('editData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $updateData = MailSetup::findOrFail($id);
        if(!Gate::allows('checkPermission', $updateData)){
           abort(403, 'Not Permiton This Content');
        }
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

        $otherLink = [];
        if ($request->has('other_links')) {
            $request->validate([
                'other_links' => 'required|json',
            ]);
            $jsonData = json_decode($request->other_links, true);
            foreach ($jsonData as $item) {
                $validator = Validator::make($item, [
                    'iconLink' => 'required|string',
                    'yourLink' => 'required|string',
                    'linkIndex' => 'required|integer',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $otherLink[] = $validator->validate();
            }
        }

        if ($request->has('sender_number')) {
            $request->validate([
                'sender_number' => 'required|numeric',
            ]);
        }
        // return $otherLink;
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
            'other_links' => $otherLink,
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
        $deleteMail = MailSetup::findOrFail($id)->delete();
        return $deleteMail ? redirect()->back()->with('success', 'Mail Delete Successful') :  redirect()->back()->with('error', 'someting went wrong');
    }
}
