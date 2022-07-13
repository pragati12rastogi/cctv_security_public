<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','first_name','last_name','email','phone','address','country_id','state_id','suit_no','city','zipcode'];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function country(){
        return $this->belongsTo('App\Models\Country','country_id','id');
    }

    public function state(){
        return $this->belongsTo('App\Models\State','state_id','id');
    }
}
