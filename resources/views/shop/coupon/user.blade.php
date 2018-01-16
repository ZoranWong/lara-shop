@extends('layouts.my_page')
@section('content')
<style type="text/css">
  .fans-box .fans-avatar {
    float: left;
    width: 60px;
    height: 60px;
    background: #eee;
    overflow: hidden;
}
.fans-box .fans-msg {
    float: left;
}
.fans-box .fans-msg p {
    padding: 0 10px;
    text-align: left;
}
</style>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand" href="#">营销管理</a>
    </div>
    <div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="/shop/coupon">优惠券</a></li>
        </ul>
    </div>
    </div>
</nav>
       <div class="row">
        <div class="col-xs-12">
            <div class="box">
              <div id="toolbar">
                    <span>已领取列表</span> <span class="gray"> | </span>
                    <span class="orange" style="color: #f60;"></span>
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
                               data-page-list="[10, 25, 50, 100, ALL]"
                               data-show-footer="false"
                               data-side-pagination="server"
                               data-url="/ajax/shop/coupon/{{ $id }}/user?type={{ $type }}"
                               data-response-handler="responseHandler">
                        </table>
                  </div>
            </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

@stop

@section('adminlte_js')
<script type="text/javascript">
$(document).ready(function () {

  var $table = $('#table'),
      $remove = $('#remove'),
      selections = [];

  function initTable() {
      $table.bootstrapTable({
          height: getHeight(),
          columns: [
              [
                {
                      title: '编号',
                      field: 'id',
                      align: 'center',
                      valign: 'middle',
                      sortable: true
                  },{
                      field: 'weapp_user_id',
                      title: '用户',
                      sortable: true,
                      editable: true,
                      align: 'center',
                      formatter:function(value,row) {
                        var html = '<div class="fans-box clearfix"><div class="fans-avatar">';
                        html +='<img src="'+row.weapp_user.headimgurl+'" width="60" height="60"></div>';
                        html += '<div class="fans-msg"><p>'+row.weapp_user.nickname+'</p></div></div>';

                        return html;
                      }
                  },{
                      field: 'created_at',
                      title: '领取时间',
                      sortable: true,
                      editable: true,
                      align: 'center'
                  },{
                      field: 'value',
                      title: '价值',
                      sortable: true,
                      editable: true,
                      align: 'center'
                  },{
                      field: 'used_at',
                      title: '使用时间',
                      sortable: true,
                      editable: true,
                      align: 'center'
                  },{
                      field: 'order_no',
                      title: '订单详情',
                      sortable: true,
                      editable: true,
                      align: 'center',
                      formatter: function (value, row) {
                        if(row.order_id > 0) {
                          return  '<a href="/shop/order/detail2/'+row.order_id+'" target="_blank">详情</a>';
                        } else {
                          return '-';
                        }
                      }
                  },{
                      field: 'used_at',
                      title: '状态',
                      sortable: true,
                      editable: true,
                      align: 'center',
                      formatter: function (value, row) {
                        if(row.order_id > 0) {
                          return '<span class="label label-default">已使用</span>';
                        } else {
                           return '<span class="label label-default">未使用</span>';
                        }
                      }
                  }
              ]
          ],
          responseHandler: function (res) {
              $("#toolbar .orange").html(res.data.coupon.name);
              return res.data.coupon_user;
          }
      });
      setTimeout(function () {
          $table.bootstrapTable('resetView');
      }, 200);
      $table.on('check.bs.table uncheck.bs.table ' +
              'check-all.bs.table uncheck-all.bs.table', function () {
          $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
          selections = getIdSelections();
      });
      $(window).resize(function () {
          $table.bootstrapTable('resetView', {
              height: getHeight()
          });
      });
  }


  function getIdSelections() {
      return $.map($table.bootstrapTable('getSelections'), function (row) {
            return row.id;
      });
  }

    function getNameSelections() {
        return $.map($table.bootstrapTable('getSelections'), function (row) {
                return row.name;
        });
    }

  function getHeight() {
      return $(window).height() - $('#box-body').offset().top - 32;
  }

  $(function () {
    initTable();
  });
});
</script>
@stop
