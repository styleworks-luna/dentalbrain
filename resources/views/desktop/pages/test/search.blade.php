@extends('desktop.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/find-id.css') }}">
@endsection

@section('frame')
    <section id="content">
        <section class="search">
            faq 검색
            <form method="POST" action="{{ route('api.admin.customer.faqs.search') }}">
                @csrf
                <input type="text" id="keyword" name="keyword" value="t">
                <input type="submit">
            </form>
            문의하기 검색
            <form method="POST" action="{{ route('api.admin.customer.inquiries.search') }}">
                @csrf
                <input type="text" id="keyword" name="keyword" value="">
                <select name="gubun">
                    <option value="all">구분</option>
                    <option value="notCompleted">미완료</option>
                    <option value="Completed">완료</option>
                    <option value="normal">일반</option>
                    <option value="refund">환불</option>
                </select>
                <input type="submit">
            </form>
        </section>
    </section>
@endsection
