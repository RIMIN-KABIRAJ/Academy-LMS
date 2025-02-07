<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\FileUploader;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CurriculumController extends Controller
{
    public function store(Request $request)
    {
        $maximum_sort_value = Section::where('course_id', $request->course_id)->orderBy('sort', 'desc')->firstOrNew()->sort;
        $request->validate([
            'title' => 'required',
        ]);

        $section            = new Section();
        $section->title     = $request->title;
        $section->user_id   = auth()->user()->id;
        $section->course_id = $request->course_id;
        $section->sort      = $maximum_sort_value + 1;
        $done               = $section->save();
        Session::flash('success', get_phrase('Section added successfully'));
        return redirect()->back();
    }

    public function update(Request $request)
    {

        Section::where('id', $request->section_id)->update(['title' => $request->up_title]);
        Session::flash('success', get_phrase('update successfully'));
        return redirect()->back();
    }

    public function delete($id)
    {

        Section::where('id', $id)->delete();
        Session::flash('success', get_phrase('Delete successfully'));
        return redirect()->back();
    }

    public function section_sort(Request $request)
    {
        $sections = json_decode($request->itemJSON);
        foreach ($sections as $key => $value) {
            $updater = $key + 1;
            Section::where('id', $value)->update(['sort' => $updater]);
        }

        Session::flash('success', get_phrase('Sections sorted successfully'));
    }

    public function lesson_store(Request $request)
    {

        $maximum_sort_value = Lesson::where('course_id', $request->course_id)->orderBy('sort', 'desc')->firstOrNew()->sort;

        $data['title']       = $request->title;
        $data['user_id']     = auth()->user()->id;
        $data['course_id']   = $request->course_id;
        $data['section_id']  = $request->section_id;
        $data['sort']  = $maximum_sort_value + 1;
        $data['is_free']     = $request->free_lesson;
        $data['lesson_type'] = $request->lesson_type;
        $data['summary']     = $request->summary;
        if ($request->lesson_type == 'text') {
            $data['attachment']      = $request->text_description;
            $data['attachment_type'] = $request->lesson_provider;
        } elseif ($request->lesson_type == 'video-url') {

            $data['video_type'] = $request->lesson_provider;
            $data['lesson_src'] = $request->lesson_src;

            if (empty($request->duration)) {
                $data['duration']   =  '00:00:00';
            } else {
                $duration_formatter = explode(':', $request->duration);
                $hour               = sprintf('%02d', $duration_formatter[0]);
                $min                = sprintf('%02d', $duration_formatter[1]);
                $sec                = sprintf('%02d', $duration_formatter[2]);
                $data['duration']   = $hour . ':' . $min . ':' . $sec;
            }
        } elseif ($request->lesson_type == 'html5') {

            $data['video_type'] = $request->lesson_provider;
            $data['lesson_src'] = $request->lesson_src;
            if (empty($request->duration)) {
                $data['duration']   =  '00:00:00';
            } else {
                $duration_formatter = explode(':', $request->duration);
                $hour               = sprintf('%02d', $duration_formatter[0]);
                $min                = sprintf('%02d', $duration_formatter[1]);
                $sec                = sprintf('%02d', $duration_formatter[2]);
                $data['duration']   = $hour . ':' . $min . ':' . $sec;
            }
        } elseif ($request->lesson_type == 'document_type') {

            if ($request->attachment == '') {
                $file = '';
            } else {
                $item      = $request->file('attachment');
                $file_name = strtotime('now') . random(4) . '.' . $item->getClientOriginalExtension();

                $path = public_path('uploads/lesson_file/attachment');
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                } else {
                    FileUploader::upload($request->attachment, 'uploads/lesson_file/attachment/' . $file_name);
                }
                $file = $file_name;
            }
            $data['attachment']      = $file;
            $data['attachment_type'] = $request->attachment_type;
        } elseif ($request->lesson_type == 'image') {

            if ($request->attachment == '') {
                $file = '';
            } else {
                $item      = $request->file('attachment');
                $file_name = strtotime('now') . random(4) . '.' . $item->getClientOriginalExtension();

                $path = public_path('uploads/lesson_file/attachment');
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                } else {
                    FileUploader::upload($request->attachment, 'uploads/lesson_file/attachment/' . $file_name);
                }
                $file = $file_name;
            }
            $data['attachment']      = $file;
            $data['attachment_type'] = $item->getClientOriginalExtension();
        } elseif ($request->lesson_type == 'vimeo-url') {

            $data['video_type'] = $request->lesson_provider;
            $data['lesson_src'] = $request->lesson_src;
            if (empty($request->duration)) {
                $data['duration']   =  '00:00:00';
            } else {
                $duration_formatter = explode(':', $request->duration);
                $hour               = sprintf('%02d', $duration_formatter[0]);
                $min                = sprintf('%02d', $duration_formatter[1]);
                $sec                = sprintf('%02d', $duration_formatter[2]);
                $data['duration']   = $hour . ':' . $min . ':' . $sec;
            }
        } elseif ($request->lesson_type == 'iframe') {

            $data['lesson_src'] = $request->iframe_source;
        } elseif ($request->lesson_type == 'google_drive') {

            $data['video_type'] = $request->lesson_provider;
            $data['lesson_src'] = $request->lesson_src;
            if (empty($request->duration)) {
                $data['duration']   =  '00:00:00';
            } else {
                $duration_formatter = explode(':', $request->duration);
                $hour               = sprintf('%02d', $duration_formatter[0]);
                $min                = sprintf('%02d', $duration_formatter[1]);
                $sec                = sprintf('%02d', $duration_formatter[2]);
                $data['duration']   = $hour . ':' . $min . ':' . $sec;
            }
        } elseif ($request->lesson_type == 'system-video') {

            if ($request->system_video_file == '') {
                $file = '';
            } else {
                $item      = $request->file('system_video_file');
                $file_name = strtotime('now') . random(4) . '.' . $item->getClientOriginalExtension();

                $path = public_path('uploads/lesson_file/videos');
                if (! File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                $type = get_player_settings('watermark_type');
                if ($type == 'ffmpeg') {
                    $watermark = get_player_settings('watermark_logo');
                    if (! $watermark) {
                        return redirect()->back()->with('error', get_phrase('Please configure watermark setting.'));
                    }

                    if (! file_exists(public_path($watermark))) {
                        return redirect()->back()->with('error', get_phrase('File doesn\'t exists.'));
                    }

                    $watermark_status = WatermarkController::encode($item, $file_name, $path);
                    if (! $watermark_status) {
                        return redirect()->back()->with('error', get_phrase('Something went wrong.'));
                    }
                }
                FileUploader::upload($request->system_video_file, 'uploads/lesson_file/videos/' . $file_name);

                $file = str_replace(public_path('/'), '', $path).'/'. $file_name;
            }

            $data['video_type'] = $request->lesson_provider;
            $data['lesson_src'] = $file;
            if (empty($request->duration)) {
                $data['duration']   =  '00:00:00';
            } else {
                $duration_formatter = explode(':', $request->duration);
                $hour               = sprintf('%02d', $duration_formatter[0]);
                $min                = sprintf('%02d', $duration_formatter[1]);
                $sec                = sprintf('%02d', $duration_formatter[2]);
                $data['duration']   = $hour . ':' . $min . ':' . $sec;
            }
        }

        Lesson::insert($data);
        Session::flash('success', get_phrase('lesson added successfully'));
        return redirect()->back();
    }

    public function lesson_sort(Request $request)
    {
        $lessons = json_decode($request->itemJSON);
        foreach ($lessons as $key => $value) {
            $updater = $key + 1;
            Lesson::where('id', $value)->update(['sort' => $updater]);
        }
        Session::flash('success', get_phrase('Lessons sorted successfully'));
    }

    public function lesson_edit(Request $request)
    {
        $current_data = Lesson::find($request->id);

        $lesson['title']      = $request->title;
        $lesson['section_id'] = $request->section_id;
        $lesson['summary']    = $request->summary;
        if ($request->lesson_type == 'text') {
            $lesson['attachment'] = $request->text_description;
        } elseif ($request->lesson_type == 'video-url') {
            $lesson['lesson_src'] = $request->lesson_src;
            if (empty($request->duration)) {
                $data['duration']   =  '00:00:00';
            } else {
                $duration_formatter = explode(':', $request->duration);
                $hour               = sprintf('%02d', $duration_formatter[0]);
                $min                = sprintf('%02d', $duration_formatter[1]);
                $sec                = sprintf('%02d', $duration_formatter[2]);
                $data['duration']   = $hour . ':' . $min . ':' . $sec;
            }
        } elseif ($request->lesson_type == 'html5') {
            $lesson['lesson_src'] = $request->lesson_src;
            if (empty($request->duration)) {
                $data['duration']   =  '00:00:00';
            } else {
                $duration_formatter = explode(':', $request->duration);
                $hour               = sprintf('%02d', $duration_formatter[0]);
                $min                = sprintf('%02d', $duration_formatter[1]);
                $sec                = sprintf('%02d', $duration_formatter[2]);
                $data['duration']   = $hour . ':' . $min . ':' . $sec;
            }
        } elseif ($request->lesson_type == 'document_type') {
            if ($request->attachment) {
                $item      = $request->file('attachment');
                $file_name = strtotime('now') . random(4) . '.' . $item->getClientOriginalExtension();

                $path = public_path('uploads/lesson_file/attachment');
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                } else {
                    FileUploader::upload($request->attachment, 'uploads/lesson_file/attachment/' . $file_name);
                }
                $lesson['attachment']      = $file_name;
                $lesson['attachment_type'] = $request->attachment_type;

                remove_file('uploads/lesson_file/attachment/'.$current_data->attachment);
            }
        } elseif ($request->lesson_type == 'image') {
            if ($request->attachment) {
                $item      = $request->file('attachment');
                $file_name = strtotime('now') . random(4) . '.' . $item->getClientOriginalExtension();

                $path = public_path('uploads/lesson_file/attachment');
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                } else {
                    FileUploader::upload($request->attachment, 'uploads/lesson_file/attachment/' . $file_name);
                }
                $lesson['attachment']      = $file_name;
                $lesson['attachment_type'] = $item->getClientOriginalExtension();
                remove_file('uploads/lesson_file/attachment/'.$current_data->attachment);
            }
        } elseif ($request->lesson_type == 'vimeo-url') {
            $lesson['lesson_src'] = $request->lesson_src;
            if (empty($request->duration)) {
                $data['duration']   =  '00:00:00';
            } else {
                $duration_formatter = explode(':', $request->duration);
                $hour               = sprintf('%02d', $duration_formatter[0]);
                $min                = sprintf('%02d', $duration_formatter[1]);
                $sec                = sprintf('%02d', $duration_formatter[2]);
                $data['duration']   = $hour . ':' . $min . ':' . $sec;
            }
        } elseif ($request->lesson_type == 'iframe') {
            $lesson['lesson_src'] = $request->iframe_source;
        } elseif ($request->lesson_type == 'google_drive') {
            $lesson['lesson_src'] = $request->lesson_src;
            if (empty($request->duration)) {
                $data['duration']   =  '00:00:00';
            } else {
                $duration_formatter = explode(':', $request->duration);
                $hour               = sprintf('%02d', $duration_formatter[0]);
                $min                = sprintf('%02d', $duration_formatter[1]);
                $sec                = sprintf('%02d', $duration_formatter[2]);
                $data['duration']   = $hour . ':' . $min . ':' . $sec;
            }
        } elseif ($request->lesson_type == 'system-video') {

            if ($request->system_video_file) {
                $item      = $request->file('system_video_file');
                $file_name = strtotime('now') . random(4) . '.' . $item->getClientOriginalExtension();

                $path = public_path('uploads/lesson_file/videos');
                if (! File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                $type = get_player_settings('watermark_type');
                if ($type == 'ffmpeg') {
                    $watermark = get_player_settings('watermark_logo');
                    if (! $watermark) {
                        return redirect()->back()->with('error', get_phrase('Please configure watermark setting.'));
                    }

                    if (! file_exists(public_path($watermark))) {
                        return redirect()->back()->with('error', get_phrase('File doesn\'t exists.'));
                    }

                    $watermark_status = WatermarkController::encode($item, $file_name, $path);
                    if (! $watermark_status) {
                        return redirect()->back()->with('error', get_phrase('Something went wrong.'));
                    }
                }
                FileUploader::upload($request->system_video_file, 'uploads/lesson_file/videos/' . $file_name);

                $file = str_replace(public_path('/'), '', $path).'/'. $file_name;
                $lesson['lesson_src'] = $file;
                remove_file($current_data->lesson_src);
            }

            if (empty($request->duration)) {
                $data['duration']   =  '00:00:00';
            } else {
                $duration_formatter = explode(':', $request->duration);
                $hour               = sprintf('%02d', $duration_formatter[0]);
                $min                = sprintf('%02d', $duration_formatter[1]);
                $sec                = sprintf('%02d', $duration_formatter[2]);
                $data['duration']   = $hour . ':' . $min . ':' . $sec;
            }
        }

        Lesson::where('id', $request->id)->update($lesson);
        Session::flash('success', get_phrase('lesson update successfully'));
        return redirect()->back();
    }

    public function lesson_delete($id)
    {
        $current_data = Lesson::find($id);
        remove_file($current_data->lesson_src);
        remove_file('uploads/lesson_file/attachment/'.$current_data->attachment);
        
        Lesson::where('id', $id)->delete();
        Session::flash('success', get_phrase('Delete successfully'));
        return redirect()->back();
    }
}
