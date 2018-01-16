<style type="text/css">
.col-sm-1 {
    padding-top: 5px;
}
/*#idLogo {
    padding-top: 5px;
}*/
</style>

@extends('layouts.box_base')
@include('layouts.vue_base')
@section('box-title')
    平台信息设置
@stop
@section('box-body')
    <style>
        .required:before {
            content: '*';
            font-size: 18px;
            color: #e01212;
        }
    </style>
    <form role = "form" id="form" class="form-horizontal">
        {{--<div class = "form-group">--}}
            {{--<label class="col-sm-2 control-label" for = "platform_name">小程序名称：</label>--}}
            {{--<div class="col-sm-2">--}}
                {{--<input type = "text" class = "form-control"--}}
                    {{--name="title" value = "{{$title}}">--}}
                {{--</div>--}}
        {{--</div>--}}
        <div class = "form-group">
            <label class="col-sm-2 control-label required" for = "platform_title">商城名称：</label>
            <div class="col-sm-2 ">
                <input type="text" class="form-control " name="name" value = "{{$name}}" required></input>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label required">平台logo：</label>
            <div class="col-sm-5 ">
                <div id='app'>
                    <upload url='/upload/image_image'  name="logo_url" xthumb="{{ $logo_url }}" required></upload>
                </div>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class = "form-group">
            <label class="col-sm-2 control-label required" for = "tel-first">客服热线：</label>
            <div class="col-sm-2 ">
                <input type="number" class="form-control" id = "tel-first"
                    name="hotline1" value = "{{$hotline1}}" required></input>
            </div>
        </div>
        <!-- <div class = "form-group">
            <label class="col-sm-2 control-label" for = "tel-sec">客服热线：</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" id = "tel-sec"
                    name="hotline2" value = "{{$hotline2}}"></input>
            </div>
        </div> -->
        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <button class="btn btn-primary" id="submit">保存</button>
            </div>
        </div>
    </form>
@stop

@section('js')
<script>
$(document).ready(function () {
    $('#form').validator().on('submit', function (e) {
        if(!e.isDefaultPrevented()){
            e.preventDefault();
            var data = $(e.target).serialize();
            $('#submit').attr('disabled', 'disabled');
            $('#submit').text('保存中...');
        }

        $.post('/ajax/shop/set/update', data, function (json) {
            if(json.code == 200 ){
                bootbox.alert({
                    title: '<span class="text-success">成功</span>',
                    message:'更新成功',
                });
                $('#submit').removeAttr('disabled');
                $('#submit').text('保存');
            }else if(json.code == 401){
                location.pathname = '/login';
            }else{
                bootbox.alert({
                    title: '<span class="text-danger">错误</span>',
                    message: json.error,
                });
                $('#submit').removeAttr('disabled');
                $('#submit').text('保存');
            }
        }, 'json')

    });
});
</script>
@stop
