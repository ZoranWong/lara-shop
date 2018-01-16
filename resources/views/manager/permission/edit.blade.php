@extends('layouts.manager_page')

@section('content_header')
  <h1>
     编辑用户
  </h1>
  <ol class="breadcrumb">
    <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/role">Role</a></li>
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
                  <div class="form-group  has-feedback">
                      <label for="inputName" class="col-sm-2 control-label">权限名</label>
                      <div class="col-sm-10">
                          <input type="" class="form-control" id="inputName"
                                 placeholder="权限名"
                                 autocomplete="off"
                                 name="name"
                                 required>
                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                          <div class="help-block with-errors"></div>
                      </div>
                  </div>
                  <div class="form-group  has-feedback">
                      <label for="inputDisname" class="col-sm-2 control-label">显示名称</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputDisname"
                                 placeholder="显示名称"
                                 autocomplete="off"
                                 name="display_name"
                                 required>
                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                          <div class="help-block with-errors"></div>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="inputDesc" class="col-sm-2 control-label">描述</label>
                      <div class="col-sm-10">
                          <textarea type="text" class="form-control" id="inputDesc"
                                    placeholder="描述"
                                    autocomplete="off"
                                    name="description">
                          </textarea>
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
        $.getJSON('/ajax/role/' + id,function (json) {
            $('#inputName').val(json.data.name);
            $('#inputDisname').val(json.data.display_name);
            $('#inputDesc').val(json.data.description);

        })
        $('#form').validator().on('submit', function (e) {
            if(!e.isDefaultPrevented()){
                e.preventDefault();
                var data = $(e.target).serialize();
                $.post('/ajax/permission/save/' + id , data , function (json) {
                    if(json.code == 200 ){
                        bootbox.alert({
                            title: '<span class="text-success">成功</span>',
                            message:'更新权限成功',
                            callback: function () {
                                location.pathname = '/permission';
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