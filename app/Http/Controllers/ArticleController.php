<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function articles($type)
    {
        $typeText = Article::TYPES[$type];
        $articles = Article::where('type', $type)->orderBy('created_at', 'desc')->paginate(10);
        return view('layouts.articles.list', compact('articles', 'typeText'));
    }

    public function article($type, $id)
    {
        $article = Article::where('type', $type)->findOrFail($id);
        $article->increment('read_num');
        return view('layouts.articles.detail', compact('article'));
    }

    public function comment(Request $request)
    {
        $replyId = $request->input('reply_id');
        $parentId = $request->input('parent_id');
        $validator = Validator::make($request->all(), [
            'parent_id' => 'required|numeric',
            'foreign_id' => 'required|numeric',
            'name' => 'required|min:2|max:20',
            'email' => 'required|email',
            'link' => 'url|max:30',
            'content' => 'required|min:2|max:999'
        ]);
        if ($validator->fails()) {
            return ['code' => 0, 'message' => $validator->errors()->first()];
        }
        $data = $validator->validated();
        if (!$article = Article::find($data['foreign_id'])) {
            return ['code' => 0, 'message' => '不存在的资源'];
        }
        $data['is_admin'] = 0;
        $data['status'] = 2;
        $data['ip'] = $request->getClientIp();
        $data['type'] = $article->type;
        if ($created = Comment::create($data)) {
            $content = str_replace(PHP_EOL, '<br />', $data['content']);
            if ($parentId == 0 && $replyId == 0) {
                // 给被回复对象发邮件
                $types = Article::TYPES;
                Mail::send('emails.comment', [
                    'article' => $article,
                    'comment' => $created,
                    'content' => $content,
                    'types' => $types,
                ], function ($mail) use ($article, $types) {
                    $mail->to($article->email);
                    $mail->subject("【十年之约】{$types[$article->type]} <{$article->title}> 有了新的评论");
                });
            } else {
                // 被回复对象原评论
                $comment = null;
                if ($replyId != 0 && !$comment = Comment::find($replyId)) {
                    return ['code' => 0, 'message' => '回复对象不存在'];
                }
                // 给被回复对象发邮件
                $email = $comment->email;
                Mail::send('emails.reply', [
                    'row' => $comment,
                    'comment' => $created,
                    'content' => $content
                ], function ($mail) use ($email) {
                    $mail->to($email);
                    $mail->subject('【十年之约】你的评论有了新的回复');
                });
            }

            return ['code' => 1, 'message' => '评论成功, 审核通过后显示'];
        }

        return ['code' => 0, 'message' => '评论失败'];
    }
}
