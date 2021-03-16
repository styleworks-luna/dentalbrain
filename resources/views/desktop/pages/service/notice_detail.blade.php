@extends('desktop.layouts.frames.basic_frame')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/service/notice-detail.css') }}">
@endsection

@section('content')
    <section id="content">
        <div class="notice-detail-wrap">
            <div class="container">
                <div class="service-menu">
                    <h1>고객센터</h1>
                    <ul>
                        <li class="{{ (strpos(Route::currentRouteName(), 'customer.notices.show') !== false) ? 'active-menu' : '' }}"><a href="{{ route('customer.notices.index') }}">공지사항</a></li>
                        <li class="{{ (strpos(Route::currentRouteName(), 'customer.faqs.index') !== false) ? 'active-menu' : '' }}"><a href="{{ route('customer.faqs.index') }}">FAQ</a></li>
                        <li class="{{ (strpos(Route::currentRouteName(), 'customer.inquiries.index') !== false) ? 'active-menu' : '' }}"><a href="{{ route('customer.inquiries.index') }}">문의하기</a></li>
                    </ul>
                </div>


                <section class="notice-detail">
                    <h2>공지사항</h2>
                    <div class="notice-detail-text">
                        <div class="notice-detail-title">
                            <h3>{{ $notice -> title }}</h3>
                            <div class="notice-info">
                                <span class="writer">{{ $notice -> name }}</span>
                                <span class="bar"></span>
                                <span class="date">{{ date_format($notice ->created_at, 'Y.m.d H:m:s') }}</span>
                            </div>
                        </div>
                        <div class="notice-detail-content">
                            <p>{{ $notice -> content }}</p>
                        </div>

                    </div>
                    <div class="btn-wrap">
                        <a href="{{ route('customer.notices.index') }}" class="btn-prev">목록으로</a>
                    </div>
                </section>

            </div>
        </div>
    </section>
@endsection
