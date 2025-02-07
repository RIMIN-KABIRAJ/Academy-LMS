<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::where('user_id', auth()->user()->id);
        if (request()->has('search') && request()->query('search') != '') {
            $query = $query->where('code', request()->query('search'));
        }

        $page_data['coupons'] = $query->paginate(10)->appends(request()->query());
        return view('admin.coupon.index', $page_data);
    }

    public function create()
    {
        return view('admin.coupon.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'code'     => 'required|string|unique:coupons,code',
            'discount' => 'required|numeric|between:1,100',
            'expiry'   => 'required|date|after_or_equal:today',
            'status'   => 'required|in:0,1',
        ];

        $messages = [
            'expiry.after_or_equal' => 'Expiry date must be a future date.',
            'status.in'             => 'Status must be either 0 or 1.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $coupon['code']     = $request->code;
        $coupon['user_id']  = auth()->user()->id;
        $coupon['discount'] = $request->discount;
        $coupon['expiry']   = strtotime($request->expiry);
        $coupon['status']   = $request->status;

        // insert data
        Coupon::insert($coupon);

        Session::flash('success', get_phrase('Coupon has been created successfully.'));
        return redirect()->back();
    }

    public function delete($id)
    {
        // check user data exists or not
        $query = Coupon::where('id', $id)->where('user_id', auth()->user()->id);
        if ($query->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // delete data
        $query->delete();
        Session::flash('success', get_phrase('Coupon has ben deleted successfully.'));
        return redirect()->back();
    }

    public function edit($id)
    {
        // check user data exists or not
        $query = Coupon::where('id', $id)->where('user_id', auth()->user()->id);
        if ($query->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $page_data['coupon_details'] = $query->first();
        return view('admin.coupon.edit', $page_data);
    }

    public function update(Request $request, $id)
    {
        // check user data exists or not
        $query = Coupon::where('id', $id)->where('user_id', auth()->user()->id);
        if ($query->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $rules = [
            'code'     => "required|string|unique:coupons,code,$id",
            'discount' => 'required|numeric|between:1,100',
            'expiry'   => 'required|date|after_or_equal:today',
            'status'   => 'required|in:0,1',
        ];

        $messages = [
            'expiry.after_or_equal' => 'Expiry date must be a future date.',
            'status.in'             => 'Status must be either 0 or 1.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $coupon['code']     = $request->code;
        $coupon['user_id']  = auth()->user()->id;
        $coupon['discount'] = $request->discount;
        $coupon['expiry']   = strtotime($request->expiry);
        $coupon['status']   = $request->status;

        // insert data
        Coupon::where('id', $id)->update($coupon);

        Session::flash('success', get_phrase('Coupon has been updated successfully.'));
        return redirect()->back();
    }

    public function status($id)
    {
        // check user data exists or not
        $query = Coupon::where('id', $id)->where('user_id', auth()->user()->id);
        if ($query->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $coupon = $query->first();
        $query->update(['status' => $coupon->status ? 0 : 1]);
        Session::flash('success', get_phrase('Status has been updated'));
        return redirect(route('admin.coupons'));
    }
}
