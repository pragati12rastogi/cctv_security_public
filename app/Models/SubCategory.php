<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable=[
		  'category_id','name','image','description','status'
	  ];

    public function category(){
    	return $this->belongsTo('App\Models\Category','category_id','id');
    }

    public function childcategory(){
    	return $this->hasMany('App\Models\ChildCategory','sub_category_id','id');
    }

    public function products()
    {
    	return $this->hasMany('App\Models\Product','sub_category_id');
    }
}
