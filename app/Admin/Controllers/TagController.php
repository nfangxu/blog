<?php

namespace App\Admin\Controllers;

use App\Models\Tag;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Show;

class TagController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->row($this->form())
            ->body($this->grid());
    }

    protected function grid()
    {
        $grid = new Grid(new Tag);
        $grid->disableRowSelector();
        $grid->disableFilter();
        $grid->disableExport();
        $grid->disableCreateButton();
        $grid->id('标签ID');
        $grid->name('标签')->editable();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
            $actions->disableView();
        });

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Tag);

        $form->text('name', '标签名')->required();
        $form->setAction('/admin/tag');

        $form->tools(function (Form\Tools $tools) {
            // 去掉`列表`按钮
            $tools->disableList();
            // 去掉`删除`按钮
            $tools->disableDelete();
            // 去掉`查看`按钮
            $tools->disableView();
        });
        $form->footer(function ($footer) {
            // 去掉`重置`按钮
            $footer->disableReset();
            // 去掉`提交`按钮
            // $footer->disableSubmit();
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();
            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();

        });
        return $form;
    }
}
