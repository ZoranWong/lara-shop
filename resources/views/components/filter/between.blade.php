<div class="form-group col-md-5 col-sm-12 filter-group">
    <div class="input-group">
        <div class="input-group-addon">{{$label}}</div>
        <input type="{{$type}}" class="form-control {{$class}}" placeholder="{{$label}}" name="{{$name['start']}}" value="{{ request($name['start'], array_get($value, 'start')) }}">
        <span class="input-group-addon" style="border-left: 0; border-right: 0;">-</span>
        <input type="{{$type}}" class="form-control {{$class}}" placeholder="{{$label}}" name="{{$name['end']}}" value="{{ request($name['end'], array_get($value, 'end')) }}">
    </div>
</div>