<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Translatable\HasTranslations;

class BankDetail extends Model
{

  	protected $fillable=[
		'bank name','branch name','ifsc','account_no','account_name','status'
	];
   
}
