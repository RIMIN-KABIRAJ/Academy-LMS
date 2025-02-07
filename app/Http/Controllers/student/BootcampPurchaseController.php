<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Bootcamp;
use App\Models\OfflinePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BootcampPurchaseController extends Controller
{
    public function purchase($id)
    {
        $bootcamp = Bootcamp::where('id', $id)->first();
        if (! $bootcamp) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // check course owner
        if ($bootcamp->user_id == auth()->user()->id) {
            Session::flash('error', get_phrase('You own this item.'));
            return redirect()->back();
        }

        // check item is purchased or not
        if (is_purchased_bootcamp($bootcamp->id)) {
            Session::flash('error', get_phrase('Item is already purchased.'));
            return redirect()->back();
        }

        // check any offline processing data
        $processing_payments = OfflinePayment::where([
            'user_id'   => auth()->user()->id,
            'items'     => $bootcamp->id,
            'item_type' => 'bootcamp',
            'status'    => 0,
        ])->first();

        if ($processing_payments) {
            Session::flash('warning', get_phrase('Your request is in process.'));
            return redirect()->back();
        }

        // prepare bootcamp payment data
        $price           = $bootcamp->discount_flag ? $bootcamp->price - $bootcamp->discounted_price : $bootcamp->price;
        $payment_details = [
            'items'          => [
                [
                    'id'             => $bootcamp->id,
                    'title'          => $bootcamp->title,
                    'subtitle'       => '',
                    'price'          => $bootcamp->price,
                    'discount_price' => $price,
                ],
            ],

            'custom_field'   => [
                'item_type' => 'bootcamp',
                'pay_for'   => get_phrase('Bootcamp payment'),
            ],

            'success_method' => [
                'model_name'    => 'BootcampPurchase',
                'function_name' => 'purchase_bootcamp',
            ],

            'payable_amount' => round($price, 2),
            'tax'            => 0,
            'coupon'         => null,
            'cancel_url'     => route('bootcamp.details', $bootcamp->slug),
            'success_url'    => route('payment.success', ''),
        ];

        Session::put(['payment_details' => $payment_details]);
        return redirect()->route('payment');
    }
}
