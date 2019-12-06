<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function articles(Request $request)
    {
        $type = $request->route('type');
        $typeText = Article::TYPES[$type];
        $articles = Article::where('type', $type)->orderBy('created_at', 'desc')->paginate(10);
        return view('layouts.articles.list', compact('articles', 'typeText'));
    }

    public function article(Request $request)
    {
        $article = Article::where('type', $request->route('type'))->findOrFail($request->route('id'));
        $article->increment('read_num');
        return view('layouts.articles.detail', compact('article'));
    }
}
