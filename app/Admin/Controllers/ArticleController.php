<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class ArticleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article);
        $grid->model()->orderBy('id', 'desc');

        $grid->quickSearch('title', 'content');

        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->like('title', __('标题'));
        });

        $grid->column('id', __('ID'));
        $grid->column('title', __('标题'));
        $grid->column('content', __('内容'))->display(function ($content) {
            return Str::limit($content, 100);
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
        $grid->column('type', __('类型'))
            ->using(Article::$types)
            ->filter(Article::$types)
            ->label();
//        $grid->column('key', __('标识'));
//        $grid->column('updated_at', __('Updated at'));
        $grid->column('created_at', __('创建时间'))->sortable()
            ->filter('range', 'datetime');

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
        $show->field('title', __('标题'));
        $show->field('content', __('内容'));
        $show->field('is_comment', __('是否允许评论'))
            ->using([0 => '否', 1 => '是'])
            ->dot([
                0 => 'danger',
                1 => 'success',
            ], 'warning');
        $show->field('type', __('类型'))->using(Article::$types);
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
        $form = new Form(new Article);

        $form->text('title', __('标题'));
        $form->summernote('content', __('内容'));
        $form->switch('is_comment', __('是否允许评论'))
            ->states([
                'on'  => ['value' => 1, 'text' => '是', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '否', 'color' => 'danger'],
            ])
            ->default(1);
        $form->radio('type', __('类型'))
            ->options([
                'notice' => __('公告'),
                'article' => __('文章'),
                'page' => __('单页')
            ])
            ->default('notice');
        $form->text('key', __('单页标识'))->placeholder('不填写则使用ID为文章路径');

        return $form;
    }
}
