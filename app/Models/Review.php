<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','customer_id','review','rating'];

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

    public function customer(){
        return $this->belongsTo('App\Models\User','customer_id','id');
    }
}
