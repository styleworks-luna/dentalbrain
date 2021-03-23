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
                    @forelse($articles as $article)
                        <li>
                            <div class="image-wrap">
                                <img src="{{ $article->thumbnail->url }}" alt="{{ $article->thumbnail->name }}">
                            </div>
                            <div class="community-information">
                                <h3>{{ $article->title }}</h3>
                                <p class="date">{{ $article->date }}</p>
                            </div>
                            <span class="arrow-right"></span>
                        </li>
                    @empty
                        <li>
                            <p>관련 뉴스가 없습니다.</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </section>
@endsection
