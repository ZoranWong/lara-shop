@extends('layouts.master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'register-page')

@section('body')
    <div class="register-box" id="pjax-container" pjax-container>
        <div class="register-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">{{ trans('user.register_message') }}</p>
            <form action="{{ url(config('adminlte.register_url', 'register')) }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="text" name="mobile" class="form-control" value="{{ old('email') }}"
                           placeholder="{{ trans('user.mobile') }}">
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                    @if ($errors->has('mobile'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mobile') }}</strong>
                        </span>
                    @endif
                </div>
                <!--
                <div class="form-group .col-xs-3 has-feedback {{ $errors->has('sms_captcha') ? 'has-error' : '' }}">
                    <input type="text" name="sms_captcha" class="form-control" value="{{ old('sms_captcha') }}"
                           placeholder="{{ trans('user.sms_captcha') }}">               
					<span class="input-group-btn form-control-feedback">
                      <button type="button" class="btn btn-info btn-flat">{{ trans('user.btn_send_captcha') }}</button>
                    </span>
                    @if ($errors->has('sms_captcha'))
                        <span class="help-block">
                            <strong>{{ $errors->first('sms_captcha') }}</strong>
                        </span>
                    @endif
                </div>
                -->

                <div class="form-group has-feedback {{ $errors->has('nick_name') ? 'has-error' : '' }}">
                    <input type="text" name="nick_name" class="form-control" value="{{ old('name') }}"
                           placeholder="{{ trans('user.full_name') }}">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('nick_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nick_name') }}</strong>
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
                <button type="submit"
                        class="btn btn-primary btn-block btn-flat"
                >{{ trans('user.register') }}</button>
            </form>
            <div class="auth-links">
                <a href="{{ url(config('adminlte.login_url', 'login')) }}"
                   class="text-center">{{ trans('user.i_already_have_a_membership') }}</a>
            </div>
        </div>
        <!-- /.form-box -->
    </div><!-- /.register-box -->
@stop

@section('adminlte_js')
    @yield('js')
@stop
