<?php

namespace App\Http\Controllers\instructor;

use App\Http\Controllers\Controller;
use App\Models\BootcampModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BootcampModuleController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
    }
    public function store(Request $request)
    {
        $rules = [
            'title'       => 'required|string',
            'validity'    => 'required',
            'bootcamp_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // check duplicate title for same bootcamp id
        $title = BootcampModule::join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->where('bootcamps.user_id', auth()->user()->id)->where('bootcamp_modules.title', $request->title)->first();
        if ($title) {
            Session::flash('error', get_phrase('This title has been taken.'));
            return redirect()->back();
        }

        $data['title']       = $request->title;
        $data['restriction'] = $request->restriction;
        $data['bootcamp_id'] = $request->bootcamp_id;

        $date                 = explode('-', $request->validity);
        $data['publish_date'] = strtotime($date[0]);
        $data['expiry_date']  = strtotime($date[1]);

        BootcampModule::insert($data);
        Session::flash('success', get_phrase('Module has been created.'));
        return redirect()->back();
    }

    public function delete($id)
    {
        $module = BootcampModule::join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->where('bootcamp_modules.id', $id)
            ->where('bootcamps.user_id', auth()->user()->id);
        if ($module->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $module->delete();

        Session::flash('success', get_phrase('Module has been deleted.'));
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title'    => 'required|string',
            'validity' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $module = BootcampModule::join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->where('bootcamp_modules.id', $id)
            ->where('bootcamp_modules.bootcamp_id', $request->bootcamp_id)
            ->where('bootcamps.user_id', auth()->user()->id)
            ->first();
        if (! $module) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // check duplicate title for same bootcamp id
        $title = BootcampModule::join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->where('bootcamp_modules.id', '!=', $id)
            ->where('bootcamps.user_id', auth()->user()->id)
            ->where('bootcamp_modules.title', $request->title)->first();

        if ($title) {
            Session::flash('error', get_phrase('This title has been taken.'));
            return redirect()->back();
        }

        $data['title']       = $request->title;
        $data['restriction'] = $request->restriction;

        $date                 = explode('-', $request->validity);
        $data['publish_date'] = strtotime($date[0]);
        $data['expiry_date']  = strtotime($date[1]);

        BootcampModule::where('id', $id)->update($data);
        Session::flash('success', get_phrase('Module has been updated.'));
        return redirect()->back();
    }

    public function sort(Request $request)
    {
        $modules = json_decode($request->itemJSON);
        foreach ($modules as $key => $value) {
            $updater = $key + 1;
            BootcampModule::where('id', $value)->update(['sort' => $updater]);
        }

        return response()->json([
            'status'  => true,
            'success' => get_phrase('Modules sorted successfully'),
        ]);
    }
}
