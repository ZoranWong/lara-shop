@push('js')
<script>
    var allActivityController      = null;
    var runningActivityController  = null;
    var endActivityController      = null;
    var notStartActivityController = null;
    var editActivityController = null;
    var detailActivityController = null;
    var addActivityController = null;
    function tableOptHtml(row) {
        var html  = '';
        switch (row.status){
            case 0:
            case 1:{
                if(row.status == 1)html += '<a class = "groupon-activity-spread" href="javascript:void(0);">推广</a>--';
                html += '<a class = "groupon-activity-edit" href="javascript:void(0);">编辑</a>--<a  href="javascript:void(0);" class="groupon-activity-invalid">使失效</a>';
                break;
            }
            case 2:
            case 3:{
                html += '<a href="javascript:void(0);" class = "groupon-activity-detail">查看</a>--<a class = "groupon-activity-delete" href="javascript:void(0);" >删除</a>';
                break;
            }
        }
        return html;
    }

    function activityStatus(value,row) {
        var color = '';
        switch (row.status){
            case 0:{
                color = '#2c9bcc';
                break;
            }
            case 1:{
                color = "#26ca27";
                break;
            }
            case 2:{
                color = '#e8500f';
                break;
            }
            case 3:{
                color = '#888888';
                break;
            }
        }
        return '<span style="color: '+color+'">'+value+'</span>';
    }

    function OperateEvents (controller) {
        return {
            'click .groupon-activity-edit':function (e, value, row, index) {
                $('.tab-content .tab-pane').removeClass('active');
                $('.tab-content .tab-pane#edit').addClass('active');
                $('.nav-tabs li').removeClass('active');
                $('.create-groupon-activity').hide();
                editActivityController.reset(row.id);
            },
            'click .groupon-activity-detail':function (e, value, row, index) {
                $('.tab-content .tab-pane').removeClass('active');
                $('.tab-content .tab-pane#detail').addClass('active');
                $('.nav-tabs li').removeClass('active');
                $('.create-groupon-activity').hide();
                detailActivityController.reset(row.id);
            },
            'click .groupon-activity-delete':function (e, value, row, index) {
                bootbox.confirm({
                    size: "small",
                    title: "警告",
                    message: '确定删除' + row.activity_name+'团购活动',
                    buttons: {
                        confirm: {
                            label: '确定',
                            className: 'btn-danger'
                        },
                        cancel: {
                            label: '取消'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            HttpUtils.del('/ajax/shop/activity/groupon/'+row.id).done(function (res) {
                                if(res.code == 200 && res.success){
                                    $.notify({
                                        message: "删除" + row.activity_name + "成功"
                                    },{
                                        type: 'success',
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                    controller.$table.bootstrapTable('refresh');
                                }else if (json.code == 401) {
                                    location.pathname = '/login';
                                } else {
                                    bootbox.alert({
                                        title: '<span class="text-danger">错误</span>',
                                        message: json.error,
                                    });
                                }
                            }).fail(function (error) {

                            });
                        }
                    }
                });
            },
            'click .groupon-activity-invalid':function (e, value, row, index) {
                bootbox.confirm({
                    size: "small",
                    title: "警告",
                    message: '此操作会使得'+ row.activity_name+'团购活动失效',
                    buttons: {
                        confirm: {
                            label: '确定',
                            className: 'btn-danger'
                        },
                        cancel: {
                            label: '取消'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            HttpUtils.patch('/ajax/shop/activity/groupon/'+row.id).done(function (res) {
                                if(res.code == 200 && res.success && res.data){
                                    controller.updateRow(index, res.data);
                                }
                            }).fail(function (error) {

                            });
                            HttpUtils.patch('/ajax/shop/activity/groupon/'+row.id).done(function (res) {
                                if(res.code == 200 && res.success){
                                    $.notify({
                                        message: row.activity_name + "已失效"
                                    },{
                                        type: 'success',
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                    controller.updateRow(index, res.data);
                                }else if (json.code == 401) {
                                    location.pathname = '/login';
                                } else {
                                    bootbox.alert({
                                        title: '<span class="text-danger">错误</span>',
                                        message: json.error
                                    });
                                }
                            }).fail(function (error) {

                            });
                        }
                    }
                });
            },
            'click .groupon-activity-spread':function (e, value, row, index) {
                HttpUtils.get('/ajax/shop/activity/groupon/spread?id='+row.id).done(function (json) {
                    res = json.data;
                    var text = $('#groupon-act-spread').text();
                    bootbox.dialog({
                        'title':'推广',
                        'message': text,
                        buttons: {
                            Cancel: {
                                label: "关闭",
                                className: "btn-default",
                                callback: function () {

                                }
                            }
                        }
                    });
                },function (error) {

                });
            }
        };
    }

    var currentStatus = 'all';

    var STATUS = {
        'NOT_START':0,
        'RUNNING':1,
        'OVER_DATE':2,
        'INVALID':3
    };



    function navTabsInit() {
        var navControllers = {
            'all':allActivityController,
            'not_start':notStartActivityController,
            'running':runningActivityController,
            'end':endActivityController
        };
        $('.nav-tabs li').click(function () {
            currentStatus = this.dataset.status;
            $('.create-groupon-activity').show();
            $('.tab-content .tab-pane').removeClass('active');
            $('.nav-tabs li').removeClass('active');
            $.each(navControllers,function ( index, controller) {
                if(index == currentStatus){
                    controller.reset();
                }else{
                    controller.leave();
                }
            });
            editActivityController.leave();
            detailActivityController.leave();
            addActivityController.leave();
        });

        $('.cancel').click(function () {
            currentStatus = 'all';
            $('.create-groupon-activity').show();
            $('.tab-content .tab-pane').removeClass('active');
            $('.nav-tabs li').removeClass('active');
            $.each(navControllers,function ( index, controller) {
                if(index == currentStatus){
                    controller.reset();
                }else{
                    controller.leave();
                }
            });
            editActivityController.leave();
            detailActivityController.leave();
            addActivityController.leave();
        });
    }

    // 对Date的扩展，将 Date 转化为指定格式的String
    // 月(M)、日(d)、小时(h)、分(m)、秒(s)、季度(q) 可以用 1-2 个占位符，
    // 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)
    // 例子：
    // (new Date()).Format("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423
    // (new Date()).Format("yyyy-M-d h:m:s.S")      ==> 2006-7-2 8:9:4.18
    Date.prototype.format = function(fmt)
    { //author: meizz
        var o = {
            "M+" : this.getMonth()+1,                 //月份
            "d+" : this.getDate(),                    //日
            "h+" : this.getHours(),                   //小时
            "m+" : this.getMinutes(),                 //分
            "s+" : this.getSeconds(),                 //秒
            "q+" : Math.floor((this.getMonth()+3)/3), //季度
            "S"  : this.getMilliseconds()             //毫秒
        };
        if(/(y+)/.test(fmt))
            fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
        for(var k in o)
            if(new RegExp("("+ k +")").test(fmt))
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
        return fmt;
    };

    function dateTimeInit(controller) {
        controller.stage.find('.datepicker').datetimepicker({
            autoclose: true,
            language: 'zh-CN',
            format: 'yyyy-mm-dd hh:mm:ss',
            minuteStep:1
        });

        var nowDate = (new Date()).format("yyyy-MM-dd hh:mm:ss");
        controller.stage.find('.start-datepicker').click(function () {
            controller.startTimePicker.datetimepicker('show');
        });

        controller.stage.find('.end-datepicker').click(function () {
            controller.endTimePicker.datetimepicker('show');
        });
        controller.startTimePicker = controller.stage.find('.start-datepicker-1');
        controller.startTimePicker
        .datetimepicker({'startDate': nowDate})
        .on('changeDate', function(ev){
            if(typeof controller.startTime != 'undefined')
                controller.startTime(ev, this);
        });

        controller.endTimePicker = controller.stage.find('.end-datepicker-1');
        controller.endTimePicker
        .datetimepicker({'startDate': nowDate})
        .on('changeDate', function(ev){
            if(typeof controller.endTime != 'undefined')
                controller.endTime(ev, this);
        });
    }

    function renderGrouponActivityInfo(controller) {
        controller.stage.find('.activity_goods_img').attr('src',controller.data.goods.image_url);
        controller.stage.find('.activity_name').val(controller.data.activity_name);
        controller.stage.find('').val(controller.data.activity_name);
    }


    function goodsTable(data, leaderPrefer) {
        var table  = '<table class="table table-bordered">';
        table += '<thead><tr>';
        if(data['products'] && data['products'].length > 0){
            table +=  '<th class = "sku">产品规格</th>';
        }
        table +=  '<th class = "origin-price" >产品原价（元）</th>';
        table += '<th class = "groupon-price" >团购价（元）</th>';
        table += '<th class = "leader-price" '+(leaderPrefer ? '' : 'hidden="true"')+'>团长优惠价（元）</th>';
        table += '<th class = "stock-num" >库存</th>';
        table += '</thead></tr>';
        table += '<tbody>';
        if(data['products']  && data['products'].length > 0){
         $.each(data['products'],function (index, product) {
             table += productTd(product, leaderPrefer, index);
         });
        }else{
            table += goodsTd(data, leaderPrefer);
        }
        table += '</tbody>';
        table +=  '</table>';
        return table;
    }
    

    function productTd(product, leaderPrefer, index) {
        var td = '<tr>';
        if(typeof  product['price'] == 'undefined'){
            product['price'] = '';
        }
        if(typeof  product['leader_price'] == 'undefined'){
            product['leader_price'] = '';
        }
        td += '<td class = "sku">' + product['sku'] + '</td>';
        td += '<td class = "origin-price">' + product['sell_price'] + '</td>';
        td += '<td class = "groupon-price"><input type="number" class = "form-control  groupon-price-input products-price-'+product['id'] + '" data-name = "price" data-type = "products" data-index="'+index+
            '" data-id ="' + product['id'] + '" value = "'+product['price']+'"  min ="0.01" step="0.01" max="'+
            product['sell_price']+'" ></td>';
        if(leaderPrefer)
            td += '<td class = "leader-price"><input type = "number" class = "form-control  leader-price-input products-leader-pirce-'+product['id'] + '" data-name = "leader_price" data-type = "products" data-index="'+index+
                 '" data-id ="' + product['id'] + '"  value = "'+product['leader_price']+'" min ="0.01" step="0.01" max="'+
                product['sell_price']+'"></td>';
        td += '<td class = "stock-num">'+product['stock_num'] + '</td>';
        return td+'</td>';
    }
    function goodsTd(goods, leaderPrefer) {
        if(typeof  goods['price'] == 'undefined'){
            goods['price'] = '';
        }
        if(typeof  goods['leader_price'] == 'undefined'){
            goods['leader_price'] = '';
        }
        var td = '<tr>';
        td += '<td class = "origin-price">' +  goods['sell_price'] + '</td>';
        td += '<td class = "groupon-price"><input type = "number" class = "form-control  groupon-price-input goods-price-' + goods['id'] +'" data-name = "price" data-type = "goods" ' +
            'data-id ="' + goods['id'] + '"  value = "'+goods['price']+'" min ="0.01" step="0.01" max="'+
            goods['sell_price']+'"></td>';
        if(leaderPrefer)
            td += '<td class = "leader-price"><input type = "number" class = "form-control  leader-price-input goods-leader-pirce-'+goods['id']+'" data-name = "leader_price" data-type = "goods"'+
                '" data-id ="'+goods['id'] + '"  value = "'+goods['leader_price']+'" min ="0.01" step="0.01" max="'+ goods['sell_price']+'"></td>';
        td += '<td class = "stock-num">' + goods['stock_num'] + '</td>';
        return td + '</td>';
    }
</script>
@endpush