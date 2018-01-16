@extends('layouts.my_page')
@include('layouts.vue_base')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                @include('shop.design.tab', ['active' => 'nav'])
                <div class="box-body" id="app">
                    <designnav></designNnav>
                </div>
            </div>
        </div>
    </div>
@stop