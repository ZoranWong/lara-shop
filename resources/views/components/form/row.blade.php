<div class="row" {!! $attributes !!}>
    @foreach($fields as $field)
    <div class="col-md-{{ $field['width'] }}">
        {!! $field['element']->render() !!}
    </div>
    @endforeach
</div>