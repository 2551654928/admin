<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">最新评论</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>

    <!-- /.box-header -->
    <div class="box-body dependencies">
        <div class="table-responsive">
            <table class="table table-striped">
                @foreach($news as $new)
                    <tr>
                        <td width="100%">
                            {{ $new['content'] }}
                        </td>
                        <td><span class="label label-primary">{{ $new['name'] }}</span></td>
                    </tr>
                @endforeach
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer text-center">
        <a href="{{ url('admin/comments') }}" class="uppercase">查看全部</a>
    </div>
    <!-- /.box-footer -->
</div>
