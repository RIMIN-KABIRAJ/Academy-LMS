<?php

namespace App\Http\Controllers\instructor;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Models\FileUploader;


class LessonController extends Controller
{
    public function store(Request $request)
    {
        $maximum_sort_value = Lesson::where('course_id', $request->course_id)->orderBy('sort', 'desc')->firstOrNew()->sort;
        // duplicate check
        if (Lesson::where('course_id', $request->course_id)->where('title', $request->title)->exists()) {
            Session::flash('error', get_phrase('Lesson already exists.'));
            return redirect()->back();
        }

        $lesson              = new Lesson();
        $lesson->title       = $request->title;
        $lesson->user_id     = auth()->user()->id;
        $lesson->course_id   = $request->course_id;
        $lesson->section_id  = $request->section_id;
        $lesson->is_free     = $request->free_lesson;
        $lesson->lesson_type = $request->lesson_type;
        $lesson->summary     = $request->summary;
        $lesson->sort     = $maximum_sort_value+1;
        if ($request->lesson_type == 'text') {
            $lesson->attachment      = $request->text_description;
            $lesson->attachment_type = $request->lesson_provider;
        } elseif ($request->lesson_type == 'video-url') {

            $lesson->video_type = $request->lesson_provider;
            $lesson->lesson_src = $request->lesson_src;
            $lesson->duration   = $request->duration;
        } elseif ($request->lesson_type == 'html5') {

            $lesson->video_type = $request->lesson_provider;
            $lesson->lesson_src = $request->lesson_src;
            $lesson->duration   = $request->duration;
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
            $lesson->attachment      = $file;
            $lesson->attachment_type = $request->attachment_type;
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
            $lesson->attachment      = $file;
            $lesson->attachment_type = $item->getClientOriginalExtension();
        } elseif ($request->lesson_type == 'vimeo-url') {

            $lesson->video_type = $request->lesson_provider;
            $lesson->lesson_src = $request->lesson_src;
            $lesson->duration   = $request->duration;
        } elseif ($request->lesson_type == 'iframe') {

            $lesson->lesson_src = $request->iframe_source;
        } elseif ($request->lesson_type == 'google_drive') {

            $lesson->video_type = $request->lesson_provider;
            $lesson->lesson_src = $request->lesson_src;
            $lesson->duration   = $request->duration;
        } elseif ($request->lesson_type == 'system-video') {

            if ($request->system_video_file == '') {
                $file = '';
            } else {
                $item      = $request->file('system_video_file');
                $file_name = strtotime('now') . random(4) . '.' . $item->getClientOriginalExtension();

                $path = public_path('uploads/lesson_file/videos');
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                } else {
                    FileUploader::upload($request->system_video_file, 'uploads/lesson_file/videos/' . $file_name);
                }
                $file = $file_name;
            }
            $lesson->video_type = $request->lesson_provider;
            $lesson->lesson_src = $file;
            $lesson->duration   = $request->system_video_file_duration;
        }

        $lesson->save();
        Session::flash('success', get_phrase('Lesson added successfully.'));
        return redirect()->back();
    }

    public function sort(Request $request)
    {
        $lessons = json_decode($request->itemJSON);
        foreach ($lessons as $key => $value) {
            $updater = $key + 1;
            Lesson::where('id', $value)->update(['sort' => $updater]);
        }
    }

    public function update(Request $request)
    {
        // duplicate check
        if (Lesson::where('course_id', $request->course_id)->where('title', $request->title)->exists()) {
            Session::flash('error', get_phrase('Lesson already exists.'));
            return redirect()->back();
        }


        $lesson['title']      = $request->title;
        $lesson['section_id'] = $request->section_id;
        $lesson['summary']    = $request->summary;

        if ($request->lesson_type == 'text') {
            $lesson['attachment'] = $request->text_description;
        } elseif ($request->lesson_type == 'video-url') {
            $lesson['lesson_src'] = $request->lesson_src;
            $lesson['duration']   = $request->duration;
        } elseif ($request->lesson_type == 'html5') {
            $lesson['lesson_src'] = $request->lesson_src;
            $lesson['duration']   = $request->duration;
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
            $lesson['attachment']      = $file;
            $lesson['attachment_type'] = $request->attachment_type;
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
            $lesson['attachment']      = $file;
            $lesson['attachment_type'] = $item->getClientOriginalExtension();
        } elseif ($request->lesson_type == 'vimeo-url') {
            $lesson['lesson_src'] = $request->lesson_src;
            $lesson['duration']   = $request->duration;
        } elseif ($request->lesson_type == 'iframe') {
            $lesson['lesson_src'] = $request->iframe_source;
        } elseif ($request->lesson_type == 'google_drive') {

            $lesson['lesson_src'] = $request->lesson_src;
            $lesson['duration']   = $request->duration;
        } elseif ($request->lesson_type == 'system-video') {

            if ($request->system_video_file == '') {
                $file = '';
            } else {
                $item      = $request->file('system_video_file');
                $file_name = strtotime('now') . random(4) . '.' . $item->getClientOriginalExtension();

                $path = public_path('uploads/lesson_file/videos');
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                } else {
                    FileUploader::upload($request->system_video_file, 'uploads/lesson_file/videos/' . $file_name);
                }
                $file = $file_name;
            }

            $lesson['lesson_src'] = $file;
            $lesson['duration']   = $request->system_video_file_duration;
        }

        Lesson::where('id', $request->id)->update($lesson);
        Session::flash('success', get_phrase('lesson update successfully'));
        return redirect()->back();
    }

    public function delete($id)
    {
        Lesson::where('id', $id)->delete();
        Session::flash('success', get_phrase('Delete successfully'));
        return redirect()->back();
    }
}
