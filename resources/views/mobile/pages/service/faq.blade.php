@extends('mobile.layouts.frames.except_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/service/faq.js')}}"></script>
    <script src="{{ asset('js/jquery.jscroll.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('ul.pagination').css('display', 'none');
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                padding: 0,
                loadingHtml: '',
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'ul.infinite-scroll',
                callback: function () {
                    $('ul.pagination').css('display', 'none').remove();
                }
            });
        });
    </script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/service/faq.css') }}">
@endsection

@section('content')
    <section id="content">
        <section class="faq">
            <div class="m-container">

                <section class="faq-history">
                    <ul class="infinite-scroll">
                        @forelse($faqs as $key => $value)
                            <li class="faq-content">
                                <div class="question-information">
                                    <div class="title-wrap">
                                        <em>Q</em>
                                        <div class="question">
                                            <p>{{ $value->question }}</a>
                                        </div>
                                    </div>
                                    <p class="sort">{{$value->category_name}}</p>
                                    <span class="arrow-down"></span>
                                </div>
                                <div class="answer hide">
                                    <em>A</em>
                                    <p>{{ $value->answer }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="list-none">FAQ 가 없습니다.</li>
                        @endforelse
                        {{ $faqs->links() }}
                    </ul>
                </section>
            </div>
        </section>
    </section>
@endsection
