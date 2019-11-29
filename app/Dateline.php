<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dateline extends Model
{
    protected $table = 'dateline';

    protected $fillable = ['blog_id', 'date', 'content'];

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }
}
