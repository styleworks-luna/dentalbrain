@extends('desktop.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/find-id.css') }}">
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#mobile_file').on('change',function(e) {
                var formData = new FormData();
                formData.append("image", $("#mobile_file")[0].files[0]);

                $.ajax({
                    url: '{{route('api.admin.upload.image')}}',
                    type: 'POST',
                    data : formData,
                    dataType: "json",
                    {{--data : {__token : "{{csrf_token()}}", file},--}}
                    success: function(response) {
                        console.log(response);
                        $('#mobile_file_id').val(response['file'].id);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });

            $('#desktop_file').on('change',function(e) {
                var formData = new FormData();
                formData.append("image", $("#desktop_file")[0].files[0]);

                $.ajax({
                    url: '{{route('api.admin.upload.image')}}',
                    type: 'POST',
                    data : formData,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        $('#desktop_file_id').val(response['file'].id);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });
    </script>
@endsection


@section('frame')
    <section id="content">
        <section class="notice">
            faq 넣는 함수
            <form method="POST" action="{{route('api.admin.customer.faqs.store')}}">
                @csrf
                question<input type="text" name="question" placeholder="faq 질문" value="question">
                answer<input type="text" name="answer" placeholder="faq정답" value="answer">
                category_id<input type="text" name="category_id" placeholder="카테고리 id" value="1">
                is_open<input type="text" name="is_open" placeholder="상태" value="1">
                <input type="submit">
            </form>
            <br>

            notice 넣는 함수
            <form method="POST" action="{{route('api.admin.customer.notices.store')}}">
                @csrf
                title<input type="text" name="title" placeholder="제목" value="title">
                content<input type="text" name="content" placeholder="내용" value="content">
                display_name<input type="text" name="display_name" placeholder="관리자 이름" value="관리자">
                is_open<input type="text" name="is_open" placeholder="상태" value="1">
                <input type="submit">
            </form>
            <br>

            inquiry 넣는 함수
            <form method="POST" action="{{route('customer.inquiries.store')}}">
                @csrf
                name<input type="text" name="name" placeholder="name" value="이름">
                phone<input type="text" name="phone" placeholder="phone" value="01012345678">
                email<input type="text" name="email" placeholder="email" value="onoffmix@onoffmix.com">
                title<input type="text" name="title" placeholder="title" value="제목">
                content<input type="text" name="content" placeholder="content" value="내용">
                cateogry<input type="text" name="category" placeholder="category" value="1">
                <input type="submit">
            </form>
            <br>

            banner 넣는 함수
            <form method="POST" action="{{route('api.admin.banners.store')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="desktop_file_id" id="desktop_file_id" placeholder="데스크탑 파일 아이디" value="">
                <input type="hidden" name="mobile_file_id" id='mobile_file_id' placeholder="모바일 파일 아이디" value="">
                category_id<input type="text" name="category_id" placeholder="종류(위치)" value="{{\App\Models\Manage\Banner::$POSITION_BOTTOM}}">
                order<input type="text" name="order" placeholder="중요도" value="1">
                title<input type="text" name="title" placeholder="제목(title)" value="배너제목">
                link<input type="text" name="link" placeholder="연결 링크" value="https://google.com">
                desktop_file<input type="file" name="desktop_file" id="desktop_file" placeholder="데스크탑 파일">
                mobile_file<input type="file" name="mobile_file" id="mobile_file" placeholder="모바일 파일">
                started_at<input type="date" name="started_at" placeholder="시작 시간" value="{{now()}}">
                ended_at<input type="date" name="ended_at" placeholder="종료 시간" value="{{ now() }}">
                is_open<input type="text" name="is_open" placeholder="활성화 여부" value="1">
                <input type="submit">
            </form>

            <br>
            id 검색 함수
            <form method="post" action="{{ route('api.find.id') }}">
                @csrf
                <input type="text" name="name" id="name" placeholder="이름">
                <input type="text" name="phone" id="phone" placeholder="휴대전화">
                <input type="submit">
            </form>

            <br>
            id 존재 함수
            <form method="post" action="{{ route('api.find.checkIdDuplication') }}">
                @csrf
                <input type="text" name="login_id" id="login_id" placeholder="아이디">
                <input type="submit">
            </form>

            <br>
            문자인증번호
            <form method="post" action="{{route('api.sendVerificationNumber')}}">
                @csrf
                <input type="text" name="phone" id="phone" placeholder="휴대전화">
                <input type="submit">
            </form>

            <br>
            문자 인증확인
            <form method="post" action="{{ route('api.comapreVerificationNumber') }}">
                @csrf
                <input type="text" name="phone" id="phone" placeholder="휴대전화">
                <input type="text" name="verficationNumber" placeholder="인증번호">
                <input type="submit">
            </form>
        </section>
    </section>
@endsection
