<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    use HasFactory;

    protected $fillable=[
		'product_id','image','default_image'
	]; 

    public function product(){
    	return $this->belongsTo('App\Models\Product','product_id','id');
    }
}
