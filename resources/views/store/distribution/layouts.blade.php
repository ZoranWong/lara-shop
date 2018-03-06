<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="myTab">
                <li @if ($active == "index") class="active" @endif ><a href="/distribution?store_id={{ $store_id }}">首页</a></li>
                <li @if ($active == "member") class="active" @endif ><a href="/distribution/member?store_id={{ $store_id }}">分销商管理</a></li>
                <li @if ($active == "cash") class="active" @endif ><a href="/distribution/cash?store_id={{ $store_id }}">提现管理</a></li>
                <li @if ($active == "setting") class="active" @endif ><a href="/distribution/setting?store_id={{ $store_id }}">设置</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    @yield('tab_content')
                </div>
            </div>
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->