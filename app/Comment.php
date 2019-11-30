<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    protected $dates = ['updated_at', 'created_at'];

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
}
