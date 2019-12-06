<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>Comment notice</title>
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
    .detail-container>p.detail-reply{margin:18px 0;padding:10px 15px;border:0 solid #ddd;background-color:#f5f5f5}
    .detail-container>p.detail-content,.detail-container>p.detail-reply{white-space:normal;font-size:14px;line-height:18px;word-break:break-all}
</style>
<main>
    <h2>
        <span>&gt; </span>
        您({{ $name }})发布的{{ $type }}
        <a href="{{ url()->previous() }}" target="_blank" rel="noopener"><{{ $title }}></a>
        有了新的评论
    </h2>
    <div class="detail-container">
        <p class="detail-date">
            时间：<span>{{ $comment->created_at }}</span>
        </p>
        <p><strong>{{ ($comment->is_admin ? '[管理员] ' : '') . $comment->name }}</strong> 评论说：</p>
        <p class="detail-content">{!! $comment->content !!}</p>
        <p class="info">
            您可以点击<a href="{{ url()->previous().'#comments-container' }}" target="_blank" rel="noopener">
                查看回复的完整內容</a>。<br>
            本邮件为自动发送，请勿直接回复，如有疑问，请联系
            <a href="mailto:admin@foreverblog.cn" target="_blank" rel="noopener">admin@foreverblog.cn</a>
        </p>
    </div>
</main>
</body>
</html>
