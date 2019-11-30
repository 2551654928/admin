<?php

namespace App\Admin\Controllers;

use App\Dateline;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class DatelineController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '大事记';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Dateline);
        $grid->model()->orderBy('id', 'desc');

        $grid->quickSearch('name', 'content');

        $grid->column('id', __('ID'));
         $grid->column('blog.name', __('博客名称'));
        $grid->column('date', __('日期'))->sortable()
            ->editable('datetime')
            ->filter('range', 'datetime');
        $grid->column('content', __('内容'))->display(function ($content) {
            return Str::limit(strip_tags($content), 100);
        });
        $grid->column('created_at', __('创建时间'))->sortable()
            ->filter('range', 'datetime');

        $grid->disableCreateButton();

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
        $show = new Show(Dateline::findOrFail($id));

        $show->field('id', __('Id'));
        // $show->field('blog_id', __('Blog id'));
        $show->field('date', __('日期'));
        $show->field('content', __('内容'));
        $show->field('created_at', __('创建时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Dateline);

        // $form->number('blog_id', __('Blog id'));
        $form->datetime('date', __('日期'))->default(date('Y-m-d H:i:s'));
        $form->textarea('content', __('内容'));

        return $form;
    }
}
