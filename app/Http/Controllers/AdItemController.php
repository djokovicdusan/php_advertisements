<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdItemController extends Controller{
    public function index(){
        $aditems = AdItem::all();
        return view('admin/ads/add', ['adItems' => $aditems]);
    }


    public function store(Request $request){
        $typeId = $request->get('type_id');


        if($typeId == 1){
            //        dd($request->all());

            $duration = $request->get('duration');
            $file = $request->file('videoFile');
            $fileName = $request->get('videoName');



            $fullFileName = $fileName. "." . $file->getClientOriginalExtension();
            $file->move('assets/ads/video', $fullFileName);


            AdItem::create([
                'duration'=>$duration,
                'file_name'=>$fullFileName,
                'type_id'=>$typeId,

            ]);

            return redirect()->back();
        }
        else if($typeId == 2){
//             dd($request->all());
            $images = $request->file('images');
//            dd($images);
            $name = $request->get('slideshowName');
//            dd($name);
            $duration = $request->get('duration');
//            $key = 1;


            for ($i=0; $i<count($images); $i++){
//                var_dump($images[$i]);
                $fullFileName = '0'.$i . '.' . $images[$i]->getClientOriginalExtension();

                Storage::disk('public')->putFileAs('ads/slideshows/'.$name, $images[$i], $fullFileName);


            }
            AdItem::create([
                'duration'=>$duration,
                'file_name'=>$name,
                'type_id'=>$typeId,

            ]);

            return redirect()->back();
        }


    }


}
