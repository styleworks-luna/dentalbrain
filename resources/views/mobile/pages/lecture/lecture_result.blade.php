@extends('mobile.layouts.frames.except_frame')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/lecture/lecture-apply.css') }}">
@endsection

@section('content')
    <section class="content lecture-result">
        <div class="m-container">
            <div class="m-short-row">

                <section class="lecture-information-wrap">

                    <div class="lecture-information">
                        <div class="lecture-sort">
                            @if($program->is_online == true)
                                <span class="online">온라인</span>
                            @else
                                <span class="offline">오프라인</span>
                            @endif

                            <p class="lecture-subject">
                                {{ $program->major_category_name }} @isset($program->minor_category_name) &middot; {{ $program->minor_category_name}} @endisset</p>
                            @if($program->is_online == true)
                                <p class="lecture-length">{{ $program->running_time }}</p>
                            @endif
                        </div>
                        <h2 class="lecture-title">{{ $program->title }}</h2>
                        <table>
                            @if($program->is_online == false)
                                <tr>
                                    <td>
                                        <p class="lecture-length">
                                            {{ carbonDate($program->place->started_at,'Y년 MMMM Do (ddd) HH:mm ') }}
                                            ~ {{ carbonDate($program->place->ended_at,'Y년 MMMM Do (ddd) HH:mm ') }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="lecture-length">
                                            {{ $program->place->address }} @isset($program->place->address_detail){{ ' , '.$program->place->address_detail }}@endisset
                                        </p>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </section>

                <section class="applicant-information">
                    <h3>신청자 정보 <span class="warning">※ 정보 변경은 마이페이지에서 가능합니다.</span></h3>
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
                                <em>{{ auth()->user()->email }}</em>
                            </td>
                        </tr>
                        <tr>
                            <th>휴대전화</th>
                            <td>
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

                    <div class="payment-result">
                        @if($program->ticket->is_free)
                            <span>결제금액</span>
                            <span class="price"><em>무료</em></span>
                        @else
                            <span>
                                {{ changePaymentMethodName($programStudent->payment->method) }}
                            </span>

                            @if($program->repeated())
                                <span class="price"><em>{{ number_format($program->ticket->repeat_price) }}원</em></span>
                            @else
                                <span class="price"><em>{{ number_format($program->ticket->price) }}원</em></span>
                            @endif

                        @endif
                    </div>
                    @isset($programStudent->payment)
                        @if ($programStudent->payment->method == '가상계좌')
                            <div class="tip">
                                ※ 계좌입금 후 신청이 완료됩니다.<br>
                                ※ 마이페이지 – 결제내역에서 계좌 확인이 가능합니다.
                            </div>
                        @endif
                    @endisset

                </section>

                <section class="btn-wrap">
                    <a href="{{ route('lectures.detail',$program->id) }}" class="btn-confirm">확인</a>
                </section>
            </div>
        </div>
    </section>
@endsection

