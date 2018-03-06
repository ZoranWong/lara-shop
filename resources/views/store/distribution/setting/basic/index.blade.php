@extends('store.distribution.setting.index')
@section('setting_content')
<style type="text/css">
    .leftSide{width:200px; line-height:30px; text-align: right;}
    .rightSide{width:600px; line-height:30px; text-align: left;}
    #base-setting-table{width:800px; margin-left:10px; border: 0px solid transparent;}
    #base-setting-save-button{margin:5px 10px 5px 80px;}
</style>
<div class="box-body" id = "setting_basic">
    <form class="form-horizontal" id="system_form" autocomplete="off">
        <table class="table " id = "base-setting-table" >
            <tr>
                <td class="leftSide">
                    <label for="info_status">分销商填资料：</label>
                </td>
                <td class="rightSide">
                    <input type="checkbox"
                           value="{{$setting['info_status']}}"
                           data-on-color="success"
                           id="info_status"
                           class="bt-switch"
                           name="info_status" /><br />
                    <font color="green">开启填写资料后，用户需要先填写个人资料</font>
                </td>
            </tr>
            <tr>
                <td class="leftSide">
                    <label for="mobile_status">手机号验证：</label>
                </td>
                <td class="rightSide">
                    <input type="checkbox"
                           value="{{$setting['mobile_status']}}"
                           data-on-color="success"
                           id="mobile_status"
                           class="bt-switch-mobile"
                           name="mobile_status" /><br />
                    <font color="red">开启手机号验证，需要充值短信，未开通及无短信库存请勿选择，如有需要请联系客服。</font>
                </td>
            </tr>
            {{--<tr>--}}
                {{--<td class="leftSide">--}}
                    {{--<label for="commission_status">自购佣金：</label>--}}
                {{--</td>--}}
                {{--<td class="rightSide">--}}
                    {{--<input type="checkbox"--}}
                           {{--value="{{$setting['commission_status']}}"--}}
                           {{--data-on-color="success"--}}
                           {{--id="commission_status"--}}
                           {{--class="bt-switch-commission"--}}
                           {{--name="commission_status" /><br />--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td class="leftSide">--}}
                    {{--<label for="level">分销层级：</label>--}}
                {{--</td>--}}
                {{--<td class="rightSide">--}}
                   {{--<select name="level" id="level" class="form-control">--}}
                        {{--<option value="">请选择</option>--}}
                        {{--<option value="1">一级下线</option>--}}
                        {{--<option value="2">二级下线</option>--}}
                        {{--<option value="3">三级下线</option>--}}
                    {{--</select>--}}
                {{--</td>--}}
            {{--</tr>--}}
             <tr>
                <td class="leftSide">
                    <label for="commission-days">佣金结算天数：</label>
                </td>
                <td class="rightSide">
                    <input type="text" id = "commission-days" name="commission_days" class="form-control" placeholder="佣金结算天数">
                    <br>
                    <font color="green">交易完成后需要再等x天再给分销商结算佣金.建议设置为售后周期后</font>
                </td>
            </tr>
            <tr>
                <td class="leftSide">
                    <label for="check_way">分销商审核方式：</label>
                </td>
                <td class="rightSide">
                    <input type="checkbox"
                           value="{{ $setting['check_way'] === 1 ? 2 : 1 }}"
                           data-on-color="success"
                           id="check_way"
                           class="bt-switch-checkWay"
                           name="check_way" />
                    <br>
                    <br>
                    <font color="green">使用说明：设置为系统自动审核时，申请人可立即成为分销商。总部审核为后台审核。</font>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" />
                    <button class="btn btn-primary " id = "base-setting-save-button">保存修改</button>
                </td>
            </tr>

        </table>

    </form>

</div>

<script type="text/javascript">
    window.pageInit = function () {
        $('.bt-switch').bootstrapSwitch({onText:"开启",offText:"关闭"}).on('switchChange.bootstrapSwitch', function(event, status){
            this.value = status ? 1: 0;
        });
        $('.bt-switch-mobile').bootstrapSwitch({onText:"开启",offText:"关闭"}).on('switchChange.bootstrapSwitch', function(event, status){
            this.value = status ? 1: 0;
        });
        $('.bt-switch-commission').bootstrapSwitch({onText:"开启",offText:"关闭"}).on('switchChange.bootstrapSwitch', function(event, status){
            this.value = status ? 1: 0;
        });
        $('.bt-switch-checkWay').bootstrapSwitch({onText:"不需要审核",offText:"需要审核",offColor:"primary",}).on('switchChange.bootstrapSwitch', function(event, status){
            this.value = (status === 1) ? 1: 2;
        });

        $('#info_status').bootstrapSwitch('state', {{$setting['info_status']}});
        $('#mobile_status').bootstrapSwitch('state', {{$setting['mobile_status']}});
        {{--$('#commission_status').bootstrapSwitch('state', {{$setting['commission_status']}});--}}
        $('#check_way').bootstrapSwitch('state', {{$setting['check_way']}});
        $('#commission-days').val({{$setting['commission_days']}});

        $('#system_form').validator().on('submit', function (e) {
            if(!e.isDefaultPrevented()){
                e.preventDefault();
                let newData = {
                    store_id: {{$store_id}},
                    info_status: 0,
                    mobile_status: 0,
                    // commission_status: 0,
                    check_way: 2
                };
                let data = $(e.target).serializeArray();
                data.map(function (item) {
                    newData[item['name']] = item['value'];
                });

                $.ajax({
                    type: "POST",
                    data: newData,
                    url:'/ajax/distribution/setting/basic',
                    async: false,
                    error: function(error) {
                        bootbox.alert("操作超时，请稍后重试");
                    },
                    success: function(json) {
                        if(json.success === true  && json.code === 200) {
                            bootbox.alert({
                                title: '<span class="text-success">成功</span>',
                                message: '更新成功',
                                callback: function () {
                                    location.pathname = "/distribution/setting?store_id={{$store_id}}";
                                },
                            });
                        } else if(json.code === 422) {
                            bootbox.alert({
                                title: '<span class="text-danger">更新失败</span>',
                                message: '您的规则名称或关键字已经被使用啦'
                            });
                        } else　if(json.code === 401) {
                            bootbox.alert({
                                title: '<span class="text-danger">认证失败</span>',
                                message: '由于长时间未进行操作，请进行重新登录',
                                callback: function () {
                                    location.pathname = "/login";
                                }
                            });
                        } else {
                            bootbox.alert({
                                title: '<span class="text-danger">操作失败</span>',
                                message: json.error
                            });
                        }
                    },
                });
            }
            return false;
        });
    }
</script>

@stop