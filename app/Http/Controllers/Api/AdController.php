<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdController extends \App\Http\Controllers\Controller
{
    public function carouselClient()
    {
        $now = Carbon::now()->addHour()->addHour();

        $ad = Ad::where('start_time', '<', $now)->where('end_time', '>', $now)->first();

        if ($ad == null) {
            $ad = Ad::where('name', 'defaultAd')->first();
            $adItem = $ad->adsAdItem[0]->adItem;
            $refreshInterval = $ad->adsAdItem[0]->adItem->duration;
            $adItemStartTime = 0;

            return response()->json(compact('adItem','refreshInterval','adItemStartTime') ,200 );
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
        $refreshInterval = $adsAdItemDurationCarousel;
        $adItemStartTime = $adsAdItemStartTime;
        return response()->json(compact('adItem','refreshInterval','adItemStartTime') ,200 );

    }
    public function index(){
        $ads = Ad::orderBy('start_time', 'desc')->get();
//        dd('test');
        return response()->json(compact('ads') ,200 );

    }

}
