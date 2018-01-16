@extends('layouts.manager_page')

@section('content_header')
  <h1>
     编辑用户
  </h1>
  <ol class="breadcrumb">
    <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/user">User</a></li>
    <li class="active">edit</li>
  </ol>
@stop

@section('content')
	<div class="row">
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">编辑用户</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" id="form">
              <div class="box-body">
                <div class="form-group has-feedback">
                  <label for="inputName" class="col-sm-2 control-label">用户名</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nick_name" id="inputName"  placeholder="用户名" required>
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
                <div class="form-group has-feedback">
                  <label for="inputMobile" class="col-sm-2 control-label">手机号</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="mobile" id="inputMobile" placeholder="手机号"
                           pattern="^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9])\d{8}$"
                           required>
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success">保存</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (right) -->
      </div>
@stop
@section('adminlte_js')
  <script>
    $(document).ready(function () {
        var id = {{ $id }};
        $.getJSON('/ajax/user/' + id,function (json) {
            $('#inputMobile').val(json.data.mobile);
            $('#inputName').val(json.data.nick_name);
        })
        $('#form').validator().on('submit', function (e) {
            if(!e.isDefaultPrevented()){
                e.preventDefault();
                var data = $(e.target).serialize();
                $.post('/ajax/user/save/' + id , data , function (json) {
                    if(json.code == 200 ){
                        bootbox.alert({
                            title: '<span class="text-success">成功</span>',
                            message:'更新用户成功',
                            callback: function () {
                                location.pathname = '/user';
                            }
                        });
                    }else if(json.code == 401){
                        location.pathname = '/login';
                    }else{
                        bootbox.alert({
                            title: '<span class="text-danger">错误</span>',
                            message: json.error,
                        });
                    }
                }, 'json')
            }
        })
    })
  </script>
@stop