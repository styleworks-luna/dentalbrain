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
                        @foreach($notices as $key => $value)
                            <li class="notice-content">
                                <p class="index list-common">{{$value -> id }}</p>
                                <a href="{{ route('customer.notices.show',['notice' => $value->id])  }}" class="title list-common">{{ $value -> title }}</a>
                                <p class="writer list-common">{{$value -> name }}</p>
                                <p class="date list-common">{{ date('Y-m-d',strtotime($value->created_at)) }}</p>
                                <p class="views list-common">{{$value-> views }}</p>
                            </li>
                        @endforeach
                    </ul>
                    {{ $notices->links() }}
                </section>
            </div>
        </div>
    </section>
@endsection
