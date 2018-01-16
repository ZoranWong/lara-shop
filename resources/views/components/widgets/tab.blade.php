<div  {!! $attributes !!}>
    <ul class="nav nav-tabs">

        @foreach($tabs as $id => $tab)
            {{ logger('tab', $tab)? :'' }}
            <li class="nav-item {{ $id == $active ? 'active' : '' }}" ><a class="nav-link" href="#tab_{{ $tab['id'] }}" data-toggle="tab">{{ $tab['title'] }}</a></li>
        @endforeach

        @if (!empty($dropDown))
            <div class="btn-group dropdown">
                <button class="btn btn-sm btn-default dropdown-toggle" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span>Dropdown</span>
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach($dropDown as $link)
                        <li role="presentation" class="dropdown-item"><a role="menuitem" tabindex="-1" href="{{ $link['href'] }}">{{ $link['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
        <li class="pull-right header">{{ $title }}</li>
    </ul>
</div>
<div class="tab-content">
    @foreach($tabs as $id => $tab)
        <div class="tab-pane {{ $id == $active ? 'active' : '' }}" id="tab_{{ $tab['id'] }}">
            {!! $tab['content'] !!}
        </div>
    @endforeach

</div>