@extends('layouts.my_page')
@section('content')
<style>
.edit-a-sort{color:#337ab7;width:20px;height:20px;display:block;margin: 0 auto}
.goods-info-float{float:left;padding-left: 5px;text-align: left}
.btn-margin{margin-left: 3px;margin-top: -3px;height:30px;width:40px;padding: 0 0;}
.edit-sort{display:none}
.box-header{padding-bottom:0px;padding-top: 0px}
.box-header div{float:left;width:80px;height:50px;text-align: center;line-height: 50px}
.chose-cate{position: relative;margin-top: 10px;margin-bottom: 10px;margin-right: 5px}
.status-bottom{border-bottom: 2px solid #337AB7}
.status-left{border-left: 2px solid #337AB7}
.goods-status{cursor:pointer}
.box-body-left{width:93px;float:left;background: #fff;position: relative}
.box-body-left div{height:50px;width:100%;line-height: 50px;text-align: center}
.box-body-left div a{color:#444;font-size: 17px}
.box-body-right{width:88%;float:left;background: #fff;position: relative;border-left:2px solid #D2D6DE }
.delete-cancel a{margin-right: 4px}
</style>
<div class="row">
    <div class="col-xs-12" style="padding: 0;">
        <div class="box" style="margin-bottom: 0;">
          <div class="box-header with-border" style="padding-left: 25px;">
            <div class="goods-status status-bottom" data-status="1">
                <h3 class="box-title">出售中</h3>
            </div>
            <div class="goods-status" data-status="2">
                <h3 class="box-title">已售罄</h3>
            </div>
            <div class="goods-status" data-status="0">
                <h3 class="box-title">仓库中</h3>
            </div>
          </div>
        </div>
    </div>
    <div class="col-xs-12" style="background-color:#fff;">

            <div id="toolbar" style="width:100%">
              <a id="up" href="javascript:void(0)" class="btn btn-info" style="display:none">
                  <i class="glyphicon glyphicon-saved"></i>上架
              </a>
                <a id="close" href="javascript:void(0)" class="btn btn-primary">
                    <i class="glyphicon glyphicon-eye-close"></i>下架
                </a>
                <a id="remove" href="javascript:void(0)" class="btn btn-danger">
                    <i class="glyphicon glyphicon-remove"></i>删除
                </a>
                <a id="add" href="{{ url('shop/goods/add') }}" class="btn btn-primary">
                    <i class="glyphicon glyphicon-plus"></i>发布商品
                </a>
            </div>
            <div class="box-body" id="box-body">
                <table id="table"
                    data-toolbar="#toolbar"
                    data-search="true"
                    data-striped="true"
                    data-show-refresh="true"
                    data-strict-search="true"
                    data-search-on-enter-key="true"
                    data-pagination="true"
                    data-id-field="id"
                    data-page-size="10"
                    data-page-list="[10]"
                    data-show-footer="false"
                    data-side-pagination="server"
                    data-url="/ajax/shop/goods/list"
                    data-response-handler="responseHandler">
                </table>
            </div>
    </div>
    <div class="box-body" id="box-body">
      <table id="table"
      data-toolbar="#toolbar"
      data-search="true"
      data-striped="true"
      data-show-refresh="true"
      data-strict-search="true"
      data-search-on-enter-key="true"
      data-pagination="true"
      data-id-field="id"
      data-page-size="10"
      data-page-list="[10]"
      data-show-footer="false"
      data-side-pagination="server"
      data-url="/ajax/shop/goods/list"
      data-response-handler="responseHandler">
    </table>
  </div>
</div>
</div>
</div>
<!-- /.row -->
@stop

@section('adminlte_js')
<script>
$(document).ready(function () {
  var $table = $('#table'),
  $remove = $('#remove'),
  $close = $('#close'),
  $up = $('#up')
  statusCheck = 1,
  cateCheck = 0,
  status = 1,
  selections = [];
  var pagHtml = '<div class="pull-left pagination-detail delete-cancel">'
              +'<input id="selectAll" type="checkbox" name="dc" style="margin-left:10px !important;margin-right:15px !important">'
              +'<a id="up" href="javascript:void(0)" name="dc" class="btn btn-info dc" style="display:none;">'
              +'<i class="glyphicon glyphicon-saved"></i>上架'
              +'</a>'
              +'<a id="close" href="javascript:void(0)" name="dc" class="btn btn-primary dc">'
              +'<i class="glyphicon glyphicon-eye-close"></i>下架'
              +'</a>'
              +'<a id="remove" href="javascript:void(0)" name="dc" class="btn btn-danger dc">'
              +'<i class="glyphicon glyphicon-remove"></i>删除'
              +'</a>'
              +'</div>';
  var isfresh = false;
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
            title: '商品信息',
            field: 'id',
            align: 'center',
            valign: 'middle',
            sortable: false,
            formatter:goodsInfoFormatter
          },
          {
            title: '库存',
            field: 'stock_num',
            align: 'center',
            valign: 'middle'
          },{
            title: '销量',
            field: 'sell_num',
            align: 'center',
            valign: 'middle'
          },{
            title: '创建时间',
            field: 'created_at',
            align: 'center',
            valign: 'middle'
          },{
            title: '序号',
            field: 'sort',
            align: 'center',
            valign: 'middle',
            events: sortEvents,
            formatter:sortFormatter
          },{
            title: '操作',
            field: 'operate',
            align: 'center',
            valign: 'middle',
            events: operateEvents,
            formatter: operateFormatter
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

    //push分组进入toolbar
    $.get('/ajax/shop/category/list', {}, function (json) {
      if (json.code == 200) {
        var data = json.data;
        var str = '<div class="pull-right chose-cate"><select class="form-control" id="chose-cate"><option value="0">所有分组</option>';
        for(var i in data){
          str += '<option value="'+data[i].id+'">'+data[i].name+"</option>"
        }
        str += '</select></div>';
        $('.fixed-table-toolbar').append(str);
      } else if (json.code == 401) {
        location.pathname = '/login';
      }
    }, 'json')
    $table.on('load-success.bs.table',function(data){
      //pushanniu
      if($('.delete-cancel').length == 0){
        $('.fixed-table-pagination').prepend(getPushHtml());
      }
    });

    //push 按钮进入分页
    $table.on('check.bs.table uncheck.bs.table ' +
    'check-all.bs.table uncheck-all.bs.table', function () {
      $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
      selections = getIdSelections();
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
      if(e.target.id == 'up'){
        var ids = getIdSelections();
        if(ids.length == 0){
          $.notify({
            message: "请选择商品"
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
          message: '确定要上架这些商品吗',
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
              upGoods(ids);
            }
          }
        })
      }
      if(e.target.id == 'close'){
        var ids = getIdSelections();
        if(ids.length == 0){
          $.notify({
            message: "请选择商品"
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
          message: '确定要下架这些商品吗',
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
              closeGoods(ids);
            }
          }
        })
      }
      if(e.target.id == 'remove'){
        var ids = getIdSelections();
        if(ids.length == 0){
          $.notify({
            message: "请选择商品"
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
          message: '确定要删除这些商品吗？',
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
              deleteGoods(ids);
            }
          }
        })
      }
    })
  }

  function queryParams(params){
    var offset = params.offset;
    var categoryId = $("#chose-cate").val();
    var limit = params.limit;
    var search = params.search;
    if(categoryId != 'undefined' && categoryId != undefined){
      if(statusCheck != status || cateCheck != categoryId){
        offset = 0;
        search = '';
        limit = 10;
      }
      statusCheck = status;
      cateCheck = categoryId;
    }
    return {
      status:status,
      category_id:categoryId,
      limit:limit,
      offset:offset,
      search:search
    }
  }

  $(".box").bind('change','#chose-cate',function(e){
    if(e.target.id != 'chose-cate')return;
    $table.bootstrapTable('refresh',{
    });
  })

  //点击样式变化
  $(".goods-status").on('click',function(){
    status = $(this).data('status');
    $(this).addClass('status-bottom');
    $(this).siblings('.goods-status').removeClass('status-bottom');
    $("#chose-cate").val(0);
    if(status == 0){
      isfresh = true;
      $("#up").show();
      $("#close").hide();
    }else{
      isfresh = false;
      $("#up").hide();
      $("#close").show();
    }
    $table.bootstrapTable('refresh',{

    });
  })

  window.sortEvents = {
    'click .edit-a-sort': function (e, value, row, index) {
      $(this).hide();
      $(this).siblings('div').show();
    },
    'click .sort-edit-fail': function (e, value, row, index) {
      $('#edit-sort-'+row.id).hide();
      $('#edit-a-sort-'+row.id).show();
    },
    'click .sort-edit-success': function (e, value, row, index) {
      var sort = $("#sort-"+row.id).val();
      var $self = $(this);
      var alertLog = '';
      if(isNaN(sort)){
        alertLog = '排序参数必须为数字';
      }
      if(sort < 0){
        alertLog = '排序参数不能为负数';
      }
      if(sort > row.stock_num){
        alertLog = '排序参数不能大于当前商品库存';
      }
      if(alertLog.length > 0){
        bootbox.alert({
          title: '<span class="text-danger">提示</span>',
          message: alertLog,
        });
        return false;
      }
      $self.attr('disabled', 'disabled');
      $.post('/ajax/shop/goods/sort/'+row.id, {sort:sort}, function (json) {
        if (json.code == 200) {
          $table.bootstrapTable('refresh', {
          });
        } else if (json.code == 401) {
          location.pathname = '/login';
        } else {
          bootbox.alert({
            title: '<span class="text-danger">错误</span>',
            message: '编辑失败',
          });
          $self.removeAttr('disabled');
          return false;
        }
      }, 'json')
    },
  }

  function sortFormatter(value,row,index){
    var label = '<a href="javascript:void(0);" class="edit-a-sort" id="edit-a-sort-'+row.id+'">'+value+'</a>';
    label += '<div class="edit-sort" id="edit-sort-'+row.id+'"><input type="number" value="'+value+'" min="0" max="'+row.stock_num+'" id="sort-'+row.id+'" style="border:1px solid #006DC9;border-radius:2px;width:60px;height:30px;">';
    label += '<button type="button" class="btn btn-primary btn-margin sort-edit-success"><i class="fa fa-fw fa-check"></i></button>';
    label += '<button type="button" class="btn btn-info btn-margin sort-edit-fail"><i class="fa fa-fw fa-close"></i></button></div>';
    return label;
  }

  function goodsInfoFormatter(value, row, index){
    var label = '<div class="goods-info-float"><img src="'+row.image_url+'" style="height:50px;width:80px"></div>'
    + '<div class="goods-info-float">' + row.name + '<br>￥' + row.sell_price/100 + '</div>';
    return label;
  }

  function priceFormatter(value, row, index) {
    var label = '';
    if(value) {
      label = '￥' + value;
    }
    return label;
  }

  function statusFormatter(value, row, index) {
    var label = '';
    if(value == 1) {
      label = '上架';
    } else {
      label = '下架';
    }
    return label;
  }

  function operateFormatter(value, row, index) {
    var label = '<a href="javascript:void(0);" class="goods-edit">编辑</a>';
    return label;
  }

  window.operateEvents = {
    'click .goods-edit': function (e, value, row, index) {
      location.pathname = "/shop/goods/edit/" + row.id;
    },
    'click .goods-up':function(e, value, row, index){
    }
  };

  function getIdSelections() {
    return $.map($table.bootstrapTable('getSelections'), function (row) {
      return row.id;
    });
  }

  function getHeight() {
    return $(window).height() - $('#box-body').offset().top - 32;
  }


  function deleteGoods(ids){
    $.post('/ajax/shop/goods/delete', {id: ids}, function (json) {
      if (json.code == 200) {
        $.notify({
          message: "删除商品成功"
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
      $('.fixed-table-pagination').prepend(getPushHtml());
      } else if (json.code == 401) {
        location.pathname = '/login';
      } else {
        alert( json.error);
      }
    }, 'json')
  }

  function closeGoods(ids){
    $.post('/ajax/shop/goods/close', {id:ids}, function (json) {
      if (json.code == 200) {
        $.notify({
          message: "下架商品成功"
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
        $('.fixed-table-pagination').prepend(getPushHtml());
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

  function upGoods(ids){
    $.post('/ajax/shop/goods/up', {id: ids}, function (json) {
      if (json.code == 200) {
        $.notify({
          message: "商品上架成功"
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
        $('.fixed-table-pagination').prepend(getPushHtml());
      } else if (json.code == 401) {
        location.pathname = '/login';
      } else {
        alert( json.error);
      }
    }, 'json')
  }

  function getPushHtml(){
    var pushHtml = pagHtml;
    if(isfresh){
      var pagHtm = '<div class="pull-left pagination-detail delete-cancel">'
                  +'<input id="selectAll" type="checkbox" name="dc" style="margin-left:10px !important;margin-right:15px !important">'
                  +'<a id="up" href="javascript:void(0)" name="dc" class="btn btn-info dc">'
                  +'<i class="glyphicon glyphicon-saved"></i>上架'
                  +'</a>'
                  +'<a id="close" href="javascript:void(0)" name="dc" class="btn btn-primary dc" style="display:none">'
                  +'<i class="glyphicon glyphicon-eye-close"></i>下架'
                  +'</a>'
                  +'<a id="remove" href="javascript:void(0)" name="dc" class="btn btn-danger dc">'
                  +'<i class="glyphicon glyphicon-remove"></i>删除'
                  +'</a>'
                  +'</div>';
        pushHtml = pagHtm;
    }
    return pushHtml;
  }

  $(function () {
    initTable();
  });
})
</script>
@stop
