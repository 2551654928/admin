<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Illuminate\Http\Request;

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

    public function comment(Request $request)
    {
        $parentId = $request->input('parent_id');
        $foreignId = $request->input('foreign_id');
        $name = $request->input('name');
        $email = $request->input('email');
        $link = $request->input('link');
        $content = $request->input('content');
        // TODO 校验参数
        $comment = new Comment;
        $comment->parent_id = $parentId;
        $comment->foreign_id = $foreignId;
        $comment->name = $name;
        $comment->email = $email;
        $comment->link = $link;
        $comment->content = $content;
        if ($comment->save()) {
            // TODO 设置cookie
            return ['code' => 1];
        }
        return ['code' => 0];
    }
}
