<?php

namespace App\Services;

use App\Models\AdItem;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdItemService
{

    public function storeSlideshow(Request $request)
    {
        $validator = $request->validate([
            'slideshowName' => 'string|required',
            'duration' => 'required',
            'images' => 'required'
        ]);

        $images = $request->file('images');
        $name = $request->get('slideshowName');
        $duration = $request->get('duration');


        for ($i = 0; $i < count($images); $i++) {
            $fullFileName = '0' . $i . '.' . $images[$i]->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('ads/slideshows/' . $name, $images[$i], $fullFileName);
        }
        AdItem::create([
            'duration' => $duration,
            'file_name' => $name,
            'type_id' => 2,

        ]);

    }

    public function storeVideo(Request $request)
    {
        $validator = $request->validate([
            'videoFile' => 'required|max:2000000',
            'videoName' => 'string|required',
            'duration' => 'required'
        ]);

        $duration = $request->get('duration');
        $file = $request->file('videoFile');
        $fileName = $request->get('videoName');

        $fullFileName = $fileName . "." . $file->getClientOriginalExtension();
        //move already uploaded video from raw folder to main video folder, and delete file in raw folder afterwards
        File::move('assets/ads/videoRaw/' . \request()->videoFile->getClientOriginalName(), 'assets/ads/video/' . $fullFileName);
        File::delete('assets/ads/videoRaw/' . \request()->videoFile->getClientOriginalName());


        AdItem::create([
            'duration' => $duration,
            'file_name' => $fullFileName,
            'type_id' => 1,

        ]);

    }

    public function uploadFile(Request $request)
    {

    }


}
