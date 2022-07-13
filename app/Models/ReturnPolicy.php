<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','days','description'
    ];


    public function products(){
        return $this->hasMany('App\Models\Product','return_policy_id');
    }
}
