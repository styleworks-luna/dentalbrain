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

                <div class="faq-history">
                    <h2>FAQ</h2>
                    <ul>
                        <li class="faq-header">
                            <span class="sort">분류</span>
                            <span class="question">질문</span>
                        </li>
                        <li class="faq-content">
                            <p class="sort">강의신청</p>
                            <div class="question">
                                <em>Q</em>
                                <a href="" class="question-content">질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용</a>
                            </div>
                            <span class="arrow-down"></span>
                        </li>
                        <li class="faq-content">
                            <p class="sort">강의신청</p>
                            <div class="question">
                                <em>Q</em>
                                <a href="" class="question-content">질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용</a>
                            </div>
                            <span class="arrow-down"></span>
                        </li>
                        <li class="faq-content">
                            <p class="sort">강의신청</p>
                            <div class="question">
                                <em>Q</em>
                                <a href="" class="question-content">질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용</a>
                            </div>
                            <span class="arrow-down"></span>
                        </li>
                        <li class="faq-content">
                            <p class="sort">강의신청</p>
                            <div class="question">
                                <em>Q</em>
                                <a href="" class="question-content">질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용</a>
                            </div>
                            <span class="arrow-down"></span>
                        </li>
                        <li class="faq-content">
                            <p class="sort">강의신청</p>
                            <div class="question">
                                <em>Q</em>
                                <a href="" class="question-content">질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용질문내용</a>
                            </div>
                            <span class="arrow-down"></span>
                        </li>
                    </ul>
                </div>

            </div>
        </section>
    </section>
@endsection
