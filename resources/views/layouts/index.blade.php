@extends('layouts.app')

@section('title', '十年之约')

@section('header-class', 'alt')

@section('content')
    <!-- Banner -->
    <section id="banner">

        <!--
            ".inner" is set up as an inline-block so it automatically expands
            in both directions to fit whatever's inside it. This means it won't
            automatically wrap lines, so be sure to use line breaks where
            appropriate (<br />).
        -->
        <div class="inner">

            <header>
                <h2>十年之约</h2>
            </header>
            <p>一个人的寂寞，一群人的狂欢。</p>
            <footer>
                <ul class="buttons vertical">
                    <li><a href="{{ url('/blogs.html') }}" class="button fit scrolly">查看成员</a></li>
                </ul>
            </footer>
        </div>

    </section>

    <!-- Main -->
    <article id="main">

        <header class="special container">
            <span class="icon solid fa-chart-bar"></span>
            <h2>十年之约，即从加入这个活动起，我们的博客十年不关闭，保持更新和活力！</h2>
        </header>

        <!-- One -->
        <section class="wrapper style2 container special-alt">


            <header>
                <center><h2>Join us</h2></center>
            </header>
            <p></p><center>十年之约官网将记录所有成员的加入时间、履约情况、博客大事记、博客陨落时间等信息！</center><p></p>
            <footer>
                <ul class="buttons">
                    <center><li><a href="{{ url('/treaty.html') }}" class="button">申请加入</a></li></center>
                </ul>
            </footer>
        </section>

        <!-- Two -->
        <section class="wrapper style3 container special">

            <header class="major">
                <h2>最新公告</h2>
            </header>

            <div class="row">
                @foreach($notices as $notice)
                <div class="col-6 col-12-narrower">

                    <section class="news">
                        <header>
                            <h3>{{ $notice->title }}</h3>
                        </header>
                        <p class="content">
                            {{ \Illuminate\Support\Str::limit(strip_tags($notice->content), 180) }}
                        </p>
                        <center><a href="{{ url("notice/{$notice->id}.html") }}">查看全文</a></center>
                        <p></p>
                    </section>

                </div>
                @endforeach
            </div>

            <footer class="major">
                <ul class="buttons">
                    <li><a href="{{ url('/notices.html') }}" class="button">查看更多公告</a></li>
                </ul>
            </footer>

        </section>

        <!-- Three -->
        <section class="wrapper style1 container special">
            <header class="major">
                <h2>最新成员</h2>
            </header>

            <div class="row">
                @foreach($blogs as $blog)
                <div class="col-4 col-12-narrower">

                    <section>
                        <img class="avatar" src="{{ gravatar($blog->email) }}">
                        <header>
                            <h3>{{ $blog->name }}</h3>
                        </header>
                    </section>

                </div>
                @endforeach
            </div>
        </section>

    </article>
@endsection
