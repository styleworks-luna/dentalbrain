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

    Route::get('cancel', 'Test\TestController@cancelTest');

    Route::get('mail', 'Test\TestController@mailView');
    Route::get('mailAdmin', 'Test\TestController@mailViewAdmin');
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
            // 강의 신청 폼
            Route::get('apply', 'Lecture\ApplyController@showApplyForm')->name('apply.form');
            // 강의 신청
            Route::post('apply', 'Lecture\ApplyController@apply')->name('apply');
            // 강의 결제 폼
            Route::get('payment', 'Lecture\PaymentsController@showPaymentForm')->name('payment.form');
            // 강의 결제 성공
            Route::get('success', 'Lecture\PaymentsController@success')->name('payment.success');
            // 강의 신청 성공
            Route::get('result', 'Lecture\ApplyController@result')->name('result');
            // 강의 시청
            Route::get('watch/{lecture?}', 'Lecture\WatchController@watch')->name('watch');
            // 강의 시청 확인
            Route::patch('watched/{lecture?}', 'Lecture\WatchController@watched')->name('check-watch');
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
    Route::group(['prefix' => 'questions', 'as' => 'questions.'], function () {
        Route::get('/', 'Account\QuestionController@index')->name('index');
        Route::post('/{lecture}', 'Account\QuestionController@store')->name('store');
    });

    // 회원정보 수정
    Route::get('modify', 'Account\UserController@modify')->name('modify');
    Route::post('update', 'Account\UserController@update')->name('update');
    // 회원정보 패스워드 확인
    Route::get('confirm', 'Account\UserController@needConfirm')->name('confirm');
    Route::post('confirm', 'Account\UserController@confirm')->name('confirm');

    //마이페이지 회원탈퇴 (임시)
    Route::get('secession', 'Account\SecessionController@secessionForm')->name('secession');
    //마이페이지 회원탈퇴 함수
    Route::post('userSecession', 'Account\SecessionController@userSecession')->name('userSecession');
});

