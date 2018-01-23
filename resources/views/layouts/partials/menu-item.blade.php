@if (is_string($item))
    <li class="header">{{ $item }}</li>
@else
    <li class="{{ $item['class'] }}">
        <a href="{{ $item['href'] }}"
           @if (isset($item['target'])) target="{{ $item['target'] }}" @endif
        >
            <i class="fa fa-fw {{ $item['icon'] or 'fa-circle-o' }} {{ isset($item['icon_color']) ? 'text-' . $item['icon_color'] : '' }}"></i>
            <span>{{ $item['text'] }}</span>
            @if (isset($item['label']))
                <span class="pull-right-container">
                    <span class="label label-{{ $item['label_color'] or 'primary' }} pull-right">{{ $item['label'] }}</span>
                </span>
            @elseif (isset($item['children']))
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            @endif
        </a>
        @if (isset($item['children']))
            <ul class="{{ $item['children_class'] }}">
                @each('layouts.partials.menu-item', $item['children'], 'item')
            </ul>
        @endif
    </li>
@endif
