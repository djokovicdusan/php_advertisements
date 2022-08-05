<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsAdItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('ads_ad_items', function (Blueprint $table){

            $table->increments('id');
            $table->integer('ad_item_id');
            $table->integer('ad_id');
            $table->integer('number_of_cycles');
            $table->integer('position');
            $table->integer('startsFromSecond');
            $table->integer('duration_in_ad');
            $table->timestamps();
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
