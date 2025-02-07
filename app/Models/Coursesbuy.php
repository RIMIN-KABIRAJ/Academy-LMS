<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Coursesbuy extends Model
{
    use HasFactory;

    public static function buy_courses($identifier)
    {
        $payment_details = session('payment_details');
        $transaction_keys = session('keys');
        $transaction_keys = json_encode($transaction_keys);
        $invoice_no = random_int(10000000, 99999999);

        for ($i = 0; $i < count($payment_details['items']); $i++) {

            $payment_data['course_id'] = $payment_details['items'][$i]['id'];
            $payment_data['user_id'] = auth()->user()->id;

            if (get_course_creator_id($payment_data['course_id'])->role == 'admin') {
                $payment_data['amount'] = $payment_details['items'][$i]['price'];
                $payment_data['tax'] = $payment_data['amount'] * (get_settings('course_selling_tax') / 100);
                $payment_data['admin_revenue'] = $payment_data['amount'];
            } else {
                $payment_data['amount'] = $payment_details['items'][$i]['price'];
                $payment_data['tax'] = $payment_data['amount'] * (get_settings('course_selling_tax') / 100);
                $payment_data['instructor_revenue'] = $payment_data['amount'] * (get_settings('instructor_revenue') / 100);
                $payment_data['admin_revenue'] = $payment_data['amount'] - $payment_data['instructor_revenue'];
            }


            $payment_data['payment_type'] = $identifier;
            $payment_data['coupon'] = $payment_details['custom_field']['coupon_code'];
            $payment_data['transaction_id'] = $transaction_keys;
            $payment_data['invoice'] = $invoice_no;
            $payment_data['created_at'] = date('Y-m-d H:i:s');
            $payment_data['updated_at'] = date('Y-m-d H:i:s');

            // new payment for subscription
            $done =  DB::table('payment_histories')->insert($payment_data);

            if ($done) {

                $data['course_id'] = $payment_details['items'][$i]['id'];
                $data['user_id'] = auth()->user()->id;
                $data['enrollment_type'] = "paid";
                $data['entry_date'] = time();
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');

                // new subscription added
                DB::table('enrollments')->insert($data);
            }
        }



        if ($done) {

            $id = $payment_details['custom_field']['cart_id'];

            for ($i = 0; $i < count($id); $i++) {
                DB::table('addtocarts')->where('id', $id[$i])->delete();
            }
        }


        session(['payment_details' => array()]);
        Session::flash('success_message', 'Donation completed.');
        return redirect($payment_details['cancel_url']);
        // cancel url redirects selected creator page
        // it doesn't cancel any process
    }
}
