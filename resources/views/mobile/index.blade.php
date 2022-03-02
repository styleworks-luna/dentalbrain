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

@section('title')
    <div class="menu-btn-wrap">
        <a href="" class="menu-btn"></a>
    </div>
    <div class="logo-wrap">
        <a href="{{ url('/') }}" class="ir_pm header-logo">
            <img src="{{ asset('/images/mobile/global/logo.svg') }}" alt="덴탈브레인">
        </a>
    </div>
    <a href="{{ url('/m-search') }}" class="btn-search"></a>
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
                                    <img src="{{ $slide->mobileFile->url }}" alt="최상단 슬라이드">
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

            <section class="middle-banner">
                <h2>진행중인 인기 이벤트</h2>
                <div class="m-middle-swiper-container">
                    <div class="swiper-wrapper">
                        @forelse($recommends as $recommend)
                            <div class="swiper-slide">
                                <a href="{{ route('api.banners.redirect',$recommend->id) }}">
                                    <img src="{{ $recommend->mobileFile->url }}" alt="추천배너">
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

            <section class="middle-banner">
                <h2>위크 특가! TIME DEAL</h2>
                <div class="m-middle-swiper-container2">
                    <div class="swiper-wrapper">
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
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test2.jpg') }}" alt="추천배너">
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="middle-banner">
                <h2>실시간 인기강의</h2>
                <div class="m-middle-swiper-container3">
                    <div class="swiper-wrapper">
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
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test2.jpg') }}" alt="추천배너">
                            </a>
                        </div>
                    </div>
                </div>
            </section>



            <div class="m-row">
                <lecture-all :is_pagination="false" :per_page="8" :mobile="false"></lecture-all>
            </div>

            <section class="ad">
                @if($bar)
                    <a href="{{ route('api.banners.redirect',$bar->id) }}">
                        <img src="{{ $bar->mobileFile->url }}" alt="바배너">
                    </a>
                @else
                    <a href="">
                        <img src="{{ asset('images/dummy/test2.jpg') }}" alt="바배너">
                    </a>
                @endif
            </section>


            <section class="bottom-banner">
                <div class="banner-wrap">
                    @forelse($bottomSlides as $bottom)
                        <a href="{{ route('api.banners.redirect',$bottom->id)}}">
                            <img src="{{ $bottom->mobileFile->url }}" alt="하단배너">
                        </a>
                        @break($loop->iteration == 2)
                    @empty
                        @for($i = 0; $i < 2; $i++)
                            <a href="">
                                <img src="{{ asset('images/dummy/test2.jpg') }}" alt="하단배너">
                            </a>
                        @endfor
                    @endforelse
                </div>
            </section>

        </div>
    </section>
@endsection
