@extends('layouts.store_base')
@section('nav_title')
    <ul class="nav navbar-nav">
        <li><a href="/store">选择店铺</a></li>
    </ul>
@stop
@section('box_right_button')
    <div class="text-right" style="margin: 10px;">
        <a href="/store/add">创建新店铺</a>
    </div>
@stop
@section('content')
    <section class="content" id="noStore" style="display: none;">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-danger" style="margin-top: 100px; padding: 20px;">
                    <div class="inner" style="margin: 10px;">
                        <p class="text-center">您还没有创建或加入任何店铺</p>
                        <a href="/store/add">
                            <button class="btn btn-success center-block">创建店铺</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content" id="storeList" style="display: none;">
        <div class="row">
            <div class="col-md-12">
                <h5>我管理的店铺</h5>
            </div>
            <div class="col-md-12" id="storeWrap">
                <a href="/home" class="col-md-3">
                    <div class="box box-info" style="cursor: pointer;">
                        <div class="small-box">
                            <div class="inner">
                                <h4>150</h4>
                                <p>
                                    <span>New Orders</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
@stop
@section('js')
<script>
    $(document).ready(function () {
        $.getJSON('/ajax/store/list',function (json) {
            if(json.data.length > 0){
                var box = getStoreBox(json.data).join(' ');
                $('#storeWrap').html(box);
                $('#storeList').show();
            }else{
                $('#noStore').show();
            }
        });
        function getStoreBox(data) {
            return $.map(data, function (item) {
                return '<a href="/home/?store_id=' + item.id +
                    '" class="col-md-3 text-muted">' +
                    '<div class="box box-info" style="cursor: pointer;">' +
                    '<div class="small-box">' +
                    '<div class="inner">' +
                    '<h4>' + item.name + '</h4>' +
                    '<p>' +
                    '<span>' + item.contact_wx + '</span>' +
                    '</p>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</a>';
            });
        }
    })
</script>
@stop