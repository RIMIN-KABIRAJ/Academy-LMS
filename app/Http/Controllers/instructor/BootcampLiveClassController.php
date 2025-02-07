<?php

namespace App\Http\Controllers\instructor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ZoomMeetingController;
use App\Models\BootcampLiveClass;
use App\Models\BootcampModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BootcampLiveClassController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string',
            'date'        => 'required|date',
            'start_time'  => 'required|string',
            'end_time'    => 'required|string|after:start_time',
            'module_id'   => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // check selected module
        $module = BootcampModule::where('id', $request->module_id)->first();
        if (! $module) {
            Session::flash('error', get_phrase('Module does not exist.'));
            return redirect()->back();
        }

        // process class schedule
        $start           = $request->date . ' ' . $request->start_time;
        $start_timestamp = strtotime($start);
        $end             = $request->date . ' ' . $request->end_time;
        $end_timestamp   = strtotime($end);

        // check module and class schedule
        if ($module->restriction) {
            if ($module->restriction == 1 && $start_timestamp < $module->publish_date) {
                Session::flash('error', get_phrase('Please set class schedule properly.'));
                return redirect()->back();
            }
            if ($module->restriction == 2 && (($start_timestamp < $module->publish_date || $start_timestamp > $module->expiry_date) && ($end_timestamp < $module->publish_date || $end_timestamp > $module->expiry_date))) {
                Session::flash('error', get_phrase('Please set class schedule properly.'));
                return redirect()->back();
            }
        }

        // check duplicate title for same bootcamp id
        $title = BootcampLiveClass::join('bootcamp_modules', 'bootcamp_live_classes.module_id', 'bootcamp_modules.id')
            ->join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->where('bootcamps.user_id', auth()->user()->id)
            ->where('bootcamp_modules.id', $request->module_id)
            ->where('bootcamp_live_classes.title', $request->title)->first();
        if ($title) {
            Session::flash('error', get_phrase('This title has been taken.'));
            return redirect()->back();
        }

        $data['title']       = $request->title;
        $data['slug']        = slugify($request->title);
        $data['description'] = $request->description;
        $data['status']      = $request->status;
        $data['module_id']   = $request->module_id;
        $data['start_time']  = $start_timestamp;
        $data['end_time']    = $end_timestamp;

        $joiningData    = ZoomMeetingController::createMeeting($request->title, $start_timestamp);
        $joiningInfoArr = json_decode($joiningData, true);

        if (array_key_exists('code', $joiningInfoArr) && $joiningInfoArr) {
            return redirect(route('instructor.bootcamp.edit', ['id' => $module->bootcamp_id, 'tab' => 'curriculum']))->with('error', get_phrase($joiningInfoArr['message']));
        }
        $data['provider']     = 'zoom';
        $data['joining_data'] = $joiningData;

        BootcampLiveClass::insert($data);

        Session::flash('success', get_phrase('Live class has been created.'));
        return redirect()->route('instructor.bootcamp.edit', ['id' => $module->bootcamp_id, 'tab' => 'curriculum']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string',
            'start_time'  => 'required',
            'end_time'    => 'required',
            'module_id'   => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $class = BootcampLiveClass::join('bootcamp_modules', 'bootcamp_live_classes.module_id', 'bootcamp_modules.id')
            ->join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->where('bootcamp_live_classes.id', $id)
            ->where('bootcamp_live_classes.module_id', $request->module_id)
            ->where('bootcamps.user_id', auth()->user()->id)
            ->select('bootcamp_live_classes.*', 'bootcamp_modules.restriction', 'bootcamp_modules.publish_date', 'bootcamp_modules.expiry_date')
            ->first();
        if (! $class) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // process class schedule
        $start           = $request->date . ' ' . $request->start_time;
        $start_timestamp = strtotime($start);
        $end             = $request->date . ' ' . $request->end_time;
        $end_timestamp   = strtotime($end);

        // check module and class schedule
        if ($class->restriction) {
            if ($class->restriction == 1 && $start_timestamp < $class->publish_date) {
                Session::flash('error', get_phrase('Please set class schedule properly.'));
                return redirect()->back();
            }
            if ($class->restriction == 2 && (($start_timestamp < $class->publish_date || $start_timestamp > $class->expiry_date) && ($end_timestamp < $class->publish_date || $end_timestamp > $class->expiry_date))) {
                Session::flash('error', get_phrase('Please set class schedule properly.'));
                return redirect()->back();
            }
        }

        // check duplicate title for same bootcamp id
        $title = BootcampLiveClass::join('bootcamp_modules', 'bootcamp_live_classes.module_id', 'bootcamp_modules.id')
            ->join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->where('bootcamps.user_id', auth()->user()->id)
            ->where('bootcamp_modules.id', $request->module_id)
            ->where('bootcamp_live_classes.id', '!=', $id)
            ->where('bootcamp_live_classes.title', $request->title)->first();
        if ($title) {
            Session::flash('error', get_phrase('This title has been taken.'));
            return redirect()->back();
        }

        if ($class->start_time != $start_timestamp || $class->end_time != $end_timestamp) {
            $data['force_stop'] = 0;
        }

        $data['title']       = $request->title;
        $data['slug']        = slugify($request->title);
        $data['description'] = $request->description;
        $data['status']      = $request->status;
        $data['module_id']   = $request->module_id;
        $data['start_time']  = $start_timestamp;
        $data['end_time']    = $end_timestamp;

        if ($class->provider == 'zoom') {
            $oldMeetingData = json_decode($class->joining_data, true);
            ZoomMeetingController::updateMeeting($request->title, $request->start_time, $oldMeetingData['id']);
            $oldMeetingData["start_time"] = date('Y-m-d\TH:i:s', strtotime($request->start_time));
            $oldMeetingData["topic"]      = $request->class_topic;
            $data['joining_data']         = json_encode($oldMeetingData);
        }

        $class->update($data);

        Session::flash('success', get_phrase('Live class has been updated.'));
        return redirect()->back();
    }

    public function delete($id)
    {
        $class = BootcampLiveClass::join('bootcamp_modules', 'bootcamp_live_classes.module_id', 'bootcamp_modules.id')
            ->join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->where('bootcamp_live_classes.id', $id)
            ->where('bootcamps.user_id', auth()->user()->id);
        if ($class->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $meetingData = $class->value('joining_data');
        if ($meetingData) {
            $oldMeetingData = json_decode($meetingData, true);
            ZoomMeetingController::deleteMeeting($oldMeetingData['id']);
        }
        BootcampLiveClass::where('id', $id)->delete();
        Session::flash('success', get_phrase('Live class has been deleted.'));
        return redirect()->back();
    }

    public function join_class($slug)
    {
        $current_time  = time();
        $extended_time = $current_time + (60 * 15);

        $class = BootcampLiveClass::join('bootcamp_modules', 'bootcamp_live_classes.module_id', 'bootcamp_modules.id')
            ->join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->where('bootcamp_live_classes.slug', $slug)
            ->where('bootcamp_live_classes.start_time', '<', $extended_time)
            ->where('bootcamp_live_classes.end_time', '>', $current_time)
            ->where('bootcamps.user_id', auth()->user()->id)
            ->select('bootcamp_live_classes.*', 'bootcamps.id as bootcamp_id', 'bootcamps.user_id as host_id')
            ->first();

        if (! $class) {
            Session::flash('error', get_phrase('Class not found.'));
            return redirect()->back();
        }

        if (get_settings('zoom_web_sdk') == 'active') {
            $page_data['class']   = $class;
            $page_data['user']    = get_user_info($class->host_id);
            $page_data['is_host'] = 1;
            return view('bootcamp_online_class.index', $page_data);
        } else {
            $meeting_info = json_decode($class->joining_data, true);
            return redirect($meeting_info['start_url']);
        }
    }

    public function stop_class($id)
    {
        $class = BootcampLiveClass::join('bootcamp_modules', 'bootcamp_live_classes.module_id', 'bootcamp_modules.id')
            ->join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->where('bootcamp_live_classes.id', $id)
            ->where('bootcamps.user_id', auth()->user()->id)
            ->select('bootcamp_live_classes.*', 'bootcamps.id as bootcamp_id')
            ->first();

        if (! $class) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $class->update(['force_stop' => 1]);
        Session::flash('success', get_phrase('Class has been ended.'));
        return redirect()->back();
    }

    public function sort(Request $request)
    {
        $classes = json_decode($request->itemJSON);
        foreach ($classes as $key => $value) {
            $updater = $key + 1;
            BootcampLiveClass::where('id', $value)->update(['sort' => $updater]);
        }

        return response()->json([
            'status'  => true,
            'success' => get_phrase('Classes sorted successfully'),
        ]);
    }
}
