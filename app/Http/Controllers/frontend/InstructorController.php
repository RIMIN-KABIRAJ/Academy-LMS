<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InstructorController extends Controller
{
    public function index()
    {
        $page_data['instructors'] = User::where('role', 'instructor')->latest('id')->paginate(8);
        $view_path                = 'frontend.' . get_frontend_settings('theme') . '.instructor.index';
        return view($view_path, $page_data);
    }

    public function show($name, $id)
    {
        $instructor = User::where('id', $id)->first();

        // if instructor doesn't exists go back
        if (!$instructor && $instructor->name != $name) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $instructor_courses = Course::join('users', 'courses.user_id', '=', 'users.id')
            ->select('courses.*', 'users.name as instructor_name', 'users.email as instructor_email', 'users.photo as instructor_image')
            ->where('courses.status', 'active')
            ->where('courses.user_id', $instructor->id)
            ->latest('id')->paginate(6);

        $page_data['instructor_details'] = $instructor;
        $page_data['instructor_courses'] = $instructor_courses;
        $view_path                       = 'frontend.' . get_frontend_settings('theme') . '.instructor.details';
        return view($view_path, $page_data);
    }
}
