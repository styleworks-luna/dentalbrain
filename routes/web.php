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
use App\Http\Controllers\Admin\Banner\ProgramBannerController;
use App\Http\Controllers\Admin\Banner\TitleController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register');
// 로그인
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
// 로그아웃
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

/*============================ TESTING ============================*/

if (env('APP_ENV') != 'production') {
    Route::group(['prefix' => 'test', 'as' => 'test.'], function () {
        // 테스팅 계정 생성 // !! 삭제하지 말것 !!
        Route::get('register', 'Test\TestController@showRegistrationForm');
    });

    Route::group(['prefix' => 'dev', 'as' => 'dev.'], function () {
        Route::get('pretend/{user}', [\App\Http\Controllers\Development\DevelopmentController::class, 'pretend']);
    });

    Route::get("show", [\App\Http\Controllers\Development\DevelopmentController::class, 'show']);


    Route::group(['prefix' => 'albatalk', 'as' => 'albatalk.'], function () {

        Route::group(['prefix' => 'recruit', 'as' => 'recruit.'], function () {
            // 구인 등록 폼
            Route::get('/', [\App\Http\Controllers\Albatalk\Recruit\RecruitController::class, 'createForm'])->name('create')->middleware('auth');
            // 구인 등록
            Route::post('/', [\App\Http\Controllers\Albatalk\Recruit\RecruitController::class, 'saveRecruitDataToSession'])->name('create')->middleware('auth');
            // 구인 등록 결제 성공
            Route::get('/payment/success', [\App\Http\Controllers\Albatalk\Recruit\RecruitController::class, 'success'])->name('payment.success')->middleware('auth');

            Route::group(['prefix' => '{recruit}'], function () {
                // 구인 상세
                Route::get('/', [\App\Http\Controllers\Albatalk\Recruit\RecruitDetailController::class, 'detail'])->name('detail');

                Route::group(['middleware' => 'auth'], function () {
                    // 구인 제출자들의 이력서 pdf
                    Route::get('applied/{user}', [\App\Http\Controllers\Albatalk\Recruit\RecruitDetailController::class, 'pdf'])->name('pdf');
                    // 이력서 제출
                    Route::post('/', [\App\Http\Controllers\Albatalk\Recruit\RecruitDetailController::class, 'apply'])->name('apply');
                    // 이력서 취소
                    Route::post('/cancel', [\App\Http\Controllers\Albatalk\Recruit\RecruitDetailController::class, 'cancel'])->name('cancel');
                    // 구인 수정 폼
                    Route::get('edit', [\App\Http\Controllers\Albatalk\Recruit\RecruitController::class, 'edit'])->name('edit');
                    // 구인 수정
                    Route::post('edit', [\App\Http\Controllers\Albatalk\Recruit\RecruitController::class, 'update'])->name('edit');
                    // 구인 복사
                    Route::get('/duplicate', [\App\Http\Controllers\Albatalk\Recruit\RecruitController::class, 'duplicateForm'])->name('duplicate');
                });
            });

        });

        Route::group(['prefix' => 'resume', 'as' => 'resume.', 'middleware' => 'auth'], function () {
            // 이력서 생성 폼 or 자기 이력서 (= resume_complete.blade.php)
            Route::get('/', [\App\Http\Controllers\Albatalk\Resume\ResumeController::class, 'resumeIndex'])->name('index');
            // 이력서 등록
            Route::post('/', [\App\Http\Controllers\Albatalk\Resume\ResumeController::class, 'create'])->name('store');

            // 이력서 수정 폼
            Route::get('edit', [\App\Http\Controllers\Albatalk\Resume\ResumeController::class, 'edit'])->name('edit');
            // 이력서 수정
            Route::post('edit', [\App\Http\Controllers\Albatalk\Resume\ResumeController::class, 'update'])->name('update');
        });

        // 헤드 헌팅 리다이렉트
        Route::get('head-hunting', [\App\Http\Controllers\Albatalk\HeadHuntingController::class, 'index'])->name('head-hunting');

        // 알바톡(임시)
        Route::get('/', function () {
            return view(viewPrefix() . 'pages.albatalk.albatalk');
        });
    });

    Route::group(['prefix' => 'account', 'as' => 'account.', 'middleware' => 'auth'], function () {
        //구인 정보
        Route::get('albatalk', function () {
            return view(viewPrefix() . 'pages.user.mypage.mypage_albatalk_recruit');
        })->name('albatalk');

        //구직 정보
        Route::get('offer', function () {
            return view(viewPrefix() . 'pages.user.mypage.mypage_albatalk_resume_apply');
        })->name('offer');

        //구직 이력서 정보
        Route::get('resume', [\App\Http\Controllers\Account\ResumeController::class, 'mypageResume'])->name('resume');

        Route::get('recruit', [\App\Http\Controllers\Account\RecruitController::class, 'mypageRecruit'])->name('recruit');
    });

    Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
        Route::group(['prefix' => 'albatalk', 'as' => 'albatalk.'], function () {
            // 메인 구인공고 검색 API
            Route::get('search', [\App\Http\Controllers\Albatalk\Recruit\RecruitSearchController::class, 'search'])->name('search');

            Route::group(['prefix' => 'resume', 'as' => 'resume.', 'middleware' => 'auth'], function () {
                // 이력서 사진 업로드용
                Route::post('upload-thumbnail', [\App\Http\Controllers\Albatalk\AlbatalkFileController::class, 'uploadResume'])->name('image-upload');
            });
            Route::group(['prefix' => 'recruit', 'as' => 'recruit.', 'middleware' => 'auth'], function () {
                // 구인공고 사진 업로드용
                Route::post('upload-thumbnail', [\App\Http\Controllers\Albatalk\AlbatalkFileController::class, 'uploadRecruitThumbnail'])->name('image-upload');
                Route::post('editor/image', [\App\Http\Controllers\Albatalk\AlbatalkFileController::class, 'uploadRecruitEditorImage'])->name('editor.image-upload');
                Route::post('editor/file', [\App\Http\Controllers\Albatalk\AlbatalkFileController::class, 'uploadRecruitEditorFile'])->name('editor.file-upload');
            });
        });

        Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
            Route::group(['prefix' => 'head-hunting', 'as' => 'head-hunting.'], function () {
                Route::get('', [\App\Http\Controllers\Admin\Albatalk\HeadHuntingController::class, 'index'])->name('index');
                Route::post('', [\App\Http\Controllers\Admin\Albatalk\HeadHuntingController::class, 'create'])->name('create');
            });
            Route::group(['prefix' => 'recruit-price', 'as' => 'recruit-price.'], function () {
                Route::get('', [\App\Http\Controllers\Admin\Albatalk\RecruitPriceController::class, 'index'])->name('index');
                Route::post('normal', [\App\Http\Controllers\Admin\Albatalk\RecruitPriceController::class, 'updateNormal'])->name('update.normal');
                Route::post('membership', [\App\Http\Controllers\Admin\Albatalk\RecruitPriceController::class, 'updateMembership'])->name('update.membership');
            });
            Route::group(['prefix' => 'resume', 'as' => 'resume.'], function () {
                Route::get('', [\App\Http\Controllers\Admin\Albatalk\ResumeController::class, 'search'])->name('search');
                Route::group(['prefix' => '{resume}'], function () {
                    Route::get('pdf', [\App\Http\Controllers\Admin\Albatalk\ResumeController::class, 'detailPdf'])->name('detail');
                });

            });
        });

        Route::group(['prefix' => 'account', 'as' => 'account.', 'middleware' => 'auth'], function () {
            // 구인 등록 보기
            Route::get('recruit', [\App\Http\Controllers\Account\RecruitController::class, 'index'])->name('recruit');
            Route::get('applied-resume', [\App\Http\Controllers\Account\ResumeController::class, 'appliedResumeList'])->name('applied-resume');
        });
    });
}

