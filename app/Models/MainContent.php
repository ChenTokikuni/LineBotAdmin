<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainContent extends Model
{
	protected $table = 'main_content';
	protected $primaryKey = 'id';
	protected $fillable = [
		'title_id','is_open','place','content'
    ];
}
