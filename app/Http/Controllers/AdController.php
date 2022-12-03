<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreAdRequest;
use App\Http\Requests\StoreComplexAdRequest;
use App\Models\Ad;
use App\Models\AdItem;
use App\Models\AdsAdItem;
use App\Services\AdService;
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

    public function store(StoreAdRequest $request, AdService $adService)
    {
        $adService->storeSimpleAds($request);
        return redirect('/ads');

    }

    public function storeComplexAds(StoreComplexAdRequest $request, AdService $adService)
    {
        $adService->storeComplexAds($request);
        return redirect('/ads');

    }

    public function carousel(Request $request)
    {
//        dd("asd");
        $now = Carbon::now()->addHours(1);
//        $now = Carbon::now("Europe/Belgrade");
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
        $startTime = Carbon::parse($request->get('start_time'));
        $ad = Ad::where('start_time', '=', $startTime)->first();

        return view('admin/adDetails', ['ad' => $ad]);

    }

    public function destroy(Ad $ad, AdService $adService)
    {
        $adService->destroyAd($ad);
        return redirect('/ads');
    }

    public function update(Ad $ad, Request $request, AdService $adService)
    {
        $adService->updateAd($ad, $request);
        return redirect('/ads');
    }

    public function duplicate(Ad $ad, Request $request, AdService $adService)
    {
        $adService->duplicateAd($ad, $request);
        return redirect('/ads');
    }

}
