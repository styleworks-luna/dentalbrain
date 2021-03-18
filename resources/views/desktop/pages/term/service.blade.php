@extends('desktop.layouts.frames.basic_frame')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/mypage-edit.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            @include('desktop.layouts.navigation.term')
        </div>
    </section>
@endsection
