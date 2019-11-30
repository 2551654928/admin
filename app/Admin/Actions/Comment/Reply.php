<?php

namespace App\Admin\Actions\Comment;

use App\Comment;
use Encore\Admin\Actions\RowAction;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Reply extends RowAction
{
    public $name = '回复';

    public function handle(Model $model, Request $request)
    {
        $sendEmail = $request->input('send_email', 0);
        $content = $request->input('content');

        $comment = new Comment;
        $comment->parent_id = $this->row->parent_id ? $this->row->parent_id : $this->row->id;
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
            $content = str_replace([
                PHP_EOL,
            ], [
                '<br />',
            ], $content);

            $email = $this->row->email;
            Mail::send('emails.reply', [
                'row' => $this->row,
                'comment' => $comment,
                'content' => $content
            ], function ($mail) use ($email) {
                $mail->to($email);
                $mail->subject('【十年之约】回复通知');
            });
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
