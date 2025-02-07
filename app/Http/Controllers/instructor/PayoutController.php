<?php

namespace App\Http\Controllers\instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Payout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PayoutController extends Controller
{
    public function index()
    {
        $page_data['start_date'] = strtotime('first day of this month');
        $page_data['end_date']   = strtotime('last day of this month');

// modify date and prepare to compare with database
        if (request()->has('eDateRange')) {
            $date                    = explode('-', urldecode(request()->query('eDateRange')));
            $page_data['start_date'] = strtotime($date[0] . ' 00:00:00');
            $page_data['end_date']   = strtotime($date[1] . ' 23:59:59');
        }
        $query = Payout::where('user_id', auth()->user()->id)->where('created_at', '>=', date('Y-m-d H:i:s', $page_data['start_date']))
            ->where('created_at', '<=', date('Y-m-d H:i:s', $page_data['end_date']))->latest('id');

        $page_data['payout_reports'] = $query->paginate(10)->appends(request()->query('eDateRange'));
        $page_data['payout_request'] = Payout::where('user_id', auth()->user()->id)->where('status', 0)->first();
        $page_data['total_payout']   = instructor_total_payout();
        $page_data['balance']        = instructor_available_balance();

        return view('instructor.payout_report.index', $page_data);
    }

    public function store(Request $request)
    {
        // check old request
        if (Payout::where('user_id', auth()->user()->id)->where('status', 0)->exists()) {
            Session::flash('error', get_phrase('Your request is in process.'));
            return redirect()->back();
        }

        // check amount validity
        $total_income      = instructor_total_revenue();
        $total_payout      = instructor_total_payout();
        $balance_remaining = $total_income - $total_payout;

        if ($request->amount < 1 || $request->amount > $balance_remaining) {
            Session::flash('error', get_phrase('You do not have sufficient balance.'));
            return redirect()->back();
        }

        $data['user_id'] = auth()->user()->id;
        $data['amount']  = $request->amount;
        Payout::insert($data);

        Session::flash('success', get_phrase('Your request has been submitted.'));
        return redirect()->back();
    }

    public function delete($id)
    {
        if (Payout::where('id', $id)->where('user_id', auth()->user()->id)->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }
        Payout::where('id', $id)->delete();
        Session::flash('success', get_phrase('Your request has been deleted.'));
        return redirect()->back();
    }
}
