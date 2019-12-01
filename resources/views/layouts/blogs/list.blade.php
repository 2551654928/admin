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
                @for($i = 0; $i < 30; $i++)
                    <li>
                        <a href="" target="_blank" rel="noopener" class="item">
                            <img src="{{ gravatar('1591788658@qq.com') }}" alt="">
                            <div class="meta">
                                <h4 class="name">熊二哈</h4>
                                <span class="date"><span class="str">签约时间: </span>2019-01-04</span>
                            </div>
                        </a>
                    </li>
                @endfor
            </ul>

            <header class="container">
                <h2><strong>异常名录</strong></h2>
            </header>

            <ul>
                @for($i = 0; $i < 30; $i++)
                    <li>
                        <a href="" target="_blank" rel="noopener" class="item gray">
                            <img src="{{ gravatar('1591788658@qq.com') }}" alt="">
                            <div class="meta">
                                <h4 class="name">熊二哈</h4>
                                <span class="date"><span class="str">签约时间: </span>2019-01-04</span>
                            </div>
                        </a>
                    </li>
                @endfor
            </ul>

        </section>

    </article>
@endsection
