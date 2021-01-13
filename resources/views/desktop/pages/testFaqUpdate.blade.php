@extends('desktop.layouts.app')

@section('style')
<link rel="stylesheet" href="{{ mix('css/desktop/pages/user/find-id.css') }}">
@endsection

@section('content')
<section id="content">
    <section class="faqEdit">
        <form method="POST" action="{{ route('admin.faqUpdate',['faq' => $faq->id]) }}">
            @method('PUT')
            @csrf

            <input type="text" name="id" value="{{$faq -> id}}">
            <input type="text" name="question" value="{{$faq-> question}}">
            <input type="text" name="answer" value="{{$faq-> answer}}">
            <input type="text" name="category_id" value="{{$faq-> category_id}}">
            <input type="text" name="category_id" value="{{$faq-> category_name}}">
            <button type="submit">Update</button>
        </form>

        <form method="POST" action="{{ route('admin.faqDestroy',['faq' => $faq->id]) }}">
            @method('DELETE')
            @csrf
            <button type="submit">Delete</button>
        </form>
    </section>
</section>
@endsection
