@extends('layouts.master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">
        @include('layouts.partials.header')
        @include('layouts.partials.menu')
        <!-- Content Wrapper. Contains page content pjax-container-->
        <div class="content-wrapper pjax-container" id="pjax-container">
            {!! \App\Renders\Facades\SectionContent::link() !!}
            {!! \App\Renders\Facades\SectionContent::css() !!}
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
            {!! \App\Renders\Facades\SectionContent::jsLoad() !!}
            <script>
                if(window.zoukeApp === undefined){
                    window.zoukeApp = {};
                }

                if(window.zoukeApp){
                    console.log('install');
                    window.zoukeApp.siteBootUp = function () {
                        if(window.pageInit != undefined && window.pageInit)
                            window.pageInit();
                        {!! \App\Renders\Facades\SectionContent::script() !!}
                    }
                }
            </script>
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
