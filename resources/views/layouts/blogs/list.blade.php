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
                @if(isset($blogs[1]))
                    @foreach($blogs[1] as $item)
                    <li>
                        <a href="{{ url("/blog/{$item->id}.html") }}" target="_blank" rel="noopener" class="item" title="{{ $item->message }}">
                            <img src="{{ gravatar($item->email) }}" alt="">
                            <div class="meta">
                                <h4 class="name">{{ $item->name }}</h4>
                                <span class="date"><span class="str">签约时间: </span>{{ $item->adopted_at->format('Y-m-d') }}</span>
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
                @if(isset($blogs[3]))
                    @foreach($blogs[3] as $blog)
                        <li>
                            <a href="{{ url("/blog/{$blog->id}.html") }}" target="_blank" rel="noopener" class="item gray" title="{{ $blog->message }}">
                                <img src="{{ gravatar($blog->email) }}" alt="">
                                <div class="meta">
                                    <h4 class="name">{{ $blog->name }}</h4>
                                    <span class="date"><span class="str">签约时间: </span>{{ $blog->adopted_at->format('Y-m-d') }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>

        </section>

    </article>
@endsection
