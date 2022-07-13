<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','user_id','product_id','qty','old_amount','actual_amount','total_amount','tax_amount','order_product_status'];

    public function order(){
        return $this->belongsTo('App\Models\Order','order_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id','id')->withTrashed();
    }
}
