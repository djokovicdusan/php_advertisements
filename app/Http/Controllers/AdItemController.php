<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdItemRequest;
use App\Models\Ad;
use App\Models\AdItem;
use App\Services\AdItemService;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdItemController extends Controller
{
    private $adItemService;

    public function __construct(AdItemService $service)
    {
        $this->adItemService = $service;
    }

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
        $typeId = $request->type_id;

        if ($typeId == 1) {
            $this->adItemService->storeVideo($request);
        } else if ($typeId == 2) {
            $this->adItemService->storeSlideshow($request);

        }
        return redirect()->back();

    }


}
