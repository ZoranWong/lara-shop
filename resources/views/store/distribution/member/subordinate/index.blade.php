@extends('store.distribution.member.index')
@section('member_content')
    <style>
        .header-box>div{margin:20px 50px;}
        .header-box>div>img{width:170px;height:170px;border-radius: 50%;padding:1px}
        .head-bar>div{height: 35px; line-height: 35px;}
        .head-bar>div>span.part1{width:100px;text-align: right;}
        .head-bar>div>span.part2{width:150px;text-align: center}
    </style>
    <div class="row">
        <div class="col-md-4 header-box">
            <div>
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAIAAAACCAYAAABytg0kAAAAE0lEQVQImWN88+HrfwYgYGKAAgA7LwPUZUzZKQAAAABJRU5ErkJggg==" id="headimgurl"  onerror="">
            </div> 	
        </div>
        <div class="col-md-8 head-bar">
            <div >
                <span class="part1" >昵称：</span>
                <span class="part2" id="nickname"></span>
            </div>
             <div >
                <span class="part1">姓名：</span>
                <span class="part2" id="full_name"></span>
            </div>
            <div >
                <span class="part1">手机号：</span>
                <span class="part2" id="mobile"></span>
            </div>
            <div >
                <span class="part1">微信号：</span>
                <span class="part2" id="wechat"></span>
            </div>
            <div >
                <span class="part1">下级人数：</span>
                <span class="part2">
                    总计<span id="referrals">0</span>人
                    <span class="subordinate_nums_level_one">
                        ，一级：<span id="subordinate_nums_level_one">0</span>人
                    </span>
                    <span class="subordinate_nums_level_two">
                        ，二级<span id="subordinate_nums_level_two"></span>人
                    </span>
                    <span class="subordinate_nums_level_three">
                        ，三级<span id="subordinate_nums_level_three">0</span>人
                    </span>
                </span>
            </div>
        </div>
         <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#one" data-toggle="tab" aria-expanded="true" id="level_lower_one">一级</a></li>
                    <li class=""><a href="#two" data-toggle="tab" aria-expanded="false" id="level_lower_two">二级</a></li>
                    <li class=""><a href="#three" data-toggle="tab" aria-expanded="false" id="level_lower_thr">三级</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="one">
                        @include('store.distribution.member.subordinate.one')
                    </div>
                    <div class="tab-pane" id="two">
                        @include('store.distribution.member.subordinate.two')
                    </div>
                     <div class="tab-pane" id="three">
                        @include('store.distribution.member.subordinate.three')
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
	window.pageInit = function () {
        var fans_id = {{ $id }};
        $.post('/ajax/fenxiao/member/list/memberInfo', {'fans_id': fans_id}, function (json)
        {
            if (json.code == 200) {
                var user_info = json.data;
                $('#nickname').text(user_info.nickname);
                $('#headimgurl').removeAttr('src');
                $('#headimgurl').attr('src',user_info.head_image);
                $('#full_name').text(user_info.full_name);
                $('#mobile').text(user_info.mobile);
                $('#wechat').text(user_info.wechat);
                //  一级下级数量
                var level_one = $('#subordinate_nums_level_one').text();
                //  二级下级数量
                var level_two = $('#subordinate_nums_level_two').text();
                //  三级下级数量
                var level_thr = $('#subordinate_nums_level_three').text();
                //  用户层级
                if (user_info.level == 0) {
                    level_one = 0;
                    level_two = 0;
                    level_thr = 0;
                    //  按照当前层级对应展示/隐藏
                    $('.subordinate_nums_level_one').hide();
                    $('.subordinate_nums_level_two').hide();
                    $('.subordinate_nums_level_three').hide();
                    $("#level_lower_one").hide();
                    $("#one").empty();
                    $("#level_lower_two").hide();
                    $("#two").empty();
                    $("#level_lower_thr").hide();
                    $("#three").empty()
                } else if (user_info.level == 1) {
                    $('.subordinate_nums_level_two').hide();
                    $('.subordinate_nums_level_three').hide();
                    level_two = 0;
                    level_thr = 0;
                    $("#level_lower_two").hide();
                    $("#two").empty();
                    $("#level_lower_thr").hide();
                    $("#three").empty()
                } else if (user_info.level == 2) {
                    $('.subordinate_nums_level_three').hide();
                    level_thr = 0;
                    $("#level_lower_thr").hide();
                    $("#three").empty();
                }
                //  下级人数总和
                var level_total = parseInt(level_one) +parseInt(level_two) +parseInt(level_thr);
                $("#referrals").empty();
                $("#referrals").append(level_total);
            } else if (json.code == 404) {
                bootbox.alert({
                    title: '<span class="text-danger">ERROR!</span>',
                    message: json.error
                });
            }
        });
    };
</script>
@endpush