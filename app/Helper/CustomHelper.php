<?php

namespace App\Helper;

use App\Models\GeneralSetting;

use DB;
use App\Models\Country;
use App\Models\State;

class CustomHelper
{
    public static function general(){
        $gen = GeneralSetting::first();
        return $gen;
    }

    public static function get_country($country_id){
        $country = Country::where('id',$country_id)->first();
        return $country;
    }

    public static function get_state($state_id){
        $state = State::where('id',$state_id)->first();
        return $state;
    }
}