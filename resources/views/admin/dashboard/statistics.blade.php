<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $data['total'] }}</h3>

                <p>博客总数</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ url('admin/blogs') }}" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-aqua-active">
            <div class="inner">
                <h3>{{ $data['passed'] }}</h3>

                <p>已通过</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ url('admin/blogs') }}" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-black-gradient">
            <div class="inner">
                <h3>{{ $data['refuse'] }}</h3>

                <p>未通过</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ url('admin/blogs') }}" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $data['pending'] }}</h3>

                <p>待审核</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/blogs') }}" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
