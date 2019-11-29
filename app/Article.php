<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';

    protected $dates = ['updated_at', 'created_at'];

    public static $types = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::$types = ['notice' => __('公告'), 'article' => __('文章'), 'page' => __('单页')];
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'foreign_id', 'id');
    }
}
