<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dateline extends Model
{
    protected $table = 'dateline';

    public function blog()
    {
        return $this->belongsTo('App\Models\Blog', 'blog_id', 'id');
    }
}
