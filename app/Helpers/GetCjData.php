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
	public static function GetLevelViewData()
	{
		$data = [];
		$rows = DB::table('main_content')->count('id');
		$data[0]['name'] = '所有优惠';
		$data[0]['title_id'] = '';
		$data[0]['level_count'] = $rows;
		$rows = DB::table('main_content')->select('title_id', DB::raw('count( title_id) as level_count'))->groupBy('title_id')->get()->toArray();
		foreach ($rows as $k=>$v) {
			$data[$k+1]['name'] = GetCjData::GetMatchLevelName($v->title_id);
			$data[$k+1]['title_id'] = $v->title_id;
			$data[$k+1]['level_count'] = $v->level_count;
		}
		
		return $data;
	}
}
