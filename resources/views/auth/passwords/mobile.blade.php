@extends('layouts.my')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">{{ trans('user.password_reset_message') }}</p>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ url('password/reset') }}" id="reset_password_form" method="post">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('mobile') ? 'has-error' : '' }}">
                    <input type="text" name="mobile" class="form-control" maxlength="11" value="{{ $mobile or old('mobile') }}"
                           placeholder="{{ trans('user.mobile') }}">
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                    @if ($errors->has('mobile'))
                        <span class="help-block">
                            <strong id="mobilemsg">{{ $errors->first('mobile') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('code') ? 'has-error' : '' }}">
                    <input type="text" name="code" class="form-control"
                           placeholder="请输入验证码" style="width: 220px;float: left;">
                    <a class="btn btn-success" id="getcode" style="width: 100px;background-color: #c1c1c1;border-color:#c1c1c1;">发送验证码</a>
                    @if ($errors->has('code'))
                        <span class="help-block">
                            <strong>{{ $errors->first('code') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control"
                           placeholder="{{ trans('user.make_password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="{{ trans('user.retype_password') }}">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" id="reset_password_button" class="btn btn-primary btn-block btn-flat">{{ trans('user.send_password_reset_link') }}</button>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@stop

@section('adminlte_js')
    @yield('js')
    <script>
        $(document).ready(function () {
            $("input[name=mobile]").bind('input propertychange', function() {
                var mobile = $("input[name=mobile]").val();
                if(/^1[34578]\d{9}$/.test(mobile)){
                    $('#getcode').css({'background-color':'#00a65a','border-color':'#008d4c'});
                }else{
                    $('#getcode').css({'background-color':'#c1c1c1','border-color':'#c1c1c1'});
                }
            });
            $("#reset_password_form").submit(function () {
                var url = $("#reset_password_form").attr('action');
                var data = $("#reset_password_form").serialize();
                $.post(url,data,function (data) {
                    if(data.success) {
                        alert('重置密码成功');
                        window.location.href = "{{url('login')}}";
                    } else {
                        alert(data.error);
                    }
                });
                return false;
            });
            $('#getcode').click(function () {
                var mobile = $("input[name=mobile]").val();
                if(!(/^1[34578]\d{9}$/.test(mobile))) {
                    alert('请填写正确的手机号');
                    return;
                }
                $('#getcode').attr('class','btn btn-success disabled');
                $('#getcode').css({'background-color':'#c1c1c1','border-color':'#c1c1c1'});
                $.post('/sms/send/password-reset-code?mobile='+mobile,function (data) {
                    if(data.success) {
                        var nums = 60;
                        $('#getcode').text('重新发送('+nums+'s)');
                        clock = setInterval(doLoop, 1000); //一秒执行一次
                        function doLoop() {
                            nums--;
                            if (nums > 0) {
                                $('#getcode').text('重新发送('+nums+'s)');
                            } else {
                                clearInterval(clock); //清除js定时器
                                $('#getcode').css({'background-color':'#00a65a','border-color':'#008d4c'});
                                $('#getcode').text('获取验证码');
                                $('#getcode').attr('class','btn btn-success');
                                nums = 60; //重置时间
                            }
                        }
                    }else {
                        $('#getcode').css({'background-color':'#00a65a','border-color':'#008d4c'});
                        $('#getcode').attr('class','btn btn-success');
                        alert(data.error);
                    }
                });
            });
        });
    </script>
@stop
