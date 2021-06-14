<nav class="aside hide">
    <div class="aside-wrap">
        <div class="top">
            <a href="{{ URL('/') }}">
                <img src="{{ asset('/images/mobile/navigation/icon_nav_home.svg') }}" alt="메인 바로가기">
            </a>
            <a href="" class="btn-nav-close">
                <img src="{{ asset('/images/mobile/navigation/icon_nav_close.svg') }}" alt="닫기">
            </a>
        </div>

        <div class="aside-main">
            <div class="user-controller">
                @auth()
                    <div class="user">
                        <div class="name">
                            <strong>{{ auth()->user()->name }}</strong> 님
                        </div>
                        <div class="user-edit">
                            <a href="{{ route('account.modify') }}">회원정보 수정</a>
                        </div>
                    </div>
                    <div class="my-page">
                        <ul>
                            <li><a href="{{ route('account.lectures') }}">신청한 강의</a></li>
                            <li><a href="{{ route('account.payments') }}">결제내역</a></li>
                            <li><a href="{{ route('account.questions.index') }}">질문내역</a></li>
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
                    <li><a href="{{ url('introduce') }}">회사소개</a></li>
                    <li><a href="{{ url('instructor') }}">강사소개</a></li>
                    <li><a href="{{ url('community') }}">커뮤니티</a></li>
                    <li><a href="{{ url('lectures') }}">전체강의</a></li>
                    <li><a href="{{ url('membership') }}">유료회원</a></li>
                    <li><a href="{{ route('account.like') }}">찜 강의내역</a></li>
                </ul>
                <div class="menu-title">
                    <h3>고객센터</h3>
                    <span class="line"></span>
                </div>
                <ul class="CI">
                    <li><a href="{{ route('customer.notices.index') }}">공지사항</a></li>
                    <li><a href="{{ route('customer.faqs.index') }}">FAQ</a></li>
                    <li><a href="{{ route('customer.inquiries.index') }}">문의하기</a></li>
                </ul>
            </div>

            <div class="search-controller">
                <form action="{{ route('lectures.search') }}" method="GET">
                    <input type="text" id="keyword" name="keyword" placeholder="검색어를 입력하세요."/>
                    <button class="btn-search ir_pm">
                        검색
                        <span class="search-icon"></span>
                    </button>
                </form>
            </div>
        </div>


        <div class="bottom">
            @auth()
                <a href="{{ route('logout') }}">로그아웃</a>
                <a href="{{ route('account.secession') }}">회원탈퇴</a>
            @else
                <a href="{{ route('login') }}">로그인</a>
                <a href="{{ route('register') }}">회원가입</a>
            @endauth
        </div>
    </div>
</nav>
<div class="aside-dim hide"></div>
