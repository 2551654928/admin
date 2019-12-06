<!-- Comment -->
<section class="wrapper style4 special container" id="comments-container">

    <!-- Content -->
    <div class="content" id="comments-box">
        <h4>共有 {{ $data->getCommentCount() }} 条评论</h4>
        <ul id="comments">
            @foreach($data->comments() as $comment)
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
                            <p>{!! $comment->html !!}</p>
                        </div>
                        <a href="javascript:void(0)" class="reply" data-parent-id="{{ $comment->id }}" data-reply-id="{{ $comment->id }}" data-at="{{ "@{$comment->name} " }}">回复</a>
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
                                            <p class="date"
                                               title="{{ $reply->created_at }}">{{ $reply->created_at }}</p>
                                        </div>
                                        <div class="content">
                                            {!! $reply->html !!}
                                        </div>
                                        <a href="javascript:void(0)" class="reply" data-parent-id="{{ $comment->id }}" data-reply-id="{{ $reply->id }}" data-at="{{ "@{$reply->name} " }}">回复</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
        {!! $data->comments()->fragment('comments-container')->links() !!}
        @if($data->is_comment)
            <p>添加新评论<a href="javascript:void(0)" id="cancel-reply" data-at="">取消回复</a></p>
            <div style="clear: both"></div>
            <form id="comment-form" method="post">
                @csrf
                <div class="row gtr-50">
                    <div class="col-6 col-12-mobile">
                        <input type="text" name="name" placeholder="名称*" value="{{ \Encore\Admin\Facades\Admin::user() ? \Encore\Admin\Facades\Admin::user()->name : '' }}" required>
                    </div>
                    <div class="col-6 col-12-mobile">
                        <input type="email" name="email" placeholder="邮箱地址*" value="{{ \Encore\Admin\Facades\Admin::user() ? \Encore\Admin\Facades\Admin::user()->email : '' }}" required>
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
                <input type="hidden" name="reply_id" value="0">
                <input type="hidden" name="parent_id" value="0">
                <input type="hidden" name="foreign_id" value="{{ $data->id }}">
            </form>
        @else
            <p class="close-comment"><i class="fa fa-lock"></i> 管理员已禁止当前页面的评论！</p>
        @endif
    </div>

</section>

@section('js')
    <script>
        $(function () {
            var at = '';
            $reply = $('input[name=reply_id]');
            $parent = $('input[name=parent_id]');
            $content = $('textarea[name=content]');

            $('#comment-form').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ url('/comment/'.$type) }}",
                    type: "post",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        alert(response.message);
                        if (response.code) {
                            window.location.href = '';
                        }
                    },
                    error: function (error) {
                        alert('当前无法评论, 请稍后重试')
                    }
                });
            });

            $('#cancel-reply').click(function (e) {
                e.preventDefault();
                $parent.val(0);
                $reply.val(0);
                var regex = new RegExp(at);
                $content.val($content.val().replace(regex, ''));
                $('#cancel-reply').hide();
            });

            $('a.reply').click(function (e) {
                e.preventDefault();
                $parent.val($(this).data('parent-id'));
                $reply.val($(this).data('reply-id'));

                var regex = new RegExp(at);
                $content.val(($content.val()).replace(regex, ''));

                at = $(this).data('at');
                $content.val(at + $content.val());

                $('#cancel-reply').data('at', at).show();
                $("html, body").animate({
                    scrollTop: $('#comment-form').offset().top - 160 + "px"
                }, 500);
            });
        })
    </script>
@endsection
