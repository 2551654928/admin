@extends('layouts.app')

@section('title', "已签约博主名单 | 十年之约")

@section('content')
    <!-- Main -->
    <article id="main">

        <header class="special container">
            <span class="icon solid fa-file-text"></span>
            <h2><strong>已签约博主名单</strong></h2>
        </header>

        <!-- One -->
        <section class="wrapper style3 container special" id="blogs">

            <ul id="normal">
                @if(count($normal))
                    @foreach($normal as $item)
                    <li>
                        <a href="{{ url("/blog/{$item->id}.html") }}" target="_blank" rel="noopener" class="item" title="{{ $item->message }}">
                            <img data-original="{{ gravatar($item->email) }}" alt="">
                            <div class="meta">
                                <h4 class="name">{{ $item->name }}</h4>
                                <span class="date"><span class="str">签约时间: </span>{{ $item->created_at->format('Y-m-d') }}</span>
                            </div>
                        </a>
                    </li>
                    @endforeach
                @endif
            </ul>

            <a href="javascript:void(0)" id="show-more">显示更多 <i class="fa fa-angle-down"></i></a>

            <header class="container">
                <h2><strong>异常名录</strong></h2>
            </header>

            <ul id="abnormal" class="hide">
                @if(count($abnormal))
                    @foreach($abnormal as $blog)
                        <li>
                            <a href="{{ url("/blog/{$blog->id}.html") }}" target="_blank" rel="noopener" class="item gray" title="{{ $blog->message }}">
                                <img data-original="{{ gravatar($blog->email) }}" alt="">
                                <div class="meta">
                                    <h4 class="name">{{ $blog->name }}</h4>
                                    <span class="date"><span class="str">签约时间: </span>{{ $blog->created_at->format('Y-m-d') }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
            <a href="javascript:$('ul.hide').removeClass('hide').siblings('#show-all').remove();" id="show-all">显示全部 <i class="fa fa-angle-down"></i></a>

        </section>

    </article>
    <div style="display: none" id="li-copy">
        <li>
            <a href="__url__" target="_blank" rel="noopener" class="item" title="__message__">
                <img data-original="__avatar__" alt="">
                <div class="meta">
                    <h4 class="name">__name__</h4>
                    <span class="date"><span class="str">签约时间: </span>__date__</span>
                </div>
            </a>
        </li>
    </div>
@endsection

@section('js')
<script src="https://cdn.bootcss.com/jquery_lazyload/1.9.7/jquery.lazyload.min.js"></script>
<script>
    $("img").lazyload();
    var page = 2;
    var loading = false;
    var end = false;
    var li = $('#li-copy').html();

    function more() {
        if (!end && !loading) {
            loading = true;
            $('#show-more').attr('disabled', true).html('加载中... <i class="fa fa-cog fa-spin"></i>');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('/blogs.html') }}',
                type: 'post',
                data: {page: page},
                dataType: 'json',
                success: function (response) {
                    var data = response.data;
                    var html = '';
                    for (i in data) {
                        html += li.replace(/__url__/, data[i].url).
                            replace(/__name__/, data[i].name).
                            replace(/__avatar__/, data[i].avatar).
                            replace(/__date__/, data[i].date).
                            replace(/__message__/, data[i].message);
                    }

                    if (data.length <= 0) {
                        end = true;
                        $('#show-more').attr('disabled', true).html('我也是有底线的~');
                    } else {
                        page++;
                        $('#show-more').attr('disabled', false).html('显示更多 <i class="fa fa-angle-down"></i>');
                    }

                    $('#normal').append(html);
                    $("img").lazyload();
                },
                complete: function () {
                    loading = false;
                },
                error: function () {
                    end = true;
                    $('#show-more').attr('disabled', true).html('出现了异常，请稍后再试');
                }
            });
        }
    }

    $(window).scroll(function() {
        var offset = $("#abnormal").offset().top - 60; // 减去异常名单标题高度
        if (offset >= $(window).scrollTop() && offset < ($(window).scrollTop() + $(window).height())) {
            more();
        }
    });

    $('#show-more:not(disabled)').click(function () {
        more();
    });
</script>
@endsection
