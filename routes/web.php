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

function getTree($id, $array = [])
{
    $comments = DB::table('typecho_comments')->where('parent', $id)->get();
    foreach ($comments as $comment) {
        $array[] = $comment;
        return getTree($comment->coid, $array);
    }

    return $array;
}

Route::get('/import/blogs', function () {

    DB::transaction(function () {
        // 处理待审核和未通过的博客数据
        $blogs = DB::table('fb_bloginfo')->orderBy('create_at', 'asc')->whereIn('blog_status', [0, 9])->get();
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

            \App\Blog::create($data);
        }

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
                    'status' => $link->sort == 'live' ? 1 : 3,
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
                    // 处理一级评论
                    $commentsA = DB::table('typecho_comments')->where('cid', $content->cid)->where('parent', 0)->get();
                    $status = ['approved' => 1];
                    foreach ($commentsA as $item) {
                        $c = \App\Comment::create([
                            'parent_id' => 0,
                            'reply_id' => 0,
                            'foreign_id' => $b->id,
                            'type' => 'blog',
                            'email' => $item->mail,
                            'name' => $item->author,
                            'link' => $item->url,
                            'content' => $item->text,
                            'is_admin' => 0,
                            'ip' => $item->ip,
                            'status' => $status[$item->status],
                            'created_at' => date('Y-m-d H:i:s', $item->created)
                        ]);
                        // 下级评论
                        $children = getTree($item->coid);
                        foreach ($children as $child) {
                            \App\Comment::create([
                                'parent_id' => $c->id,
                                'reply_id' => $c->id,
                                'foreign_id' => $b->id,
                                'type' => 'blog',
                                'email' => $child->mail,
                                'name' => $child->author,
                                'link' => $child->url,
                                'content' => $child->text,
                                'is_admin' => 0,
                                'ip' => $child->ip,
                                'status' => $status[$child->status],
                                'created_at' => date('Y-m-d H:i:s', $child->created)
                            ]);
                        }
                    }
                }
            }
        }

//        throw new \Exception('666');
        // 处理文章评论
        // 98:留言板，124：关于十年之约网站改版中遇到的一些问题  106：关于近期比较集中反馈的问题 的回复  100：关于变更十年之约官方群及相关事项的通知
        $comments = DB::table('typecho_comments')->whereIn('cid', [98,124,106,100])->where('parent', 0)->get();
        $pages = [98 => 3, 124 => 7, 106 => 6, 100 => 5];
        foreach ($comments as $comment) {
            $ac = \App\Comment::create([
                'parent_id' => 0,
                'reply_id' => 0,
                'foreign_id' => $pages[$comment->cid],
                'type' => 'article',
                'email' => $comment->mail,
                'name' => $comment->author,
                'link' => $comment->url,
                'content' => $comment->text,
                'is_admin' => 0,
                'ip' => $comment->ip,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $comment->created)
            ]);
            // 下级评论
            $children = getTree($comment->coid);
            foreach ($children as $child) {
                \App\Comment::create([
                    'parent_id' => $ac->id,
                    'reply_id' => $ac->id,
                    'foreign_id' => $pages[$comment->cid],
                    'type' => 'article',
                    'email' => $child->mail,
                    'name' => $child->author,
                    'link' => $child->url,
                    'content' => $child->text,
                    'is_admin' => 0,
                    'ip' => $child->ip,
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s', $child->created)
                ]);
            }
        }
    });

});

Route::get('/import/excels', function () {
    DB::transaction(function () {
        $excels = DB::table('excel')->get();
        foreach ($excels as $excel) {
            $blog = \App\Blog::where('name', $excel->f3)->first();
            if ($blog) {
                $blog->email = $excel->f6;
                $blog->message = $excel->f7;
                $blog->history = $excel->f8;
                $blog->created_at = $excel->f2;
                $blog->save();
            }
        }
    });
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
