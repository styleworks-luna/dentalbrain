@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript">
        $(function () {
            alert('결제가 완료되었습니다.\n덴탈브레인 유료회원 가입을 환영합니다.');
            location.href='/membership';
        })
    </script>
@endsection
