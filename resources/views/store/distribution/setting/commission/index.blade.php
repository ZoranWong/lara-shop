@extends('store.distribution.setting.index')
@section('setting_content')
<style>
    .text-align{text-align: center;}
</style>
<div class="box-body">
    <form id="myFormLevel">
        <table class="table">
            <tr>
                <th class="text-align">级别</th>
                <th class="text-align">等级名称</th>
                <th class="text-align">升级规则</th>
                <th class="text-align">等级比例</th>
                <th class="text-align">操作</th>
            </tr>
            <tbody id="body2">
            </tbody>
            <tr>
                <td colspan="6">
                    <button id="add_level" class="btn btn-primary level_edit" >
                        <i class="glyphicon glyphicon-plus-sign"></i>添加新等级
                    </button>
                </td>
            </tr>
        </table>
    </form>
</div>
<script type="text/template" id="edit_level">
    @include('store.distribution.setting.commission.add')
</script>
<script type="text/javascript">
    window.commissionLevel = '';
    window.pageInit = function () {
        $.ajaxSettings.async = false;
        $.getJSON('/ajax/distribution/commission/level/list',function(json){
            let id ='';
            let data = json.data;
            let html = '';
            let text = '无';
            for (let i =0; i < json.data.length; i++)
            {
                let row = data[i];
                if(row.level !== 1) {
                    text = "不自动升级";
                    if(row['upgrade_type']  === 1){
                        text = "已结算佣金满" + row['reach_amount'] + "元";
                    }
                }

                html += "<tr style='text-align: center;'>";
                html += "<td>" + row.level + "</td>";
                html += "<td>" + row.name + "</td>";
                html += "<td>" + text + "</td>";
                let commission_text = '';
                if( row['commission_status'] ){
                    commission_text += "自购：" + row['commission'] + "%<br>";
                }
                if( row['level'] === 1 ){
                    commission_text += "一级：" + row['father_commission'] + "%";
                }
                if( row['level'] === 2 ){
                    commission_text += "一级：" + row['father_commission'] + "%<br>二级：" + row['grand_father_commission'] + "%";
                }
                if( row['level'] === 3 ){
                    commission_text += "一级：" + row['father_commission'] + "%<br>二级：" + row['grand_father_commission'] + "%<br>三级：" +
                        row['great_grand_father_commission'] + "%";
                }
                html += "<td>" + commission_text + "</td>";
                html += "<td><button class='level_edit btn btn-default' data=" + row.id+ ">编辑</button></td>";
                html += "</tr>";
            }
            $('#body2').append(html);
        });
        $('.level_edit').click(function(){
            let id = $(this).attr('data');
            let tab = $('#edit_level').text();
            $.post('/ajax/distribution/commission/level/edit', {'id': id, 'store_id': '{{$store_id}}' }, function(json){
                window.commissionLevel = json.data;
                if(json.code === 200) {
                    bootbox.dialog({
                        title: '<span class="text-danger">佣金设置</span>',
                        message: tab,
                        buttons: {
                            Success: {
                                label: "保存",
                                className: "btn-primary",
                                callback: function () {
                                    let levelNameSelector = `#edit_form input[name=level_name]`;
                                    let level_name = $(levelNameSelector).val();
                                    let levelUpgradeTypeSelector = '#edit_form input[name=upgrade_type]:checked';
                                    let upgrade_type = $(levelUpgradeTypeSelector).val();
                                    let reachAmountSelector = '#edit_form input[name=reach_amount]';
                                    let reach_amount = $(reachAmountSelector).val();
                                    let commissionSelector = '#edit_form input[name=commission]';
                                    let commission = $(commissionSelector).val();
                                    let commissionOneSelector = '#edit_form input[name=father_commission]';
                                    let commission_one = $(commissionOneSelector).val();
                                    let commissionTwoSelector = '#edit_form input[name=grand_father_commission]';
                                    let commission_two = $(commissionTwoSelector).val();
                                    let commissionThreeSelector = '#edit_form input[name=great_grand_father_commission]';
                                    let commission_three = $(commissionThreeSelector).val();
                                    if(level_name === '') {
                                        bootbox.alert({
                                            title: '<span class="text-danger">保存失败</span>',
                                            message: '请填写等级名称',
                                            callback: function(){
                                                let selector = `#edit_form input[name=level_name]`;
                                                $(selector).css('border','1px solid red');
                                            }
                                        });
                                        return false;
                                    }
                                    if(upgrade_type === 1 && ( reach_amount === '' || reach_amount === 0 )) {
                                        bootbox.alert({
                                            title: '<span class="text-danger">保存失败</span>',
                                            message: '请设置升级额度'
                                        });
                                        return false;
                                    }
                                    let newData = {
                                        'id': id,
                                        'store_id': {{$store_id}},
                                        'level': window.commissionLevel['level'],
                                        'name': level_name,
                                        'upgrade_type': upgrade_type,
                                        'reach_amount': reach_amount,
                                        'commission': commission,
                                        'father_commission': commission_one,
                                        'grand_father_commission': commission_two,
                                        'great_grand_father_commission': commission_three,
                                    };
                                    $.ajax({
                                        type: "POST",
                                        data: newData,
                                        url:'/ajax/distribution/commission/level/save',
                                        async: false,
                                        error: function(error) {
                                            alert("操作失败");
                                        },
                                        success: function(json) {
                                            if(json.code === 200) {
                                                bootbox.alert({
                                                    title: '<span class="text-success">保存成功</span>',
                                                    message: '操作成功',
                                                    callback: function () {
                                                        location.pathname = '/distribution/commission?store_id={{$store_id}}';
                                                    }
                                                });
                                            } else if (json.code === 401) {
                                                bootbox.alert({
                                                    title: '<span class="text-danger">提示</span>',
                                                    message: '由于长时间未进行操作，请进行重新登录',
                                                    callback: function () {
                                                        location.pathname = '/login';
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
                                    return false;
                                }
                            },
                            Cancel: {
                                label: "关闭",
                                className: "btn-default"
                            }
                        }
                    });
                } else {
                    bootbox.alert({
                        title: "<span class='text-danger'>数据加载失败</span>",
                        message: json.error
                    })
                }
            });
            return false;
    });
    };
</script>
@stop
