<?php

namespace App\Http\Controllers\instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Payment_history;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        $start_date = strtotime('first day of this month');
        $end_date   = strtotime('last day of this month');

        if (request()->has('eDateRange')) {
            // modify date and prepare to compare with database
            $date       = explode('-', urldecode(request()->query('eDateRange')));
            $start_date = strtotime($date[0] . ' 00:00:00');
            $end_date   = strtotime($date[1] . ' 23:59:59');
        }

        $query = Payment_history::join('courses', 'payment_histories.course_id', 'courses.id')
            ->join('users', 'payment_histories.user_id', 'users.id')
            ->select(
                'payment_histories.*',
                'courses.title as course_title',
                'courses.slug as course_slug',
                'courses.user_id as instructor_id',
                'users.name as student_name'
            )
            ->where('courses.user_id', auth()->user()->id)
            ->where('payment_histories.created_at', '>=', date('Y-m-d H:i:s', $start_date))
            ->where('payment_histories.created_at', '<=', date('Y-m-d H:i:s', $end_date));

        $page_data['start_date']   = $start_date;
        $page_data['end_date']     = $end_date;
        $page_data['sales_report'] = $query->paginate(10)->appends($request->query());
        return view('instructor.sales_report.index', $page_data);
    }
}
