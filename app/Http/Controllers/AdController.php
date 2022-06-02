<?php

namespace App\Http\Controllers;


use App\Models\Ad;
use App\Models\AdItem;
use App\Models\AdsAdItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{

    public function index()
    {
        $ads = Ad::orderBy('start_time', 'desc')->get();
//        dd('test');

        return view('admin/ads', ['ads' => $ads]);
    }

    public function adItem()
    {
        return view('admin/adItem');
    }

    public function allAds()
    {
        return view('admin/allads', ['active' => 'ads']);
    }

    public function addAds()
    {
        $aditems = AdItem::all();
        return view('admin/addads', ['active' => 'ads', 'adItems' => $aditems]);
    }

    public function items()
    {
        $aditems = AdItem::all();
//        return view('admin/ads/add', ['adItems' => $aditems]);
        return view('admin/itemads', ['active' => 'ads', 'adItems' => $aditems]);
    }

    public function store(Request $request)
    {
        $itemIds = $request->get('itemIds');
        $cycles = $request->get('cycles');
//        dd($request->all());
        // creating ad
        $sumOfDurations = 0;
        foreach ($itemIds as $key => $itemId) {
//            dd($itemId);
            $adItem = AdItem::find($itemId);
            $duration = $adItem->duration;
            $number_of_cycles = $cycles[$key];
            if ($adItem->type_id == 2) {
                $numberOfPhotos = count(Storage::disk('public')->allFiles('ads/slideshows/' . $adItem->file_name));
                $adsAdItemDuration = $duration * $number_of_cycles * $numberOfPhotos;
            } else {
                $adsAdItemDuration = $duration * $number_of_cycles;
            }

            //$start_time=Ad::find($)


            $sumOfDurations += $adsAdItemDuration;
        }
//        dd($sumOfDurations);

        $ad = Ad::create([
            'name' => $request->get('addName'),
            'start_time' => $request->get('addStart'),
            'end_time' => Carbon::parse($request->get('addStart'))->addSeconds($sumOfDurations),
        ]);


        // creating ad item
//        dd($request->all());

//        dd($itemIds[0], $cycles);


        foreach ($itemIds as $key => $itemId) {


            AdsAdItem::create([
                'ad_item_id' => $itemId,
                'ad_id' => $ad->id,
                'number_of_cycles' => $cycles[$key],
                'position' => $key

            ]);
        }
        return redirect('/ads');

    }

    public function carousel()
    {
        $now = Carbon::now()->addHour()->addHour();
//        $now = Carbon::now()->addHour();
//        dd($now);
        $ad = Ad::where('start_time', '<', $now)->where('end_time', '>', $now)->first();

        if ($ad == null) {
            $ad = Ad::where('name', 'defaultAd')->first();

            return view('admin/carousel', ['ad' => $ad, 'adItem' => $ad->adsAdItem[0]->adItem, 'refreshInterval' => $ad->adsAdItem[0]->adItem->duration, 'adItemStartTime' => 0]);
        }
//        dd($ad->adsAdItem[0]->adItem);
//        dd($ad);
        $start_time = $ad->start_time;

        $sumOfSeconds = 0;
        $adsAdItemDurationCarousel = 0;
        $currentAdItem = null;

        foreach ($ad->adsAdItem as $adsAdItem) {

            $adItem = $adsAdItem->adItem;
            $duration = $adItem->duration;
            $noOfCycles = $adsAdItem->number_of_cycles;

            //calculating of duration
            if ($adItem->type_id == 2) {
                $numberOfPhotos = count(Storage::disk('public')->allFiles('ads/slideshows/' . $adItem->file_name));
                $adsAdItemDuration = $duration * $noOfCycles * $numberOfPhotos;
            } else {
                $adsAdItemDuration = $duration * $noOfCycles;
            }

            $currentItemStartTime = $sumOfSeconds;
            $sumOfSeconds += $adsAdItemDuration;

            $time = Carbon::parse($start_time)->addSeconds($sumOfSeconds);
            // cim suma sekunda prebaci now(sat) vrati taj ad item
            if ($now < $time) {
                //uhvati ovaj aditem
                $currentAdItem = $adItem;

                $secondsGone = Carbon::parse($now)->diffInSeconds($start_time);
//                    dd($secondsGone);
                //fucking magic formula
                $adsAdItemStartTime = ($secondsGone - $currentItemStartTime) % ($currentAdItem->duration);
                $adsAdItemDurationCarousel = $sumOfSeconds - $secondsGone;
//                    dd($adsAdItemStartTime);

                break;
            }

        }
//        dd($adItem);
        return view('admin/carousel', ['adItem' => $currentAdItem, 'refreshInterval' => $adsAdItemDurationCarousel, 'adItemStartTime' => $adsAdItemStartTime]);
    }



    public function getAd(Request $request)
    {
//        dd($request);
        $startTime = Carbon::parse($request->get('start_time'));
//        dd($startTime);
        $ad = Ad::where('start_time', '=', $startTime)->first();
//        dd($ad);
//        dd($startTime);

        return view('admin/adDetails', ['ad' => $ad]);

    }
    public function destroy(Ad $ad)
    {
//        dd($ad);
        $adsAdItemsToDelete = $ad->adsAdItem();
        foreach ($adsAdItemsToDelete as $item){
           $item->ads()->detach();
           $item->delete();
        }
        $ad->delete();

        Session::flash('success', 'You have successfully deleted the ad!');
        return redirect('/ads');
    }
    public function update(Ad $ad,Request $request)
    {
//        dd($request->get('addStart'));
        $secondsToAdd = Carbon::parse($ad->end_time)->diffInSeconds(Carbon::parse($ad->start_time));
//        dd(Carbon::parse($ad->start_time));
//        dd($secondsToAdd);
//        $ad->update($ad);
        $start_time = $request->get('addStart');
        $end_time = Carbon::parse($request->get('addStart'))->addSeconds($secondsToAdd);
        $ad->start_time = $start_time;
        $ad->end_time= $end_time;
        $ad->update();
        return redirect('/ads');
    }

}
