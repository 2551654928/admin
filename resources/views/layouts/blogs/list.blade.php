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

            <ul>
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

            <header class="container">
                <h2><strong>异常名录</strong></h2>
            </header>

            <ul>
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

        </section>

    </article>
@endsection

@section('js')
<script src="https://cdn.bootcss.com/jquery_lazyload/1.9.7/jquery.lazyload.min.js"></script>
<script>
    $("img").lazyload({
        // effect: "fadeIn"
    });
</script>
@endsection
