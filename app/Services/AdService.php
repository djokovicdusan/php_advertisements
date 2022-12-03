<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\AdItem;
use App\Models\AdsAdItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdService
{

    public function storeComplexAds(Request $request)
    {
        $itemIds = $request->get('itemIds');
        $cycles = $request->get('cycles');
        $seconds = $request->get('seconds');


        list($sumOfDurations, $allDurationsInSeconds, $itemPositions, $itemCycles, $itemStartsAtSeconds) = $this->calculateComplexSumOfDurations($itemIds, $cycles, $seconds);


        DB::transaction(function () use ($itemStartsAtSeconds, $itemPositions, $itemIds, $itemCycles, $allDurationsInSeconds, $sumOfDurations, $request) {

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
        });

    }

    public function storeSimpleAds(Request $request)
    {
        $itemIds = $request->get('itemIds');
        $itemCycles = $request->get('cycles');

        list($sumOfDurations, $allDurationsInSeconds) = $this->calculateSimpleSumOfDurations($itemIds, $itemCycles);

        DB::transaction(function () use ($itemIds, $itemCycles, $allDurationsInSeconds, $sumOfDurations, $request) {

            $ad = Ad::create([
                'name' => $request->get('addName'),
                'start_time' => $request->get('addStart'),
                'end_time' => Carbon::parse($request->get('addStart'))->addSeconds($sumOfDurations),
            ]);

            foreach ($itemIds as $key => $itemId) {


                AdsAdItem::create([
                    'ad_item_id' => $itemId,
                    'ad_id' => $ad->id,
                    'startsFromSecond' => 0,
                    'duration_in_ad' => $allDurationsInSeconds[$key],
                    'number_of_cycles' => $itemCycles[$key],
                    'position' => $key

                ]);
            }
        });
    }

    public function calculateSimpleSumOfDurations(array $itemIds, array $itemCycles)
    {
        $sumOfDurations = 0;
        foreach ($itemIds as $key => $itemId) {
            $adItem = AdItem::find($itemId);
            $duration = $adItem->duration;
            $number_of_cycles = $itemCycles[$key];
            if ($adItem->type_id == 2) {
                $numberOfPhotos = count(Storage::disk('public')->allFiles('ads/slideshows/' . $adItem->file_name));
                $adsAdItemDuration = $duration * $number_of_cycles * $numberOfPhotos;
            } else {
                $adsAdItemDuration = $duration * $number_of_cycles;
            }
            $allDurationsInSeconds [] = $adsAdItemDuration;
            $sumOfDurations += $adsAdItemDuration;
        }

        return [$sumOfDurations, $allDurationsInSeconds];
    }

    public function calculateComplexSumOfDurations(array $itemIds, array $cycles, array $seconds)
    {
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
                }
            }
        }
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
                //if this is the last item
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

        return [$sumOfDurations, $allDurationsInSeconds, $itemPositions, $itemCycles, $itemStartsAtSeconds];
    }


    public function destroyAd(Ad $ad)
    {
        $adsAdItemsToDelete = $ad->adsAdItem();
        foreach ($adsAdItemsToDelete as $item) {
            $item->ads()->detach();
            $item->delete();
        }
        $ad->delete();
    }

    public function updateAd(Ad $ad, Request $request)
    {
        $secondsToAdd = Carbon::parse($ad->end_time)->diffInSeconds(Carbon::parse($ad->start_time));
        $start_time = $request->get('addStart');
        $end_time = Carbon::parse($request->get('addStart'))->addSeconds($secondsToAdd);
        $ad->start_time = $start_time;
        $ad->end_time = $end_time;
        $ad->update();
    }

    public function duplicateAd(Ad $ad, Request $request)
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
    }

}
