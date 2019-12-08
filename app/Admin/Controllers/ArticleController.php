<?php

namespace App\Admin\Controllers;

use App\Article;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
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
        $grid->model()->orderBy('id', 'desc')->where('type', 'article');

        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->column(1/2, function ($filter) {
                $filter->like('title', __('标题'));
                $filter->like('content', __('内容'));
            });
            $filter->column(1/2, function ($filter) {
                $filter->like('name', __('发布人'));
                $filter->like('email', __('发布人邮箱'));
            });
        });

        $grid->column('id', __('ID'));
        $grid->column('name', __('发布人'));
        $grid->column('email', __('发布人邮箱'));
        $grid->column('title', __('标题'));
        $grid->column('read_num', __('阅读量'))->sortable();
        $grid->column('content', __('内容'))->display(function ($content) {
            return Str::limit(strip_tags($content), 70);
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
            ->using(Article::TYPES)
            ->filter(Article::TYPES)
            ->label([
                'article' => 'success',
                'notice' => 'info',
                'page' => 'danger'
            ]);
        $grid->column('updated_at', __('更新时间'))->sortable()
            ->filter('range', 'datetime');
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
        $show->field('name', __('发布人'));
        $show->field('email', __('发布人邮箱'));
        $show->field('title', __('标题'));
        $show->field('read_num', __('阅读量'));
        $show->field('content', __('内容'));
        $show->field('is_comment', __('是否允许评论'))
            ->using([0 => '否', 1 => '是'])
            ->dot([
                0 => 'danger',
                1 => 'success',
            ], 'warning');
        $show->field('type', __('类型'))->using(Article::TYPES);

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
        $article = Article::find(request()->route('article'));

        $form = new Form(new Article);

        $form->text('title', __('标题'))->required();

        $form->text('name', __('发布人'))
            ->required()
            ->default(($article ? $article->name : false) ?: Admin::user()->name);
        $form->text('email', __('发布人邮箱'))
            ->required()
            ->default(($article ? $article->email : false) ?: Admin::user()->email);

        $form->summernote('content', __('内容'));
        $form->switch('is_comment', __('是否允许评论'))
            ->states([
                'on'  => ['value' => 1, 'text' => '是', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '否', 'color' => 'danger'],
            ])
            ->default(1);
        $form->text('read_num', __('阅读量'))->rules('numeric');
        $form->hidden('type')->value('article');
        /*$form->radio('type', __('类型'))
            ->options(Article::TYPES)
            ->default('notice');*/

        return $form;
    }
}
