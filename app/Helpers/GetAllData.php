<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class GetAllData
{
	public static function getLineBotData($bot_id)
	{
		$data = [];
		$rows = \App\Models\BotSet::all();
		foreach ($rows as $k => $v) {
			if( $v->id == $bot_id){
				$data = $rows[$k];
			}
			break;
		}
		
		return $data;
	}
	
	public static function getMessageData($id)
	{
		$data = [];
		$rows = \App\Models\MessageSend::all();
		foreach ($rows as $k => $v) {
			if( $v->id == $id){
				$data = $rows[$k];
			}
			break;
		}
		
		return $data;
	}
}
