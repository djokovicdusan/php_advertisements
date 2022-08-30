<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdItemRequest;
use App\Models\Ad;
use App\Models\AdItem;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdItemController extends Controller
{
    public function index()
    {
        $aditems = AdItem::all();
        return view('admin/ads/add', ['adItems' => $aditems]);
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'max:2000000',
        ]);
        $fileOriginalName = request()->file->getClientOriginalName();
        $file_name = time() . '.' . request()->file->getClientOriginalExtension();
        request()->file->move('assets/ads/videoRaw', $fileOriginalName);
        $file_path = asset('assets/ads/videoRaw/' . $fileOriginalName);
        return response()->json(['file_path' => $file_path]);
    }


    public function store(Request $request)
    {
//        dd($request->all());
        $typeId = $request->type_id;


        if ($typeId == 1) {
            //        dd($request->all());
            $validator = $request->validate([
                'videoFile' => 'required|max:2000000',
                'videoName'=>'string|required',
                'duration'=> 'required'
            ]);

            $duration = $request->get('duration');
            $file = $request->file('videoFile');



            $fileName = $request->get('videoName');

//            File::move('assets/ads/videoRaw/' . \request()->file->getClientOriginalName(), 'assets/ads/video')
            $fullFileName = $fileName . "." . $file->getClientOriginalExtension();
            //move already uploaded video from raw folder to main video folder, and delete file in raw folder afterwards

            File::move('assets/ads/videoRaw/' . \request()->videoFile->getClientOriginalName(), 'assets/ads/video/' . $fullFileName);
            File::delete('assets/ads/videoRaw/' . \request()->videoFile->getClientOriginalName());
//            $file->move('assets/ads/video', $fullFileName);


            AdItem::create([
                'duration' => $duration,
                'file_name' => $fullFileName,
                'type_id' => $typeId,

            ]);
//            AdItem::create($request->validated());

            return redirect()->back();
        } else if ($typeId == 2) {
//             dd($request->all());

            $validator = $request->validate([
                'slideshowName'=>'string|required',
                'duration'=>'required',
                'images'=>'required'
            ]);

            $images = $request->file('images');
//            dd($images);
            $name = $request->get('slideshowName');
//            dd($name);
            $duration = $request->get('duration');
//            $key = 1;


            for ($i = 0; $i < count($images); $i++) {
//                var_dump($images[$i]);
                $fullFileName = '0' . $i . '.' . $images[$i]->getClientOriginalExtension();

                Storage::disk('public')->putFileAs('ads/slideshows/' . $name, $images[$i], $fullFileName);


            }
            AdItem::create([
                'duration' => $duration,
                'file_name' => $name,
                'type_id' => $typeId,

            ]);

            return redirect()->back();
        }


    }


}
