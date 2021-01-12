@extends('desktop.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/find-id.css') }}">
@endsection

@section('content')
    <section id="content">
        <section class="notice">
            <form method="POST" action="notice">
                @csrf
                <input type="text" name="title" placeholder="제목" value="title">
                <input type="text" name="content" placeholder="내용" value="content">
                <input type="text" name="display_name" placeholder="관리자 이름" value="조성권">
                <input type="text" name="user_id" placeholder="user_id" value="1">
                <input type="submit">
            </form>
            <br>
            밑에는 faq 넣는 함수
            <form method="POST" action="faqs">
                @csrf
                <input type="text" name="question" placeholder="faq 질문" value="question">
                <input type="text" name="answer" placeholder="faq정답" value="answer">
                <input type="text" name="category_id" placeholder="카테고리 id" value="1">
                <input type="submit">
            </form>
        </section>
    </section>
@endsection
