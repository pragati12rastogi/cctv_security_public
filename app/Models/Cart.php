<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['qty','user_id','product_id','old_amount','actual_price','tax'];
    
    public function product(){
        return $this->belongsTo('App\Models\Product','product_id','id')->withTrashed();
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
