<div class="form-group col-md-5 col-sm-12 filter-group">
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control" id="{{$id['start']}}" placeholder="{{$label}}(开始)" name="{{$name['start']}}" value="{{ request($name['start'], array_get($value, 'start')) }}">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control" id="{{$id['end']}}" placeholder="{{$label}}(结束)" name="{{$name['end']}}" value="{{ request($name['end'], array_get($value, 'end')) }}">
    </div>
</div>