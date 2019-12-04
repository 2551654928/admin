<?php

namespace App\Http\Controllers;

use App\Blog;

class BlogController extends Controller
{
    public function blogs()
    {
        $blogs = Blog::all()->whereIn('status', [1, 3])->groupBy('status');
        return view('layouts.blogs.list', compact('blogs'));
    }

    public function join()
    {
        return view('layouts.blogs.join');
    }
}
