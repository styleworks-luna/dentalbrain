<div class="certification-wrap">
    <img src="{{ $staticImages['certification_back'] }}" class="background-image" alt="background-image">
    <div class="img-wrap">
        <img src="{{ $staticImages['KDMA_mark'] }}" class="certificate-logo" alt="KDMA">
    </div>
    <img src="{{ $staticImages['KDMA_light_mark'] }}" class="certificate-background-logo" alt="KDMA">
    <h3 class="certificate-title"> 교 육 수 료 증</h3>
    <p class="certificate-name">성<span class="for-margin"></span>명 : {{ $profile->name }}</p>
    <pre class="certificate-content">{!! $certification->content !!}</pre>
    <p class="certificate-sub-content">{{ $certification->bottom_content }}</p>
    <p class="certificate-date"> {{ carbonDate($profile->passed_at ?? time(), 'Y년 M월 D일') }}</p>
    <div class="certificate-associate">
        @foreach($categories as $category)
            <span class="{{ in_array($category, ['대한치과의료관리학회', '대한구강위생관리학회']) ? 'margin-left-50' : '' }}">
                {{$category}}
            </span>
        @endforeach
    </div>
    <div class="certificate-main-associate-wrap">
        <p class="certificate-main-associate">대한치과경영관리협회</p>
        <img src="{{ $staticImages['sign'] }}" class="sign" alt="SIGN">
    </div>
</div>
