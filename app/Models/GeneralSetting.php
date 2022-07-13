<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Translatable\HasTranslations;

class GeneralSetting extends Model
{
	
    
    protected $fillable=[
	
		'project_name','email','title','logo','favicon','copyright','address','email','phone','show_map','map_code','service_section','offer_section','meta_title','meta_keyword','meta_description','state_id','paypal_active','razorpay_active','stripe_active','watsapp_no'

	];


	public function state(){
		return $this->belongsTo('App\Models\State','state_id','id');
	}
}
