<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable=[
		'title','link_by','cat_type','cat_id','page_id','url','linked_parent','status'
	]; 

    protected $casts = ['linked_parent' => 'array','page_id'=>'array'];

    
}
