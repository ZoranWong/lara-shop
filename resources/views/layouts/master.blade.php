<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
    @yield('title', config('adminlte.title', 'AdminLTE 2'))
    @yield('title_postfix', config('adminlte.title_postfix', ''))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
    {{--<link rel="stylesheet" href="https://getbootstrap.com/dist/css/bootstrap.min.css">--}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">--}}
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("/vendor/adminlte/dist/css/skins/" . config('admin.skin') .".min.css") }}">
    {!! \App\Renders\Facades\SectionContent::link() !!}
    <link rel="stylesheet" href="{{ asset("/vendor/laravel-admin/laravel-admin/laravel-admin.css") }}">
    <link rel="stylesheet" href="{{ asset("/vendor/laravel-admin/nprogress/nprogress.css") }}">
    <link rel="stylesheet" href="{{ asset("/vendor/laravel-admin/sweetalert/dist/sweetalert.css") }}">
    <link rel="stylesheet" href="{{ asset("/vendor/laravel-admin/nestable/nestable.css") }}">
    <link rel="stylesheet" href="{{ asset("/vendor/laravel-admin/toastr/build/toastr.min.css") }}">
    <link rel="stylesheet" href="{{ asset("/vendor/laravel-admin/bootstrap3-editable/css/bootstrap-editable.css") }}">
    <link rel="stylesheet" href="{{ asset("/vendor/laravel-admin/google-fonts/fonts.css") }}">
    {{--<link rel="stylesheet" href="{{ asset("/vendor/laravel-admin/AdminLTE/bootstrap/dist/css/AdminLTE.min.css") }}">--}}
    <link rel="stylesheet" href="{{ asset("/vendor/adminlte/dist/css/AdminLTE.min.css") }}">

    <!-- REQUIRED JS SCRIPTS -->
    {{--<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.js') }}"></script>--}}
    {{--<script src="{{ asset('/bower_components/jquery/dist/jquery.js') }}"></script>--}}
    {{--<script src="{{ asset('/bower_components/jquery/dist/jquery.slim.min.js') }}"></script>--}}
    {{--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>--}}
    <script src="{{ asset ("/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
    <script src="https://getbootstrap.com/assets/js/vendor/popper.min.js"></script>
    <script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.js') }}"></script>
    {{--<script src="https://getbootstrap.com/dist/js/bootstrap.min.js"></script>--}}
    {{--<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.js') }}"></script>--}}
    {{--<script src="{{ asset ("/vendor/laravel-admin/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>--}}
    <script src="{{ asset ("/vendor/adminlte/dist/js/adminlte.min.js") }}"></script>
    <script src="{{ asset ("/bower_components/jquery-pjax/jquery.pjax.js") }}"></script>
    <script src="{{ asset ("/vendor/laravel-admin/nprogress/nprogress.js") }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.js') }}"></script>


    @if(config('adminlte.plugins.select2'))
        <!-- Select2 -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    @endif

    <!-- Theme style -->
    {{--<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-table/dist/bootstrap-table.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/dropzone/dist/min/basic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/dropzone/dist/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2-bootstrap.min.css') }}">--}}



    @if(config('adminlte.plugins.datatables'))
        <!-- DataTables -->
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    @endif

    @yield('adminlte_css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition  @yield('body_class')">
{{--<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>--}}

{{--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>--}}
<script src="{{ asset('bower_components/bootstrap-table/dist/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-table/dist/locale/bootstrap-table-zh-CN.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-table/dist/extensions/multiple-search/bootstrap-table-multiple-search.min.js') }}"></script>
<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('bower_components/jquery-inputlist/jquery.inputlist.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-validator/dist/validator.min.js') }}"></script>
<script src="{{ asset('bower_components/bootbox.js/bootbox.js') }}"></script>
<script src="{{ asset('bower_components/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.js') }}"></script>
<script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/moment/min/locales.min.js') }}"></script>
<script src="{{ asset('bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('bower_components/dropzone/dist/min/dropzone.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-validator/dist/validator.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
@if(config('adminlte.plugins.select2'))
    <!-- Select2 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@endif

@if(config('adminlte.plugins.datatables'))
    <!-- DataTables -->
    <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
@endif
<!-- ./wrapper -->
@yield('body')
<script>
    function LA() {}
    LA.token = "{{ csrf_token() }}";
</script>

<!-- REQUIRED JS SCRIPTS -->
<script src="{{ asset ("/vendor/laravel-admin/nestable/jquery.nestable.js") }}"></script>
<script src="{{ asset ("/vendor/laravel-admin/toastr/build/toastr.min.js") }}"></script>
<script src="{{ asset ("/vendor/laravel-admin/bootstrap3-editable/js/bootstrap-editable.min.js") }}"></script>
<script src="{{ asset ("/vendor/laravel-admin/sweetalert/dist/sweetalert.min.js") }}"></script>
{!! \App\Renders\Facades\SectionContent::js() !!}
<script src="{{ asset ("/vendor/laravel-admin/laravel-admin/laravel-admin.js") }}"></script>
@yield('adminlte_js')
</body>
</html>
