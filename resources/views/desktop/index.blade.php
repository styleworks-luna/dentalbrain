@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/popup/ie-popup.js') }}"></script>
@endsection

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/index.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/lecture/lecture-list.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/popup/ie-popup.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            <section class="top-banner">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @forelse($slides as $slide)
                            <div class="swiper-slide">
                                <a href="{{ route('banner-redirect',$slide->id) }}">
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
                        <div class="swiper-scrollbar"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </section>

            <section class="middle-banner">
                <h2>{{ $titles[0] }}</h2>
                <div class="middle-swiper-container">
                    <div class="swiper-wrapper">
                        @forelse($recommends as $recommend)
                        <div class="swiper-slide">
                            <a href="{{ route('banner-redirect',$recommend->id) }}">
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
                <div class="middle-swiper-button-prev swiper-button-prev-common"></div>
                <div class="middle-swiper-button-next swiper-button-next-common"></div>
            </section>

            <section class="middle-banner">
                <h2>{{ $titles[1] }}</h2>
                <div class="middle-swiper-container2">
                    <lecture-banner1></lecture-banner1>
                    {{--
                    <div class="swiper-wrapper">
                        <ul class="swiper-slide">
                            <li class="lecture-card" :key="lectures.id">
                                <a :href="'/lectures/' + lecture.program_id">
                                    <img :src="lecture.program.thumbnail.url" alt="">
                                    <div class="lecture-description">
                                        <div class="lecture-description-sub">
                                            <span class="lecture-type">{{lecture.program.minor_category_name}}</span>
                                            <p class="lecture-date">수강기간 {{ lecture.program.term }}일</p>
                                            <p class="lecture-time">{{ lecture.program.running_time }}</p>
                                        </div>
                                        <p class="lecture-name">{{ lecture.program.title }}</p>
                                        <divclass="lecture-all-price">
                                            <template v-if="lecture.program.price != 0 && lecture.program.discount_rate != 0">
                                                <span class="lecture-sale">{{ lecture.program.discount_rate }}%</span>
                                                <span class="lecture-price">
                                                    {{ Helper.numberWithCommas(lecture.program.discounted_price) }}원</span>
                                                <span class="lecture-ogprice">{{ Helper.numberWithCommas(lecture.program.price) }}원</span>
                                            </template>
                                            //if="lecture.program.price != 0 && lecture.program.discount_rate == 0"
                                            <p class="lecture-price">{{ Helper.numberWithCommas(lecture.program.price) }}원</p>
                                            //if="lecture.program.price == 0"
                                            <p class="lecture-price">무료</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    --}}
                </div>
                <div class="middle-swiper-button-prev2 swiper-button-prev-common"></div>
                <div class="middle-swiper-button-next2 swiper-button-next-common"></div>
            </section>

            <section class="middle-banner">
                <h2>{{ $titles[2] }}</h2>
                <div class="middle-swiper-container3">
                    <lecture-banner2></lecture-banner2>
                </div>
                <div class="middle-swiper-button-prev3 swiper-button-prev-common"></div>
                <div class="middle-swiper-button-next3 swiper-button-next-common"></div>
            </section>


            <h2 class="lecture_title">{{ $titles[3] }}</h2>
            <lecture-all :is_Main="true" :is_pagination="false" :per_page="16"></lecture-all>

            <section class="ad">
                @if($bar)
                    <a href="{{ route('banner-redirect',$bar->id) }}">
                        <img src="{{ $bar->desktopFile->url }}" alt="바배너">
                    </a>
                @else
                    <a href="">
                        <img src="{{ asset('images/dummy/test2.jpg') }}" alt="바배너">
                    </a>
                @endif
            </section>

            <section class="bottom-banner">
                <div class="bottom-swiper-container">
                    <div class="swiper-wrapper">
                        @forelse($bottomSlides as $bottom)
                            <div class="swiper-slide">
                                <a href="{{ route('banner-redirect',$bottom->id)}}">
                                    <img src="{{ $bottom->desktopFile->url }}" alt="하단배너">
                                </a>
                            </div>
                        @empty
                            @for($i = 0; $i < 7; $i++)
                                <div class="swiper-slide">
                                    <a href="">
                                        <img src="{{ asset('images/dummy/test2.jpg') }}" alt="하단배너">
                                    </a>
                                </div>
                            @endfor
                        @endforelse
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
                            <li><a href="{{ route('account.index') }}"><p>마이페이지</p></a></li>
                            <li><a href="{{ route('customer.index') }}"><p>고객센터</p></a></li>
                            <li><a href="{{ url('lectures') }}"><p>전체강의</p></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        @include('.desktop.component.popup.IE.ie_popup')
    </section>
@endsection
