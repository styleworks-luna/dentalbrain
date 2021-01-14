<div class="service-menu">
    <h1>고객센터</h1>
    <ul>
        <li class="{{ (strpos(Route::currentRouteName(), 'customer.notices.index') !== false) ? 'active-menu' : '' }}"><a href="{{ route('customer.notices.index') }}">공지사항</a></li>
        <li class="{{ (strpos(Route::currentRouteName(), 'customer.faqs.index') !== false) ? 'active-menu' : '' }}"><a href="{{ route('customer.faqs.index') }}">FAQ</a></li>
        <li class="{{ (strpos(Route::currentRouteName(), 'customer.inquiries.index') !== false) ? 'active-menu' : '' }}"><a href="{{ route('customer.inquiries.index') }}">문의하기</a></li>
    </ul>
</div>
