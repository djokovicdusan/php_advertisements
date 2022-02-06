<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(){
        $result1 = DB::select(DB::raw("SELECT count(*) as file_count, ad_items.file_name as file_name FROM ads_ad_items join ad_items on ads_ad_items.ad_item_id=ad_items.id group by ads_ad_items.ad_item_id, ad_items.file_name"));
        $chartData1 = "";
        foreach($result1 as $list){
            $chartData1.="['".$list->file_name."', ".$list->file_count."],";
        }
        $arr['chartData1']=rtrim($chartData1,",");

        $result2 = DB::select(DB::raw("SELECT count(*) as type_count, ad_types.name as type_name FROM ad_items join ad_types on ad_items.type_id=ad_types.id GROUP BY ad_types.name, ad_items.type_id"));
        $chartData2 = "";
        foreach($result2 as $list){
            $chartData2.="['".$list->type_name."', ".$list->type_count."],";
        }
        $arr['chartData2']=rtrim($chartData2,",");
        
        return view('components/statistics', $arr);
    }
}
