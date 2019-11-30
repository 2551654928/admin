<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Blog\Send;
use App\Blog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use App\Admin\Actions\Blog\Record;

class BlogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '博客管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Blog);
        $grid->model()->orderBy('id', 'desc');

        $grid->quickSearch('name', 'email', 'link', 'message');

        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->column(1/2, function ($filter) {
                $filter->like('name', __('博客名称'));
                $filter->like('email', __('邮箱'));
            });
            $filter->column(1/2, function ($filter) {
                $filter->like('link', __('链接'));
                $filter->like('message', __('寄语'));
            });
        });

        $grid->column('id', 'ID')->sortable();
        $grid->column('name', __('博客名称'))->editable()
            ->modal('大事记', function ($model) {
                $datelines = $model->datelines()->get()->map(function ($dateline) {
                    return $dateline->only(['id', 'date', 'content']);
                });
                return new Table(['ID', __('记录时间'), __('内容')], $datelines->toArray());
            });
        $grid->column('avatar', __('头像'))->gravatar(20);
        $grid->column('email', __('邮箱'));
        $grid->column('link', __('链接地址'))->link()
            ->copyable();
        $grid->column('message', __('寄语'));
        $grid->column('status', __('状态'))
            ->filter(Blog::STATUS)
            ->editable('select', Blog::STATUS);

        $grid->column('created_at', __('提交时间'))->sortable()
            ->filter('range', 'datetime');

        $grid->actions(function ($actions) {
            $actions->add(new Record);
            $actions->add(new Send);
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
        $show = new Show(Blog::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Blog);

        $form->display('id', 'ID');
        $form->text('name', __('博客名称'))
            ->rules('required|min:3');
        $form->email('email', __('邮箱'))
            ->rules('required|email')
            ->creationRules(['required', "unique:blog"])
            ->updateRules(['required', "unique:blog,email,{{id}}"]);
        $form->url('link', __('链接地址'))
            ->rules('required|url');
        $form->textarea('message', __('博主寄语'))
            ->rules('required|max:200');
        $form->radio('status', __('状态'))
            ->options(Blog::STATUS)->default(0);

        return $form;
    }
}
