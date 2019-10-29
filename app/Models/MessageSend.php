<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageSend extends Model
{
	protected $table = 'line_message_send';
	protected $primaryKey = 'id';
	protected $casts = [
		'user_id' => 'json',
	];
}
