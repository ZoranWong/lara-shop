@extends('layouts.manager_page')

@section('content_header')
      <h1>
         店铺列表
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/store">Store</a></li>
        <li class="active">index</li>
      </ol>
@stop

@section('content')
       <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-body">
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
                     data-url="/ajax/store/list"
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
  var $table = $('#table');
  function initTable() {
      $table.bootstrapTable({
          height: getHeight(),
          columns: [
              [
                  {
                      title: '店铺ID',
                      field: 'id',
                      align: 'center',
                      valign: 'middle',
                      sortable: true
                  }, {
                      field: 'name',
                      title: '店铺名称',
                      sortable: true,
                      editable: true,
                      align: 'center'
                  }, {
                      field: 'contact_mobile',
                      title: '手机号',
                      sortable: true,
                      align: 'center'
                  }, {
                      field: 'operate',
                      title: '操作',
                      align: 'center',
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
  }



  function operateFormatter(value, row, index) {
      var operateDate = [
          '<a class="edit" href="javascript:void(0)" title="编辑">',
          '<i class="glyphicon glyphicon-edit"></i>',
          '编辑权限',
          '</a>  '
      ];
      return operateDate.join('');
  }

  window.operateEvents = {
      'click .edit': function (e, value, row, index) {
          location.pathname = "/store/edit/" + row.id;
      }
  };


  function getHeight() {
      return $(window).height() - $('h1').outerHeight(true);
  }

  $(function () {
    initTable();
  });
})
</script>
@stop