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
    return view('index');
});

//회사 소개 (임시)
Route::get('introduce',function () {
    return view('pages.introduce.about_us');
});

//강사 소개 (임시)
Route::get('instructor',function () {
    return view('pages.introduce.instructor');
});
