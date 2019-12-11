<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';

    protected $dates = ['abnormaled_at', 'adopted_at', 'updated_at', 'created_at'];

    protected $appends = ['avatar'];

    protected $fillable = ['name', 'email', 'link', 'message', 'status', 'history', 'views', 'adopted_at', 'updated_at', 'created_at'];

    const STATUS = ['审核中', '审核通过', '未通过', '异常'];

    public static function boot()
    {
        parent::boot();

        static::updating(function (Blog $blog) {
            if ($blog->status == 1) {
                // 更新审核时间
                $blog->adopted_at = date('Y-m-d H:i:s');
            } else {
                $blog->adopted_at = null;
            }
        });
    }

    public function getAvatarAttribute($value)
    {
        return gravatar($this->attributes['email']);
    }

    public function datelines()
    {
        return $this->hasMany(Dateline::class, 'blog_id', 'id')->orderBy('created_at', 'asc');
    }

    public function comments($page = 10)
    {
        return $this->hasMany(Comment::class, 'foreign_id', 'id')
            ->with('replies')
            ->orderBy('created_at', 'desc')
            ->where('parent_id', 0)
            ->where('type', 'blog')
            ->where('status', 1)
            ->paginate($page);
    }

    public function getCommentCount()
    {
        return Comment::where('foreign_id', $this->id)
            ->where('type', 'blog')
            ->where('status', 1)
            ->count();
    }
}
