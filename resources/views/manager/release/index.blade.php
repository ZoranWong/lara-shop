@extends('layouts.manager_page')

@section('content_header')
      <h1>
         发布管理
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">index</li>
      </ol>
@stop

@section('content')
    <style>
        .modal-dialog {
            width: 1024px;
        }
    </style>
       <div class="row">
        <div class="col-xs-12">

          <div class="box">
              <div id="toolbar">
                  <button id="add" class="btn btn-primary">
                      <i class="glyphicon glyphicon-plus"></i>发布更新
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
                     data-url="/ajax/weapp/version/get"
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
       <div class="modal fade" id="release" tabindex="-1" role="dialog" aria-hidden="true">
           <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <button type="button" class="close" id="createAward" data-dismiss="modal" aria-hidden="true">
                           &times;
                       </button>
                       <h4 class="modal-title">新增奖品</h4>
                   </div>
                   <div class="modal-body">
                       <form role="form" class="form-horizontal" id="system_form" autocomplete="off">
                           <div class="form-group" id="form_tem">
                               <label for="template_id" class="col-sm-2 control-label"><b style="color:red;">*</b>代码模板ID：</label>
                               <div class="col-sm-8">
                                   <input type="text" class="form-control" name="template_id"  placeholder="代码模板ID"/>
                                   <span class="help-block col-sm-8"></span>
                               </div>
                           </div>
                           <div class="form-group" id="form_version">
                               <label for="version" class="col-sm-2 control-label"><b style="color:red;">*</b>小程序版本：</label>
                               <div class="col-sm-8">
                                   <input type="text" class="form-control" name="version"  placeholder="小程序版本"/>
                                   <span class="help-block col-sm-8"></span>
                               </div>
                           </div>
                           <div class="form-group">
                               <label for="description" class="col-sm-2 control-label">版本描述：</label>
                               <div class="col-sm-8">
                                   <input type="text" class="form-control" name="description"  placeholder="版本描述"/>
                                   <span class="help-block col-sm-8"></span>
                               </div>
                           </div>
                           <div class="form-group" id="form_item">
                               <label for="item_list" class="col-sm-2 control-label"><b style="color:red;">*</b>更新页面：</label>
                               <div class="col-sm-8">
                                   <table class="table table-bordered">
                                       <thead>
                                       <tr>
                                           <th>address</th>
                                           <th>title</th>
                                           <th>tag</th>
                                           <th>操作</th>
                                       </tr>
                                       </thead>
                                       <tbody id="set">
                                       </tbody>
                                   </table>
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="col-sm-2 control-label"></label>
                               <div class="col-sm-8">
                                   <button type="button" class="btn btn-primary" id="addtr">增加</button>
                               </div>
                           </div>
                       </form>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">取消</button>
                       <button type="button" class="btn btn-primary" id="addRecord">提交</button>
                   </div>
               </div>
           </div>
       </div>
@stop

@section('adminlte_js')
<script>
$(document).ready(function () {
  var $table = $('#table'),
      $remove = $('#remove'),
      trnum = 1,
      selections = [];

  $('#addtr').click(function () {
      trnum = trnum + 1;
      if($('#set tr').size() > 4) {
          alert('最多提交五条');
          return false;
      }
      $("#set tr:last").after(
          '<tr><td>' +
          '<input name="address" type="text">' +
          '</td> <td>' +
          '<input name="title" type="text"></td> <td>' +
          '<input name="tag" type="text"></td>' +
          '<td><a style="margin-left: 8px;" id="del'+trnum+'" href="javascript:void(0);"><span class="glyphicon glyphicon-remove"></span></a></td></tr>'
      );
      $('#del'+trnum).click(function () {
          if($("#set tr").size() <= 1) {
              alert('至少有一条提交');
              return false;
          }
          $(this).parent('td').parent('tr').remove();
      });
  });

  function initTable() {
      $table.bootstrapTable({
          height: getHeight(),
          columns: [
              [
                  {
                      title: 'ID',
                      field: 'id',
                      align: 'center',
                      valign: 'middle',
                      sortable: true
                  }, {
                      field: 'version',
                      title: '小程序版本',
                      sortable: true,
                      editable: true,
                      align: 'center'
                  }, {
                      field: 'description',
                      title: '描述',
                      sortable: true,
                      align: 'center'
                  }, {
                      field: 'created_at',
                      title: '发布时间',
                      sortable: true,
                      align: 'center'
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

  function getHeight() {
      return $(window).height() - $('h1').outerHeight(true);
  }

  $(function () {
    initTable();
  });

  var tab = $('#releaseVersion').text();
  $('#add').click(function () {
      trnum = 1;
      $('#release input').val('');
      $('#set').html('<tr><td>' +
          '<input name="address" type="text">' +
          '</td> <td>' +
          '<input name="title" type="text"></td> <td>' +
          '<input name="tag" type="text"></td>' +
          '<td><a style="margin-left: 8px;" id="del1" href="javascript:void(0);"><span class="glyphicon glyphicon-remove"></span></a></td></tr>'
      );
      $('#del1').click(function () {
          if($("#set tr").size() <= 1) {
              alert('至少有一条提交');
              return false;
          }
          $(this).parent('td').parent('tr').remove();
      });
      $('#release').modal('show');
  });
    $('#addRecord').click(function () {
        var set = new Array();
        $('#release input[name=address]').css({"border":""});
        $('#release input[name=title]').css({"border":""});
        if(!$('input[name=template_id]').val()) {
            $('#form_tem').attr('class','form-group has-error');
            $('#form_tem span').text('请填写代码模板ID');
            return false;
        }else {
            $('#form_tem').attr('class','form-group');
            $('#form_tem span').text('');
        }
        if(!$('input[name=version]').val()) {
            $('#form_version').attr('class','form-group has-error');
            $('#form_version span').text('请填写小程序版本号');
            return false;
        }else {
            $('#form_version').attr('class','form-group');
            $('#form_version span').text('');
        }
        $('#release input[name=address]').each(function (i,val) {
            if(!$(this).val()) {
                $(this).css({"border":"1px solid red"});
                return false;
            }
        });
        $('#release input[name=title]').each(function (i,val) {
            if(!$(this).val()) {
                $(this).css({"border":"1px solid red"});
                return false;
            }
        });
        $('#set tr').each(function (i,val) {
            $(this).find("input").css({"border":""});
            var title = $(this).find("input[name=title]").val();
            var address = $(this).find("input[name=address]").val();
            var tag = $(this).find("input[name=tag]").val();
            set[i] = new Object();
            set[i].address = address;
            set[i].title = title;
            set[i].tag = tag;
        });
        var template_id = $('#release input[name=template_id]').val();
        var version = $('#release input[name=version]').val();
        var description = $('#release input[name=description]').val();
        $.post('/ajax/weapp/version/release',{item_list:set,template_id:template_id,version:version,description:description},function (data) {
            if(data.success) {
                bootbox.alert({
                    title:'提示',
                    message:'<span class="text-success">更新版本成功</span>',
                    callback:function () {
                        $("#table").bootstrapTable('refresh');
                    }
                });
                $('#release').modal('hide');
            }else {
                bootbox.alert({
                    title:'提示',
                    message:'<span class="text-fail">'+data.error+'</span>'
                });
                return false;
            }
        });
    });
})
</script>
@stop