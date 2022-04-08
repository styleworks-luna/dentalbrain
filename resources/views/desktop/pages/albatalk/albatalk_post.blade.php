@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/albatalk/albatalk-post.js') }}"></script>
    <script type="text/javascript"
            src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=bx56ktabzx&submodules=geocoder"></script>
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('js/editor.js')  }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-post.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-common.css') }}">
@endsection

@section('content')
    <section class="albatalk-post-wrap">
        @include('desktop.layouts.albatalk')
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <section class="albatalk-post">
                <div class="sub-title-wrap">
                    <h2>구인 등록</h2>
                    <span class="tip">* 필수 입력 항목입니다.</span>
                </div>
                <div class="albatalk-post-content">
                    <form action={{route('albatalk.recruit.create')}} method="post">
                        @csrf
                        <div class="dental-form-wrap">
                            <div class="thumbnail-wrap">
                                <img class="main-thumbnail" src="" alt="치과 사진">
                                <div class="sub-thumbnail-wrap">
                                    <div class="sub-thumbnail-title">
                                        <h3>기타 사진</h3>
                                        <span class="sub-thumbnail-tip">최대 3개까지 등록 가능 (800px × 600px)</span>
                                    </div>
                                    <div class="sub-thumbnail-content">
                                        <img class="sub-thumbnail" src="" alt="치과 사진">
                                        <img class="sub-thumbnail" src="" alt="치과 사진">
                                        <img class="sub-thumbnail" src="" alt="치과 사진">
                                    </div>
                                </div>
                                <p class="thumbnail-tip">※ 2MB 이내의 JPG, JPEG, PNG, GIF </p>
                            </div>
                            <table>
                                <tr>
                                    <th>치과명 *</th>
                                    <td>
                                        <input type="text"

                                               id="dental_name"
                                               class="input-s"
                                               name="dental_name"
                                               value="{{old('dental_name')}}"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 치과명을 입력해주세요">
                                    </td>

                                    <th>담당자명 *</th>
                                    <td>
                                        <input type="text"
                                               id="manager_name"
                                               class="input-s"
                                               name="manager_name"
                                               value="{{old('manager_name')}}"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 담당자명을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>대표자명 *</th>
                                    <td>
                                        <input type="text"
                                               id="ceo_name"
                                               class="input-s"
                                               name="ceo_name"
                                               value="{{old('ceo_name')}}"
                                               placeholder="대표자명 입력(최소 2자 이상)"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 대표자명을 입력해주세요">
                                    </td>

                                    <th>담장자 전화번호 *</th>
                                    <td>
                                        <input type="text"
                                               id="manager_phone"
                                               class="input-s"
                                               name="manager_phone"
                                               value="{{old('manager_phone')}}"
                                               placeholder="‘-‘ 없이 입력"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>사업자등록번호 *</th>
                                    <td>
                                        <input type="text"
                                               id="num"
                                               class="input-s"
                                               name="num"
                                               value="{{old('num')}}"
                                               placeholder="대표자명 입력(최소 2자 이상)"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 사업자등록번호를 입력해주세요.">
                                    </td>

                                    <th>담장자 이메일 *</th>
                                    <td>
                                        <input type="text"
                                               id="manager_email"
                                               class="input-s"
                                               name="manager_email"
                                               value="{{old('manager_email')}}"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 이메일을 입력해주세요.">
                                    </td>
                                </tr>
                                <tr>
                                    <th>전화번호 *</th>
                                    <td colspan="3">
                                        <input type="text"
                                               id="phone"
                                               class="input-s"
                                               name="phone"
                                               value="{{old('dental_name')}}"
                                               placeholder="‘-‘ 없이 입력"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>홈페이지 주소</th>
                                    <td colspan="3">
                                        <input type="text"
                                               id="homepage"
                                               class="input-xl"
                                               name="homepage"
                                               value="{{old('homepage')}}">
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="dental-additional-form-wrap">
                            <table>
                                <tr>
                                    <th>주소입력 *</th>
                                    <td class="wrapper-s">
                                        <div class="address-wrap">
                                            <input type="button" class="btn-address" value="주소검색">
                                            <input type="text" id="address"
                                                   class="address input-l"
                                                   readonly
                                                   data-parsley-required-message="※ 주소를 입력해주세요.">
                                            <input type="text" id="address_detail"
                                                   class="address-detail input-l"
                                                   placeholder="상세주소를 입력"
                                                   data-parsley-required="true"
                                                   data-parsley-required-message="상세주소를 입력하세요">
                                        </div>
                                        <div id="map" class="map"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>인근 지하철역</th>
                                    <td class="wrapper-s">
                                        <input type="text"
                                               id="subway"
                                               class="input-xxl"
                                               name="subway"
                                               value="{{old('subway')}}"
                                               placeholder="인근 지하철역을 입력해주세요.(ex: 7호선 신논현 도보 5분)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>신청분야 *</th>
                                    <td class="wrapper-lg">
                                        <div class="checkbox-container">
                                            @foreach($typeApplication as $application)
                                                <div class="checkbox-wrap">
                                                    <input type="checkbox" id="application_field_[{{$application->id}}]"
                                                           name="application[{{$application->id}}]"
                                                           @if(old('application')[$application->id] ?? 'off' == 'on') checked @endif>
                                                    <label for="application_field_[{{$application->id}}]">{{$application->type}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>근무형태 *</th>
                                    <td class="wrapper-lg">
                                        <div class="radio-container">
                                            @foreach($typeWork as $work)
                                                <div class="radio-wrap">
                                                    <input type="radio" id="work_type_field_[{{$work->id}}]"
                                                           name="work"
                                                           value={{$work->id}}
                                                           @if(old('work') == $work->id)
                                                                   checked
                                                            @endif>
                                                    <label for="work_type_field_[{{$work->id}}]">{{$work->type}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>직종 *</th>
                                    <td class="wrapper-lg">
                                        <div class="radio-container">
                                            @foreach($typeJob as $job)
                                                <div class="radio-wrap">
                                                    <input type="radio" id="job_type_filed_[{{$job->id}}]" name="job"
                                                           value={{$job->id}} @if(old('job') == $job->id) checked @endif>
                                                    <label id="job_type_filed_[{{$job->id}}]">{{$job->type}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>급여 *</th>
                                    <td class="wrapper-s">
                                        <div class="radio-container">
                                            @foreach($typeSalary as $salary)
                                                <div class="radio-wrap">
                                                    <input type="radio" id="salary_type_field_[{{$salary->id}}]"
                                                           name="salary"
                                                           value={{$salary->id}}
                                                           @if(old('salary') == $salary->id)
                                                                   checked
                                                            @endif>
                                                    <label for="salary_type_field_[{{$salary->id}}]">{{$salary->type}}</label>
                                                    @if($salary->id == 4)
                                                        <input type="text" name="salary_value"
                                                               value="{{old("salary_value")}}"
                                                               placeholder="내용을 입력해주세요.">
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>학력 *</th>
                                    <td class="wrapper-s">
                                        <div class="radio-container">
                                            <div class="radio-wrap">
                                                <input type="radio" id="study_type_field_01" name="study">
                                                <select class="input-xs select-menu">
                                                    <option value="">학력 선택</option>
                                                </select>
                                            </div>
                                            <div class="radio-wrap">
                                                <input type="radio" id="study_type_field_02" name="study">
                                                <label for="study_type_field_02">기타</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>경력 *</th>
                                    <td class="wrapper-s">
                                        <div class="radio-container">
                                            <div class="radio-wrap">
                                                <input type="radio" id="career_field_01" name="career">
                                                <label for="career_field_01">신입</label>
                                            </div>
                                            <div class="radio-wrap">
                                                <input type="radio" id="career_field_02" name="career">
                                                <label for="career_field_02" class="career-radio-label">경력</label>
                                                <select name="" id="" class="input-xs radio-input select-menu">
                                                    <option value="">경력기간 선택</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>근무요일 *</th>
                                    <td class="wrapper-s">
                                        <div class="radio-container">
                                            @foreach($typeDay as $day)
                                                <div class="radio-wrap">
                                                    <input type="radio" id="day_type_field_[{{$day->id}}]" name="day"
                                                           value={{$day->id}} @if(old('day') == $day->id) checked @endif>
                                                    <label for="day_type_field_[{{$day->id}}]">{{$day->type}}</label>
                                                    @if($day->id == 4)
                                                        <input type="text" name="day_value" value="{{old("day_value")}}"
                                                               placeholder="내용을 입력해주세요.">
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>복리후생 *</th>
                                    <td class="wrapper-lg">
                                        <div class="checkbox-grid-container">
                                            @foreach($typeBenefit as $benefit)
                                                <div class="checkbox-wrap">
                                                    <input type="checkbox" id="benefit_type_field_[{{$benefit->id}}]"
                                                           name="benefit[{{$benefit->id}}]"
                                                           @if(old('benefit')[$benefit->id] ?? 'off' == 'on') checked @endif>
                                                    <label for="benefit_type_field_[{{$benefit->id}}]">{{$benefit->type}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>모집마감일 *</th>
                                    <td class="wrapper-s">
                                        <div class="radio-container">
                                            <div class="radio-wrap">
                                                <input type="radio" id="deadline_field_01" name="deadline">

                                                <input type="text" class="input-xs start-date" name="started_at"
                                                       placeholder="시작일자 선택" readonly>
                                                <input type="text" class="input-xxs start-time" placeholder="HH:mm">
                                                <p class="time-from">부터</p>
                                                <input type="text" class="input-xs end-date" name="ended_at"
                                                       placeholder="마감일자 선택" readonly>
                                                <input type="text" class="input-xxs end-tme" placeholder="HH:mm">
                                            </div>
                                            <div class="radio-wrap">
                                                <input type="radio" id="deadline_field_02" name="deadline">
                                                <label for="deadline_field_02">채용시까지</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>상세정보</th>
                                    <td class="wrapper-s">
                                        <ul class="editor-extra-toolbar">
                                            <li>
                                                <label for="image" class="ir_pm">사진</label>
                                                <input type="file" id="image" class="btn-editor-image" accept="image/*">
                                            </li>
                                            <li>
                                                <label for="file" class="ir_pm">파일</label>
                                                <input type="file" id="file" class="btn-editor-file">
                                            </li>
                                        </ul>
                                        <textarea id="editor" class="editor"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>결제금액</th>
                                    <td class="wrapper-lg">
                                        <p class="money">100,000원</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>결제방식 *</th>
                                    <td class="wrapper-s">
                                        <div class="radio-container">
                                            <div class="radio-wrap">
                                                <input type="radio" id="pay_method_filed_01" name="pay_method">
                                                <label for="pay_method_filed_01" class="card-radio-label">신용카드</label>
                                                <select name="" id="" class="input-xs select-menu">
                                                    <option value="">신한</option>
                                                </select>
                                            </div>
                                            <div class="radio-wrap">
                                                <input class="last" type="radio" id="pay_method_filed_01"
                                                       name="pay_method">
                                                <label id="pay_method_filed_01">실시간 계좌이체</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="btn-wrap">
                            <button class="btn-submit" type="submit">구인공고 등록</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </section>
@endsection
