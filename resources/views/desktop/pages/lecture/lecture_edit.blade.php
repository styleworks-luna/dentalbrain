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
                        <h1>강의 신청 정보 수정</h1>
                        {{--<p><em>수정하기</em></p>--}}
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
                                           value="{{old('email') ?? $programStudent->email}}"
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
                                           value="{{old('phone') ?? $programStudent->phone}}"
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
                                                               @if($choice->choiceAnswer)
                                                               checked
                                                               @endif
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
                                                               @if($choice->choiceAnswer)
                                                               checked
                                                               @endif
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
                                                   value="@isset($survey->answer) {{ $survey->answer->content }} @endisset"
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
                                                       value="@isset($survey->answer) {{ $survey->answer->address }} @endisset"
                                                       data-index="{{ $idx }}"
                                                       readonly="readonly"
                                                       data-parsley-required="{{$survey->is_required ? 'true' : 'false'}}"
                                                       data-parsley-errors-container=".address_answer_error_wrap{{ $survey->id }}"
                                                       data-parsley-required-message="주소를 검색해주세요.">
                                                <input type="text" id="address-detail"
                                                       name="surveys[{{ $idx }}][address_detail]"
                                                       class="address-detail"
                                                       value="@isset($survey->answer) {{ $survey->answer->address_detail }} @endisset"
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

                    <section class="btn-wrap">
                        <button type="submit" class="btn-confirm">
                            수정하기
                        </button>
                        <a href="{{ session()->previousUrl() }}" class="btn-cancel">취소</a>
                    </section>

                </div>
            </form>
            <div class="dim"></div>
            <div class="popup-control">
                @include('desktop.pages.agreement.privacy_to_third')
                @include('desktop.pages.agreement.refund')
            </div>
        </div>
    </section>
@endsection

