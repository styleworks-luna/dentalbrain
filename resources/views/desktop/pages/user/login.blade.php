@extends('desktop.layouts.app')

@section('content')
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <input type="text" id="login_id" name="login_id">
        <input type="text" id="password" name="password">
        <input type="submit">
    </form>
@endsection
