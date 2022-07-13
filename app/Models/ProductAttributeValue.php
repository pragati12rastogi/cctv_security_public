<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    use HasFactory;

    protected $fillable=[
		'attr_key','value','attribute_id'
    ];

    public function attribute(){
    	return $this->belongsTo('App\Models\ProductAttribute','attribute_id','id');
    }
}
