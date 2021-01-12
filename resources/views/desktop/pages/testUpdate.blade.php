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

            <form method="POST" action="/admin/notice/{{$notice ->id}}">
                @method('DELETE')
                @csrf
                <button>Delete</button>
            </form>
        </section>
    </section>
@endsection
