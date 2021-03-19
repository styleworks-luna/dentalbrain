<div class="term-menu">
    <ul>
        <li class="{{ (strpos(Route::currentRouteName(), 'service') !== false) ? 'active' : '' }}"><a href="{{ url('service') }}">이용약관</a></li>
        <li class="{{ (strpos(Route::currentRouteName(), 'privacy') !== false) ? 'active' : '' }}"><a href="{{ url('privacy') }}">개인정보처리방침</a></li>
        <li class="{{ (strpos(Route::currentRouteName(), 'refund') !== false) ? 'active' : '' }}"><a href="{{ url('refund') }}">환불약관</a></li>
    </ul>
</div>
