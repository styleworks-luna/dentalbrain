@extends('desktop.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/find-id.css') }}">
@endsection

@section('content')
    <section id="content">
        <section class="notice">
            faq 넣는 함수
            <form method="POST" action="{{route('api.admin.customer.faqs.store')}}">
                @csrf
                <input type="text" name="question" placeholder="faq 질문" value="question">
                <input type="text" name="answer" placeholder="faq정답" value="answer">
                <input type="text" name="category_id" placeholder="카테고리 id" value="1">
                <input type="text" name="is_open" placeholder="상태" value="1">
                <input type="submit">
            </form>

            notice 넣는 함수
            <form method="POST" action="{{route('api.admin.customer.notices.store')}}">
                @csrf
                <input type="text" name="title" placeholder="제목" value="title">
                <input type="text" name="content" placeholder="내용" value="content">
                <input type="text" name="display_name" placeholder="관리자 이름" value="관리자">
                <input type="text" name="user_id" placeholder="user_id" value="1">
                <input type="submit">
            </form>
            <br>

            inquiry 넣는 함수
            <form method="POST" action="{{route('customer.inquiries.store')}}">
                @csrf
                <input type="text" name="name" placeholder="name" value="이름">
                <input type="text" name="phone" placeholder="phone" value="01012345678">
                <input type="text" name="email" placeholder="email" value="onoffmix@onoffmix.com">
                <input type="text" name="title" placeholder="title" value="제목">
                <input type="text" name="content" placeholder="content" value="내용">
                <input type="text" name="category" placeholder="category" value="1">
                <input type="submit">
            </form>
        </section>
    </section>
@endsection
