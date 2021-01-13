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
        Route::group(['prefix' => 'notices', 'as' => 'notices.'], function () {
            // 공지사항
            Route::get('notice', 'Admin\NoticeController@index')->name('index');
            // 공지사항 저장
            Route::post('notice', 'Admin\NoticeController@store')->name('create');
            //공지사항 edit
            Route::get('notice/{notice}/edit', 'Admin\NoticeController@edit')->name('edit');
            //공지사항 update
            Route::put('notice/{notice}', 'Admin\NoticeController@update')->name('update');
            //공지사항 삭제
            Route::delete('notice/{notice}', 'Admin\NoticeController@destroy')->name('destroy');
        });

        Route::group(['prefix' => 'faq', 'as' => 'faqs.'], function () {
            //FAQ create
            Route::post('faq', 'Admin\FaqController@store')->name('create');
            //Faq 수정 페이지 데이터 불러오기
            Route::get('faq/{faq}/edit', 'Admin\FaqController@edit')->name('edit');
            //Faq 업데이트
            Route::put('faq/{faq}', 'Admin\FaqController@update')->name('update');
            //Faq 삭제
            Route::delete('faq/{faq}', 'Admin\FaqController@destroy')->name('destroy');
        });
    });

});