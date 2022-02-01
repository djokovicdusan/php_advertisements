<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['start_time','end_time','name'];

    protected $with = ['adsAdItem'];

//    public function get
    public function adsAdItem()
    {
        return $this->hasMany('App\Models\AdsAdItem', 'ad_id');
    }

}
