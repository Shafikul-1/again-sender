<?php

namespace App\Http\Controllers\fbData;

use App\Models\AllLink;
use App\Models\CollectData;
use App\Models\RequestLimit;
use Illuminate\Http\Request;
use App\Jobs\DatasCollectJob;
use App\Exports\ExportCollectData;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class CollectDataController extends Controller
{
    public function index()
    {
        $allData = CollectData::where('user_id', Auth::user()->id)->orderByDesc('id')->paginate(25);
        //  return $fileData;
        return view('fbData.allData', compact('allData'));
    }

    public function collectData()
    {
        // set_time_limit(200);
        // $getData = AllLink::where('check', 'valid')->where('status', 'noaction')->limit(10)->pluck('link')->toArray();
        AllLink::where('status', 'running')->update(['status' => 'pending',]);
        $getData = AllLink::where('check', 'valid')->where('status', 'noaction')->limit(10)->get();
        $collectionData = collect();

        if (!$getData->isEmpty()) {
            foreach ($getData as $key => $value) {
                $requestLimit = RequestLimit::firstOrCreate(
                    ['user_id' => $value->user_id],
                    ['request_limit' => 0]
                );

                if ($requestLimit->request_limit < 150) {
                    $requestLimit->increment('request_limit');
                    $collectionData->push($value);
                }
            }

            if (!$collectionData->isEmpty()) {
                try {
                    $sentJob =  DatasCollectJob::dispatch($collectionData);
                    if ($sentJob) {
                        foreach ($getData as $key => $value) {
                            AllLink::where('link', '=', $value->link)->update([
                                'status' => 'running'
                            ]);
                        }
                    }

                    return 'ok';
                } catch (\Throwable $th) {
                    Log::error('CollectData Error : ' . $th->getMessage());
                }
            }
        }
    }

    public function reciveData()
    {
        $filesPath = base_path('resources/js/fbData');
        if (File::exists($filesPath)) {
            $fullFilePath = File::files($filesPath);

            array_map(function ($fileCheck) use ($filesPath) {
                $fileName = $fileCheck->getFilename();
                if ($fileName === 'running.json') {
                    return;
                }
                $filePath = $filesPath . DIRECTORY_SEPARATOR . $fileName;
                $fileData = json_decode(File::get($filePath, true));

                if (is_array($fileData)) {
                    $fileInsert = array_map(function ($data) {
                        return [
                            'url' => $data->basicData->url ?? 'N/A',
                            'allInfo' => json_encode($data),
                            'user_id' => $data->basicData->user_id ?? 1,
                            // 'user_id' => Auth::user()->id,
                        ];
                    }, $fileData);
                    $batchSize = 100;
                    $chunks = array_chunk($fileInsert, $batchSize);
                    foreach ($chunks as $chunk) {
                        CollectData::insert($chunk);
                    }
                } else {
                    return 'File Data Format Wrong';
                }

                File::delete($filePath);

                return 'Success Data Insert';
            }, $fullFilePath);
        } else {
            return 'Already up to date';
        }
    }

    public function multiwork(Request $request)
    {
        // Log::info($request->all());
        $validator = Validator::make($request->all(), [
            'linkIds' => 'required|array',       // Ensure 'ids' is an array
            'linkIds.*' => 'integer',             // Ensure each ID in the array is an integer
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Return validation errors
        }

        $linkIds = $request->input('linkIds');

        if ($linkIds) {
            CollectData::whereIn('id', $linkIds)->delete();
        }

        return response()->json(['success' => 'Links deleted successfully.']);
    }

    public function exportData()
    {
        return Excel::download(new ExportCollectData, 'collect-data.xlsx');
    }
}
