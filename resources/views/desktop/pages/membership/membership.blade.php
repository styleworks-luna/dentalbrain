@extends('desktop.layouts.frames.basic_frame')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/membership/membership.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="membership">
            <br><br><br><br><br><br><br><br>
            <a href="{{ route('membership.paymentForm',['days' => 30]) }}"> 30일권 구매하기</a>
            <br><br><br><br><br><br><br><br>
            <a href="{{ route('membership.paymentForm',['days' => 100]) }}"> 100일권 구매하기</a>
            <br><br><br><br><br><br><br><br>
        </div>
    </section>
@endsection
