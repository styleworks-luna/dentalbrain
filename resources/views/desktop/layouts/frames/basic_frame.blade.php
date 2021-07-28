@extends('desktop.layouts.app')

@section('frame')
    @include('desktop.layouts.header')
    <main class="main">
        @yield('content')
    </main>
    <!-- kakao popup -->
    <div
        id="kakao-talk-channel-chat-button"
        class="kakao-popup"
        data-channel-public-id="_sxgbCxd"
        data-title="consult"
        data-size="large"
        data-color="yellow"
        data-shape="pc"
        data-support-multiple-densities="true">
    </div>
    @include('desktop.layouts.footer')
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

