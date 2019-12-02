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
Route::get('{type}/{id}.html', 'ArticleController@article');

// 文章
Route::get('articles.html', 'ArticleController@articles')->defaults('type', 'article');
Route::get('{type}/{id}.html', 'ArticleController@article');

// 博客
Route::get('blogs.html', 'BlogController@blogs');

// 评论
Route::post('comment', 'ArticleController@comment');

Route::get('{key?}.html', 'PageController@detail');
