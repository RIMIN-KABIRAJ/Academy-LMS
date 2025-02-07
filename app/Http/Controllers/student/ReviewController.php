<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\BlogLike;
use App\Models\Course;
use App\Models\LikeDislikeReview;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $data['course_id']   = $request->course_id;
        $data['user_id']     = auth()->user()->id;
        $data['review']      = $request->review;
        $data['review_type'] = 'course';
        $data['rating']      = $request->rating;

        Review::insert($data);

        // update course rating
        $query        = Review::where('course_id', $request->course_id)->where('review_type', 'course');
        $total_rating = $query->sum('rating');
        $avg_rating   = $total_rating / $query->count();
        Course::where('id', $request->course_id)->update(['average_rating' => round($avg_rating)]);

        Session::flash('success', get_phrase('You review has been saved.'));
        return redirect()->back();
    }

    public function delete($id)
    {
        // if user has selected item then delete item else redirect to cart page
        if (Review::where('id', $id)->where('user_id', auth()->user()->id)->exists()) {
            Review::where('id', $id)->delete();
            Session::flash('success', get_phrase('Your review has been deleted.'));
        } else {
            Session::flash('error', get_phrase('Data not found.'));
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        // validate id
        if (!is_numeric($id) && $id < 1) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $data['course_id']   = $request->course_id;
        $data['user_id']     = auth()->user()->id;
        $data['review']      = $request->review;
        $data['review_type'] = 'course';
        $data['rating']      = $request->rating;

        Review::where('id', $id)->update($data);

        Session::flash('success', get_phrase('Your review has been updated.'));
        return redirect()->back();
    }

    public function like($id)
    {
        // validate id
        if (!is_numeric($id) && $id < 1) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $status = LikeDislikeReview::where('user_id', auth()->user()->id)
            ->where('review_id', $id)->first();

        // if there is no like dislike then insert
        if ($status) {
            if ($status->liked) {
                $status->delete();
            } else {
                $status->update(['liked' => 1, 'disliked' => 0]);
            }
        } else {
            $like['user_id']   = auth()->user()->id;
            $like['review_id'] = $id;
            $like['liked']     = 1;
            LikeDislikeReview::insert($like);
        }
        Session::flash('success', get_phrase('Your changes has been saved'));
        return redirect()->back();
    }

    public function dislike($id)
    {
        // validate id
        if (!is_numeric($id) && $id < 1) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $status = LikeDislikeReview::where('user_id', auth()->user()->id)
            ->where('review_id', $id)->first();

        // if there is no like dislike then insert
        if ($status) {
            if ($status->disliked) {
                $status->delete();
            } else {
                $status->update(['disliked' => 1, 'liked' => 0]);
            }
        } else {
            $like['user_id']   = auth()->user()->id;
            $like['review_id'] = $id;
            $like['disliked']  = 1;
            LikeDislikeReview::insert($like);
        }
        Session::flash('success', get_phrase('Your changes has been saved'));
        return redirect()->back();
    }
}
