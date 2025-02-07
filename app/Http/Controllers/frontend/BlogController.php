<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    public function index(Request $request, $category = '')
    {
        $category_row = BlogCategory::where('slug', $category)->first();
        $query = Blog::query();

        // search result
        if (request()->has('search')) {
            $search = request()->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        // if blog has category
        if ($category != '') {
            $query->where('category_id', $category_row->id);
        }

        $page_data['blogs'] = $query->latest('id')->paginate(6)->appends($request->query());
        $view_path          = 'frontend' . '.' . get_frontend_settings('theme') . '.blog.index';
        return view($view_path, $page_data);
    }

    public function blog_details($slug)
    {
        $query = Blog::join('users', 'blogs.user_id', 'users.id')
            ->select(
                'blogs.*',
                'users.name as author_name',
                'users.email as author_email',
                'users.photo as author_photo',
                'users.skills as author_skills',
                'users.biography as author_biography',
                'users.facebook as author_facebook',
                'users.linkedin as author_linkedin',
                'users.twitter as author_twitter',
            )
            ->where('blogs.slug', $slug);

        // if selected blog doesn't exists return back page
        if ($query->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $blog_details               = $query->first();
        $page_data['blog_details']  = $blog_details;
        $page_data['blog_comments'] = BlogComment::join('users', 'blog_comments.user_id', '=', 'users.id')
            ->select('blog_comments.*', 'users.name as commentator_name', 'users.photo as commentator_photo')
            ->where('blog_comments.blog_id', $blog_details->id)
            ->where('blog_comments.parent_id', null)
            ->latest('id')->get();

        $view_path = 'frontend' . '.' . get_frontend_settings('theme') . '.blog.details';
        return view($view_path, $page_data);
    }
}
