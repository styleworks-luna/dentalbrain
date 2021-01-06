@extends('desktop.layouts.app')

@section('script')
    <script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
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
            <section class="lecture">
                <div class="lecture-menu">
                    <ul>
                        <li><a href="">치과의사</a></li>
                        <li><a href="">치과위생사</a></li>
                        <li><a href="">치과조무사</a></li>
                        <li><a href="">학생(민간자격증)</a></li>
                        <li><a href="">치바시</a></li>
                        <li><a href="">기타</a></li>
                    </ul>
                </div>
                <div class="lecture-contents">
                    <ul>
                        <li class="lecture-card">
                            <a href=""><img src="{{ asset('images/dummy/test.png') }}" alt=""></a>
                            <div class="lecture-description">
                                <div class="lecture-description-sub">
                                    <p class="lecture-type">치과의사・임플란트</p>
                                    <p class="lecture-time">총 4강 / 200분</p>
                                </div>
                                <a href="" class="lecture-name">임플란트 상담으로 치과수익을 올려보세요. 임플란트 상담으로 치과수익을 올려보세요.</a>
                                <p class="lecture-price">300,000원</p>
                            </div>
                        </li>
                        <li class="lecture-card">
                            <a href=""><img src="{{ asset('images/dummy/test.png') }}" alt=""></a>
                            <div class="lecture-description">
                                <div class="lecture-description-sub">
                                    <p class="lecture-type">치과의사・임플란트</p>
                                    <p class="lecture-time">총 4강 / 200분</p>
                                </div>
                                <a href="" class="lecture-name">임플란트 상담으로 치과수익을 올려보세요. 임플란트 상담으로 치과수익을 올려보세요.</a>
                                <p class="lecture-price">300,000원</p>
                            </div>
                        </li>
                        <li class="lecture-card">
                            <a href=""><img src="{{ asset('images/dummy/test.png') }}" alt=""></a>
                            <div class="lecture-description">
                                <div class="lecture-description-sub">
                                    <p class="lecture-type">치과의사・임플란트</p>
                                    <p class="lecture-time">총 4강 / 200분</p>
                                </div>
                                <a href="" class="lecture-name">임플란트 상담으로 치과수익을 올려보세요. 임플란트 상담으로 치과수익을 올려보세요.</a>
                                <p class="lecture-price">300,000원</p>
                            </div>
                        </li>
                        <li class="lecture-card">
                            <a href=""><img src="{{ asset('images/dummy/test.png') }}" alt=""></a>
                            <div class="lecture-description">
                                <div class="lecture-description-sub">
                                    <p class="lecture-type">치과의사・임플란트</p>
                                    <p class="lecture-time">총 4강 / 200분</p>
                                </div>
                                <a href="" class="lecture-name">임플란트 상담으로 치과수익을 올려보세요. 임플란트 상담으로 치과수익을 올려보세요.</a>
                                <p class="lecture-price">300,000원</p>
                            </div>
                        </li>
                        <li class="lecture-card">
                            <a href=""><img src="{{ asset('images/dummy/test.png') }}" alt=""></a>
                            <div class="lecture-description">
                                <div class="lecture-description-sub">
                                    <p class="lecture-type">치과의사・임플란트</p>
                                    <p class="lecture-time">총 4강 / 200분</p>
                                </div>
                                <a href="" class="lecture-name">임플란트 상담으로 치과수익을 올려보세요. 임플란트 상담으로 치과수익을 올려보세요.</a>
                                <p class="lecture-price">300,000원</p>
                            </div>
                        </li>
                        <li class="lecture-card">
                            <a href=""><img src="{{ asset('images/dummy/test.png') }}" alt=""></a>
                            <div class="lecture-description">
                                <div class="lecture-description-sub">
                                    <p class="lecture-type">치과의사・임플란트</p>
                                    <p class="lecture-time">총 4강 / 200분</p>
                                </div>
                                <a href="" class="lecture-name">임플란트 상담으로 치과수익을 올려보세요. 임플란트 상담으로 치과수익을 올려보세요.</a>
                                <p class="lecture-price">300,000원</p>
                            </div>
                        </li>
                        <li class="lecture-card">
                            <a href=""><img src="{{ asset('images/dummy/test.png') }}" alt=""></a>
                            <div class="lecture-description">
                                <div class="lecture-description-sub">
                                    <p class="lecture-type">치과의사・임플란트</p>
                                    <p class="lecture-time">총 4강 / 200분</p>
                                </div>
                                <a href="" class="lecture-name">임플란트 상담으로 치과수익을 올려보세요. 임플란트 상담으로 치과수익을 올려보세요.</a>
                                <p class="lecture-price">300,000원</p>
                            </div>
                        </li>
                        <li class="lecture-card">
                            <a href=""><img src="{{ asset('images/dummy/test.png') }}" alt=""></a>
                            <div class="lecture-description">
                                <div class="lecture-description-sub">
                                    <p class="lecture-type">치과의사・임플란트</p>
                                    <p class="lecture-time">총 4강 / 200분</p>
                                </div>
                                <a href="" class="lecture-name">임플란트 상담으로 치과수익을 올려보세요. 임플란트 상담으로 치과수익을 올려보세요.</a>
                                <p class="lecture-price">300,000원</p>
                            </div>
                        </li>
                        <li class="lecture-card">
                            <a href=""><img src="{{ asset('images/dummy/test.png') }}" alt=""></a>
                            <div class="lecture-description">
                                <div class="lecture-description-sub">
                                    <p class="lecture-type">치과의사・임플란트</p>
                                    <p class="lecture-time">총 4강 / 200분</p>
                                </div>
                                <a href="" class="lecture-name">임플란트 상담으로 치과수익을 올려보세요. 임플란트 상담으로 치과수익을 올려보세요.</a>
                                <p class="lecture-price">300,000원</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>
            <section class="ad">
                <a href="">
                    <img src="{{ asset('images/dummy/test2.jpg') }}" alt="">
                </a>
            </section>
            <section class="middle-banner">
                <h2>추천강의</h2>
                <div class="middle-swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test.png') }}" alt="">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test.png') }}" alt="">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test.png') }}" alt="">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test.png') }}" alt="">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test.png') }}" alt="">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test.png') }}" alt="">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test.png') }}" alt="">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test.png') }}" alt="">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('images/dummy/test.png') }}" alt="">
                            </a>
                        </div>
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
                            <li><a href="">마이페이지</a></li>
                            <li><a href="">고객센터</a></li>
                            <li><a href="">전체강의</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
