<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected  $fillable = ['order_id','user_id','shipping_address','billing_address','payment_method','payment_receive','transaction_id','order_total','purchase_proof','special_note'];

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice', 'order_id','id');
    }
}
