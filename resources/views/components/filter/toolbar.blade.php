<div id="{{$id}}" class = "filter-toolbar" style="width:100%">
    <form action="{!! $action !!}" method="get" class="form-horizontal" pjax-container>
        @foreach($filters as $filter)
            {!! $filter->render() !!}
        @endforeach
    </form>
</div>