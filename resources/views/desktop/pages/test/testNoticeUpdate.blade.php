@extends('desktop.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/find-id.css') }}">
@endsection

@section('frame')
    <section id="content">
        <section class="noitceEdit">
            <form method="POST" action="{{ route('api.admin.customer.notices.update',['notice' => $notice->id]) }}">
                @method('PUT')
                @csrf
                <input type="text" name="title" value="{{$notice-> title}}">
                <input type="text" name="content" value="{{$notice-> content}}">
                <button type="submit">Update</button>
            </form>
            <form method="post" action="{{route('api.admin.customer.notices.destroy',['notice'=>$notice->id])}}">
                @method('DELETE')
                @csrf
                <button type="submit">Delete</button>
            </form>
            <form method="POST" action="{{ route('api.admin.customer.notices.statusChange',['notice' => $notice->id]) }}">
                @csrf
                @method('PUT')
                <button type="submit">상태 변경</button>
            </form>
        </section>
    </section>
@endsection
