<!-- Comment -->
<section class="wrapper style4 special container" id="comments-container">

    <!-- Content -->
    <div class="content" id="comments-box">
        <h4>共有 {{ $article->comments()->total() }} 条评论</h4>
        <ul id="comments">
            @foreach($article->comments() as $comment)
                <li class="item">
                    <div class="comment-item">
                        <div class="meta">
                            <img class="avatar" src="{{ gravatar($comment->email) }}">
                            <p class="name">
                                @if($comment->is_admin)
                                    <span>管理员</span>
                                @endif
                                <a href="{{ $comment->link }}" target="_blank">{{ $comment->name }}</a>
                            </p>
                            <p class="date" title="{{ $comment->created_at }}">{{ $comment->created_at }}</p>
                        </div>
                        <div class="content">
                            <p>{{ $comment->content }}</p>
                        </div>
                        <a href="" class="reply">回复</a>
                    </div>
                    @if($comment->replies)
                        <ul class="children">
                            @foreach($comment->replies as $reply)
                                <li class="item">
                                    <div class="comment-item">
                                        <div class="meta">
                                            <img class="avatar" src="{{ gravatar($reply->email) }}">
                                            <p class="name">
                                                @if($reply->is_admin)
                                                    <span>管理员</span>
                                                @endif
                                                <a href="{{ $reply->link }}" target="_blank">{{ $reply->name }}</a>
                                            </p>
                                            <p class="date" title="{{ $reply->created_at }}">{{ $reply->created_at }}</p>
                                        </div>
                                        <div class="content">
                                            {{ $reply->content }}
                                        </div>
                                        <a href="" class="reply">回复</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
        {!! $article->comments()->fragment('comments-container')->links() !!}
        @if($article->is_comment)
            <p>添加新评论</p>
            <form>
                <div class="row gtr-50">
                    <div class="col-6 col-12-mobile">
                        <input type="text" name="name" placeholder="名称*" required>
                    </div>
                    <div class="col-6 col-12-mobile">
                        <input type="email" name="email" placeholder="邮箱地址*" required>
                    </div>
                    <div class="col-12">
                        <input type="text" name="link" placeholder="网站">
                    </div>
                    <div class="col-12">
                        <textarea name="content" placeholder="牛逼的人都会说两句" rows="3" style="resize: vertical"></textarea>
                    </div>
                    <div class="col-12">
                        <ul class="buttons">
                            <li><input type="submit" class="special" value="提交评论"></li>
                        </ul>
                    </div>
                </div>
            </form>
        @else
            <p class="close-comment"><i class="fa fa-lock"></i> 管理员已禁止当前页面的评论！</p>
        @endif
    </div>

</section>
