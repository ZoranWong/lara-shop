@extends('layouts.manager_page')

@section('content_header')
  <h1>
     编辑权限
  </h1>
  <ol class="breadcrumb">
    <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/store">Store</a></li>
    <li class="active">edit</li>
  </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="form">
                <div class="box box-info">
                    {{-- 基础设置 --}}
                    <div class="box-header with-border">
                        <h3 class="box-title">基础设置</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">短信验证码</label>
                            <div class="col-md-6">
                                <input type="checkbox" value="1" data-on-color="success" class="bt-switch" name="base[integral_ex_sms_code]" id="integral_ex_sms_code" checked />
                            </div>
                        </div>
                    </div>
                    
                    {{-- 积分宝 --}}
                    <div class="box-header with-border">
                        <h3 class="box-title">积分宝</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">权限</label>
                            <div class="col-md-3">
                                <input type="checkbox" value="0" data-on-color="success" id="jifenbao" class="bt-switch" name="jifenbao[is_activate]" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">开始:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="jifenbao[start_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">结束:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="jifenbao[end_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- 积分商城 --}}
                    <div class="box-header with-border">
                        <h3 class="box-title">积分商城</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">权限</label>
                            <div class="col-md-3">
                                <input type="checkbox" value="0" data-on-color="success" id="pointshop" class="bt-switch" name="pointshop[is_activate]" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">开始:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="pointshop[start_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">结束:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="pointshop[end_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- 智慧码 --}}
                    <div class="box-header with-border">
                        <h3 class="box-title">智慧码</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">权限</label>
                            <div class="col-md-3">
                                <input type="checkbox" value="0" data-on-color="success" id="zhm" class="bt-switch" name="zhm[is_activate]" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">开始:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="zhm[start_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">结束:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="zhm[end_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- 读书 --}}
                    <div class="box-header with-border">
                        <h3 class="box-title">读书</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">权限</label>
                            <div class="col-md-3">
                                <input type="checkbox" value="0" data-on-color="success" id="read" class="bt-switch" name="read[is_activate]" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">开始:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="read[start_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">结束:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="read[end_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 商城 --}}
                    <div class="box-header with-border">
                        <h3 class="box-title">商城</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">权限</label>
                            <div class="col-md-3">
                                <input type="checkbox" value="0" data-on-color="success" id="shop" class="bt-switch" name="shop[is_activate]" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">开始:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="shop[start_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">结束:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="shop[end_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 分销 --}}
                    <div class="box-header with-border">
                        <h3 class="box-title">分销</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">权限</label>
                            <div class="col-md-3">
                                <input type="checkbox" value="0" data-on-color="success" id="fenxiao" class="bt-switch" name="fenxiao[is_activate]" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">开始:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="fenxiao[start_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">结束:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="fenxiao[end_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- 合伙人 --}}
                    <div class="box-header with-border">
                        <h3 class="box-title">合伙人</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">权限</label>
                            <div class="col-md-3">
                                <input type="checkbox" value="0" data-on-color="success" id="partner" class="bt-switch" name="partner[is_activate]" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">开始:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="partner[start_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">结束:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="partner[end_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                    </div>




                    {{-- 尚汤 --}}
                    <div class="box-header with-border">
                        <h3 class="box-title">尚汤智能售卖</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">权限</label>
                            <div class="col-md-3">
                                <input type="checkbox" value="0" data-on-color="success" id="stsmart" class="bt-switch" name="stsmart[is_activate]" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">开始:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="stsmart[start_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">结束:</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="stsmart[end_date]" class="form-control pull-right datetimepicker">
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="box-footer">
                        <button type="submit" class="btn btn-success">保存</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@stop
@section('adminlte_js')
<script>
    $(document).ready(function () {
        var id = {{ $id  }};

        //插件初始化
        $('.datetimepicker').datetimepicker({
            autoclose: true,
            language: 'zh-CN',
            format: 'yyyy-mm-dd',
            startView: 4,
            minView: 2
        });
        $('.bt-switch').bootstrapSwitch().on('switchChange.bootstrapSwitch', function(event, status){
            this.value = status ? 1: 0;
        });

        //页面数据渲染
        $.getJSON('/ajax/store/config/' + id , function (json) {
            var data = json.data;
            for (model in data) {
                $('#' + model).bootstrapSwitch('state',data[model]['is_activate'])
                for (option in data[model]){
                    $('[name="' + model + '[' + option + ']').val(data[model][option]);
                }
            }
        })

        //表单提交
        $('#form').validator().on('submit', function (e) {
            if(!e.isDefaultPrevented()){
                e.preventDefault();
                var newData = {
                    'base[integral_ex_sms_code]': 0,
                    'jifenbao[is_activate]': 0,
                    'zhm[is_activate]': 0,
                    'pointshop[is_activate]': 0,
                    'read[is_activate]': 0,
                    'shop[is_activate]': 0,
                    'fenxiao[is_activate]': 0,
                    'stsmart[is_activate]': 0,
                    'partner[is_activate]': 0
                },
                data = $(e.target).serializeArray();

                data.map(function (item) {
                    newData[item['name']] = item['value'];
                })
                $.post('/ajax/store/config/' + id , newData , function (json) {
                    if(json.code == 200 ){
                        bootbox.alert({
                            title: '<span class="text-success">成功</span>',
                            message:'设置权限成功',
                            callback: function () {
                                location.pathname = '/store';
                            }
                        });
                    }else if(json.code == 401){
                        location.pathname = '/login';
                    }else{
                        bootbox.alert({
                            title: '<span class="text-danger">错误</span>',
                            message: json.error,
                        });
                    }
                }, 'json')
            }
        })
    })
</script>
@stop
