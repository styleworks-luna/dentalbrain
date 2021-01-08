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

//회사 소개 (임시)
Route::get('introduce', function () {
    return view('desktop.pages.introduce.about_us');
});

//강사 소개 (임시)
Route::get('instructor', function () {
    return view('desktop.pages.introduce.instructor');
});

//강의 상세 (임시)
Route::get('lecture', function () {
    return view('desktop.pages.lecture.lecture_detail');
});

//강의 신청 (임시)
Route::get('apply', function () {
    return view('desktop.pages.lecture.lecture_apply');
});

//마이페이지 신청한 강의 (임시)
Route::get('mypage', function () {
    return view('desktop.pages.user.mypage_lecture');
});

//마이페이지 결제내역 (임시)
Route::get('mypage/payment', function () {
    return view('desktop.pages.user.mypage_payment');
});

//마이페이지 질문내역 (임시)
Route::get('mypage/question', function () {
    return view('desktop.pages.user.mypage_question');
});

//마이페이지 회원탈퇴 (임시)
Route::get('mypage/secession', function () {
    return view('desktop.pages.user.mypage_secession');
});

//마이페이지 회원정보수정 진입 (임시)
Route::get('mypage/login', function () {
    return view('desktop.pages.user.mypage_login');
});

//마이페이지 회원정보수정 (임시)
Route::get('mypage/edit', function () {
    return view('desktop.pages.user.mypage_edit');
});

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    //회원가입 (임시)
    Route::post('create', 'Auth\RegisterController@register')->name('create');
});
