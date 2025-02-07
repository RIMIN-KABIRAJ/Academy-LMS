<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::controller(ChatController::class)->middleware(['auth'])->group(function () {
    Route::get('/message', 'message')->name('message');
    Route::get('/new_message', 'new_message')->name('new.message');
    Route::get('/chat/inbox/{reciver}/{product?}/', 'chat')->name('chat');

    Route::POST('/chat/save', 'chat_save')->name('chat.save');
    Route::get('chat/own/remove/{id}', 'remove_chat')->name('remove.chat');
    Route::POST('/my_message_react', 'react_chat')->name('react.chat');
    Route::get('/chat/profile/search/', 'search_chat')->name('search.chat');

    Route::get('/chat/inbox/load/data/ajax/', 'chat_load')->name('chat.load');
    Route::get('/chat/inbox/read/message/ajax/', 'chat_read_option')->name('chat.read');
});
