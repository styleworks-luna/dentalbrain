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
        </section>
    </section>
@endsection
