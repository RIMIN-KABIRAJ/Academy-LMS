<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment_history;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
    public function purchase_history()
    {
        $page_data['payments'] = Payment_history::join('courses', 'payment_histories.course_id', 'courses.id')
            ->join('users', 'payment_histories.user_id', 'users.id')
            ->where('payment_histories.user_id', auth()->user()->id)
            ->select('payment_histories.*', 'courses.title as course_title', 'users.name as user_name')
            ->latest('id')->paginate(10);
        $view_path = 'frontend.' . get_frontend_settings('theme') . '.student.purchase_history.index';
        return view($view_path, $page_data);
    }

    public function invoice($id)
    {
        // validate course id
        if (!is_numeric($id) && $id < 1) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // check existence
        $payment = Payment_history::join('courses', 'payment_histories.course_id', 'courses.id')
            ->join('users', 'payment_histories.user_id', 'users.id')
            ->where('payment_histories.id', $id)
            ->select('payment_histories.*', 'courses.title as course_title', 'users.name as user_name')->first();
        if (!$payment) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $page_data['invoice'] = $payment;
        $view_path            = 'frontend.' . get_frontend_settings('theme') . '.student.purchase_history.invoice';
        return view($view_path, $page_data);
    }

    public function purchase_course($course_id)
    {
        // validate course id
        if (!is_numeric($course_id) && $course_id < 1) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // check personal course
        if (Course::where('id', $course_id)->where('user_id', auth()->user()->id)->exists()) {
            Session::flash('error', get_phrase('Ops! You own this course.'));
            return redirect()->back();
        }

        // check the course is enrolled or not
        $enroll = Enrollment::where('user_id', auth()->user()->id)->where('course_id', $course_id);
        if ($enroll->exists()) {
            Session::flash('success', get_phrase('You already enrolled in this course'));
            return redirect()->back();
        }

        // get course details by id
        $course_details = Course::where('id', $course_id)->first();

        // if course doesn't exist redirect back
        if (!$course_details) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // if course is free then enroll user and redirect to my courses
        if ($course_details->is_paid == 0) {
            $enrollment['user_id']         = auth()->user()->id;
            $enrollment['course_id']       = $course_id;
            $enrollment['enrollment_type'] = 'free';
            $enrollment['entry_date']      = time();
            $enrollment['expiry_date']     = null;
            Enrollment::insert($enrollment);
            return redirect()->route('my.courses');
        } else {
            $query = CartItem::where('course_id', $course_id)->where('user_id', auth()->user()->id);
            if ($query->count() == 0) {
                CartItem::insert(['user_id' => auth()->user()->id, 'course_id' => $course_id, 'created_at' => date('Y-m-d H:i:s')]);
                return redirect(route('cart'));
            } elseif ($query->count() == 1) {
                return redirect(route('cart'));
            }
        }

        // redirect to cart store
        return redirect()->back();
    }

    public function payout(Request $request)
    {
        // get all item details by its id
        $items_id = json_decode($request->items);
        $courses  = $items_id;

        // if order is gift then select gifted user id
        if ($request->gifted_user_email) {
            $gifted_user_id = User::where('role', '!=', 'admin')->where('email', $request->gifted_user_email)->value('id');
            if (!$gifted_user_id) {
                Session::flash('error', get_phrase("User email doesn't exists."));
                return redirect()->back();
            }

            $courses = [];
            foreach ($items_id as $item) {
                if (Enrollment::where('course_id', $item)->where('user_id', $gifted_user_id)->doesntExist()) {
                    $courses[] = $item;
                }
            }

            if (count($courses) == 0) {
                Session::flash('error', get_phrase('User already enrolled.'));
                return redirect()->back();
            }
        }

        $selected_courses = Course::whereIn('id', $courses)->get();

        // prepare each item by its id
        foreach ($selected_courses as $key => $course) {
            $items[] = [
                'id'             => $course->id,
                'title'          => $course->title,
                'subtitle'       => '',
                'price'          => $course->price,
                'discount_price' => $course->discount_flag ? $course->discounted_price : 0,
            ];
        }

        $payment_details = [
            'items'          => $items,

            'custom_field'   => [
                'item_type'       => 'course',
                'pay_for'         => 'course payment',
                'user_id'         => auth()->user()->id,
                'user_photo'      => auth()->user()->photo,
                'cart_id'         => $items_id,
                'coupon_discount' => $request->coupon_discount,
                'gifted_user_id'  => $gifted_user_id ?? '',
            ],

            'success_method' => [
                'model_name'    => 'PurchaseCourse',
                'function_name' => 'purchase_course',
            ],

            'tax'            => round($request->tax, 2),
            'coupon'         => $request->coupon_code,
            'payable_amount' => round($request->payable, 2),
            'cancel_url'     => route('cart'),
            'success_url'    => route('payment.success', ''),
        ];

        Session::put(['payment_details' => $payment_details]);
        return redirect()->route('payment');
    }
}
