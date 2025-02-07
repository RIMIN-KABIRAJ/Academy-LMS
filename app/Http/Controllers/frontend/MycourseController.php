<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\MessageThread;
use App\Models\Payment_history;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MycourseController extends Controller
{
    public function mycourses(Request $request)
    {
        $page_data['courses'] = Enrollment::where('user_id', auth()->user()->id)->get();

        // searched courses
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $query = Enrollment::join('courses', 'enrollments.course_id', 'courses.id')
                ->where('enrollments.user_id', auth()->user()->id)
                ->where('courses.title', 'LIKE', '%' . $_GET['search'] . '%')
                ->get();
            $page_data['courses'] = $query;
        }

        $view_path = 'frontend' . '.' . get_frontend_settings('theme') . '.my_courses.my_courses';
        return view($view_path, $page_data);
    }

    public function profile()
    {
        return view('frontend.my-courses.profile');
    }
    public function profile_edit(Request $request)
    {
        $data['name']    = $request->name;
        $data['email']   = $request->email;
        $data['about']   = $request->about;
        $data['phone']   = $request->phone;
        $data['website'] = $request->website;

        User::where('id', $request->user_id)->update($data);
        Session::flash('success', get_phrase('Update successfully'));
        return redirect()->back();
    }
    public function wishlist()
    {
        $quary = Wishlist::join('courses', 'wishlists.course_id', 'courses.id')
            ->where('wishlists.user_id', auth()->user()->id)
            ->get();
        $page_data['courses'] = $quary;

        return view('frontend.my-courses.wishlist', $page_data);
    }
    public function message()
    {
        $page_data['message_threads'] = MessageThread::get();
        return view('frontend.my-courses.message', $page_data);
    }
    public function purchase_history()
    {

        $payment_history      = Payment_history::where('user_id', auth()->user()->id)->get();
        $page_data['courses'] = $payment_history;
        return view('frontend.my-courses.purchase-history', $page_data);
    }

    public function invoice($id)
    {
        $invoice               = Payment_history::where('id', $id)->first();
        $user                  = User::where('id', $invoice->user_id)->first();
        $course                = Course::where('id', $invoice->course_id)->first();
        $page_data['invoices'] = $invoice;
        $page_data['courses']  = $course;
        $page_data['users']    = $user;
        return view('frontend.my-courses.invoice', $page_data);
    }
}
