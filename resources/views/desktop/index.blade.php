@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
@endsection

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/index.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            <section class="top-banner">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset('images/dummy/test2.jpg') }}" alt="">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/dummy/test2.jpg') }}" alt="">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/dummy/test2.jpg') }}" alt="">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/dummy/test2.jpg') }}" alt="">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/dummy/test2.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="swiper-controller-wrap">
                        <div class="swiper-pagination"></div>
                        <div class="swiper-scrollbar"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </section>

            <lecture></lecture>

            <section class="ad">
                @if($middle)
                    <a href="{{ $middle->link }}">
                        <img src="{{ $middle->file->url }}" alt="">
                    </a>
                @endif
            </section>

            <section class="middle-banner">
                <h2>추천강의</h2>
                <div class="middle-swiper-container">
                    <div class="swiper-wrapper">

                        @foreach($bottomSlides as $bottom)
                            <div class="swiper-slide">
                                <a href="{{ $bottom->link }}">
                                    <img src="{{ $bottom->desktopFile->url }}" alt="">
                                </a>
                            </div>
                        @endforeach
                        {{--                        <div class="swiper-slide">--}}
                        {{--                            <a href="">--}}
                        {{--                                <img src="{{ asset('images/dummy/test.png') }}" alt="">--}}
                        {{--                            </a>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="swiper-slide">--}}
                        {{--                            <a href="">--}}
                        {{--                                <img src="{{ asset('images/dummy/test.png') }}" alt="">--}}
                        {{--                            </a>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="swiper-slide">--}}
                        {{--                            <a href="">--}}
                        {{--                                <img src="{{ asset('images/dummy/test.png') }}" alt="">--}}
                        {{--                            </a>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="swiper-slide">--}}
                        {{--                            <a href="">--}}
                        {{--                                <img src="{{ asset('images/dummy/test.png') }}" alt="">--}}
                        {{--                            </a>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="swiper-slide">--}}
                        {{--                            <a href="">--}}
                        {{--                                <img src="{{ asset('images/dummy/test.png') }}" alt="">--}}
                        {{--                            </a>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="swiper-slide">--}}
                        {{--                            <a href="">--}}
                        {{--                                <img src="{{ asset('images/dummy/test.png') }}" alt="">--}}
                        {{--                            </a>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="swiper-slide">--}}
                        {{--                            <a href="">--}}
                        {{--                                <img src="{{ asset('images/dummy/test.png') }}" alt="">--}}
                        {{--                            </a>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="swiper-slide">--}}
                        {{--                            <a href="">--}}
                        {{--                                <img src="{{ asset('images/dummy/test.png') }}" alt="">--}}
                        {{--                            </a>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
                <div class="middle-swiper-button-prev swiper-button-prev-common"></div>
                <div class="middle-swiper-button-next swiper-button-next-common"></div>
            </section>
            <section class="bottom-banner">
                <div class="bottom-swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test2.jpg') }}" alt="">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test2.jpg') }}" alt="">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test2.jpg') }}" alt="">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test2.jpg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="bottom-swiper-button-prev swiper-button-prev-common"></div>
                <div class="bottom-swiper-button-next swiper-button-next-common"></div>
            </section>
        </div>
        <section class="community">
            <div class="container">
                <div class="community-wrap">
                    <div class="notice community-common">
                        <h2>공지사항</h2>
                        <ul>
                            <li><a href="">브레인스펙 치과보험청구전문강사 모집 </a></li>
                            <li><a href="">김민정 대표와 함께하는 우리치과 예방진료 중간중간중간 김민정 대표와 함께하는 우리치과 예방진료 중간중간중간</a></li>
                            <li><a href="">신종코로나바이너스로 의료기관 및 국민 여러분께 신종코로나바이너스로 의료기관 및 국민 여러분께</a></li>
                        </ul>
                        <a href="" class="btn-more">더보기</a>
                    </div>
                    <div class="faq community-common">
                        <h2>FAQ</h2>
                        <ul>
                            <li><a href="">브레인스펙 치과보험청구전문강사 모집 </a></li>
                            <li><a href="">김민정 대표와 함께하는 우리치과 예방진료 중간중간중간 김민정 대표와 함께하는 우리치과 예방진료 중간중간중간</a></li>
                            <li><a href="">신종코로나바이너스로 의료기관 및 국민 여러분께 신종코로나바이너스로 의료기관 및 국민 여러분께</a></li>
                        </ul>
                        <a href="" class="btn-more">더보기</a>
                    </div>
                    <div class="community-menu">
                        <ul>
                            <li><a href="{{ route('account.index') }}">마이페이지</a></li>
                            <li><a href="{{ route('customer.index') }}">고객센터</a></li>
                            <li><a href="">전체강의</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
