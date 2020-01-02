<!DOCTYPE HTML>
<!--
	Twenty by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
    <title>@yield('title', '十年之约')</title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="zh-CN" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="description" content="@yield('description', '一个人的寂寞，一群人的狂欢。')" />
    <meta name="keywords" content="十年之约,个人博客,博客十年之约,博客收录,博客交流,博客展示,独立博客,记录我们的十年" />
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/main.css?ver=20200102" />
    <link rel="stylesheet" href="/assets/css/app.css?ver=20191217" />
    <noscript><link rel="stylesheet" href="/assets/css/noscript.css" /></noscript>
</head>
<body class="index is-preload">
@yield('css')
<div id="page-wrapper">

    <!-- Header -->
    <header id="header" class="@yield('header-class')">
        <h1 id="logo"><a href="{{ url('/') }}">十年之约</a></h1>
        <nav id="nav">
            <ul>
                <li class="current"><a href="{{ url('/') }}">首页</a></li>
                <li class="submenu">
                    <a href="#">更多</a>
                    <ul>
                        <li><a href="{{ url('/notices.html') }}">公告</a></li>
                        <li><a href="{{ url('/articles.html') }}">文章</a></li>
                        <li><a href="http://rss.foreverblog.cn/" target="_blank">动态</a></li>
                        <li><a href="{{ url('/blogs.html') }}">成员</a></li>
                        <li><a href="{{ url('/message.html') }}">留言</a></li>
                        <li><a href="{{ url('/donate.html') }}">捐赠</a></li>
                        <li><a href="{{ url('/about.html') }}">关于</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('/treaty.html') }}" class="button primary">申请加入</a></li>
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
                <li><a href="{{ url('/donate.html') }}" class="button special">捐助</a></li>
            </ul>
        </footer>

    </section>

    <!-- Footer -->
    <footer id="footer">

        <ul class="icons">
            <li><a href="/" class="icon brands circle fa-home"><span class="label">Home</span></a></li>
            <li><a href="https://jq.qq.com/?_wv=1027&k=5CFhYXd" class="icon brands circle fa-qq" target="_blank"><span class="label">QQ</span></a></li>
            <li><a href="{{ url('/about.html') }}" class="icon brands circle fa-flag"><span class="label">Flag</span></a></li>
            <li><a href="https://github.com/foreverblog" class="icon brands circle fa-github" target="_blank"><span class="label">Github</span></a></li>
            <li><a href="{{ url('/donate.html') }}" class="icon brands circle fa-money"><span class="label">Money</span></a></li>
        </ul>

        <ul class="copyright">
            <li>© 十年之约 2017 - {{ date('Y', time()) }} </li> <li><a href="http://www.beian.miit.gov.cn/">蜀ICP备15021049号-3</a></li>&nbsp; <li><a href="http://www.jetli.com.cn">博客志：优秀博客</a></li>
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
@yield('js')
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?0c7836ac8678d921d1d4ad74e6affa81";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);

        var bp = document.createElement('script');
        var curProtocol = window.location.protocol.split(':')[0];
        if (curProtocol === 'https') {
            bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
        } else {
            bp.src = 'http://push.zhanzhang.baidu.com/push.js';
        }
        s.parentNode.insertBefore(bp, s);
    })();
</script>
</body>
</html>
