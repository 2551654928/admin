<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Setting;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;

class SettingController extends AdminController
{
    public function index(Content $content)
    {
        return $content->title('网站设置')->body(new Setting());
    }
}
