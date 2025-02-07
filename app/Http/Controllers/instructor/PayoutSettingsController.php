<?php

namespace App\Http\Controllers\instructor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PayoutSettingsController extends Controller {
    public function payout_setting() {
        $payment_setting         = User::where('id', auth()->user()->id)->first();
        $page_data['instructor'] = json_decode($payment_setting->paymentkeys, true);
        return view('instructor.payout_setting.index', $page_data);
    }

    public function payout_setting_store(Request $request) {
        $data = $request->all();
        array_shift($data);
        $data = json_encode($_POST['gateways']);

        User::where('id', auth()->user()->id)->update(['paymentkeys' => $data]);
        return redirect(route('instructor.payout.setting'))->with('success', get_phrase('Payout setting updated'));
    }
}
