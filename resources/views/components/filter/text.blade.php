<div class="input-group">
    <div class="form-control input-group-addon col-md-2">
        {{$label}}
    </div>
    <input type="{{ $type }}" class="form-control {{ $id }}" placeholder="{{$placeholder}}" name="{{$name}}" value="{{ request($name, $value) }}">
</div>