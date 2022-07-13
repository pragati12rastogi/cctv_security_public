<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    use HasFactory;

    protected $fillable=[
		  'category_id','sub_category_id','name','image','description','status'
	  ];

    public function subcategory(){
    	return $this->belongsTo('App\Models\SubCategory','sub_category_id','id');
    }

    public function category(){
    	return $this->belongsTo(Category::class,'category_id');
    }

    public function products()
    {
    	return $this->hasMany(Product::class,'child_category_id');
    }
}
