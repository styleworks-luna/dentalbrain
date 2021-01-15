@extends('desktop.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/find-id.css') }}">
@endsection

@section('content')
    <section id="content">
        <section class="InquiryEdit">
            <form method="POST" action="{{ route('api.admin.customer.inquiries.update',['inquiry' => $inquiry->id]) }}">
                @method('PUT')
                @csrf
                <input type="text" name="name" value="{{$inquiry-> name}}">
                <input type="text" name="phone" value="{{$inquiry-> phone}}">
                <input type="text" name="email" value="{{$inquiry-> email}}">
                <input type="text" name="title" value="{{$inquiry-> title}}">
                <input type="text" name="category" value="{{$inquiry-> category}}">
                <button type="submit">Update</button>
            </form>

            <form method="POST" action="{{ route('api.admin.customer.inquiries.destroy',['inquiry' => $inquiry->id]) }}">
                @method('DELETE')
                @csrf
                <button type="submit">Delete</button>
            </form>
        </section>
    </section>
@endsection
