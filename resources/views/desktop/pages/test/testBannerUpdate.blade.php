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
        <section class="bannerEdit">
            <form method="POST" action="{{ route('api.admin.banners.update',['banner' => $banner->id]) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="desktop_file_id" id='desktop_file_id' placeholder="테스크탑 파일 아이디" value="{{$banner->desktop_file_id}}">
                <input type="hidden" name="mobile_file_id" id='mobile_file_id' placeholder="테스크탑 파일 아이디" value="{{$banner->mobile_file_id}}">
                <input type="text" name="position" placeholder="종류(위치)" value="{{$banner->position}}">
                <input type="text" name="order" placeholder="중요도" value="{{$banner->order}}">
                <input type="text" name="title" placeholder="제목(title)" value="{{$banner->title}}">
                <input type="text" name="link" placeholder="연결 링크" value="{{$banner->link}}">
                <input type="date" name="started_at" placeholder="시작 시간" value="{{$banner->started_at}}">
                <input type="date" name="ended_at" placeholder="종료 시간" value="{{ $banner->ended_at }}">

                <input type="file" name="desktop_file" id="desktop_file" placeholder="데스크탑 파일 아이디">
                <input type="file" name="mobile_file" id="mobile_file" placeholder="모바일 파일 아이디">
                <input type="text" name="is_open" id="is_open" placeholder="활성화여부" value="{{ $banner -> is_open }}">
                <button type="submit">Update</button>
            </form>
            <br/>
            <form method="post" action="{{route('api.admin.banners.destroy',['banner'=>$banner->id])}}">
                @method('DELETE')
                @csrf
                <button type="submit">Delete</button>
            </form>
            <br/>
            <form method="POST" action="{{ route('api.admin.banners.statusChange',['banner' => $banner->id]) }}">
                @csrf
                @method('PATCH')
                <button type="submit">상태 변경</button>
            </form>
        </section>
    </section>
@endsection
