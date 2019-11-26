<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';

    protected $dates = ['abnormaled_at', 'adopted_at', 'updated_at', 'created_at'];

    protected $appends = ['avatar'];

    public static $status = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::$status = [
            0 => __('审核中'),
            1 => __('审核通过'),
            2 => __('异常'),
        ];
    }

    public function getAvatarAttribute($value)
    {
        return $this->attributes['email'];
    }

    public function datelines()
    {
        return $this->hasMany('App\Models\Dateline', 'blog_id', 'id');
    }
}