// 관리자
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
    Route::view('/', 'admin.index');
    Route::view('{any}', 'admin.index');

    // lecture
    Route::view('lecture/{any}', 'admin.index');
    Route::view('lecture/online/{any}', 'admin.index');
    Route::view('lecture/online/{user}/{any}', 'admin.index');
    Route::view('lecture/offline/{any}', 'admin.index');
    Route::view('lecture/offline/{user}/{any}', 'admin.index');
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
    Route::post('toss/deposited', 'Lecture\PaymentsController@deposited');

    Route::post('send-verification', 'Notification\PhoneVerificationController@sendVerificationNumber')->name('send-verification');

    Route::post('compare-verification', 'Notification\PhoneVerificationController@compareVerificationNumber')->name('compare-verification');

    Route::get('lecturesData', 'Account\ProgramController@lecturesData')->name('lecturesData');
    // 회원 아이디 중복체크
    Route::post('check-id', 'Account\FindIdController@checkIdDuplication')->name('check-id');

    Route::group(['prefix' => 'find', 'as' => 'find.'], function () {
        // 회원 아이디 찾기
        Route::post('id', 'Account\FindIdController@findIdWithNameAndPhone')->name('id');
        // 회원 비밀번호 찾기
        Route::post('password', 'Account\FindPasswordController@sendPasswordMail')->name('password');
    });

    Route::group(['prefix' => 'lectures', 'as' => 'lectures.'], function () {
        Route::get('/', 'Main\LectureController@index')->name('list');
        Route::get('categories', 'Main\LectureController@categories')->name('categories');
        Route::group(['prefix' => '{program}'], function () {

            // 유저 자동환불 신청
            Route::delete('cancel', 'Lecture\CancelController@cancel')->name('cancel')->middleware('auth');
            // 유저 수동환불 신청
            Route::delete('cancel-request', 'Lecture\CancelController@cancelRequest')->name('cancel-request')->middleware('auth');

            Route::post('like', 'Lecture\DetailController@like');
            Route::get('download', 'Lecture\MaterialController@download')->name('download');

            Route::group(['prefix' => 'comments', 'as' => 'comments.'], function () {
                Route::post('/', 'Lecture\CommentController@store')->name('store');
                Route::put('{comment}', 'Lecture\CommentController@update')->name('update');
                Route::delete('{comment}', 'Lecture\CommentController@delete')->name('delete');
            });
        });
    });

    Route::group(['prefix' => 'surveys', 'as' => 'surveys.'], function () {
        Route::group(['prefix' => '{survey}'], function () {
            Route::group(['prefix' => 'answers', 'as' => 'answers.'], function () {
                Route::get('{answer}/download', 'Survey\FileController@download')->name('download');
            });
        });
    });

    Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
        Route::group(['prefix' => '{banner}'], function () {
            Route::get('/', 'Main\BannerController@redirectToLink')->name('redirect');
        });
    });


    Route::get('map/geocode', 'MapController@naver_map');
    Route::get('map/reverse-geocode', 'MapController@reverse_geocode');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
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
            // user 검색 데이터
            Route::post('search', 'Admin\User\UserController@search')->name('search');
            //관리자 회원정보 상세 패스워드 변경 이메일 보내기
            Route::post('find/password/{user}', 'Account\FindPasswordController@sendPasswordMailWithUser')->name('sendPasswordMailWithUser');
            // user 유료회원 <-> 무료회원 전환
            Route::patch('{user}/paid', 'Admin\User\UserController@updatePaid')->name('change.paid');
        });

        Route::group(['prefix' => 'lecture', 'as' => 'lecture.'], function () {
            // 강의 카테고리 리소스
            Route::get('categories', 'Admin\Program\OnlineProgramController@getCategories')->name('categories');
            // 강의 상세 내용 이미지 업로드
            Route::post('upload', 'Admin\FileController@uploadContent')->name('upload');

            Route::group(['prefix' => 'online', 'as' => 'online.'], function () {
                // 온라인 강의 리스트
                Route::get('/', 'Admin\Program\OnlineProgramController@index')->name('index');
                // 온라인 강의 저장
                Route::post('/', 'Admin\Program\OnlineProgramController@store')->name('store');
                Route::group(['prefix' => '{program}'], function () {
                    // 온라인 강의 수강생 목록
                    Route::get('students', 'Admin\Program\OnlineStudentController@students')->name('students');
                    // 온라인 강의 수강 취소
                    Route::delete('students/{student}', 'Admin\Payment\PaymentController@cancel')->name('students.cancel');
                    // 온라인 강의 수정
                    Route::get('/', 'Admin\Program\OnlineProgramController@edit')->name('edit');
                    // 온라인 강의 업데이트
                    Route::put('/', 'Admin\Program\OnlineProgramController@update')->name('update');
                    // 온라인 강의 비공개/공개 전환
                    Route::patch('/', 'Admin\Program\OnlineProgramController@changeOpen')->name('changeOpen');
                });
//                Route::delete('{program}', 'Admin\Program\OnlineProgramController@index');
            });
            Route::group(['prefix' => 'offline', 'as' => 'offline.'], function () {
                // 오프라인 강의 리스트
                Route::get('/', 'Admin\Program\OfflineProgramController@index')->name('index');
                // 오프라인 강의 저장
                Route::post('/', 'Admin\Program\OfflineProgramController@store')->name('store');
                Route::group(['prefix' => '{program}'], function () {
                    // 오프라인 강의 수강생 리스트
                    Route::get('/students', 'Admin\Program\OfflineStudentController@students')->name('students');
                    // 오프라인 강의 수강 취소
                    Route::delete('students/{student}', 'Admin\Payment\PaymentController@cancel')->name('students.cancel');
                    // 오프라인 강의 수정
                    Route::get('/', 'Admin\Program\OfflineProgramController@edit')->name('edit');
                    // 오프라인 강의 업데이트
                    Route::put('/', 'Admin\Program\OfflineProgramController@update')->name('update');
                    // 오프라인 강의 비공개/공개 전환
                    Route::patch('/', 'Admin\Program\OfflineProgramController@changeOpen')->name('changeOpen');
                });
//                Route::delete('{program}', 'Admin\Program\OfflineProgramController@index');
            });
            Route::group(['prefix' => 'question', 'as' => 'question.'], function () {
                // 질문 index 페이지 데이터
                Route::get('/', 'Admin\Program\QuestionController@index')->name('index');
                // 질문 수정 페이지 데이터
                Route::get('{question}/edit', 'Admin\Program\QuestionController@edit')->name('edit');
                // 질문 업데이트 함수
                Route::post('{question}', 'Admin\Program\QuestionController@update')->name('update');
                //질문 답변 변경 함수
                Route::patch('{question}/status', 'Admin\Program\QuestionController@statusChange')->name('statusChange');
            });

            Route::group(['prefix'=>'notification', 'as' => 'notification.'], function(){
                Route::get('email/{program}','Admin\Program\NotificationController@email')->name('emailData');
                Route::get('sms/{program}','Admin\Program\NotificationController@sms')->name('smsData');
                Route::post('email','Admin\Program\NotificationController@sendEmail')->name('email');
                Route::post('sms','Admin\Program\NotificationController@sendSms')->name('sms');
                Route::post('id-email','Admin\Program\NotificationController@findIdWIthNameAndEmailInSendEmail')->name('findId.email');
                Route::post('id-phone','Admin\Program\NotificationController@findIdWithNameAndPhoneInSendSms')->name('findId.phone');
            });

            Route::group(['prefix' => 'excel', 'as'=>'excel.'],function(){
                Route::post('/','Admin\Program\ExcelController@export')->name('export');
            });
        });

        Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
            Route::get('/', 'Admin\Payment\PaymentController@index')->name('index');
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
