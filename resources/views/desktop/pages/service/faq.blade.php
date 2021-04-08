@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/service/faq.js')}}"></script>
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
                        @forelse($faqs as $key => $value)
                            <li class="faq-content">
                                <div class="question-information">
                                    <p class="sort for-padding">{{$value->category_name}}</p>
                                    <em class="for-padding">Q</em>
                                    <div class="question">
                                        <a href="" class="question-content for-padding">{{ $value->question }}</a>
                                    </div>
                                </div>
                                <div class="answer">
                                    <em>A</em>
                                    <p>{{ $value->answer }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="list-none">FAQ 가 없습니다.</li>
                        @endforelse
                    </ul>
                </section>
                <div class="paging-wrap">
                    {{ $faqs->links() }}
                </div>
            </div>
        </section>
    </section>
@endsection
