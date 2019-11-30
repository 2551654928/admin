<?php

namespace App\Http\Controllers;

use App\Article;

class ArticleController extends Controller
{
    public function articles($type)
    {
        $typeText = Article::TYPES[$type];
        $articles = Article::where('type', $type)->orderBy('created_at', 'desc')->paginate(10);
        return view('layouts.articles.list', compact('articles', 'typeText'));
    }

    public function article($type, $id)
    {
        $article = Article::where('type', $type)->findOrFail($id);
        $article->increment('read_num');
        return view('layouts.articles.detail', compact('article'));
    }
}
