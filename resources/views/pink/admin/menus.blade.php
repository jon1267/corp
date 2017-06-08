@extends(env('THEME').'.layouts.admin')

@section('navigation')
    {!! $navigation !!}
@endsection

@section('content')
    {!! $content !!}
@endsection

@section('footer')
    {{--@include('pink.footer') --}}
    {!! $footer !!}
@endsection