@extends('layouts.my_page')
@section('content')

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
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#" id="all" data-toggle="tab" aria-expanded="true">所有优惠券</a></li>
                    <li class=""><a href="#" id="nostart" data-toggle="tab" aria-expanded="true">未开始</a></li>
                    <li class=""><a href="#" id="inhand" data-toggle="tab" aria-expanded="true">进行中</a></li>
                    <li class=""><a href="#" id="invalid" data-toggle="tab" aria-expanded="true">已失效</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="couponManage">
                              <div id="toolbar">
                                   <div class="btn btn-primary" data-toggle="modal" id="buttonAddCoupon" data-target="#addCoupon">新建优惠券</div>
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
                                       data-url="/ajax/shop/coupon/list"
                                       data-response-handler="responseHandler">
                                </table>
                              </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

                <div class="modal fade" id="shopCouponLink" tabindex="-1" role="dialog" aria-hidden="true">
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



                <div class="modal fade" id="addCoupon" tabindex="-1" role="dialog" aria-hidden="true">
                   <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title">新建优惠券</h4>
                            </div>
                            <div class="modal-body">
                                  <form role="form" id="addCouponForm" action="javascript:void(0)">
                                    <input type="hidden" name="coupon_id" id="coupon_id" value="">
                                    <input type="hidden" name="edit_type" id="edit_type" value="1">
                                    <div class="form-group">  
                                        <label class="control-label" for="name">优惠券名称:</label>  
                                        <input type="text" class="form-control" name="name" maxlength="10" value="" placeholder="最多支持10个字" />
                                    </div>

                                    <div class="form-group">  
                                        <label class="control-label" for="total">发放总量:</label>  
                                        <input type="number" name="total" class="form-control" value="" placeholder="请输入大于零的整数" />
                                    </div>

                                    <div class="form-group">  
                                        <label class="control-label" for="value">优惠形式:</label>  
                                        <div>
                                          面值：<input type="number" name="value" style="width: 80px;" value="" class="input-sm" />
                                          <span id="div_value_random_to" style="display: none;">
                                          至 <input type="number" style="width: 80px;" name="value_random_to" value="" class="input-sm" /> 元
                                          </span>
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="is_random" id="is_random" value="1" /> 随机
                                           </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">  
                                        <label class="control-label" for="at_least">使用门槛:</label>  
                                        <div>
                                            <label class="radio-inline">
                                              <input type="radio" name="is_at_least" id="is_at_least_0" value="0" checked /> 不限制
                                            </label>
                                            <label class="radio-inline">
                                              <input type="radio" name="is_at_least" id="is_at_least_1" value="1" /> 满 <input type="number" style="width: 80px;" name="at_least" value="" class="input-sm" />元可使用
                                            </label>
                                        </div> 
                                    </div>  

                                    <div class="form-group">  
                                        <label class="control-label" for="quota">每人限领:</label>  
                                        <select name="quota" class="form-control" >
                                              <option value="0" selected="">不限张</option>
                                              <option value="1">1张</option>
                                              <option value="2">2张</option>
                                              <option value="3">3张</option>
                                              <option value="4">4张</option>
                                              <option value="5">5张</option>
                                              <option value="10">10张</option>
                                          </select>
                                    </div>

                                    <div class="form-group">  
                                        <label class="control-label">有效期:</label>
                                        <div>
                                        <label>
                                            <input type="radio" name="date_type" value="1" id="date_type_1" checked /> 固定日期 
                                            <input type="text"  name="start_at" placeholder="开始时间"  class="input-sm datetimepicker" /> - 
                                            <input type="text" name="end_at" placeholder="过期时间" value="" class="input-sm datetimepicker" /> 
                                        </label>
                                        <label>
                                            <input type="radio" name="date_type" id="date_type_2" value="2" /> 领到券当日开始
                                            <input type="number" name="fixed_term" style="width: 80px;" value="" class="input-sm" />天内有效
                                        </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                      <label for="name">使用说明:</label>
                                      <textarea class="form-control" name="description" rows="3" placeholder="最多支持200个字" ></textarea>
                                    </div>
                                </form>                                    
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-primary" id="addRecord">提交</button>
                            </div>
                        </div>
                    </div>
                </div>          

@stop

