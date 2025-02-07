<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index(Request $request)
    {
        // has any coupon then validate coupon
        if (request()->has('coupon')) {
            $code   = request()->query('coupon');
            $coupon = Coupon::where('code', $code)->first();
            if (! $coupon) {
                Session::flash('error', get_phrase('This coupon is not valid.'));
                return redirect()->back();
            }

            if ($coupon->status && (time() >= $coupon->expiry)) {
                Session::flash('error', get_phrase('Ops! coupon is expired.'));
                return redirect()->back();
            }
            $discount = $coupon->discount;
            $page_data['coupon'] = $coupon;
        }

        // cart items by course id
        $page_data['cart_items'] = CartItem::join('courses', 'cart_items.course_id', '=', 'courses.id')
            ->select('cart_items.id as cart_id', 'courses.*', 'courses.id as course_id')
            ->where('cart_items.user_id', auth()->user()->id)->get();
        $page_data['discount'] = isset($discount) ? $discount : 0;

        $view_path = 'frontend.' . get_frontend_settings('theme') . '.student.cart.index';
        return view($view_path, $page_data);
    }

    public function store($id)
    {
        // check personal course
        if (Course::where('id', $id)->where('user_id', auth()->user()->id)->exists()) {
            Session::flash('error', get_phrase('Ops! You own this course.'));
            return redirect()->back();
        }

        // check if the course is purchased or not
        if (Enrollment::where('user_id', auth()->user()->id)->where('course_id', $id)->exists()) {
            Session::flash('error', get_phrase('You already purchased the course.'));
            return redirect()->back();
        }

        // if course_id doesn't exit in cart then insert course_id
        if (CartItem::where('user_id', auth()->user()->id)->where('course_id', $id)->doesntExist()) {
            CartItem::insert(['user_id' => auth()->user()->id, 'course_id' => $id]);
        }

        // redirect back
        Session::flash('success', get_phrase('Item added to the cart.'));
        return redirect()->back();
    }

    public function delete($id)
    {
        // if user has selected item then delete item else redirect to cart page
        $query = CartItem::where('course_id', $id)->where('user_id', auth()->user()->id);

        if ($query->exists()) {
            $query->delete();
            Session::flash('success', get_phrase('Item removed from cart.'));
        } else {
            Session::flash('error', get_phrase('Data not found.'));
        }
        return redirect()->back();
    }
}
