<nav class="aside hide">

    <div class="top">
        <a href="{{ URL('/') }}">
            <img src="{{ asset('/images/mobile/navigation/icon_nav_home.svg') }}" alt="메인 바로가기">
        </a>
        <a href="" class="btn-nav-close">
            <img src="{{ asset('/images/mobile/navigation/icon_nav_close.svg') }}" alt="닫기">
        </a>
    </div>

    <div class="user-controller">
        @auth()
            <div class="user">
                <div class="name">
                    <strong>{{ auth()->user()->name }}</strong> 님
                </div>
                <div class="user-edit">
                    <a href="">회원정보 수정</a>
                </div>
            </div>
            <div class="my-page">
                <ul>
                    <li><a href="">신청한 강의</a></li>
                    <li><a href="">결제내역</a></li>
                    <li><a href="">질문내역</a></li>
                </ul>
            </div>
        @else
            <div class="user-no-login">
                <h2><em>로그인</em> 해주세요</h2>
                <p>회원이 아니시라면 <strong>회원가입</strong>을 해주세요.</p>
            </div>
        @endauth
    </div>

    <div class="menu-controller">
        <ul class="main-menu">
            <li>회사소개</li>
            <li>강의안내</li>
            <li>강사소개</li>
            <li>전체강의</li>
        </ul>
        <div class="menu-title">
            <h3>고객센터</h3>
            <span class="line"></span>
        </div>
        <ul class="CI">
            <li>공지사항</li>
            <li>FAQ</li>
            <li>문의하기</li>
        </ul>
    </div>

    <div class="bottom">
        @auth()
            <a href="{{ route('logout') }}">로그아웃</a>
            <a href="">회원탈퇴</a>
        @else
            <a href="{{ route('login') }}">로그인</a>
            <a href="{{ route('register') }}">회원가입</a>
        @endauth
    </div>

</nav>
<div class="dim hide"></div>
