@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
@endsection

@section('content')
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <h3>이미지 업로드 예시</h3>
    <form action="{{ route('api.admin.upload.image') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image">
        <input type="submit">
    </form>
    <br><h4>=======================================================================</h4><br>
    <h3>파일 업로드 예시</h3>
    <form action="{{ route('api.admin.upload.file') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file">
        <input type="submit">
    </form>
    <br><h4>=======================================================================</h4><br>
    <h3>이미지 다운로드 예시</h3>
    <img src="{{route('api.admin.download',1)}}" alt="">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
@endsection
