<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ApiLib;

class LineReplyController extends Controller
{

	public function reply(Request $request)
	{
		try {
			if($query = $request->getContent()){
				ApiLib::writeLog(['req' => '', 'res' => $query], storage_path('logs/' . date('Ymd') . '-reply_api.log'));
			}
			$query = json_decode($query);
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}

}
