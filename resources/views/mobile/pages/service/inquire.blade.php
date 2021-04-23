@extends('mobile.layouts.frames.except_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.ui.emailbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/service/inquire.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/service/inquire.css') }}">
@endsection

@section('title')
    <a href="" class="btn-back"></a>
    <h1>문의하기</h1>
@endsection

@section('content')
    <section id="content">
        <section class="inquire-wrap">
            <div class="m-container">

                <section class="inquire">
                    <div class="m-row">
                        <form method="POST" action="{{route('customer.inquiries.index')}}" id="inquire-form">
                            @csrf
                            <div class="inquire-form-wrap">
                                <table>
                                    <tr>
                                        <th>이름</th>
                                        <td class="name-wrap">
                                            <input type="text"
                                                   id="name"
                                                   name="name"
                                                   placeholder="이름을 입력해주세요."
                                                   data-parsley-required="true"
                                                   data-parsley-required-message="※ 이름을 입력해주세요."
                                                   value="{{old('name')}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>연락처</th>
                                        <td class="phone-wrap">
                                            <input type="text"
                                                   id="phone"
                                                   name="phone"
                                                   class="phone"
                                                   placeholder="연락처를 입력해주세요."
                                                   data-parsley-required="true"
                                                   data-parsley-required-message="※ 연락처를 입력해주세요."
                                                   value="{{old('phone')}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>이메일</th>
                                        <td class="email-wrap" colspan="3">
                                            <p>※ 답변 받을 이메일 주소를 입력해주세요.</p>
                                            <input type="email"
                                                   id="email"
                                                   name="email"
                                                   class="email-box"
                                                   data-parsley-required="true"
                                                   data-parsley-type="email"
                                                   data-parsley-required-message="※ 이메일 주소를 입력해주세요."
                                                   data-parsley-class-handler=".ui-emailbox"
                                                   data-parsley-errors-container=".email-error-wrap"
                                                   value="{{old('email')}}">
                                            <div class="email-error-wrap parsley-error-wrap"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>제목</th>
                                        <td class="title-wrap" colspan="3">
                                            <select id="title-category" name="category_id" class="select-menu">
                                                @foreach($categories as $category)
                                                    <option value={{ $category->id }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>

                                            <input type="text"
                                                   id="title"
                                                   name="title"
                                                   class="title"
                                                   placeholder="제목을 입력해주세요."
                                                   value="{{old('title')}}"
                                                   data-parsley-required="true"
                                                   data-parsley-required-message="※ 제목을 입력해주세요."
                                                   data-parsley-errors-container=".title-error-wrap">
                                            <div class="title-error-wrap parsley-error-wrap"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>문의내용</th>
                                        <td class="inquire-content-wrap" colspan="3">
                                        <textarea id="inquire_content"
                                                  name="content"
                                                  class="inquire-content"
                                                  placeholder="문의내용을 입력해주세요."
                                                  data-parsley-required="true"
                                                  data-parsley-required-message="※ 문의내용을 입력해주세요."
                                                  value="{{old('content')}}"></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="btn-wrap">
                                <input type="submit" class="btn-submit" value="문의하기">
                            </div>
                        </form>
                    </div>
                </section>

            </div>
        </section>
    </section>
@endsection
