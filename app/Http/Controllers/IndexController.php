<?php

namespace App\Http\Controllers;

use App\Article;
use App\Blog;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $notices = Article::where('type', 'notice')->limit(4)->orderBy('created_at', 'desc')->get();
        $blogs = Blog::where('status', 1)->limit(3)->get();
        return view('layouts.index', compact('notices', 'blogs'));
    }
}
