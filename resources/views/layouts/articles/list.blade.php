@extends('layouts.app')

@section('title', "{$typeText} | 十年之约")

@section('content')
    <!-- Main -->
    <article id="main">

        <header class="special container">
            <span class="icon solid fa-file-text"></span>
            <h2><strong>{{ $typeText }}</strong></h2>
        </header>

        <!-- One -->
        <section class="wrapper style3 container special">

            <div class="row">
                @foreach($articles as $article)
                    <div class="col-6 col-12-narrower">

                        <section class="news">
                            <header>
                                <h3>{{ $article->title }}</h3>
                            </header>
                            <p class="content">
                                {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 180) }}
                            </p>
                            <center><a href="{{ url("{$article->type}/{$article->id}.html") }}">查看全文</a></center>
                            <p></p>
                        </section>

                    </div>
                @endforeach
            </div>

            {!! $articles->links() !!}

        </section>

    </article>
@endsection
