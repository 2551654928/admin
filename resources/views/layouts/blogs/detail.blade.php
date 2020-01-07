@extends('layouts.app')

@section('title', "【{$blog->name}】十年之约")

@section('description', \Illuminate\Support\Str::limit($blog->message, 190))

@section('content')
    <!-- Main -->
    <article id="main">

        <header class="special container">
            <span class="icon fa-calendar"></span>
            <h2><strong>【{{ $blog->name }}】十年之约</strong></h2>
        </header>

        <!-- One -->
        <section class="wrapper style4 container">

            <!-- Content -->
            <div class="content">
                <section class="adapro">

                    <div class="cleft">
                        <img src="{{ gravatar($blog->email) }}">
                        <h2 style="text-align:center">{{ $blog->name }}</h2>
                        <p>博主寄语: {{ $blog->message }}</p>
                        <a href="{{ $blog->link }}" target="_blank">
                            <div class="linkbtn">查看TA的网站</div>
                        </a>
                        @if($blog->status == 4)
                            <div class="ribbon">异 常</div>
                        @endif
                    </div>
                    <div class="cright">
                        @if(!$blog->datelines->isEmpty())
                            <h2>大事记</h2>
                            @foreach($blog->datelines as $dateline)
                            <div class="item">
                                <blockquote><p>{{ $dateline->join_date }}</p></blockquote>
                                <p>{!! str_replace(["\r\n", PHP_EOL], ['<br/>', '<br/>'], $dateline->content) !!}</p>
                            </div>
                            @endforeach
                        @else
                            <div style="text-align: center">暂无大事记</div>
                        @endif
                    </div>

                </section>
            </div>
        </section>

        @component('comment', ['type' => 'blog', 'data' => $blog]) @endcomponent
    </article>

    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        window.onload = function () {
            $('.cright .item').each(function () {
                $content = $(this).find('> p');
                $content.html(marked($content.html()))
            })
        }
    </script>
@endsection
