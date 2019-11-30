<?php

namespace App\Http\Controllers;

use App\Article;

class PageController extends Controller
{
    public function detail($key)
    {
        $article = Article::where('key', $key)->firstOrFail();
        $article->increment('read_num');
        return view('layouts.page', compact('article'));
    }
}
