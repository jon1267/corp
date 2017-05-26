{{--@extends(env('THEME').'.layouts.site') --}}
{{-- !!! вот почему в админке не было ckeditor'a--}}
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