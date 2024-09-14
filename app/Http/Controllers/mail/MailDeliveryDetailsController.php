<?php

namespace App\Http\Controllers\mail;

use Illuminate\Http\Request;
use App\Models\MailDelivaryDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MailDeliveryDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allDetails = MailDelivaryDetail::where('user_id', Auth::user()->id)->get();
        // return $allDetails;
        return view('mail.mailDelivery.all', compact('allDetails'));
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
        //
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
        $deleteMessage = MailDelivaryDetail::find($id)->delete();
        return redirect()->back()->with('Delete Successful');
    }
}
