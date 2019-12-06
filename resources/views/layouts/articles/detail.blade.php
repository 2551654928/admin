@extends('layouts.app')

@section('title', $article->title . ' | 十年之约')

@section('content')
    <!-- Main -->
    <article id="main">

        <header class="special container">
            <span class="icon solid fa-file-text"></span>
            <h2><strong>{{ $article->title }}</strong></h2>
            <p>
                {{ $article->name }} 发布于
                <time style="border-bottom: 1px dashed rgb(204, 204, 204);" title="{{ $article->created_at }}">
                    {{ $article->created_at->diffForHumans() }}
                </time> &middot;
                共 {{ $article->read_num_string }} 次点击
            </p>
        </header>

        <!-- One -->
        <section class="wrapper style4 container">

            <!-- Content -->
            <div class="content detail">
                {!! $article->content !!}
            </div>

        </section>

        @component('comment', ['type' => 'article', 'data' => $article]) @endcomponent
    </article>
@endsection
