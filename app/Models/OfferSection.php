<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferSection extends Model
{
    use HasFactory;

    protected $fillable=[
        'photo','tag','title','link_type','category_id','product_id','url'
    ];

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    
}
