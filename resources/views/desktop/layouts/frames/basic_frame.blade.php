@extends('desktop.layouts.app')

@section('frame')
    @include('desktop.layouts.header')
    <main class="main">
        @yield('content')
    </main>
    @include('desktop.layouts.footer')
@endsection
