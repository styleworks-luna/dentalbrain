@extends('desktop.layouts.frames.basic_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-post.css') }}">
@endsection

@section('content')
    <section class="albatalk-wrap">
        <div class="title-wrap">
            <div class="container">
            </div>
        </div>
        <div class="container">
            <section class="wanted">
                <h2>구인 등록</h2>
                <form>
                    @csrf
                    <div class="inquire-form-wrap">
                        <table>
                            <tr>
                                <th>치과명 *</th>
                                <td class="name-wrap">
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 치과명을 입력해주세요">
                                </td>

                                <th>담당자명 *</th>
                                <td class="manager-wrap">
                                    <input type="text"
                                           id="manager"
                                           name="manager"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 담당자명을 입력해주세요">
                                </td>
                            </tr>
                            <tr>
                                <th>대표자명 *</th>
                                <td class="ceo-wrap">
                                    <input type="text"
                                           id="ceo"
                                           name="ceo"
                                           placeholder="대표자명 입력(최소 2자 이상)"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 대표자명을 입력해주세요">
                                </td>

                                <th>담장자 전화번호 *</th>
                                <td class="manager-phone-wrap">
                                    <input type="text"
                                           id="manager-phone"
                                           name="manager-phone"
                                           placeholder="대표자명 입력(최소 2자 이상)"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                </td>
                            </tr>
                            <tr>
                                <th>사업자등록번호 *</th>
                                <td class="num-wrap">
                                    <input type="text"
                                           id="num"
                                           name="num"
                                           placeholder="대표자명 입력(최소 2자 이상)"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 대표자명을 입력해주세요">
                                </td>

                                <th>담장자 이메일 *</th>
                                <td class="manager-email-wrap">
                                    <input type="text"
                                           id="manager-email"
                                           name="manager-email"
                                           placeholder="대표자명 입력(최소 2자 이상)"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                </td>
                            </tr>
                            <tr>
                                <th>전화번호 *</th>
                                <td class="phone-wrap">
                                    <input type="text"
                                           id="phone"
                                           name="phone"
                                           placeholder="대표자명 입력(최소 2자 이상)"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                </td>
                            </tr>
                            <tr>
                                <th>홈페이지 주소 *</th>
                                <td class="page-wrap">
                                    <input type="text"
                                           id="page-wrap"
                                           name="page-wrap"
                                           placeholder="대표자명 입력(최소 2자 이상)"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <th>주소입력 *</th>
                                <td class="address-wrap">
                                    <input type="button" class="btn-address" value="주소검색"
                                           data-index="test">
                                    <input type="text" id="address" name="surveys[test][address]"
                                           class="address"
                                           data-index="test"
                                           readonly="readonly"
                                           data-parsley-required-message="주소를 검색해주세요.">
                                    <input type="text" id="address-detail"
                                           name="surveys[test][address_detail]"
                                           class="address-detail"
                                           placeholder="상세주소를 입력하세요."
                                           data-parsley-required-message="상세주소를 입력하세요">
                                </td>
                            </tr>
                        </table>

                    </div>
                </form>
            </section>

        </div>
    </section>
@endsection
