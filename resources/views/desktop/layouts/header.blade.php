<header class="header">
    <div class="container">
            <div class="header-logo-wrap">
                <a href="{{ url('/') }}" class="ir_pm header-logo">
                    <img src="{{ asset('/images/desktop/global/logo.png') }}" alt="덴탈브레인">
                </a>
            </div>
            <div class="login-menu">
                <p class="user-name"><a href="">홍길동</a> 님</p>
                <a href="" class="login-btn">로그아웃</a>
            </div>
            <div class="header-left">
                <ul>
                    <li><a href="{{ url('introduce') }}">회사소개</a></li>
                    <li><a href="">강의안내</a></li>
                    <li><a href="{{ url('instructor') }}">강사소개</a></li>
                    <li><a href="">전체강의</a></li>
                </ul>
            </div>
            <div class="header-right">
                <ul>
                    <li>
                        <a href="" class="header-mypage">마이페이지</a>
                    </li>
                    <li>
                        <a href="" class="header-cs">고객센터</a>
                    </li>
                </ul>
            </div>
        </div>
</header>
