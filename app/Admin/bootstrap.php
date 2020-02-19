<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Show;
use \Encore\Admin\Grid;

Encore\Admin\Form::forget(['map', 'editor']);

Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar) {
    $navbar->right(new \App\Admin\Extensions\Nav\Links);
});

Grid::init(function (Grid $grid) {
    $grid->model()->orderByDesc('id');
});

Form::init(function (Form $form) {
//    $form->disableEditingCheck();
    $form->disableCreatingCheck();
//    $form->disableViewCheck();
    $form->tools(function (Form\Tools $tools) {
        $tools->disableDelete();
        $tools->disableView();
//        $tools->disableList();
    });
});

Show::init(function (Show $show) {
    $show->panel()->tools(function (Show\Tools $tools) {
        $tools->disableDelete();
//        $tools->disableEdit();
//        $tools->disableList();
    });
});
