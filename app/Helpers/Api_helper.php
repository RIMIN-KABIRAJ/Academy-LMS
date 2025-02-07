<?php
// import facade

use App\Models\Addon;
use App\Models\NotificationSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\{Course, Category, Review};

//Api related
if (!function_exists('enroll_history')) {
    function enroll_history($course_id = "", $distinct_data = false)
    {
        if ($distinct_data) {
            $enroll_hoistory = DB::table('enrollments')->select('user_id')
                ->distinct()
                ->where('course_id', $course_id)
                ->get();
            return $enroll_hoistory;
        } else {
            if ($course_id > 0) {
                return DB::table('enrollments')->where('course_id', $course_id)->get();
            } else {
                return DB::table('enrollments')->get();
            }
        }
    }
}

// Return require course data
if (!function_exists('course_data')) {
    function course_data($courses = array())
    {
        foreach ($courses as $key => $course) {
            $courses[$key]->requirements = json_decode($course->requirements);
            $courses[$key]->outcomes = json_decode($course->outcomes);
            $courses[$key]->thumbnail = get_photo('course_thumbnail', $course->thumbnail);
            $courses[$key]->banner = get_photo('course_banner', $course->banner);
            $courses[$key]->preview = get_photo('course_preview', $course->preview);
            // $courses[$key]->enable_drip_content = $course->enable_drip_content;
            if ($course->is_paid == 0) {
                $courses[$key]->price = 'Free';
            } else {
                if ($course->discount_flag == 1) {
                    $courses[$key]->price = currency($course->discounted_price);
                    $courses[$key]->price_cart = $course->discounted_price;
                } else {
                    $courses[$key]->price = currency($course->price);
                    $courses[$key]->price_cart = $course->price;
                }
            }
            // // $total_rating =  get_ratings('course', $course->id, true)->row()->rating;
            // // $number_of_ratings = get_ratings('course', $course->id)->num_rows();
            // if ($number_of_ratings > 0) {
            // 	$courses[$key]->rating = ceil($total_rating / $number_of_ratings);
            // } else {
            // 	$courses[$key]->rating = 0;
            // }
            // $courses[$key]->number_of_ratings = $number_of_ratings;
            $instructor_details = get_user_info($course->user_id);
            $courses[$key]->instructor_name = $instructor_details->name;
            $courses[$key]->instructor_image = url('public/' . $instructor_details->photo);
            $courses[$key]->total_enrollment = enroll_history($course->id)->count();
            $courses[$key]->shareable_link = url('course/' . slugify($course->title));

            $review = Review::where('course_id', $course->id)->get();

            $total = $review->count();
            $rating = array_sum(array_column($review->toArray(), 'rating'));

            $average_rating = 0.0;
            if ($total != 0.0) {
                $average_rating = round($rating / $total);
            }

            $courses[$key]->total_reviews = $total;
            // $courses[$key]->average_rating = $course->average_rating;
            $courses[$key]->average_rating = number_format($average_rating, 1, '.', '');

        }

        return $courses;
    }
}

if (!function_exists('get_photo')) {
    function get_photo($type, $identifier)
    { // type is the flag to realize whether it is course, category or user image. For course, user image Identifier is id but for category Identifier is image name
        if ($type == 'user_image') {
            if (file_exists('public/' . $identifier) && $identifier != "") {
                return url('public/' . $identifier);
            } else {
                return url('public/uploads/users/student/placeholder/placeholder.png');
                return url('public/uploads/users/student/placeholder/placeholder.png');
            }
        } elseif ($type == 'course_thumbnail') {
            if (file_exists('public/' . $identifier) && $identifier != "") {
                return url('public/' . $identifier);
            } else {
                return url('public/uploads/course-thumbnail/placeholder/placeholder.png');
            }
        } elseif ($type == 'course_banner') {
            if (file_exists('public/' . $identifier) && $identifier != "") {
                return url('public/' . $identifier);
            } else {
                return url('public/uploads/course-banner/placeholder/placeholder.png');
            }
        } elseif ($type == 'course_preview') {
            if (file_exists('public/' . $identifier) && $identifier != "") {
                return url('public/' . $identifier);
            } else {
                return url('public/uploads/course-preview/placeholder/placeholder.png');
            }
        } elseif ($type == 'category_thumbnail') {
            if (file_exists('public/' . $identifier) && $identifier != "") {
                return url('public/' . $identifier);
            } else {
                return url('public/uploads/category-thumbnail/placeholder/placeholder.png');
            }
        }
    }

}

