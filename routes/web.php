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

use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index');

Route::get('notices.html', 'ArticleController@articles')->defaults('type', 'notice');
Route::get('{type}/{id}.html', 'ArticleController@article');

Route::get('articles.html', 'ArticleController@articles')->defaults('type', 'article');
Route::get('{type}/{id}.html', 'ArticleController@article');

Route::get('{key?}.html', 'PageController@detail');
