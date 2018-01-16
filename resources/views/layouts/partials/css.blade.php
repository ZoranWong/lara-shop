@foreach($css as $c)
    @if($c->isLink())
        <link rel="stylesheet" href="{{ $c->href() }}">
    @else
        {!! $c !!}
    @endif

@endforeach