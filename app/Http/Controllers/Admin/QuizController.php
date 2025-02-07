<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'      => 'required',
            'section'    => 'required|numeric',
            'second'     => 'max:59',
            'minute'     => 'max:59',
            'hour'       => 'max:23',
            'total_mark' => 'required|numeric',
            'pass_mark'  => 'required|numeric',
            'retake'     => 'required|numeric|min:1',
        ])->after(function ($validator) use ($request) {
            $hour   = $request->hour;
            $minute = $request->minute;
            $second = $request->second;

            if ($hour == 0 && $minute == 0 && $second == 0) {
                $validator->errors()->add('second', 'If hour and minute are 0, second must be greater than 0.');
            } elseif ($hour == 0 && $minute == 0 && $second < 1) {
                $validator->errors()->add('minute', 'If hour is 0, minute must be greater than 0.');
            } elseif ($minute == 0 && $second == 0 && $hour < 1) {
                $validator->errors()->add('hour', 'If minute and second are 0, hour must be greater than 0.');
            }

            if ($request->pass_mark > $request->total_mark) {
                $validator->errors()->add('pass_mark', 'The pass mark must be less than the total mark.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $title = Lesson::join('sections', 'lessons.section_id', 'sections.id')
            ->join('courses', 'sections.course_id', 'courses.id')
            ->where('courses.user_id', auth()->user()->id)
            ->where('lessons.title', $request->title)
            ->first();
        if ($title) {
            Session::flash('error', get_phrase('Title has been taken.'));
            return redirect()->back();
        }

        $data['title']       = $request->title;
        $data['section_id']  = $request->section;
        $data['total_mark']  = $request->total_mark;
        $data['pass_mark']   = $request->pass_mark;
        $data['retake']      = $request->retake;
        $data['description'] = $request->description;
        $data['lesson_type'] = 'quiz';
        $data['status']      = 1;

        $hour             = $request->hour ?? 0;
        $minute           = $request->minute ?? 0;
        $second           = $request->second ?? 0;
        $data['duration'] = $hour . ':' . $minute . ':' . $second;

        Lesson::insert($data);

        Session::flash('success', get_phrase('Quiz has been created.'));
        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'      => 'required',
            'section'    => 'required|numeric',
            'second'     => 'max:59',
            'minute'     => 'max:59',
            'hour'       => 'max:23',
            'total_mark' => 'required|numeric',
            'pass_mark'  => 'required|numeric',
            'retake'     => 'required|numeric|min:1',
        ])->after(function ($validator) use ($request) {
            $hour   = $request->hour;
            $minute = $request->minute;
            $second = $request->second;

            if ($hour == 0 && $minute == 0 && $second == 0) {
                $validator->errors()->add('second', 'If hour and minute are 0, second must be greater than 0.');
            } elseif ($hour == 0 && $minute == 0 && $second < 1) {
                $validator->errors()->add('minute', 'If hour is 0, minute must be greater than 0.');
            } elseif ($minute == 0 && $second == 0 && $hour < 1) {
                $validator->errors()->add('hour', 'If minute and second are 0, hour must be greater than 0.');
            }

            if ($request->pass_mark > $request->total_mark) {
                $validator->errors()->add('pass_mark', 'The pass mark must be less than the total mark.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $title = Lesson::join('sections', 'lessons.section_id', 'sections.id')
            ->join('courses', 'sections.course_id', 'courses.id')
            ->where('lessons.id', '!=', $id)
            ->where('lessons.title', $request->title)
            ->where('courses.user_id', auth()->user()->id)
            ->first();
        if ($title) {
            Session::flash('error', get_phrase('Title has been taken.'));
            return redirect()->back();
        }

        $data['title']       = $request->title;
        $data['section_id']  = $request->section;
        $data['total_mark']  = $request->total_mark;
        $data['pass_mark']   = $request->pass_mark;
        $data['retake']      = $request->retake;
        $data['description'] = $request->description;
        $data['lesson_type'] = 'quiz';
        $data['status']      = 1;

        $hour             = $request->hour ?? 0;
        $minute           = $request->minute ?? 0;
        $second           = $request->second ?? 0;
        $data['duration'] = $hour . ':' . $minute . ':' . $second;

        Lesson::where('id', $id)->update($data);

        Session::flash('success', get_phrase('Quiz has been updated.'));
        return redirect()->back();
    }

    public function result(Request $request)
    {
        $submissions = QuizSubmission::where('quiz_id', $request->quizId)
            ->where('user_id', $request->participant)->get();

        $result[] = "<option>" . get_phrase('Select an option') . "</option>";
        foreach ($submissions as $key => $submission) {
            $result[] = "<option value=" . $submission->id . ">Attempt " . ++$key . "</option>";
        }
        return $result;
    }

    public function result_preview(Request $request)
    {
        $page_data['quiz']      = Lesson::where('id', $request->quizId)->first();
        $page_data['results']   = QuizSubmission::where('quiz_id', $request->quizId)->where('user_id', $request->participantId)->get();
        $page_data['questions'] = Question::where('quiz_id', $request->quizId)->get();
        return view('admin.quiz_result.preview', $page_data);
    }
}
