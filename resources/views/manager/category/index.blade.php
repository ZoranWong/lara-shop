@extends('layouts.page')
@section('content')
<style>
.box-header{padding-bottom:0px;padding-top: 0px}
.box-header div{float:left;width:80px;height:50px;text-align: center;line-height: 50px}
.box-body-left{width:93px;float:left;background: #fff;position: relative}
.box-body-left div{height:50px;width:100%;line-height: 50px;text-align: center}
.box-body-left div a{color:#444;font-size: 17px}
.status-left{border-left: 2px solid #337AB7}
.btn-sm{margin-left: 4px}
.box-body-right{width:88%;float:left;background: #fff;position: relative;border-left:2px solid #D2D6DE }
</style>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <div class="goods-status" data-status="1">
          <h3 class="box-title">商品分组</h3>
        </div>
      </div>
      <div class="col-xs-12" style="background-color:#fff;padding-left: 0px">
        <div class="box-body-right">
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                  <tr>
                    <th>分组名称<span class="label label-success" style="margin-left:20px"><a href="javascript:void(0)" id="add-category" style="color:#fff">新建分组</a></span></th>
                    <th>商品数</th>
                    <th>创建时间</th>
                    <th><button type="button" class="btn btn-sm btn-info" id="btn-ref">刷新</button></th>
                  </tr>
                </thead>
                <tbody id="category-tbody">
                  <tr><td>数据加载中。。。。。。</td></tr>
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
<script type="text/javascript" src="{{ asset('js/zclip/jquery.zclip.js') }}"></script>
<script>
$(document).ready(function () {
  var historyUrl = document.referrer;
  var categoryArr = [];
  if(historyUrl.substr(historyUrl.length-5,5) != 'goods'){
    $("#historyBack").find('a').attr('href',historyUrl);
    $("#historyBack").show();
  }
  function getCategory(){
    $.getJSON('/ajax/category/list', function (json) {
      var data = json.data;
      var categoryHtml = '';
      for(var i in data){
        categoryArr.push(data[i].name);
        if(data[i].created_at == null)data[i].created_at = '-';
        categoryHtml += '<tr id="tr'+data[i].id+'"><td><span id="span'+data[i].id+'">'+data[i].name+'</span><input type="text" style="display:none" id="name'+data[i].id+'" value="'+data[i].name+'"></td><td>'+data[i].goods_num+'</td><td>'+data[i].created_at+'</td>';

        categoryHtml += '<td><button type="button" class="btn btn-sm btn-primary category-edit" name="edit" data-id="'+data[i].id+'" id="bj'+data[i].id+'">编辑</button>';

        categoryHtml += '<button type="button" style="display:none" class="btn btn-sm btn-success category-sub-edit" name="subEdit" data-id="'+data[i].id+'" id="sub-edit'+data[i].id+'">确定</button>';

        categoryHtml += '<button type="button" class="btn btn-sm btn-success" name="spread" value="'+data[i].id+'" id="sub-spread'+data[i].id+'">推广</button>';

        if(data[i].is_default != 1){
          categoryHtml += '<button type="button" class="btn btn-sm btn-danger category-delete" name="delete" data-d="'+data[i].name+'" id="'+data[i].id+'">删除</button>';
        }

        categoryHtml += '</td></tr>';
      }
      $("#category-tbody").html(categoryHtml);
    })
  }

  $("#add-category").on('click',function(){
    if($("#cate").length > 0)return;
    var addStr = '<tr id="cate"><td><input type="text" id="category" placeholder="输入分组名称"></td><td></td><td></td>'
        +'<td><button type="button" class="btn btn-block btn-success" id="sub-category">确定</button></td></tr>';
    $("#category-tbody").prepend(addStr);
  })

  $("#category-tbody").bind('click','.btn',function(e){
    if(e.target.getAttribute('name') == 'edit'){
      var id = e.target.getAttribute('data-id');
      $("#span"+id).hide();
      $("#name"+id).show();
      $("#bj"+id).hide();
      $("#sub-edit"+id).show();
    }

    if(e.target.getAttribute('name') == 'subEdit'){
      var id = e.target.getAttribute('data-id');
      var category = $.trim($("#name"+id).val());
      if(category.length == 0)return;
      if($.inArray(category,categoryArr) > -1){
        bootbox.alert({
          title: '<span class="text-danger">提示</span>',
          message: '此分组已存在，请修改后再添加',
        });
        return;
      }
      if(category.lenght > 30){
        bootbox.alert({
          title: '<span class="text-danger">提示</span>',
          message: '名称过长，请修改后再添加',
        });
        return;
      }
      $.post('/ajax/category/save/'+id, {name:category}, function (json) {
        var data = json.data;
        if(json.code == 200){
          ref();
        }else if (json.code == 401) {
          location.pathname = '/login';
        } else {
          bootbox.alert({
            title: '<span class="text-danger">错误</span>',
            message: '修改失败',
          });
          return false;
        }
      })
    }

    if(e.target.getAttribute('name') == 'spread'){
        groupId = e.target.getAttribute('value');
        var text = $('#spread').text();
        $.post('/ajax/shop/goods/weapp/category/spread', {'category_id' : groupId}, function (json) {
            res = json.data;
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
        }, 'json');
    }

    if(e.target.getAttribute('name') == 'delete'){
      var id = e.target.id;
      var cateOne = e.target.getAttribute('data-d');
      bootbox.confirm({
        size: "small",
        title: "警告",
        message: '确定要删除这个分组吗',
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
            $.post('/ajax/category/delete', {id:[id]}, function (json) {
              var data = json.data;
              if(json.code == 200){
                if(json.hasError && json.error > 0){
                  bootbox.alert({
                    title: '<span class="text-danger">提示</span>',
                    message: '该分组下有商品，无法删除',
                  });
                }else{
                  categoryArr.splice($.inArray(cateOne,categoryArr),1);
                  ref();
                }
              }else if (json.code == 401) {
                location.pathname = '/login';
              } else {
                bootbox.alert({
                  title: '<span class="text-danger">错误</span>',
                  message: '删除失败',
                });
                return false;
              }
            })
          }
        }
      })
    }
  })

  $("#category-tbody").bind('click','#sub-category',function(e){
    if(e.target.id != 'sub-category')return;
    var category = $.trim($("#category").val());
    if(category.length == 0)return;
    if($.inArray(category,categoryArr) > -1){
      bootbox.alert({
        title: '<span class="text-danger">提示</span>',
        message: '此分组已存在，请修改后再添加',
      });
      return;
    }
    if(category.lenght > 30){
      bootbox.alert({
        title: '<span class="text-danger">提示</span>',
        message: '名称过长，请修改后再添加',
      });
      return;
    }
    $('#sub-category').attr('disabled', 'disabled');
    $('#sub-category').text('正在提交中');
    $.post('/ajax/category/create', {name:category,parent_id:0}, function (json) {
      var data = json.data;
      if(json.code == 200){
        ref();
      }else if (json.code == 401) {
        location.pathname = '/login';
      } else {
        bootbox.alert({
          title: '<span class="text-danger">错误</span>',
          message: '新增失败',
        });
        $('#sub-category').removeAttr('disabled');
        $('#sub-category').text('确定');
        return false;
      }
    })
  })

  $("#btn-ref").on('click',function(){
    ref();
  })

  function ref(){
    $("#category-tbody").html('<tr><td>数据加载中。。。。。。</td></tr>');
    getCategory();
  }


  getCategory();
})
</script>
  <script type="text/template" id="spread">
      <!-- /*查看某商品独立佣金详情 */ -->
      <div class="form-group" style="height:320px;">
          <div class="col-sm-2" style="padding-top: 120px;"> 小程序码</div>
          <div class="col-sm-10" >
            <div style="margin-left: 80px;">微信“扫一扫”小程序访问</div>

            <img src="" id="mini_code" width="300px;"/>
            <div style="margin-left: 100px;margin-bottom: 10px;margin-top: -10px;"><a href="" id="weapp_code">下载小程序码</a></div>
          </div>

      </div>
      <div class="col-sm-2">
          小程序路径
      </div>
      <div class="col-sm-10 input-group form-group" style="line-height:21px;">
          <input type="text"
                 class="form-control"
                 name="path" id="path" disabled><span id="copy_word" style="font-size:12px; color:#ab9a9a;" class="input-group-addon">复制</span>
      </div>

      <script type="text/javascript">
          $('#mini_code').attr('src',res.mini_code);
          $('#path').val(res.path);
          $('#copy_word').click(function(){
            $(this).zclip({
              path: "{{asset('js/zclip/ZeroClipboard.swf')}}",
              copy: function(){
                  return res.path;
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
          $('#weapp_code').click(function(){
              $(this).attr('href', '/ajax/shop/goods/downloadImage?mini_code=' + res.mini_code + '&type=category&id=' + groupId);
          });

      </script>
  </script>
@stop

@section('adminlte_js')

@stop
