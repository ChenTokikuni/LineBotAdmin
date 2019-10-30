<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;

class ActiveSelect extends Action
{
	protected $data;

	public function __construct($data = null)
	{
		if ($data) {
			$this->data = $data;
		}

		parent::__construct();
	}
    public function handle(Request $request)
    {
        // $request ...

        //return $this->response()->success('Success message...')->refresh();
    }

    public function html()
    {
        return view('admin/LevelSelect', ['data' => $this->data]);
    }
}