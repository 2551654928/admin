<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blogs()
    {
        return view('layouts.blogs.list');
    }
}
