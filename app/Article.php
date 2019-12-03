<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';

    protected $dates = ['updated_at', 'created_at'];

    protected $appends = ['read_num_string'];

    const TYPES = ['notice' => '公告', 'article' => '文章', 'page' => '单页'];

    public function comments($page = 10)
    {
        return $this->hasMany(Comment::class, 'foreign_id', 'id')
            ->with('replies')
            ->orderBy('created_at', 'desc')
            ->where('parent_id', 0)
            ->where('status', 1)
            ->paginate($page);
    }

    public function getCommentCount()
    {
        return Comment::where('foreign_id', $this->id)->where('status', 1)->count();
    }

    public function getReadNumStringAttribute($key)
    {
        return self::numToString($this->attributes['read_num']);
    }

    /**
     * 将数字转换为友好的字符串格式
     *
     * @param $num
     * @return string
     */
    public static function numToString($num)
    {
        if ($num >= 10000) {
            $num = round($num / 10000 * 100) / 100 . ' W';
        } elseif ($num >= 1000) {
            $num = round($num / 1000 * 100) / 100 . ' K';
        }
        return $num;
    }
}
