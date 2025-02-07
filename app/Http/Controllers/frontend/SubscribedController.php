<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Newsletter_subscriber;
use Illuminate\Http\Request;

class SubscribedController extends Controller
{
    public function contact_us()
    {
        return view('frontend.contact');
    }
    public function contact_us_store(Request $request)
    {
        if ($request->check == '1') {
            $data['first_name'] = $request->first_name;
            $data['last_name'] = $request->last_name;
            $data['email'] = $request->email;
            $data['phone'] = $request->phone;
            $data['address'] = $request->address;
            $data['message'] = $request->comment;

            Contact::insert($data);
        }
        return redirect()->back();
    }

    public function about_us()
    {
        $view_path = 'frontend' . '.' . get_frontend_settings('theme') . '.home.index';
        return view($view_path);
    }
    public function privacy_policy()
    {
        return view('frontend.privacy_policy.index');
    }
    public function refund_policy()
    {
        return view('frontend.refund_policy.index');
    }
    public function terms_and_condition()
    {
        return view('frontend.terms_and_condition.index');
    }
    public function faq()
    {
        return view('frontend.faq.index');
    }
}
