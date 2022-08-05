<?php

namespace App\Http\Controllers;

use App\Models\AdItem;

class SlideshowPreviewController extends \Illuminate\Routing\Controller
{

    public function index(AdItem $adItem){
        return view("admin/slideshowPreview", ['adItem'=> $adItem,'refreshInterval' => 60]);
    }

}
