<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dateline extends Model
{
    protected $table = 'dateline';

    protected $fillable = ['blog_id', 'date', 'content'];

    protected $appends = ['join_date'];

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }

    public function getJoinDateAttribute()
    {
        return date('Y/m/d', strtotime($this->date));
    }
}
