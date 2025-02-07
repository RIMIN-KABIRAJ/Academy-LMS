<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WishListController extends Controller
{
    public function index()
    {
        $page_data['wishlist'] = Wishlist::join('courses', 'wishlists.course_id', '=', 'courses.id')
            ->join('users', 'courses.user_id', '=', 'users.id')
            ->select('wishlists.*', 'courses.*', 'courses.thumbnail as course_thumbnail', 'users.name as user_name', 'users.photo as users_photo')
            ->where('wishlists.user_id', auth()->user()->id)->paginate(6);

        $view_path = 'frontend.' . get_frontend_settings('theme') . '.student.wishlist.index';
        return view($view_path, $page_data);
    }
    public function toggleWishItem(Request $request, $course_id = '')
    {
        $res = [];
        if (!is_numeric($course_id) && $course_id < 1) {
            return response()->json($res);
        }

        $query = Wishlist::where('user_id', auth()->user()->id)->where('course_id', $course_id);
        if ($query->exists()) {
            $query->delete();
            $res = ['toggleStatus' => 'removed'];

            if (!$request->ajax())
                Session::flash('success', get_phrase('Item removed from wishlist.'));
        } else {
            $data['user_id']   = auth()->user()->id;
            $data['course_id'] = $course_id;
            Wishlist::insert($data);
            $res = ['toggleStatus' => 'added'];

            if (!$request->ajax())
                Session::flash('success', get_phrase('Item added to wishlist.'));
        }
        return response()->json($res);
    }
}
