<div class="certification-wrap">
    <img src="{{ $staticImages['certification_back'] }}" class="background-image" alt="background-image">
    <div class="img-wrap">
        <img src="{{ $staticImages['KDMA_mark'] }}" class="certificate-logo" alt="KDMA">
    </div>
    <img src="{{ $staticImages['KDMA_light_mark'] }}" class="certificate-background-logo" alt="KDMA">
    <p class="certificate-number">자격번호 : {{ $profile->certificate_number ?? '없음' }}</p>
    <h3 class="certificate-title">자 격 증</h3>
    <div class="certificate-information-wrap">
        <div class="certificate-text-wrap">
            <p class="certificate-name">성<span class="for-margin"></span>명 : {{ $profile->name }}</p>
            <p class="certificate-birth">생년월일 : {{ carbonDate($profile->birthday, 'Y-MM-DD') }}</p>
            <p class="certificate-grade">자격등급 : {{ $certification->grade }}</p>
        </div>
        <div class="certificate-image-wrap">
            <img src="{{ $profile_image }}" alt="" class="thumbnail">
        </div>
    </div>
    <pre class="certificate-content">{!! $certification->content !!}</pre>
    <p class="certificate-date"> {{ carbonDate($profile->passed_at ?? time(), 'Y년 M월 D일') }}</p>
    <div class="certificate-associate">
        @foreach($categories as $category)
            @if (in_array($category, ['대한치과의료관리학회', '대한구강위생관리학회']))
                <span class="margin-left">
                    {{ $category }}
                </span>
            @else
                <span>
                    {{ $category }}
                </span>
            @endif
        @endforeach
    </div>
    <div class="certificate-main-associate-wrap">
        <p class="certificate-main-associate">대한치과경영관리협회</p>
        <img src="{{ $staticImages['sign'] }}" class="sign" alt="SIGN">
    </div>
</div>