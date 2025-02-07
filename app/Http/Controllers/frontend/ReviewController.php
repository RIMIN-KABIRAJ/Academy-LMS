<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Instructor_review;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function instructor_review_store(Request $request)
    {
        $data['instructor_id'] = $request->instructor_id;
        $data['user_id'] = Auth()->user()->id;
        $data['review'] = $request->comment;
        $data['rating'] = $request->rating;

        Instructor_review::insert($data);
        return redirect()->back();
    }
    public function instructor_details($id)
    {
        $page_data['instructor'] = User::where('id', $id)->first();
        return view('frontend.instructor.instructor_details', $page_data);
    }
}
