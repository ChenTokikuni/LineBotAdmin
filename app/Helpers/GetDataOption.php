<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class GetDataOption
{
	public static function getBotIdOption()
	{
		$options = [];
		$rows = \App\Models\BotSet::all();
		foreach ($rows as $row) {
			if($row->name ==''){
				$options[$row->id] = '未設定名稱'.$row->id;
			}else{
				$options[$row->id] = $row->name;
			}
		}
		return $options;
	}
	public static function getUserIdOption()
	{
		$options = [];
		$rows = \App\Models\FriendsList::all();
		foreach ($rows as $row) {
			if($row->name ==''){
				$options[$row->id] = '未設定名稱'.$row->id;
			}else{
				$options[$row->id] = $row->name;
			}
		}
		return $options;
	}
}
