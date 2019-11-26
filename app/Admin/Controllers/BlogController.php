<?php

namespace App\Admin\Controllers;

use App\Models\Blog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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

        $grid->quickSearch('name', 'email', 'link', 'message');

        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->like('name', __('博客名称'));
            $filter->like('email', __('邮箱'));
            $filter->like('link', __('链接'));
            $filter->like('message', __('寄语'));
        });

        $grid->column('id', 'ID')->sortable();
        $grid->column('name', __('博客名称'))->editable();
        $grid->column('avatar', __('头像'))->gravatar(20);
        $grid->column('email', __('邮箱'));
        $grid->column('link', __('链接地址'))->link();
        $grid->column('message', __('寄语'));
        $grid->column('status', __('状态'))->filter([
            0 => __('审核中'),
            1 => __('审核通过'),
            2 => __('异常'),
        ])->editable('select', [
            0 => __('审核中'),
            1 => __('审核通过'),
            2 => __('异常'),
        ]);

        $grid->column('created_at', __('提交时间'))->sortable();

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
            ->options([
                0 => __('审核中'),
                1 => __('审核通过'),
                2 => __('异常'),
            ])->default(0);

        return $form;
    }
}
