{{--<input type="checkbox" class="grid-select-all" />&nbsp;--}}
<div class="btn-group dropdown">
    <button class="btn btn-sm btn-default dropdown-toggle" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span>{{ trans('admin.action') }}</span>
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @foreach($actions as $action)
            <li class="dropdown-item grid-batch-{{ $action['id'] }}""><a href="#" >{{ $action['title'] }}</a></li>
        @endforeach
    </ul>
</div>