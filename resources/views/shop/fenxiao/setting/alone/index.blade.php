 <button id="add_product" class="btn btn-primary">
    <i class="glyphicon glyphicon-plus-sign"></i>添加商品
</button>
<div class="box-body">    
    <table id="table"
           data-pagination="true"
           data-id-field="id"
           data-page-size="10"
           data-page-list="[10, 25, 50, 100]"
           data-show-footer="false"
           data-search="true" 
           data-show-refresh="true"
           data-side-pagination="server"
           data-response-handler="responseHandler"
           data-url="/ajax/shop/fenxiao/showFields" >
    </table>
</div>
<!-- /.box-body -->

@section('js')
<!-- 添加独立商品start -->
    <!-- 添加独立商品　模板start -->
    <script type="text/template" id="product">
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
                    columns: [
                        [
                            {
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
                            }, {
                                field: 'operate',
                                title: '操作',
                                align: 'center',
                                valign: 'middle',
                                events: operateEvents,
                                formatter: operateFormatter
                            }
                        ]
                    ],
                    responseHandler: function (res) {
                        return res.data;
                    },
                });
            }

            function getHeight() {
                return $(window).height() - $('.box-body').offset().top - 32;
            }

            function operateFormatter(value, row, index) {
                var operateDate = [
                    '<a class="select" href="javascript:void(0)" title="选择">',
                    '选择',
                    '</a>  '
                ];
                return operateDate.join('');
            }

            window.operateEvents = {
                'click .select': function (e, value, row, index) {
                    $.get('/ajax/shop/fenxiao/commissionSet', {}, function (json)
                    {
                        level = json.data[0].level;
                    });
                    $.post('/ajax/shop/fenxiao/miniProgramProductChoose', {'id':row.id}, function (json)
                    {
                        if(json.code==200) {
                            res=json.data.rows[0];
                            res.level = level;
                            
                            var tab;
                            if(res) {
                                tab = $('#product2').text();
                            } else {
                                tab = "ERROR";
                            }

                            bootbox.dialog({
                                title: '<span class="text-danger">佣金设置</span>',
                                message: tab,
                                buttons: {
                                    Success: {
                                        label: "保存",
                                        className: "btn-primary",
                                        callback: function () {
                                            var type = $('#commissionType input[name=type]:checked').val();
                                            var commission = $('#commission [name=commission2]').val();
                                            var father_commission = $('#product_one [name=father_commission]').val();
                                            var grand_father_commission = $('#product_two [name=grand_father_commission]').val();
                                            var great_grand_father_commission = $('#product_three [name=great_grand_father_commission]').val();
                                            var name = $('#commissionType input[name=title]').val();
                                            var image_url = $('#commissionType input[name=image_url]').val();
                                            var sell_price = $('#commissionType input[name=product_price]').val();
                                            var info = new Object;
                                            info.type = type;
                                            info.commission = commission;
                                            info.father_commission = father_commission;
                                            info.grand_father_commission = grand_father_commission;
                                            info.great_grand_father_commission = great_grand_father_commission;
                                            info.name = res.name;
                                            info.product_thumb = res.image_url;
                                            info.product_price = res.sell_price;
                                            info.product_id = res.id; 
                                            $.post("/ajax/shop/fenxiao/productCommissionStore",info,function(json){
                                                if(json.code == 200) {
                                                   bootbox.alert({
                                                        title: '<span class="text-success">成功</span>',
                                                        message: '更新成功',
                                                        callback: function () {
                                                           location.pathname = "/shop/fenxiao/setting";
                                                        }
                                                    });
                                                } else if(json.code == 400) {
                                                    bootbox.alert({
                                                        title: '<span class="text-danger">异常错误</span>',
                                                        message: json.error
                                                    });
                                                } else {
                                                    bootbox.alert({
                                                        title: '<span class="text-danger">失败</span>',
                                                        message: json.error,
                                                        callback: function () {
                                                           location.pathname = "/shop/fenxiao/setting";
                                                        }
                                                    });
                                                }
                                            },'json');
                                        }
                                    }
                                }
                            });
                        } else {
                            bootbox.alert({
                                title: '<span class="text-success">失败</span>',
                                message: json.error
                            })
                        }
                    }, 'json');
                }
            }

            initTable();
        </script>
    </script>
    <!-- 添加独立商品　模板end -->

    <!-- 选中商品，进行佣金设置start -->
    <script type="text/template" id="product2">
        <style type="text/css">
            .precent {
                width: 25px; 
                height: 24px; 
                background: #b9a0a0;
                padding: 2px;
            }
        </style>
        <!-- /*查看某商品独立佣金详情 */ -->
        <form>
            <fieldset> 
                <div class="form-group" style="height:80px;"> 
                    <div class="col-sm-2"> 
                     <img src="" style="width:80px;height:80px;" id="thumb"/> 
                    </div> 
                    <div class="col-sm-8" style="margin-top: 25px; text-align:center;" id="name">
                    </div> 
                    <div class="col-sm-2" style="text-align:center;margin-top: 25px;" id="price">
                    </div> 
                </div>
                <hr />
                <div class="col-sm-2">
                    使用说明：
                </div>
                <div class="col-sm-10" id="explain1" style="line-height:21px;">
                    设置独立佣金的商品，用户购买后，以独立佣金计算。按比例算佣金，填写的获得佣金比例均为订单实付金额的比例。
                </div>
                <div class="col-sm-10" id="explain2" style="line-height:21px;display:none;">
                    设置独立佣金的商品，用户购买后，以独立佣金计算。按金额算佣金，佣金为固定金额，不论实付款金额为多少，商品佣金固定。
                </div>
                <br />
                <div class="form-group" id="commissionType">
                   <label class="col-sm-2 control-label">佣金类型：</label>
                    <div class="col-sm-4" style="margin-top: 5px;">
                         <input type="radio" name="type" value="1" id="type_1" checked/>
                         <label for="type_1" style="margin-right: 8px; margin-left: 3px;"> 百分比</label>
                         <input type="radio" name="type" value="2" id="type_2" />
                         <label for="type_2" style="margin-left: 3px;"> 固定金额</label>
                         <br />
                    </div>
                    <div class="col-sm-6" style="height: 42px;"></div>
                </div>
                <br />
                <br />
                <div class="form-group" id="precent">
                    <label class="col-sm-2 control-label" style="margin-top: 8px;">设置佣金：</label>
                    <div class="col-sm-10" style="height:60px;">
                        <div style="width: 90px; height:60px; border:1px solid black; float:left; font-size:12px; margin-right: 20px;" id="commission">
                            <span style="width:90px; height:50px; line-height: 25px;">
                                <span style="margin-left: 26px;">自购</span>
                            </span>
                            <div style="margin-left: 15px;">
                                <input type="number" name="commission2" value="0" min="0" max="100" style="border-radius: 5px;" />
                                <span class="precent">%</span>
                            </div>
                        </div>
                        <div>
                            <div style="width: 90px; height:60px; border:1px solid black; float:left; font-size:12px;" id="product_one">
                                <span style="width:90px; height:50px; line-height: 25px;" >
                                    <span style="margin-left: 18px;">一级上线</span>
                                </span>
                                <div style="margin-left: 15px;">
                                    <input type="number" name="father_commission" value="0" min="0" max="100" style="border-radius: 5px;" />
                                    <span class="precent">%</span>
                                </div>
                            </div>
                            <div id="product_two">
                                <div style="float:left; margin-top:40px; margin-right: -10px;"></div>
                                <div style="width: 90px; height:60px; border:1px solid black; float:left; font-size:12px; margin-left: 12px;">
                                    <span style="width:90px; height:50px; line-height: 25px; margin-left: 12px;">
                                        <span style="margin-left: 6px;">二级上线</span>
                                    </span>
                                    <div style="margin-left: 15px;">
                                        <input type="number" name="grand_father_commission" value="0" min="0" max="100" style="border-radius: 5px;" />
                                        <span class="precent">%</span>
                                    </div>
                                </div>
                            </div>
                            <div id="product_three">
                                <div style="float:left; margin-top:40px; margin-right: -10px;"></div>
                                <div style="width: 90px; height:60px; border:1px solid black; float:left; margin-left: 12px;">
                                    <span style="width:90px; height:50px; line-height: 25px; margin-left: 12px;">
                                        <span style="margin-left: 6px;">三级上线</span>
                                    </span>
                                    <div style="margin-left: 15px;">
                                        <input type="number" name="great_grand_father_commission" value="0" min="0" max="100" style="border-radius: 5px;" />
                                        <span class="precent">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </fieldset>
        </form>
        <script type="text/javascript">
            $('#thumb').attr('src',res.image_url);
            $('#name').text(res.name);
            $('#price').text(res.price);
            switch(res.level)
            {
                case 1:
                    $('#product_two').hide();
                    $('#product_three').hide();
                    break;
                case 2:
                    $('#product_three').hide();
                    break;
                default:
                    break;
            }
            //点击事件
            $('#commissionType').click(function(){
                if($('#commissionType input[name=type]:checked').val() == 2) {
                    $('#precent .precent').hide();
                    $('#explain1').hide();
                    $('#explain2').css('display','block');
                } else {
                    $('#precent .precent').removeAttr('style');
                    $('#explain1').css('display','block');
                    $('#explain2').hide();
                }
            });

        </script>
    </script>
    <!-- 选中商品，进行佣金设置end -->

    <script type="text/javascript">
        $(document).ready(function () {
            var productList = $('#product').text();
            $('#add_product').click(function(){
                bootbox.dialog({
                    'title': '选择商品',
                    'message': productList,
                });
            });
        });
    </script>
