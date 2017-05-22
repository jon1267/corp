@if($menu)
    <div class="menu classic">
        {{--это компонент ларавела Лавари-меню, как ненумеров спис --}}
        {!! $menu->asIl(['class'=>'menu']) !!}
    </div>
@endif