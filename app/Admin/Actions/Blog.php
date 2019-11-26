<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Blog extends RowAction
{
    public $name = '记录大事记';

    public function handle(Model $model)
    {
        // TODO ... 记录大事记

        return $this->response()->success(__('记录成功'))->refresh();
    }

    public function form()
    {
        $this->datetime('date', __('时间'));
        $this->textarea('content', __('内容'))->rules('required');
    }

}
