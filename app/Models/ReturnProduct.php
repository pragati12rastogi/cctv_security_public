<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnProduct extends Model
{
    use HasFactory;

    protected $fillable = ['pay_mode','user_id','invoice_id','order_id','qty','amount','txn_id','txn_fee','pickup_location','reason','status','additional_comment','bank_details'];

    protected $casts = [
    	'pickup_location' => 'array',
        'bank_details' => 'array'
    ];


    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice','invoice_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id','id');
    }
}
