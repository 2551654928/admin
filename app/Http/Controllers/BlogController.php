<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function blogs()
    {
        $blogs = Blog::whereIn('status', [1, 3])->select()
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy('status');
        return view('layouts.blogs.list', compact('blogs'));
    }

    public function blog(Request $request)
    {
        $blog = Blog::findOrFail($request->route('id'));
        $blog->increment('views');
        return view('layouts.blogs.detail', compact('blog'));
    }

    public function join(Request $request)
    {
        // 系统是否开启申请系统
        $config = Config::where('key', 'close_apply')->first();
        $closeApply = $config->value == 1 ? true : false;
        if ($request->isMethod('post')) {
            if ($closeApply) {
                return ['code' => 0, 'message' => '申请系统已被管理员关闭!'];
            }

            $email = $request->input('email');
            if (Blog::where('email', $email)->where('status', '<>', 2)->count()) {
                return ['code' => 0, 'message' => '检测到系统已存在该邮箱, 同一个邮箱只允许申请一次!'];
            }
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2|max:20',
                'email' => 'required|email',
                'link' => 'required|url|max:50',
                'message' => 'required|min:2|max:300',
                'captcha' => 'required|captcha'
            ], [
                'link.required' => '网站地址不能为空',
                'link.url' => '网站地址格式不正确',
                'link.max' => '网站地址过长, 最大 50 个字符',
                'message.required' => '博主寄语不能为空',
                'message.min' => '博主寄语字符必须大于 2',
                'message.max' => '博主寄语字符必须小于 300',
                'captcha.required' => '验证码不能为空',
                'captcha.captcha' => '验证码错误',
            ]);
            if ($validator->fails()) {
                return ['code' => 0, 'message' => $validator->errors()->first()];
            }
            $data = $validator->validated();
            $data['status'] = 0;
            if (!Blog::create($data)) {
                return ['code' => 0, 'message' => '申请失败, 请稍后重试!'];
            }
            return ['code' => 1, 'message' => '申请成功, 请耐心等待审核, 结果会以邮件形式通知到您的邮箱!'];
        }

        return view('layouts.blogs.join', compact('closeApply'));
    }
}
