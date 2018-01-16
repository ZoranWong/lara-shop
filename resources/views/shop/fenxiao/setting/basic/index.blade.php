<style type="text/css">
    .leftSide{width:200px; line-height:30px; text-align: right;}
    .rightSide{width:600px; line-height:30px; text-align: left;}
</style>
<div class="box-body">
    <form class="form-horizontal" id="system_form" autocomplete="off">
        <table class="table" style="width:800px; margin-left:10px; border: 0px solid transparent">
            <tr>
                <td class="leftSide">分销商填资料：</td>
                <td class="rightSide">
                    <input type="checkbox"
                           value="0"
                           data-on-color="success"
                           id="info_status"
                           class="bt-switch"
                           name="info_status" /><br />
                    <font color="green">开启填写资料后，用户需要先填写个人资料</font>
                </td>
            </tr>
            <tr>
                <td class="leftSide">手机号验证：</td>
                <td class="rightSide">
                    <input type="checkbox"
                           value="0"
                           data-on-color="success"
                           id="mobile_status"
                           class="bt-switch-mobile"
                           name="mobile_status" /><br />
                    <font color="red">开启手机号验证，需要充值短信，未开通及无短信库存请勿选择，如有需要请联系客服。</font>
                </td>
            </tr>
            <tr>
                <td class="leftSide">申请成为分销商的条件：</td>
                <td class="rightSide">
                    <input id="apply_type_0" type="radio" name="apply_type" value="0" /> <label for="apply_type_0"> 无条件</label><br>
                   <input id="apply_type_1" type="radio" name="apply_type" value="1" /> <label for="apply_type_1"> 购买指定商品</label><br>
                    <button name="productInfo" class="btn btn-default" id="productbutton" disabled style="display:none;float: left;height: 34px;">请选择商品</button>
                    <input type="hidden" id="productInfo" name="productInfo"/>
                    <button id="product_id" type="button" class="btn btn-default" style="display:none;margin-left: 100px;">选择商品</button>
                    <!--  <input id="apply_type_2" type="radio" name="apply_type" value="2" /> <label for="apply_type_2"> 消费达到</label><br /> -->
                    <span id="setMinimum" style="display:none;">
                        <input class="input" name="apply_amount" type="text" maxlength="11" placeholder="请输入金额"><br>
                        <font color="red">温馨提醒：默认值为0，代表无消费要求。设置购买金额，会限制部分用户成为分销商，可能会有潜在的风险，请谨慎使用</font>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="leftSide">分销商审核方式：</td>
                <td class="rightSide">
                    <input type="checkbox"
                           value="1"
                           data-on-color="success"
                           id="check_way"
                           class="bt-switch-checkWay"
                           name="check_way" />
                    <br>
                    <font color="green">使用说明：设置为系统自动审核时，申请人可立即成为分销商。总部审核为后台审核。</font>
                </td>
            </tr>
            <tr>
                <td class="leftSide">推广海报</td>
                <td class="rightSide">
                    <select class="form-control poster select2"
                            id="poster_id"
                            name="poster_id"
                            data-placeholder="请选择推广海报"
                            required>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button class="btn btn-primary" style="margin:5px 10px 5px 80px;">保存修改</button>
                </td>
            </tr>

        </table>

    </form>

