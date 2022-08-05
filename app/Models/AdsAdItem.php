<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdsAdItem extends Model
{
    //
    protected $fillable = ['ad_item_id', 'ad_id', 'number_of_cycles','startsFromSecond','duration_in_ad', 'position'];
    protected $with = ['adItem'];
    protected $appends = ['duration'];

    public function adItem(){
        return $this->hasOne('App\Models\AdItem', 'id', 'ad_item_id');
    }

    public function ads(){
        return $this->hasMany('App\Models\Ad', 'id', 'ad_id');
    }
    public function getDurationAttribute(){
        $duration = 0;
        foreach ($this->adItem() as $item){
            $duration +=$item->duration;

        }
        return $duration;

    }


}