/*============================ PAGES ============================*/

// 메인 페이지
Route::get('/', 'Main\MainController@index');

//마이페이지 아이디 비밀번호 찾기 (임시)
// TODO: route 변경
Route::get('find', function () {
    return view('desktop.pages.user.find_id');
});

//모바일  아이디 비밀번호 찾기 (임시)
// TODO: route 변경
Route::get('m-find', function () {
    return view('mobile.pages.user.find_id');
});
Route::get('m-find-ps', function () {
    return view('mobile.pages.user.find_password');
});
// 모바일 검색 창
Route::get('m-search', function () {
    return view('mobile.pages.search.search');
});

//회사 소개 (임시)
Route::get('introduce', function () {
    return view(viewPrefix() . 'pages.introduce.about_us');
});

// 커뮤니티
Route::group(['prefix' => 'community', 'as' => 'community.'], function () {
    Route::get('/', 'ArticleController@index')->name('index');
});


//강사 소개
Route::get('instructor', function () {
    return view(viewPrefix() . 'pages.introduce.instructor');
});

// 이용 약관
Route::get('service', function () {
    return view('desktop.pages.term.service');
})->name('service');

Route::get('privacy', function () {
    return view('desktop.pages.term.privacy');
})->name('privacy');

Route::get('refund', function () {
    return view('desktop.pages.term.refund');
})->name('refund');

