<?php

namespace App\Admin\Actions\Blog;

use Encore\Admin\Actions\RowAction;
use Encore\Admin\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Send extends RowAction
{
    public $name = '发送邮件';

    public function handle(Model $model, Request $request)
    {
        $email = $this->row->email;
        $title = $request->input('title');
        $content = $request->input('content');
        // TODO 替换字符串
        Mail::send('mail.notify', [
            'email' => $email,
            'title' => $title,
            'content' => $content,
        ], function ($mail) use ($email, $title, $content) {
            $mail->from('i@wispx.cn', $title);
            $mail->to($email);
            $mail->subject($content);
        });

        return $this->response()->success('发送成功')->refresh();
    }

    public function form()
    {
        $this->radio('type', __('邮件类型'))->options([
            0 => '自定义',
            1 => '通过',
            2 => '驳回',
        ])->default(0);
        $this->text('title', __('邮件标题'))->required()->placeholder('请输入邮件标题');
        $this->textarea('content', __('内容'))->required()->placeholder('请输入邮件内容');
        // TODO 完善发邮件功能
        Admin::script(
            <<<'SCRIPT'
var title = '';
var content = '';
var $title = $('.modal-body input[name=title]');
var $content = $('.modal-body textarea');
$('.modal-body input').on('ifChecked', function() {
  switch (parseInt($(this).val())) {
    case 0:
        title = '';
        content = '';
        break;
    case 1:
        title = '【十年之约】您的申请已通过审核';
        content = '您在 {date} 申请加入的十年之约, 现已通过审核, 从现在起请保证博客的更新与活力, 访问 ';
        break;
    case 2:
        title = '【十年之约】很抱歉, 您的申请未通过审核';
        content = '您在 {date} 申请加入的十年之约, 没有通过审核';
        break;
  }
  $title.val(title);
  $content.val(content);
});
SCRIPT
        );
    }
}
