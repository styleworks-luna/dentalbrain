<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*============================ AUTH ============================*/
// 회원가입
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register');
// 로그인
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
// 로그아웃
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

/*============================ TESTING ============================*/


Route::group(['prefix' => 'test', 'as' => 'test.'], function () {
    //FAQ, 공지사항, 문의하기 생성 페이지
    Route::get('/', 'Test\TestController@index')->name('index');

    //공지사항 업데이트 확인 페이지
    Route::get('faq/{faq}', 'Test\TestController@FaqEdit')->name('FaqEdit');

    //공지사항 업데이트 확인 페이지
    Route::get('notice/{notice}', 'Test\TestController@NoticeEdit')->name('NoticeEdit');

    //문의하기 업데이트 확인 페이지
    Route::get('inquiry/{inquiry}', 'Test\TestController@InquiryEdit')->name('InquiryEdit');

    //업로드 파일 확인 페이지
    Route::get('upload/file', 'Test\TestController@FileUpload')->name('upload.file');
    //배너 업데이트 확인 페이지
    Route::get('banner/{banner}', 'Test\TestController@bannerEdit')->name('bannerEdit');
    //유저 관리자 업로드 확인 페이지
    Route::get('user/{userId}', 'Test\TestController@UserEdit')->name('userEdit');

    Route::get('search', 'Test\TestController@search')->name('search');
});

/*============================ PAGES ============================*/

// 메인 페이지
Route::get('/', 'Main\MainController@index');

//마이페이지 아이디 비밀번호 찾기 (임시)
Route::get('find', function () {
    return view('desktop.pages.user.find_id');
});

//이름과 전화번호로 아이디 찾기
Route::post('findIdWithNameAndPhone', 'Account\FindIdController@findIdWithNameAndPhone')->name('findIdWithNameAndPhone');
// 패스워드 변경 이메일 보내기
Route::post('sendPasswordMail','Account\FindPasswordController@sendPasswordMail')->name('sendPasswordMail');
//관리자 회원정보 상세 패스워드 변경 이메일 보내기
Route::post('sendPasswordMailWithUser/{user}','Account\FindPasswordController@sendPasswordMailWithUser')->name('sendPasswordMailWithUser');

//회사 소개 (임시)
Route::get('introduce', function () {
    return view(viewPrefix() . 'pages.introduce.about_us');
});

//강의 안내
Route::get('information', function () {
    return view(viewPrefix() . 'pages.introduce.lecture_information');
});

//강사 소개
Route::get('instructor', function () {
    return view(viewPrefix() . 'pages.introduce.instructor');
});

//강의 시청 (임시)
Route::get('watch', function () {
    return view('desktop.pages.lecture.lecture_watch');
});


Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
    Route::redirect('/', '/customer/notices')->name('index');

    Route::group(['prefix' => 'notices', 'as' => 'notices.'], function () {
        // 고객센터 공지사항
        Route::get('/', 'Customer\NoticeController@index')->name('index');
        // 고객센터 공지사항 상세
        Route::get('{notice}', 'Customer\NoticeController@show')->name('show');
    });

    Route::group(['prefix' => 'inquiries', 'as' => 'inquiries.'], function () {
        //고객센터 문의 (임시)
        Route::get('/', 'Customer\InquiryController@index')->name('index');

        Route::post('/', 'Customer\InquiryController@store')->name('store');
    });

    Route::group(['prefix' => 'faqs', 'as' => 'faqs.'], function () {
        Route::get('/', 'Customer\FaqController@index')->name('index');
    });
});


Route::group(['prefix' => 'lectures', 'as' => 'lectures.'], function () {
    // 전체 강의
    Route::get('/', function () {
        return view(viewPrefix() . 'pages.lecture.lecture_all');
    });
    Route::group(['prefix' => '{program}'], function () {
        //강의 상세
        Route::get('/', 'Lecture\DetailController@detail')->name('detail');
        // 강의 신청
        Route::group(['middleware' => 'auth'], function () {
            Route::get('apply', 'Lecture\ApplyController@showApplyForm')->name('apply.form');
            Route::post('apply', 'Lecture\ApplyController@apply')->name('apply');
        });
        // 강의 신청 성공
        Route::get('success', function () {
            return view('desktop.pages.lecture.lecture_success');
        });

        Route::group(['prefix' => 'comments', 'as' => 'comments.'], function () {
            Route::post('/', 'Lecture\CommentController@store')->name('store');
            Route::put('{comment}', 'Lecture\CommentController@update')->name('update');
            Route::delete('{comment}', 'Lecture\CommentController@delete')->name('delete');
        });
    });
});

