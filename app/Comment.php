<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Comment extends Model
{
    protected $table = 'comment';

    protected $dates = ['updated_at', 'created_at'];

    protected $appends = ['html'];

    protected $fillable = ['parent_id', 'foreign_id', 'name', 'email', 'link', 'content', 'type', 'status', 'is_admin'];

    const TYPES = ['article' => '文章', 'blog' => '博客'];

    const STATUS = ['违规', '正常', '审核中'];

    public function article()
    {
        return $this->belongsTo(Article::class, 'foreign_id', 'id');
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'foreign_id', 'id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    public function getHtmlAttribute()
    {
        $content = htmlentities($this->attributes['content']);
        $content = str_replace(
            [
                PHP_EOL, // 替换换行
                ' ' // 替换空格
            ],
            [
                '<br>',
                '&nbsp;'
            ],
            $content
        );
        // 匹配a链接 Regex Link：https://daringfireball.net/2010/07/improved_regex_for_matching_urls
        $regex = '@(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))@';
        $content = preg_replace($regex, '<a class="comment-link" target="_blank" href="$1" rel="noopener">$1</a>', $content);
        return $content;
    }

    /**
     * 发送评论邮件
     *
     * @param Comment $comment  新插入的评论
     * @param string $email     收件人邮箱
     * @param string $subject   邮件主题
     * @param string $name      收件人名称
     * @param string $title     发布内容标题
     * @param string $type      发布内容类型
     * @param string $content   评论内容
     */
    public static function sendCommentEmail(
        Comment $comment,
        string $email,
        string $subject,
        string $name,
        string $title,
        string $type,
        string $content
    ) {
        Mail::send('emails.comment', [
            'title' => $title,
            'name' => $name,
            'comment' => $comment,
            'type' => $type,
            'content' => str_replace(PHP_EOL, '<br />', $content),
        ], function ($mail) use ($email, $subject) {
            $mail->to($email);
            $mail->subject($subject);
        });
    }

    /**
     * 发送回复邮件
     *
     * @param Comment $row      原评论
     * @param Comment $comment  新插入的评论
     * @param string $title     发布内容标题
     * @param string $email     收件人邮箱
     * @param string $subject   邮件主题
     * @param string $content   邮件内容
     * @param string $url       URL
     */
    public static function sendReplyEmail(
        Comment $row,
        Comment $comment,
        string $title,
        string $email,
        string $subject,
        string $content,
        string $url = ''
    ) {
        Mail::send('emails.reply', [
            'title' => $title,
            'row' => $row,
            'comment' => $comment,
            'content' => str_replace(PHP_EOL, '<br />', $content),
            'url' => $url ?: url()->previous()
        ], function ($mail) use ($email, $subject) {
            $mail->to($email);
            $mail->subject($subject);
        });
    }
}
