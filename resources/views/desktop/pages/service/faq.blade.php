@extends('desktop.layouts.app')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/faq.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/service/faq.css') }}">
@endsection

@section('content')
    <section id="content">
        <section class="faq">
            <div class="container">
                @include('desktop.layouts.navigation.service')

                <section class="faq-history">
                    <h2>FAQ</h2>
                    <ul>
                        <li class="faq-header">
                            <span class="sort">분류</span>
                            <span class="question">질문</span>
                        </li>
                        @foreach($faqs as $key => $value)
                            <li class="faq-content">
                                <div class="question-information">
                                    <p class="sort">강의신청</p>
                                    <div class="question">
                                        <em>Q</em>
                                        <a href="" class="question-content">{{ $value->question }}</a>
                                    </div>
                                    <span class="arrow-down"></span>
                                </div>
                                <div class="answer">
                                    <em>A</em>
                                    <p>
                                        {{ $value->answer }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>

            </div>
        </section>
    </section>
@endsection
