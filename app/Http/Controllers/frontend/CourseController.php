<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CourseController extends Controller
{
    public function index(Request $request, $category = '')
    {
        $layout              = Session::has('view') ? session('view') : 'grid';
        $page_data['layout'] = $layout;

        $query = Course::join('users', 'courses.user_id', '=', 'users.id')
            ->select('courses.*', 'users.name as instructor_name', 'users.email as instructor_email', 'users.photo as instructor_image')
            ->where('courses.status', 'active');

        // filter by category
        if ($category != '') {
            $category_details = Category::where('slug', $request->category)->first();
            if ($category_details->parent_id > 0) {
                $page_data['child_cat'] = $request->category;
                $query                  = $query->where('category_id', $category_details->id);
            } else {
                $sub_cat_id              = Category::where('parent_id', $category_details->id)->pluck('id')->toArray();
                $sub_cat_id[] = $category_details->id;
                $query                   = $query->whereIn('category_id', $sub_cat_id);
                $page_data['parent_cat'] = $request->category;
            }
        }

        // searched courses
        if (request()->has('search')) {
            $query->where(function ($query) {
                $query->where('courses.title', 'LIKE', '%' . request()->input('search') . '%');
                $query->orWhere('courses.short_description', 'LIKE', '%' . request()->input('search') . '%');
                $query->orWhere('courses.level', 'LIKE', '%' . request()->input('search') . '%');
                $query->orWhere('courses.meta_keywords', 'LIKE', '%' . request()->input('search') . '%');
                $query->orWhere('courses.meta_description', 'LIKE', '%' . request()->input('search') . '%');
                $query->orWhere('courses.description', 'LIKE', '%' . request()->input('search') . '%');
            });
        }

        // filter by price
        if (request()->has('price')) {
            $price = request()->query('price');
            if ($price == 'paid') {
                $query = $query->where('is_paid', 1);
            } elseif ($price == 'discount') {
                $query = $query->where('discount_flag', 1);
            } elseif ($price == 'free') {
                $query = $query->where('is_paid', 0);
            }
        }

        // filter by level
        if (request()->has('level')) {
            $level = request()->query('level');
            $query = $query->where('level', $level);
        }

        // filter by language
        if (request()->has('language')) {
            $language = request()->query('language');
            $query    = $query->where('language', $language);
        }

        // filter by rating
        if (request()->has('rating')) {
            $rating = request()->query('rating');
            $query  = $query->where('average_rating', $rating);
        }

        $wishlist = [];
        if (isset(auth()->user()->id)) {
            $wishlist = Wishlist::where('user_id', auth()->user()->id)->pluck('course_id')->toArray();
        }

        $page_data['courses']  = $query->latest('id')->paginate($layout == 'grid' ? 9 : 5)->appends($request->query());
        $page_data['wishlist'] = $wishlist;
        $page_data['category_details'] = Category::where('slug', $category)->first();
        return view('frontend' . '.' . get_frontend_settings('theme') . '.course.index', $page_data);
    }

    public function course_details(Request $request, $slug)
    {
        // validate slug
        if (empty($slug)) {
            return redirect()->back();
        }

        // course details
        $course = Course::where('slug', $slug);
        if ($course->exists()) {
            $course_details              = $course->first();
            $page_data['course_details'] = $course_details;
            $page_data['sections']       = Section::where('course_id', $course_details->id)->orderBy('sort')->get();
            $page_data['total_lesson']   = Lesson::where('course_id', $course_details->id)->count();
            $page_data['enroll']         = Enrollment::where('course_id', $course_details->id)->count('user_id');

            $view_path = 'frontend.' . get_frontend_settings('theme') . '.course.course_details';
            return view($view_path, $page_data);
        } else {
            return redirect()->back();
        }
    }

    public function change_layout(Request $request)
    {
        $layout = Session::has('view');
        if ($layout) {
            Session::forget('view');
        }
        session(['view' => $request->view]);
        return response()->json(['reload' => true]);
    }

    // ------------------------------------------------------------------------------------------------------

    public function compare(Request $request)
    {
        $course_1 = $request->course_1;
        $course_2 = $request->course_2;
        $course_3 = $request->course_3;

        if (isset($course_1) && $course_1 != '') {
            $course_details_1              = Course::where('status', 'active')->where('slug', $course_1)->first();
            $page_data['course_details_1'] = $course_details_1;
        }
        if (isset($course_2) && $course_2 != '') {
            $course_details_2              = Course::where('status', 'active')->where('slug', $course_2)->first();
            $page_data['course_details_2'] = $course_details_2;
        }
        if (isset($course_3) && $course_3 != '') {
            $course_details_3              = Course::where('status', 'active')->where('slug', $course_3)->first();
            $page_data['course_details_3'] = $course_details_3;
        }

        if ($course_1 == '' && $course_2 == '' && $course_3 == '') {
            $page_data['course_details'] = '';
        }

        return view('frontend.course.compare', $page_data);
    }

    public function comparewith($course_1 = '', $course_2 = '', $course_3 = '')
    {

        $response = array();
        $result   = Course::join('users', 'courses.user_id', 'users.id')
            ->select('course.id as id', 'course.title as title', 'users.first_name as first_name', 'users.last_name as last_name')
            ->where('course.id', '!=', $course_1)
            ->where('course.id', '!=', $course_2)
            ->where('course.id', '!=', $course_3)
            ->where('course.status', 'active')
            
            ->like('course.title', $_GET['searchVal'])
            ->or_like('short_description', $_GET['searchVal'])
            ->or_like('first_name', $_GET['searchVal'])
            ->or_like('last_name', $_GET['searchVal'])
            
            ->take(100)
            ->get();

        foreach ($result as $key => $row) {
            $response[] = ['id' => $row->id, 'text' => $row->title . ' (' . get_phrase('Creator') . ': ' . $row->first_name];
        }
        echo json_encode($response);
    }
}
