@extends('mobile.layouts.frames.except_frame')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/service/notice.css') }}">
@endsection

@section('content')
    <section id="content">
        <div class="notice">
            <div class="m-container">

                <section class="notice-history">
                    <ul>
                        @forelse($notices as $notice)
                            <li class="notice-content">
                                <a href="{{ route('customer.notices.show',$notice->id) }}"
                                   class="title list-common">{{ $notice->title }}</a>
                                <p class="date list-common">{{ date_format($notice->created_at,'Y.m.d') }}</p>
                            <span class="icon-arrow"><a href="{{ route('customer.notices.show',$notice->id) }}"></a></span>
                            </li>
                        @empty
                            <li class="list-none">공지사항이 없습니다.</li>
                        @endforelse
                    </ul>
                </section>
            </div>
        </div>
    </section>
@endsection
