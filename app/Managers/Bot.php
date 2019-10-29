<?php

namespace App\Managers;

use App\Helpers\GetAllData;
use App\Helpers\GetMatchData;
use App\Helpers\ApiLib;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Bot extends ManagerBase
{

	protected $settings;

	// 
	public static function sendmessage($id)
	{
		// 檢查
		$message_data = GetAllData::getMessageData($id);
		if($message_data ==''){
			throw new \Exception('查無設定訊息');
		}

		//組資料
		$bot_data = GetAllData::getLineBotData($message_data->bot_id);
		$user = [];
		foreach($message_data->user_id as $k=>$v){
			$user[$k]=GetMatchData::getMatchUserId($v);
		}
		if(in_array('查無對應 Line User Id',$user)){
			throw new \Exception('發送對象有查無對應 Line User Id 請重新設定再進行發送');
		}

		$form_params = [
			'to' => $user,
			'messages' => [
			(object)array(
				'type' => 'text',
				'text' => $message_data->message)
			]
		];/* print_r($form_params);exit; */
		try {
			// 發送 line api 
			$client = new \GuzzleHttp\Client();
			$response = $client->request('POST' , 'https://api.line.me/v2/bot/message/multicast', [
				'headers' => [
					'Authorization' => 'Bearer '.$bot_data->access_token,
					'Accept' => 'application/json',
				],
				'json' => $form_params,
			]);

			// 檢查
			if ($response->getStatusCode() != 200) {
				throw new \Exception('GuzzleHttp request failed. (' . $response->getStatusCode() . ')', 104);
			}

			$result = json_decode($response->getBody(), true);
			ApiLib::writeLog(['req' => $form_params, 'res' => $result], public_path('storage/logs/' . date('Ymd') . '-multicast_api.log'));
			if(!$result){
				DB::table('line_message_send')->where('id', '=',$id)->update([
					'response' => '發送成功',
					'updated_at' => date('Y-m-d H:i:s')
				]);
			}else{
				DB::table('line_message_send')->where('id', '=',$id)->update([
					'response' => $result,
					'updated_at' => date('Y-m-d H:i:s')
				]);
				return 'error';
			}
			return 'success';

		} catch (\GuzzleHttp\Exception\ConnectException $e) {
			throw $e;
		} catch (\Exception $e) {
			DB::table('line_message_send')->where('id', '=',$id)->update(['response' => $e->getMessage(),'updated_at' => date('Y-m-d H:i:s')]);
			throw $e;
		}

	}

}
