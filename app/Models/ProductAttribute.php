<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $casts = ['category_ids' => 'array'];

    protected $fillable=[
		'title','category_ids','attr_type'
    ]; 

    public function attribute_value(){
      return $this->hasMany('App\Models\ProductAttributeValue','attribute_id');
    }
}
