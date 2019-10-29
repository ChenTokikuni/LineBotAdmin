<?php

namespace App\Observer;

use App\Models\MainTitle;
use Illuminate\Support\Facades\DB;

class MainTitleObserver
{
	// Handle the User "creating" event.
	public function creating(MainTitle $model)
	{
	}

	// Handle the User "created" event.
	public function created(MainTitle $model)
	{
	}

	// Handle the User "updating" event.
	public function updating(MainTitle $model)
	{
	}

	// Handle the User "updated" event.
	public function updated(MainTitle $model)
	{
	}

	// Handle the User "saving" event.
	public function saving(MainTitle $model)
	{
	}

	// Handle the User "saved" event.
	public function saved(MainTitle $model)
	{
	}

	// Handle the User "deleting" event.
	public function deleting(MainTitle $model)
	{
		$rows = DB::table('main_content')->select('*')->where('title_id','=',$model->id)->exists();
		if($rows){
			DB::table('main_content')->where('title_id','=',$model->id)->update(['title_id'=>'0']);
		}
	}

	// Handle the User "deleted" event.
	public function deleted(MainTitle $model)
	{
	}

}
