@extends('desktop.layouts.app')

@section('style')
<link rel="stylesheet" href="{{ mix('css/desktop/pages/user/find-id.css') }}">
@endsection

@section('frame')
<section id="content">
    <section class="faqEdit">
        <form method="POST" action="{{ route('api.admin.customer.faqs.update',['faq' => $faq->id]) }}">
            @method('PUT')
            @csrf
            <input type="text" name="question" value="{{$faq-> question}}">
            <input type="text" name="answer" value="{{$faq-> answer}}">
            <input type="text" name="is_open" value="{{$faq-> is_open}}">
            <input type="text" name="category_id" value="{{$faq-> category_id}}">
            <input type="text" name="category_name" value="{{$faq-> category_name}}">
            <button type="submit">Update</button>
        </form>

        <form method="POST" action="{{ route('api.admin.customer.faqs.destroy',['faq' => $faq->id]) }}">
            @method('DELETE')
            @csrf
            <button type="submit">Delete</button>
        </form>

        <form method="POST" action="{{ route('api.admin.customer.faqs.statusChange',['faq' => $faq->id]) }}">
            @csrf
            <button type="submit">상태 변경</button>
        </form>
    </section>
</section>
@endsection
