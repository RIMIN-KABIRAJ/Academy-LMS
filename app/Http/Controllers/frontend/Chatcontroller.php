<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\MessageThread;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class Chatcontroller extends Controller
{
    public function studentQuery(Request $request)
    {
        $data = $request->all();

        $message    = $data['message'];
        $receiver   = $data['receiver_id'];
        $sender     = auth()->user()->id;

        //check if the thread between those 2 users exists, if not create new thread
        $check = MessageThread::where('sender', $sender)->where('receiver', $receiver)->count();

        if ($check == 0) {
            $data_message_thread                        = new MessageThread();
            $message_thread_code                        = substr(md5(rand(100000000, 20000000000)), 0, 15);
            $data_message_thread['message_thread_code'] = $message_thread_code;
            $data_message_thread['sender']              = $sender;
            $data_message_thread['receiver']            = $receiver;
            $data_message_thread->save();
        } elseif ($check > 0) {
            $message_thread_code = MessageThread::where('sender', $sender)->where('receiver', $receiver)->value('message_thread_code');
        }

        $data_message = new Message();
        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['read_status']            = 0;
        $data_message->save();

        return redirect()->back();
    }

    function mark_thread_messages_read($message_thread_code)
    {
        // mark read only the oponnent messages of this thread, not currently logged in user's sent messages
        Message::where('sender', '!=', auth()->user()->id)
            ->where('message_thread_code', $message_thread_code)
            ->update([
                'read_status' => 1,
            ]);
    }

    public function agentMessage($param1 = '', $param2 = '')
    {
        if (empty($param1)) {
            $param1 = 'message_home';
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2;
            $this->mark_thread_messages_read($param2);
            $message_thread_details = MessageThread::where('message_thread_code', $param2)->first();
            $page_data['first_sender'] = $message_thread_details->sender;
            $page_data['sender'] = $message_thread_details->message_to_sender->name;
            $page_data['receiver'] = $message_thread_details->message_to_receiver->name;
            $page_data['messages'] = Message::where('message_thread_code', $param2)->get();
        } else {
            $page_data['current_message_thread_code'] = '';
        }

        $message_threads = MessageThread::where('sender', auth()->user()->id)
            ->get();



        $page_data['message_threads'] = $message_threads;
        $page_data['message_inner_page_name'] = $param1;
        $page_data['agent_messages'] = 'active';
        $page_data['navigation_name'] = 'Messaging with Agents';
        return view('frontend.my-courses.message', $page_data);
    }

    public function agentReplyMessage(Request $request, $param1 = '')
    {

        $data = $request->all();

        $message    = $data['message'];
        $sender     = auth()->user()->id;

        $data_message['message_thread_code']    = $param1;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['read_status']            = 0;

        Message::create($data_message);

        return redirect()->route('agentMessage', ['param1' => 'message_read', 'param2' => $param1]);
    }
}
