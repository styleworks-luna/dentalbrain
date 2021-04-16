@extends('mobile.layouts.app')

@section('frame')
    <div class="wrap">
    @include('mobile.layouts.header')
    @include('mobile.layouts.navigation.aside')
    <main class="main">
        @yield('content')
    </main>
    @include('mobile.layouts.footer')
    </div>
@endsection