if (!function_exists('get_category_wise_courses')) {
    function get_category_wise_courses($category_id = "")
    {
        // $category_details = get_category_details_by_id($category_id);

        $courses = Course::where('category_id', $category_id)->where('status', 'active')->get();
        return $courses;
    }
}

if (!function_exists('get_category_details_by_id')) {
    function get_category_details_by_id($id)
    {
        return DB::table('categories')->where('id', $id)->get();
    }
}

if (!function_exists('sub_categories')) {
    // Get sub categories
    function sub_categories($parent_category_id)
    {
        $response = array();

        $categories = DB::table('categories')->where('parent_id', $parent_category_id)->get();

        foreach ($categories as $key => $category) {

            $number_of_courses = DB::table('courses')->where('status', 'active')->where('category_id', $category->id)->count();
            $category->number_of_courses = $number_of_courses;
            $category->thumbnail = get_photo('category_thumbnail', $category->thumbnail);
            $response[] = $category;
        }

        return $response;

    }
}

if (!function_exists('course_details_by_id')) {
    // Get sub categories
    function course_details_by_id($user_id = "", $course_id = "")
    {
        $course_details = get_course_by_id($course_id);

        $response = course_data($course_details);

        foreach ($response as $key => $resp) {
            $response[$key]->sections = sections($course_id);
            $response[$key]->is_wishlisted = is_added_to_wishlist($user_id, $course_id);
            $response[$key]->is_purchased = is_purchased($user_id, $course_id);
            $response[$key]->includes = array(
                get_total_duration_of_lesson_by_course_id($course_id) . ' On demand videos',
                get_lessons('course', $course_id)->count() . ' Lessons',
                'High quality videos',
                'Life time access'
            );
        }
        return $response;

    }
}

function get_course_by_id($course_id = "")
{
    return DB::table('courses')->where('id', $course_id)->get();
}

