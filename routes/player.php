<?php

use App\Http\Controllers\ForumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::controller(PlayerController::class)->middleware('auth')->group(function () {
        Route::get('play-course/{slug}/{id?}', 'course_player')->name('course.player');
        Route::post('set-watch-history/', 'set_watch_history')->name('set.watch.history');
        Route::get('player/prepend/watermark', 'prepend_watermark')->name('player.prepend.watermark');
    });

    Route::controller(ForumController::class)->middleware('auth')->group(function () {
        Route::get('forum/questions', 'index')->name('forum.questions');
        Route::get('forum/question/create', 'create')->name('forum.question.create');
        Route::post('forum/question/store', 'store')->name('forum.question.store');
        Route::get('forum/question/delete/{id}', 'delete')->name('forum.question.delete');
        Route::get('forum/question/edit/', 'edit')->name('forum.question.edit');
        Route::post('forum/question/update/{id}', 'update')->name('forum.question.update');

        Route::get('forum/question/likes/{id}', 'likes')->name('forum.question.likes');
        Route::get('forum/question/dislikes/{id}', 'dislikes')->name('forum.question.dislikes');
        Route::get('forum/tab/active', 'tab_active')->name('forum.tab.active');

        Route::get('forum/question/reply/create', 'create_reply')->name('forum.question.reply.create');
        Route::post('forum/question/reply/store', 'store_reply')->name('forum.question.reply.store');
        Route::get('forum/question/reply/edit', 'edit_reply')->name('forum.question.reply.edit');
        Route::post('forum/question/reply/update/{id}', 'update_reply')->name('forum.question.reply.update');
    });
});
