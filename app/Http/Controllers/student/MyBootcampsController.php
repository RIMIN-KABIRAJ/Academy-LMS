<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\BootcampLiveClass;
use App\Models\BootcampPurchase;
use App\Models\BootcampResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MyBootcampsController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
    }
    public function index()
    {
        $page_data['my_bootcamps'] = BootcampPurchase::join('bootcamps', 'bootcamp_purchases.bootcamp_id', 'bootcamps.id')
            ->where('bootcamp_purchases.user_id', auth()->user()->id)
            ->where('bootcamp_purchases.status', 1)
            ->select('bootcamps.*')->latest('id')->paginate(10)->appends(request()->query());
        return view(theme_path() . 'student.my_bootcamps.index', $page_data);
    }

    public function show($slug)
    {
        $page_data['bootcamp'] = BootcampPurchase::join('bootcamps', 'bootcamp_purchases.bootcamp_id', 'bootcamps.id')
            ->where('bootcamp_purchases.user_id', auth()->user()->id)
            ->where('bootcamp_purchases.status', 1)
            ->where('bootcamps.slug', $slug)
            ->select('bootcamps.*')->latest('id')->first();

        if (! $page_data['bootcamp']) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        return view(theme_path() . 'student.my_bootcamps.details', $page_data);
    }

    public function join_class($slug)
    {
        $current_time  = time();
        $extended_time = $current_time + (60 * 15);

        $class = BootcampLiveClass::join('bootcamp_modules', 'bootcamp_live_classes.module_id', 'bootcamp_modules.id')
            ->join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->join('bootcamp_purchases', function ($join) {
                $join->on('bootcamps.id', 'bootcamp_purchases.bootcamp_id')
                    ->where('bootcamp_purchases.user_id', auth()->user()->id)
                    ->where('bootcamp_purchases.status', 1);
            })
            ->where('bootcamp_live_classes.slug', $slug)
            ->where('bootcamp_live_classes.start_time', '<', $extended_time)
            ->where('bootcamp_live_classes.end_time', '>', $current_time)
            ->select('bootcamp_live_classes.*', 'bootcamps.id as bootcamp_id', 'bootcamp_purchases.user_id as enrolled_user')
            ->first();

        if ($current_time > $class->end_time) {
            Session::flash('error', get_phrase('Time up! Class is over.'));
            return redirect()->route('admin.bootcamp.edit', [$class->bootcamp_id, 'tab' => 'curriculum']);
        }

        if (! $class) {
            Session::flash('error', get_phrase('Class not found.'));
            return redirect()->route('admin.bootcamp.edit', [$class->bootcamp_id, 'tab' => 'curriculum']);
        }

        if (get_settings('zoom_web_sdk') == 'active') {
            $page_data['class']   = $class;
            $page_data['user']    = get_user_info($class->enrolled_user);
            $page_data['is_host'] = 0;
            return view('bootcamp_online_class.index', $page_data);
        } else {
            $meeting_info = json_decode($class->joining_data, true);
            return redirect($meeting_info['start_url']);
        }
    }

    public function download($id)
    {
        $resource = BootcampResource::join('bootcamp_modules', 'bootcamp_resources.module_id', 'bootcamp_modules.id')
            ->join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->join('bootcamp_purchases', 'bootcamps.id', 'bootcamp_purchases.bootcamp_id')
            ->where('bootcamp_resources.id', $id)
            ->where('bootcamp_resources.upload_type', 'resource')
            ->where('bootcamp_purchases.user_id', auth()->user()->id)
            ->select('bootcamp_resources.*', 'bootcamp_purchases.user_id')
            ->first();

        if (! $resource) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $file_path = public_path($resource->file);
        if (! file_exists($file_path)) {
            Session::flash('error', get_phrase('File does not exist.'));
            return redirect()->back();
        }
        return response()->download($file_path);
    }

    public function play($file)
    {
        $class = BootcampResource::join('bootcamp_modules', 'bootcamp_resources.module_id', 'bootcamp_modules.id')
            ->join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->join('bootcamp_purchases', 'bootcamps.id', 'bootcamp_purchases.bootcamp_id')
            ->where('bootcamp_resources.title', $file)
            ->where('bootcamp_resources.upload_type', 'record')
            ->where('bootcamp_purchases.user_id', auth()->user()->id)
            ->select('bootcamp_resources.*', 'bootcamp_purchases.user_id as enrolled_user', 'bootcamps.slug as bootcamp_slug')
            ->first();

        if (! $class) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $file_path = public_path($class->file);
        if (! file_exists($file_path)) {
            Session::flash('error', get_phrase('File does not exist.'));
            return redirect()->back();
        }

        return view('class_record.player', compact('class'));
    }
}
