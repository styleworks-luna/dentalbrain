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
            <div class="article-description">
                @forelse($articles as $article)
                    <img src="{{ $article->thumbnail->url }}" alt="{{ $article->thumbnail->name }}">
                    <h2>{{ $article->title }}</h2>
                    <p>{{ $article->date }}</p>
                @empty
                    <h1>없습니다</h1>
                @endforelse
            </div>
        </div>
    </section>
@endsection