@section('adminlte_js')
<script type="text/javascript" src="{{ asset('js/zclip/jquery.zclip.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {

    // 日期控件
    $('.datetimepicker').datetimepicker({
        autoclose: true,
        language: 'zh-CN',
        format: 'yyyy-mm-dd hh:ii:ss'
    });

  var $table = $('#table'),
      $remove = $('#remove'),
      type = 'all',
      condition = true,
      selections = [];

  function initTable() {
      $table.bootstrapTable({
          height: getHeight(),
          queryParams:queryParams,
          columns: [
              [
                {
                      title: '编号',
                      field: 'id',
                      align: 'center',
                      valign: 'middle',
                      sortable: true
                  },{
                      field: 'name',
                      title: '优惠券名称',
                      sortable: true,
                      editable: true,
                      align: 'center'
                  },{
                      field: 'name',
                      title: '价值',
                      sortable: true,
                      editable: true,
                      align: 'center',
                      formatter: function (value, row) {
                        var html = "";
                        if(row.is_random == 0) {
                            html += row.value;
                        } else {
                            html += row.value + " ~ " + row.value_random_to;
                        }
                        if(row.at_least > 0) {
                          html += '<p class="gray">最低消费: ￥'+row.at_least+'</p>';
                        }
                        return html;
                      }
                  },{
                      field: 'name',
                      title: '领取限制 ',
                      sortable: true,
                      editable: true,
                      align: 'center',
                      formatter: function (value, row) {
                        var html = "";
                        if(row.quota == 0) {
                            html += "不限张数";
                        } else {
                            html += "一人"+row.quota+"张";
                        }
                        html += '<p class="gray">库存：'+row.total+'</p>';
                        return html;                      
                      }
                  },{
                      field: 'total_num',
                      title: '有效期',
                      sortable: true,
                      editable: true,
                      align: 'center',
                      formatter: function (value, row) {
                        var html = "";
                        if(row.date_type == 1) {
                            html += row.start_at + "至" + row.end_at;
                        } else {
                            html += "领到券当日开始"+row.fixed_term+"天内有效";
                        }
                        return html;
                      }
                  },{
                      field: 'total_num',
                      title: '领取人/次',
                      sortable: true,
                      editable: true,
                      align: 'center',
                      formatter: function (value, row) {
                        return  '<a href="/shop/coupon/user/'+row.id+'/type/1">' + row.total_user_taked + "</a>/" + row.total_take;
                      }
                  },{
                      field: 'total_used',
                      title: '已使用',
                      sortable: true,
                      editable: true,
                      align: 'center',
                      formatter: function (value, row) {
                        return  '<a href="/shop/coupon/user/'+row.id+'/type/2">' + row.total_used + "</a>";
                      }
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

  function queryParams(params){
    if(params.sort == undefined) {
        params.sort = 'id';
        params.order = 'desc';
    }
    if(condition) {
        params.order = 'desc';
        params.search = '';
        condition = false;
    }
    params.type = type;
    return params;
  }

  function operateFormatter(value, row, index) {
     //
     if(row.is_invalid == 1) {
          var operateDate = [   
              '<span class="gray">',
              '已失效',
              '</span> '
          ];
     } else {
       if(row.status == 1)  {
          var operateDate = [   
              '<a class="edit" href="javascript:void(0)" title="编辑">',
              '编辑',
              '</a>  ',
              '<a class="disabled" href="javascript:void(0)" title="使失效">',
              '使失效',
              '</a>  ',
              '<a class="spread" href="javascript:void(0)" title="推广">',
              '推广',
              '</a>'
          ];
       } else if(row.status == 2) {
          var operateDate = [   
              '<a class="edit2" href="javascript:void(0)" title="编辑">',
              '编辑',
              '</a>  ',
              '<a class="disabled" href="javascript:void(0)" title="使失效">',
              '使失效',
              '</a>  ',
              '<a class="spread" href="javascript:void(0)" title="推广">',
              '推广',
              '</a>'
          ];
       } else {
          var operateDate = [   
              '<span class="gray">',
              '已失效',
              '</span> '
          ];
       }
     }


      return operateDate.join('');
  }
  window.operateEvents = {
      'click .edit': function (e, value, row, index) {
        $.getJSON('/ajax/shop/coupon/' + row.id,function(json) {
          $('#addCoupon').modal('show');
            if(json.data) {
                var coupon = json.data;
                $("#coupon_id").val(row.id);
                $("input[name='name']").val(coupon.name);
                $("input[name='total']").val(coupon.total);
                $("input[name='value']").val(coupon.value);
                if(coupon.is_random == 1) {
                  $("input[name='is_random']").attr("checked","checked");
                  $("input[name='value_random_to']").val(coupon.value_random_to);
                  $("#div_value_random_to").show();
                }
                
                if(coupon.at_least > 0 ) {
                  $("input[name='at_least']").val(coupon.at_least);
                  $("#is_at_least_1").attr("checked","checked");
                } else {
                  $("#is_at_least_0").attr("checked","checked");
                }
                $("select[name='quota']").val(coupon.quota);
                if(coupon.date_type == 1) {
                  $("input[name='start_at']").val(coupon.start_at);
                  $("input[name='end_at']").val(coupon.end_at);
                  $("#date_type_1").attr("checked","checked");
                } else if(coupon.date_type == 2) {
                  $("input[name='fixed_term']").val(coupon.fixed_term);
                  $("#date_type_2").attr("checked","checked");
                }
                $("input[name='description']").val(coupon.description);
            }else{
                bootbox.alert({
                    title: '<span class="text-danger">错误</span>',
                    message: "优惠券不存在",
                });
            }
        });
      },

      'click .edit2': function (e, value, row, index) {
        $.getJSON('/ajax/shop/coupon/' + row.id,function(json) {
          $('#addCoupon').modal('show');
            if(json.data) {
                var coupon = json.data;
                $("#coupon_id").val(row.id);
                $("#edit_type").val(2);
                $("input[name='name']").val(coupon.name);
                $("input[name='total']").val(coupon.total);
                $("input[name='value']").val(coupon.value);
                if(coupon.is_random == 1) {
                  $("input[name='is_random']").attr("checked","checked");
                  $("input[name='value_random_to']").val(coupon.value_random_to);
                  $("#div_value_random_to").show();
                } else {
                  $("input[name='is_random']").removeAttr("checked");
                  $("#div_value_random_to").hide();
                }
                
                if(coupon.at_least > 0 ) {
                  $("input[name='at_least']").val(coupon.at_least);
                  $("#is_at_least_1").attr("checked","checked");
                } else {
                  $("#is_at_least_0").attr("checked","checked");
                }
                $("select[name='quota']").val(coupon.quota);
                if(coupon.date_type == 1) {
                  $("input[name='start_at']").val(coupon.start_at);
                  $("input[name='end_at']").val(coupon.end_at);
                  $("#date_type_1").attr("checked","checked");
                } else if(coupon.date_type == 2) {
                  $("input[name='fixed_term']").val(coupon.fixed_term);
                  $("#date_type_2").attr("checked","checked");
                }
                $("textarea[name='description']").val(coupon.description);
                $("select[name='quota']").attr('disabled','disabled');
                $("textarea[name='description']").attr('disabled','disabled');
                
                $('#addCouponForm input').each(function() {

                  if($(this).attr('name') != 'name' && $(this).attr('name') != 'total'  && $(this).attr('name') != 'coupon_id' ) {
                    $(this).attr('disabled','disabled');
                  }
                });
            }else{
                bootbox.alert({
                    title: '<span class="text-danger">错误</span>',
                    message: "优惠券不存在",
                });
            }
        });
      },

      'click .disabled': function (e, value, row, index) {
          bootbox.confirm({
              size: "small",
              title: "警告",
              message: '确定让这组优惠券['+row.name+']失效',
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
                    $.post('/ajax/shop/coupon/invalid/' + row.id , function (json) {
                        if (json.code == 200) {
                            $.notify({
                                message: "设置优惠券成功"
                            },{
                                type: 'info',
                                placement: {
                                    from: "top",
                                    align: "center"
                                }
                            });
                            $('#addCoupon').modal('hide');
                            $table.bootstrapTable('selectPage', 1);
                        } else if (json.code == 401) {
                            location.pathname = '/login';
                        } else {
                            bootbox.alert({
                                title: '<span class="text-danger">错误</span>',
                                message: json.error,
                            });
                        }

                    }, 'json').error(function(response) {
                      var errorMsg = "";
                      $.each(response.responseJSON, function(index, content){
                          errorMsg += "<p>" + content[0] + "<p/>";
                          //alert(content[0]);
                      });
                      bootbox.alert({
                          title: '<span class="text-danger">错误</span>',
                          message: errorMsg,
                      });              
                    }); 
                  }
              }
          });         
      },
      'click .spread': function (e, value, row, index) {
          $("#weapp_page_path").val($("#weapp_page_path").data("page") + "?couponId=" + row.id);
          if(row.weapp_page_code) {
            $("#weapp_page_code").attr("src",row.weapp_page_code);
            $("#weapp_page_code_down").attr("href",row.weapp_page_code);
            $('#shopCouponLink').modal('show');
          } else {
              $.getJSON('/ajax/shop/coupon/weapp_code/' + row.id,function(json) {
                if(json.code == 200 && json.data) {
                  $("#weapp_page_code").attr("src",json.data);
                  $("#weapp_page_code_down").attr("href",json.data);
                  $('#shopCouponLink').modal('show');
                } else {
                    bootbox.alert({
                        title: '<span class="text-danger">错误</span>',
                        message: json.error,
                    });
                }
              });
          }
          
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

      },
      'click .remove': function (e, value, row, index) {
          bootbox.confirm({
              size: "small",
              title: "警告",
              message: '确定要删除优惠券：' + row.name,
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
                      $.post('/ajax/shop/coupon/delete', {'id': [row.id]}, function (json) {
                          if (json.code == 200) {
                              $.notify({
                                  message: "删除优惠券" + row.name + "成功"
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

                      }, 'json')
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
    $("#buttonAddCoupon").click(function () {
        $("#addCouponForm")[0].reset();
        $("select[name='quota']").removeAttr('disabled');
        $("textarea[name='description']").removeAttr('disabled');
        
        $('#addCouponForm input').each(function() {
          if($(this).attr('name') != 'name' && $(this).attr('name') != 'total' ) {
            $(this).removeAttr('disabled');
          }
        });
        $("#edit_type").val(1);
    });
    $("#is_random").click(function() {
      if($(this).is(':checked')) {
        $("#div_value_random_to").show();
      } else {
        $("#div_value_random_to").hide();
      }
    });

    $("#addRecord").click(function(){
            var data = $("#addCouponForm").serialize();
            var id = $("#coupon_id").val();
            var edit_type = $("#edit_type").val();
            $("#addRecord").attr("disabled","disabled");
            if(!id) {
              addCoupon(data);
            } else {
              updateCoupon(id,data,edit_type);
            }
            $("#addRecord").removeAttr("disabled");
    });


        $('#all').click(function () {
            type = '';
            $('.search .form-control').val('');
            condition = true;
            $table.bootstrapTable('refresh');
        });
        $('#nostart').click(function () {
            type = 'nostart';
            $('.search .form-control').val('');
            condition = true;
            $table.bootstrapTable('refresh');
        });
        $('#inhand').click(function () {
            $('.search .form-control').val('');
            condition = true;
            type = 'inhand';
            $table.bootstrapTable('refresh');
        });
        $('#invalid').click(function () {
            $('.search .form-control').val('');
            condition = true;
            type = 'invalid';
            $table.bootstrapTable('refresh');
        });

  });

function updateCoupon(id,data,edit_type) {
    var url = '/ajax/shop/coupon/save/' + id;
    if(edit_type == 2) {
        url = '/ajax/shop/coupon/save2/' + id;
    }
    $.post(url, data , function (json) {
          if (json.code == 200) {
              $.notify({
                  message: "更新优惠券成功"
              },{
                  type: 'info',
                  placement: {
                      from: "top",
                      align: "center"
                  }
              });
              $('#addCoupon').modal('hide');
              $table.bootstrapTable('selectPage', 1);
          } else if (json.code == 401) {
              location.pathname = '/login';
          } else {
              bootbox.alert({
                  title: '<span class="text-danger">错误</span>',
                  message: json.error,
              });
          }

      }, 'json').error(function(response) {
        var errorMsg = "";
        $.each(response.responseJSON, function(index, content){
            errorMsg += "<p>" + content[0] + "<p/>";
            //alert(content[0]);
        });
        bootbox.alert({
            title: '<span class="text-danger">错误</span>',
            message: errorMsg,
        });              
      });
}

  function addCoupon(data) {
      $.post('/ajax/shop/coupon/create', data , function (json) {
          if (json.code == 200) {
              $.notify({
                  message: "新建优惠券成功"
              },{
                  type: 'info',
                  placement: {
                      from: "top",
                      align: "center"
                  }
              });
              $('#addCoupon').modal('hide');
              $table.bootstrapTable('selectPage', 1);
              window.location.reload();
          } else if (json.code == 401) {
              location.pathname = '/login';
          } else {
              bootbox.alert({
                  title: '<span class="text-danger">错误</span>',
                  message: json.error,
              });
          }

      }, 'json').error(function(response) {
        var errorMsg = "";
        $.each(response.responseJSON, function(index, content){
            errorMsg += "<p>" + content[0] + "<p/>";
            //alert(content[0]);
        });
        bootbox.alert({
            title: '<span class="text-danger">错误</span>',
            message: errorMsg,
        });              
      });
  }
});
</script>
@stop
