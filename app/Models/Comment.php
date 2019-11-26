<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    protected $dates = ['updated_at', 'created_at'];

    public static $types = [];

    public static $status = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::$types = ['article' => __('文章'), 'blog' => __('博客')];
        self::$status = [__('违规'), __('正常'), __('审核中')];
    }

    public function article()
    {
        return $this->belongsTo('App\Models\Article', 'foreign_id', 'id');
    }

    public function blog()
    {
        return $this->belongsTo('App\Models\Blog', 'foreign_id', 'id');
    }
}
