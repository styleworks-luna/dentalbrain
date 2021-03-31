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
                <h2>관련뉴스</h2>
                <ul class="community-list">
                    @forelse($articles as $article)
                        <li>
                            <div class="image-wrap">
                                <img
                                    src="{{ $article->thumbnail ? $article->thumbnail->url : asset('/images/desktop/global/logo.png') }}"
                                    alt="{{ $article->thumbnail ? $article->thumbnail : '덴탈브레인 로고' }}">
                            </div>
                            <div class="community-information">
                                <h3><a href="{{ $article->link }}" target="_blank">{{ $article->title }}</a></h3>
                                <p class="date">{{ date_format($article->date, 'Y.m.d') }}</p>
                            </div>
                            <span><a href="{{ $article->link }}" class="arrow-right" target="_blank"></a></span>
                        </li>
                    @empty
                        <li>
                            <p class="none">관련 뉴스가 없습니다.</p>
                        </li>
                    @endforelse
                </ul>
                <div class="paging-wrap">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
