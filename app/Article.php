<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';

    protected $dates = ['updated_at', 'created_at'];

    const TYPES = ['notice' => '公告', 'article' => '文章', 'page' => '单页'];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'foreign_id', 'id');
    }
}
