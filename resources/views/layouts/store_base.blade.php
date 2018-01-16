@extends('layouts.master')
@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte_my.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop
@section('body')
    <div class="container">

        <!-- Static navbar -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">醉赞</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    @yield('nav_title')
                    <ul class="nav navbar-nav navbar-right">
                        <li><a class="navbar-brand user-mobile"></a></li>
                        <li>
                            @if(config('adminlte_my.logout_method') == 'GET' || !config('adminlte_my.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                <a href="{{ url(config('adminlte_my.logout_url', 'auth/logout')) }}">
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('app.log_out') }}
                                </a>
                            @else
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('app.log_out') }}
                                </a>
                                <form id="logout-form" action="{{ url(config('adminlte_my.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                    @if(config('adminlte_my.logout_method'))
                                        {{ method_field(config('adminlte_my.logout_method')) }}
                                    @endif
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>
        <section>
            <div class="col-md-12">
                <div class="info-box with-border">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-person"></i></span>

                    <div class="info-box-content pull-left" style="margin-left: 5px;">
                        <h4 class="user-name"></h4>
                        <span class="user-mobile">账号：</span>
                    </div>

                    <div class="info-box-content pull-right">

                        <div class="info-box-text">
                            <form class="form-inline">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control">
                                        <div class="input-group-addon btn btn-default">搜索</div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="info-box-text">
                            @yield('box_right_button')
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @yield('content')

    </div>
@stop
@section('adminlte_js')
    <script>
        $(document).ready(function () {
            $.getJSON('/ajax/profile', function (json) {
                var user = json.data;
                $('.user-mobile').text(user.mobile);
                $('.user-name').text(user.nick_name);
            })
        })
    </script>
    @yield('js')
@stop
