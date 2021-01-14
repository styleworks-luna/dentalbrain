<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
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
            Route::get('/','Admin\NoticeController@index')->index('index');
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