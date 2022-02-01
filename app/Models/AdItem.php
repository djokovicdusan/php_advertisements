<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AdItem extends Model
{
    protected $fillable = ['type_id','file_name','duration'];
    //

    protected $appends = ['files'];
//    protected $with = ['adsAdItem'];

    public function type()
    {
        return $this->hasOne('App\Models\AdType', 'id', 'type_id');
    }

    public function adsAdItem(){
        return $this->hasMany('App\Models\AdsAdItem','ad_item_id','id');
    }

    public function getFilesAttribute(){
        return Storage::disk('public')->allFiles('ads/slideshows/'.$this->file_name);
    }
}
