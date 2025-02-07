<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\TeamTrainingPackage;
use Illuminate\Http\Request;

class TeamTrainingController extends Controller
{
    public function index($course_category = '')
    {
        $query = TeamTrainingPackage::join('courses', 'team_training_packages.course_id', 'courses.id')
            ->join('users', 'team_training_packages.user_id', 'users.id')
            ->where('team_training_packages.status', 1)
            ->select(
                'team_training_packages.*',
                'courses.title as course_title',
                'courses.slug as course_slug',
                'courses.price as course_price',
                'users.name as creator_name',
                'users.email as creator_email',
                'users.photo as creator_photo',
            );

        if (request()->has('search')) {
            $query = $query->where('team_training_packages.title', 'LIKE', "%" . request()->query('search') . "%");
        }

        if ($course_category) {
            $category_details = Category::where('slug', $course_category)->first();
            if ($category_details->parent_id == 0) {
                $sub_cat_id = Category::where('parent_id', $category_details->id)->pluck('id');
                $courses    = Course::whereIn('category_id', $sub_cat_id)->pluck('id')->toArray();
            } else {
                $courses = Course::where('category_id', $category_details->id)->pluck('id')->toArray();
            }

            $query = $query->where('course_id', $courses);
        }

        $page_data['packages'] = $query->latest('id')->paginate(5)->appends(request()->query());
        return view('frontend.default.team_training.index', $page_data);
    }

    public function show($slug)
    {
        $page_data['package'] = TeamTrainingPackage::join('courses', 'team_training_packages.course_id', 'courses.id')
            ->join('users', 'team_training_packages.user_id', 'users.id')
            ->select(
                'team_training_packages.*',
                'courses.title as course_title',
                'courses.slug as course_slug',
                'courses.price as course_price',
                'users.name as creator_name',
                'users.email as creator_email',
                'users.photo as creator_photo',
            )
            ->where('team_training_packages.slug', $slug)
            ->first();

        if (! $page_data['package']) {
            return redirect()->back()->with('error', get_phrase('Data not found.'));
        }
        return view('frontend.default.team_training.details', $page_data);
    }
}
