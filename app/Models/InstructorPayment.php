<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class InstructorPayment extends Model
{
    use HasFactory;
    public static function instructor_payment($identifier)
    {
        $payment_details = session('payment_details');
        $id = $payment_details['custom_field']['payout_id'];
        $data['status'] = 1;
        $data['payment_type'] = $identifier;
        Payout::where('id', $id)->update($data);
        Session::flash('success_message', 'Instructor payment successfully.');
        return redirect($payment_details['cancel_url']);
    }
}
