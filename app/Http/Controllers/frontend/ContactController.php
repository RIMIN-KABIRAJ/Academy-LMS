<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        $view_path = 'frontend.' . get_frontend_settings('theme') . '.contact_us.index';
        return view($view_path);
    }

    public function store(Request $request)
    {
        // check duplicate
        if (Contact::where('email', $request->email)->exists()) {
            Session::flash('error', get_phrase('This email has been taken.'));
            return redirect()->back();
        }

        // validate user data
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'message' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // process data
        $contact['name'] = $request->name;
        $contact['email'] = $request->email;
        $contact['phone'] = $request->phone;
        $contact['address'] = $request->address;
        $contact['message'] = $request->message;

        // insert data
        Contact::insert($contact);

        // redirect back
        Session::flash('success', get_phrase('Your record has been saved.'));
        return redirect()->back();
    }
}