// 배너 연결 링크
Route::get('banner-redirect/{banner}/', 'Main\BannerController@redirectToLink')->name('banner-redirect');

Route::group(['prefix' => 'membership', 'as' => 'membership.'], function () {
    Route::get('/', [\App\Http\Controllers\Membership\MembershipController::class, 'apply'])->name('index');
    Route::group(['prefix' => 'payment', 'middleware' => 'auth',], function () {
        // 결제 성공 연결
        Route::get('/payment/success', [\App\Http\Controllers\Membership\PaymentController::class, 'success'])->name('paymentSuccess');
        // 결제 성공 연결
        Route::post('/payment/another', [\App\Http\Controllers\Membership\PaymentController::class, 'anotherPay'])->name('paymentAnother');
        // 결제 결과
        Route::get('/payment/result', [\App\Http\Controllers\Membership\MembershipController::class, 'result'])->name('paymentResult');
    });

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
    })->name("index");

    // 강의 검색
    Route::get('/search', function () {
        return view(viewPrefix() . 'pages.lecture.lecture_search');
    })->name("search");

    Route::group(['prefix' => '{program}'], function () {
        //강의 상세
        Route::get('/', [\App\Http\Controllers\Lecture\DetailController::class, 'detail'])->name('detail');
        // 강의 신청
        Route::group(['middleware' => 'auth'], function () {
            // 강의 신청 폼
            Route::get('apply', [\App\Http\Controllers\Lecture\ApplyController::class, 'showApplyForm'])->name('apply.form');
            // 강의 신청
            Route::post('apply', [\App\Http\Controllers\Lecture\ApplyController::class, 'apply'])->name('apply');
            // 강의 계좌입금
            Route::post('another', [\App\Http\Controllers\Lecture\ApplyController::class, 'anotherPay'])->name('anotherPay');
            // 강의 결제 폼
            Route::get('payment', [\App\Http\Controllers\Lecture\PaymentsController::class, 'showPaymentForm'])->name('payment.form');
            // 강의 결제 성공
            Route::get('success', [\App\Http\Controllers\Lecture\PaymentsController::class, 'success'])->name('payment.success');
            // 강의 신청 성공
            Route::get('result', [\App\Http\Controllers\Lecture\ApplyController::class, 'result'])->name('result');
            // 강의 시청
            Route::get('watch/{lecture?}', 'Lecture\WatchController@watch')->name('watch');
            // 강의 시청 확인
            Route::patch('watched/{lecture?}', 'Lecture\WatchController@watched')->name('check-watch');
        });
        Route::get('excel', 'Admin\Program\ExcelController@export')->name('excel')->middleware('admin');
    });
});

