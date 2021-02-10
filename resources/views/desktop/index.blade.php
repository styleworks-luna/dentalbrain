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
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/lecture/lecture-all.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            <section class="top-banner">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @forelse($slides as $slide)
                            <div class="swiper-slide">
                                <a href="{{ route('lectures.detail',$slide->id) }}">
                                    <img src="{{ $slide->thumbnail->url }}" alt="광고">
                                </a>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <a href="">
                                    <img src="{{ asset('images/dummy/test2.jpg') }}" alt="광고">
                                </a>
                            </div>
                        @endforelse
                    </div>
                    <div class="swiper-controller-wrap">
                        <div class="swiper-pagination"></div>
                        <div class="swiper-scrollbar"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </section>

            <lecture-all :is_pagination="false" :per_page="9"></lecture-all>

            <section class="ad">
                @if($bar)
                    <a href="{{ $bar->link }}">
                        <img src="{{ $bar->desktopFile->url }}" alt="광고">
                    </a>
                @else
                    <a href="">
                        <img src="{{ asset('images/dummy/test2.jpg') }}" alt="광고">
                    </a>
                @endif
            </section>

            <section class="middle-banner">
                <h2>추천강의</h2>
                <div class="middle-swiper-container">
                    <div class="swiper-wrapper">
                        @forelse($bottomSlides as $bottom)
                            <div class="swiper-slide">
                                <a href="{{ route('api.admin.banners.redirectToLink',['banner'=>$bottom->id])}}">
                                    <img src="{{ $bottom->desktopFile->url }}" alt="광고">
                                </a>
                            </div>
                        @empty
                            @for($i = 0; $i < 7; $i++)
                                <div class="swiper-slide">
                                    <a href="">
                                        <img src="{{ asset('images/dummy/test2.jpg') }}" alt="광고">
                                    </a>
                                </div>
                            @endfor
                        @endforelse
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
                                <img src="{{ asset('images/dummy/test2.jpg') }}" alt="광고">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test2.jpg') }}" alt="광고">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test2.jpg') }}" alt="광고">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test2.jpg') }}" alt="광고">
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
                            @forelse($notices as $notice)
                                <li><a href="{{ route('customer.notices.show',$notice->id) }}">{{ $notice->title }}</a>
                                </li>
                            @empty
                                <li>공지사항이 없습니다.</li>
                            @endforelse
                        </ul>
                        <a href="{{ route('customer.notices.index') }}" class="btn-more">더보기</a>
                    </div>
                    <div class="faq community-common">
                        <h2>FAQ</h2>
                        <ul>
                            @forelse($faqs as $faq)
                                <li><a href="{{ route('customer.faqs.index') }}">{{ $faq->question }}</a></li>
                            @empty
                                <li>FAQ가 없습니다.</li>
                            @endforelse
                        </ul>
                        <a href="{{ route('customer.faqs.index') }}" class="btn-more">더보기</a>
                    </div>
                    <div class="community-menu">
                        <ul>
                            <li><a href="{{ route('account.index') }}">마이페이지</a></li>
                            <li><a href="{{ route('customer.index') }}">고객센터</a></li>
                            <li><a href="{{ url('lectures') }}">전체강의</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
