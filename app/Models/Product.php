<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable=[
		'name','category_id','sub_category_id','child_category_id','description','specification','price','old_price','qty','datasheet_upload','user_manual_upload','tags','tax','cash_on_delivery','return_available','cancel_available','status','is_feature','return_policy_id'
	]; 

    
    public function category(){
    	return $this->belongsTo('App\Models\Category','category_id','id');
    }

    public function subcategory(){
    	return $this->belongsTo('App\Models\SubCategory','sub_category_id','id');
    }

    public function childcategory(){
    	return $this->belongsTo('App\Models\ChildCategory','child_category_id','id');
    }

    public function photos(){
        return $this->hasMany('App\Models\ProductPhoto','product_id');
    }

    public function varients_attribute(){
        return $this->hasMany('App\Models\ProductVariantsDetail','product_id');
    }

    public function return_policy(){
        return $this->belongsTo('App\Models\ReturnPolicy','return_policy_id','id');
    }

    public function reviews(){
        return $this->hasMany('App\Models\Review','product_id');
    }

    public function invoices(){
        return $this->hasMany('App\Models\Invoice','product_id');
    }
}
