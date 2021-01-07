@extends('desktop.layouts.app')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/mypage-payment.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            @include('desktop.layouts.navigation.account')

            <section class="payment-history">
                <h2>결제내역</h2>
                <ul>
                    <li>
                        <div class="lecture-information">
                            <span class="online">온라인</span>
                            <h3 class="lecture-name">치과위생사를 위한 예방 및 유지관리 전문가 과정</h3>
                        </div>
                        <table class="payment-information">
                            <tr>
                                <th>결제금액</th>
                                <th>결제상태</th>
                                <th>결제수단</th>
                                <th>결제일</th>
                            </tr>
                            <tr>
                                <td>500,000원</td>
                                <td>결제완료</td>
                                <td>
                                    신용카드
                                    <a href="">결제 영수증</a>
                                </td>
                                <td>2020.11.17</td>
                            </tr>
                        </table>
                    </li>
                    <li class="payment-cancel">
                        <div class="lecture-information">
                            <span class="offline">오프라인</span>
                            <h3 class="lecture-name">치과위생사를 위한 예방 및 유지관리 전문가과정</h3>
                        </div>
                        <table class="payment-information">
                            <tr>
                                <th>결제금액</th>
                                <th>결제상태</th>
                                <th>결제수단</th>
                                <th>결제일/취소일</th>
                            </tr>
                            <tr>
                                <td>500,000원</td>
                                <td class="cancel">결제취소</td>
                                <td>
                                    신용카드
                                    <a href="">취소 영수증</a>
                                </td>
                                <td>
                                    <p class="payment-date">2020.11.17/</p>
                                    2020.11.20
                                </td>
                            </tr>
                        </table>
                    </li>
                    <li>
                        <div class="lecture-information">
                            <span class="online">온라인</span>
                            <h3 class="lecture-name">치과위생사를 위한 예방 및 유지관리 전문가 과정</h3>
                        </div>
                        <table class="payment-information">
                            <tr>
                                <th>결제금액</th>
                                <th>결제상태</th>
                                <th>결제수단</th>
                                <th>결제일</th>
                            </tr>
                            <tr>
                                <td>500,000원</td>
                                <td>결제완료</td>
                                <td>
                                    실시간 계좌이체
                                    <a href="">결제 영수증</a>
                                </td>
                                <td>2020.11.17</td>
                            </tr>
                        </table>
                    </li>
                    <li>
                        <div class="lecture-information">
                            <span class="online">온라인</span>
                            <h3 class="lecture-name">치과위생사를 위한 예방 및 유지관리 전문가 과정</h3>
                        </div>
                        <table class="payment-information">
                            <tr>
                                <th>결제금액</th>
                                <th>결제상태</th>
                                <th>결제수단</th>
                                <th>결제일</th>
                            </tr>
                            <tr>
                                <td>500,000원</td>
                                <td>결제완료</td>
                                <td>
                                    무통장입금(가상계좌)
                                    <a href="">결제 영수증</a>
                                </td>
                                <td>2020.11.17</td>
                            </tr>
                        </table>
                    </li>
                </ul>
            </section>

        </div>
    </section>
@endsection
