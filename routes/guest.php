<?php

use App\Http\Controllers\frontend\AboutController;
use App\Http\Controllers\frontend\BlogController;
use App\Http\Controllers\frontend\BootcampController;
use App\Http\Controllers\frontend\ContactController;
use App\Http\Controllers\frontend\CourseController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\InstructorController;
use App\Http\Controllers\frontend\NewsletterController;
use App\Http\Controllers\frontend\TeamTrainingController;
use App\Http\Controllers\frontend\KnowledgeBaseTopicController;
use App\Models\Knowledge_base_topick;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
});

// course page
Route::controller(CourseController::class)->group(function () {
    Route::get('courses/{category?}', 'index')->name('courses');
    Route::get('change/layout', 'change_layout')->name('change.layout');
    Route::get('course/{slug}', 'course_details')->name('course.details');
});

// blogs page
Route::controller(BlogController::class)->middleware('blog.visibility')->group(function () {
    Route::get('blogs/{category?}', 'index')->name('blogs');
    Route::get('blog/{slug?}', 'blog_details')->name('blog.details');
    Route::get('blogs-list/{id}', 'blog_by_category')->name('blog.by.category');
});

// newsletter
Route::controller(NewsletterController::class)->group(function () {
    Route::post('newsletter/store', 'store')->name('newsletter.store');
});

// contact us
Route::controller(ContactController::class)->group(function () {
    Route::get('contact-us/', 'index')->name('contact.us');
    Route::post('contact/', 'store')->name('contact.store');
});

// about us
Route::controller(AboutController::class)->group(function () {
    Route::get('about-us/', 'index')->name('about.us');
});

// instructor details
Route::controller(InstructorController::class)->group(function () {
    Route::get('instructors', 'index')->name('instructors');
    Route::get('instructor-details/{name}/{id}', 'show')->name('instructor.details');
});

// privacy and policy
Route::get('/privacy-policy', function () {
    $view_path = 'frontend.' . get_frontend_settings('theme') . '.privacy_policy.index';
    return view($view_path);
})->name('privacy.policy');

// refund policy
Route::get('/refund-policy', function () {
    $view_path = 'frontend.' . get_frontend_settings('theme') . '.refund_policy.index';
    return view($view_path);
})->name('refund.policy');

//FAQ
Route::get('/faq', function () {
    $view_path = 'frontend.' . get_frontend_settings('theme') . '.faq.index';
    return view($view_path);
})->name('faq');

// terms and condition
Route::get('/terms-and-condition', function () {
    $view_path = 'frontend.' . get_frontend_settings('theme') . '.terms_and_condition.index';
    return view($view_path);
})->name('terms.condition');

Route::get('/cookie-policy', function () {
    $view_path = 'frontend.' . get_frontend_settings('theme') . '.cookie_policy.index';
    return view($view_path);
})->name('cookie.policy');

//Bootcamp
Route::controller(BootcampController::class)->group(function () {
    Route::get('bootcamp', 'index')->name('bootcamps');
    Route::get('bootcamp/{slug}', 'show')->name('bootcamp.details');
});

// team training
Route::controller(TeamTrainingController::class)->group(function () {
    Route::get('team-packages/{course_category?}', 'index')->name('team.packages');
    Route::get('team-package/{slug}', 'show')->name('team.package.details');
});

//knowledge base
Route::controller(KnowledgeBaseTopicController::class)->group(function () {
    Route::get('knowledge-base','index')->name('knowledge.base.topicks');
    Route::get('knowledge-base/article/{id}','show')->name('knowledge.base.article');
});