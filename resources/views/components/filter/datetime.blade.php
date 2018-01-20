<div class="input-group col-md-3 col-sm-2 filter-group">
    <div class="input-group-addon">
        {{$label}}<i class="fa fa-calendar"></i>
    </div>
    <input type="text" class="form-control pull-right datepicker" id="{{$id}}" placeholder="{{$label}}" name="{{$name}}" value="{{ request($name, $value) }}">
</div>