</div>
@push('js')
<script type="text/javascript">
    $(document).ready(function () {

        $("#apply_type_0").click(function(){
            $('#product_id').hide();
            $('#productbutton').hide();
            $('#setMinimum').hide();
        });
        $("#apply_type_1").click(function(){
            $('#product_id').css('display','block');
            $('#productbutton').css('display','block');
            $('#setMinimum').hide();
        });
        $("#apply_type_2").click(function(){
            $('#setMinimum').show();
            $('#product_id').hide();
            $('#productbutton').hide();
        });

        //获取海报资源
        $.ajax({
            timeout: 3000,
            async: false,
            type: "POST",
            url: "/ajax/shop/fenxiao/getPosters", // 获取海报
            dataType: "json",
            success: function (json) {
                var data = json.data.rows;
                for (var i = 0; i < data.length; i++) {
                    $("#poster_id").append("<option value="+data[i].id+">" + data[i].title + "</option>").select2();
                }
            }
        });

    });
    $('#product_id').click(function (){
        var productList = $('#selectProduct').text();
        bootbox.dialog({
            'title':'选择商品',
            'message': productList,
            buttons: {
                Cancel: {
                    label: "取消",
                    className: "btn-default",
                },
                Success: {
                    label: "确定",
                    className: "btn-primary",
                    callback: function () {
                        var getSelectedItem = getIdSelections();
                        $.post('/ajax/shop/fenxiao/miniProgramProductHandle', {'id': getSelectedItem[0]}, function (json)
                        {
                            if(json.code == 200) {
                                var productInfo = json.data;
                                if(productInfo) {
                                    var data = {
                                        'item_id': productInfo.id,
                                        'product_price': productInfo.sell_price,
                                        'product_name': productInfo.name,
                                        'product_thumb': productInfo.image_url
                                    }
                                    var jsonData = JSON.stringify(data);  //String
                                    $("#productbutton").css('display','block');
                                    $("#productInfo").val(jsonData);
                                    $("#productbutton").text(productInfo.name);
                                } else {
                                    bootbox.alert({
                                        title: '<span class="text-success">消失了</span>',
                                        message: '数据丢失了，请稍候重试',
                                        callback: function () {
                                            location.pathname = "/shop/fenxiao/setting";
                                        },
                                    });
                                }
                            } else {
                                bootbox.alert({
                                    title: '<span class="text-success">失败</span>',
                                    message: json.error,
                                    callback: function () {
                                        location.pathname = "/shop/fenxiao/setting";
                                    },
                                });
                            }
                        }, 'json');
                    }
                }
            }
        });
        return false;
    });

    $('#system_form').validator().on('submit', function (e) {
        if(!e.isDefaultPrevented()){
            e.preventDefault();
            var newData = {
                info_status: 0,
                mobile_status: 0,
                check_way: 2,
            }
            data = $(e.target).serializeArray();
            data.map(function (item) {
                newData[item['name']] = item['value'];
            });
          
            $.ajax({
                type: "POST",
                data: newData,
                url:'/ajax/shop/fenxiao/basicSet/save',
                async: false,
                error: function(error) {
                    alert("保存失败");
                },
                success: function(json) {
                    if(json.success == true  && json.code == 200) {
                        bootbox.alert({
                            title: '<span class="text-success">成功</span>',
                            message: '更新成功',
                            callback: function () {
                                location.pathname = "/shop/fenxiao/setting";
                            },
                        });
                    } else if(json.code == 422) {
                        bootbox.alert({
                            title: '<span class="text-danger">失败</span>',
                            message: '您的规则名称或关键字已经被使用啦',
                            callback: function () {
                                location.pathname = "/shop/fenxiao/setting";
                            },
                        });
                    } else　if(json.code == 401) {
                        bootbox.alert({
                            title: '<span class="text-danger">认证失败</span>',
                            message: '由于长时间未进行操作，请进行重新登录',
                            callback: function () {
                                location.pathname = "/login";
                            },
                        });
                    } else　if(json.success == false && json.code == 200) {
                        bootbox.alert({
                            title: '<span class="text-danger">失败</span>',
                            message: '请检查数据的合法性，进行补全资料...',
                            callback: function () {
                                // location.pathname = "/shop/fenxiao/setting";
                            },
                        });
                    } else　{
                        bootbox.alert({
                            title: '<span class="text-danger">失败</span>',
                            message: json.error
                            
                        });
                    }
                },
            });
        } else {
            bootbox.alert({
                title: '<span class="text-success">提交</span>',
                message: '请选择海报',
            });
        }
        return false;
    });
    $(document).ready(function () {
        $('.bt-switch').bootstrapSwitch({onText:"开启",offText:"关闭"}).on('switchChange.bootstrapSwitch', function(event, status){
            this.value = status ? 1: 0;
        });
        $('.bt-switch-mobile').bootstrapSwitch({onText:"开启",offText:"关闭"}).on('switchChange.bootstrapSwitch', function(event, status){
            this.value = status ? 1: 0;
        });
        $('.bt-switch-checkWay').bootstrapSwitch({onText:"不需要审核",offText:"需要审核",offColor:"primary",}).on('switchChange.bootstrapSwitch', function(event, status){
            this.value = (status == 1) ? 1: 2;
        });
        $.getJSON('/ajax/shop/fenxiao/basicSet',function (json) {
            var data = json.data;
            if(data) {
                var stateValue = (data.check_way == 1) ? 1 :0;
                var res = {
                        'item_id': data.product_id,
                        'product_price': data.product_price/100,
                        'product_name': data.product_name,
                        'product_thumb': data.product_thumb,
                    }
                var jsonData = JSON.stringify(res);  //String
                $('#check_way').bootstrapSwitch('state',stateValue);
                $('#system_form [name=apply_type][value='+data.apply_type+']').attr("checked",true);
                if(data.apply_type == 1) {  //指定商品
                    $('#product_id').css('display','block');
                    $("#productbutton").css('display','block');
                    $("#productInfo").val(jsonData);
                    $("#productbutton").text(data.product_name);

                } else if (data.apply_type == 2){  //满额,尚未开发
                    $('#setMinimum').removeAttr('style');
                }
                $('#info_status').bootstrapSwitch('state',data.info_status);
                $('#mobile_status').bootstrapSwitch('state',data.mobile_status);
                $('#poster_id').val(data.poster_id).trigger("change");
            }
        });
    });
</script>
<script type="text/template" id="selectProduct">
    <div class="box-body">
        <table id="table2"
               data-pagination="true"
               data-id-field="id"
               data-page-size="10"
               data-page-list="[10, 25, 50, 100]"
               data-show-footer="false"
               data-search="true"
               data-show-refresh="true"
               data-side-pagination="server"
               data-response-handler="responseHandler"
               data-url="/ajax/shop/fenxiao/miniProgramProductChoose" >
        </table>
    </div>
    <script type="text/javascript">
        var $table = $('#table2');
        function initTable() {
            $table.bootstrapTable({
                pagination: true,/*是否分页显示*/
                sidePagination: "server", /*分页方式：client客户端分页，server服务端分页*/
                smartDisplay: false,/*隐藏分页*/
                paginationPreText: "上一页",
                paginationNextText: "下一页",
                pageNumber: 1,
                pageSize: 10,
                striped: true,
                height: getHeight(),
                clickToSelect: true,//点击行即可选中单选/复选框
                singleSelect: true,
                columns: [
                    [
                    {
                        field: 'state',
                        checkbox: true,
                        align: 'center',
                        valign: 'middle'
                    }, {
                        field: 'id',
                        title: 'ID',
                        align: 'center',
                        valign: 'middle'
                    }, {
                        field: 'name',
                        title: '商品信息',
                        align: 'center',
                        valign: 'middle',
                    }, {
                        field: 'price',
                        title: '价格(:元)',
                        align: 'center',
                        valign: 'middle',
                    }
                    ]
                ],
                responseHandler: function (res) {
                    return res.data;
                },
            });
        }

        function getHeight() {
            return $(window).height() - $('.box-body').offset().top - 160;
        }

        function getIdSelections() {
            return $.map($table.bootstrapTable('getSelections'), function (row) {
                return row.id;
            });
        }

        initTable();
</script>
@endpush
