@extends('desktop.layouts.frames.basic_frame')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/lecture/lecture-apply.css') }}">
@endsection

@section('content')
    <section class="content lecture-result">
        <div class="container">
            <div class="row">
                <section class="apply-title">
                    <h1>신청내역 확인</h1>
                    <p>Step 1. 신청하기 <span class="for-padding">&gt;</span> <em>Step 2. 신청내역 확인</em></p>
                </section>

                <section class="lecture-information-wrap">
                    <div class="lecture-image">
                        <img src="{{ $program->thumbnail->url }}" alt="강의 사진">
                    </div>
                    <div class="lecture-information">
                        <div class="lecture-sort">
                            <span class="lecture-type">{{$program->minor_category_name}}</span>

                            <p class="lecture-date">수강기간 10일</p>
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
                                        <p class="lecture-length">{{ $program->place->address}}  @isset($program->place->address_detail){{' , '.$program->place->address_detail }}@endisset</p>
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
                            <td><em>{{ $user->name }}</em></td>
                        </tr>
                        <tr>
                            <th>아이디</th>
                            <td><em>{{ $user->login_id }}</em></td>
                        </tr>
                        <tr>
                            <th>이메일</th>
                            <td>
                                <em>{{ $user->email }}</em>
                            </td>
                        </tr>
                        <tr>
                            <th>휴대전화</th>
                            <td>
                                <em>{{ $user->phone }}</em>
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
                        @if($program->getUserSpecificFree())
                            <tr>
                                <th>결제금액</th>
                                <td><em>무료</em></td>
                            </tr>
                        @else
                            <tr>
                                <th>결제금액</th>
                                <td><em>{{ number_format($programStudent->payment->totalAmount) }}원</em></td>
                            </tr>
                            <tr>
                                <th>결제방식</th>
                                <td>
                                    @if ($programStudent->payment->method == '가상계좌')
                                        <p class="payment-method-virtual">{{ changePaymentMethodName($programStudent->payment->method) }}</p>
                                        <p class="tip">
                                            ※ 계좌입금 후 신청이 완료됩니다.<br>
                                            ※ 마이페이지 – 결제내역에서 계좌 확인이 가능합니다.
                                        </p>
                                    @elseif($programStudent->payment->method == '계좌입금')
                                        <p class="payment-method">{{ changePaymentMethodName($programStudent->payment->method) }}</p>
                                        <p class="account">신한은행 140-010-094358 예금주 : ㈜브레인스펙병원교육개발원</p>
                                    @else
                                        <p class="payment-method">{{ changePaymentMethodName($programStudent->payment->method) }}</p>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </table>
                </section>

                <section class="btn-wrap">
                    <a href="{{ route('lectures.detail',$program->id) }}" class="btn-confirm">확인</a>
                </section>
            </div>
        </div>
    </section>
@endsection

