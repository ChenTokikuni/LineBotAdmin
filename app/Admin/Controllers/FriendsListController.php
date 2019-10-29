<?php

namespace App\Admin\Controllers;

use App\Models\FriendsList;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;


class FriendsListController extends Controller
{
	
   use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('好友')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('好友')
            ->description('检视')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('好友')
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('好友')
            ->description('新建')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FriendsList);

		// 關閉選擇器
		$grid->disableRowSelector();
		$grid->disableExport();
		$grid->disableColumnSelector();
		$grid->disableFilter();
		//$grid->disableCreateButton();
		//$grid->disableActions();
		//自訂
		$grid->filter(function($filter){
			$filter->disableIdFilter();
				// 在这里添加字段过滤器
			/*
				$filter->group('play_count', '可游玩次数', function ($group) {
					$group->equal('等于');
					$group->notEqual('不等于');
					$group->gt('大于');
					$group->lt('小于');
					$group->nlt('大于等于');
					$group->ngt('小于等于');
				});
			*/
		});
		// 關閉搜尋
		//$grid->disableFilter(); 
		$grid->actions(function ($actions) {
			
			//$actions->disableEdit();
			
			$actions->disableView();
			
			//$actions->disableDelete();
			
		});
		/*
		$grid->tools(function ($tools) {
			$switch = $this->nowSwitch();
			$tools->append(new \App\Admin\Extensions\Tools\UserGender(admin_base_path('notice/check_switch'),$switch));
		});*/
		$grid->column('name', '名稱')->display(function ($name) {
			if($name==''){
				return '未設定名稱'.$this->id;
			}
			return $name;
		});
		$grid->column('user_id', 'Line User Id');
		
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(FriendsList::findOrFail($id));

        $show->setting_id('Setting id');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FriendsList);

		$form->tools(function (Form\Tools $tools) {
			$tools->disableView();
			$tools->disableDelete();
			/*
			$tools->disableList();
			$tools->disableBackButton();
			$tools->disableListButton();
			*/
		});
		
		$form->footer(function ($footer) {

			// 去掉`重置`按钮
			//$footer->disableReset();

			// 去掉`提交`按钮
			//$footer->disableSubmit();

			// 去掉`查看`checkbox
			$footer->disableViewCheck();

			// 去掉`继续编辑`checkbox
			$footer->disableEditingCheck();

			// 去掉`继续创建`checkbox
			$footer->disableCreatingCheck();

		});
		$form->text('name', '名稱');
		$form->text('user_id', 'LineUserId')->required()->rules(function ($form) {
			//all user_id
			$all = [];
			$rows = \App\Models\FriendsList::all();
			foreach ($rows as $row) {
				$all[$row->id] = $row->user_id;	
			}
			if ($id = $form->model()->id) {
				return "unique:line_friends_list,user_id,$id,id";
			}
			if (!$id = $form->model()->id) {
				return 'unique:line_friends_list,user_id';
			}
		},['警告:已有相同UserId，请重新设定']);
        return $form;
    }
}

