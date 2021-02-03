@extends('desktop.layouts.frames.basic_frame')

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
                        @forelse($notices as $notice)
                            <li class="notice-content">
                                <p class="index list-common">{{ $notice->id }}</p>
                                <a href="{{ route('customer.notices.show',$notice->id) }}" class="title list-common">{{ $notice->title }}</a>
                                <p class="writer list-common">{{ $notice->name }}</p>
                                <p class="date list-common">{{ date_format($notice->created_at,'Y-m-d') }}</p>
                                <p class="views list-common">{{ $notice->views }}</p>
                            </li>
                        @empty
                            <li class="list-none">공지사항이 없습니다.</li>
                        @endforelse
                    </ul>
                    {{ $notices->links() }}
                </section>
            </div>
        </div>
    </section>
@endsection
