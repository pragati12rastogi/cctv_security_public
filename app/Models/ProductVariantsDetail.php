<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantsDetail extends Model
{
    use HasFactory;

    protected $fillable=[
		'product_id','attribute_id','attribute_value_id','attribute_value'
    ]; 

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

    public function attribute(){
        return $this->belongsTo('App\Models\ProductAttribute','attribute_id','id');
    }

    public function attributeValue(){
        return $this->belongsTo('App\Models\ProductAttributeValue','attribute_value_id','id');
    }
}
