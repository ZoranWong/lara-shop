<div class="input-group">
    <div class="input-group-addon">
        {{$label}}<i class="fa fa-calendar"></i>
    </div>
    <input type="text" class="form-control" id="{{$id}}" placeholder="{{$label}}" name="{{$name}}" value="{{ request($name, $value) }}">
</div>