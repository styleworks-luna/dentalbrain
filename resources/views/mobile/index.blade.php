@extends('mobile.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
@endsection

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ mix('css/mobile/index.css') }}">
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/lecture/lecture-all.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="m-container">

            <section class="top-banner">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @forelse($slides as $slide)
                            <div class="swiper-slide">
                                <a href="{{ route('api.banners.redirect',$slide->id) }}">
                                    <img src="{{ $slide->desktopFile->url }}" alt="최상단 슬라이드">
                                </a>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <a href="">
                                    <img src="{{ asset('images/dummy/test2.jpg') }}" alt="최상단 슬라이드">
                                </a>
                            </div>
                        @endforelse
                    </div>
                    <div class="swiper-controller-wrap">
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </section>

            <div class="m-row">
                <lecture-all :is_pagination="false" :per_page="8"></lecture-all>
            </div>

            <section class="ad">
                @if($bar)
                    <a href="{{ route('api.banners.redirect',$bar->id) }}">
                        <img src="{{ $bar->desktopFile->url }}" alt="바배너">
                    </a>
                @else
                    <a href="">
                        <img src="{{ asset('images/dummy/test2.jpg') }}" alt="바배너">
                    </a>
                @endif
            </section>

            <div class="m-row">
                <section class="middle-banner">
                    <h2>추천강의</h2>
                    <div class="middle-swiper-container">
                        <div class="swiper-wrapper">
                            @forelse($recommends as $recommend)
                                <div class="swiper-slide">
                                    <a href="{{ route('api.banners.redirect',$recommend->id) }}">
                                        <img src="{{ $recommend->desktopFile->url }}" alt="추천배너">
                                    </a>
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <a href="">
                                        <img src="{{ asset('images/dummy/test2.jpg') }}" alt="추천배너">
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="">
                                        <img src="{{ asset('images/dummy/test2.jpg') }}" alt="추천배너">
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="">
                                        <img src="{{ asset('images/dummy/test2.jpg') }}" alt="추천배너">
                                    </a>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </section>
            </div>

            <section class="bottom-banner">
                <div class="banner-wrap">
                    <a href="">
                        <img src="{{ asset('images/dummy/test2.jpg') }}" alt="바배너">
                    </a>
                </div>
                <div class="banner-wrap">
                    <a href="">
                        <img src="{{ asset('images/dummy/test2.jpg') }}" alt="하단배너">
                    </a>
                </div>
            </section>

        </div>
    </section>
@endsection
