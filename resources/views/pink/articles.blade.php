@extends(env('THEME').'.layouts.site')

@section('navigation')
    {!! $navigation !!}
@endsection

@section('content')
    {!! $content !!}
@endsection

@section('bar')
    {!! $rightBar or '' !!}
@endsection

@section('footer')
    {{--@include('pink.footer') --}}
    {!! $footer !!}
@endsection