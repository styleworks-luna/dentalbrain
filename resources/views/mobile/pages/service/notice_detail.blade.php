@extends('mobile.layouts.frames.except_frame')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/service/notice-detail.css') }}">
@endsection

@section('title')
    <a href="" class="btn-back"></a>
    <h1>공지사항</h1>
@endsection

@section('content')
    <section id="content">
        <div class="notice-detail-wrap">
            <div class="m-container">

                <section class="notice-detail">
                    <div class="m-row">
                        <div class="notice-detail-text">
                            <div class="notice-detail-title">
                                <h3>{{ $notice -> title }}</h3>
                                <div class="notice-info">
                                    <span class="writer">{{ $notice -> name }}</span>
                                    <span class="date">{{ date_format($notice ->created_at, 'Y.m.d') }}</span>
                                </div>
                            </div>
                            <div class="notice-detail-content">
                                <div class="fr-element fr-view">
                                    <p>{!! $notice -> content !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </section>
@endsection
