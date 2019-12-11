<?php

namespace App\Admin\Actions\Blog;

use App\Blog;
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
        $status = $request->input('status');
        $title = $request->input('title');
        $subtitle = $request->input('subtitle');
        $content = $request->input('content');
        $content = str_replace([
            PHP_EOL,
            '{name}',
        ], [
            '<br />',
            $this->row->name,
        ], $content);

        Mail::send('emails.notify', [
            'email' => $email,
            'title' => $title,
            'content' => $content,
            'subtitle' => $subtitle,
        ], function ($mail) use ($email, $title, $status) {
            $mail->to($email);
            $mail->subject($title);
            if ($status == 1) {
                // 审核通过增加附件
                $mail->attach(storage_path('十年之约公约.pdf'));
            }
        });

        $this->row->status = $status;
        $this->row->save();

        return $this->response()->success('发送成功')->refresh();
    }

    public function form()
    {
        $this->radio('status', __('设置状态'))->options(Blog::STATUS)->default($this->row->status);
        $this->radio('type', __('邮件类型'))->options([
            0 => '自定义',
            1 => '通过',
            2 => '驳回',
        ])->default(0);
        $this->text('title', __('邮件标题'))->required()->placeholder('请输入邮件标题');
        $this->text('subtitle', __('邮件副标题'))->required()->placeholder('请输入邮件副标题');
        $this->textarea('content', __('内容'))->required()->placeholder('请输入邮件内容');
        Admin::script(
            <<<'SCRIPT'
var title = '';
var subtitle = '';
var content = '';
var $title = $('.modal-body input[name=title]');
var $subtitle = $('.modal-body input[name=subtitle]');
var $content = $('.modal-body textarea');
$('.modal-body input[name=type]').on('ifChecked', function() {
  switch (parseInt($(this).val())) {
    case 0:
        title = '';
        subtitle = '';
        content = '';
        break;
    case 1:
        title = '【十年之约】欢迎加入十年之约！';
        subtitle = '审核通过通知';
        content = "亲爱的十年之约成员：\n\n" +

"很高兴通知您，您的申请已通过审核，欢迎加入十年之约！ \n\n" +

"从今日起，您就是十年之约的正式成员！您收到本邮件之时，您博客的十年之约正式生效，请认真对待这个约定！\n\n" +

"在约定期间，您的网站在涉及域名、名称等变化或暂时以及长期关闭等情况时，请到 http://www.foreverblog.cn/ 留言，项目组将对此作更改或者记录！若有其它问题，请通过此邮箱与项目组取得联系！\n\n" +

"若您还有更多线上交流的需求，可加入十年之约线上QQ交流群（702409956）\n";
        break;
    case 2:
        title = '【十年之约】申请驳回通知！';
        subtitle = '申请驳回通知';
        content = "尊敬的 {name} 博主：\n\n" +

"根据“十年公约”，所列条款，经过项目组审核评议, 决定驳回您的申请。\n\n" +

"驳回理由：您的站点目前暂不符合《十年公约》第二条中所列之内容。\n\n" +

"随本邮件附十年公约一份，您可仔细阅读，达到申请条件后可再行申请！\n\n" +

"特此通知\n";
        break;
  }
  $title.val(title);
  $subtitle.val(subtitle);
  $content.val(content);
});
SCRIPT
        );
    }
}
