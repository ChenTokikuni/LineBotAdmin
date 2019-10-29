<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class SendMessage extends RowAction
{
    public $name = '發送';

    public function handle(Model $model)
    {
		$res = \App\Managers\Bot::sendmessage($model->id);
		if($res =='success'){
			return $this->response()->success('發送成功')->refresh();
		}else{
			return $this->response()->error('發送失敗')->refresh();
		}	
    }
}