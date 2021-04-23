@extends('mobile.layouts.frames.basic_frame')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/introduce/about-us.css') }}">
@endsection

@section('title')
    <a href="" class="btn-back"></a>
    <h1>회사소개</h1>
@endsection

@section('content')
    <section class="content">
        <div class="title-image"></div>
        <div class="m-container">
            <div class="m-row">
                <div class="title">
                    <em>덴탈브레인과 함께하세요!</em>
                    <h1>남들과 조금은 차별화된 인재로 거듭나기!</h1>
                    <strong>원장님, 실장, 스텝, 경영지원실등 치과스텝을 위한 다양한 세미나가 매달 업데이트 됩니다.</strong>
                </div>
                <div class="introduce-description">
                    <div class="introduce-start">
                        <div class="img-wrap">
                            <img src="{{ asset("images/mobile/introduce/introduce_img.png") }}" alt="회사소개 이미지">
                        </div>
                        <div class="start-content">
                            <div class="content-wrap">

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
                                <img src="{{ asset("images/mobile/introduce/sign.png") }}" alt="김민정 사인">
                            </div>
                        </div>
                    </div>
                    <div class="introduce-middle">
                        <div class="img-wrap">

                        </div>
                        <div class="description">
                            <ul>
                                <li>
                                    <p>도태되지 않고 <em>세상변화에
                                            빠르게 반응하며 발빠른 지식과
                                            정보</em>를 얻기 위해 끊임없는 학습을 통해 자신의 목표에
                                        다가가고 있습니다.</p>
                                </li>
                                <li>
                                    <p>브레인스펙의 온라인 &
                                        오프라인 채널로 <em>공부하고자 하는
                                            치과인들의 파트너</em>가 되겠습니다.</p>
                                </li>
                                <li>
                                    <p>2006년 설립, 30년 이상 치과계에 종사, 현업에 필요한 실질적인
                                        교육 프로그램과 더욱 도전적이고
                                        <em>질 높은 교육 컨텐츠로 치과인들의
                                            업으로 도움</em>되게 노력했습니다.</p>
                                </li>
                                <li>
                                    <p>치과계의 지속적인 <em>새로운
                                            교육스타일과 온오프라인
                                            교육을 통해 앞선 기술을</em> 연구하며 성공적인 치과인의 알맞은
                                        교육을 선보이겠습니다.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="introduce-end">
                        <h3><em>덴탈브레인의<br>강의 구성</em>을 소개합니다.</h3>
                        <p>덴탈브레인이 제공하는 교육프로그램은 온오프라인 세미나 학습자의 다양한 요구에 맞추어,
                            임상전문가의 높은 수준의 교육을 제공하고 있습니다.</p>
                        <div class="introduce-construction">
                            <table>
                                <tr>
                                    <td>임플란트 임상교육</td>
                                    <td>치과임상심화</td>
                                    <td>계속구강관리</td>
                                    <td>치과상담</td>
                                </tr>
                                <tr>
                                    <td>치과건강보험</td>
                                    <td>치과경영</td>
                                    <td>치과<br>사보험</td>
                                    <td>온라인<br>마케팅</td>
                                </tr>
                                <tr>
                                    <td>치과 미스터리진단</td>
                                    <td>치과 텔레마케팅</td>
                                    <td>치아교정재료</td>
                                    <td>치아교정상담</td>
                                </tr>
                                <tr>
                                    <td>임플란트상담</td>
                                    <td>임플란트임상교육</td>
                                    <td>치과 방사선촬영법</td>
                                    <td>치과재료</td>
                                </tr>
                                <tr>
                                    <td>리셉션<br>직무교육</td>
                                    <td>조직관리</td>
                                    <td>팀워크</td>
                                    <td>직원 채용과 관리</td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td>직무 스트레스 관리</td>
                                    <td>해리슨직무 적합도검사</td>
                                    <td>병원코디네이터<br>자격과정</td>
                                    <td>치과코디네이터<br>자격과정</td>
                                </tr>
                                <tr>
                                    <td>텔레<br>마케팅<br>자격과정</td>
                                    <td>온라인<br>마케팅<br>자격과정</td>
                                    <td>병원<br>관리자<br>자격과정</td>
                                    <td>치과보험청구사과정</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
