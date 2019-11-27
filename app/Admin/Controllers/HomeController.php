<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
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
            ->description('Description...')
            ->row(view('admin.dashboard.title'))
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
        $news = Blog::all()->where('status', 0)->take(10);
        return view('admin.dashboard.blogs', compact('news'));
    }

    private static function comments()
    {
        $news = Comment::all()->take(10);
        return view('admin.dashboard.comments', compact('news'));
    }
}
