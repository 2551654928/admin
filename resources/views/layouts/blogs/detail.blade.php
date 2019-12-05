@extends('layouts.app')

@section('title', "【{$blog->name}】十年之约")

@section('content')
    <!-- Main -->
    <article id="main">

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
                        </div>
                        <div class="cright">
                            <h2>大事记</h2>
                            <div class="item">
                                <blockquote><p>2017/11/14</p></blockquote>
                                <p>加入十年之约</p>
                            </div>
                            <div class="item">
                                <blockquote><p>2017/11/14</p></blockquote>
                                <p>加入十年之约</p>
                            </div>
                            <div class="item">
                                <blockquote><p>2017/11/14</p></blockquote>
                                <p>加入十年之约</p>
                            </div>
                        </div>

                    </section>
                </div>
            </section>
        </article>

    </article>
@endsection
