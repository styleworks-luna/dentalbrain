@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ko.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/albatalk/albatalk-resume.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-resume.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-common.css') }}">
@endsection

@section('content')
    <section class="albatalk-resume-wrap">
        @include('desktop.layouts.navigation.albatalk')
        <div class="container">
            <section class="resume">
                <div class="sub-title-wrap">
                    <h2>이력서 작성</h2>
                    <span class="tip">* 필수 입력 항목입니다.</span>
                </div>
                <form id="albatalk_resume_form" action="{{ route('albatalk.resume.update') }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="desire-form-wrap common-form-wrap">
                        <table>
                            <tr>
                                <th>희망 근무 지역</th>
                                <td>
                                    <input type="text"
                                           id="work_area"
                                           name="work_area"
                                           value="{{ old("work_area", $resume->work_area) }}"/>
                                </td>
                            </tr>
                            <tr>
                                <th>희망 근무 요일</th>
                                <td>
                                    <input type="text"
                                           id="work_day"
                                           name="work_day"
                                           value="{{ old("work_day", $resume->work_day) }}"/>
                                </td>
                            </tr>
                            <tr>
                                <th>희망 근무 시간</th>
                                <td>
                                    <input type="text"
                                           id="work_time"
                                           name="work_time"
                                           value="{{ old("work_time", $resume->work_time) }}"/>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="user-form-wrap common-form-wrap">
                        <div class="image-wrap">
                            <input type="hidden" class="image-file-id" name="file_id"
                                   value="{{ $resume->file->id ?? '' }}">
                            <input type="hidden" class="file-check" value="N"
                                   data-parsley-required="true"
                                   data-parsley-pattern="[Y]"
                                   data-parsley-required-message="※ 이력서 대표 사진을 업로드 해주세요."
                                   data-parsley-pattern-message="※ 이력서 대표 사진을 업로드 해주세요."
                                   data-parsley-errors-container=".thumbnail-error-container">
                            <!-- 썸네일 존재하지 않을경우-->
                            <div class="image-off">
                                <div class="resume-profile none-image">
                                    <h4 class="none-image-title">이력서 대표 사진 *</h4>
                                    <p class="none-image-tip">(800px × 600px)</p>
                                    <span class="none-image-icon"></span>
                                </div>
                                <div class="image-hover">
                                    <input type="file"
                                           id="resume_image"
                                           class="resume-profile"
                                           name="resume_image"
                                           accept="image/jpeg, image/png, image/gif">
                                    <label for="resume_image" class="image-icon-common btn-plus"></label>
                                </div>
                                <div class="image-tip">※ 2MB 이내의 JPG, JPEG, PNG, GIF</div>
                            </div>
                            <div class="image-on">
                                <!-- 썸네일 존재 할 경우 (등록 이미지)-->
                                <img class="resume-profile"
                                     id="profile-preview"
                                     src="{{ $resume->file->url ?? '' }}" alt="이력서 사진"/>
                                <div class="image-hover">
                                    <span class="image-icon-common btn-delete-thumbnail"></span>
                                </div>
                            </div>
                            <div class="thumbnail-error-container parsley-error-container"></div>
                        </div>
                        <table>
                            <tr>
                                <th>이름 *</th>
                                <td>
                                    <input type="text"
                                           id="name"
                                           class="name"
                                           name="name"
                                           value="{{ old("name", $resume->name) }}"
                                           placeholder="이름 입력 (최소 2자 이상)"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 이름을 입력해주세요"/>
                                </td>
                                <th>영문 이름 *</th>
                                <td>
                                    <input type="text"
                                           id="english_name"
                                           class="english-name"
                                           name="english_name"
                                           value="{{ old("english_name", $resume->english_name) }}"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 영문 이름을 입력해주세요."/>
                                </td>
                            </tr>
                            <tr>
                                <th>생년 월일 *</th>
                                <td>
                                    <input type="text"
                                           id="birthday"
                                           class="birthday"
                                           name="birthday"
                                           value="{{ old("birthday", $resume->birthday) }}"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 생년 월일을 입력해주세요."/>
                                </td>

                                <th>휴대폰 번호 *</th>
                                <td>
                                    <input type="text"
                                           id="phone"
                                           class="phone"
                                           name="phone"
                                           value="{{ old("phone", $resume->phone) }}"
                                           placeholder="‘-‘ 없이 입력"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                           data-parsley-required="true"
                                           data-parsley-length="[9,11]"
                                           data-parsley-length-message="※ 9자 ~ 11자로 입력해주세요."
                                           data-parsley-required-message="※ 휴대폰 번호를 입력해주세요."/>
                                </td>
                            </tr>
                            <tr>
                                <th>비상연락처 *</th>
                                <td>
                                    <input type="text"
                                           id="emergency_phone"
                                           class="emergency-phone"
                                           name="emergency_phone"
                                           value="{{ old("emergency_phone", $resume->emergency_phone) }}"
                                           placeholder="‘-‘ 없이 입력"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 비상연락처를 입력해주세요."/>
                                </td>

                                <th>이메일 *</th>
                                <td>
                                    <input type="email"
                                           id="email"
                                           class="email"
                                           name="email"
                                           value="{{ old("email", $resume->email) }}"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 이메일을 입력해주세요."
                                           data-parsley-type-message="※ 이메일 형식에 맞게 입력하세요."/>
                                </td>
                            </tr>
                            <tr>
                                <th>주소 *</th>
                                <td colspan="3">
                                    <input type="text"
                                           id="address"
                                           class="address"
                                           name="address"
                                           value="{{ old("address", $resume->address) }}"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 주소를 입력해주세요"/>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="double-form-wrap">
                        <div class="education-form-wrap common-form-wrap">
                            <h3>학력사항</h3>
                            <table>
                                <tr>
                                    <th>학위취득년월</th>
                                    <td>
                                        <input type="text" name="graduated_at"
                                               value="{{ old("graduated_at", $resume->graduated_at) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>출신학교</th>
                                    <td>
                                        <input type="text" name="school" value="{{ old("school", $resume->school) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>학과(세부전공)</th>
                                    <td>
                                        <input type="text"
                                               id="major"
                                               name="major" value="{{ old("major", $resume->major) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>학위</th>
                                    <td>
                                        <input type="text"
                                               id="degree"
                                               name="degree"
                                               value="{{ old("degree", $resume->degree) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>졸업구분</th>
                                    <td>
                                        <input type="text"
                                               id="graduated"
                                               name="graduation_type"
                                               value="{{ old("graduation_type", $resume->graduation_type) }}">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="desire-ranking-form-wrap common-form-wrap">
                            <h3>희망 순위</h3>
                            <table>
                                <thead>
                                <tr>
                                    <th>구분</th>
                                    <th>1순위</th>
                                    <th>2순위</th>
                                    <th>3순위</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th>희망 진료과</th>
                                    <td colspan="3">
                                        <div class="input-wrap">
                                            <input type="text"
                                                   id="first_treatment"
                                                   name="treatment_1"
                                                   placeholder="ex. 교정"
                                                   value="{{ old('treatment_1', $resume->treatment_1) }}">
                                            <input type="text"
                                                   id="second_treatment"
                                                   name="treatment_2"
                                                   value="{{ old('treatment_2', $resume->treatment_2) }}">
                                            <input type="text"
                                                   id="third_treatment"
                                                   name="treatment_3"
                                                   value="{{ old('treatment_3', $resume->treatment_3) }}">
                                        </div>
                                </tr>
                                <tr>
                                    <th>희망 부서</th>
                                    <td colspan="3">
                                        <div class="input-wrap">
                                            <input type="text"
                                                   id="first_department"
                                                   name="department_1"
                                                   value="{{ old('department_1', $resume->department_1) }}"
                                                   placeholder="ex. 진료실">
                                            <input type="text"
                                                   id="second_department"
                                                   name="department_2"
                                                   value="{{ old('department_2', $resume->department_2) }}">
                                            <input type="text"
                                                   id="third_department"
                                                   name="department_3"
                                                   value="{{ old('department_3', $resume->department_3) }}">
                                        </div>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="certification-form-wrap common-form-wrap">
                        <h3>면허/자격증 보유 현황</h3>
                        <table>
                            <thead>
                            <tr>
                                <th>구분</th>
                                <th>자격증명</th>
                                <th>취득년월</th>
                                <th>인가, 관리기관</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>1</th>
                                <td>
                                    <input type="text"
                                           id="first_certificate_name"
                                           name="certificate_name_1"
                                           value="{{ old('certificate_name_1', $resume->certificate_name_1) }}">
                                </td>
                                <td>
                                    <input type="text"
                                           id="first_certificate_day"
                                           name="certificate_day_1"
                                           value="{{ old('certificate_day_1', $resume->certificate_day_1) }}">
                                </td>
                                <td>
                                    <input type="text"
                                           id="first_certificate_agency"
                                           name="certificate_agency_1"
                                           value="{{ old('certificate_agency_1', $resume->certificate_agency_1) }}">
                                </td>
                            </tr>
                            <tr>
                                <th>2</th>
                                <td>
                                    <input type="text"
                                           id="second_certificate_name"
                                           name="certificate_name_2"
                                           value="{{ old('certificate_name_2', $resume->certificate_name_2) }}">
                                </td>
                                <td>
                                    <input type="text"
                                           id="second_certificate_day"
                                           name="certificate_day_2"
                                           value="{{ old('certificate_agency_2', $resume->certificate_day_2) }}">
                                </td>
                                <td>
                                    <input type="text"
                                           id="second_certificate_agency"
                                           name="certificate_agency_2"
                                           value="{{ old('certificate_agency_2', $resume->certificate_agency_2) }}">

                                </td>
                            </tr>
                            <tr>
                                <th>3</th>
                                <td>
                                    <input type="text"
                                           id="third_certificate_name"
                                           name="certificate_name_3"
                                           value="{{ old('certificate_name_3', $resume->certificate_name_3) }}">
                                </td>
                                <td>
                                    <input type="text"
                                           id="third_certificate_day"
                                           name="certificate_day_3"
                                           value="{{ old('certificate_day_3', $resume->certificate_day_3) }}">
                                </td>
                                <td>
                                    <input type="text"
                                           id="third_certificate_agency"
                                           name="certificate_agency_3"
                                           value="{{ old('certificate_agency_3', $resume->certificate_agency_3) }}">
                                </td>
                            </tr>
                            <tr>
                                <th>4</th>
                                <td>
                                    <input type="text"
                                           id="fourth_certificate_name"
                                           name="certificate_name_4"
                                           value="{{ old('certificate_name_4', $resume->certificate_name_4) }}">
                                </td>
                                <td>
                                    <input type="text"
                                           id="fourth_certificate_day"
                                           name="certificate_day_4"
                                           value="{{ old('certificate_day_4', $resume->certificate_day_4) }}">
                                </td>
                                <td>
                                    <input type="text"
                                           id="fourth_certificate_agency"
                                           name="certificate_agency_4"
                                           value="{{ old('certificate_agency_4', $resume->certificate_agency_4) }}">
                                </td>
                            </tr>
                            <tr>
                                <th>5</th>
                                <td>
                                    <input type="text"
                                           id="fifth_certificate_name"
                                           name="certificate_name_5"
                                           value="{{ old('certificate_name_5', $resume->certificate_name_5) }}">
                                </td>
                                <td>
                                    <input type="text"
                                           id="fifth_certificate_day"
                                           name="certificate_day_5"
                                           value="{{ old('certificate_day_5', $resume->certificate_day_5) }}">
                                </td>
                                <td>
                                    <input type="text"
                                           id="fifth_certificate_agency"
                                           name="certificate_agency_5"
                                           value="{{ old('certificate_agency_5', $resume->certificate_agency_5) }}">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="information-form-wrap common-form-wrap">
                        <h3>자기소개</h3>
                        <textarea id="information"
                                  name="about_me"
                                  placeholder="자기소개를 1,000자 이내로 입력해 주세요.">{{ old('about_me',$resume->about_me) }}</textarea>
                    </div>

                    <div class="evaluation-form-wrap common-form-wrap">
                        <div class="evaluation-title-wrap">
                            <h3>
                                치과 업무 능력 자기 평가표
                            </h3>
                            <span>생각하는 업무 능력을 평가해주세요. 본 정보는 인재 능력을 평가 지표로 사용되며 추후 교육자료로 활용됩니다.</span>
                        </div>
                        <div class="evaluation-content-wrap">
                            <div class="left-content-wrap">
                                <table>
                                    <thead>
                                    <tr>
                                        <th colspan="2">구분</th>
                                        <th>자가평가 점수</th>
                                        <th>교육가능 유무</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($leftList as $abilityAnswer)
                                        @php
                                            /** @var mixed $abilityAnswer */
                                        $ability = $abilityAnswer->ability;
                                        @endphp
                                        <tr>
                                            @if( $loop->index == $leftCategoryHeaders[$ability->category_id]['loopIndex'] )
                                                <th rowspan="{{ $leftCategoryHeaders[$ability->category_id]['rowspan']  }}">{{ $leftCategoryHeaders[$ability->category_id]['name'] }}</th>
                                            @endif
                                            @if($ability->type == 'select')
                                                    <td class="ability-cell">
                                                        {{ $ability->name }}
                                                        <input type="hidden" class="ability-check" value="Y"
                                                               data-parsley-pattern="Y"
                                                               data-parsley-pattern-message="※ 능력표를 선택해주세요.">
                                                    </td>

                                                <td class="select-cell">
                                                    <input type="hidden"
                                                           name="{{ 'abilities['.$ability->id.'][ability_id]' }}"
                                                           value="{{ $ability->id }}">
                                                    <select class="select-menu"
                                                            name="{{ 'abilities['.$ability->id.'][score]' }}">
                                                        <option
                                                            value="0">
                                                            선택
                                                        </option>
                                                        <option value="1"
                                                                @if( old('abilities.'.$ability->id.'.score', $abilityAnswer->score) == 1 ) selected @endif>
                                                            경험없음
                                                        </option>
                                                        <option value="2"
                                                                @if( old('abilities.'.$ability->id.'.score', $abilityAnswer->score) == 2) selected @endif>
                                                            미흡
                                                        </option>
                                                        <option value="3"
                                                                @if( old('abilities.'.$ability->id.'.score', $abilityAnswer->score) == 3) selected @endif>
                                                            보통
                                                        </option>
                                                        <option value="4"
                                                                @if( old('abilities.'.$ability->id.'.score', $abilityAnswer->score) == 4) selected @endif>
                                                            잘함
                                                        </option>
                                                        <option value="5"
                                                                @if( old('abilities.'.$ability->id.'.score', $abilityAnswer->score) == 5) selected @endif>
                                                            매우잘함
                                                        </option>
                                                    </select>
                                                </td>
                                                <td class="checkbox-cell">
                                                    <input type="hidden"
                                                           name="{{ 'abilities['.$ability->id.'][can_learn]' }}"
                                                           value="0">
                                                    <input type="checkbox"
                                                           name="{{ 'abilities['.$ability->id.'][can_learn]' }}"
                                                           value="1"
                                                           @if( old('abilities.'.$ability->id.'.can_learn', $abilityAnswer->can_learn) ) checked @endif
                                                    >
                                                </td>
                                            @else
                                                    <td class="ability-cell">
                                                        {{ $ability->name }}
                                                        <div
                                                            class="ability-input-error-container parsley-errors-container"></div>
                                                    </td>
                                                <td class="input-cell" colspan="2">
                                                    <input type="text"
                                                           name="{{ 'abilities['.$ability->id.'][content]' }}"
                                                           value="{{ old('abilities.'.$ability->id.'.content', $abilityAnswer->content) }}"
                                                           placeholder="수기입력" style="width: 200px"
                                                           data-parsley-required="true"
                                                           data-parsley-required-message="※ 종류를 입력해주세요."
                                                           data-parsley-errors-container=".ability-input-error-container">
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="right-content-wrap">
                                <table>
                                    <thead>
                                    <tr>
                                        <th colspan="2">구분</th>
                                        <th>자가평가 점수</th>
                                        <th>교육가능 유무</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rightList as $abilityAnswer)
                                        @php
                                            /** @var mixed $abilityAnswer */
                                        $ability = $abilityAnswer->ability;
                                        @endphp
                                        <tr>
                                            @if( $loop->index == $rightCategoryHeaders[$ability->category_id]['loopIndex'] )
                                                <th rowspan="{{ $rightCategoryHeaders[$ability->category_id]['rowspan']  }}">{{ $rightCategoryHeaders[$ability->category_id]['name'] }}</th>
                                            @endif
                                            @if($ability->type == 'select')
                                                <td class="ability-cell">
                                                    {{ $ability->name }}
                                                    <input type="hidden" class="ability-check" value="Y"
                                                           data-parsley-pattern="Y"
                                                           data-parsley-pattern-message="※ 능력표를 선택해주세요.">
                                                </td>

                                                <td class="select-cell">
                                                    <input type="hidden"
                                                           name="{{ 'abilities['.$ability->id.'][ability_id]' }}"
                                                           value="{{ $ability->id }}">
                                                    <select class="select-menu"
                                                            name="{{ 'abilities['.$ability->id.'][score]' }}">
                                                        <option
                                                            value="0">
                                                            선택
                                                        </option>
                                                        <option value="1"
                                                                @if( old('abilities.'.$ability->id.'.score', $abilityAnswer->score) == 1 ) selected @endif>
                                                            경험없음
                                                        </option>
                                                        <option value="2"
                                                                @if( old('abilities.'.$ability->id.'.score', $abilityAnswer->score) == 2) selected @endif>
                                                            미흡
                                                        </option>
                                                        <option value="3"
                                                                @if( old('abilities.'.$ability->id.'.score', $abilityAnswer->score) == 3) selected @endif>
                                                            보통
                                                        </option>
                                                        <option value="4"
                                                                @if( old('abilities.'.$ability->id.'.score', $abilityAnswer->score) == 4) selected @endif>
                                                            잘함
                                                        </option>
                                                        <option value="5"
                                                                @if( old('abilities.'.$ability->id.'.score', $abilityAnswer->score) == 5) selected @endif>
                                                            매우잘함
                                                        </option>
                                                    </select>
                                                </td>
                                                <td class="checkbox-cell">
                                                    <input type="hidden"
                                                           name="{{ 'abilities['.$ability->id.'][can_learn]' }}"
                                                           value="0">
                                                    <input type="checkbox"
                                                           name="{{ 'abilities['.$ability->id.'][can_learn]' }}"
                                                           value="1"
                                                           @if( old('abilities.'.$ability->id.'.can_learn', $abilityAnswer->can_learn) ) checked @endif
                                                    >
                                                </td>
                                            @else
                                                <td class="ability-cell">
                                                    {{ $ability->name }}
                                                    <div
                                                        class="ability-right-input-error-container parsley-errors-container"></div>
                                                </td>
                                                <td class="input-cell" colspan="2">
                                                    <input type="text"
                                                           name="{{ 'abilities['.$ability->id.'][content]' }}"
                                                           value="{{ old('abilities.'.$ability->id.'.content', $abilityAnswer->content) }}"
                                                           placeholder="수기입력" style="width: 200px"
                                                           data-parsley-required="true"
                                                           data-parsley-required-message="※ 종류를 입력해주세요."
                                                           data-parsley-errors-container=".ability-right-input-error-container">
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $key => $error)
                                    <li>{{ $key }} => {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <ul>
                                @foreach ($errors->keys() as $key)
                                    <li>{{ $key }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="btn-wrap">
                        <button class="btn-submit" type="submit">이력서 수정</button>
                    </div>
                </form>
            </section>
        </div>
    </section>
@endsection
