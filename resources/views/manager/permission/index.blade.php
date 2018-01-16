@extends('layouts.manager_page')

@section('content_header')
      <h1>
         权限列表
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/permission">permission</a></li>
        <li class="active">index</li>
      </ol>
@stop

@section('content')
       <div class="row">
        <div class="col-xs-12">

          <div class="box">
              <div id="toolbar">
                  <a id="add" href="{{ url('permission/add') }}" class="btn btn-primary">
                      <i class="glyphicon glyphicon-plus"></i>新增权限
                  </a>
                  <button id="remove" class="btn btn-danger" disabled>
                      <i class="glyphicon glyphicon-remove"></i>批量删除
                  </button>
              </div>
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
                     data-url="/ajax/permission/list"
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
      selections = [];


  function initTable() {
      $table.bootstrapTable({
          height: getHeight(),
          columns: [
              [
                  {
                      field: 'state',
                      checkbox: true,
                      align: 'center',
                      valign: 'middle'
                  }, {
                      title: '权限ID',
                      field: 'id',
                      align: 'center',
                      valign: 'middle',
                      sortable: true
                  }, {
                      field: 'name',
                      title: '权限名',
                      sortable: true,
                      editable: true,
                      align: 'center'
                  }, {
                      field: 'display_name',
                      title: '显示名',
                      sortable: true,
                      editable: true,
                      align: 'center'
                  }, {
                      field: 'description',
                      title: '描述',
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
      $table.on('check.bs.table uncheck.bs.table ' +
              'check-all.bs.table uncheck-all.bs.table', function () {
          $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
          selections = getIdSelections();
      });
      $remove.click(function () {
          //删除多个用户
          var ids = getIdSelections();
          var names = getNameSelections().join(',');
          bootbox.confirm({
              size: "small",
              title: "警告",
              message: '确定要删除权限：' + names,
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

                      $.post('/ajax/permission/delete', {'id': ids}, function (json) {
                          if (json.code == 200) {
                              $.notify({
                                  message: "删除权限" + names + "成功"
                              },{
                                  type: 'success',
                                  placement: {
                                      from: "top",
                                      align: "center"
                                  },
                              });
                              $table.bootstrapTable('remove', {
                                  field: 'id',
                                  values: ids
                              });
                              $remove.prop('disabled', true);
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
              }
          })
      })
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


  function operateFormatter(value, row, index) {
      var operateDate = [
          '<a class="edit" href="javascript:void(0)" title="编辑">',
          '<i class="glyphicon glyphicon-edit"></i>',
          '</a>  ',
          '<a class="remove" href="javascript:void(0)" title="删除">',
          '<i class="glyphicon glyphicon-remove"></i>',
          '</a>'
      ];
      return operateDate.join('');
  }
  window.operateEvents = {
      'click .edit': function (e, value, row, index) {
          location.pathname = "/permission/edit/" + row.id;
      },
      'click .remove': function (e, value, row, index) {
          bootbox.confirm({
              size: "small",
              title: "警告",
              message: '确定要删除权限：' + row.name,
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
                      //删除单个用户
                      $.post('/ajax/permission/delete', {'id': [row.id]}, function (json) {
                          if (json.code == 200) {
                              $.notify({
                                  message: "删除权限" + row.nick_name + "成功"
                              },{
                                  type: 'success',
                                  placement: {
                                      from: "top",
                                      align: "center"
                                  },
                              });
                              $table.bootstrapTable('remove', {
                                  field: 'id',
                                  values: [row.id]
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
              }
          })
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