Route::group(['prefix' => 'account', 'as' => 'account.', 'middleware' => 'auth'], function () {
    Route::redirect('/', '/account/lectures')->name('index');
    // 신청한 강의
    Route::get('lectures', 'Account\ProgramController@index')->name('lectures');
    // 결제 내역
    Route::get('payments', 'Account\PaymentController@index')->name('payments');
    // 질문 내역
    Route::get('questions', 'Account\QuestionController@index')->name('questions');
    // 회원정보 수정
    Route::get('modify', 'Account\UserController@modify')->name('modify');
    Route::post('update', 'Account\UserController@update')->name('update');
    // 회원정보 패스워드 확인
    Route::get('confirm', 'Account\UserController@needConfirm')->name('confirm');
    Route::post('confirm', 'Account\UserController@confirm')->name('confirm');

    //마이페이지 회원탈퇴 (임시)
    Route::get('secession', 'Account\SecessionController@secessionForm')->name('secession');
    //마이페이지 회원탈퇴 함수
    Route::post('userSecession','Account\SecessionController@userSecession')->name('userSecession');
});

// 관리자
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
    Route::view('/', 'admin.index');
    Route::view('{any}', 'admin.index');

    // lecture
    Route::view('lecture/{any}', 'admin.index');
    Route::view('lecture/online/{any}', 'admin.index');
    Route::view('lecture/offline/{any}', 'admin.index');
    Route::view('lecture/question/{any}', 'admin.index');

    // user
    Route::view('user', 'admin.index');
    Route::view('user/{any}', 'admin.index');

    // banner
    Route::view('banner', 'admin.index');
    Route::view('banner/{any}', 'admin.index');

    // customer
    Route::view('customer/{any}', 'admin.index');
    Route::view('customer/faq/{any}', 'admin.index');
    Route::view('customer/notice/{any}', 'admin.index');
    Route::view('customer/inquire/{any}', 'admin.index');
});

