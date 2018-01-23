<div class="input-group">
    <div class="input-group-addon">
        {{$label}}
    </div>
    <input type="{{ $type }}" class="form-control {{ $class }}" placeholder="{{$placeholder}}" name="{{$name}}" value="{{ request($name, $value) }}">
</div>