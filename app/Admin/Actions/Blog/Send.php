<?php

namespace App\Admin\Actions\Blog;

use App\Blog;
use Encore\Admin\Actions\RowAction;
use Encore\Admin\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class Send extends RowAction
{
    public $name = '发送邮件';

    public function handle(Model $model, Request $request)
    {
        $email = $this->row->email;
        $sendKey = "send_mail_{$email}";
        if (Cache::has($sendKey)) {
            throw new \Exception('邮件正在发送中...');
        }
        $type = $request->input('type');
        $status = $request->input('status');
        $title = $request->input('title');
        $subtitle = $request->input('subtitle');
        $content = $request->input('content');
        $content = str_replace([
            PHP_EOL,
            '{name}', // 博客名称
            '{url}', // 博客链接
            '{link}', // 博客详情页
        ], [
            '<br />',
            $this->row->name,
            $this->row->link,
            $this->row->detail_url,
        ], $content);

        Cache::put($sendKey, $email, 180);
        try {
            Mail::send('emails.notify', [
                'email' => $email,
                'title' => $title,
                'content' => $content,
                'subtitle' => $subtitle,
            ], function ($mail) use ($email, $title, $status, $type) {
                $mail->to($email);
                $mail->subject($title);
                if ($type == 1 || $type == 2) {
                    // 审核通过或驳回增加附件
                    $mail->attach(storage_path('十年之约公约.pdf'));
                }
            });

            $this->row->status = $status;
            // 如果是审核邮件，更改是否已发送邮件状态
            if ($type > 0) {
                $this->row->is_notify = 1;
            }
            if ($status == 1) { // 审核通过
                // 判断是否需要记录加入大事记
                if ($this->row->datelines->isEmpty()) {
                    if (!$this->row->datelines()->create([
                        'date' => date('Y-m-d H:i:s'),
                        'content' => '加入十年之约'
                    ])) {
                        throw new \Exception('大事记记录失败');
                    }
                }
            }

            $this->row->save();
        } catch (\Exception $e) {
            Cache::forget($sendKey);
            throw new \Exception($e->getMessage());
        }
        Cache::forget($sendKey);
        return $this->response()->success('发送成功')->refresh();
    }

    public function form()
    {
        $this->radio('status', __('设置状态'))->options(Blog::STATUS)->default($this->row->status);
        $this->radio('type', __('邮件类型'))->options([
            0 => '自定义',
            1 => '通过',
            2 => '驳回',
            3 => '异常',
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
    case 3:
        title = '【十年之约】博客异常通知！';
        subtitle = '博客异常通知';
        content = "亲爱的 {name} 博主：\n\n" +

"经十年之约项目组巡查，您的 {url} 无法正常访问。\n\n" +

"若您更换了域名，请到您的大事记页面留言 {link}" +

"这是您在十年之约的专属页面，以后凡涉及博客信息变更，请您一概至此页面留言。\n\n" +

"若您已关闭博客，根据十年公约，请发送邮件至 admin@foreverblog.cn 告知项目组！\n\n" +

"十年之约项目组\n";
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
