@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script src="https://js.tosspayments.com/v1"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script>
        $(function () {
            // select menu
            var select_menu = $('.select-menu');
            var clientKey = '{{ env('TOSS_PAYMENTS_CLIENT_KEY') }}';
            var tossPayments = TossPayments(clientKey);
            var message = getParameter('message');
            var paymentmethod = $('.payment-method:checked').val();

            // 결제 실패시 오류 메세지 출력
            paymentMessage(message);

            if (select_menu.length > 0) {
                select_menu.selectmenu();
            }

            $('.payment-method').change(function () {
                paymentmethod = $('.payment-method:checked').val();
            });

            $('.btn-submit').click(function (e) {
                if (paymentmethod == "별도결제") {
                    alert('신한은행\n' +
                        '140-010-094358\n' +
                        '(주)브레인스펙병원교육개발원\n\n' +
                        '관리자가 입금내역을\n' +
                        '확인하면 강의를 시청하실 수 있습니다.\n\n' +
                        '입금후 관리자에게 확인요청을 부탁드립니다.\n' +
                        '사업자지출증빙, 세금계산서발행을 원하시는\n' +
                        '경우에 관리자에게 문의하시기 바랍니다.');
                    $('#separate_form').submit();
                } else {
                    $('.btn-submit').click(function (e) {
                        var paymentObj;
                        var cardCompany = $('.ui-selectmenu-text').text();

                        const amount = {{ $program->repeated() ? $program->ticket->repeat_price : $program->ticket->price }};
                        const orderId = '{{ \Illuminate\Support\Str::random(3) . time() }}';
                        const orderName = '{{$program->title . ', ' . $program->ticket->name}}';
                        const customerName = '{{ auth()->user()->name }}';
                        const successUrl = '{{ route('lectures.payment.success',$program->id) }}';
                        const customerEmail = '{{ auth()->user()->email }}';
                        const customerMobilePhone = '{{ auth()->user()->phone }}';

                        e.preventDefault();

                        if (paymentmethod === '가상계좌') {
                            paymentObj = {
                                amount: amount,
                                orderId: orderId,
                                orderName: orderName,
                                customerName: customerName,
                                successUrl: successUrl,
                                failUrl: window.location.href,
                                customerEmail: customerEmail,
                                customerMobilePhone: customerMobilePhone,
                            };
                        } else if (paymentmethod === '카드') {
                            var maxCardInstallmentPlan = (cardCompany === 'BC' ? 3 : 12);

                            paymentObj = {
                                amount: amount,
                                orderId: orderId,
                                orderName: orderName,
                                customerName: customerName,
                                successUrl: successUrl,
                                failUrl: window.location.href,
                                customerEmail: customerEmail,
                                customerMobilePhone: customerMobilePhone,

                                maxCardInstallmentPlan: maxCardInstallmentPlan,
                                cardCompany: cardCompany,
                            };
                        } else if (paymentmethod === '계좌이체') {
                            paymentObj = {
                                amount: amount,
                                orderId: orderId,
                                orderName: orderName,
                                customerName: customerName,
                                successUrl: successUrl,
                                failUrl: window.location.href,
                                customerEmail: customerEmail,
                                customerMobilePhone: customerMobilePhone,
                            };
                        }

                        tossPayments.requestPayment(paymentmethod, paymentObj).catch(function (err) {
                            alert('취소');
                        });
                    });
                }
            });


        });

        function getParameter(param) {
            var paramData = window.location.search.substr(1).split('&').filter(function (i) {
                return i.split('=')[0] == param;
            });

            return paramData.length === 0 ? null : paramData[0].split('=')[1];
        }

        function paymentMessage(message) {
            if (message) {
                alert(decodeURI(message));
            }
        }
    </script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/lecture/lecture-apply.css') }}">
@endsection

