<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<body>
<style>
    main{margin:50px auto;padding:0 15px 9pt;width:600px;border-top:2px solid #12addb;background-color:#fff;box-shadow:0 1px 3px #aaa;color:#555;font-size:9pt;font-family:Century Gothic,Trebuchet MS,Hiragino Sans GB,微软雅黑,Microsoft Yahei,Tahoma,Helvetica,Arial,SimSun,sans-serif;line-height:180%}
    main h2{padding:13px 0 10px 8px;border-bottom:1px solid #ddd;font-weight:400;font-size:14px}
    main h2 span{color:#12addb;font-weight:700}
    main a{color:#12addb;text-decoration:none}
    .detail-container{margin-top:18px;padding:0 9pt}
    .detail-container>p.detail-date>span{border-bottom:1px dashed #ccc}
    .detail-container>p.detail-date>span>span{position:relative;border-bottom:1px dashed #ccc}
    .detail-container>p.detail-content{margin:18px 0;padding:10px 15px;border:0 solid #ddd;background-color:#f5f5f5}
    .detail-container>p.detail-content img,.detail-container>p.detail-reply img{margin:0 1px;width:20px;height:20px;vertical-align:middle}
    .detail-container>p.detail-content img.emoji,.detail-container>p.detail-reply img.emoji{position:relative;top:-1px}
    .detail-container>p.detail-content{white-space:normal;font-size:14px;line-height:18px;word-break:break-all}
</style>
<main>
    <h2>
        {{ $subtitle }}
    </h2>
    <div class="detail-container">
        <p class="detail-date">
            时间：<span>{{ date('Y-m-d H:i:s') }}</span>
        </p>
        <p class="detail-content">{!! $content !!}</p>
        <p class="info">十年之约项目组 team@foreverblog.cn</p>
    </div>
</main>
</body>
</html>