<!-- 添加独立商品end -->

<!-- 独立商品佣金设置start -->
    <!-- 独立商品佣金  模板start -->
    <script type="text/template" id="dialog">
        <style type="text/css">
            .precent {
                width: 25px; 
                height: 24px; 
                background: #b9a0a0;
                padding: 2px;
            }
        </style>
        <!-- 查看有赞商品独立佣金详情 -->
        <form>
            <fieldset> 
                <div class="form-group" style="height:80px;"> 
                    <div class="col-sm-2"> 
                     <img src="" style="width:80px;height:80px;" id="thumb"> 
                    </div> 
                    <div class="col-sm-8" style="margin-top: 25px; text-align:center;" id="title">
                         
                    </div> 
                    <div class="col-sm-2" style="text-align:center;margin-top: 25px;" id="product_price">
                        
                    </div> 
                </div>
                <hr />
                <div class="col-sm-2">
                    使用说明：
                </div>
                <div class="col-sm-10" id="explain1" style="line-height:21px;display: none;">
                    设置独立佣金的商品，用户购买后，以独立佣金计算。按比例算佣金，填写的获得佣金比例均为订单实付金额的比例。
                </div>
                <div class="col-sm-10" id="explain2" style="line-height:21px;display: none;">
                    设置独立佣金的商品，用户购买后，以独立佣金计算。按金额算佣金，佣金为固定金额，不论实付款金额为多少，商品佣金固定。
                </div>
                <br />
                <div class="col-sm-2">
                    当前分销层级：
                </div>
                <div class="col-sm-3" style="text-align: center;line-height: 36px;" id="fenxiao_level">
                    二级 
                </div>
                <div class="col-sm-3" style="line-height: 36px;">
                    自购佣金状态：
                </div>
                <div class="col-sm-3" style="text-align: center;line-height: 36px;" id="fenxiao_status">
                    关闭
                </div>
                <div class="form-group" id="commissionType">
                    <input type="hidden" name="id">
                    <label class="col-sm-2 control-label">佣金类型：</label>
                    <div class="col-sm-4" style="margin-top: 5px;">
                         <input type="radio" name="type" value="1" id="type_1" />
                         <label for="type_1" style="margin-right: 8px; margin-left: 3px;"> 百分比</label>
                         <input type="radio" name="type" value="2" id="type_2" />
                         <label for="type_2" style="margin-left: 3px;"> 固定金额</label>
                         <br />
                    </div>
                    <div class="col-sm-6" style="height: 42px;"></div>
                </div>
                <br />
                <br />
                <div class="form-group" id="precent">
                    <label class="col-sm-2 control-label" style="margin-top: 8px;">设置佣金：</label>
                    <div class="col-sm-10" style="height:60px;">
                        <div style="width: 90px; height:60px; border:1px solid black; float:left; font-size:12px; margin-right: 20px;" id="commission">
                            <span style="width:90px; height:50px; line-height: 25px;">
                                <span style="margin-left: 26px;">自购</span>
                            </span>
                            <div style="margin-left: 15px;">
                                <input type="number" name="commission2" value="0" min="0" max="100" style="border-radius: 5px;" />
                                <span class="precent">%</span>
                            </div>
                        </div>
                        <div>
                            <div style="width: 90px; height:60px; border:1px solid black; float:left; font-size:12px;" id="product_one">
                                <span style="width:90px; height:50px; line-height: 25px;" >
                                    <span style="margin-left: 18px;">一级上线</span>
                                </span>
                                <div style="margin-left: 15px;">
                                    <input type="number" name="father_commission" value="0" min="0" max="100" style="border-radius: 5px;" />
                                    <span class="precent">%</span>
                                </div>
                            </div>
                            <div id="product_two">
                                <div style="float:left; margin-top:40px; margin-right: -10px;"></div>
                                <div style="width: 90px; height:60px; border:1px solid black; float:left; font-size:12px; margin-left: 12px;">
                                    <span style="width:90px; height:50px; line-height: 25px; margin-left: 12px;">
                                        <span style="margin-left: 6px;">二级上线</span>
                                    </span>
                                    <div style="margin-left: 15px;">
                                        <input type="number" name="grand_father_commission" value="0" min="0" max="100" style="border-radius: 5px;" />
                                        <span class="precent">%</span>
                                    </div>
                                </div>
                            </div>
                            <div id="product_three">
                                <div style="float:left; margin-top:40px; margin-right: -10px;"></div>
                                <div style="width: 90px; height:60px; border:1px solid black; float:left; margin-left: 12px;">
                                    <span style="width:90px; height:50px; line-height: 25px; margin-left: 12px;">
                                        <span style="margin-left: 6px;">三级上线</span>
                                    </span>
                                    <div style="margin-left: 15px;">
                                        <input type="number" name="great_grand_father_commission" value="0" min="0" max="100" style="border-radius: 5px;" />
                                        <span class="precent">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </fieldset>
        </form>
        <script type="text/javascript">
            $('#thumb').attr('src',dialog.product_thumb);
            $('#title').text(dialog.title);
            $('#product_price').text(dialog.product_price);
            $('#commissionType input[name=type][value='+dialog.type+']').attr('checked',true);
            $('#explain'+dialog.type).css('display','block');
            $('#commissionType input[name=id]').val(dialog.id);
            $('#product_one input[name=father_commission]').val(dialog.father_commission);
            
            if(dialog.type == 2) {
                $('#precent .precent').hide();
            }
            //点击事件
            $('#commissionType').click(function(){
                if($('#commissionType input[name=type]:checked').val() == 2) {
                    $('#precent .precent').hide();
                    $('#explain1').hide();
                    $('#explain2').css('display','block');
                } else {
                    $('#precent .precent').removeAttr('style');
                    $('#explain1').css('display','block');
                    $('#explain2').hide();
                }
            });
            switch(dialog.commission_status)
            {
                case 0:
                    $('#precent #commission').hide();
                    $('#fenxiao_status').text('关闭');
                    $('#commission input[name=commission2]').val(0);

                    break;
                case 1:
                    $('#fenxiao_status').text('开启');
                    $('#commission input[name=commission2]').val(dialog.commission);
                    break;
                default:
                    $('#fenxiao_status').text('');
                    break;
            }
            switch(dialog.level)
            {
                case 1:
                    $('#fenxiao_level').text('一级');
                    $('#product_two').hide();
                    $('#product_three').hide();
                    $('#product_two input[name=grand_father_commission]').val(0);
                    $('#product_three input[name=great_grand_father_commission]').val(0);
                    break;
                case 2:
                    $('#fenxiao_level').text('二级');
                    $('#product_three').hide();
                    $('#product_two input[name=grand_father_commission]').val(dialog.grand_father_commission);
                    $('#product_three input[name=great_grand_father_commission]').val(0);
                    break;
                case 3:
                    $('#fenxiao_level').text('三级');
                    $('#product_two input[name=grand_father_commission]').val(dialog.grand_father_commission);
                    $('#product_three input[name=great_grand_father_commission]').val(dialog.great_grand_father_commission);
                    break;
                default:
                    $('#level_status').text('未开启分销等级');
                    break;
            }
        </script>
    </script>
    <!-- 独立商品佣金  模板end -->

    <script type="text/javascript">
        $(document).ready(function () {
            var $table = $('#table');
            var commision_status = '';
            var fenxiao_level = '';
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
                    showColumns: true,//列选择按钮
                    height: getHeight(),
                    columns: [
                        [
                            {
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
                            }, {
                                field: 'commission',
                                title: '自购佣金',
                                valign: 'middle',
                                align: 'center',
                            }, {
                                field: 'father_commission',
                                valign: 'middle',
                                title: '一级上线',
                                align: 'center'
                            }, {
                                valign: 'middle',
                                field: 'grand_father_commission',
                                title: '二级上线',
                                align: 'center'
                            }, {
                                valign: 'middle',
                                field: 'great_grand_father_commission',
                                title: '三级上线',
                                align: 'center'
                            }, {
                                field: 'created_at',
                                valign: 'middle',
                                title: '创建时间',
                                align: 'center'
                            }, {
                                field: 'updated_at',
                                title: '更新时间',
                                editable: true,
                                align: 'center',
                                valign: 'middle'
                            }, {
                                field: 'operate',
                                title: '操作',
                                align: 'center',
                                valign: 'middle',
                                events: operateEvents,
                                formatter: operateFormatter
                            }
                        ]
                    ],
                    responseHandler: function (res) {
                        var data = res.data; 
                        for (var i = 0; i < data.rows.length; i++) {
                            for( var pro in data.rows[i] ) {
                               if(data.rows[i].type === 1 && (pro === 'commission' || pro === 'father_commission' || pro === 'grand_father_commission' || pro === 'great_grand_father_commission')) {
                                    data.rows[i][pro] += '%';
                               }     
                            }
                        }
                        if(data.rows.length){
                            fenxiao_level = data.rows[0].level;
                            commision_status = data.rows[0].commission_status; 
                            if(!commision_status){
                                $table.bootstrapTable('hideColumn', 'commission');
                            }

                            if(fenxiao_level == 2) {
                                $table.bootstrapTable('hideColumn', 'great_grand_father_commission');
                            }
                            if(fenxiao_level == 1) {
                                $table.bootstrapTable('hideColumn', 'grand_father_commission');
                                $table.bootstrapTable('hideColumn', 'great_grand_father_commission');
                            }
                        }
                        return data;
                    },
                });
            }

            function getHeight() {
                return $(window).height() - $('.box-body').offset().top - 32;
            }

            function operateFormatter(value, row, index) {
                var operateDate = [
                    '<a class="edit" href="javascript:void(0)" title="编辑">',
                    ' <i class="glyphicon glyphicon-edit"></i>编辑',
                    '</a>  ',
                    '<a class="delete" href="javascript:void(0)" title="删除">',
                    '<i class="glyphicon glyphicon-remove"></i>删除',
                    '</a>'
                ];
                return operateDate.join('');
            }

            window.operateEvents = {
                'click .edit': function (e, value, row, index) {
                    $.post('/ajax/shop/fenxiao/productCommission/edit', {'id': row.id}, function (json)
                    {
                        if(json.code == 200) {
                            dialog = json.data;
                            var tab;
                            if(dialog) {
                                tab = $('#dialog').text();
                            } else {
                                tab="ERROR";
                            }
                            bootbox.dialog({
                                title: '<span class="text-danger">佣金设置</span>',
                                message: tab,
                                buttons: {
                                    Cancel: {
                                        label: "取消",
                                        className: "btn-default"
                                    }, 
                                    Success: {
                                        label: "保存",
                                        className: "btn-primary",
                                        callback: function () {
                                            var id = $('#commissionType [name=id]').val();
                                            var type = $('#commissionType input[name=type]:checked').val();
                                            var commission = $('#commission [name=commission2]').val();
                                            var father_commission = $('#product_one [name=father_commission]').val();
                                            var grand_father_commission = $('#product_two [name=grand_father_commission]').val();
                                            var great_grand_father_commission = $('#product_three [name=great_grand_father_commission]').val();
                                            var info = {"type":type};
                                            info.id = id;
                                            info.commission = commission;
                                            info.father_commission = father_commission;
                                            info.grand_father_commission = grand_father_commission;
                                            info.great_grand_father_commission = great_grand_father_commission;
                                            $.post("/ajax/shop/fenxiao/productCommissionStore",info,function(json){
                                                if(json.code == 200) {
                                                    bootbox.alert({
                                                        title: '<span class="text-success">成功</span>',
                                                        message: '更新成功',
                                                        callback: function () {
                                                           $table.bootstrapTable('refresh');
                                                        },
                                                    });
                                                    
                                                } else if(json.code == 400) {
                                                    bootbox.alert({
                                                        title: '<span class="text-success">异常错误</span>',
                                                        message: json.error,
                                                        callback: function () {
                                                           $table.bootstrapTable('refresh');
                                                        }
                                                    });
            
                                                } else if(json.code == 401) {
                                                    bootbox.alert({
                                                        title: '<span class="text-danger">失败</span>',
                                                        message: '由于长时间未进行操作，请进行重新登录',
                                                        callback: function () {
                                                            location.pathname = '/login';
                                                        }
                                                    });
                                                } else {
                                                      bootbox.alert({
                                                        title: '<span class="text-danger">失败</span>',
                                                        message: json.error,
                                                        callback: function () {
                                                            location.pathname = '/shop/fenxiao/setting';
                                                        }
                                                    });
                                                }
                                            },'json');
                                        }
                                    }
                                }
                            });
                        }
                    }, 'json');
                },
                
                'click .delete': function (e, value, row, index) {
                    var id = row.id;
                    if(confirm('确定要删除该条记录吗')) {
                        $.post('/ajax/shop/fenxiao/product/delete', {'id': id}, function (json) {
                            if (json.code == 200) {
                                $table.bootstrapTable('remove', {
                                    field: 'id',
                                    values: id
                                });
                                $table.bootstrapTable('refresh');
                            } else if(json.code == 401) {
                                bootbox.alert({
                                    title: '<span class="text-success">失败</span>',
                                    message: '由于长时间未进行操作，请进行重新登录',
                                    callback: function () {
                                        location.pathname = '/login';
                                    },
                                });
                            } else {
                                 bootbox.alert({
                                    title: '<span class="text-success">失败</span>',
                                    message: json.error,
                                    callback: function () {
                                        location.pathname = '/shop/fenixao/setting';
                                    },
                                });
                            }
                        }, 'json')
                    }
                }
            };

            initTable();
        });
    </script>

<!-- 独立商品佣金设置end -->

@stop
