<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelledInvoice extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','invoice_id','user_id','comment','other_reason','pay_method','amount','is_refunded','transaction_id','txn_fee'];

    public function order(){
        return $this->belongsTo('App\Models\Order','order_id','id');
    }

    public function invoice(){
        return $this->belongsTo('App\Models\Invoice','invoice_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    
}
