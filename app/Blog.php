<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';

    protected $dates = ['abnormaled_at', 'adopted_at', 'updated_at', 'created_at'];

    protected $appends = ['avatar'];

    protected $fillable = ['name', 'email', 'link', 'message', 'status'];

    const STATUS = ['审核中', '审核通过', '未通过', '异常'];

    public function getAvatarAttribute($value)
    {
        return gravatar($this->attributes['email']);
    }

    public function datelines()
    {
        return $this->hasMany(Dateline::class, 'blog_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'foreign_id', 'id');
    }
}
