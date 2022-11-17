<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreAdRequest;
use App\Http\Requests\StoreComplexAdRequest;
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
        return view('admin/createSimpleAds', ['active' => 'ads', 'adItems' => $aditems]);
    }

    public function createComplexAds()
    {
        $aditems = AdItem::all();
        return view('admin/createComplexAds', ['adItems' => $aditems]);
    }

    public function items()
    {
        $aditems = AdItem::all();
//        return view('admin/ads/add', ['adItems' => $aditems]);
        return view('admin/itemads', ['active' => 'ads', 'adItems' => $aditems]);
    }

    public function store(StoreAdRequest $request)
    {
//        dd($request->validated());
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
            $allDurationsInSeconds [] = $adsAdItemDuration;

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
                'startsFromSecond' => 0,
                'duration_in_ad' => $allDurationsInSeconds [$key],
                'number_of_cycles' => $cycles[$key],
                'position' => $key

            ]);
        }
        return redirect('/ads');

    }

    public function storeComplexAds(StoreComplexAdRequest $request)
    {
//        dd($request->all());
        $itemIds = $request->get('itemIds');
        $cycles = $request->get('cycles');
        $seconds = $request->get('seconds');

        $sumOfDurations = 0;
        $itemIdCounter = 1;
        for ($i = 0; $i < 2 * count($itemIds) - 1; $i++) {

            if ($i % 2 == 0) {
                $itemPositions[] = $itemIds[0];
                $itemStartsAtSeconds[] = $seconds[$i / 2];
                $itemCycles[] = 1;
            } else {
                $itemPositions[] = $itemIds[$itemIdCounter];
                $itemCycles[] = $cycles[$itemIdCounter];
                $itemIdCounter += 1;
                if ($i != 0) {
                    $itemStartsAtSeconds[] = 0;
//                    $itemCycles[] = 1;
                }
            }
        }
//        dd($itemCycles);
//        $mainItemId = $itemIds[0];
        foreach ($itemPositions as $key => $itemId) {
//            dd($itemId);
            $adItem = AdItem::find($itemId);
            $number_of_cycles = $itemCycles[$key];
            $startsFromSecond = $itemStartsAtSeconds[$key];
            // if startsFrom is 0, calculate like in normal ads
            if ($startsFromSecond == 0) {
                if ($key == 0) {
                    $duration = $itemStartsAtSeconds[$key + 2];
                } else {
                    $duration = $adItem->duration;
                }
            } else {
                //if this is the last ite
                if ($key + 1 == count($itemPositions)) {
                    $duration = $adItem->duration - $startsFromSecond;
                } else {
                    $duration = $itemStartsAtSeconds[$key + 2] - $startsFromSecond;
                }
            }
            if ($adItem->type_id == 2) {
                $numberOfPhotos = count(Storage::disk('public')->allFiles('ads/slideshows/' . $adItem->file_name));
                $adsAdItemDuration = $duration * $number_of_cycles * $numberOfPhotos; // - startsFrom(Slecedeg) + startsFrom(njegov)
            } else {
                $adsAdItemDuration = $duration * $number_of_cycles; // - startsFrom(Slecedeg) + startsFrom(njegov)
            }
            $allDurationsInSeconds [] = $adsAdItemDuration;

            $sumOfDurations += $adsAdItemDuration;
        }
//        dd($allDurationsInSeconds);

        // if cycles[0] (main item) >1, loop that many times - 1 (leave first creation as it was) -> create n ads, next begins when previous ends

        $ad = Ad::create([
            'name' => $request->get('addName'),
            'start_time' => $request->get('addStart'),
            'end_time' => Carbon::parse($request->get('addStart'))->addSeconds($sumOfDurations),
        ]);


        foreach ($itemPositions as $key => $itemId) {


            AdsAdItem::create([
                'ad_item_id' => $itemId,
                'ad_id' => $ad->id,
                'startsFromSecond' => $itemStartsAtSeconds[$key],
                'number_of_cycles' => $itemCycles[$key],
                'duration_in_ad' => $allDurationsInSeconds [$key],
                'position' => $key

            ]);
        }
        return redirect('/ads');

    }

    public function carousel(Request $request)
    {
//        dd("asd");
//        $now = Carbon::now()->addHours(1);
        $now = Carbon::now("Europe/Belgrade");
//        dd($now);
        $ad = Ad::where('start_time', '<=', $now)->where('end_time', '>', $now)->first();

        if ($ad == null) {
            $ad = Ad::where('name', 'defaultAd')->first();
//            dd($ad);

            return view('admin/carousel', ['ad' => $ad, 'adsAdItem' => $ad->adsAdItem[0], 'adItem' => $ad->adsAdItem[0]->adItem,
                'refreshInterval' => $ad->adsAdItem[0]->adItem->duration, 'adItemStartTime' => 0,
                'refreshIntervalMilliSeconds' => $ad->adsAdItem[0]->adItem->duration * 1000,
                'adItemStartTimeMilliSeconds' => 0 * 1000, 'ads']);
        }
//        dd($ad->adsAdItem[0]->adItem);
//        dd($ad);
        $start_time = $ad->start_time;

        $sumOfSeconds = 0;
        $sumOfMilliSeconds = 0;
        $adsAdItemDurationCarousel = 0;
        $currentAdItem = null;
        $currentAdsAdItem = null;
        $numItems = count($ad->adsAdItem);
        $i = 0;
        $lastItem = false;
        $firstItem = true;
        foreach ($ad->adsAdItem as $key => $adsAdItem) {
            $adItem = $adsAdItem->adItem;
            $durationInAd = $adsAdItem->duration_in_ad;

            $currentItemStartTime = $sumOfSeconds;
            $currentItemStartTimeMilliSeconds = $sumOfMilliSeconds;
//            $sumOfSeconds += $adsAdItemDuration;
            $sumOfSeconds += $durationInAd;
            $sumOfMilliSeconds += ($durationInAd * 1000);
            //ako je poslednja reklama dodaj joj 2 sekunde

            if (++$i === $numItems) {
//                $sumOfSeconds += $adsAdItemDuration + 2;
                $lastItem = true;
            }
            if ($key != 0) {
                $firstItem = false;
            }

            $time = Carbon::parse($start_time)->addSeconds($sumOfSeconds);
            $timeMilliSeconds = Carbon::parse($start_time)->addMilliseconds($sumOfMilliSeconds);
            // cim suma sekunda prebaci now(sat) vrati taj ad item
            if ($now < $timeMilliSeconds) { // $now<$time
                //uhvati ovaj aditem
                $currentAdItem = $adItem;
                $currentAdsAdItem = $adsAdItem;


                $secondsGone = Carbon::parse($now)->diffInSeconds($start_time);
                $millisecondsGone = Carbon::parse($now)->diffInMilliseconds($start_time);
//                    dd($secondsGone);
                //fucking magic formula
//                $adsAdItemStartTime = ($secondsGone - $currentItemStartTime) % ($currentAdItem->duration);
                $adsAdItemStartTime = (($secondsGone - $currentItemStartTime) % ($currentAdsAdItem->duration_in_ad)) + $currentAdsAdItem->startsFromSecond;
                $adsAdItemStartTimeMilliSeconds = (($millisecondsGone - $currentItemStartTimeMilliSeconds) % ($currentAdsAdItem->duration_in_ad * 1000)) + $currentAdsAdItem->startsFromSecond * 1000;
                $adsAdItemDurationCarousel = $sumOfSeconds - $secondsGone;
                $adsAdItemDurationCarouselMilliSeconds = $sumOfMilliSeconds - $millisecondsGone;
//                    dd($adsAdItemStartTime);

                break;
            }
        }

//        dd($adItem);
        if ($lastItem) {
            $adsAdItemDurationCarousel += 2;
            $adsAdItemDurationCarouselMilliSeconds += 1000;
            if ($currentAdItem->type_id == 2) {
                $adsAdItemDurationCarousel += 1;
                $adsAdItemDurationCarouselMilliSeconds += 1000;
            }
            $adsAdItemStartTime -= 1.6;
            $adsAdItemStartTimeMilliSeconds -= 300;
        } else {

            if ($currentAdsAdItem->number_of_cycles > 1) {
                $adsAdItemDurationCarousel += (0.8 * $currentAdsAdItem->number_of_cycles);
            } else {
                $adsAdItemDurationCarousel += 1.2;
            }
            $adsAdItemDurationCarouselMilliSeconds += 300 * ($currentAdsAdItem->number_of_cycles);

            // remove this the moment you fix refresh interval on default ad;
            if ($firstItem) {
                $adsAdItemStartTime += 1.6;
                $adsAdItemStartTimeMilliSeconds += 500;
                //slideshow
//                if($currentAdItem->type_id == 2){
//                    $adsAdItemDurationCarousel -= 1.5;
//                }
            } else {
                $adsAdItemStartTime -= 1.6;
                $adsAdItemStartTimeMilliSeconds -= 300;
                //slideshow
                if ($currentAdItem->type_id == 2) {
                    $adsAdItemDurationCarousel += 1.5;
                    $adsAdItemStartTimeMilliSeconds += 300;
                }
            }


        }
//        dd($currentAdsAdItem);
        if ($request->ajax()) {
            return (['refreshInterval' => $adsAdItemDurationCarousel, 'adItemStartTime' => $adsAdItemStartTime]);
        }
        return view('admin/carousel', ['adItem' => $currentAdItem, 'adsAdItem' => $currentAdsAdItem, 'refreshInterval' => $adsAdItemDurationCarousel,
            'refreshIntervalMilliSeconds' => $adsAdItemDurationCarouselMilliSeconds, 'adItemStartTime' => $adsAdItemStartTime,
            'adItemStartTimeMilliSeconds' => $adsAdItemStartTimeMilliSeconds]);
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
        foreach ($adsAdItemsToDelete as $item) {
            $item->ads()->detach();
            $item->delete();
        }
        $ad->delete();

        Session::flash('success', 'You have successfully deleted the ad!');
        return redirect('/ads');
    }

    public function update(Ad $ad, Request $request)
    {
//        dd($request->get('addStart'));
        $secondsToAdd = Carbon::parse($ad->end_time)->diffInSeconds(Carbon::parse($ad->start_time));
//        dd(Carbon::parse($ad->start_time));
//        dd($secondsToAdd);
//        $ad->update($ad);
        $start_time = $request->get('addStart');
        $end_time = Carbon::parse($request->get('addStart'))->addSeconds($secondsToAdd);
        $ad->start_time = $start_time;
        $ad->end_time = $end_time;
        $ad->update();
        return redirect('/ads');
    }

    public function duplicate(Ad $ad, Request $request)
    {
        $adsAdItems = AdsAdItem::where('ad_id', $ad->id)->get();
        $secondsToAdd = Carbon::parse($ad->end_time)->diffInSeconds(Carbon::parse($ad->start_time));
        $start_time = $request->get('addStart');
        $end_time = Carbon::parse($request->get('addStart'))->addSeconds($secondsToAdd);
        $duplicatedAd = Ad::create([
            'name' => $ad->name,
            'start_time' => $start_time,
            'end_time' => $end_time
        ]);

        foreach ($adsAdItems as $adsAdItem) {
            AdsAdItem::create([
                'ad_item_id' => $adsAdItem->ad_item_id,
                'ad_id' => $duplicatedAd->id,
                'number_of_cycles' => $adsAdItem->number_of_cycles,
                'startsFromSecond' => $adsAdItem->startsFromSecond,
                'duration_in_ad' => $adsAdItem->duration_in_ad,
                'position' => $adsAdItem->position
            ]);
        }

        return redirect('/ads');
    }

}
