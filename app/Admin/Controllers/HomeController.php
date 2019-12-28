<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Blog;
use App\Comment;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('仪表盘')
            ->description('Dashboard')
            ->row(view('admin.dashboard.title'))
            ->row(self::statistics())
            ->row(function (Row $row) {
                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(self::blogs());
                });

                $row->column(4, function (Column $column) {
                    $column->append(self::comments());
                });
            });
    }

    private static function blogs()
    {
        $news = Blog::orderBy('id', 'desc')->take(10)->get();
        return view('admin.dashboard.blogs', compact('news'));
    }

    private static function comments()
    {
        $news = Comment::orderBy('id', 'desc')->take(10)->get();
        return view('admin.dashboard.comments', compact('news'));
    }

    private static function statistics()
    {
        $data = [
            'total' => Blog::count(),
            'passed' => Blog::where('status', 1)->count(),
            'refuse' => Blog::where('status', 2)->count(),
            'pending' => Blog::where('status', 0)->count(),
        ];

        return view('admin.dashboard.statistics', compact('data'));
    }
}
