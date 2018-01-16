@extends('layouts.my_page')
@section('content')
       <div class="row">
        <div class="col-xs-12">

          <div class="box">
            @include('shop.design.tab', ['active' => 'index'])
            <div id="toolbar">
                <a id="add" href="{{ url('shop/design/add') }}" class="btn btn-primary">
                    <i class="glyphicon glyphicon-plus"></i>新增页面
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
                     data-page-list="[10, 25, 50, 100, ALL]"
                     data-show-footer="false"
                     data-side-pagination="server"
                     data-url="/ajax/shop/page/list"
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
      <div class="modal fade" id="weappPageCouponLink" tabindex="-1" role="dialog" aria-hidden="true">
                   <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title" id="myModalLabel">查看</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="javascript:void(0)">
                                      <div class="form-group" style="height:320px;"> 
                                          <div class="col-sm-2" style="padding-top: 120px;"> 小程序码</div>
                                          <div class="col-sm-10" >
                                            <div style="margin-left: 80px;">微信“扫一扫”小程序访问</div>

                                            <img src="" id="weapp_page_code" width="300px;"/>
                                            <div style="margin-left: 100px;margin-bottom: 10px;margin-top: 10px;"><a href="" id="weapp_page_code_down" download>下载小程序码</a></div>
                                          </div>
                                      </div>
                                      <div class="col-sm-2">
                                          小程序路径
                                      </div>
                                      <div class="col-sm-10 input-group form-group" style="line-height:21px;">
                                          <input type="text" class="form-control" name="weapp_page_path" data-page="{{ $page }}" id="weapp_page_path" disabled />
                                          <span id="weapp_page_path_copy" style="font-size:12px; color:#ab9a9a;" class="input-group-addon">复制</span>
                                      </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            </div>
                        </div>
                    </div>
                </div>    
@stop

@section('adminlte_js')
<script type="text/javascript" src="{{ asset('js/zclip/jquery.zclip.js') }}"></script>
<script>
$(document).ready(function () {
  var $table = $('#table'),
      $remove = $('#remove'),
      selections = [];

$('#weappPageCouponLink').on("shown.bs.modal", function() {
  $("#weapp_page_path_copy").zclip({
      path: "{{asset('js/zclip/ZeroClipboard.swf')}}",
      copy: function() {
          return $("#weapp_page_path").val();
      },
      beforeCopy:function(){/* 按住鼠标时的操作 */
          $(this).css("color","orange");
      },
      afterCopy:function(){/* 复制成功后的操作 */
          $(this).css("color","green");
          $(this).text('复制成功');
      }
  });
});
$('#weappPageCouponLink').on("hide.bs.modal", function() {
  $('#weapp_page_path_copy').text('复制');
  $('#weapp_page_path_copy').css({'font-size':'12px','color':'#ab9a9a'});
});
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
                  },{
                      title: 'ID',
                      field: 'id',
                      align: 'center',
                      valign: 'middle',
                      sortable: true
                  },{
                      field: 'title',
                      title: '标题',
                      sortable: true,
                      editable: true,
                      align: 'center'
                  },{
                      field: 'created_at',
                      title: '创建时间',
                      sortable: true,
                      align: 'center'
                  },{
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
                return row.title;
        });
    }


  function operateFormatter(value, row, index) {
      var setDom = row.is_homepage ? '<span style="color: #4b0;" title="当前主页">当前主页</span>' : '<a class="home" href="javascript:void(0)" title="设为主页">设为主页</a>'
      var operateDate = [
          '<a class="edit" href="javascript:void(0)" title="编辑">',
          '编辑',
          '</a>  ',
          '<a class="remove" href="javascript:void(0)" title="删除">',
          '删除',
          '</a>  ',
          '<a class="spread" href="javascript:void(0)" title="推广">',
          '推广',
          '</a>  '
      ];
      operateDate.push(setDom)
      return operateDate.join('');
  }
  window.operateEvents = {
      'click .edit': function (e, value, row, index) {
          location.pathname = "shop/design/edit/" + row.id;
      },
      'click .spread': function (e, value, row, index) {
          $("#weapp_page_path").val($("#weapp_page_path").data("page") + "?couponId=" + row.id);
          if(row.weapp_page_code) {
            $("#weapp_page_code").attr("src",row.weapp_page_code);
            $("#weapp_page_code_down").attr("href",row.weapp_page_code);
            $('#weappPageCouponLink').modal('show');
          } else {
              $.getJSON('/ajax/shop/page/weapp_code/' + row.id,function(json) {
                if(json.code == 200 && json.data) {
                  $("#weapp_page_code").attr("src",json.data);
                  $("#weapp_page_code_down").attr("href",json.data);
                  $('#weappPageCouponLink').modal('show');
                } else {
                    bootbox.alert({
                        title: '<span class="text-danger">错误</span>',
                        message: json.error,
                    });
                }
              });
          }
      },
      'click .remove': function (e, value, row, index) {
          bootbox.confirm({
              size: "small",
              title: "警告",
              message: '确定要删除页面：' + row.title,
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
                  //删除单个用户
                  if (result) {
                      $.ajax({
                        url: '/ajax/shop/page/' + row.id,
                        type: 'DELETE',
                        dataType: 'json',
                        success: function (json) {
                          if (json.code == 200) {
                              $.notify({
                                  message: "删除书籍" + row.title + "成功"
                              },{
                                  type: 'info',
                                  placement: {
                                      from: "top",
                                      align: "center"
                                  },
                              })
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
                        }
                      })
                  }
              }
          })
      },
      'click .home': function (e, value, row, index) {
          bootbox.confirm({
              size: "small",
              title: "警告",
              message: '确定将：' + row.title + '设为主页？',
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
                  //删除单个用户
                  if (result) {
                      $.post('/ajax/shop/page/homepage/' + row.id, {} , function (json) {
                        if (json.code == 200) {
                            $.notify({
                                message: row.title + "设为主页成功"
                            },{
                                type: 'info',
                                placement: {
                                    from: "top",
                                    align: "center"
                                },
                            })
                            $table.bootstrapTable('refresh')
                        } else if (json.code == 401) {
                            location.pathname = '/login';
                        } else {
                            bootbox.alert({
                                title: '<span class="text-danger">错误</span>',
                                message: json.error,
                            });
                        }
                      })
                  }
              }
          })
      },
  };


  function getHeight() {
      return $(window).height() - $('#box-body').offset().top - 32;
  }

  $(function () {
    initTable();
  });
})
</script>
@stop