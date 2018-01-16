@extends('layouts.my_page')
@section('css')
  <link rel="stylesheet" href="{{ asset('design/main.ed03af95.css') }}">
@stop
<style>
  .van-swipe .van-swipe-item, 
  .van-swipe .van-swipe__track,
  .van-swipe .cap-image-ad__link{
    height: auto;
  }
  .zent-table div{
    box-sizing: content-box;
  }
  .zent-design .zent-design-preview{
    box-sizing: content-box;
  }
</style>
@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header with-border">
          <h3 class="box-title">新增页面</h3>
      </div>
      <div class="box-body">
          <div id="root"></div>
      </div>
    </div>
  </div>
</div>
@stop

@section('js')
  <script type="text/javascript" src="{{ asset('design/main.29ebf4bc.js') }}"></script>
@stop
