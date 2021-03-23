@extends('desktop.layouts.frames.basic_frame')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/introduce/community.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="title-wrap">
            <div class="container">
                <div class="title">
                    <h1>커뮤니티</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="community-description">
                <h2>관련 뉴스</h2>
                <ul>
                    <li>
                        <div class="image-wrap">
                            <img src="{{ url('images/dummy/test.png') }}" alt="">
                        </div>
                        <div class="community-information">
                            <h3>코로나19로 인해 치과임상공부 집에서도 편하게하는 온라인라이브세미나를 시작했습니다. 코로나19로 인해 치과임상공부 집에서도 편하게하는
                                온라인라이브세미나를
                                시작했습니다. </h3>
                            <p class="date">2020.11.17</p>
                        </div>
                        <span class="arrow-right"></span>
                    </li>

                    @forelse($articles as $article)
                        <li>
                            <img src="{{ $article->thumbnail->url }}" alt="{{ $article->thumbnail->name }}">
                            <h3>{{ $article->title }}</h3>
                            <p>{{ $article->date }}</p>
                        </li>
                    @empty
                        <li>
                            <p>없습니다</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </section>
@endsection
