<?php

namespace App\Admin\Actions\Comment;

use App\Article;
use App\Blog;
use App\Comment;
use Encore\Admin\Actions\RowAction;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Reply extends RowAction
{
    public $name = '回复';

    public function handle(Model $model, Request $request)
    {
        $type = $this->row->type;
        $title = '';
        $url = config('app.url');
        if ($type === 'blog') {
            if (!$blog = Blog::find($this->row->foreign_id)) {
                return $this->response()->error('该评论来源博客已被删除, 无法回复');
            }
            $title = $blog->name;
            $url = url("/blog/{$blog->id}.html");
        }

        if ($type === 'article') {
            if (!$article = Article::find($this->row->foreign_id)) {
                return $this->response()->error('该评论来源数据已被删除, 无法回复');
            }
            $title = $article->title;
            if ($article->type === 'page') {
                $url = url("/{$article->key}.html");
            } else {
                $url = url("/{$article->type}/{$blog->id}.html");
            }
        }

        $sendEmail = $request->input('send_email', 0);
        $content = $request->input('content');
        $content = "@{$this->row->name} ".$content;

        $comment = new Comment;
        $comment->parent_id = $this->row->parent_id ? $this->row->parent_id : $this->row->id;
        $comment->reply_id = $this->row->id;
        $comment->foreign_id = $this->row->foreign_id;
        $comment->type = $this->row->type;
        $comment->email = Admin::user()->email;
        $comment->name = Admin::user()->name;
        $comment->link = config('app.url');
        $comment->content = $content;
        $comment->is_admin = 1;
        $comment->ip = $request->getClientIp();
        $comment->status = 1;
        $comment->save();

        if ($sendEmail) {
            $email = $this->row->email;
            Comment::sendReplyEmail(
                $this->row,
                $comment,
                $title,
                $email,
                '【十年之约】回复通知',
                $content,
                $url
            );
        }

        return $this->response()->success('回复成功')->refresh();
    }

    public function form()
    {
        $this->radio('send_email', __('邮件通知'))->options([
            1 => '发送邮件通知',
            0 => '不发送邮件通知',
        ])->default(1);
        $this->textarea('content', __('请输入回复内容...'))->required();
    }

}
