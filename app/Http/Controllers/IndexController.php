<?php

namespace App\Http\Controllers;

use App\Article;
use App\Blog;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $notices = Article::where('type', 'notice')->limit(4)->orderByDesc('created_at')->get();
        $blogs = Blog::where('status', 1)->limit(3)->orderBy('adopted_at', 'asc')->get();
        return view('layouts.index', compact('notices', 'blogs'));
    }
}
