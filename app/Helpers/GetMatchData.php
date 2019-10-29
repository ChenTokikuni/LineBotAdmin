<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class GetMatchData
{
	public static function getMatchBotId($bot_id)
	{
		$data = [];
		$rows = \App\Models\BotSet::all();
		foreach ($rows as $row) {
			$data[$row->id] = $row->name;
		}
		if(isset($data[$bot_id]) && $data[$bot_id] !=''){
			$match_bot_id = $data[$bot_id];
		}else if(isset($data[$bot_id]) && $data[$bot_id] ==''){
			$match_bot_id = '未設定名稱'.$bot_id;
		}else{
			$match_bot_id = '查無對應 Line Bot';
		}
		return $match_bot_id;
	}
	public static function getMatchUserId($user_id)
	{
		$data = [];
		$rows = \App\Models\FriendsList::all();
		foreach ($rows as $row) {
			$data[$row->id] = $row->user_id;
		}
		if(isset($data[$user_id])){
			$match_user_id = $data[$user_id];
		}else{
			$match_user_id = '查無對應 Line User Id';
		}
		return $match_user_id;
	}
	public static function getMatchUserIdToName($user_id)
	{
		$data = [];
		$rows = \App\Models\FriendsList::all();
		foreach ($rows as $row) {
			$data[$row->id]['name'] = $row->name;
			$data[$row->id]['user_id'] = $row->user_id;
		}
		if(isset($data[$user_id]['name']) && $data[$user_id]['name'] != ''){
			$match_name = $data[$user_id]['name'];
		}else if(isset($data[$user_id]['name']) && $data[$user_id]['name'] == ''){
			$match_name = $data[$user_id]['user_id'].'(名稱未設定)';
		}else{
			$match_name = '查無對應 Line User';
		}
		return $match_name;
	}
	public static function getMatchUserIdToNameArray($user_id_array)
	{
		$data = [];
		
		if(is_null($user_id_array) || $user_id_array == '' || $user_id_array == '[null]' || empty($user_id_array)){
			return'';
		}else{
			$rows = \App\Models\FriendsList::all();
			foreach($rows as $k=>$v){
				$data[$v->id] = $v->name;
			}
			foreach($user_id_array as $k=>$v){
				if($data[$v] == ''){
					$match_name[$k]='未設定名稱'.$v;
				}else{
					$match_name[$k]=$data[$v];
				}
				
			}
			return $match_name;
		}
	}
}
