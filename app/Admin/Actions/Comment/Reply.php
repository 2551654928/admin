<?php

namespace App\Admin\Actions\Comment;

use App\Comment;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Reply extends RowAction
{
    public $name = '回复';

    public function handle(Model $model, Request $request)
    {
        $sendEmail = $request->input('send_email');
        $content = $request->input('content');
        if ($sendEmail) {

        }

        $comment = new Comment;
        $comment->parent_id = $this->row->parent_id ? $this->row->parent_id : $this->row->id;
        $comment->foreign_id = $this->row->foreign_id;
        $comment->type = $this->row->type;

        return $this->response()->success('回复成功')->refresh();
    }

    public function form()
    {
        $this->radio('send_email', __('邮件通知'))->options([
            0 => '发送邮件通知',
            1 => '不发送邮件通知',
        ])->default(0);
        $this->textarea('content', __('请输入回复内容...'))->required();
    }

}