function is_added_to_wishlist($user_id = 0, $course_id = "")
{
    if ($user_id > 0) {
        $wishlists = array();
        $wishlist_check = DB::table('wishlists')->where('user_id', $user_id)->where('course_id', $course_id)->first();
        if (!empty($wishlist_check)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function is_purchased($user_id = 0, $course_id = "")
{
    // 0 represents Not purchased, 1 represents Purchased, 2 represents Pending
    if ($user_id > 0) {
        if (enroll_status($course_id, $user_id) == 'valid') {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

if (!function_exists('enroll_status')) {
    function enroll_status($course_id = "", $user_id = "")
    {

        $enrolled_history = DB::table('enrollments')->where('user_id', $user_id)->where('course_id', $course_id)->first();

        if (!empty($enrolled_history)) {
            $expiry_date = $enrolled_history->expiry_date;
            if ($expiry_date == null || $expiry_date >= time()) {
                return 'valid';
            } else {
                return 'expired';
            }
        } else {
            return false;
        }
    }
}

function get_total_duration_of_lesson_by_course_id($course_id)
{
    $total_duration = 0;
    $lessons = get_lessons('course', $course_id);
    foreach ($lessons as $lesson) {
        if ($lesson->lesson_type != "other" && $lesson->lesson_type != "text") {
            $time_array = !empty($lesson->duration) ? explode(':', $lesson->duration) : explode(':', '00:00:00');
            $hour_to_seconds = $time_array[0] * 60 * 60;
            $minute_to_seconds = $time_array[1] * 60;
            $seconds = $time_array[2];
            $total_duration += $hour_to_seconds + $minute_to_seconds + $seconds;
        }
    }
    // return gmdate("H:i:s", $total_duration).' '.get_phrase('hours');
    $hours = floor($total_duration / 3600);
    $minutes = floor(($total_duration % 3600) / 60);
    $seconds = $total_duration % 60;
    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds) . ' ' . get_phrase('hours');
}

if (!function_exists('course_progress')) {
    function course_progress($course_id = "", $user_id = "", $return_type = "")
    {
        $watch_history = DB::table('watch_histories')->where('student_id', $user_id)->where('course_id', $course_id)->first();
        $total_lessons = DB::table('lessons')->where('course_id', $course_id)->count();

        if (!empty($watch_history)) {
            $completed_lessons = json_decode($watch_history->completed_lesson, true);
            // Check if completed_lesson is an array and is not empty
            if (is_array($completed_lessons) && !empty($completed_lessons)) {
                $total_completed_lesson = count($completed_lessons);
                $watch_history->course_progress = ($total_completed_lesson / $total_lessons) * 100;
            } else {
                $total_completed_lesson = 0;
                $watch_history->course_progress = 0; // Ensure course_progress is set to 0 if no lessons are completed
            }
        } else {
            $total_completed_lesson = 0;
        }

        if ($return_type == "completed_lesson_ids") {
            // Return completed_lesson as an array, or an empty array if it's empty
            return is_array($completed_lessons) ? $completed_lessons : [];
        }
        if (!empty($watch_history) && $watch_history->course_progress > 0) {
            return $watch_history->course_progress;
        } else {
            return 0;
        }
    }

}

if (!function_exists('lesson_progress_api')) {
    function lesson_progress_api($lesson_id = "", $user_id = "", $course_id = "")
    {
        if ($course_id == "") {
            $course_id = DB::table('lessons')->where('id', $lesson_id)->value('course_id');
        }

        $query = DB::table('watch_histories')->where('student_id', $user_id)->where('course_id', $course_id)->first();

        if (!empty($query)) {
            $lesson_ids = json_decode($query->completed_lesson, true);
            if (is_array($lesson_ids) && in_array($lesson_id, $lesson_ids)) {
                return 1;
            } else {
                return 0;
            }
        }
    }
}

if (!function_exists('get_lessons')) {
    function get_lessons($type = "", $id = "")
    {
        $lessons = array();

        if ($type == "course") {
            $lessons = DB::table('lessons')->where('course_id', $id)->orderBy("sort", "asc")->get();
        } elseif ($type == "section") {
            $lessons = DB::table('lessons')->where('section_id', $id)->orderBy("sort", "asc")->get();
        } elseif ($type == "lesson") {
            $lessons = DB::table('lessons')->where('id', $id)->orderBy("sort", "asc")->get();
        } else {
            $lessons = DB::table('lessons')->orderBy("sort", "asc")->get();
        }

        return $lessons;
    }
}

if (!function_exists('update_watch_history_manually')) {
    // code of mark this lesson as completed
    function update_watch_history_manually($lesson_id = "", $course_id = "", $user_id = "")
    {
        $is_completed = 0;

        $query = DB::table('watch_histories')->where('course_id', $course_id)->where('student_id', $user_id)->first();

        $course_progress = course_progress($course_id, $user_id);

        if (!empty($query)) {
            $lesson_ids = json_decode($query->completed_lesson, true);
            if (!is_array($lesson_ids))
                $lesson_ids = array();
            if (!in_array($lesson_id, $lesson_ids)) {
                array_push($lesson_ids, $lesson_id);
                $total_lesson = DB::table('lessons')->where('course_id', $course_id)->get();
                $course_progress = (100 / count($total_lesson)) * count($lesson_ids);

                if ($course_progress >= 100 && $query->completed_date == null) {
                    $completed_date = time();
                } else {
                    $completed_date = $query->completed_date;
                }

                DB::table('watch_histories')->where('id', $query->id)->update([
                    'completed_lesson' => json_encode($lesson_ids),
                    'completed_date' => $completed_date,
                ]);

                $is_completed = 1;

            } else {
                if (($key = array_search($lesson_id, $lesson_ids)) !== false) {
                    unset($lesson_ids[$key]);
                }

                $total_lesson = DB::table('lessons')->where('course_id', $course_id)->get();
                $course_progress = (100 / count($total_lesson)) * count($lesson_ids);

                if ($course_progress >= 100 && $query->completed_date == null) {
                    $completed_date = time();
                } else {
                    $completed_date = $query->completed_date;
                }

                DB::table('watch_histories')->where('id', $query->id)->update([
                    'completed_lesson' => json_encode($lesson_ids),
                    'completed_date' => $completed_date,
                ]);

                $is_completed = 0;
            }

        } else {
            $total_lesson = DB::table('lessons')->where('course_id', $course_id)->get();
            $course_progress = (100 / count($total_lesson));

            $insert_data['course_id'] = $course_id;
            $insert_data['student_id'] = $user_id;
            $insert_data['completed_lesson'] = json_encode(array($lesson_id));
            $insert_data['watching_lesson_id'] = $lesson_id;
            DB::table('watch_histories')->create($insert_data);
        }

        return json_encode(array('lesson_id' => $lesson_id, 'course_progress' => round($course_progress), 'is_completed' => $is_completed));
    }
}

function course_completion_data($course_id = "", $user_id = "")
{
    $response = array();
    $response['course_id'] = $course_id;
    $response['number_of_lessons'] = get_lessons('course', $course_id)->count();
    $response['number_of_completed_lessons'] = get_completed_number_of_lesson($user_id, 'course', $course_id);
    $response['course_progress'] = round(course_progress($course_id, $user_id));
    return $response;
}

if (!function_exists('get_completed_number_of_lesson')) {
    function get_completed_number_of_lesson($user_id = "", $type = "", $id = "")
    {
        $counter = 0;
        if ($type == 'section') {
            $lessons = get_lessons('section', $id);
        } else {
            $lessons = get_lessons('course', $id);
        }
        foreach ($lessons as $key => $lesson) {
            if (lesson_progress_api($lesson->id, $user_id)) {
                $counter = $counter + 1;
            }
        }
        return $counter;
    }
}

//get all sections
function sections($course_id = "", $user_id = "")
{
    $lesson_counter_starts = 0;
    $lesson_counter_ends = 0;
    $sections = api_get_section('course', $course_id);
    foreach ($sections as $key => $section) {
        $sections[$key]->lessons = section_wise_lessons($section->id, $user_id);
        $sections[$key]->total_duration = str_replace(' Hours', "", get_total_duration_of_lesson_by_section_id($section->id));
        if ($key == 0) {
            $lesson_counter_starts = 1;
            $lesson_counter_ends = count($sections[$key]->lessons);
        } else {
            $lesson_counter_starts = $lesson_counter_ends + 1;
            $lesson_counter_ends = $lesson_counter_starts + count($sections[$key]->lessons);
        }
        $sections[$key]->lesson_counter_starts = $lesson_counter_starts;
        $sections[$key]->lesson_counter_ends = $lesson_counter_ends;
        if ($user_id > 0) {
            $sections[$key]->completed_lesson_number = get_completed_number_of_lesson($user_id, 'section', $section->id);
        } else {
            $sections[$key]->completed_lesson_number = 0;
        }
    }
    $response = add_user_validity($sections);
    return $response;
}

function api_get_section($type_by, $id)
{
    $sections = array();

    if ($type_by == 'course') {
        $sections = DB::table('sections')->where('course_id', $id)->orderBy("sort", "asc")->get();
    } elseif ($type_by == 'section') {
        $sections = DB::table('sections')->where('id', $id)->orderBy("sort", "asc")->get();
    }

    return $sections;
}

function section_wise_lessons($section_id = "", $user_id = "")
{
    $lessons = get_lessons('section', $section_id);
    foreach ($lessons as $key => $lesson) {
        $response[$key]['id'] = $lesson->id;
        $response[$key]['title'] = $lesson->title;
        $response[$key]['duration'] = readable_time_for_humans($lesson->duration);
        $response[$key]['course_id'] = $lesson->course_id;
        $response[$key]['section_id'] = $lesson->section_id;
        $response[$key]['video_type'] = ($lesson->video_type == "" ? "" : $lesson->video_type);
        if ($lesson->lesson_type == 'system-video') {
            $response[$key]['video_url'] = ($lesson->lesson_src == "" ? "" : url('/public') . '/' . $lesson->lesson_src);
        } else {
            $response[$key]['video_url'] = ($lesson->lesson_src == "" ? "" : $lesson->lesson_src);
        }
        // $response[$key]['video_url_web'] = $lesson->video_url;
        // $response[$key]['video_type_web'] = $lesson->video_type;
        $response[$key]['lesson_type'] = $lesson->lesson_type;
        $response[$key]['is_free'] = $lesson->is_free;
        if ($lesson->lesson_type == 'text') {
            $response[$key]['attachment'] = remove_js(htmlspecialchars_decode_($lesson->attachment));
        } else {
            $response[$key]['attachment'] = $lesson->attachment;
        }
        $response[$key]['attachment_url'] = $lesson->attachment ? url('/public/uploads/lesson_file/attachment') . '/' . $lesson->attachment : $lesson->attachment;
        $response[$key]['attachment_type'] = $lesson->attachment_type;
        $response[$key]['summary'] = remove_js(htmlspecialchars_decode_($lesson->summary));
        if ($user_id > 0) {
            $response[$key]['is_completed'] = lesson_progress_api($lesson->id, $user_id);
        } else {
            $response[$key]['is_completed'] = 0;
        }
        $response[$key]['user_validity'] = true;
    }

    return $response;
}

function add_user_validity($responses = array())
{
    foreach ($responses as $key => $response) {
        $responses[$key]->user_validity = true;
    }
    return $responses;
}

function get_total_duration_of_lesson_by_section_id($section_id)
{
    $total_duration = 0;
    $lessons = get_lessons('section', $section_id);
    foreach ($lessons as $lesson) {
        if ($lesson->lesson_type != "other" && $lesson->lesson_type != "text") {
            $time_array = !empty($lesson->duration) ? explode(':', $lesson->duration) : explode(':', '00:00:00');
            $hour_to_seconds = $time_array[0] * 60 * 60;
            $minute_to_seconds = $time_array[1] * 60;
            $seconds = $time_array[2];
            $total_duration += $hour_to_seconds + $minute_to_seconds + $seconds;
        }
    }
    //return gmdate("H:i:s", $total_duration).' '.get_phrase('hours');
    $hours = floor($total_duration / 3600);
    $minutes = floor(($total_duration % 3600) / 60);
    $seconds = $total_duration % 60;
    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
}

// Human readable time
if (!function_exists('readable_time_for_humans')) {
    function readable_time_for_humans($duration)
    {
        if ($duration) {
            $duration_array = explode(':', $duration);
            $hour = $duration_array[0];
            $minute = $duration_array[1];
            $second = $duration_array[2];
            if ($hour > 0) {
                $duration = $hour . ' ' . get_phrase('hr') . ' ' . $minute . ' ' . get_phrase('min');
            } elseif ($minute > 0) {
                if ($second > 0) {
                    $duration = ($minute + 1) . ' ' . get_phrase('min');
                } else {
                    $duration = $minute . ' ' . get_phrase('min');
                }
            } elseif ($second > 0) {
                $duration = $second . ' ' . get_phrase('sec');
            } else {
                $duration = '00:00';
            }
        } else {
            $duration = '00:00';
        }
        return $duration;
    }
}

if (!function_exists('remove_js')) {
    function remove_js($description = '')
    {
        return preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $description);
    }
}

