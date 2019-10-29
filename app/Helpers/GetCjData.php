<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class GetCjData
{

	public static function GetLevelOptions()
	{
		$options = [];
		$options[0] = '不选择层级'; 
		$rows = \App\Models\MainTitle::all();
		
		foreach ($rows as $row) {
			$options[$row->id] = $row->name;
		}
		return $options;
	}
	public static function GetMatchLevelName($id)
	{
		$match_name = '查无对应层级ID: '.$id;
		$rows = \App\Models\MainTitle::all();

		foreach ($rows as $row) {
			$level_name[$row->id] = $row->name;
		}
		$level_name[0] = '不选择层级';
		if(isset($level_name[$id])){
			$match_name = $level_name[$id];
		}
		
		return $match_name;
	}
}
