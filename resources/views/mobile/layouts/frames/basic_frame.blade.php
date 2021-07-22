@extends('mobile.layouts.app')

@section('frame')
    <div class="wrap">
        @include('mobile.layouts.header')
        @include('mobile.layouts.navigation.aside')
        <main class="main">
            @yield('content')
        </main>
        @include('mobile.layouts.footer')
    </div>
    <div
        id="kakao-talk-channel-chat-button"
        class="kakao-popup"
        data-channel-public-id="_sxgbCxd"
        data-title="consult"
        data-size="small"
        data-color="yellow"
        data-shape="mobile"
        data-support-multiple-densities="true">
    </div>
@endsection

@section('pop-script')
    <script>
        window.kakaoAsyncInit = function () {
            Kakao.Channel.createChatButton({
                container: '#kakao-talk-channel-chat-button',
            });
        };
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://developers.kakao.com/sdk/js/kakao.channel.min.js';
            fjs.parentNode.insertBefore(js, fjs);
        })(document, 'script', 'kakao-js-sdk');
    </script>
@endsection
