@extends('store.distribution.setting.index')
@section('setting_content')
<style type="text/css">
    fieldset{padding:.35em .625em .75em;margin:0 2px;border:1px solid silver;border-radius:8px;font-size: 13px;}
    legend{padding:.5em;border:0;width:auto;margin-bottom:10px; font-size: 13px;}
    #cash_setting form #cash_submit{margin:5px 10px 5px 80px;}
    .margin10{margin: 10px;}
    .margin-l-40{ margin-left: 40px;}
 </style>
 <div class="box-body" id = "cash_setting">
    <form class="form-horizontal" id="cash_form" autocomplete="off">
        <div class="form-group ">
            <label class="col-sm-4 control-label margin10">最小提现金额：</label>
            <div class="col-sm-5 margin10">
                <input type="text" name="min_cash_num" class="form-control" placeholder="输入最小提现金额">
                <input type="hidden" name="store_id" class="form-control" value="{{ $store_id }}">
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-6 margin-l-40" ><font color="red">注: 用户提现时必须超过此金额才可提现，单位：元。</font></div>
        </div>
         <div class="form-group">
            <div class="col-sm-10 col-sm-offset-4">
                <button class="btn btn-primary" id="cash_submit">保存修改</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $('#cash_submit').click(function (){
        $.ajax({
            type: "POST",
            url:'/ajax/distribution/commission/cash/setting',
            data:$('#cash_form').serialize(),// 你的formid
            async: false,
            error: function(request) {
                bootbox.alert("操作超时，请稍后重试");
            },
            success: function(json) {
                if(json.code === 200) {
                    bootbox.alert({
                        title: '<span class="text-success">成功</span>',
                        message:'更新成功',
                        callback: function () {
                            location.pathname = "/distribution/setting/cash";
                        }
                    });
                } else if(json.code === 401) {
                    bootbox.alert({
                        title: '<span class="text-danger">失败</span>',
                        message: '由于长时间未进行操作，请进行重新登录',
                        callback: function () {
                            location.pathname = '/login';
                        },
                    });
                } else {
                    bootbox.alert({
                        title: '<span class="text-danger">操作失败</span>',
                        message: json.error
                    });
                }
            }
        });
        return false;
    });
    $(document).ready(function () {
        $.getJSON('/ajax/distribution/commission/cash/setting?store_id={{$store_id}}',function (json) {
            let  data = json.data;
            let selector = '#cash_form input[name=min_cash_num]';
            $(selector).val(data.min_cash_num);
        });
    });
</script>
@stop
