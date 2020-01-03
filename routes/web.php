<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index');

// 公告
Route::get('notices.html', 'ArticleController@articles')->defaults('type', 'notice');
Route::get('notice/{id}.html', 'ArticleController@article')->defaults('type', 'notice');

// 文章
Route::get('articles.html', 'ArticleController@articles')->defaults('type', 'article');
Route::get('article/{id}.html', 'ArticleController@article')->defaults('type', 'article');

// 博客
Route::any('blogs.html', 'BlogController@blogs');
Route::get('blog/{id}.html', 'BlogController@blog');

// 申请加入
Route::any('join.html', 'BlogController@join');

// 评论
Route::post('comment/article', 'CommentController@article');
Route::post('comment/blog', 'CommentController@blog');

Route::get('{key?}.html', 'PageController@detail');
