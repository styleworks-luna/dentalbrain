@extends('desktop.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/find-id.css') }}">
@endsection

@section('content')
    <section id="content">
        <section class="noitceEdit">
            <ol>
                <li>{{$notice -> id}}</li>
                <li>{{$notice-> title}}</li>
                <li>{{$notice-> content}}</li>
                <li>{{$notice-> user_id}}</li>
            </ol>

            <form method="POST" action="{{ route('admin.noticeUpdate',['notice' => $notice->id]) }}">
                @method('PUT')
                @csrf

                <input type="text" name="id" value="{{$notice -> id}}">
                <input type="text" name="title" value="{{$notice-> title}}">
                <input type="text" name="content" value="{{$notice-> content}}">
                <input type="text" name="user_id" value="{{$notice-> user_id}}">
                <button type="submit">Update</button>
            </form>

            <form method="POST">

            </form>
        </section>
    </section>
@endsection
