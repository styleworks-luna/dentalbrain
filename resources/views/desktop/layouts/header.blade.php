<header class="header">
    <div class="container">
        <div class="header-logo-wrap">
            <a href="{{ url('/') }}" class="ir_pm header-logo">
                <img src="{{ asset('/images/desktop/global/logo.png') }}" alt="덴탈브레인">
            </a>
        </div>
        <div class="login-menu">
            @auth()
                @if(auth()->user()->isAdmin())
                    <p class="admin"><a href="{{ url('admin') }}">관리자</a></p>
                @endif
                <p class="user-name"><a href="{{ route('account.index') }}">{{ auth()->user()->name }}</a> 님</p>
                <a href="{{ route('logout') }}" class="login-btn">로그아웃</a>
            @else
                <p class="user-name"><a href="{{ route('register') }}">회원가입</a></p>
                <a href="{{ route('login') }}" class="login-btn">로그인</a>
            @endauth
        </div>
        <div class="header-right">
            <ul>
                <li>
                    <a href="{{ route('account.index') }}" class="header-mypage">마이페이지</a>
                </li>
                <li>
                    <a href="{{ route('customer.index') }}" class="header-cs">고객센터</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="header-menu-wrap">
        <div class="header-menu">
            <ul>
                <li><a href="{{ url('introduce') }}">회사소개</a></li>
                <li><a href="{{ url('instructor') }}">강사소개</a></li>
                <li><a href="{{ url('community') }}">커뮤니티</a></li>
                <li><a href="{{ url('lectures') }}">전체강의</a></li>
                <li><a href="{{ url('membership') }}">유료회원</a></li>
            {{--<li><a href="{{ url('albatalk') }}">알바톡</a></li>--}}
            </ul>
            <form action="{{ route('lectures.search') }}" method="GET">
            <div class="input-wrap">
                <input type="text" id="keyword" name="keyword" placeholder="검색어를 입력하세요."/>
                <button class="btn-search ir_pm">
                    검색
                    <span class="search-icon"></span>
                </button>
            </div>
            </form>
        </div>
    </div>
</header>
