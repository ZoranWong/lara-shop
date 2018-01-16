@extends('layouts.my_page')
@section('content')
<style>
.box{margin-bottom: 0px}
.delete-cancel a{margin-right: 4px}
</style>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">订单管理</h3>
      </div>
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title" style="font-size:16px">筛选查询</h3>
        </div>
        <div class="box-body">
          <form method="post" class="form-horizontal" id="eventqueryform">
            <div class="form-group">
              <label for="title" class="col-sm-1 control-label">输入搜索</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <input type="text" class="form-control" name="goods-value" placeholder="商品名称/商品货号">
                  <span class="input-group-addon">
                    收货人
                  </span>
                  <input type="text" class="form-control" name="receiver-name" placeholder="">
                  <span class="input-group-addon">
                    提交时间(开始)
                  </span>
                  <input type="text" class="form-control datepicker" name="start-time" placeholder="">
                  <span class="input-group-addon">
                    提交时间(结束)
                  </span>
                  <input type="text" class="form-control datepicker" name="end-time" placeholder="">
                  <span class="input-group-addon" style="padding:0px 5px;border:none">
                    <input type="button" class="btn btn-primary" id="search-query" value="查询">
                  </span>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="box-body" id="box-body">
        <table id="table"
        data-toolbar="#toolbar"
        data-search="false"
        data-striped="true"
        data-strict-search="true"
        data-search-on-enter-key="true"
        data-pagination="true"
        data-id-field="id"
        data-page-size="10"
        data-page-list="[10]"
        data-show-footer="false"
        data-side-pagination="server"
        data-url="/ajax/shop/order/index"
        data-response-handler="responseHandler">
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
@stop

