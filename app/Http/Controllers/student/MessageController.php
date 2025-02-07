<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\FileUploader;
use App\Models\MediaFile;
use App\Models\Message;
use App\Models\MessageThread;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set("Asia/Dhaka");
    }
    public function index()
    {
        $contacts = Message::where('sender_id', auth()->user()->id)
            ->orWhere('receiver_id', auth()->user()->id)
            ->latest('id')
            ->pluck('sender_id', 'receiver_id')
            ->toArray();

        // if url has any thread then get all conversations by that thread
        $conversations = [];
        if (request()->has('inbox') && !empty(request()->query('inbox'))) {
            $thread        = request()->query('inbox');
            $conversations = Message::join('message_threads', 'messages.thread_id', '=', 'message_threads.id')
                ->select('messages.*', 'message_threads.code')
                ->where('message_threads.code', $thread)
                ->get();
        } elseif (request()->has('instructor') && !empty(request()->query('instructor'))) {
            $new_thread = Str::random(25);
            $instructor_id = request()->query('instructor');

            $check_thread = MessageThread::where(function ($query) use ($instructor_id) {
                $query->where('contact_one', auth()->user()->id)->where('contact_two', $instructor_id);
            })
                ->orWhere(function ($query) use ($instructor_id) {
                    $query->where('contact_two', auth()->user()->id)->where('contact_one', $instructor_id);
                })->count();


            if ($check_thread == 0) {
                // create a new thread and redirect
                $data['code']        = $new_thread;
                $data['contact_one'] = auth()->user()->id;
                $data['contact_two'] = request()->query('instructor');
                MessageThread::insert($data);

                return redirect(route('message', ['inbox' => $new_thread, 'instructor' => $instructor_id]));
            }
        }



        $enrollments    = Enrollment::where('user_id', auth()->user()->id)->get();
        $my_instructors = array();
        foreach ($enrollments as $enrollment) :
            $course_details = Course::where('id', $enrollment->course_id)->first();
            foreach (json_decode($course_details->instructors, true) ?? array() as $instructor_id) {
                if (!in_array($instructor_id, $my_instructors)) {
                    $my_instructors[] = $instructor_id;
                }
            }
            if (!in_array($course_details->user_id, $my_instructors)) {
                $my_instructors[] = $course_details->user_id;
            }
        endforeach;
        $page_data['my_instructor_ids'] = $my_instructors;

        $page_data['contacts']      = array_keys($contacts);

        $page_data['message_threads']      = MessageThread::where('contact_one', auth()->user()->id)->where('contact_two', auth()->user()->id)->get();
        $page_data['conversations'] = $conversations;
        $view_path                  = 'frontend.' . get_frontend_settings('theme') . '.student.message.index';
        return view($view_path, $page_data);
    }

    public function store(Request $request)
    {
        if (empty($request->message) && !$request->media_files) {
            return redirect()->back();
        }

        $data['sender_id']   = auth()->user()->id;
        $data['receiver_id'] = $request->receiver_id;
        $data['thread_id']   = $request->thread;
        $data['message']     = $request->message;
        $data['read']     = 0;

        Message::insert($data);
        MessageThread::where('id', $request->thread)->update(['updated_at' => date('Y-m-d H:i:s')]);
        $conversation = Message::latest()->first();

        // upload media files
        if ($request->media_files) {
            $thread_code = MessageThread::where('id', $request->thread)->value('code');
            $files       = $request->media_files;

            foreach ($files as $file) {
                $mimeType  = $file->getClientMimeType();
                $mimeType  = explode('/', $mimeType);
                $file_type = $mimeType[0];

                if (in_array($file_type, ['image', 'video'])) {
                    $file_name = Str::random(20) . '.' . $file->extension();
                    FileUploader::upload($file, 'uploads/message/' . $thread_code . '/' . $file_name, null, null, 300);

                    $media['chat_id']   = $conversation->id;
                    $media['file_name'] = $file_name;
                    $media['file_type'] = $file_type;

                    MediaFile::insert($media);
                }
            }
        }
        Session::flash('success', get_phrase('Message sent successfully.'));
        return redirect()->back();
    }

    public function fetch_message(Request $request)
    {
        $conversations = Message::where('thread_id', $request->thread)->get();
        return view('frontend.default.student.message.body', compact('conversations'));
    }

    public function search_student(Request $request)
    {
        $page_data['user_details'] = User::where('email', $request->search_mail)->first();
        $view_path                 = 'frontend.' . get_frontend_settings('theme') . '.student.message.search_result';
        return view($view_path, $page_data);
    }

    public function inbox($user_id)
    {
        // check if any thread code exists or not
        $auth       = auth()->user()->id;
        $has_thread = MessageThread::where(function ($query) use ($auth, $user_id) {
            $query->where('contact_one', $auth)->where('contact_two', $user_id);
        })
            ->orWhere(function ($query) use ($auth, $user_id) {
                $query->where('contact_one', $user_id)->where('contact_two', $auth);
            })
            ->first();

        $thread = $has_thread ? $has_thread->code : Str::random(20);

        // create a new thread and redirect
        if (!$has_thread) {
            $data['code']        = $thread;
            $data['contact_one'] = $auth;
            $data['contact_two'] = $user_id;

            MessageThread::insert($data);
        }
        return redirect()->route('message', ['inbox' => $thread]);
    }
}
