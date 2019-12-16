<style>
    .box-body {
        display: flex;
        flex-direction: column;
        height: 500px;
        width: 100%;
        overflow: auto;
    }
    iframe {
        width: 100%;
        height: 100%;
    }
</style>
<button type="button" id="start" class="btn btn-primary btn-lg btn-block" style="margin-bottom: 1rem">
    点击开始检测
</button>
<div class="row">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">检测进度 <small>已检测 <span id="normal-num">0</span> 个</small></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
                <iframe id="check-url" src="" frameborder="0"></iframe>
            </div>
            <!-- /.box-footer -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">异常博客 <small>共 <span id="abnormal-num">0</span> 个</small></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>

            <!-- /.box-header -->
            <div class="box-body" id="errors">

            </div>
            <!-- /.box-footer -->
        </div>
    </div>
</div>

<script>
    $(function () {
        var url = "{{ url('/admin/check?start=true') }}";
        var $start = $('#start');
        var $iframe = $('iframe#check-url');
        $start.click(function () {
            if (!this.disabled) {
                $iframe.attr('src', url + '&t=' + new Date().getTime());
                $('#errors').html('');
                $(this).html('<i class="fa fa-cog fa-spin"></i> 检测中，请勿关闭窗口').attr('disabled', true);
            }
        });

        setInterval(function() {
            // 滚动到底部
            $('#errors').animate({scrollTop: $('#errors').prop("scrollHeight")}, 1000);
        }, 3000);
    })
</script>
