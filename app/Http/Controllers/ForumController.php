<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $page_data['questions'] = Forum::join('users', 'forums.user_id', 'users.id')
            ->select('forums.*', 'users.name as user_name', 'users.photo as user_photo')
            ->latest('forums.id')
            ->where('forums.parent_id', 0)
            ->where('forums.course_id', $request->course_id)
            ->get();
        return view('course_player.forum.question_body', $page_data);
    }
    public function create(Request $request)
    {
        $page_data['course_id']          = $request->course_id;
        $page_data['parent_question_id'] = $request->parent_question_id;
        return view('course_player.forum.create_question', $page_data);
    }

    public function store(Request $request)
    {
        $rules = [
            'title'       => 'required',
            'description' => 'required',
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        $msg                 = 'Question added successfully.';
        $data['description'] = $request->description;
        if ($request->title == 'reply') {
            $msg                 = 'Reply added successfully.';
            $data['description'] = strip_tags($request->description);
        }

        $data['user_id']   = auth()->user()->id;
        $data['course_id'] = $request->course_id;
        $data['parent_id'] = $request->parent_id ?? 0;
        $data['title']     = $request->title;

        Forum::insert($data);
        Session::flash('success', get_phrase($msg));
        return redirect()->back();
    }

    public function edit(Request $request)
    {
        $page_data['course_id'] = $request->course_id;
        $page_data['question']  = Forum::where('id', $request->question_id)->first();
        return view('course_player.forum.edit_question', $page_data);
    }

    public function delete($id)
    {
        $query = Forum::where('user_id', auth()->user()->id)->where('id', $id);
        if ($query->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
        } else {
            $query->delete();
            Session::flash('success', get_phrase('Question deleted successfully.'));
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title'       => 'required',
            'description' => 'required',
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        $msg                 = 'Question updated successfully.';
        $data['description'] = $request->description;
        if ($request->title == 'reply') {
            $msg                 = 'Reply updated successfully.';
            $data['description'] = strip_tags($request->description);
        }

        $data['title']       = $request->title;
        $data['description'] = $request->description;

        Forum::where('id', $id)->update($data);
        Session::flash('success', get_phrase($msg));
        return redirect()->back();
    }

    public function likes($id)
    {
        $question = Forum::where('id', $id)->first();
        $user_id  = auth()->user()->id;
        $likes    = $question->likes ? json_decode($question->likes, true) : [];

        if (in_array($user_id, $likes)) {
            $likes = self::rmv_item($likes, $user_id);
            Session::flash('success', get_phrase('Your like has been removed.'));
        } else {
            array_push($likes, $user_id);
            Session::flash('success', get_phrase('Your like has been added.'));
        }
        $data['likes'] = count($likes) > 0 ? json_encode($likes) : null;

        // remove dislike is there is any dislike
        $dislikes = $question->dislikes ? json_decode($question->dislikes, true) : [];
        if (in_array($user_id, $dislikes)) {
            $dislikes         = self::rmv_item($dislikes, $user_id);
            $data['dislikes'] = count($dislikes) > 0 ? json_encode($dislikes) : null;
        }

        Forum::where('id', $id)->update($data);
        return redirect()->back();
    }

    public function dislikes($id)
    {
        $question = Forum::where('id', $id)->first();
        $user_id  = auth()->user()->id;
        $dislikes = $question->dislikes ? json_decode($question->dislikes, true) : [];

        if (in_array($user_id, $dislikes)) {
            $dislikes = self::rmv_item($dislikes, $user_id);
            Session::flash('success', get_phrase('Your changes has been saved.'));
        } else {
            array_push($dislikes, $user_id);
            Session::flash('success', get_phrase('Your changes has been saved.'));
        }
        $data['dislikes'] = count($dislikes) > 0 ? json_encode($dislikes) : null;

        // remove like is there is any like
        $likes = $question->likes ? json_decode($question->likes, true) : [];
        if (in_array($user_id, $likes)) {
            $likes         = self::rmv_item($likes, $user_id);
            $data['likes'] = count($likes) > 0 ? json_encode($likes) : null;
        }

        Forum::where('id', $id)->update($data);
        return redirect()->back();
    }

    public static function rmv_item($arr = [], $user_id)
    {
        $pos = array_search($user_id, $arr);
        array_splice($arr, $pos, 1);
        return $arr;
    }

    public function tab_active(Request $request)
    {
        $tab = explode('#pills-', $request->tab)[1];
        Session::put('forum_tab', $tab);
    }

    public function create_reply(Request $request)
    {
        $page_data['parent_question_id'] = $request->parent_question_id;
        return view('course_player.forum.create_reply', $page_data);
    }

    public function edit_reply(Request $request)
    {
        $page_data['reply'] = Forum::where('id', $request->reply_id)->first();
        return view('course_player.forum.edit_reply', $page_data);
    }
}
