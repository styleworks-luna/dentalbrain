@extends('mobile.layouts.frames.basic_frame')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/introduce/about-us.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="title-wrap">
            <div class="title">
                <em>덴탈브레인과 함께하세요!</em>
                <h1>남들과 조금은 차별화된 인재로 거듭나기!</h1>
                <strong>원장님, 실장, 스텝, 경영지원실등 치과스텝을 위한 다양한 세미나가 매달 업데이트 됩니다.</strong>
            </div>
        </div>
        <div class="m-container">
            <div class="introduce-description">
                <h2>회사소개</h2>
                <div class="introduce-start">
                    <div class="img-wrap">
                        <img src="{{ asset("images/desktop/introduce/introduce_img.png") }}" alt="회사소개 이미지">
                    </div>
                    <div class="start-content">
                        <div class="content-img-wrap">
                            <img src="{{ asset("images/desktop/introduce/introduce_title.png") }}" alt="회사소개 타이틀">
                        </div>
                        <div class="text-wrap">
                            <p>
                                치과임상현장에서 실무전문가를 만드는 것입니다.수강자들이 지식을 수집하여<br>
                                임상현장의 문제를 해결하고 자신의 업무 및 치과 환경에서 일어나는 문제에 대한<br>
                                해결능력을 높일 수 있도록 돕겠습니다.<br>
                                <br>
                                전문강사들의 교육과 실전코칭으로 성공적으로 치과업무에 적용하는<br>
                                온오프라인으로 전문과정과 세미나로 진행합니다.<br>
                                <br>
                                덴탈브레인이 제공하는 오늘배워 내일적용하는<br>
                                실용적인 세미나로 여러분의 성장과 발전을 응원합니다.<br>
                            </p>
                        </div>
                        <div class="sign">
                            <img src="{{ asset("images/desktop/introduce/introduce_sign.png") }}" alt="김민정 사인">
                        </div>
                    </div>
                </div>
                <div class="introduce-middle">
                    <div class="img-wrap">
                        <img src="{{ asset("images/desktop/introduce/introduce_img_2.png") }}"
                             alt="CREATIVE,PARTNER,HISTORY,PROFESSIONAL">
                    </div>
                    <div class="description">
                        <ul>
                            <li>
                                <p>도태되지 않고 <em>세상변화에<br>
                                        빠르게 반응하며 발빠른 지식과<br>
                                        정보</em>를 얻기 위해 끊임없는 학습을 통해 자신의 목표에<br>
                                    다가가고 있습니다.</p>
                            </li>
                            <li>
                                <p class="for-padding">브레인스펙의 온라인 &<br>
                                    오프라인 채널로 <em>공부하고자 하는<br>
                                        치과인들의 파트너</em>가 되겠습니다.</p>
                            </li>
                            <li>
                                <p>2006년 설립, 30년 이상 치과계에 종사, 현업에 필요한 실질적인<br>
                                    교육 프로그램과 더욱 도전적이고<br>
                                    <em>질 높은 교육 컨텐츠로 치과인들의<br>
                                        업으로 도움</em>되게 노력했습니다.</p>
                            </li>
                            <li>
                                <p>치과계의 지속적인 <em>새로운<br>
                                        교육스타일과 온오프라인<br>
                                        교육을 통해 앞선 기술을</em> 연구하며 성공적인 치과인의 알맞은<br>
                                    교육을 선보이겠습니다.</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="introduce-end">
                    <h3><em>덴탈브레인의 강의 구성</em>을 소개합니다.</h3>
                    <p>덴탈브레인이 제공하는 교육프로그램은 온오프라인 세미나 학습자의 다양한 요구에 맞추어,<br>
                        임상전문가의 높은 수준의 교육을 제공하고 있습니다.</p>
                    <div class="img-wrap">
                        <img src="{{ asset("images/desktop/introduce/introduce_content.png") }}" alt="강의 구성">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
