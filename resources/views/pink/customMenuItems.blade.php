@foreach($items as $item)
    <!-- <li {{ (URL::current() == $item->url()) ? "class=active" : '' }}> -->
    <!-- стр. выше чтоб "подсветить" активн.п.меню. class=active - сделать в CSS -->
    <li>
        <a href="{{ $item->url() }}">{{ $item->title }}</a>
        @if($item->hasChildren())
            <ul class="sub-menu">
                @include(config('settings.theme').'.customMenuItems', ['items'=>$item->children()])
            </ul>
        @endif
    </li>
@endforeach