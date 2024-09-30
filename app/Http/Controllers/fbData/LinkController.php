<?php

namespace App\Http\Controllers\fbData;

use App\Models\AllLink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{
    public function index()
    {
        $allLinks = AllLink::where('user_id', Auth::user()->id)->orderByDesc('id')->paginate(25);
        return view('fbData.allLink', compact('allLinks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'links' => 'required|string'
        ]);

        $allLinks = explode(' ', $request->links);
        $filterArray = array_filter($allLinks, function ($value) {
            return !empty($value);
        });

        function checkLink($link)
        {
            return Str::startsWith($link, ['https://', 'http://']) ? 'valid' : 'invalid';
        }

        $data = array_map(function ($link) {
            return [
                'link' => $link,
                'status' => 'noaction',
                'check' => checkLink($link),
                'user_id' => Auth::user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $filterArray);

        $batchSize = 200;
        $chunks = array_chunk($data, $batchSize);
        // return $chunks;
        foreach ($chunks as $chunk) {
            AllLink::insert($chunk);
        }

        return redirect()->route('allLink.index')->with('success', 'Link Added Successful');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteLink = AllLink::find($id)->delete();
        return $deleteLink ? redirect()->back()->with('success', 'link delete succesful') : redirect()->back()->with('error', 'Someting went wrong');
    }

    // Multi work
    public function multiwork(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',       // Ensure 'ids' is an array
            'ids.*' => 'integer',             // Ensure each ID in the array is an integer
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Return validation errors
        }

        // Proceed with deletion logic
        AllLink::destroy($request->input('ids')); // Use destroy to delete multiple records

        return response()->json(['success' => true, 'message' => 'Links deleted successfully']);
    }

    public function linkDelete()
    {
        $deleteData = AllLink::where('status', 'pending')->delete();
        if ($deleteData) {
            return 'delete Successfull';
        } else {
            return 'delete Failed';
        }
    }
}
