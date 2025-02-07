<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Forum;
use App\Models\Lesson;
use App\Models\Watch_history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PlayerController extends Controller
{
    public function course_player(Request $request, $slug, $id = '')
    {
        $course = Course::where('slug', $slug)->first();

        // check if course is paid
        if ($course->is_paid && auth()->user()->role != 'admin') {
            if (auth()->user()->role == 'student') { // for student check enrollment
                $enrollment = Enrollment::where('course_id', $course->id)->where('user_id', auth()->user()->id)->first();
                if (! $enrollment) {
                    Session::flash('error', get_phrase('Not registered for this course.'));
                    return redirect()->route('my.courses');
                }
            } elseif (auth()->user()->role == 'instructor') { // for instructor check who is course instructor
                if ($course->user_id != auth()->user()->id) {
                    Session::flash('error', get_phrase('Not valid instructor.'));
                    return redirect()->route('my.courses');
                }
            }
        }

        $check_lesson_history = Watch_history::where('course_id', $course->id)
            ->where('student_id', auth()->user()->id)->first();
        $first_lesson_of_course = Lesson::where('course_id', $course->id)->orderBy('sort', 'asc')->value('id');
        if ($id == '') {
            $id = $check_lesson_history->watching_lesson_id ?? $first_lesson_of_course;
        }

        // if user has any watched history or not
        if (! $check_lesson_history && $id > 0) {
            $data = [
                'course_id'          => $course->id,
                'student_id'         => auth()->user()->id,
                'watching_lesson_id' => $id,
                'completed_lesson'   => json_encode([])
            ];
            Watch_history::insert($data);
        }

        // when user plays a lesson, update that lesson id as watch history
        if ($id > 0) {
            Watch_history::where('course_id', $course->id)
                ->where('student_id', auth()->user()->id)
                ->update(['watching_lesson_id' => $id]);
        }

        $page_data['course_details'] = $course;
        $page_data['lesson_details'] = Lesson::where('id', $id)->first();
        $page_data['history']        = Watch_history::where('course_id', $course->id)->where('student_id', auth()->user()->id)->first();

        $forum_query = Forum::join('users', 'forums.user_id', 'users.id')
            ->select('forums.*', 'users.name as user_name', 'users.photo as user_photo')
            ->latest('forums.id')
            ->where('forums.parent_id', 0)
            ->where('forums.course_id', $course->id);

        if (isset($_GET['search'])) {
            $forum_query->where(function ($query) use ($request) {
                $query->where('forums.title', 'like', '%' . $request->search . '%')->where('forums.description', 'like', '%' . $request->search . '%');
            });
        }

        $page_data['questions'] = $forum_query->get();

        return view('course_player.index', $page_data);
    }

    public function set_watch_history(Request $request)
    {
        $course     = Course::where('id', $request->course_id)->first();
        $enrollment = Enrollment::where('course_id', $course->id)->where('user_id', auth()->user()->id)->first();
        if (! $enrollment && (auth()->user()->role != 'admin' || ! is_course_instructor($course->id))) {
            Session::flash('error', get_phrase('Not registered for this course.'));
            return redirect()->back();
        }

        $data['course_id']  = $request->course_id;
        $data['student_id'] = auth()->user()->id;

        $total_lesson = Lesson::where('course_id', $request->course_id)->pluck('id')->toArray();

        $watch_history = Watch_history::where('course_id', $request->course_id)
            ->where('student_id', auth()->user()->id)->first();

        if (isset($watch_history)) {
            $lessons = (array) json_decode($watch_history->completed_lesson);
            if (! in_array($request->lesson_id, $lessons)) {
                array_push($lessons, $request->lesson_id);
            } else {
                while (($key = array_search($request->lesson_id, $lessons)) !== false) {
                    unset($lessons[$key]);
                }
            }

            $data['completed_lesson']   = json_encode($lessons);
            $data['watching_lesson_id'] = $request->lesson_id;
            $data['completed_date']     = (count($total_lesson) == count($lessons)) ? time() : null;
            Watch_history::where('course_id', $request->course_id)->where('student_id', auth()->user()->id)->update($data);
        } else {
            $lessons                    = [$request->lesson_id];
            $data['completed_lesson']   = json_encode($lessons);
            $data['watching_lesson_id'] = $request->lesson_id;
            $data['completed_date']     = (count($total_lesson) == count($lessons)) ? time() : null;
            Watch_history::insert($data);
        }

        if (progress_bar($request->course_id) >= 100) {
            $certificate = Certificate::where('user_id', auth()->user()->id)->where('course_id', $request->course_id);

            if ($certificate->count() == 0) {
                $certificate_data['user_id']    = auth()->user()->id;
                $certificate_data['course_id']  = $request->course_id;
                $certificate_data['identifier'] = random(12);
                $certificate_data['created_at'] = date('Y-m-d H:i:s');
                Certificate::insert($certificate_data);
            }
        }

        return redirect()->back();
    }

    public function prepend_watermark()
    {
        return view('course_player.watermark');
    }
}