@section('adminlte_js')
<script>
$(document).ready(function () {
  var $table = $('#table'),
  $remove = $('#remove'),
  $close = $('#close'),
  $cancel = 50,
  $complete = 40,
  $no_pay = 10,
  $no_deliver = 20,
  $no_receipt = 30,
  selections = [];
  $(".datepicker").datetimepicker({
    todayBtn: true,
    autoclose: true,
    language: 'zh-CN',
    format: 'yyyy-mm-dd hh:ii:ss'
  });
  var pagHtml = '<div class="pull-left pagination-detail delete-cancel">'
              +'<input id="selectAll" type="checkbox" name="dc" style="margin-left:10px !important;margin-right:15px !important">'
              +'<a id="close" href="javascript:void(0)" name="dc" class="btn btn-primary">'
              +'<i class="glyphicon glyphicon-eye-close"></i>批量关闭'
              +'</a>'
              +'<a id="remove" href="javascript:void(0)" name="dc" class="btn btn-danger">'
              +'<i class="glyphicon glyphicon-remove"></i>批量删除'
              +'</a></div>';
  function initTable() {
    $table.bootstrapTable({
      height: getHeight(),
      queryParams:queryParams,
      columns: [
        [
          {
            field: 'state',
            checkbox: true,
            align: 'center',
            valign: 'middle'
          },{
            field: 'order_no',
            title: '订单编号',
            align: 'center'
          },{
            title: '提交时间',
            field: 'created_at',
            align: 'center',
            valign: 'middle'
          },{
            title: '用户账号',
            field: 'weapp_user.nickname',
            align: 'center',
            valign: 'middle',
          },{
            title: '订单金额',
            field: 'payment',
            align: 'center',
            valign: 'middle',
            formatter : function (value, row, index) {
              return '￥'+value/100;
            }
          },{
            title: '支付方式',
            field: 'paid_type',
            align: 'center',
            valign: 'middle',
            formatter: payTypeFormatter
          },{
            title:'订单状态',
            field: 'status',
            align: 'center',
            formatter :statusFormatter
          },{
            field: 'operate',
            title: '操作',
            align: 'center',
            events: operateEvents,
            formatter : operateFormatter
          }
        ]
      ],
      responseHandler: function (res) {
        return res.data;
      }
    });
    setTimeout(function () {
      $table.bootstrapTable('resetView');
    }, 200);

    $(window).resize(function () {
      $table.bootstrapTable('resetView', {
        height: getHeight()
      });
    });
    $table.on('check.bs.table uncheck.bs.table ' +
    'check-all.bs.table uncheck-all.bs.table', function () {
      $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
      selections = getIdSelections();
    });

    $table.on('load-success.bs.table',function(data){
      //pushanniu
      if($('.delete-cancel').length == 0){
        $('.fixed-table-pagination').prepend(pagHtml);
      }
    });

    $(".box").bind('click','.dc',function(e){
      if(e.target.getAttribute('name') != 'dc')return;
      if(e.target.id == 'selectAll'){
        if($('#selectAll').is(':checked')){
          $table.bootstrapTable('checkAll');
        }else{
          $table.bootstrapTable('uncheckAll');
        }
      }
      if(e.target.id == 'close'){
        //关闭多个订单
        var ids = getIdSelections();
        if(ids.length == 0){
          $.notify({
            message: "请选择订单"
          },{
            type: 'success',
            placement: {
              from: "top",
              align: "center"
            },
          })
          return;
        }
        bootbox.confirm({
          size: "small",
          title: "警告",
          message: '确定要关闭这些订单吗',
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
            if(result){
              closeOrder(ids);
            }
          }
        })
      }

      if(e.target.id == 'remove'){
        //删除多个用户
        var ids = getIdSelections();
        if(ids.length == 0){
          $.notify({
            message: "请选择订单"
          },{
            type: 'success',
            placement: {
              from: "top",
              align: "center"
            },
          })
          return;
        }
        bootbox.confirm({
          size: "small",
          title: "警告",
          message: '确定要删除这些订单吗？',
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
            //关闭单个订单
            if (result) {
              deleteOrder(ids);
            }
          }
        })
      }
    })
  }

  function queryParams(params){
    return {
      receiver_name:$("input[name='receiver-name']").val(),
      goods_value:$("input[name='goods-value']").val(),
      start_time:$("input[name='start-time']").val(),
      end_time:$("input[name='end-time']").val(),
      limit:params.limit,
      offset:params.offset,
    }
  }

  $("#search-query").click(function() {
    $table.bootstrapTable('refresh');
  });

  function statusFormatter(value, row, index) {
    var label = '';
    if(value == $no_pay){
      label = '待付款';
    }else if (value == $no_deliver) {
      label = '待发货';
    }else if (value == $no_receipt) {
      label = '待收货';
    }else if (value == $complete) {
      label = '已完成';
    }else if (value == $cancel) {
      label = '已取消';
    }
    return label;
  }

  function payTypeFormatter(value, row, index) {
    var label = '未支付';
    if(row.status != $no_pay && row.status != $cancel){
      if(value == 'wxpay'){
        label = '微信';
      }else if(value == 'alipay'){
        label = '支付宝';
      }else if(value == 'unionpay'){
        label = '银联';
      }else{
        label = '其他';
      }
    }
    return label;
  }

  function operateFormatter(value, row, index) {
    var str = '';
    str += '<a href="javascript:void(0);" class="order-detail" style="margin-right:15px">详情</a>';
    if(row.status == $no_pay){
      str += '<a href="javascript:void(0);" class="order-close">关闭</a>';
    }
    return str;
  }

  window.operateEvents = {
    'click .order-detail': function (e, value, row, index) {
      location.pathname = "shop/order/detail2/" + row.id;
    },
    'click .order-close': function (e, value, row, index) {
      bootbox.confirm({
        size: "small",
        title: "警告",
        message: '确定要关闭该订单吗',
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
          //关闭单个订单
          if (result) {
            closeOrder([row.id]);
          }
        }
      })
    }
  };

  function getIdSelections() {
    return $.map($table.bootstrapTable('getSelections'), function (row) {
      return row.id;
    });
  }

  function getOrderNoSelections() {
    return $.map($table.bootstrapTable('getSelections'), function (row) {
      return row.order_no;
    });
  }

  function getHeight() {
    return $(window).height() - $('#box-body').offset().top - 32;
  }

  function deleteOrder(ids){
    $.post('/ajax/shop/order/delete', {id: ids}, function (json) {
      if (json.code == 200) {
        $.notify({
          message: "删除订单成功"
        },{
          type: 'success',
          placement: {
            from: "top",
            align: "center"
          },
        })
        $table.bootstrapTable('remove', {
          field: 'id',
          values: ids
        });
          $('.fixed-table-pagination').prepend(pagHtml);
      } else if (json.code == 401) {
        location.pathname = '/login';
      } else {
        alert( json.error);
      }
    }, 'json')
  }

  function closeOrder(ids){
    $.post('/ajax/shop/order/cancel', {id:ids}, function (json) {
      if (json.code == 200) {
        $.notify({
          message: "关闭订单成功"
        },{
          type: 'success',
          placement: {
            from: "top",
            align: "center"
          },
        })
        $table.bootstrapTable('refresh', {
        });
      } else if (json.code == 401) {
        location.pathname = '/login';
      } else {
        bootbox.alert({
          title: '<span class="text-danger">错误</span>',
          message: json.error,
        });
      }

    }, 'json')
  }
  $(function () {
    initTable();
  });
})
</script>
@stop
