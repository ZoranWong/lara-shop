@extends('layouts.manager_page')

@section('content_header')
      <h1>
         帐号列表
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/user">User</a></li>
        <li class="active">index</li>
      </ol>
@stop

@section('content')
       <div class="row">
        <div class="col-xs-12">

          <div class="box">
              <div id="toolbar">
                  <a id="add" href="{{ url('user/add') }}" class="btn btn-primary">
                      <i class="glyphicon glyphicon-plus"></i>新增用户
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
                     data-url="/ajax/user/list"
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
                      title: '用户ID',
                      field: 'id',
                      align: 'center',
                      valign: 'middle',
                      sortable: true
                  }, {
                      field: 'nick_name',
                      title: '用户名',
                      sortable: true,
                      editable: true,
                      align: 'center'
                  }, {
                      field: 'mobile',
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
              message: '确定要删除用户：' + names,
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

                      $.post('/ajax/user/delete', {'id': ids}, function (json) {
                          if (json.code == 200) {
                              $.notify({
                                  message: "删除用户" + row.nick_name + "成功"
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
          var manager_id = {{ Auth::id() }}
          if( manager_id != row.id){
            return row.id
          }
      });
  }

    function getNameSelections() {
        return $.map($table.bootstrapTable('getSelections'), function (row) {
            var manager_id = {{ Auth::id() }}
            if( manager_id != row.id){
                return row.nick_name;
            }
        });
    }


  function operateFormatter(value, row, index) {
      var manager_id = {{ Auth::id() }};
      var operateDate = [];
      if((manager_id ==1 && row.id == 1) || (row.id !=1)) {
          operateDate = [
              '<a class="edit" href="javascript:void(0)" title="编辑">',
              '<i class="glyphicon glyphicon-edit"></i>',
              '</a>  '
          ];
      }
      if(row.id != manager_id && row.id != 1){
            operateDate.push(
                '<a class="remove" href="javascript:void(0)" title="删除">',
                '<i class="glyphicon glyphicon-remove"></i>',
                '</a>',
                '<a class="wrench" href="javascript:void(0)" title="角色管理">',
                '<i class="glyphicon glyphicon-wrench"></li>',
                '</a>'
            );
      }
      return operateDate.join('');
  }
  window.operateEvents = {
      'click .edit': function (e, value, row, index) {
          location.pathname = "/user/edit/" + row.id;
      },
      'click .wrench':function (e, value, row, index) {
          var rolemanage = $('#rolemanage').text();
          $.getJSON('/ajax/user/rolemanage/edit?id='+row.id,function (json) {
              $('#rolesel').append('<input type="hidden" id="userport" name="user_id" value="'+row.id+'"/>');
              $.each(json.data,function(i,val){
                  if(val.status === 1) {
                      $('#rolesel').append(
                          '<div class="checkbox">',
                          '<label>',
                          '<input type="checkbox" name="role_id" value="'+val.id+'" checked/>'+val.display_name+'('+val.name+')',
                          '</label>',
                          '</div>'
                      );
                  }else {
                      $('#rolesel').append(
                          '<div class="checkbox">',
                          '<label>',
                          '<input type="checkbox" name="role_id" value="'+val.id+'"/>'+val.display_name+'('+val.name+')',
                          '</label>',
                          '</div>'
                      );
                  }
              });
          });
          bootbox.dialog({
              'title' : '角色管理',
              'message' : rolemanage,
          });
      },
      'click .remove': function (e, value, row, index) {
          bootbox.confirm({
              size: "small",
              title: "警告",
              message: '确定要删除用户：' + row.nick_name,
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
                      //删除单个用户
                      $.post('/ajax/user/delete',{'id':[row.id]},function (json) {
                          if(json.code == 200 ){
                              $.notify({
                                  message: "删除用户" + row.nick_name + "成功"
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
                          }else if(json.code == 401){
                              location.pathname = '/login';
                          }else{
                              bootbox.alert({
                                  title: '<span class="text-danger">错误</span>',
                                  message: json.error,
                              });
                          }
                      },'json')
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
<script type="text/template" id="rolemanage">
    <div>
    <h4>选择角色</h4>
    <form role="form">
        <div id="rolesel" class="content"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            <button type="button" class="btn btn-primary" id="commitrole">提交</button>
        </div>
    </form>
    </div>
    <script type="text/javascript">
        $(function() {
            $('#commitrole').click(function () {
                var rd = new FormData();
                var userid = $('#userport').val();
                var str = new Array();
                var i = 0;
                $("input[name='role_id']:checked").each(function(){
                    str[i]=$(this).val();
                    i++;
                });
                rd.append('role',str);
                rd.append('user_id',userid);
                $.ajax({
                    url: "ajax/user/rolemanage/save",
                    dataType: "json",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data:rd,
                    success: function(data){
                        //
                        if(data.data) {
                            alert('设置成功');
                        } else {
                            alert('设置失败');
                        }
                    }
                });
            });
        });
    </script>
</script>
@stop