<!DOCTYPE HTML>
<!--
	Twenty by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="zh-CN" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="/assets/css/main.css" />
    <noscript><link rel="stylesheet" href="/assets/css/noscript.css" /></noscript>
</head>
<body class="index is-preload">
<div id="page-wrapper">

    <!-- Header -->
    <header id="header" class="alt">
        <h1 id="logo"><a href="{{ url('/') }}">十年之约</a></h1>
        <nav id="nav">
            <ul>
                <li class="current"><a href="{{ url('/') }}">首页</a></li>
                <li class="submenu">
                    <a href="#">更多</a>
                    <ul>
                        <li><a href="right-sidebar.html">公告</a></li>
                        <li><a href="left-sidebar.html">成员</a></li>
                        <li><a href="right-sidebar.html">动态</a></li>
                        <li><a href="no-sidebar.html">留言</a></li>
                        <li><a href="contact.html">捐赠</a></li>
                        <li><a href="contact.html">关于</a></li>
                    </ul>
                </li>
                <li><a href="#" class="button primary">申请加入</a></li>
            </ul>
        </nav>
    </header>

    @yield('content')

    <!-- CTA -->
    <section id="cta">

        <header>
            <h2>Ready to do <strong>something</strong>?</h2>
            <p>十年之约是一个非盈利项目，如果你想帮助这样一个活动更好的走下去，下面的按钮或许适合你。</p>
        </header>
        <footer>
            <ul class="buttons">
                <li><a href="https://www.foreverblog.cn/donate.html" class="button special">捐助</a></li>
            </ul>
        </footer>

    </section>

    <!-- Footer -->
    <footer id="footer">

        <ul class="icons">
            <li><a href="#" class="icon brands circle fa-twitter"><span class="label">Twitter</span></a></li>
            <li><a href="#" class="icon brands circle fa-facebook-f"><span class="label">Facebook</span></a></li>
            <li><a href="#" class="icon brands circle fa-google-plus-g"><span class="label">Google+</span></a></li>
            <li><a href="#" class="icon brands circle fa-github"><span class="label">Github</span></a></li>
            <li><a href="#" class="icon brands circle fa-dribbble"><span class="label">Dribbble</span></a></li>
        </ul>

        <ul class="copyright">
            <li>© 十年之约 2017-2019 </li> <li><a href="http://www.beian.miit.gov.cn/">蜀ICP备15021049号-3</a></li>&nbsp; <li><a href="http://www.jetli.com.cn">博客志：优秀博客</a></li>
        </ul>

    </footer>

</div>

<!-- Scripts -->
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/jquery.dropotron.min.js"></script>
<script src="/assets/js/jquery.scrolly.min.js"></script>
<script src="/assets/js/jquery.scrollex.min.js"></script>
<script src="/assets/js/browser.min.js"></script>
<script src="/assets/js/breakpoints.min.js"></script>
<script src="/assets/js/util.js"></script>
<script src="/assets/js/main.js"></script>

</body>
</html>
