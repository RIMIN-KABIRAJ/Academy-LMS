<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogLike;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blog_like(Request $request)
    {
        $query = BlogLike::where('blog_id', $request->blog_id)->where('user_id', auth()->user()->id);
        if ($query->exists()) {
            $query->delete();
            $like = false;
        } else {
            $like['blog_id'] = $request->blog_id;
            $like['user_id'] = auth()->user()->id;
            BlogLike::insert($like);
            $like = true;
        }
        return response()->json(['like' => $like]);
    }
}
