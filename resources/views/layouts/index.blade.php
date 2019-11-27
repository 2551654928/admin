@extends('layouts.app')

@section('title', '十年之约')

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
                    <li><a href="https://www.foreverblog.cn/links.html" class="button fit scrolly">查看成员</a></li>
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
                    <center><li><a href="http://join.foreverblog.cn" class="button">申请加入</a></li></center>
                </ul>
            </footer>
        </section>

        <!-- Two -->
        <section class="wrapper style3 container special">

            <header class="major">
                <h2>最新公告</h2>
            </header>

            <div class="row">
                <div class="col-6 col-12-narrower">

                    <section class="news">
                        <header>
                            <h3>“十年之约”公约</h3>
                        </header>
                        <p class="content">（2018 年 5 月 24 日第二次修订）
                            在您加入“十年之约”之前，请承诺您会仔细阅读并遵守如下条文中的规定和要求。第一条“十年之约”是由“十年之约”项目组维护的非营利性、自愿加入的博客活动...</p>
                        <center><a href="https://www.foreverblog.cn/archives/xinbanfankui.html">查看全文</a></center>
                        <p></p>
                    </section>

                </div>
                <div class="col-6 col-12-narrower">

                    <section class="news">
                        <header>
                            <h3>关于十年之约网站改版中遇到的一些问题</h3>
                        </header>
                        <p class="content">很高兴在5月20日成功上线新版皮肤及表单平台，经过5天的实际应用中遇到的一些问题，下面统一说明一下。1.点击成员列表中的成员卡片，自动跳转回成员列表的问题。答复:鉴于十年之约并不是导航类网站，所...</p>
                        <center><a href="https://www.foreverblog.cn/archives/xinbanfankui.html">查看全文</a></center>
                        <p></p>
                    </section>

                </div>
                <div class="col-6 col-12-narrower">

                    <section class="news">
                        <header>
                            <h3>关于近期比较集中反馈的问题 的回复</h3>
                        </header>
                        <p class="content">鉴于近期有很多博友反馈关于审核时间过长，提交后未审核的问题。现统一答复一下。1.博友从提交，到项目组审核的周期大约为15个 非工作日。因为目前项目组雇佣不到免费的专职人员处理该项目。2.从审核通...</p>
                        <center><a href="https://www.foreverblog.cn/archives/xinbanfankui.html">查看全文</a></center>
                        <p></p>
                    </section>

                </div>
                <div class="col-6 col-12-narrower">

                    <section class="news">
                        <header>
                            <h3>关于变更十年之约官方群及相关事项的通知</h3>
                        </header>
                        <p class="content">鉴于前官方群群主独断专行，在未与“十年之约项目组”协商讨论，并在项目组不知情的情况下擅自另行建立并冒用十年之约网站，在未经项目组及十年之约成员同意的情况下，使用十年之约的成员资料和数据。项目组经...</p>
                        <center><a href="https://www.foreverblog.cn/archives/xinbanfankui.html">查看全文</a></center>
                        <p></p>
                    </section>

                </div>
            </div>

            <footer class="major">
                <ul class="buttons">
                    <li><a href="#" class="button">查看更多公告</a></li>
                </ul>
            </footer>

        </section>

        <!-- Three -->
        <section class="wrapper style1 container special">
            <header class="major">
                <h2>最新成员</h2>
            </header>

            <div class="row">
                <div class="col-4 col-12-narrower">

                    <section>
                        <img class="avatar" src="https://secure.gravatar.com/avatar/abfa24634b0283431f23247675bd59df?s=96&r=G&d=">
                        <header>
                            <h3>雨落泪尽</h3>
                        </header>
                        <p class="content">每一个前十年都想不到后十年我会演变成何等模样，可知人生无常，没有什么规律，没有什么必然。</p>
                    </section>

                </div>
                <div class="col-4 col-12-narrower">

                    <section>
                        <img class="avatar" src="https://q2.qlogo.cn/headimg_dl?dst_uin=1591788658&spec=100">
                        <header>
                            <h3>熊二哈的猫窝</h3>
                        </header>
                        <p class="content">我很向往未来，却也害怕未来，但我们总得面对不是吗？期待十年后的自己。</p>
                    </section>

                </div>
                <div class="col-4 col-12-narrower">

                    <section>
                        <img class="avatar" src="https://www.gravatar.com/avatar/44f4221a1b501907c37a9c543427651e?s=96&d=mp&r=g">
                        <header>
                            <h3>吾爱BUG</h3>
                        </header>
                        <p class="content">十年，足以改变很多。</p>
                    </section>

                </div>
            </div>
        </section>

    </article>
@endsection
