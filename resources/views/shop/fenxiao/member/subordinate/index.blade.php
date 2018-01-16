@extends('layouts.my_page')
@section('content')
    <div class="row">
        <div class="col-sm-2">
            <a href="javascript:history.go(-1);" class="btn btn-default">
                <i class="glyphicon glyphicon-backward"></i> 返回上一页
            </a>
        </div>
        <div class="col-sm-12"></div>
        <div class="col-md-4"> 
            <div style="margin:20px 50px;">
                <img src="" id="headimgurl" style="width:170px;height:170px;border-radius: 50%;padding:1px;" onerror="">
            </div> 	
        </div>
        <div class="col-md-8">
            <div style="height: 35px; line-height: 35px;">
                <span style="width:100px;text-align: right;">昵称：</span>
                <span style="width:150px;text-align: center;" id="nickname"></span>
            </div>
             <div style="height: 35px; line-height: 35px;">
                <span style="width:100px;text-align: right;">姓名：</span>
                <span style="width:150px;text-align: center;" id="full_name"></span>
            </div>
            <div style="height: 35px; line-height: 35px;">
                <span style="width:100px;text-align: right;">手机号：</span>
                <span style="width:150px;text-align: center;" id="mobile"></span>
            </div>
            <div style="height: 35px; line-height: 35px;">
                <span style="width:100px;text-align: right;">微信号：</span>
                <span style="width:150px;text-align: center;" id="wechat"></span>
            </div>
            <div style="height: 35px; line-height: 35px;">
                <span style="width:100px;text-align: right;">下级人数：</span>
                <span style="width:150px;text-align: center;">
                    总计<span id="referrals">0</span>人，一级：<span id="subordinate_nums_level_one">0</span>人，二级<span id="subordinate_nums_level_two"></span>人，三级<span id="subordinate_nums_level_three">0</span>人
                </span>
            </div>
        </div>
         <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#one" data-toggle="tab" aria-expanded="true">一级</a></li>
                    <li class=""><a href="#two" data-toggle="tab" aria-expanded="false">二级</a></li>
                    <li class=""><a href="#three" data-toggle="tab" aria-expanded="false">三级</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="one">
                        @include('shop.fenxiao.member.subordinate.one')
                    </div>
                    <div class="tab-pane" id="two">
                        @include('shop.fenxiao.member.subordinate.two')
                    </div>
                     <div class="tab-pane" id="three">
                        @include('shop.fenxiao.member.subordinate.three')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
<script type="text/javascript">
	$(document).ready(function () {
        $.getJSON('/ajax/shop/fenxiao/member/list/'+{{ $id }}+ '/0',function (json) {
            var personData = json.data.rows[0];
            if(personData) {
                $('#nickname').text(personData.nickname);
                $('#headimgurl').attr('src',personData.headimgurl);
                $('#full_name').text(personData.full_name);
                $('#mobile').text(personData.mobile);
                $('#wechat').text(personData.wechat);
                $('#referrals').text(personData.referrals);
            } else {
                bootbox.alert({ 
                    title: "<span class='text-danger'>错误</span>",
                    message: "数据不存在",
                    callback: function(){
                        location.pathname = '/shop/fenxiao/member';
                    }
                });
            }
        });
    });
</script>
@endpush