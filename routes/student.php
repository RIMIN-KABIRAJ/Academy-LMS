<?php

use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\LanguageController;
use App\Http\Controllers\student\BecomeInstructorController;
use App\Http\Controllers\student\BlogCommentController;
use App\Http\Controllers\student\BlogController;
use App\Http\Controllers\student\BootcampPurchaseController;
use App\Http\Controllers\student\CartController;
use App\Http\Controllers\student\InvoiceController;
use App\Http\Controllers\student\LiveClassController;
use App\Http\Controllers\student\MessageController;
use App\Http\Controllers\student\MyBootcampsController;
use App\Http\Controllers\student\MyCoursesController;
use App\Http\Controllers\student\MyProfileController;
use App\Http\Controllers\student\MyTeamPackageController;
use App\Http\Controllers\student\OfflinePaymentController;
use App\Http\Controllers\student\PurchaseController;
use App\Http\Controllers\student\QuizController;
use App\Http\Controllers\student\ReviewController;
use App\Http\Controllers\student\WishListController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    // my profile routes
    Route::controller(MyProfileController::class)->group(function () {
        Route::get('my-profile', 'index')->name('my.profile');
        Route::post('my-profile/update/{user_id}', 'update')->name('update.profile');
        Route::post('update-profile-picture', 'update_profile_picture')->name('update.profile.picture');
    });

    // my wishlist routes
    Route::controller(WishListController::class)->group(function () {
        Route::get('wishlist', 'index')->name('wishlist');
        Route::get('toggleWishItem/{course_id?}', 'toggleWishItem')->name('toggleWishItem');
    });

    // my course routes
    Route::controller(MyCoursesController::class)->group(function () {
        Route::get('my-courses', 'index')->name('my.courses');
    });

    // quiz routes
    Route::controller(QuizController::class)->group(function () {
        Route::post('quiz/submit/{id}', 'quiz_submit')->name('quiz.submit');
        Route::get('load/quiz/result/', 'load_result')->name('load.quiz.result');
        Route::get('load/quiz/questions/', 'load_questions')->name('load.quiz.questions');
    });

    // purchase routes
    Route::controller(PurchaseController::class)->group(function () {
        Route::get('purchase/course/{course_id}', 'purchase_course')->name('purchase.course');
        Route::post('payout', 'payout')->name('payout');
        Route::get('purchase-history', 'purchase_history')->name('purchase.history');
        Route::get('invoice/{id}', 'invoice')->name('invoice');
    });

    // cart routes
    Route::controller(CartController::class)->group(function () {
        Route::any('cart', 'index')->name('cart');
        Route::get('cart/store/{id}', 'store')->name('cart.store');
        Route::get('cart/delete/{id}', 'delete')->name('cart.delete');
    });

    // review routes
    Route::controller(ReviewController::class)->group(function () {
        Route::post('review/store', 'store')->name('review.store');
        Route::get('review/edit/', 'edit')->name('review.edit');
        Route::get('review/delete/{id}', 'delete')->name('review.delete');
        Route::post('review/update/{id}', 'update')->name('review.update');
        Route::get('review/like/{id}', 'like')->name('review.like');
        Route::get('review/dislike/{id}', 'dislike')->name('review.dislike');
    });

    // blog
    Route::controller(BlogController::class)->middleware('blog.visibility')->group(function () {
        Route::get('/blog-like', 'blog_like')->name('blog.like');
    });

    // blog comment
    Route::controller(BlogCommentController::class)->middleware('blog.visibility')->group(function () {
        Route::post('/blog/comment/store', 'store')->name('blog.comment.store');
        Route::get('/blog/comment/delete/{id}', 'delete')->name('blog.comment.delete');
        Route::post('/blog/comment/update/{id}', 'update')->name('blog.comment.update');
    });

    // message
    Route::controller(MessageController::class)->group(function () {
        Route::get('/message', 'index')->name('message');
        Route::post('/message/store', 'store')->name('message.store');
        Route::get('/message/fetch', 'fetch_message')->name('message.fetch');
        Route::post('/message/search/student', 'search_student')->name('search.student');
        Route::get('/message/inbox/{user_id}', 'inbox')->name('message.inbox');
    });

    // become instructor
    Route::controller(BecomeInstructorController::class)->group(function () {
        Route::get('/become-an-instructor', 'index')->name('become.instructor');
        Route::post('/become-an-instructor/store', 'store')->name('become.instructor.store');
    });

    // live class
    Route::controller(LiveClassController::class)->group(function () {
        Route::get('live-class/join/{id}', 'live_class_join')->name('live.class.join');
    });

    // my bootcamp routes
    Route::controller(MyBootcampsController::class)->group(function () {
        Route::get('my-bootcamps/', 'index')->name('my.bootcamps');
        Route::get('my-bootcamps/details/{slug?}', 'show')->name('my.bootcamp.details');
        Route::get('bootcamp/live/class/join/{topic}', 'join_class')->name('bootcamp.live.class.join');
        Route::get('bootcamp/resource/download/{id}', 'download')->name('bootcamp.resource.download');
        Route::get('bootcamp/resource/play/{file}', 'play')->name('bootcamp.resource.play');
    });

    // purchase bootcamp routes
    Route::controller(BootcampPurchaseController::class)->group(function () {
        Route::get('purchase/bootcamp/{id}', 'purchase')->name('purchase.bootcamp');
        Route::get('bootcamp/purchase/history', 'purchase_history')->name('bootcamp.purchase.history');
        Route::get('bootcamp/invoice/{id}', 'invoice')->name('bootcamp.invoice');
    });

    // my team packages
    Route::controller(MyTeamPackageController::class)->group(function () {
        Route::get('my-team-packages/', 'index')->name('my.team.packages');
        Route::get('my-team-packages/details/{slug}', 'show')->name('my.team.packages.details')
            ->middleware('record.exists:team_training_packages,slug');
        Route::get('my-team-packages/search/members/{package_id?}', 'search_members')->name('search.package.members');
        Route::get('my-team-packages/{action}/members', 'member_action')->name('my.team.packages.members.action');
        Route::get('purchase/team-package/{id}', 'purchase')->name('purchase.team.package');
        Route::get('my-team-packages/invoice/{id}', 'invoice')->name('team.package.invoice')
            ->middleware('record.exists:team_package_purchases,id');
    });

});

//Certificate download
Route::get('certificate/{identifier}', [HomeController::class, 'download_certificate'])->name('certificate');

// offline payment
Route::post('payment/offline/store', [OfflinePaymentController::class, 'store'])->name('payment.offline.store');

// select language
Route::get('select/language/', [LanguageController::class, 'select_lng'])->name('select.lng');
