<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message_thrade;
use App\Models\User;
use App\Models\FileUploader;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ChatController extends Controller
{

    public function message()
    {
        return view('frontend.my-courses.message');
    }

    public function new_message()
    {
        return view('frontend.my-courses.new_message_form');
    }
    public function chat($reciver, $product = null)
    {
        $user_id  = auth()->user()->id;
        $messageThrade = Message_thrade::where(function ($query) use ($reciver, $user_id) {
            $query->where('sender_id', $reciver)
                ->where('reciver_id', $user_id);
        })->orWhere(function ($query) use ($reciver, $user_id) {
            $query->where('sender_id', $user_id)
                ->where('reciver_id', $reciver);
        })->first();

        $reciver_data = User::find($reciver);
        if (!empty($messageThrade)) {
            Chat::where('message_thrade', $messageThrade->id)->where('reciver_id', $reciver)->where('read_status', '0')->update(['read_status' => '1']);
            $message = Chat::where('message_thrade', $messageThrade->id)->orderBy('id', 'DESC')->limit('20')->get();
        } else {
            $message = [];
        }
        if (isset($product) && $product != null) {
            $product_url = url('/') . '/product/view/' . $product;
        } else {
            $product_url = null;
        }
        $previousChatList = Message_thrade::where('reciver_id', auth()->user()->id)->orWhere('sender_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        return view('frontend.chat.index', compact('reciver_data', 'message', 'previousChatList', 'product_url', 'product'));
    }

    public function chat_save(Request $request)
    {
        $reciver = $request->reciver_id;
        $user_id = auth()->user()->id;

        $firstmessageThrade = Message_thrade::where(function ($query) use ($reciver, $user_id) {
            $query->where('sender_id', $reciver)
                ->where('reciver_id', $user_id);
        })->orWhere(function ($query) use ($reciver, $user_id) {
            $query->where('sender_id', $user_id)
                ->where('reciver_id', $reciver);
        })
            ->first();


        $messageThradeCount = Message_thrade::where(function ($query) use ($reciver, $user_id) {
            $query->where('sender_id', $reciver)
                ->where('reciver_id', $user_id);
        })->orWhere(function ($query) use ($reciver, $user_id) {
            $query->where('sender_id', $user_id)
                ->where('reciver_id', $reciver);
        })
            ->count();

        if ($messageThradeCount <= 0) {
            $messageThrade = new Message_thrade();
            $messageThrade->sender_id = auth()->user()->id;
            $messageThrade->reciver_id = $request->reciver_id;
            $messageThrade->chatcenter = $request->messagecenter;
            $done = $messageThrade->save();
            if ($done) {
                $chat = new Chat();
                $chat->reciver_id = $request->reciver_id;
                $chat->sender_id = auth()->user()->id;
                $chat->chatcenter = $request->messagecenter;
                $chat->message = $request->message;
                $chat->message_thrade = $messageThrade->id;

                $chat->file = '1';
                $chat->save();
                $last_chat_id = $chat->id;

                if (is_array($request->multiple_files) && $request->multiple_files[0] != null) {
                    //Data validation
                    $rules = array('multiple_files' => 'mimes:jpeg,jpg,png,gif,jfif,mp4,mov,wmv,mkv,webm,avi');
                    $validator = Validator::make($request->multiple_files, $rules);
                    if ($validator->fails()) {
                        return json_encode(array('validationError' => $validator->getMessageBag()->toArray()));
                    }

                    foreach ($request->multiple_files as $key => $media_file) {
                        $file_name = random(40);
                        $file_extention = strtolower($media_file->getClientOriginalExtension());
                        if ($file_extention == 'avi' || $file_extention == 'mp4' || $file_extention == 'webm' || $file_extention == 'mov' || $file_extention == 'wmv' || $file_extention == 'mkv') {
                            FileUploader::upload($media_file, 'uploads/chat/videos/' . $file_name . '.' . $file_extention);
                            $file_type = 'video';
                        } else {
                            FileUploader::upload($media_file, 'uploads/chat/images/' . $file_name, 1000, null, 300);
                            $file_type = 'image';
                        }
                        $file_name = $file_name . '.' . $file_extention;


                        $media_file_data = array('user_id' => auth()->user()->id, 'chat_id' => $last_chat_id, 'file_name' => $file_name, 'file_type' => $file_type, 'privacy' => 'public');
                        $media_file_data['created_at'] = time();
                        $media_file_data['updated_at'] = $media_file_data['created_at'];
                    }
                }
                $page_data['message'] = Chat::where('message_thrade', $messageThrade->id)->orderBy('id', 'DESC')->limit('1')->get();
                return  view('frontend.my-courses.message', $page_data);
            }
        } else {
            $chat = new Chat();
            $chat->reciver_id = $request->reciver_id;
            $chat->sender_id = auth()->user()->id;
            $chat->chatcenter = $request->messagecenter;
            $chat->message = $request->message;
            $chat->message_thrade = $firstmessageThrade->id;

            $chat->file = '1';
            $chat->save();
            $last_chat_id = $chat->id;

            if (is_array($request->multiple_files) && $request->multiple_files[0] != null) {
                //Data validation
                $rules = array('multiple_files' => 'mimes:jpeg,jpg,png,gif,jfif,mp4,mov,wmv,mkv,webm,avi');
                $validator = Validator::make($request->multiple_files, $rules);
                if ($validator->fails()) {
                    return json_encode(array('validationError' => $validator->getMessageBag()->toArray()));
                }

                foreach ($request->multiple_files as $key => $media_file) {
                    $file_name = random(40);
                    $file_extention = strtolower($media_file->getClientOriginalExtension());
                    if ($file_extention == 'avi' || $file_extention == 'mp4' || $file_extention == 'webm' || $file_extention == 'mov' || $file_extention == 'wmv' || $file_extention == 'mkv') {
                        FileUploader::upload($media_file, 'uploads/chat/videos/' . $file_name . '.' . $file_extention);
                        $file_type = 'video';
                    } else {
                        FileUploader::upload($media_file, 'uploads/chat/images/' . $file_name, 1000, null, 300);
                        $file_type = 'image';
                    }
                    $file_name = $file_name . '.' . $file_extention;


                    $media_file_data = array('user_id' => auth()->user()->id, 'chat_id' => $last_chat_id, 'file_name' => $file_name, 'file_type' => $file_type, 'privacy' => 'public');

                    $media_file_data['chat_id'] = $chat->id;
                    $media_file_data['created_at'] = time();
                    $media_file_data['updated_at'] = $media_file_data['created_at'];
                }
            }
            $page_data['message'] = Chat::where('message_thrade', $firstmessageThrade->id)->orderBy('id', 'DESC')->limit('1')->get();
            return view('frontend.my-courses.message', $page_data);
        }
    }
}
