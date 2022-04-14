@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
    <script type="text/javascript"
            src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId={{ env('NAVER_CLOUD_ID') }}&submodules=geocoder"></script>
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('js/editor.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/albatalk/albatalk-post.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-post.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-common.css') }}">
@endsection

@section('content')
    <section class="albatalk-post-wrap">
        @include('desktop.layouts.navigation.albatalk')
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
                    <form action="{{ route('albatalk.recruit.edit') }}" method="post">
                        @csrf
                        <div class="dental-form-wrap">
                            <div class="thumbnail-wrap">
                                <div class="img-wrap main-thumbnail-wrap">
                                    <input type="hidden" name="main_file_id" class="file-id">
                                    <input type="hidden" class="thumbnail-check" value="N"
                                           data-parsley-required="true"
                                           data-parsley-pattern="[Y]"
                                           data-parsley-required-message="※ 치과 대표 사진을 업로드 해주세요."
                                           data-parsley-pattern-message="※ 치과 대표 사진을 업로드 해주세요."
                                           data-parsley-errors-container=".thumbnail-error-container">
                                    <!-- 썸네일 존재하지 않을경우 -->
                                    <div class="image-off">
                                        <div class="main-thumbnail none-image">
                                            <h4 class="none-image-title">치과 대표 사진 *</h4>
                                            <p class="none-image-tip">(800px × 600px)</p>
                                            <span class="none-image-icon"></span>
                                        </div>
                                        <div class="image-hover-common image-hover-lg">
                                            <input type="file" id="main_thumbnail_input" class="thumbnail-input">
                                            <label for="main_thumbnail_input"
                                                   class="image-icon-common image-icon-lg btn-plus"></label>
                                        </div>
                                    </div>
                                    <!-- 썸네일 존재 할 경우 (등록 이미지) -->
                                    <div class="image-on">
                                        <img class="main-thumbnail thumbnail-image" src="" alt="치과 사진">
                                        <div class="image-hover-common image-hover-lg">
                                            <span class="image-icon-common image-icon-lg btn-delete-thumbnail"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="thumbnail-error-container parsley-error-container"></div>
                                <div class="sub-thumbnail-wrap">
                                    <div class="sub-thumbnail-title">
                                        <h3>기타 사진</h3>
                                        <span class="sub-thumbnail-tip">최대 3개까지 등록 가능 (800px × 600px)</span>
                                    </div>
                                    <div class="sub-thumbnail-content">
                                        <div class="img-wrap">
                                            <input type="hidden" name="file_1_id" class="file-id">
                                            <div class="image-off">
                                                <!-- 썸네일 존재하지 않을경우-->
                                                <div class="sub-thumbnail none-image">
                                                    <span class="none-image-icon"></span>
                                                </div>
                                                <div class="image-hover-common image-hover-sm">
                                                    <input type="file" id="sub_thumbnail_input_01"
                                                           class="thumbnail-input">
                                                    <label for="sub_thumbnail_input_01"
                                                           class="image-icon-common image-icon-sm btn-plus"></label>
                                                </div>
                                            </div>
                                            <!-- 썸네일 존재 할 경우 (등록 이미지)-->
                                            <div class="image-on">
                                                <img class="sub-thumbnail thumbnail-image" src="" alt="치과 사진">
                                                <div class="image-hover-common image-hover-sm">
                                                    <span
                                                            class="image-icon-common image-icon-sm btn-delete-thumbnail"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="img-wrap">
                                            <input type="hidden" name="file_2_id" class="file-id">
                                            <!-- 썸네일 존재하지 않을경우-->
                                            <div class="image-off">
                                                <div class="sub-thumbnail none-image">
                                                    <span class="none-image-icon"></span>
                                                </div>
                                                <div class="image-hover-common image-hover-sm">
                                                    <input type="file" id="sub_thumbnail_input_02"
                                                           class="thumbnail-input">
                                                    <label for="sub_thumbnail_input_02"
                                                           class="image-icon-common image-icon-sm btn-plus"></label>
                                                </div>
                                            </div>
                                            <!-- 썸네일 존재 할 경우 (등록 이미지)-->
                                            <div class="image-on">
                                                <img class="sub-thumbnail thumbnail-image" src="" alt="치과 사진">
                                                <div class="image-hover-common image-hover-sm">
                                                    <span
                                                            class="image-icon-common image-icon-sm btn-delete-thumbnail"></span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="img-wrap">
                                            <input type="hidden" name="file_3_id" class="file-id">
                                            <!-- 썸네일 존재하지 않을경우-->
                                            <div class="image-off">
                                                <div class="sub-thumbnail none-image">
                                                    <span class="none-image-icon"></span>
                                                </div>
                                                <div class="image-hover-common image-hover-sm">
                                                    <input type="file" id="sub_thumbnail_input_03"
                                                           class="thumbnail-input">
                                                    <label for="sub_thumbnail_input_03"
                                                           class="image-icon-common image-icon-sm btn-plus"></label>
                                                </div>
                                            </div>
                                            <!-- 썸네일 존재 할 경우 (등록 이미지)-->
                                            <div class="image-on">
                                                <img class="sub-thumbnail thumbnail-image" src="" alt="치과 사진">
                                                <div class="image-hover-common image-hover-sm">
                                                    <span
                                                            class="image-icon-common image-icon-sm btn-delete-thumbnail"></span>
                                                </div>
                                            </div>
                                        </div>
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
                                               value="{{old('dental_name', $recruit->company_name)}}"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 치과명을 입력해주세요">
                                    </td>

                                    <th>담당자명 *</th>
                                    <td>
                                        <input type="text"
                                               id="manager_name"
                                               class="input-s"
                                               name="manager_name"
                                               value="{{old('manager_name', $recruit->name)}}"
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
                                               value="{{old('ceo_name', $recruit->company_leader)}}"
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
                                               value="{{old('manager_phone', $recruit->phone)}}"
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
                                               value="{{old('num', $recruit->company_license)}}"
                                               placeholder="대표자명 입력(최소 2자 이상)"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 사업자등록번호를 입력해주세요.">
                                    </td>

                                    <th>담장자 이메일 *</th>
                                    <td>
                                        <input type="email"
                                               id="manager_email"
                                               class="input-s"
                                               name="manager_email"
                                               value="{{old('manager_email', $recruit->email)}}"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 이메일을 입력해주세요."
                                               data-parsley-type-message="※ 이메일 형식에 맞게 입력하세요.">
                                    </td>
                                </tr>
                                <tr>
                                    <th>전화번호 *</th>
                                    <td colspan="3">
                                        <input type="text"
                                               id="phone"
                                               class="input-s"
                                               name="phone"
                                               value="{{old('phone', $recruit->company_phone)}}"
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
                                               value="{{old('homepage', $recruit->url)}}">
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
                                                   name="address"
                                                   value="{{old('address', $recruit->address)}}"
                                                   readonly
                                                   data-parsley-required="true"
                                                   data-parsley-required-message="※ 주소를 입력해주세요."
                                                   data-parsley-errors-container=".address-error-container">
                                            <input type="text" id="address_detail"
                                                   class="address-detail input-l"
                                                   name="address_detail"
                                                   value="{{old('address_detail', $recruit->address_detail)}}"
                                                   placeholder="상세주소를 입력">
                                            <input type="hidden" class="address-hidden-sido" name="sido">
                                            <input type="hidden" class="address-hidden-gugun" name="gugun">
                                            <input type="hidden" class="address-hidden-dong" name="dong">
                                            <input type="hidden" class="address-hidden-latitude" name="latitude">
                                            <input type="hidden" class="address-hidden-longitude" name="longitude">
                                        </div>
                                        <div id="map" class="map"></div>
                                        <div class="address-error-container"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>인근 지하철역</th>
                                    <td class="wrapper-s">
                                        <input type="text"
                                               id="subway"
                                               class="input-xxl"
                                               name="subway"
                                               value="{{old('subway', $recruit->subway)}}"
                                               placeholder="인근 지하철역을 입력해주세요.(ex: 7호선 신논현 도보 5분)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>신청분야 *</th>
                                    <td class="wrapper-lg">
                                        <div class="checkbox-container">
                                            @foreach($typeApplication as $application)
                                                <div class="checkbox-wrap">
                                                    <input type="hidden" name="application[{{$application->id}}]"
                                                           value="off">
                                                    <input type="checkbox" id="application_field_[{{$application->id}}]"
                                                           name="application[{{$application->id}}]"
                                                           name="{{'application['.$application->id.']'}}"
                                                           @if(old('application.'.$application->id, $recruitApplications->contains($application->id) ? 'on' :'off') == 'on')
                                                           checked
                                                           @endif
                                                           data-parsley-required="true"
                                                           data-parsley-multiple="mymultiplelink"
                                                           data-parsley-mincheck="1"
                                                           data-parsley-required-message="※ 신청분야를 선택해주세요."
                                                           data-parsley-errors-container=".application-error-container">
                                                    <label
                                                            for="application_field_[{{$application->id}}]">{{$application->type}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="application-error-container"></div>
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
                                                           @if(old('work', $recruit->typeWork->id) == $work->id)
                                                                   checked
                                                           @endif
                                                           data-parsley-required="true"
                                                           data-parsley-required-message="※ 근무형태를 선택해주세요."
                                                           data-parsley-errors-container=".work-type-error-container">
                                                    <label for="work_type_field_[{{$work->id}}]">{{$work->type}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="work-type-error-container"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>직종 *</th>
                                    <td class="wrapper-lg">
                                        <div class="radio-container">
                                            @foreach($typeJob as $job)
                                                <div class="radio-wrap">
                                                    <input type="radio" id="job_type_field_[{{$job->id}}]" name="job"
                                                           value={{$job->id}} @if(old('job', $recruit->typeJob->id) == $job->id) checked
                                                           @endif
                                                           data-parsley-required="true"
                                                           data-parsley-required-message="※ 직종을 선택해주세요."
                                                           data-parsley-errors-container=".job-type-error-container">
                                                    <label for="job_type_field_[{{$job->id}}]">{{$job->type}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="job-type-error-container"></div>
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
                                                           class="salary"
                                                           value={{$salary->id}}
                                                           @if(old('salary', $recruitSalaries[0]->type_salary_id) == $salary->id)
                                                                   checked
                                                           @endif
                                                           data-parsley-required="true"
                                                           data-parsley-required-message="※ 급여를 선택해주세요."
                                                           data-parsley-errors-container=".salary-type-error-container">
                                                    <label
                                                            for="salary_type_field_[{{$salary->id}}]">{{$salary->type}}</label>
                                                    @if($salary->id == 4 )
                                                        <input type="text" name="salary_value"
                                                               class="radio-input input-m salary-input"
                                                               value="{{old('salary_value', $recruitSalaries[0]->value)}}"
                                                               placeholder="내용을 입력해주세요."
                                                               @if(old('salary', $recruitSalaries[0]->type_salary_id) != 4) disabled @endif>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="salary-type-error-container"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>학력 *</th>
                                    <td class="wrapper-s">
                                        <div class="radio-container">
                                            <div class="radio-wrap">
                                                <input type="radio" id="study_type_field_01" class="study"
                                                       name="is_study" value="1"
                                                       @if(old('is_study', $recruit->typeStudy->id < 14) == 1) checked @endif
                                                       data-parsley-required="true"
                                                       data-parsley-required-message="※ 학력을 선택해주세요."
                                                       data-parsley-errors-container=".study-type-error-container">
                                                <select class="input-xs select-menu study-select"
                                                        @if(old('is_study', $recruit->typeStudy->id < 14) != 1) disabled @endif
                                                        name="study">
                                                    <option value="" selected>학력 선택</option>
                                                    @foreach($typeStudy as $study)
                                                        @if($study->id == 14)
                                                            @break
                                                        @else
                                                            <option value="{{ $study->id }}"
                                                                    @if(old('study', $recruit->typeStudy->id) == $study->id) selected @endif>{{$study->type}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="radio-wrap">
                                                <input type="radio" id="study_type_field_02" class="study"
                                                       name="is_study" value="2"
                                                       @if(old('is_study', $recruit->typeStudy->id == 14) == 2) checked @endif>
                                                <label for="study_type_field_02">학력무관</label>
                                            </div>
                                        </div>
                                        <div class="study-type-error-container"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>경력 *</th>
                                    <td class="wrapper-s">
                                        <div class="radio-container">
                                            <div class="radio-wrap">
                                                <input type="radio" id="career_field_01" class="career" name="is_career"
                                                       value="1"
                                                       @if(old('is_career', $recruit->career == 0) == 1) checked @endif
                                                       data-parsley-required="true"
                                                       data-parsley-required-message="※ 경력을 선택해주세요."
                                                       data-parsley-errors-container=".career-error-container">
                                                <label for="career_field_01">신입</label>
                                            </div>
                                            <div class="radio-wrap">
                                                <input type="radio" id="career_field_02" class="career" name="is_career"
                                                       value="2" @if(old('is_career', $recruit->career > 0) == 2) checked @endif>
                                                <label for="career_field_02" class="career-radio-label">경력</label>
                                                <select name="career" id="career"
                                                        class="input-xs radio-input select-menu career-select"
                                                        @if(old('is_career', $recruit->career > 0) != 2) disabled @endif>
                                                    <option value="">경력기간 선택</option>
                                                    @for ($i = 1; $i <= 30; $i++)
                                                        @if($i == 30)
                                                            <option value="{{$i}}"
                                                                    @if(old('career', $recruit->career) == $i) selected @endif>{{$i}}
                                                                년 이상
                                                            </option>
                                                        @else
                                                            <option value="{{$i}}"
                                                                    @if(old('career', $recruit->career) == $i) selected @endif>{{$i}}년
                                                            </option>
                                                        @endif
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="career-error-container"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>근무요일 *</th>
                                    <td class="wrapper-s">
                                        <div class="radio-container">
                                            @foreach($typeDay as $day)
                                                <div class="radio-wrap">
                                                    <input type="radio"
                                                           id="day_type_field_[{{$day->id}}]"
                                                           name="day"
                                                           class="work-day"
                                                           value={{$day->id}} @if(old('day', $recruitDays[0]->type_day_id) == $day->id) checked
                                                           @endif
                                                           data-parsley-required="true"
                                                           data-parsley-required-message="※ 근무요일을 선택해주세요."
                                                           data-parsley-errors-container=".day-type-error-container">
                                                    <label for="day_type_field_[{{$day->id}}]">{{$day->type}}</label>
                                                    @if($day->id == 4)
                                                        <input type="text" name="day_value"
                                                               class="radio-input input-m work-day-input"
                                                               value="{{old("day_value", $recruitDays[0]->value)}}"
                                                               placeholder="내용을 입력해주세요."
                                                               @if(old('day', $recruitDays[0]->type_day_id) != 4) disabled @endif>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="day-type-error-container"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>복리후생 *</th>
                                    <td class="wrapper-lg" style="height: 75px">
                                        <div class="checkbox-grid-container">
                                            @foreach($typeBenefit as $benefit)
                                                <div class="checkbox-wrap">
                                                    <input type="hidden" name="benefit[{{$benefit->id}}]" value="off">
                                                    <input type="checkbox" id="benefit_type_field_[{{$benefit->id}}]"
                                                           name="benefit[{{$benefit->id}}]"
                                                           @if(old('benefit.'.$benefit->id, $recruitBenefits->contains($benefit->id) ? 'on' :'off') == 'on')
                                                           checked
                                                           @endif
                                                           data-parsley-required="true"
                                                           data-parsley-multiple="mymultiplelink1"
                                                           data-parsley-mincheck="1"
                                                           data-parsley-required-message="※ 복리후생을 선택해주세요."
                                                           data-parsley-errors-container=".benefit-type-error-container">
                                                    <label
                                                            for="benefit_type_field_[{{$benefit->id}}]">{{$benefit->type}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="benefit-type-error-container"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>모집마감일 *</th>
                                    <td class="wrapper-s">
                                        <div class="radio-container">
                                            <div class="radio-wrap">
                                                <input type="radio" id="deadline_field_01" class="deadline"
                                                       name="deadline" value="1"
                                                       @if(old('deadline', $recruit->started_at != null ) == 1) checked @endif
                                                       data-parsley-required="true"
                                                       data-parsley-required-message="※ 모집마감일을 선택해주세요."
                                                       data-parsley-errors-container=".deadline-error-container">
                                                <input type="text" class="input-xs start-date" name="started_at_ymd"
                                                       value="{{old("started_at_ymd", $recruit->started_at->format('Y-m-d'))}}"
                                                       placeholder="시작일자 선택"
                                                       @if(old('deadline') != 1) readonly disabled @endif>
                                                <input type="text" class="input-xxs start-time" placeholder="HH:mm"
                                                       name="started_at_hm"
                                                       value="{{old("started_at_hm", $recruit->started_at->format('H:i'))}}"
                                                       @if(old('deadline') != 1) disabled @endif>
                                                <p class="time-from">부터</p>
                                                <input type="text" class="input-xs end-date" name="ended_at_ymd"
                                                       value="{{old("ended_at_ymd", $recruit->ended_at->format('Y-m-d'))}}"
                                                       placeholder="마감일자 선택"
                                                       @if(old('deadline') != 1) readonly disabled @endif>
                                                <input type="text" class="input-xxs end-tme" placeholder="HH:mm"
                                                       name="ended_at_hm"
                                                       value="{{old("ended_at_hm", $recruit->ended_at->format('H:i'))}}"
                                                       @if(old('deadline') != 1) disabled @endif>
                                            </div>
                                            <div class="radio-wrap">
                                                <input type="radio" id="deadline_field_02" class="deadline"
                                                       name="deadline" value="2"
                                                       @if(old('deadline', $recruit->started_at == null) == 2) checked @endif>
                                                <label for="deadline_field_02">채용시까지</label>
                                            </div>
                                        </div>
                                        <div class="deadline-error-container"></div>
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
                                        <textarea id="editor" class="editor"
                                                  name="content">{{old('content', $recruit->content)}}</textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="btn-wrap">
                            <button class="btn-submit" type="submit">구인공고 수정</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </section>
@endsection
