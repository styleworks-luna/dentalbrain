@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.ui.emailbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script type="text/javascript" src="{{ asset('js/pages/lecture/lecture-apply.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/lecture/lecture-apply.css') }}">
@endsection

@section('content')
    <section class="content lecture-apply">
        <div class="container">
            <form action="{{ route('lectures.apply',$program->id) }}" id="lecture-apply-form" method="POST"
                  enctype="multipart/form-data">
                <div class="row">
                    @csrf
                    <section class="apply-title">
                        <h1>신청하기</h1>
                        <p><em>Step 1. 신청하기</em> <em class="for-padding">&gt;</em> Step 2. 신청내역 확인</p>
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
                                    {{ $program->major_category_name }} &middot; {{ $program->minor_category_name}}
                                </p>
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
                                            <p class="lecture-length">
                                                {{ carbonDate($program->place->started_at,'Y년 MMMM Do (ddd) HH:mm ') }}
                                                ~ {{ carbonDate($program->place->ended_at,'Y년 MMMM Do (ddd) HH:mm ') }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>강의장소</th>
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
                        <h3>신청자 정보 입력</h3>
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
                                    <input type="email"
                                           id="email"
                                           name="email"
                                           class="email_box"
                                           value="{{old('email') ?? auth()->user()->email}}"
                                           data-parsley-required="true"
                                           data-parsley-type="email"
                                           data-parsley-class-handler=".ui-emailbox"
                                           data-parsley-required-message="이메일을 입력해주세요.">
                                </td>
                            </tr>
                            <tr>
                                <th>휴대전화</th>
                                <td>
                                    <input type="text"
                                           id="phone"
                                           name="phone"
                                           class="phone"
                                           value="{{old('phone') ?? auth()->user()->phone}}"
                                           data-parsley-required="true"
                                           data-parsley-required-message="전화번호를 입력해주세요.">
                                </td>
                            </tr>
                        </table>
                    </section>

                    @if($surveys->isNotEmpty())
                        <section class="additional-information">
                            <h3>추가 정보 입력</h3>
                            @foreach($surveys as $idx => $survey)
                                @switch($survey->type)
                                    @case('singleChoice')
                                    <div class="multiple-single-choice">
                                        <h4>{{ $survey->question }} <em>{{ $survey->is_required ? '(필수)' : null}}</em>
                                        </h4>
                                        <input type="hidden" name="surveys[{{ $idx }}][survey_id]"
                                               value="{{ $survey->id }}">
                                        {{-- 값 초기화 --}}
                                        <input type="hidden" name="surveys[{{ $idx }}][answer]" value="">
                                        <div class="choices">
                                            <ul>
                                                @forelse($survey->choices as $choice)
                                                    <li class="radio-wrap">

                                                        <input type="radio" id="choice-{{$choice->id}}"
                                                               name="surveys[{{ $idx }}][answer]"
                                                               value="{{ $choice->id }}"
                                                               data-parsley-required="{{$survey->is_required ? 'true' : 'false'}}"
                                                               data-parsley-errors-container=".radio_error_wrap{{ $survey->id }}"
                                                               data-parsley-multiple="radio{{ $survey->id }}"
                                                               data-parsley-required-message="항목을 선택해주세요.">
                                                        <label
                                                            for="choice-{{$choice->id}}">{{ $choice->question }}</label>
                                                    </li>
                                                @empty
                                                    질문이 없습니다.
                                                @endforelse
                                            </ul>
                                        </div>
                                        <div class="radio_error_wrap{{ $survey->id }}"></div>
                                    </div>
                                    @break
                                    @case('multipleChoice')
                                    <div class="multiple-choice">
                                        <h4>{{ $survey->question }} <em>{{ $survey->is_required ? '(필수)' : null}}</em>
                                        </h4>
                                        <input type="hidden" name="surveys[{{ $idx }}][survey_id]"
                                               value="{{ $survey->id }}">
                                        {{-- 값 초기화 --}}
                                        <input type="hidden" id="multiple-choice-{{ $choice->id }}"
                                               name="surveys[{{ $idx }}][answers]" value="">
                                        <div class="choices">
                                            <ul>
                                                @forelse($survey->choices as $choice)
                                                    <li class="checkbox-wrap">
                                                        <input type="hidden" name="surveys[{{ $idx }}][survey_id]"
                                                               value="{{ $survey->id }}">
                                                        <input type="checkbox" id="multiple-choice-{{ $choice->id }}"
                                                               name="surveys[{{ $idx }}][answers][]"
                                                               value="{{ $choice->id }}"
                                                               data-parsley-required="{{$survey->is_required ? 'true' : 'false'}}"
                                                               data-parsley-errors-container=".checkbox_error_wrap{{ $survey->id }}"
                                                               data-parsley-multiple="checkbox{{ $survey->id }}"
                                                               data-parsley-required-message="항목을 선택해주세요.">
                                                        <label
                                                            for="multiple-choice-{{ $choice->id }}">{{ $choice->question }}</label>
                                                    </li>
                                                @empty
                                                    질문이 없습니다.
                                                @endforelse
                                            </ul>
                                        </div>
                                        <div class="checkbox_error_wrap{{ $survey->id }}"></div>
                                    </div>
                                    @break
                                    @case('shortAnswer')
                                    <div class="short-answer">
                                        <h4>{{ $survey->question }} <em>{{ $survey->is_required ? '(필수)' : null}}</em>
                                        </h4>
                                        <input type="hidden" name="surveys[{{ $idx }}][survey_id]"
                                               value="{{ $survey->id }}">
                                        <div class="answers">
                                            <input type="text" id="short-answer-response"
                                                   name="surveys[{{ $idx }}][answer]"
                                                   class="short-answer-response" placeholder="답변을 입력하세요."
                                                   data-parsley-required="{{$survey->is_required ? 'true' : 'false'}}"
                                                   data-parsley-errors-container=".short_answer_error_wrap{{ $survey->id }}"
                                                   data-parsley-required-message="답변을 입력하세요.">
                                        </div>
                                        <div class="short_answer_error_wrap{{ $survey->id }}"></div>
                                    </div>
                                    @break
                                    @case('address')
                                    <div class="address-question">
                                        <h4>{{ $survey->question }} <em>{{ $survey->is_required ? '(필수)' : null}}</em>
                                        </h4>
                                        <input type="hidden" name="surveys[{{ $idx }}][survey_id]"
                                               value="{{ $survey->id }}">
                                        <div class="answers">
                                            <div class="address-form-wrap">
                                                <input type="button" class="btn-address" value="주소검색"
                                                       data-index="{{ $idx }}">
                                                <input type="text" id="address" name="surveys[{{ $idx }}][address]"
                                                       class="address"
                                                       data-index="{{ $idx }}"
                                                       readonly="readonly"
                                                       data-parsley-required="{{$survey->is_required ? 'true' : 'false'}}"
                                                       data-parsley-errors-container=".address_answer_error_wrap{{ $survey->id }}"
                                                       data-parsley-required-message="주소를 검색해주세요.">
                                                <input type="text" id="address-detail"
                                                       name="surveys[{{ $idx }}][address_detail]"
                                                       class="address-detail"
                                                       placeholder="상세주소를 입력하세요."
                                                       data-parsley-required="{{$survey->is_required ? 'true' : 'false'}}"
                                                       data-parsley-errors-container=".address_answer_error_wrap{{ $survey->id }}"
                                                       data-parsley-required-message="상세주소를 입력하세요">
                                            </div>
                                            <div class="address_answer_error_wrap{{ $survey->id }} address-error"></div>
                                        </div>
                                    </div>
                                    @break
                                    @case('file')
                                    <div class="file-question">
                                        <h4>{{ $survey->question }} <em>{{ $survey->is_required ? '(필수)' : null}}</em>
                                        </h4>
                                        <input type="hidden" name="surveys[{{ $idx }}][survey_id]"
                                               value="{{ $survey->id }}">
                                        <div class="answers">
                                            <div class="file-wrap">
                                                <input type="file"
                                                       id="file-upload"
                                                       class="upload-hidden"
                                                       name="surveys[{{ $idx }}][file]"
                                                       accept=".Key, .PDF, .Doc, .PPT, .Pages, .pptx, .docx, .xlsx,
                                               .xls, .hwp, .JPG, .JPEG, .PNG, .GIF  .zip, .alz, .rar"
                                                       data-parsley-required="{{$survey->is_required ? 'true' : 'false'}}"
                                                       data-parsley-errors-container=".file_error_wrap{{ $survey->id }}"
                                                       data-parsley-required-message="파일을 업로드해주세요.">
                                                <label for="file-upload" class="btn-file-upload">파일선택</label>
                                                <input type="text" id="file-name" name="surveys[{{ $idx }}][fileName]"
                                                       class="file-name"
                                                       value="파일을 업로드해주세요." disabled="disabled">
                                            </div>
                                            <div class="file_error_wrap{{ $survey->id }}"></div>
                                            <div class="tips">
                                                <p>
                                                    ※ 파일 용량은 최대 2MB까지 등록할 수 있습니다.<br>
                                                    ※ 첨부가능 확장자 : 문서파일 : Key, PDF, Doc, PPT, Pages, pptx, docx, xlsx,
                                                    xls,
                                                    hwp /
                                                    이미지파일 :
                                                    JPG, JPEG, PNG, GIF / 압축파일 : zip, alz, rar
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                    @default
                                    <p>default</p>
                                @endswitch
                            @endforeach
                        </section>
                    @endif

                    <section class="payment-information">
                        <h3>결제정보</h3>
                        <table>
                            <tr>
                                <th>결제금액</th>
                                <td><em>{{ $program->ticket->is_free ? '무료' : $program->ticket->price.'원' }}</em></td>
                            </tr>
                        </table>
                    </section>
                    <section class="agree">
                        <h3>신청자 동의</h3>
                        <div class="agreement-all-wrap checkbox-wrap">
                            <input type="checkbox" id="agree-all" name="agree-all" class="agree-all">
                            <label for="agree-all">전체동의</label>
                        </div>
                        <div class="agreement-wrap">
                            <ul>
                                <li>
                                    <div class="checkbox-wrap">
                                        <input type="checkbox" id="offer-consent" name="offer-consent"
                                               class="offer-consent"
                                               data-parsley-required="true"
                                               data-parsley-errors-container=".offer_error_wrap"
                                               data-parsley-required-message="동의를 선택해주세요.">
                                        <label for="offer-consent">(필수) 개인정보 제3자 제공 동의</label>
                                    </div>
                                    <p>신청자의 개인정보가 신청여부 확인 등 모임 진행을 위해 개설자에게 제공됩니다.</p>
                                    <a href="">내용보기</a>
                                    <div class="offer_error_wrap"></div>
                                </li>
                                <li>
                                    <div class="checkbox-wrap">
                                        <input type="checkbox" id="refund-consent" name="refund-consent"
                                               class="refund-consent"
                                               data-parsley-required="true"
                                               data-parsley-errors-container=".refund_error_wrap"
                                               data-parsley-required-message="동의를 선택해주세요.">
                                        <label for="refund-consent">(필수) 취소/환불약관 동의</label>
                                    </div>
                                    <p>신청기간 마감 전까지 환불신청 가능(결제수단, 사유, 환불시점에 따라 수수료 차감)</p>
                                    <a href="">내용보기</a>
                                    <div class="refund_error_wrap"></div>
                                </li>
                            </ul>
                        </div>
                    </section>

                    <section class="btn-wrap">
                        <button type="submit" class="btn-confirm">
                            {{ $program->ticket->is_free ? '신청하기' : '결제하기' }}
                        </button>
                        <a href="{{ route('lectures.detail', ['program' => $program->id]) }}" class="btn-cancel">취소</a>
                    </section>

                </div>
            </form>
        </div>
    </section>
@endsection

