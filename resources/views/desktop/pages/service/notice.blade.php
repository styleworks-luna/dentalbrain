@extends('desktop.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/service/notice.css') }}">
@endsection

@section('content')
    <section id="content">
        <div class="notice">
            <div class="container">
                @include('desktop.layouts.navigation.service')

                <section class="notice-history">
                    <h2>공지사항</h2>
                    <ul>
                        <li class="notice-header">
                            <span class="index list-common">번호</span>
                            <span class="title list-common">제목</span>
                            <span class="writer list-common">글쓴이</span>
                            <span class="date list-common">등록일</span>
                            <span class="views list-common">조회수</span>
                        </li>
                        <li class="notice-content">
                            <p class="index list-common">121</p>
                            <a href="" class="title list-common">코로나19로 인해 치과임상공부 집에서도 편하게하는 온라인라이브세미나를 시작했습니다. </a>
                            <p class="writer list-common">uniquechoa</p>
                            <p class="date list-common">2020.11.30</p>
                            <p class="views list-common">521</p>
                        </li>
                        <li class="notice-content">
                            <p class="index list-common">120</p>
                            <a href="" class="title list-common">코로나19로 인해 치과임상공부 집에서도 편하게하는 온라인라이브세미나를 시작했습니다. </a>
                            <p class="writer list-common">uniquechoa</p>
                            <p class="date list-common">2020.11.30</p>
                            <p class="views list-common">521</p>
                        </li>
                        <li class="notice-content">
                            <p class="index list-common">119</p>
                            <a href="" class="title list-common">코로나19로 인해 치과임상공부 집에서도 편하게하는 온라인라이브세미나를 시작했습니다. </a>
                            <p class="writer list-common">uniquechoa</p>
                            <p class="date list-common">2020.11.30</p>
                            <p class="views list-common">521</p>
                        </li>
                        <li class="notice-content">
                            <p class="index list-common">118</p>
                            <a href="" class="title list-common">코로나19로 인해 치과임상공부 집에서도 편하게하는 온라인라이브세미나를 시작했습니다. </a>
                            <p class="writer list-common">uniquechoa</p>
                            <p class="date list-common">2020.11.30</p>
                            <p class="views list-common">521</p>
                        </li>
                        <li class="notice-content">
                            <p class="index list-common">117</p>
                            <a href="" class="title list-common">코로나19로 인해 치과임상공부 집에서도 편하게하는 온라인라이브세미나를 시작했습니다. </a>
                            <p class="writer list-common">uniquechoa</p>
                            <p class="date list-common">2020.11.30</p>
                            <p class="views list-common">521</p>
                        </li>
                        <li class="notice-content">
                            <p class="index list-common">116</p>
                            <a href="" class="title list-common">코로나19로 인해 치과임상공부 집에서도 편하게하는 온라인라이브세미나를 시작했습니다. </a>
                            <p class="writer list-common">uniquechoa</p>
                            <p class="date list-common">2020.11.30</p>
                            <p class="views list-common">521</p>
                        </li>
                    </ul>
                </section>

            </div>
        </div>
    </section>
@endsection