Route::group(['prefix' => 'account', 'as' => 'account.', 'middleware' => 'auth'], function () {
    Route::redirect('/', '/account/lectures')->name('index');
    // 신청한 강의
    Route::get('lectures', 'Account\ProgramController@index')->name('lectures');
    Route::group(['prefix' => 'lectures/{program}', 'as' => 'lectures.'], function () {
        Route::get('/', 'Lecture\EditController@showEditForm')->name('edit');
        Route::post('/', 'Lecture\EditController@update')->name('update');
    });
    // 찜 강의 내역
    Route::get('like', function () {
        return view(viewPrefix() . 'pages.user.mypage.mypage_like');
    })->name('like');

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
    Route::view('/{any?}', 'admin.index')->where('any', '.*');;
});

Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
    Route::post('toss/deposited', 'Lecture\PaymentsController@deposited');

    Route::post('send-verification', 'Notification\PhoneVerificationController@sendVerificationNumber')->name('send-verification');

    Route::post('compare-verification', 'Notification\PhoneVerificationController@compareVerificationNumber')->name('compare-verification');

    Route::get('lecturesData', 'Account\ProgramController@lecturesData')->name('lecturesData');
    // 회원 아이디 중복체크
    Route::post('check-id', 'Account\FindIdController@checkIdDuplication')->name('check-id');

    Route::get('like-lectures', [\App\Http\Controllers\Account\LikeController::class, 'likeLectures'])->name('likes');

    Route::group(['prefix' => 'find', 'as' => 'find.'], function () {
        // 회원 아이디 찾기
        Route::post('id', 'Account\FindIdController@findIdWithNameAndPhone')->name('id');
        // 회원 비밀번호 찾기
        Route::post('password', 'Account\FindPasswordController@sendPasswordMail')->name('password');
    });

    Route::group(['prefix' => 'lectures', 'as' => 'lectures.'], function () {
        Route::get('/', 'Main\LectureController@index')->name('list');
        Route::get('categories', 'Main\LectureController@categories')->name('categories');
        Route::get('recommend', [\App\Http\Controllers\Main\RecommendLectureController::class, 'recommend'])->name('recommend');
        Route::post('{lecture}/save-progress', [\App\Http\Controllers\Lecture\WatchController::class, 'saveProgress'])->middleware('auth');
        Route::group(['prefix' => '{program}'], function () {

            Route::group(['middleware' => 'auth'], function () {
                // 유저 자동환불 신청
                Route::delete('cancel', 'Lecture\CancelController@cancel')->name('cancel');
                // 유저 수동환불 신청
                Route::delete('cancel-request', 'Lecture\CancelController@cancelRequest')->name('cancel-request');
            });

            Route::post('like', 'Lecture\DetailController@like');
            Route::get('download', 'Lecture\MaterialController@download')->name('download');

            Route::group(['prefix' => 'comments', 'as' => 'comments.', 'middleware' => 'auth'], function () {
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

    Route::group(['prefix' => 'articles', 'as' => 'articles'], function () {
        Route::get('/', 'ArticleController@articles')->name('list');
        Route::get('categories', 'ArticleController@categories')->name('categories');
        Route::get('{article}', 'ArticleController@view')->name('view');
        Route::post('{article}', 'ArticleController@like')->name('like');
    });

    Route::get('map/geocode', 'MapController@naver_map');
    Route::get('map/reverse-geocode', 'MapController@reverse_geocode');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
        Route::group(['prefix' => 'upload', 'as' => 'upload.'], function () {
            Route::post('file', [\App\Http\Controllers\Admin\FileController::class, 'uploadFile'])->name('file');
            Route::post('image', [\App\Http\Controllers\Admin\FileController::class, 'uploadImage'])->name('image');
        });
        Route::get('download/{file}', [\App\Http\Controllers\Admin\FileController::class, 'download'])->name('download');

        Route::post('email/upload', [\App\Http\Controllers\Admin\FileController::class, 'uploadMailImage']);
//        Route::post('email/upload-file', [\App\Http\Controllers\Admin\FileController::class, 'uploadMailFile']);

        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            //user index 페이지 데이터
            Route::get('/', 'Admin\User\UserController@index')->name('index');
            //user 수정 페이지 데이터
            Route::get('{user}/edit', 'Admin\User\UserController@edit')->name('edit');
            //user 업데이트 함수
            Route::put('{user}', 'Admin\User\UserController@update')->name('update');
            //user 직업 모두 가져오는 데이터
            Route::get('category', [\App\Http\Controllers\Admin\User\UserController::class, 'getUserJobNameCategory'])->name('getUserJobNameCategory');
            // user 검색 데이터
            Route::post('search', 'Admin\User\UserController@search')->name('search');
            //관리자 회원정보 상세 패스워드 변경 이메일 보내기
            Route::post('find/password/{user}', 'Account\FindPasswordController@sendPasswordMailWithUser')->name('sendPasswordMailWithUser');
            // 유저 엑셀 출력
            Route::get('export', [\App\Http\Controllers\Admin\User\UserController::class, 'userExport'])->name('export');

            Route::get('notification/email', [\App\Http\Controllers\Admin\User\UserController::class, 'emailList'])->name('notification.email');
            Route::get('notification/sms', [\App\Http\Controllers\Admin\User\UserController::class, 'smsList'])->name('notification.sms');
        });

        Route::group(['prefix' => 'membership', 'as' => 'membership.'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\Membership\MembershipController::class, 'index'])->name('index');
            // 유료 회원 엑셀 출력
            Route::get('export', [\App\Http\Controllers\Admin\Membership\MembershipController::class, 'membershipExport'])->name('export');

            Route::group(['prefix' => 'user/{user}'], function () {
                // 유료회원 상세 페이지 - 강의 신청 정보 통계 (수강중 XX건..)
                Route::get('/students/stat', [\App\Http\Controllers\Admin\Membership\MembershipDetailController::class, 'studentStat'])->name('students');
                // 유료회원 상세 페이지 - 강의 신청 정보
                Route::get('/students', [\App\Http\Controllers\Admin\Membership\MembershipDetailController::class, 'studentsHistories'])->name('students');
                // 유료회원 상세 페이지
                Route::get('/', [\App\Http\Controllers\Admin\Membership\MembershipDetailController::class, 'edit'])->name('edit');
                // 유료회원 상세 페이지 수정 완료
                Route::post('/', [\App\Http\Controllers\Admin\Membership\MembershipDetailController::class, 'update'])->name('update');
            });
            Route::group(['prefix' => '{membership}'], function () {
                // 유료 회원 결제 확인 ( 별도결제 )
                Route::post('confirm', [\App\Http\Controllers\Admin\Membership\MembershipController::class, 'confirmAnotherPay'])->name('confirm.anotherPay');
                // 유료 회원 결제 취소
                Route::post('cancel', [\App\Http\Controllers\Admin\Payment\MembershipCancelController::class, 'cancel'])->name('cancel');
            });

        });

        Route::group(['prefix' => 'lecture', 'as' => 'lecture.'], function () {
            // 강의 카테고리 리소스
            Route::get('categories', [\App\Http\Controllers\Admin\Program\BaseProgramController::class, 'getCategories'])->name('categories');
            // 강의 상세 내용 이미지 업로드
            Route::post('upload', [\App\Http\Controllers\Admin\FileController::class, 'uploadProgramDetailImage'])->name('upload');

            Route::group(['prefix' => 'online', 'as' => 'online.'], function () {
                // 온라인 강의 통계
                Route::get('/stat', [\App\Http\Controllers\Admin\Program\OnlineProgramController::class, 'stat'])->name('index');
                // 온라인 강의 리스트
                Route::get('/', [\App\Http\Controllers\Admin\Program\OnlineProgramController::class, 'index'])->name('index');
                // 온라인 강의 저장
                Route::post('/', 'Admin\Program\OnlineProgramController@store')->name('store');

                Route::group(['prefix' => '{program}'], function () {
                    // 온라인 강의 수정
                    Route::get('/', 'Admin\Program\OnlineProgramController@edit')->name('edit');
                    // 온라인 강의 업데이트
                    Route::put('/', 'Admin\Program\OnlineProgramController@update')->name('update');
                    // 온라인 강의 비공개/공개 전환
                    Route::patch('/', [\App\Http\Controllers\Admin\Program\BaseProgramController::class, 'changeOpen'])->name('changeOpen');
                    // 온라인 강의 삭제
                    Route::delete('/', [\App\Http\Controllers\Admin\Program\OnlineProgramController::class, 'delete'])->name('delete');
                    // 온라인 강의 복사 리소스
                    Route::get('/duplicate', 'Admin\Program\OnlineProgramController@duplicateEdit')->name('duplicate-edit');
                    // 온라인 강의 복사
                    Route::post('/duplicate', 'Admin\Program\OnlineProgramController@duplicate')->name('duplicate');

                    // 온라인 강의 수강생 관련
                    Route::group(['prefix' => 'students'], function () {
                        // 온라인 강의 수강생 목록
                        Route::get('', 'Admin\Program\OnlineStudentController@students')->name('students');
                        // 온라인 강의 수강 취소
                        Route::put('{student}/extend', [\App\Http\Controllers\Admin\Program\OnlineStudentController::class, 'extend'])->name('students.extend');
                        // 온라인 강의 수강 취소
                        Route::delete('{student}', 'Admin\Payment\CancelController@cancel')->name('students.cancel');
                        // 온라인 강의 계좌입금 확인
                        Route::patch('{student}', 'Admin\Payment\PaymentController@confirmAnotherPay')->name('students.confirm');
                    });
                });
            });
            Route::group(['prefix' => 'offline', 'as' => 'offline.'], function () {
                // 오프라인 강의 리스트
                Route::get('/', [\App\Http\Controllers\Admin\Program\OfflineProgramController::class, 'index'])->name('index');
                // 오프라인 강의 저장
                Route::post('/', 'Admin\Program\OfflineProgramController@store')->name('store');
                Route::group(['prefix' => '{program}'], function () {
                    // 오프라인 강의 수강생 리스트
                    Route::get('/students', 'Admin\Program\OfflineStudentController@students')->name('students');
                    // 오프라인 강의 수강 취소
                    Route::delete('students/{student}', 'Admin\Payment\CancelController@cancel')->name('students.cancel');
                    // 오프라인 강의 계좌입금 확인
                    Route::patch('students/{student}', 'Admin\Payment\PaymentController@confirmAnotherPay')->name('students.confirm');
                    // 오프라인 강의 수정
                    Route::get('/', 'Admin\Program\OfflineProgramController@edit')->name('edit');
                    // 오프라인 강의 업데이트
                    Route::put('/', 'Admin\Program\OfflineProgramController@update')->name('update');
                    // 오프라인 강의 비공개/공개 전환
                    Route::patch('/', [\App\Http\Controllers\Admin\Program\BaseProgramController::class, 'changeOpen'])->name('changeOpen');
                    // 오프라인 강의 복사 리소스
                    Route::get('/duplicate', 'Admin\Program\OfflineProgramController@duplicateEdit')->name('duplicate-edit');
                    // 오프라인 강의 복사
                    Route::post('/duplicate', 'Admin\Program\OfflineProgramController@duplicate')->name('duplicate');
                });
//                Route::delete('{program}', 'Admin\Program\OfflineProgramController@index');
            });

            Route::group(['prefix' => 'surveys', 'as' => 'surveys.'], function () {
                Route::get('{program}/{user}', 'Admin\Program\SurveyController@index')->name('index');
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

            Route::group(['prefix' => 'notification', 'as' => 'notification.'], function () {
                Route::get('email/{program}', 'Admin\Program\NotificationController@email')->name('emailData');
                Route::get('sms/{program}', 'Admin\Program\NotificationController@sms')->name('smsData');
                Route::post('email', 'Admin\Program\NotificationController@sendEmail')->name('email');
                Route::post('sms', 'Admin\Program\NotificationController@sendSms')->name('sms');
                Route::post('id-email', 'Admin\Program\NotificationController@findIdWIthNameAndEmailInSendEmail')->name('findId.email');
                Route::post('id-phone', 'Admin\Program\NotificationController@findIdWithNameAndPhoneInSendSms')->name('findId.phone');
            });
        });

        Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
            Route::get('/', 'Admin\Payment\PaymentController@index')->name('index');
            // 엑셀 출력
            Route::get('export', [\App\Http\Controllers\Admin\Payment\PaymentController::class, 'paymentExport'])->name('export');

            Route::post('/{program}/{student}/revert', [\App\Http\Controllers\Admin\Payment\CancelController::class, 'revert'])->name('revert');
        });

        Route::group(['prefix' => 'banner', 'as' => 'banners.'], function () {
            //배너 종류 데이터
            Route::get('category', 'Admin\Banner\BannerController@getBannerCategory')->name('getBannerCategory');
            //배너 클릭 횟수 올리고 링크로 이동
            Route::get('redirect/{banner}', 'Admin\Banner\BannerController@redirectToLink')->name('redirectToLink');
            //배너 index 페이지 데이터
            Route::get('/', 'Admin\Banner\BannerController@index')->name('index');
            //배너 생성 함수
            Route::post('/', 'Admin\Banner\BannerController@store')->name('store');
            //배너 수정 페이지 데이터
            Route::get('{banner}/edit', 'Admin\Banner\BannerController@edit')->name('edit');
            //배너 상태 변경 함수
            Route::patch('{banner}/status', 'Admin\Banner\BannerController@statusChange')->name('statusChange');
            //배너 업데이트 함수
            Route::put('{banner}', 'Admin\Banner\BannerController@update')->name('update');
            //배너 삭제 함수
            Route::delete('{banner}', 'Admin\Banner\BannerController@destroy')->name('destroy');
        });

        Route::group(['prefix' => 'program-banner', 'as' => 'program-banner.'], function () {
            //배너 종류 데이터
            Route::get('category', [ProgramBannerController::class, 'getBannerCategory'])->name('getBannerCategory');
            //배너 index 페이지 데이터 (검색)
            Route::get('/', [ProgramBannerController::class, 'index'])->name('index');
            //배너 생성 함수
            Route::post('/', [ProgramBannerController::class, 'store'])->name('store');
            //배너 상태 변경 함수
            Route::patch('{banner}/status', [ProgramBannerController::class, 'statusChange'])->name('statusChange');
            //배너 수정 페이지 데이터
            Route::get('{banner}', [ProgramBannerController::class, 'edit'])->name('edit');
            //배너 업데이트 함수
            Route::put('{banner}', [ProgramBannerController::class, 'update'])->name('update');
            //배너 삭제 함수
            Route::delete('{banner}', [ProgramBannerController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'title-banner', 'as' => 'title-banner.'], function () {
            // 배너 타이틀 보여주기
            Route::get('/', [TitleController::class, 'show'])->name('show');
            // 배너별 타이틀 수정하기
            Route::put('{bannerTitle}', [TitleController::class, 'update'])->name('update');
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
                // 검색
                Route::post('search', 'Admin\NoticeController@search')->name('search');
                // 공지사항 이미지 파일 업로드
                Route::post('upload/image', [\App\Http\Controllers\Admin\FileController::class, 'uploadNoticeImage'])->name('upload.image');
                // 공지사항 파일 업로드
                Route::post('upload/file', [\App\Http\Controllers\Admin\FileController::class, 'uploadNoticeFile'])->name('upload.file');
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

        Route::group(['prefix' => 'article', 'as' => 'article.'], function () {
            // 커뮤니티 (기사) index 페이지 데이터
            Route::get('/', 'Admin\ArticleController@index')->name('index');
            // 커뮤니티 (기사) 생성 함수
            Route::post('/', 'Admin\ArticleController@create')->name('create');
            // 커뮤니티 카테고리
            Route::get('/categories', 'Admin\ArticleController@categories')->name('categories');
            // 커뮤니티 이미지 파일 업로드
            Route::post('upload/image', 'Admin\FileController@uploadArticleImage')->name('upload.image');
            // 커뮤니티 파일 업로드
            Route::post('upload/file', 'Admin\FileController@uploadArticleFile')->name('upload.file');
            // 커뮤니티 (기사) 수정하기
            Route::get('{article}', 'Admin\ArticleController@edit')->name('edit');
            // 커뮤니티 (기사) 수정 반영
            Route::post('{article}', 'Admin\ArticleController@update')->name('update');
            // 커뮤니티 (기사) 삭제
            Route::delete('{article}', 'Admin\ArticleController@destroy')->name('destroy');
        });

        Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
            // 강의 질문 내역 데이터
            Route::get('question', [\App\Http\Controllers\Admin\Dashboard\LectureQuestionController::class, 'index'])->name('question');
            // 고객센터 문의 내역 데이터
            Route::get('inquiries', [\App\Http\Controllers\Admin\Dashboard\InquiryController::class, 'index'])->name('inquiries');


        });
    });
});
