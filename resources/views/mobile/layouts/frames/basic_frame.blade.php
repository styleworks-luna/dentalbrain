@extends('mobile.layouts.app')

@section('frame')
    @include('mobile.layouts.header')
    <main class="main">
        @yield('content')
    </main>
    @include('mobile.layouts.footer')
@endsection
