<div class="input-group">
    <div class="input-group-addon">
        {{$label}}
    </div>
    <select class="form-control {{ $class }}" name="{{$name}}[]" multiple style="width: 100%;">
        <option></option>
        @foreach($options as $select => $option)
            <option value="{{$select}}" {{ in_array((string)$select, request($name, [])) || in_array((string)$select, (array)$value)  ?'selected':'' }}>{{$option}}</option>
        @endforeach
    </select>
</div>