<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Translatable\HasTranslations;

class SocialMediaSetting extends Model
{
	
    
    protected $fillable=[
	
		'name','path'

	];
}
