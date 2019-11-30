@extends('layouts.app')

@section('title', '十年之约')

@section('content')
    <!-- Main -->
    <article id="main">

        <header class="special container">
            <span class="icon solid fa-file-text"></span>
            <h2><strong>{{ $article->title }}</strong></h2>
            <p>
                {{ $article->name }} 发布于 <time style="border-bottom: 1px dashed rgb(204, 204, 204);" title="{{ $article->created_at }}">{{ $article->created_at->diffForHumans() }}</time> &middot;
                共 {{ $article->read_num_string }} 次点击
            </p>
        </header>

        <!-- One -->
        <section class="wrapper style4 container">

            <!-- Content -->
            <div class="content">
                {!! $article->content !!}
            </div>

        </section>

        <!-- Two -->
        <section class="wrapper style4 special container">

            <!-- Content -->
            <div class="content">
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
            </div>

        </section>
    </article>
@endsection
