<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    use HasFactory;

    protected $fillable = ['bankname','account_no','account_name','ifsc','user_id'];

    protected $casts = [
        'bank_details' => 'array'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
