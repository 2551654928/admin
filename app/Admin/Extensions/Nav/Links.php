<?php

namespace App\Admin\Extensions\Nav;

use App\Blog;
use App\Comment;

class Links
{
    public function __toString()
    {
        $blogNum = Blog::where('status', 0)->count();
        $commentNum = Comment::where('status', 2)->count();
        $blogLink = url('admin/blogs?status[]=0');
        $commentLink = url('admin/comments?status[]=2');
        return <<<HTML

<li title="待审评论">
    <a href="$commentLink">
      <i class="fa fa-envelope-o"></i>
      <span class="label label-success">$commentNum</span>
    </a>
</li>

<li title="待审博客">
    <a href="$blogLink">
      <i class="fa fa-bell-o"></i>
      <span class="label label-warning">$blogNum</span>
    </a>
</li>

<li>
    <a href="/" target="_blank">
      <i class="fa fa-home"></i>
    </a>
</li>

HTML;
    }
}
