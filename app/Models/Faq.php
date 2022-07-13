<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{

  	protected $fillable=[
		'que','ans','status'
	];
   
}
