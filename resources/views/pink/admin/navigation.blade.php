@if($menu)
    <div class="menu classic">
        {{--это компонент ларавела Лавари-меню, как ненумеров спис --}}
        {!! $menu->asUl(['class'=>'menu']) !!}
    </div>
@endif