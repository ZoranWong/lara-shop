@extends('layouts.page')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h5 class="box-title">@yield('box-title')</h5>
                </div>
                <div class="box-body">
                    @yield('box-body')
                </div>
            </div>
        </div>
    </div>
@stop
