<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ArticleController extends Controller
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
            ->header('文章管理')
            ->description('文章列表')
            ->breadcrumb(
                ["text" => "文章管理", "url" => "/article"],
                ["text" => "文章列表"]
            )
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
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
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article);
        $grid->model()->orderBy("id", "desc")->where("status", "<>", 0);
        $grid->id('文章ID')->sortable();
        $grid->title('标题')->editable();
        $grid->tags("标签")->pluck('name')->label();
        $grid->status('状态')->switch([
            "on" => ["value" => 1, "text" => "已发布", "color" => "success"],
            "off" => ["value" => 2, "text" => "草稿", "color" => "danger"],
        ]);
        $grid->created_at('创建时间');
        $grid->updated_at('修改时间');

        $grid->filter(function ($filter) {
            // 设置created_at字段的范围查询
            $filter->between('created_at', '创建时间')->datetime();
            $filter->in('status', "文章状态")->checkbox(['已删除', '已发布', '草稿',]);
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Article::findOrFail($id));

        $show->id('Id');
        $show->category('Category');
        $show->title('Title');
        $show->content('Content');
        $show->status('Status');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article);

        $form->switch("status")->states([
            "on" => ["value" => 1, "text" => "发布", "color" => "success"],
            "off" => ["value" => 2, "text" => "草稿", "color" => "danger"],
        ])->default(2);

        $form->multipleSelect('tags', '标签')->options(Tag::all()->pluck('name', 'id'));
        $form->text('title', '标题');
        $form->markdown('content', '内容')->height(500);
        $form->markdown('content_html', '抓取内容')->height(500);

        return $form;
    }
}