@section('content')
    <section class="content lecture-payment">
        <div class="container">
            <div class="row">
                <section class="apply-title">
                    <h1>신청내역 확인</h1>
                    <p><em>Step 1. 신청하기</em> <span class="for-padding">&gt;</span> Step 2. 신청내역 확인</p>
                </section>

                <section class="lecture-information-wrap">
                    <div class="lecture-image">
                        <img src="{{ $program->thumbnail->url }}" alt="강의 사진">
                    </div>
                    <div class="lecture-information">
                        <div class="lecture-sort">
                            @if($program->is_online == true)
                                <span class="online">온라인</span>
                            @else
                                <span class="offline">오프라인</span>
                            @endif

                            <p class="lecture-subject">
                                {{ $program->major_category_name }} &middot; {{ $program->minor_category_name}}</p>
                        </div>
                        <h2 class="lecture-title">{{ $program->title }}</h2>
                        <table>
                            @if($program->is_online == true)
                                <tr>
                                    <th>강의시간</th>
                                    <td><p class="lecture-length">{{ $program->running_time }}</p></td>
                                </tr>
                            @else
                                <tr>
                                    <th>강의일시</th>
                                    <td>
                                        <p class="lecture-length">{{ carbonDate($program->place->started_at,'Y년 MMMM Do (ddd) HH:mm ') }}
                                            ~ {{ carbonDate($program->place->ended_at,'Y년 MMMM Do (ddd) HH:mm ') }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>강의장소</th>
                                    <td>
                                        <p class="lecture-length">{{ $program->place->address.' , '.$program->place->address_detail }}</p>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </section>

                <section class="applicant-information">
                    <h3>신청자 정보</h3>
                    <table>
                        <tr>
                            <th>이름</th>
                            <td><em>{{ auth()->user()->name }}</em></td>
                        </tr>
                        <tr>
                            <th>아이디</th>
                            <td><em>{{ auth()->user()->login_id }}</em></td>
                        </tr>
                        <tr>
                            <th>이메일</th>
                            <td>
                                {{--TODO: 강의 수강자(program_student) 생기는 대로 업데이트 해야함.--}}
                                <em>{{ auth()->user()->email }}</em>
                            </td>
                        </tr>
                        <tr>
                            <th>휴대전화</th>
                            <td>
                                {{--TODO: 강의 수강자(program_student) 생기는 대로 업데이트 해야함.--}}
                                <em>{{ auth()->user()->phone }}</em>
                            </td>
                        </tr>
                    </table>
                </section>

                @if($surveys->isNotEmpty())
                    <section class="additional-information-list">
                        <h3>추가 정보</h3>
                        <ul class="information-answers-list">
                            @forelse($surveys as $survey)
                                @switch($survey->type)
                                    @case('singleChoice')
                                    <li class="information-answers">
                                        <h4>{{ $survey->question }} <em>{{ $survey->is_required ? '(필수)' : null}}</em>
                                        </h4>
                                        <div class="answer">
                                            <ul>
                                                <li>{{ $survey->answer->content }}</li>
                                            </ul>
                                        </div>
                                    </li>
                                    @break
                                    @case('multipleChoice')
                                    <li class="information-answers">
                                        <h4>{{ $survey->question }} <em>{{ $survey->is_required ? '(필수)' : null}}</em>
                                        </h4>
                                        <div class="answer">
                                            <ul>
                                                @forelse($survey->answers as $answer)
                                                    <li>{{ $answer->content }}</li>
                                                @empty
                                                    선택 없음.
                                                @endforelse
                                            </ul>
                                        </div>
                                    </li>
                                    @break
                                    @case('shortAnswer')
                                    <li class="information-answers">
                                        <h4>{{ $survey->question }} <em>{{ $survey->is_required ? '(필수)' : null}}</em>
                                        </h4>
                                        <div class="answer">
                                            <ul>
                                                <li class="short-answer">
                                                    {{ $survey->answer->content }}
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    @break
                                    @case('address')
                                    <li class="information-answers">
                                        <h4>{{ $survey->question }} <em>{{ $survey->is_required ? '(필수)' : null}}</em>
                                        </h4>
                                        <div class="answer">
                                            <p>{{ $survey->answer->address }}{{ ', ' . $survey->answer->address_detail }}</p>
                                        </div>
                                    </li>
                                    @break
                                    @case('file')
                                    <li class="information-answers">
                                        <h4>{{ $survey->question }} <em>{{ $survey->is_required ? '(필수)' : null}}</em>
                                        </h4>
                                        <div class="answer">
                                            <ul>
                                                <li>
                                                    <a href="{{$survey->answer->file->url}}"><em>{{ $survey->answer->file->name }}</em></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    @break
                                    @default
                                    <p>오류가 발생했습니다.</p>
                                @endswitch
                            @empty
                                추가 정보 없음.
                            @endforelse
                        </ul>
                    </section>
                @endif

                <section class="payment-information">
                    <h3>결제정보</h3>
                    <table>
                        <tr>
                            <th>결제금액</th>
                            @if($program->repeated())
                                {{--무료인 경우 결제 프로세스 없이 넘어가야 함.--}}
                                <td><em>재수강 할인가 :{{ number_format($program->ticket->repeat_price) }}원</em></td>
                            @else
                                <td><em>{{ number_format($program->ticket->price) }}원</em></td>
                            @endif

                        </tr>
                        <tr>
                            <th>결제방식</th>
                            <td>
                                <div class="radio-wrap">
                                    <input type="radio" id="card" name="payment-method"
                                           class="payment-method" value="카드" checked>
                                    <label for="card">신용카드</label>

                                    <select name="payment-method" id="credit" class="select-menu">
                                        <option value="신한">신한</option>
                                        <option value="현대">현대</option>
                                        <option value="삼성">삼성</option>
                                        <option value="우리">우리</option>
                                        <option value="BC">BC</option>
                                        <option value="국민">국민</option>
                                        <option value="롯데">롯데</option>
                                        <option value="농협">농협</option>
                                        <option value="하나">하나</option>
                                        <option value="씨티">씨티</option>
                                        <option value="카카오뱅크">카카오뱅크</option>
                                        <option value="수협">수협</option>
                                        <option value="전북">전북</option>
                                        <option value="우체국">우체국</option>
                                        <option value="새마을">새마을</option>
                                        <option value="저축">저축</option>
                                        <option value="제주">제주</option>
                                        <option value="광주">광주</option>
                                        <option value="신협">신협</option>
                                        <option value="JCB">JCB</option>
                                        <option value="유니온페이">유니온페이</option>
                                        <option value="마스터">마스터</option>
                                        <option value="비자">비자</option>
                                        <option value="다이너스">다이너스</option>
                                        <option value="디스커버">디스커버</option>
                                    </select>
                                </div>
                                <div class="radio-wrap">
                                    <input type="radio" id="transfer" name="payment-method"
                                           class="payment-method" value="계좌이체">
                                    <label for="transfer">{{ changePaymentMethodName("계좌이체") }}</label>
                                </div>
                                <div class="radio-wrap">
                                    <input type="radio" id="separate" name="payment-method"
                                           class="payment-method" value="별도결제">
                                    <label for="separate"
                                           class="transfer-label">계좌입금</label>
                                </div>
                                {{--<div class="radio-wrap">
                                    <input type="radio" id="deposit" name="payment-method"
                                           class="payment-method" value="가상계좌">
                                    <label for="deposit">무통장입금(가상계좌)</label>
                                </div>--}}
                            </td>
                        </tr>
                    </table>
                </section>

                <section class="btn-wrap">
                    <button type="button" class="btn-confirm btn-submit">결제하기</button>
                    <a href="{{ url()->previous() }}" class="btn-confirm btn-cancel">취소하기</a>
                </section>
                <form action="{{ route('lectures.anotherPay',[$program]) }}" method="POST" id="separate_form">
                    @csrf
                </form>
            </div>
        </div>
    </section>
@endsection

