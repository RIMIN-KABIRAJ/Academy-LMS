<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TeamPackagePurchase extends Model
{
    use HasFactory;

    public static function purchase_team_package($identifier)
    {
        // get payment details
        $payment_details = session('payment_details');

        if (Session::has('keys')) {
            $transaction_keys           = session('keys');
            $transaction_keys           = json_encode($transaction_keys);
            $payment['payment_details'] = $transaction_keys;
            $remove_session_item[]      = 'keys';
        }
        if (Session::has('session_id')) {
            $transaction_keys           = session('session_id');
            $payment['payment_details'] = $transaction_keys;
            $remove_session_item[]      = 'session_id';
        }

        // generate invoice for payment
        $payment['invoice']        = '#' . Str::random(20);
        $payment['user_id']        = auth()->user()->id;
        $payment['package_id']     = $payment_details['items'][0]['id'];
        $payment['price']          = $payment_details['payable_amount'];
        $payment['tax']            = $payment_details['tax'];
        $payment['payment_method'] = $identifier;
        $payment['status']         = 1;

        $package = TeamTrainingPackage::find($payment_details['items'][0]['id']);
        if (get_user_info($package->user_id)->role == 'admin') {
            $payment['admin_revenue'] = $payment_details['payable_amount'];
        } else {
            $payment['instructor_revenue'] = $payment_details['payable_amount'] * (get_settings('instructor_revenue') / 100);
            $payment['admin_revenue']      = $payment_details['payable_amount'] - $payment['instructor_revenue'];
        }

        // insert payment details
        TeamPackagePurchase::insert($payment);

        $remove_session_item[] = 'payment_details';
        Session::forget($remove_session_item);
        Session::flash('success', get_phrase('Team package purchased successfully.'));
        return redirect()->route('my.team.packages');
    }
}
