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

Route::get('/', function () {
    return view('desktop.index');
});

//회사 소개 (임시)
Route::get('introduce',function () {
    return view('desktop.pages.introduce.about_us');
});

//강사 소개 (임시)
Route::get('instructor',function () {
    return view('desktop.pages.introduce.instructor');
});

//강의 상세 (임시)
Route::get('lecture',function () {
    return view('desktop.pages.lecture.lecture_detail');
});

//강의 신청 (임시)
Route::get('apply',function () {
    return view('desktop.pages.lecture.lecture_apply');
});

//강의 신청 (임시)
Route::get('mypage',function () {
    return view('desktop.pages.user.mypage_lecture');
});
