<div class="mypage-menu">
    <h1>마이페이지</h1>
    <ul>
        <li class="{{ (strpos(Route::currentRouteName(), 'account.lectures') !== false) ? 'active-menu' : '' }}">
            <a href="{{ route('account.lectures') }}">신청한 강의</a></li>
        <li class="{{ (strpos(Route::currentRouteName(), 'account.like') !== false) ? 'active-menu' : '' }}">
            <a href="{{ route('account.like') }}">찜 내역</a></li>
        <li class="{{ (strpos(Route::currentRouteName(), 'account.payments') !== false) ? 'active-menu' : '' }}">
            <a href="{{ route('account.payments') }}">결제내역</a></li>
        <li class="{{ (strpos(Route::currentRouteName(), 'account.questions.index') !== false) ? 'active-menu' : '' }}">
            <a href="{{ route('account.questions.index') }}">질문내역</a></li>
        <li class="{{ (strpos(Route::currentRouteName(), 'account.albatalk') !== false) ? 'active-menu' : '' }}">
            <a href="{{ route('account.albatalk') }}">구인정보</a></li>
        <li class="{{ (strpos(Route::currentRouteName(), 'account.offer') !== false) ? 'active-menu' : '' }}">
            <a href="{{ route('account.offer') }}">구직정보</a></li>
        <li class="{{
    (strpos(Route::currentRouteName(), 'account.modify') !== false ||
     (strpos(Route::currentRouteName(), 'account.confirm') !== false)) ? 'active-menu' : '' }}">
            <a href="{{ route('account.modify') }}">회원정보 수정</a></li>
        <li class="{{ (strpos(Route::currentRouteName(), 'account.secession') !== false) ? 'active-menu' : '' }}">
            <a href="{{ route('account.secession') }}">회원탈퇴</a></li>
    </ul>
</div>
