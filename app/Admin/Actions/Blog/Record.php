<?php

namespace App\Admin\Actions\Blog;

use App\Dateline;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Record extends RowAction
{
    public $name = '记录大事记';

    public function handle(Model $model, Request $request)
    {
        $blogId = $request->post('_key');
        // 记录大事记
        $dateline = new Dateline;
        $dateline->blog_id = $blogId;
        $dateline->date = $request->get('date');
        $dateline->content = $request->get('content');
        if (!$dateline->save()) {
            return $this->response()->error(__('记录失败'));
        }

        return $this->response()->success(__('记录成功'))->refresh();
    }

    public function form()
    {
        $this->datetime('date', __('时间'))->required();
        $this->textarea('content', __('内容'))->required();
    }

}
