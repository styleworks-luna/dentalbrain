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

Route::get('/', 'Main\MainController@index');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    //회원가입
    Route::post('create', 'Auth\RegisterController@register')->name('create');
});

//회사 소개 (임시)
Route::get('introduce', function () {
    return view('desktop.pages.introduce.about_us');
});

//강사 소개 (임시)
Route::get('instructor', function () {
    return view('desktop.pages.introduce.instructor');
});

//마이페이지 회원탈퇴 (임시)
Route::get('mypage/secession', function () {
    return view('desktop.pages.user.mypage_secession');
});

//마이페이지 아이디 비밀번호 찾기 (임시)
Route::get('find', function () {
    return view('desktop.pages.user.find_id');
});


Route::group(['prefix' => 'notice'],function(){
    //마이페이지 고객센터 공지사항 (임시)
    Route::get('/','Customer\NoticeController@index')->name('notice');

    ////마이페이지 고객센터 공지사항 상세 (임시)
    Route::get('detail/{notice}','Customer\NoticeController@show')->name('notice_detail');
});


Route::get('service/faq', 'Customer\FaqController@index')->name('faq');

////마이페이지 고객센터 faq (임시)
//Route::get('faq', function () {
//    return view('desktop.pages.service.faq');
//});


Route::group(['prefix' => 'admin','as' => 'admin.', 'middleware' => 'auth'],function() {
    Route::get('notice','Admin\NoticeController@index')->name('noticeCreate');
    Route::post('notice','Admin\NoticeController@store')->name('noticeCreate');
    //공지사항 create
    Route::get('notice/{notice}/edit','Admin\NoticeController@edit')->name('noticeEdit');
    Route::put('notice/{notice}','Admin\NoticeController@update')->name('noticeUpdate');
    //공지사항 edit 페이지
    Route::delete('notice/{notice}','Admin\NoticeController@destroy')->name('noticeDestroy');
    //공지사항 삭제
});


//마이페이지 고객센터 문의 (임시)
Route::get('inquire', function () {
    return view('desktop.pages.service.inquire');
});

Route::group(['prefix' => 'lectures', 'as' => 'lectures.'], function () {
    // 전체 강의
    Route::get('/', function () {
        return '준비중.';
    });
    Route::group(['prefix' => '{lecture}'], function () {
        //강의 상세
        Route::get('/', 'Lecture\DetailController@detail')->name('detail');
        // 강의 신청
        Route::get('apply', 'Lecture\ApplyController@apply')->name('apply');
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
    // 회원정보 패스워드 확인
    Route::get('confirm', 'Account\UserController@needConfirm')->name('confirm');
    Route::post('confirm', 'Account\UserController@confirm')->name('confirm');
});

