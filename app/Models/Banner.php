<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable =[
        'login_banner','register_banner','forget_password_banner','category_banner','product_banner','cart_banner','wishlist_banner','user_dasboard_banner'
    ];
}
