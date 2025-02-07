<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\MessageThread;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller
{
    public function message($message_thread_code = "")
    {
        $page_data['thread_code']    = $message_thread_code;
        $page_data['thread_details'] = MessageThread::where('code', $message_thread_code)->first();
        $contact = MessageThread::where('contact_one', auth()->user()->id)->orWhere('contact_two', auth()->user()->id)->count();

        if (!$message_thread_code) {
            $thread = MessageThread::latest('id')->value('code');

            if ($contact > 0) {
                return redirect()->route('admin.message', $thread);
            }
        } else {
            Message::where('thread_id', $page_data['thread_details']->id)->where('read', '!=', '1')->update(['read' => 1]);
        }

        return view('admin.message.message', $page_data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message'     => 'required',
            'sender_id'   => 'required|integer|exists:App\Models\User,id',
            'receiver_id' => 'required|integer|exists:App\Models\User,id',
            'thread_id'   => 'required|integer',
        ]);

        $data['message']     = $request->message;
        $data['sender_id']   = $request->sender_id;
        $data['receiver_id'] = $request->receiver_id;
        $data['thread_id']   = $request->thread_id;
        $data['created_at']  = date('Y-m-d H:i:s');
        $data['read']        = null;

        Message::insert($data);
        MessageThread::where('id', $request->thread_id)->update(['updated_at' => date('Y-m-d H:i:s')]);

        $message_thread = MessageThread::find($request->thread_id)->code;

        Session::flash('success', get_phrase('Your message successfully has been sent'));
        return redirect(route('admin.message', ['message_thread' => $message_thread]));
    }

    public function thread_store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|integer|exists:App\Models\User,id',
        ]);

        $auth       = auth()->user()->id;
        $user_id    = $request->receiver_id;
        $has_thread = MessageThread::where(function ($query) use ($auth, $user_id) {
            $query->where('contact_one', $auth)->where('contact_two', $user_id);
        })
            ->orWhere(function ($query) use ($auth, $user_id) {
                $query->where('contact_one', $user_id)->where('contact_two', $auth);
            })
            ->first();

        $thread = $has_thread ? $has_thread->code : random(20);

        if (!$has_thread) {
            $data['contact_one'] = auth()->user()->id;
            $data['contact_two'] = $request->receiver_id;
            $data['code']        = $thread;
            $data['created_at']  = date('Y-m-d H:i:s');
            MessageThread::insert($data);
            Session::flash('success', get_phrase('Message thread successfully created'));
        }

        return redirect(route('admin.message', ['message_thread' => $thread]));
    }

    public function searchThreads(Request $request)
    {
        $user_id_arr = array();
        $user_id     = $request->user()->id; // Assuming you're using Laravel's authentication
        $search      = $request->input('search');

        $users = User::where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%')->limit(50)->get();
        foreach ($users as $users) {
            $user_id_arr[] = $users->id;
        }

        $messageThreads = MessageThread::where(function ($query) use ($user_id_arr) {
            $query->whereIn('sender', $user_id_arr)->where('receiver', auth()->user()->id);
        })
            ->orWhere(function ($query) use ($user_id_arr) {
                $query->whereIn('receiver', $user_id_arr)->where('sender', auth()->user()->id);
            })
            ->get();

        $page_data['message_threads'] = $messageThreads;
        $page_data['search']          = $search;
        $page_data['thread']          = $request->thread;

        return view('admin.message.message_left_side_bar', $page_data);
    }
}
