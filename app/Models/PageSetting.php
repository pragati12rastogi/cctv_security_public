<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Translatable\HasTranslations;

class PageSetting extends Model
{
	
    
    protected $fillable=[
	
		'page_name','title','content','banner','meta_title','meta_keyword','meta_description'

	];
}
