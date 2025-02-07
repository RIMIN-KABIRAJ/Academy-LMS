<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BlogCommentController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'comment' => 'required|string|min:1',
            'blog_id' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Session::flash(' error', get_phrase('Failed to save you comment.'));
            return redirect()->back();
        }

        // blog comment data
        $comment['user_id']   = auth()->user()->id;
        $comment['blog_id']   = $request->blog_id;
        $comment['comment']   = $request->comment;
        $comment['parent_id'] = $request->parent_id;

        // store comment
        BlogComment::insert($comment);

        // redirect back
        Session::flash('success', get_phrase('Your comment has been saved.'));
        return redirect()->back();
    }

    public function delete($id)
    {
        // if user has selected item then delete item else redirect to back
        $query = BlogComment::where('id', $id);
        if ($query->where('user_id', auth()->user()->id)->exists()) {
            $query->delete();
            Session::flash('success', get_phrase('Your comment has been deleted.'));
        } else {
            Session::flash('error', get_phrase('Data not found.'));
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $comment['comment'] = $request->comment;
        BlogComment::where('id', $id)->update($comment);

        Session::flash('success', get_phrase('Your comment has been updated.'));
        return redirect()->back();
    }
}
