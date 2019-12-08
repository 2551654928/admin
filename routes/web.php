<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\DB;

function get_between($content, $start_char, $end_char) {
    $substr = substr($content, strlen($start_char) + strpos($content, $start_char), (strlen($content) - strpos($content, $end_char)) * (-1));
    return $substr;
}

Route::get('/import/blogs', function () {

    // 处理待审核和未通过的博客数据
    /*$blogs = DB::table('fb_bloginfo')->orderBy('create_at', 'asc')->whereIn('status', [0, 9])->get();
    foreach ($blogs as $blog) {
        if ($blog->blog_status == 9) {
            $status = 2;
        } else {
            $status = $blog->blog_status;
        }
        $data = [
            'name' => $blog->blog_name,
            'email' => $blog->blog_email,
            'link' => $blog->blog_url,
            'message' => $blog->send_word ?: '',
            'history' => $blog->memorabilia ?: '',
            'status' => $status,
            'updated_at' => $blog->update_at ? date('Y-m-d H:i:s', $blog->update_at) : null,
            'created_at' => $blog->create_at ? date('Y-m-d H:i:s', $blog->create_at) : null,
        ];

        // \App\Blog::create($data);
    }*/

    $links = DB::table('typecho_links')->get();
    foreach ($links as $link) {
        $slug = get_between($link->xhref, '/archives/', '.html');
        if ($slug) {
            $email = null;
            $memorabilia = null;

            $content = DB::table('typecho_contents')->where('slug', $slug)->first();
            // 查找原数据
            $blogInfo = DB::table('fb_bloginfo')->where('blog_name', 'like', "%{$link->name}%")
                ->orWhere('blog_url', $link->url)
                ->orWhere('blog_imgurl', $link->image)
                ->first();
            if ($blogInfo) {
                $email = $blogInfo->blog_email;
                $memorabilia = $blogInfo->memorabilia;
            }

            // 寄语
            $message = DB::table('typecho_fields')
                ->where('cid', $content->cid)
                ->where('name', 'xwords')
                ->where('type', 'str')
                ->value('str_value');

            $b = \App\Blog::create([
                'name' => $link->name,
                'email' => $email,
                'link' => $link->url,
                'message' => $message ?: ($link->description ?: ''),
                'history' => $memorabilia ?: '',
                'status' => 1,
                'adopted_at' => date('Y-m-d H:i:s', strtotime($link->user)),
                'created_at' => date('Y-m-d H:i:s', $content->created)
            ]);

            if ($content) {
                // 处理大事记数据
                $datelines = explode('> ', $content->text);
                unset($datelines[0]);
                $datelines = array_values($datelines);
                foreach ($datelines as $i => $dateline) {
                    $detail = array_values(array_filter(explode("\r\n", $dateline)));
                    $date = str_replace('/', '-', trim(current($detail)));
                    $time = strtotime($date);
                    if ($time) {
                        $date = date('Y-m-d H:i:s', $time);
                        unset($detail[0]);
                        $value = implode("\r\n", array_values($detail));
                        if ($i == (count($datelines) - 1)) {
                            $value = str_replace('......', '', $value);
                        }
                        // 插入大事件数据
                        \App\Dateline::create([
                            'blog_id' => $b->id,
                            'date' => $date,
                            'content' => $value
                        ]);
                    }
                }
            }
        }
    }
});

Route::get('/', 'IndexController@index');

// 公告
Route::get('notices.html', 'ArticleController@articles')->defaults('type', 'notice');
Route::get('notice/{id}.html', 'ArticleController@article')->defaults('type', 'notice');

// 文章
Route::get('articles.html', 'ArticleController@articles')->defaults('type', 'article');
Route::get('article/{id}.html', 'ArticleController@article')->defaults('type', 'article');

// 博客
Route::get('blogs.html', 'BlogController@blogs');
Route::get('blog/{id}.html', 'BlogController@blog');

// 申请加入
Route::any('join.html', 'BlogController@join');

// 评论
Route::post('comment/article', 'CommentController@article');
Route::post('comment/blog', 'CommentController@blog');

Route::get('{key?}.html', 'PageController@detail');
