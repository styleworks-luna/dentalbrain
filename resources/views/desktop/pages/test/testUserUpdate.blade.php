@extends('desktop.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/find-id.css') }}">
@endsection

@section('frame')
    <section id="content">
        <section class="UserEdit">
            <form method="POST" action="{{ route('api.admin.user.update',['user' => $user -> id]) }}">
                @method('PUT')
                @csrf
                <input type="hidden" name="id" value="{{$user -> id}}" placeholder="id">
                <input type="text" name="name" value="{{$user -> name}}" placeholder="이름">
                <input type="text" name="email" value="{{$user -> email}}" placeholder="이메일">
                <input type="text" name="phone" value="{{$user -> phone}}" placeholder="전화번호">
                <input type="text" name="job_name_id" value="{{$user->job_name_id}}" placeholder="user_jobs_id">
                <input type="text" name="license_num" value="{{$user -> license_num}}" placeholder="면허번호">
                <input type="text" name="allow_email" value="{{$user -> allow_email }}" placeholder="이메일 허용">
                <button type="submit">Update</button>
            </form>
        </section>
    </section>
@endsection