// TODO: 추후 api 인증 도입하면서 api.php 로 이사갈 예정 //
Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
    Route::get('bizppurio','Test\TestController@getToken')->name('getToken');

    Route::group(['prefix' => 'lectures', 'as' => 'lectures.'], function () {
        Route::get('/', 'Main\LectureController@index')->name('list');
        Route::get('categories', 'Main\LectureController@categories')->name('categories');
        Route::group(['prefix' => '{program}'], function () {
            Route::post('like', 'Lecture\DetailController@like');
            Route::get('download', 'Lecture\MaterialController@download')->name('download');
        });
    });

    Route::get('map/geocode', 'MapController@naver_map');
    Route::get('map/reverse-geocode', 'MapController@reverse_geocode');

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::group(['prefix' => 'upload', 'as' => 'upload.'], function () {
            Route::post('file', 'Admin\FileController@uploadFile')->name('file');
            Route::post('image', 'Admin\FileController@uploadImage')->name('image');
        });
        Route::get('download/{file}', 'Admin\FileController@download')->name('download');

        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            //user index 페이지 데이터
            Route::get('/', 'Admin\User\UserController@index')->name('index');
            //user 수정 페이지 데이터
            Route::get('{user}/edit', 'Admin\User\UserController@edit')->name('edit');
            //user 업데이트 함수
            Route::put('{user}', 'Admin\User\UserController@update')->name('update');
            //user 직업 모두 가져오는 데이터
            Route::get('category', 'Admin\User\UserController@getUserJobNameCategory')->name('getUserJobNameCategory');

            Route::post('search', 'Admin\User\UserController@search')->name('search');
        });

        Route::group(['prefix' => 'lecture', 'as' => 'lecture.'], function () {
            Route::get('categories', 'Admin\OnlineProgramController@getCategories')->name('categories');
            Route::group(['prefix' => 'online', 'as' => 'online.'], function () {
                Route::get('/', 'Admin\OnlineProgramController@index')->name('index');
                Route::post('/', 'Admin\OnlineProgramController@store')->name('store');
                Route::get('{program}/students', 'Admin\OnlineProgramController@getStudentInfo')->name('students');
                Route::get('{program}', 'Admin\OnlineProgramController@edit')->name('edit');
                Route::put('{program}', 'Admin\OnlineProgramController@update')->name('update');
//                Route::delete('{program}', 'Admin\OnlineProgramController@index');
            });
            Route::group(['prefix' => 'offline', 'as' => 'offline.'], function () {
                Route::get('/', 'Admin\OfflineProgramController@index')->name('index');
                Route::post('/', 'Admin\OfflineProgramController@store')->name('store');
                Route::get('{program}/students', 'Admin\OfflineProgramController@getStudentInfo')->name('students');
                Route::get('{program}', 'Admin\OfflineProgramController@edit')->name('edit');
                Route::put('{program}', 'Admin\OfflineProgramController@update')->name('update');
//                Route::delete('{program}', 'Admin\OfflineProgramController@index');

            });
        });

        Route::group(['prefix' => 'payment', 'as' => 'payment'], function () {

        });

        Route::group(['prefix' => 'banner', 'as' => 'banners.'], function () {
            //배너 index 페이지 데이터
            Route::get('/', 'Admin\Banner\BannerController@index')->name('index');
            //배너 생성 함수
            Route::post('/', 'Admin\Banner\BannerController@store')->name('store');
            //배너 수정 페이지 데이터
            Route::get('{banner}/edit', 'Admin\Banner\BannerController@edit')->name('edit');
            //배너 업데이트 함수
            Route::put('{banner}', 'Admin\Banner\BannerController@update')->name('update');
            //배너 삭제 함수
            Route::delete('{banner}', 'Admin\Banner\BannerController@destroy')->name('destroy');
            //배너 상태 변경 함수
            Route::patch('{banner}/status', 'Admin\Banner\BannerController@statusChange')->name('statusChange');
            //배너 검색
            Route::post('search', 'Admin\Banner\BannerController@search')->name('search');
            //배너 클릭 횟수 올리고 링크로 이동
            Route::get('redirect/{banner}', 'Admin\Banner\BannerController@redirectToLink')->name('redirectToLink');
            //배너 종류 데이터
            Route::get('category', 'Admin\Banner\BannerController@getBannerCategory')->name('getBannerCategory');
        });

        Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
            Route::group(['prefix' => 'faq', 'as' => 'faqs.'], function () {
                //FAQ index 페이지 데이터
                Route::get('/', 'Admin\FaqController@index')->name('index');
                //FAQ 생성 함수
                Route::post('/', 'Admin\FaqController@store')->name('store');
                //Faq 카테고리 가져오기
                Route::get('category', 'Admin\FaqController@getFaqCategory')->name('getFaqCategory');
                //Faq 수정 페이지 데이터
                Route::get('{faq}', 'Admin\FaqController@edit')->name('edit');
                //Faq 업데이트 함수
                Route::put('{faq}', 'Admin\FaqController@update')->name('update');
                //Faq 삭제 함수
                Route::delete('{faq}', 'Admin\FaqController@destroy')->name('destroy');
                //상태 변경 함수
                Route::patch('{faq}/status', 'Admin\FaqController@statusChange')->name('statusChange');
                //검색 함수
                Route::post('search', 'Admin\FaqController@search')->name('search');
            });

            Route::group(['prefix' => 'notice', 'as' => 'notices.'], function () {
                //공지사항 index 페이지 데이터
                Route::get('/', 'Admin\NoticeController@index')->name('index');
                // 공지사항 생성 함수
                Route::post('/', 'Admin\NoticeController@store')->name('store');
                //공지사항 수정 페이지 데이터
                Route::get('{notice}/edit', 'Admin\NoticeController@edit')->name('edit');
                //공지사항 업데이트 함수
                Route::put('{notice}', 'Admin\NoticeController@update')->name('update');
                //공지사항 삭제 함수
                Route::delete('{notice}', 'Admin\NoticeController@destroy')->name('destroy');
                //상태 변경 함수
                Route::patch('{notice}/status', 'Admin\NoticeController@statusChange')->name('statusChange');

                Route::post('search', 'Admin\NoticeController@search')->name('search');
            });

            Route::group(['prefix' => 'inquire', 'as' => 'inquiries.'], function () {
                //문의하기 index 페이지 데이터
                Route::get('/', 'Admin\InquiryController@index')->name('index');
                //문의하기 카테고리 가져오기
                Route::get('category', 'Admin\InquiryController@getInquiryCategory')->name('getInquiryCategory');
                //문의하기 수정 페이지 데이터
                Route::get('{inquiry}/edit', 'Admin\InquiryController@edit')->name('edit');
                //문의하기 업데이트 함수
                Route::patch('{inquiry}', 'Admin\InquiryController@update')->name('update');
                //문의하기 삭제 함수
                Route::delete('{inquiry}', 'Admin\InquiryController@destroy')->name('destroy');
                //문의하기 검색 페이지
                Route::post('search', 'Admin\InquiryController@search')->name('search');
            });
        });
    });
});
