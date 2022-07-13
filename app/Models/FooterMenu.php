<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_type','category_ids','page_ids','url','title','widget_name'
    ];
    protected $casts = ['category_ids' => 'array','page_ids' => 'array',"title" => "array", "url" => "array"];

}
