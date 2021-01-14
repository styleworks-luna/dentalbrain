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

Route::get('test/{id}', function () {
    return view('desktop.pages.testUpdate');
});

/*============================ PAGES ============================*/

// 메인 페이지
Route::get('/', 'Main\MainController@index');

//마이페이지 아이디 비밀번호 찾기 (임시)
Route::get('find', function () {
    return view('desktop.pages.user.find_id');
});

//회사 소개 (임시)
Route::get('introduce', function () {
    return view('desktop.pages.introduce.about_us');
});

//강사 소개 (임시)
Route::get('instructor', function () {
    return view('desktop.pages.introduce.instructor');
});

//강의 시청 (임시)
Route::get('watch', function () {
    return view('desktop.pages.lecture.lecture_watch');
});

//전체 강의 (임시)
Route::get('all', function () {
    return view('desktop.pages.lecture.lecture_all');
});


Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
    Route::redirect('/', '/customer/notices')->name('index');

    Route::group(['prefix' => 'notices', 'as' => 'notices.'], function () {
        // 고객센터 공지사항
        Route::get('/', 'Customer\NoticeController@index')->name('index');
        // 고객센터 공지사항 상세
        Route::get('/notices/{notice}', 'Customer\NoticeController@show')->name('show');
    });

    Route::group(['prefix' => 'inquiries', 'as' => 'inquiries.'], function () {
        //고객센터 문의 (임시)
        Route::get('/','Customer\InquiryController@index') -> name('index');

        Route::post('/','Customer\InquiryController@store') -> name('store');
    });

    Route::group(['prefix' => 'faqs', 'as' => 'faqs.'], function () {
        Route::get('/', 'Customer\FaqController@index')->name('index');
    });
});


Route::group(['prefix' => 'lectures', 'as' => 'lectures.'], function () {
    // 전체 강의
    Route::get('/', function () {
        return '준비중.';
    });
    Route::group(['prefix' => '{program}'], function () {
        //강의 상세
        Route::get('/', 'Lecture\DetailController@detail')->name('detail');
        // 강의 신청
        Route::get('apply', 'Lecture\ApplyController@apply')->name('apply');
        // 강의 신청 성공
        Route::get('success', function () {
            return view('desktop.pages.lecture.lecture_success');
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
});

// 관리자
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
    Route::view('/', 'admin.index');
});

Route::group(['prefix'=>'api', 'as' => 'api.' , 'middleware' => 'auth'],function(){
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

        });

        Route::group(['prefix' => 'lecture', 'as' => 'lecture.'], function () {

        });

        Route::group(['prefix' => 'payment', 'as' => 'payment'], function () {

        });

        Route::group(['prefix' => 'banner', 'as' => 'banner.'], function () {

        });

        Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
            Route::group(['prefix' => 'faq', 'as' => 'faqs.'], function () {
                //FAQ index 페이지 데이터
                Route::get('/', 'Admin\FaqController@index')->name('index');
                //FAQ 생성 함수
                Route::post('/', 'Admin\FaqController@store')->name('store');
                //Faq 수정 페이지 데이터
                Route::get('{faq}/edit', 'Admin\FaqController@edit')->name('edit');
                //Faq 업데이트 함수
                Route::put('{faq}', 'Admin\FaqController@update')->name('update');
                //Faq 삭제 함수
                Route::delete('{faq}', 'Admin\FaqController@destroy')->name('destroy');
            });

            Route::group(['prefix' => 'notice', 'as' => 'notices.'], function () {
                //공지사항 index 페이지 데이터
                Route::get('/','Admin\NoticeController@index')->name('index');
                // 공지사항 생성 함수
                Route::post('/', 'Admin\NoticeController@store')->name('store');
                //공지사항 수정 페이지 데이터
                Route::get('{notice}/edit', 'Admin\NoticeController@edit')->name('edit');
                //공지사항 업데이트 함수
                Route::put('{notice}', 'Admin\NoticeController@update')->name('update');
                //공지사항 삭제 함수
                Route::delete('{notice}', 'Admin\NoticeController@destroy')->name('destroy');
            });

            Route::group(['prefix' => 'inquiry', 'as' => 'inquiries.'],function(){
                //문의하기 index 페이지 데이터
                Route::get('/','Admin\InquiryController@index')->name('index');
                //문의하기 수정 페이지 데이터
                Route::get('{Inquiry}/edit','Admin\InquiryController@edit')->name('edit');
                //문의하기 업데이트 함수
                Route::put('{Inquiry}','Admin\InquiryController@update')->name('update');
                //문의하기 삭제 함수
                Route::delete('{Inquiry}','Admin\InquiryController@destroy')->name('destroy');
            });
        });
    });
});