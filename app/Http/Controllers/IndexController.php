<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $articles = Article::where('type', 'notice')->limit(4)->orderBy('created_at', 'desc')->get();
        dd($articles);
        return view('layouts.index');
    }
}
