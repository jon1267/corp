{{--@extends(config('settings.theme').'.layouts.site') --}}
{{-- !!! вот почему в админке не было ckeditor'a--}}
@extends(config('settings.theme').'.layouts.admin')

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