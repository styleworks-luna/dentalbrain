@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-post.css') }}">
@endsection

@section('content')
    <section class="albatalk-post-wrap">
        <div class="title-wrap">
            <div class="container">
                <a>이력서 등록</a>
                <a>구인등록</a>
                <a>헤드헌팅</a>
            </div>
        </div>
        <div class="container">
            <section class="wanted">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h2>구인 등록</h2>
                <form action={{route('albatalk.recruit.create')}} method="post">
                    @csrf
                    <div style="display: flex; float: right;">
                        <div class="inquire-form-wrap">
                            <table class="top">
                                <tr>
                                    <th>치과명 *</th>
                                    <td class="name-wrap">
                                        <input type="text"
                                               id="name"
                                               name="company_name"
                                               value="{{ old('company_name') }}"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 치과명을 입력해주세요">
                                    </td>

                                    <th>담당자명 *</th>
                                    <td class="manager-wrap">
                                        <input type="text"
                                               id="manager"
                                               name="name"
                                               value="{{ old('name') }}"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 담당자명을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>대표자명 *</th>
                                    <td class="ceo-wrap">
                                        <input type="text"
                                               id="ceo"
                                               name="company_leader"
                                               value="{{ old('company_leader') }}"
                                               placeholder="대표자명 입력(최소 2자 이상)"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 대표자명을 입력해주세요">
                                    </td>

                                    <th>담장자 전화번호 *</th>
                                    <td class="manager-phone-wrap">
                                        <input type="text"
                                               id="manager-phone"
                                               name="phone"
                                               value="{{ old('phone') }}"
                                               placeholder="‘-‘ 없이 입력"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>사업자등록번호 *</th>
                                    <td class="num-wrap">
                                        <input type="text"
                                               id="num"
                                               name="company_license"
                                               value="{{ old('company_license') }}"
                                               placeholder="대표자명 입력(최소 2자 이상)"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 사업자등록번호를 입력해주세요.">
                                    </td>

                                    <th>담장자 이메일 *</th>
                                    <td class="manager-email-wrap">
                                        <input type="text"
                                               id="manager-email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 이메일을 입력해주세요.">
                                    </td>
                                </tr>
                                <tr>
                                    <th>전화번호 *</th>
                                    <td class="phone-wrap">
                                        <input type="text"
                                               id="phone"
                                               name="company_phone"
                                               value="{{ old('company_phone') }}"
                                               placeholder="‘-‘ 없이 입력"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>홈페이지 주소</th>
                                    <td class="page-wrap">
                                        <input type="text"
                                               id="page"
                                               name="url"
                                               value="{{ old('url') }}"
                                               data-parsley-required="false">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="inquire-form-wrap">
                        <table style="border-top: 0">
                            <tr>
                                <th>주소입력 *</th>
                                <td class="address-wrap">
                                    <input type="button" class="btn-address" value="주소검색"
                                           data-index="test">
                                    <input type="text" id="address" name="surveys[test][address]"
                                           class="address"
                                           data-index="test"
                                           readonly="readonly"
                                           data-parsley-required-message="※ 주소를 입력해주세요.">
                                    <input type="text" id="address-detail"
                                           name="surveys[test][address_detail]"
                                           class="address-detail"
                                           placeholder="상세주소를 입력"
                                           data-parsley-required-message="상세주소를 입력하세요">
                                </td>
                            </tr>
                            <tr>
                                <th>인근 지하철역</th>
                                <td class="subway-wrap">
                                    <input type="text"
                                           id="subway"
                                           name="subway"
                                           value="{{ old('subway') }}"
                                           placeholder="인근 지하철역을 입력해주세요.(ex: 7호선 신논현 도보 5분)"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                </td>
                            </tr>
                            <tr>
                                <th>신청분야 *</th>
                                <td class="field-wrap">
                                    @foreach($typeApplication as $application)
                                        <input type="checkbox" id="field" name="application[{{$application->id}}]"
                                               @if(old('application')[$application->id] ?? 'off' == 'on') checked
                                               @endif
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                        <label id="field">{{$application->type}}</label>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>근무형태 *</th>
                                <td class="work-type-wrap">
                                    @foreach($typeWork as $work)
                                        <input type="radio" id="field" name="work" value={{$work->id}}
                                        @if(old('work') == $work->id) checked @endif
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                        <label id="field">{{$work->type}}</label>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>직종 *</th>
                                <td class="job-wrap">
                                    @foreach($typeJob as $job)
                                        <input type="radio" id="field" name="job" value={{$job->id}}
                                        @if(old('job') == $job->id) checked @endif
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                        <label id="field">{{$job->type}}</label>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>급여 *</th>
                                <td class="pay-wrap">
                                    @foreach($typeSalary as $salary)
                                        <input type="radio" id="field" name="salary" value={{$salary->id}}
                                        @if(old('salary') == $salary->id) checked @endif
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                        <label id="field">{{$salary->type}}</label>
                                        @if($salary->id == 4)
                                            <input type="text" name="salary_value" value="{{old("salary_value")}}" placeholder="내용을 입력해주세요.">
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>학력 *</th>
                                <td class="school-wrap">
                                    <input type="radio" id="field" name="study"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <input type="text" name="study" value="{{old('study')}}"
                                           placeholder="학력선택">
                                    <input type="radio" id="field" name="study"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">기타</label>
                                </td>
                            </tr>
                            <tr>
                                <th>경력 *</th>
                                <td class="career-wrap">
                                    <input type="radio" id="field" name="career"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">신입</label>
                                    <input type="radio" id="field" name="career"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field" class="last">경력</label>
                                    <input type="text" name="career" value="{{ old('career') }}"
                                           placeholder="경력기간 선택">
                                </td>
                            </tr>
                            <tr>
                                <th>근무요일 *</th>
                                <td class="pay-wrap">
                                    @foreach($typeDay as $day)
                                        <input type="radio" id="field" name="day" value={{$day->id}}
                                        @if(old('day') == $day->id) checked @endif
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                        <label id="field">{{$day->type}}</label>
                                        @if($day->id == 4)
                                            <input type="text" name="day_value" value="{{old("day_value")}}" placeholder="내용을 입력해주세요.">
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>복리후생 *</th>
                                <td class="welfare-wrap">
                                    @foreach($typeBenefit as $benefit)
                                        <input type="checkbox" id="field" name="benefit[{{$benefit->id}}]"
                                               @if(old('benefit')[$benefit->id] ?? 'off' == 'on') checked
                                               @endif
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                        @if($benefit->id == 6 || $benefit->id == 11)
                                            <label class="last" id="field">{{$benefit->type}}</label>
                                        @else
                                            <label id="field">{{$benefit->type}}</label>
                                        @endif
                                    @endforeach

                                </td>
                            </tr>
                            <tr>
                                <th>모집마감일 *</th>
                                <td class="deadline-wrap">
                                    <input type="radio" id="field" name="deadline"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <input type="text" name="started_at" value="{{old('started_at')}}"
                                           placeholder="시작일자 선택">
                                    <input class="time" type="text" placeholder="HH:mm">
                                    <label id="field">부터</label>
                                    <input type="text" name="ended_at" value="{{old('ended_at')}}"
                                           placeholder="마감일자 선택">
                                    <input class="time2" type="text" placeholder="HH:mm">
                                    <input type="radio" id="until-hiring" name="deadline">
                                    <label name="until-hiring" for="until-hiring">채용시까지</label>
                                </td>
                            </tr>
                            <tr>
                                <th>상세정보</th>
                                <td class="Detail-wrap">
                                    <input type="textarea" id="field" name="content" value="{{old('content')}}">

                                    </input>
                                </td>
                            </tr>
                            <tr>
                                <th>결제금액</th>
                                <td class="payment-wrap">
                                </td>
                            </tr>
                            <tr>
                                <th>결제방식 *</th>
                                <td class="paydeail-wrap">
                                    <span>
                                        <input type="radio" id="field" name="paydeail"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                        <label id="field">신용카드</label>
                                        <input type="text" placeholder="신한">
                                    </span>
                                    <input class="last" type="radio" id="field" name="paydeail"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">실시간 계좌이체</label>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <button class="submit" type="submit">구인공고 등록</button>
                </form>
            </section>
        </div>
    </section>
@endsection
