<?php

namespace App\Admin\Controllers;

use App\Models\MainContent;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

use App\Helpers\GetCjData;

class MainContentController extends Controller
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
            ->header('优惠')
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
            ->header('优惠')
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
            ->header('优惠')
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
            ->header('优惠')
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
        $grid = new Grid(new MainContent);

		// 關閉選擇器
		$grid->disableRowSelector();
		$grid->disableExport();
		$grid->disableColumnSelector();
		//$grid->disableFilter();
		//$grid->disableCreateButton();
		//$grid->disableActions();
		//自訂
		$grid->filter(function($filter){
			$filter->disableIdFilter();
				// 在这里添加字段过滤器
			$filter->equal('title_id','层级')->select(GetCjData::GetLevelOptions());
			$filter->equal('is_open','显示开关')->radio(['' => '所有', 0 => '否', 1 => '是',]);
		});
		// 關閉搜尋
		//$grid->disableFilter(); 
		$grid->actions(function ($actions) {
			
			//$actions->disableEdit();
			
			$actions->disableView();
			
			//$actions->disableDelete();
		});
		$grid->model()->orderBy('title_id')->orderBy('place');
		/* form rules "saving" can't catch
		$grid->column('title_id', '层级')->editable('select',function () {
			$options = GetCjData::GetLevelOptions();
			return $options;
		})->style('vertical-align: middle;');
		*/
		$grid->column('title_id', '层级')->display(function ($title_id) {
			return GetCjData::GetMatchLevelName($title_id);
		})->style('vertical-align: middle;');
		$grid->column('is_open', '显示开关')->switch([
			'on'  => ['value' => 1, 'text' => '是', 'color' => 'primary'],
			'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
		])->style('vertical-align: middle;');
		$grid->column('place', '排序')->sortable()->style('vertical-align: middle;');
		$grid->column('content', '内容')->display(function ($content) {
			return $content;
		})->style('vertical-align: middle;');
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
        $show = new Show(MainContent::findOrFail($id));

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
        $form = new Form(new MainContent);

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
		$form->select('title_id', '层级')->options(GetCjData::GetLevelOptions())->required();
		$form->switch('is_open', '显示开关')->states([
			'on'  => ['value' => 1, 'text' => '是', 'color' => 'primary'],
			'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
		]);
		$form->number('place', '排序')->required()->min(1)->default(1);
		$form->editor('content','內容')->rules('required',['警告:内容未填写']);
		$form->url('link_apply','申请连结')->required();
		$form->url('link_show','查看连结')->required();
		
		$form->saving(function (Form $form) {
			$title_place = [];
			$rows = DB::table('main_content')->select('id','place')->where('title_id','=',$form->title_id)->get()->toArray();
			
			
			if($rows){
				foreach ($rows as $k=>$v) {
					$title_place[$v->id] = $v->place;
				}
			}
			if($form->model()->id){
				unset($title_place[$form->model()->id]);
			}
			if(in_array($form->place,$title_place)){
				throw new \Exception('排序设置错误:该层级下已有相同排序，请重新选择');
			}
		});
        return $form;
    }
}

