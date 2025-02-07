<?php

use App\Http\Controllers\frontend\LanguageController;
use App\Http\Controllers\instructor\BlogController;
use App\Http\Controllers\instructor\BootcampController;
use App\Http\Controllers\instructor\BootcampLiveClassController;
use App\Http\Controllers\instructor\BootcampModuleController;
use App\Http\Controllers\instructor\BootcampResourceController;
use App\Http\Controllers\instructor\CourseController;
use App\Http\Controllers\instructor\DashboardController;
use App\Http\Controllers\instructor\LessonController;
use App\Http\Controllers\instructor\MyProfileController;
use App\Http\Controllers\instructor\PayoutController;
use App\Http\Controllers\instructor\PayoutSettingsController;
use App\Http\Controllers\instructor\QuestionController;
use App\Http\Controllers\instructor\QuizController;
use App\Http\Controllers\instructor\SalesReportController;
use App\Http\Controllers\instructor\SectionController;
use App\Http\Controllers\instructor\TeamTrainingController;
use App\Http\Controllers\instructor\OpenAiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::name('instructor.')->prefix('instructor')->middleware(['instructor'])->group(function () {
    // dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Courses route
    Route::controller(CourseController::class)->group(function () {
        Route::get('courses', 'index')->name('courses');
        Route::get('course/create', 'create')->name('course.create');
        Route::post('course/store', 'store')->name('course.store');
        Route::get('course/edit/{id}', 'edit')->name('course.edit');
        Route::post('course/update/{id}', 'update')->name('course.update');
        Route::get('course/duplicate/{id}', 'duplicate')->name('course.duplicate');
        Route::get('course/delete/{id}', 'delete')->name('course.delete');
        Route::get('course/draft/{id}', 'draft')->name('course.draft');
        Route::get('course/status/{type}/{id}', 'status')->name('course.status');

    });

    //Section route
    Route::controller(SectionController::class)->group(function () {
        Route::post('section/store', 'store')->name('section.store');
        Route::post('section/update', 'update')->name('section.update');
        Route::get('section/delete/{id}', 'delete')->name('section.delete');
        Route::post('section/sort', 'sort')->name('section.sort');
    });

    // Lesson route
    Route::controller(LessonController::class)->group(function () {
        Route::post('lesson/store', 'store')->name('lesson.store');
        Route::post('lesson/update', 'update')->name('lesson.update');
        Route::get('lesson/delete/{id}', 'delete')->name('lesson.delete');
        Route::post('lesson/sort', 'sort')->name('lesson.sort');
    });

    // course quiz
    Route::controller(QuizController::class)->group(function () {
        Route::post('course/quiz/store', 'store')->name('course.quiz.store');
        Route::get('course/quiz/delete/{id}', 'delete')->name('course.quiz.delete');
        Route::post('course/quiz/update/{id}', 'update')->name('course.quiz.update');
        Route::get('quiz/participant/result', 'result')->name('quiz.participant.result');
        Route::get('quiz/result/preview', 'result_preview')->name('quiz.result.preview');
    });

    // question route
    Route::controller(QuestionController::class)->group(function () {
        Route::post('course/question/store', 'store')->name('course.question.store');
        Route::get('course/question/delete/{id}', 'delete')->name('course.question.delete');
        Route::post('course/question/update/{id}', 'update')->name('course.question.update');
        Route::get('course/question/sort/', 'sort')->name('course.question.sort');

        Route::get('load/question/type/', 'load_type')->name('load.question.type');
    });

    // blog route
    Route::controller(BlogController::class)->middleware('instructorBlogPermission')->group(function () {
        Route::get('blogs', 'index')->name('blogs');
        Route::get('blog/create', 'create')->name('blog.create');
        Route::post('blog/store', 'store')->name('blog.store');
        Route::get('blog/edit/{id}', 'edit')->name('blog.edit');
        Route::post('blog/update/{id}', 'update')->name('blog.update');
        Route::get('blog/delete/{id}', 'delete')->name('blog.delete');
        Route::get('blog/pending', 'pending')->name('blog.pending');
    });

    // sales report
    Route::controller(SalesReportController::class)->group(function () {
        Route::get('sales-report', 'index')->name('sales.report');
    });
    //Open Ai 
    Route::controller(OpenAiController::class)->group(function () {
        Route::post('open-ai/generate', 'generate')->name('open.ai.generate');
    });

    // payout route
    Route::controller(PayoutController::class)->group(function () {
        Route::get('payout-reports', 'index')->name('payout.reports');
        Route::post('payout/request', 'store')->name('payout.request');
        Route::get('payout/request/delete/{id}', 'delete')->name('payout.delete');
    });

    //payout setting
    Route::controller(PayoutSettingsController::class)->group(function () {
        Route::get('payout_setting', 'payout_setting')->name('payout.setting');
        Route::post('payout_setting/store', 'payout_setting_store')->name('payout.setting.store');
    });

    //manage profile
    Route::controller(MyProfileController::class)->group(function () {
        Route::get('manage_profile', 'manage_profile')->name('manage.profile');
        Route::post('manage_profile/update', 'manage_profile_update')->name('manage.profile.update');
    });

    // bootcamp
    Route::controller(BootcampController::class)->group(function () {
        Route::get('bootcamps/', 'index')->name('bootcamps');
        Route::get('bootcamp/create', 'create')->name('bootcamp.create');
        Route::get('bootcamp/edit/{id}', 'edit')->name('bootcamp.edit');
        Route::post('bootcamp/store', 'store')->name('bootcamp.store');
        Route::get('bootcamp/delete/{id}', 'delete')->name('bootcamp.delete');
        Route::post('bootcamp/update/{id}', 'update')->name('bootcamp.update');
        Route::get('bootcamp/status/{id}', 'status')->name('bootcamp.status');
        Route::get('bootcamp/duplicate/{id}', 'duplicate')->name('bootcamp.duplicate');
        Route::get('bootcamp/purchase/history/', 'purchase_history')->name('bootcamp.purchase.history');
        Route::get('bootcamp/purchase/invoice/{id}', 'invoice')->name('bootcamp.purchase.invoice');
    });

    // bootcamp module
    Route::controller(BootcampModuleController::class)->group(function () {
        Route::post('bootcamp/module/store', 'store')->name('bootcamp.module.store');
        Route::get('bootcamp/module/delete/{id}', 'delete')->name('bootcamp.module.delete');
        Route::post('bootcamp/module/update/{id}', 'update')->name('bootcamp.module.update');
        Route::get('bootcamp/module/sort', 'sort')->name('bootcamp.module.sort');
    });

    // bootcamp live class
    Route::controller(BootcampLiveClassController::class)->group(function () {
        Route::post('bootcamp/live-class/store', 'store')->name('bootcamp.live.class.store');
        Route::get('bootcamp/live-class/delete/{id}', 'delete')->name('bootcamp.live.class.delete');
        Route::post('bootcamp/live-class/update/{id}', 'update')->name('bootcamp.live.class.update');
        Route::get('bootcamp/live-class/sort', 'sort')->name('bootcamp.live.class.sort');

        Route::get('bootcamp/live/class/join/{topic}', 'join_class')->name('bootcamp.live.class.join');
        Route::get('bootcamp/live/class/end/{id}', 'stop_class')->name('bootcamp.class.end');
        Route::get('update/on/class/end/', 'update_on_end_class')->name('update.on.end.class');
    });

    // bootcamp resource
    Route::controller(BootcampResourceController::class)->group(function () {
        Route::post('bootcamp/resource/store', 'store')->name('bootcamp.resource.store');
        Route::get('bootcamp/resource/delete/{id}', 'delete')->name('bootcamp.resource.delete');
        Route::get('bootcamp/resource/download/{id}', 'download')->name('bootcamp.resource.download');
    });

    // team training
    Route::controller(TeamTrainingController::class)->group(function () {
        Route::get('team-packages', 'index')->name('team.packages');
        Route::view('team-packages/create', 'instructor.team_training.create')->name('team.packages.create');
        Route::post('team-packages/store', 'store')->name('team.packages.store');
        Route::get('team-packages/purchase/history', 'purchase_history')->name('team.packages.purchase.history');

        Route::middleware(['record.exists:team_training_packages,id,user_id'])->group(function () {
            Route::get('team-packages/edit/{id}', 'edit')->name('team.packages.edit');
            Route::post('team-packages/update/{id}', 'update')->name('team.packages.update');
            Route::get('team-packages/delete/{id}', 'delete')->name('team.packages.delete');
            Route::get('team-packages/duplicate/{id}', 'duplicate')->name('team.packages.duplicate');
            Route::get('team-packages/toggle-status/{id}', 'toggle_status')->name('team.toggle.status');
            Route::get('team-packages/purchase/invoice/{id}', 'invoice')->name('team.packages.purchase.invoice');
        });

        Route::get('get-courses-by-privacy/', 'get_courses')->name('get.courses.by.privacy');
        Route::get('get-courses-price/', 'get_course_price')->name('get.course.price');
    });

});

Route::get('instructor/select-language/{language}', [LanguageController::class, 'select_lng'])->name('instructor.select.language');
