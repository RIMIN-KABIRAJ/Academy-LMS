<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PurchaseCourse extends Model
{
    use HasFactory;

    public static function purchase_course($identifier)
    {
        // get payment details
        $payment_details = session('payment_details');

        if (Session::has('keys')) {
            $transaction_keys          = session('keys');
            $transaction_keys          = json_encode($transaction_keys);
            $payment['transaction_id'] = $transaction_keys;
            $remove_session_item[]     = 'keys';
        }
        if (Session::has('session_id')) {
            $transaction_keys      = session('session_id');
            $payment['session_id'] = $transaction_keys;
            $remove_session_item[] = 'session_id';
        }

        // generate invoice for payment
        $payment['invoice'] = Str::random(20);
        for ($i = 0; $i < count($payment_details['items']); $i++) {
            $price           = $payment_details['items'][$i]['price'];
            $course_discount = $payment_details['items'][$i]['discount_price'];

            if (get_course_creator_id($payment_details['items'][$i]['id'])->role == 'admin') {
                $payment['admin_revenue'] = $payment_details['payable_amount'];
            } else {
                $payment['instructor_revenue'] = $payment_details['payable_amount'] * (get_settings('instructor_revenue') / 100);
                $payment['admin_revenue']      = $payment_details['payable_amount'] - $payment['instructor_revenue'];
            }

            $payment['course_id']    = $payment_details['items'][$i]['id'];
            $payment['tax']          = $payment_details['tax'];
            $payment['amount']       = $course_discount ? $course_discount : $price;
            $payment['user_id']      = auth()->user()->id;
            $payment['payment_type'] = $identifier;
            $payment['coupon']       = $payment_details['coupon'];

            // insert payment history
            $payment_history = DB::table('payment_histories')->insert($payment);

            // if payment has done then enroll user
            if ($payment_history) {
                $enroll['course_id']       = $payment_details['items'][$i]['id'];
                $enroll['user_id']         = $payment_details['custom_field']['gifted_user_id'] ? $payment_details['custom_field']['gifted_user_id'] : auth()->user()->id;
                $enroll['enrollment_type'] = "paid";
                $enroll['entry_date']      = time();

                // insert a new enrollment
                DB::table('enrollments')->insert($enroll);
            }
        }

        // if payment and enroll has been done then remove items from cart
        if ($payment_history && $enroll) {
            $cart_items = $payment_details['custom_field']['cart_id'];
            foreach ($cart_items as $item) {
                DB::table('cart_items')->where('user_id', auth()->user()->id)->where('course_id', $item)->delete();
            }
        }

        $remove_session_item[] = 'payment_details';
        Session::forget($remove_session_item);
        Session::flash('success', 'Course enrolled successfully.');
        return redirect()->route('my.courses');
    }
}
