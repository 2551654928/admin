<?php

namespace App\Admin\Controllers;

use App\Article;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class PageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '页面管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article);
        $grid->model()->orderBy('id', 'desc')->where('type', '=', 'page');

        $grid->disableRowSelector();
        $grid->disableCreateButton();

        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->like('title', __('页面标题'));
        });

        $grid->column('id', __('ID'));
        $grid->column('key', __('标识'))->label('danger');
        $grid->column('title', __('页面标题'));
        $grid->column('read_num', __('阅读量'))->sortable();
        $grid->column('content', __('内容'))->display(function ($content) {
            return Str::limit(strip_tags($content), 100);
        });
        $grid->column('is_comment', __('是否允许评论'))
            ->using([0 => __('否'), 1 => __('是')])
            ->dot([
                0 => 'danger',
                1 => 'success',
            ], 'warning')->filter([
                1 => __('允许评论'),
                0 => __('不允许评论'),
            ]);
        $grid->column('updated_at', __('更新时间'))->sortable()
            ->filter('range', 'datetime');
        $grid->column('created_at', __('创建时间'))->sortable()
            ->filter('range', 'datetime');

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            // 不可删除的单页标识
            $keys = ['about', 'donate', 'message', 'treaty'];
            if (in_array($actions->row->key, $keys)) {
                $actions->disableDelete();
            }
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

        $show->field('id', __('ID'));
        $show->field('title', __('页面标题'));
        $show->field('read_num', __('阅读量'));
        $show->field('content', __('内容'));
        $show->field('is_comment', __('是否允许评论'))
            ->using([0 => '否', 1 => '是'])
            ->dot([
                0 => 'danger',
                1 => 'success',
            ], 'warning');
        $show->field('key', __('标识'));
        $show->field('updated_at', __('更新时间'));
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
        $article = Article::find(request()->route('page'));

        $form = new Form(new Article);

        $form->text('name', __('发布人'))
            ->required()
            ->default(($article ? $article->name : false) ?: Admin::user()->name);
        $form->text('email', __('发布人邮箱'))
            ->required()
            ->default(($article ? $article->email : false) ?: Admin::user()->email);

        $form->hidden('type')->default('page');
        $form->text('title', __('页面标题'))->required();
        $form->summernote('content', __('内容'));
        $form->switch('is_comment', __('是否允许评论'))
            ->states([
                'on'  => ['value' => 1, 'text' => '是', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '否', 'color' => 'danger'],
            ]);
        $form->text('read_num', __('阅读量'))->rules('numeric');
        $form->text('key', __('单页标识'))->readonly();

        return $form;
    }
}
