<?php
// import facade

use App\Models\Addon;
use function PHPUnit\Framework\fileExists;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

// Global Settings
if (!function_exists('get_src')) {
    function get_src($url = null, $optimized = false)
    {
        return get_image($url, $optimized);
    }
}

if (!function_exists('lesson_count')) {
    function lesson_count($course_id = "")
    {
        if ($course_id != '') {
            $total_lesson = DB::table('lessons')->where('course_id', $course_id)->count();
            return $total_lesson;
        }
    }
}
if (!function_exists('section_count')) {
    function section_count($course_id = "")
    {
        if ($course_id != '') {
            $total_section = DB::table('sections')->where('course_id', $course_id)->count();
            return $total_section;
        }
    }
}
if (!function_exists('count_blogs_by_category')) {
    function count_blogs_by_category($category_id = "")
    {
        if ($category_id != '') {
            $total_blog = DB::table('blogs')->where('status', 1)->where('category_id', $category_id)->count();
            return $total_blog;
        }
    }
}
if (!function_exists('get_blog_category_name')) {
    function get_blog_category_name($id = "")
    {
        if ($id != '') {
            $category_title = DB::table('blog_categories')->where('id', $id)->value('title');
            return $category_title;
        }
    }
}
if (!function_exists('get_user_info')) {
    function get_user_info($user_id = "")
    {
        $user_info = App\Models\User::where('id', $user_id)->firstOrNew();
        return $user_info;
    }
}
if (!function_exists('get_image_by_id')) {
    function get_image_by_id($user_id = "")
    {
        $image_path = DB::table('users')->where('id', $user_id)->value('photo');
        return get_image($image_path);
    }
}

if (!function_exists('timeAgo')) {
    function timeAgo($time_ago)
    {
        $time_ago     = strtotime($time_ago);
        $cur_time     = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds      = $time_elapsed;
        $minutes      = round($time_elapsed / 60);
        $hours        = round($time_elapsed / 3600);
        $days         = round($time_elapsed / 86400);
        $weeks        = round($time_elapsed / 604800);
        $months       = round($time_elapsed / 2600640);
        $years        = round($time_elapsed / 31207680);
        // Seconds
        if ($seconds <= 60) {
            return "just now";
        }
        //Minutes
        else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "1 minute ago";
            } else {
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if ($hours <= 24) {
            if ($hours == 1) {
                return "1 hour ago";
            } else {
                return "$hours hours ago";
            }
        }
        //Days
        else if ($days <= 7) {
            if ($days == 1) {
                return "Yesterday";
            } else {
                return "$days days ago";
            }
        }
        //Weeks
        else if ($weeks <= 4.3) {
            if ($weeks == 1) {
                return "1 week ago";
            } else {
                return "$weeks weeks ago";
            }
        }
        //Months
        else if ($months <= 12) {
            if ($months == 1) {
                return "1 month ago";
            } else {
                return "$months months ago";
            }
        }
        //Years
        else {
            if ($years == 1) {
                return "1 year ago";
            } else {
                return "$years years ago";
            }
        }
    }
}

if (!function_exists('course_enrolled')) {
    function course_enrolled($user_id = "")
    {
        if ($user_id != '') {
            $enrolled = DB::table('enrollments')->where('user_id', $user_id)->exists();
            return $enrolled;
        }
    }
}
if (!function_exists('course_enrollments')) {
    function course_enrollments($course_id = "")
    {
        if ($course_id != '') {
            $enrolled = DB::table('enrollments')->where('course_id', $course_id)->count();
            return $enrolled;
        }
    }
}
if (!function_exists('course_by_instructor')) {
    function course_by_instructor($course_id = "")
    {
        if ($course_id != '') {
            $user_id      = App\Models\Course::where('id', $course_id)->firstOrNew();
            $byInstructor = App\Models\User::where('id', $user_id->user_id)->firstOrNew();
            return $byInstructor;
        }
    }
}

if (!function_exists('course_instructor_image')) {
    function course_instructor_image($course_id = "")
    {
        if ($course_id != '') {
            $user_id    = DB::table('courses')->where('id', $course_id)->value('user_id');
            $user_image = DB::table('users')->where('id', $user_id)->value('photo');
        }
        $img_path = isset($user_image) ? $user_image : $course_id;
        return get_image($img_path);
    }
}

if (!function_exists('get_course_info')) {
    function get_course_info($course_id)
    {
        $course = App\Models\Course::where('id', $course_id)->firstOrNew();
        return $course;
    }
}
if (!function_exists('count_unread_message_of_thread')) {

    function count_unread_message_of_thread($message_thread_code = "")
    {
        $unread_message_counter = 0;
        $current_user           = auth()->user()->id;
        $messages               = DB::table('messages')->where('message_thread_code', $message_thread_code)->get();
        foreach ($messages as $row) {
            if ($row->sender != $current_user && $row->read_status == '0') {
                $unread_message_counter++;
            }
        }
        return $unread_message_counter;
    }
}
if (!function_exists('get_enroll_info')) {
    function get_enroll_info($course_id = "", $user_id = "")
    {
        if ($course_id != '' && $user_id != "") {
            $enrolled = App\Models\Enrollment::where('course_id', $course_id)->where('user_id', $user_id)->firstOrNew();
            return $enrolled;
        }
    }
}
if (!function_exists('total_enrolled')) {
    function total_enrolled()
    {
        $total_enrolled = DB::table('enrollments')->count();
        return $total_enrolled;
    }
}
if (!function_exists('total_enroll')) {
    function total_enroll($course_id = "")
    {
        if ($course_id != '') {
            $count = DB::table('enrollments')->where('course_id', $course_id)->count();
            return $count;
        }
    }
}
if (!function_exists('is_course_instructor')) {
    function is_course_instructor($course_id = "", $user_id = "")
    {
        if ($user_id == '') {
            $user_id = auth()->user()->id;
        }
        $course = App\Models\Course::where('id', $course_id)->firstOrNew();
        if ($course) {
            if ($course->instructors()->where('id', $user_id)->count() > 0 || $course->user_id == $user_id) {
                return true;
            }
        }
        return false;
    }
}

// Get Home page Settings Data
if (!function_exists('get_homepage_settings')) {
    function get_homepage_settings($type = "", $return_type = false)
    {
        $value = DB::table('home_page_settings')->where('key', $type);
        if ($value->count() > 0) {
            if ($return_type === true) {
                return json_decode($value->value('value'), true);
            } elseif ($return_type === "object") {
                return json_decode($value->value('value'));
            } else {
                return $value->value('value');
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('count_student_by_instructor')) {
    function count_student_by_instructor($user_id = "")
    {
        if ($user_id != '') {
            $course        = DB::table('courses')->where('user_id', $user_id)->get();
            $total_student = 0;
            foreach ($course as $courses) {
                $total_student = DB::table('enrollments')->where('course_id', $courses->id)->count();
            }
            return ($total_student > 1) ? "{$total_student} " . get_phrase('Students') : "{$total_student} " . get_phrase('Student');
        }
    }
}
if (!function_exists('count_course_by_instructor')) {
    function count_course_by_instructor($user_id = "")
    {
        if ($user_id != '') {
            $count_course = DB::table('courses')->where('status', 'active')->where('user_id', $user_id)->count();
            return ($count_course > 1) ? "{$count_course} " . get_phrase('Courses') : "{$count_course} " . get_phrase('Course');
        }
    }
}
if (!function_exists('progress_bar')) {
    function progress_bar($course_id = "")
    {
        if ($course_id != '') {
            $lesson_history = App\Models\Watch_history::where('course_id', $course_id)
                ->where('student_id', auth()->user()->id)
                ->firstOrNew();

            $progress_result = 0;
            if ($lesson_history && $lesson_history->completed_lesson != '') {
                $count_complete_lesson = count(json_decode($lesson_history->completed_lesson, true) ?? []);
                $progress_result       = lesson_count($course_id) ? ($count_complete_lesson * 100) / lesson_count($course_id) : 0;
            }
            return number_format($progress_result, 2);
        }
    }
}
if (!function_exists('course_creator')) {
    function course_creator($user_id = "")
    {
        if ($user_id != '') {
            $creator = DB::table('courses')->where('user_id', $user_id)->exists();
            return $creator;
        }
    }
}
if (!function_exists('get_course_creator_id')) {
    function get_course_creator_id($course_id = "")
    {
        if ($course_id != '') {
            $course = DB::table('courses')->where('id', $course_id)->get();
            foreach ($course as $value) {
                $creator = App\Models\User::where('id', $value->user_id)->firstOrNew();
            }
            return $creator;
        }
    }
}

if (!function_exists('user_count')) {
    function user_count($role = "")
    {
        if ($role != '') {
            $user_count = DB::table('users')->where('role', $role)->count();
            return $user_count;
        }
    }
}
if (!function_exists('blog_user')) {
    function blog_user($user_id = "")
    {
        if ($user_id != '') {
            $user = App\Models\User::where('id', $user_id)->firstOrNew();
            return $user;
        }
    }
}
if (!function_exists('category_course_count')) {
    function category_course_count($slug = "")
    {
        if ($slug != '') {
            $slug_category = App\Models\Category::where('slug', $slug)->firstOrNew();
            $all_category  = DB::table('categories')->where('id', $slug_category->id)->get();
            foreach ($all_category as $row) {
                $sub_category = DB::table('categories')->where('parent_id', $row->id)->get();
            }
            foreach ($sub_category as $sub_categories) {

                $category_by_course = DB::table('courses')->where('category_id', $sub_categories->id)->count();
            }
            return $category_by_course;
        }
    }
}

if (!function_exists('category_by_course')) {
    function category_by_course($category_id = "")
    {
        $category_by_courses = App\Models\Category::where('id', $category_id)->firstOrNew();
        return $category_by_courses;
    }
}

if (!function_exists('check_course_admin')) {
    function check_course_admin($user_id = "")
    {
        if ($user_id != '') {
            $creator = DB::table('users')->where('id', $user_id)->value('role');
            return $creator;
        }
    }
}

if (!function_exists('duration_to_seconds')) {
    function duration_to_seconds($duration = "00:00:00:")
    {
        $time_array        = explode(':', $duration);
        $hour_to_seconds   = $time_array[0] * 60 * 60;
        $minute_to_seconds = $time_array[1] * 60;
        $seconds           = $time_array[2];
        $total_seconds     = $hour_to_seconds + $minute_to_seconds + $seconds;
        return $total_seconds;
    }
}

if (!function_exists('total_durations')) {
    function total_durations($course_id = '')
    {
        $total_duration = 0;
        $lessons        = DB::table('lessons')->where('course_id', $course_id)->get();

        foreach ($lessons as $lesson) {
            if ($lesson->duration != '') {

                $time_array = explode(':', $lesson->duration);

                $hour_to_seconds   = $time_array[0] * 60 * 60;
                $minute_to_seconds = $time_array[1] * 60;
                $seconds           = $time_array[2];
                $total_duration += $hour_to_seconds + $minute_to_seconds + $seconds;
            }
        }

        $hours   = floor($total_duration / 3600);
        $minutes = floor(($total_duration - ($hours * 3600)) / 60);
        $seconds = floor($total_duration - ($hours * 3600) - ($minutes * 60));
        return sprintf("%02dh %02dm", $hours, $minutes);
    }
}

if (!function_exists('total_durations_by')) {
    function total_durations_by($course_id = '')
    {
        $total_duration = 0;
        $lessons        = DB::table('lessons')->where('course_id', $course_id)->get();

        foreach ($lessons as $lesson) {
            if ($lesson->duration != '') {

                $time_array = explode(':', $lesson->duration);

                $hour_to_seconds   = $time_array[0] * 60 * 60;
                $minute_to_seconds = $time_array[1] * 60;
                $seconds           = $time_array[2];
                $total_duration += $hour_to_seconds + $minute_to_seconds + $seconds;
            }
        }

        $hours   = floor($total_duration / 3600);
        $minutes = floor(($total_duration - ($hours * 3600)) / 60);
        $seconds = floor($total_duration - ($hours * 3600) - ($minutes * 60));
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    }
}
if (!function_exists('lesson_durations')) {
    function lesson_durations($lesson_id = '')
    {
        $total_duration = 0;
        $lessons        = App\Models\Lesson::where('id', $lesson_id)->firstOrNew();

        if ($lessons->duration != '') {

            $time_array = explode(':', $lessons->duration);

            $hour_to_seconds   = $time_array[0] * 60 * 60;
            $minute_to_seconds = $time_array[1] * 60;
            $seconds           = $time_array[2];
            $total_duration += $hour_to_seconds + $minute_to_seconds + $seconds;
        }
        $hours   = floor($total_duration / 3600);
        $minutes = floor(($total_duration - ($hours * 3600)) / 60);
        $seconds = floor($total_duration - ($hours * 3600) - ($minutes * 60));
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    }
}

if (!function_exists('is_root_admin')) {
    function is_root_admin($admin_id = '')
    {

        // GET THE LOGGEDIN IN ADMIN ID
        if (empty($admin_id)) {
            $admin_id = auth()->user()->id;
        }

        $root_admin_id = App\Models\User::limit(1)->orderBy('id', 'asc')->firstOrNew()->id;
        if ($root_admin_id == $admin_id) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('removeScripts')) {
    function removeScripts($text)
    {
        if(!$text) return;
        
        // Remove <script> tags and their content
        $pattern_script = '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/is';
        $cleanText = preg_replace($pattern_script, '', $text);

        // Remove inline event handlers (e.g., onclick, onmouseover)
        $pattern_inline = '/\s*on\w+="[^"]*"/i';
        $cleanText = preg_replace($pattern_inline, '', $cleanText);

        // Remove JavaScript: URIs
        $pattern_js_uri = '/\s*href="javascript:[^"]*"/i';
        $cleanText = preg_replace($pattern_js_uri, '', $cleanText);

        // Remove other potentially dangerous tags (e.g., <iframe>, <object>, <embed>)
        $pattern_dangerous_tags = '/<(iframe|object|embed|applet|meta|link|style|base|form)\b[^<]*(?:(?!<\/\1>)<[^<]*)*<\/\1>/is';
        $cleanText = preg_replace($pattern_dangerous_tags, '', $cleanText);

        // Remove any remaining dangerous attributes (e.g., srcset on <img>)
        // $pattern_dangerous_attributes = '/\s*(src|srcset|data)="[^"]*"/i';
        // $cleanText = preg_replace($pattern_dangerous_attributes, '', $cleanText);

        return $cleanText;
    }
}

if (!function_exists('has_permission')) {
    function has_permission($route = '', $user_id = '')
    {
        // GET THE LOGGEDIN IN ADMIN ID
        if (empty($user_id)) {
            $user_id = auth()->user()->id;
        }

        $root_admin_id = App\Models\User::firstOrNew()->id;
        if ($user_id == $root_admin_id) {
            return true;
        } else {
            $get_admin_permission = App\Models\Permission::where('admin_id', $user_id)->firstOrNew();
            if ($get_admin_permission) {
                $permissions = json_decode($get_admin_permission->permissions, true);
                if (is_array($permissions)) {
                    if (in_array($route, $permissions)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    echo '<span class="d-none">' . redirect('/') . '</span>';
                    die;
                }
            }
        }
    }
}

if (!function_exists('get_image')) {
    function get_image($url = null, $optimized = false)
    {
        if ($url == null) {
            return asset('uploads/system/placeholder.png');
        }

        // If the value of URL is from an online URL
        if (str_contains($url, 'http://') && str_contains($url, 'https://')) {
            return $url;
        }

        $url_arr = explode('/', $url);
        // File name & Folder path
        $file_name = end($url_arr);
        $path      = str_replace($file_name, '', $url);

        //Optimized image url
        $optimized_image = $path . 'optimized/' . $file_name;

        if (!$optimized) {
            if (is_file(public_path($url)) && file_exists(public_path($url))) {
                return asset($url);
            } else {
                return asset($path . 'placeholder/placeholder.png');
            }
        } else {
            if (is_file(public_path($optimized_image)) && file_exists(public_path($optimized_image))) {
                return asset($optimized_image);
            } else {
                return asset($path . 'placeholder/placeholder.png');
            }
        }
    }
}

if (!function_exists('nice_file_name')) {
    function nice_file_name($file_title = "", $extension = "")
    {
        return slugify($file_title) . '-' . time() . '.' . $extension;
    }
}

if (!function_exists('total_review')) {
    function total_review($course_id = "")
    {
        $review = App\Models\Review::where('course_id', $course_id)
            ->count();
        return $review;
    }
}

// Global Settings
if (!function_exists('remove_file')) {
    function remove_file($url = null)
    {
        if(!$url) return;
        
        $url = str_replace('public/', '', $url);

        $url       = public_path($url);
        $url       = str_replace('optimized/', '', $url);
        $url_arr   = explode('/', $url);
        $file_name = $url_arr[count($url_arr) - 1];

        if (is_file($url) && file_exists($url) && !empty($file_name)) {
            unlink($url);

            $url = str_replace($file_name, 'optimized/' . $file_name, $url);
            if (is_file($url) && file_exists($url)) {
                unlink($url);
            }
        }
    }
}

if (!function_exists('get_all_language')) {
    function get_all_language()
    {
        return DB::table('languages')->select('name')->distinct()->get();
    }
}

if (!function_exists('get_phrase')) {
    function get_phrase($phrase = '', $value_replace = array())
    {
        $active_lan    = session('language') ?? get_settings('language');
        $active_lan_id = DB::table('languages')->where('name', 'like', $active_lan)->value('id');
        $lan_phrase    = DB::table('language_phrases')->where('language_id', $active_lan_id)->where('phrase', $phrase)->first();

        if ($lan_phrase) {
            $translated = $lan_phrase->translated;
        } else {
            $translated  = $phrase;
            $english_lan = DB::table('languages')->where('name', 'like', 'english')->first();
            if (DB::table('language_phrases')->where('language_id', $english_lan->id)->where('phrase', $phrase)->count() == 0) {
                DB::table('language_phrases')->insert(['language_id' => $english_lan->id, 'phrase' => $phrase, 'translated' => $translated]);
            }
        }

        if (!is_array($value_replace)) {
            $value_replace = array($value_replace);
        }
        foreach ($value_replace as $replace) {
            $translated = preg_replace('/____/', $replace, $translated, 1); // Replace one placeholder at a time
        }

        return $translated;
    }
}

if (!function_exists('script_checker')) {
    function script_checker($string = '', $convert_string = true)
    {
        if ($convert_string) {
            return nl2br(htmlspecialchars(strip_tags($string)));
        } else {
            return $string;
        }
    }
}
if (!function_exists('get_user_by_blogcomment')) {
    function get_user_by_blogcomment($user_id = '')
    {
        if ($user_id != '') {
            $user_info = App\Models\User::where('id', $user_id)->firstOrNew();
            return $user_info;
        }
    }
}

if (!function_exists('date_formatter')) {
    function date_formatter($strtotime = "", $format = "")
    {
        if ($strtotime && !is_numeric($strtotime)) {
            $strtotime = strtotime($strtotime);
        } elseif (!$strtotime) {
            $strtotime = time();
        }

        if ($format == "") {
            return date('d', $strtotime) . ' ' . date('M', $strtotime) . ' ' . date('Y', $strtotime);
        }

        if ($format == 1) {
            return date('D', $strtotime) . ', ' . date('d', $strtotime) . ' ' . date('M', $strtotime) . ' ' . date('Y', $strtotime);
        }

        if ($format == 2) {
            $time_difference = time() - $strtotime;
            if ($time_difference <= 10) {
                return get_phrase('Just now');
            }
            //864000 = 10 days
            if ($time_difference > 864000) {
                return date_formatter($strtotime, 3);
            }

            $condition = array(
                12 * 30 * 24 * 60 * 60 => get_phrase('year'),
                30 * 24 * 60 * 60      => get_phrase('month'),
                24 * 60 * 60           => get_phrase('day'),
                60 * 60                => 'hour',
                60                     => 'minute',
                1                      => 'second',
            );

            foreach ($condition as $secs => $str) {
                $d = $time_difference / $secs;
                if ($d >= 1) {
                    $t = round($d);
                    return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ' . get_phrase('ago');
                }
            }
        }

        if ($format == 3) {
            $date = date('d', $strtotime);
            $date .= ' ' . date('M', $strtotime);

            if (date('Y', $strtotime) != date('Y', time())) {
                $date .= date(' Y', $strtotime);
            }

            $date .= ' ' . get_phrase('at') . ' ';
            $date .= date('h:i a', $strtotime);
            return $date;
        }

        if ($format == 4) {
            return date('d', $strtotime) . ' ' . date('M', $strtotime) . ' ' . date('Y', $strtotime) . ', ' . date('h:i:s A', $strtotime);
        }
    }
}

if (!function_exists('currency')) {
    function currency($price = false)
    {
        $pattern = get_settings('currency_position');
        $symbol  = DB::table('currencies')->where('code', get_settings('system_currency'))->value('symbol');

        if ($price > 0) {
            if ($pattern == 'right') {
                $currency = $price . $symbol;
            } elseif ($pattern == 'left') {
                $currency = $symbol . $price;
            } elseif ($pattern == 'right-space') {
                $currency = $price . ' ' . $symbol;
            } elseif ($pattern == 'left-space') {
                $currency = $symbol . ' ' . $price;
            }
            return $currency;
        }
        return $symbol . max(0, $price);
    }
}

if (!function_exists('slugify')) {
    function slugify($string)
    {
        // Convert spaces or consecutive dashes to single dashes
        $slug = preg_replace('/\s+/u', '-', $string);  // Replace spaces with hyphens
        $slug = preg_replace('/-+/', '-', $slug);  // Replace multiple hyphens with a single one

        // Remove unwanted characters, but allow all Unicode letters (from any language) and numbers
        $slug = preg_replace('/[^\p{L}\p{N}-]+/u', '', $slug);  // \p{L} matches any letter in any language, \p{N} matches any number

        // Trim hyphens from the start and end
        $slug = trim($slug, '-');

        return $slug;
    }
}

if (!function_exists('ellipsis')) {
    function ellipsis($long_string, $max_character = 30)
    {
        $long_string  = strip_tags($long_string);
        $short_string = strlen($long_string) > $max_character ? mb_substr($long_string, 0, $max_character) . "..." : $long_string;
        return $short_string;
    }
}

if (!function_exists('htmlspecialchars_decode_')) {
    function htmlspecialchars_decode_($description = '')
    {
        return htmlspecialchars_decode($description ?? "");
    }
}

// RANDOM NUMBER GENERATOR FOR ELSEWHERE
if (!function_exists('random')) {
    function random($length_of_string, $lowercase = false)
    {
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shufle the $str_result and returns substring
        // of specified length
        $randVal = substr(str_shuffle($str_result), 0, $length_of_string);
        if ($lowercase) {
            $randVal = strtolower($randVal);
        }
        return $randVal;
    }
}

if (!function_exists('get_settings')) {
    function get_settings($type = "", $return_type = false)
    {
        $value = App\Models\Setting::where('type', $type);
        if ($value->count() > 0) {
            if ($return_type === true) {
                return json_decode($value->value('description'), true);
            } elseif ($return_type === "object") {
                return json_decode($value->value('description'));
            } else {
                return $value->value('description');
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('lesson_progress')) {
    function lesson_progress($lesson_id = "", $user_id = "", $course_id = "")
    {

        if ($user_id == "") {
            $user_id = Auth()->user()->id;
        }
        if ($course_id == "") {
            $course_id = DB::table('lessons')->where('id', $lesson_id)->value('course_id');
        }

        $query = DB::table('watch_histories')->where('student_id', $user_id)->where('course_id', $course_id);

        if ($query->count() > 0) {
            $lesson_ids = json_decode($query->firstOrNew('completed_lesson'), true);
            if (is_array($lesson_ids) && in_array($lesson_id, $lesson_ids)) {
                return 1;
            } else {
                return 0;
            }
        }
    }
}

if (!function_exists('htmlspecialchars_decode')) {
    function htmlspecialchars_decode($description = '')
    {
        return htmlspecialchars_decode($description ?? "");
    }
}

if (!function_exists('get_frontend_settings')) {
    function get_frontend_settings($type = "", $return_type = false)
    {
        $value = DB::table('frontend_settings')->where('key', $type);
        if ($value->count() > 0) {
            if ($return_type === true) {
                return json_decode($value->value('value'), true);
            } elseif ($return_type === "object") {
                return json_decode($value->value('value'));
            } else {
                return $value->value('value');
            }
        } else {
            return false;
        }
    }
}
if (!function_exists('check_registered')) {
    function check_registered($email = "")
    {

        if ($email != '') {
            $check = DB::table('users')->where('email', $email)->exists();
        }
        return $check;
    }
}

if (!function_exists('is_permission')) {
    function is_permission($permission_for = '', $admin_id = '')
    {

        // GET THE LOGGEDIN IN ADMIN ID
        if (empty($admin_id)) {
            $admin_id = Auth()->user()->id;
        }

        $get_admin_permissions = DB::table('permissions')->where('admin_id', $admin_id);

        if (is_root_admin($admin_id)) {
            return true;
        } else {
            $get_admin_permissions = $get_admin_permissions->firstOrNew();
            $permissions           = json_decode($get_admin_permissions->permissions, true);
            if (in_array($permission_for, $permissions) && is_array($permissions)) {
                return true;
            } else {
                return false;
            }
        }
    }
}

// count comments by blog id
if (!function_exists('count_comments_by_blog_id')) {
    function count_comments_by_blog_id($id)
    {
        $count_comments = App\Models\BlogComment::where('blog_id', $id)->count();
        $comments       = format_count($count_comments) . ' ' . get_phrase('comment');
        if ($count_comments > 1) {
            $comments = format_count($count_comments) . ' ' . get_phrase('comments');
        }
        return $comments;
    }
}

// count likes by blog id
if (!function_exists('count_likes_by_blog_id')) {
    function count_likes_by_blog_id($id)
    {
        $count_likes = App\Models\BlogLike::where('blog_id', $id)->count();
        $likes       = format_count($count_likes) . ' ' . get_phrase('like');
        if ($count_likes > 1) {
            $likes = format_count($count_likes) . ' ' . get_phrase('likes');
        }
        return $likes;
    }
}

// format numbers
if (!function_exists('format_count')) {
    function format_count($num)
    {
        if ($num >= 1000 && $num < 1000000) {
            $count = round($num / 1000, 1) . get_phrase('K');
        } elseif ($num >= 1000000) {
            $count = round($num / 1000000, 1) . get_phrase('M');
        } elseif ($num >= 10000000) {
            $count = round($num / 10000000, 1) . get_phrase('B');
        } else {
            $count = $num;
        }
        return $count;
    }
}
// get by conversation media files
if (!function_exists('get_files')) {
    function get_files($conversation_id)
    {
        $file = App\Models\MediaFile::where('chat_id', $conversation_id)->get();
        return $file;
    }
}
// instructor experience
if (!function_exists('instructor_experience')) {
    function instructor_experience($user_id)
    {
        $first_course = App\Models\Course::where('user_id', $user_id)->firstOrNew();
        $time_diff    = time() - strtotime($first_course->created_at);
        $units        = ["year" => 31536000, "month" => 2592000];

        foreach ($units as $unit => $value) {
            if ($time_diff < $value) {
                continue;
            }

            $time_units = floor($time_diff / $value);
            return ($time_units <= 1) ? "1 $unit" : $time_units . ' ' . $unit . 's';
        }
        return get_phrase('Recently appointed');
    }
}
// instructor reviews
if (!function_exists('instructor_reviews')) {
    function instructor_reviews($user_id)
    {
        $reviews = App\Models\Review::join('courses', 'reviews.course_id', '=', 'courses.id')
            ->select('reviews.*', 'courses.user_id as instructor_id')
            ->where('courses.user_id', $user_id)
            ->count();

        return ($reviews > 1) ? "{$reviews} " . get_phrase('reviews') : "{$reviews} " . get_phrase('review');
    }
}
// instructor rating
if (!function_exists('instructor_rating')) {
    function instructor_rating($user_id)
    {
        $rating = App\Models\Review::join('courses', 'reviews.course_id', '=', 'courses.id')
            ->select('reviews.*', 'courses.user_id as instructor_id')
            ->where('courses.user_id', $user_id)
            ->sum('reviews.rating');

        return number_format(($rating / 5), 1);
    }
}

// count lessons by instructor
if (!function_exists('count_instructor_lesson')) {
    function count_instructor_lesson($user_id)
    {
        $courses = App\Models\Course::where('user_id', $user_id)->pluck('id')->toArray();
        $lessons = App\Models\Lesson::whereIn('course_id', $courses)->count();
        return ($lessons > 1) ? "{$lessons} " . get_phrase('lessons') : "{$lessons} " . get_phrase('lesson');
    }
}

// count course by category
if (!function_exists('count_category_courses')) {
    function count_category_courses($category_id)
    {
        $category = App\Models\Category::where('id', $category_id)->firstOrNew();

        if ($category) {
            if ($category->parent_id > 0) {
                $courses = App\Models\Course::where('status', 'active')->where('category_id', $category_id)->count();
            } else {
                $categories = App\Models\Category::where('parent_id', $category_id)->pluck('id')->toArray();
                $categories[] = $category_id; //add this parent category to the array
                $courses    = App\Models\Course::where('status', 'active')->whereIn('category_id', $categories)->count();
            }
            return $courses;
        } else {
            return '0';
        }
    }
}

// count user certificates
if (!function_exists('count_user_certificate')) {
    function count_user_certificate($user_id)
    {
        $certificates = App\Models\Certificate::where('user_id', $user_id)->count();
        return ($certificates > 1) ? "{$certificates} " . get_phrase('certificates') : "{$certificates} " . get_phrase('certificate');
    }
}

// top category
if (!function_exists('top_categories')) {
    function top_categories()
    {
        $data = App\Models\Payment_history::join('courses', 'payment_histories.course_id', 'courses.id')
            ->join('categories', 'courses.category_id', 'categories.id')
            ->select(
                'payment_histories.course_id',
                'courses.category_id',
                'categories.*',
            )
            ->take(5)->get();

        $categoryCounts   = $data->groupBy('category_id')->map->count();
        $sortedCategories = $categoryCounts->sortDesc()->keys()->all();

        if (count($sortedCategories) > 0) {
            $categories = App\Models\Category::whereIn('id', $sortedCategories)->get();
            return $categories;
        }
        return [];
    }
}

// top category
if (!function_exists('get_blog_tags')) {
    function get_blog_tags()
    {
        $blogs = App\Models\Blog::whereNotNull('keywords')->get(['keywords']);

        $tags = $blogs->flatMap(function ($blog) {
            $keywords = json_decode($blog->keywords, true);
            return collect($keywords ?? []);
        })->pluck('value')->unique()->take(15);

        return $tags;
    }
}

// Get Home page Settings Data
if (!function_exists('replace_url_symbol')) {
    function replace_url_symbol($str)
    {
        $pattern = '/[\?#&\/:@=%]/';
        return preg_replace($pattern, '-', $str);
    }
}

// count bootcamps
if (!function_exists('count_bootcamps_by_category')) {
    function count_bootcamps_by_category($id = "")
    {
        if ($id != '') {
            $bootcamps = DB::table('bootcamps')->where('status', 1)->where('category_id', $id)->count();
            return $bootcamps;
        }
    }
}

// count bootcamp modules
if (!function_exists('count_bootcamp_modules')) {
    function count_bootcamp_modules($id = "")
    {
        $query = DB::table('bootcamp_modules');
        if ($id) {
            $query = $query->where('bootcamp_id', $id);
        }
        return $query->count();
    }
}

// count bootcamp live classes
if (!function_exists('count_bootcamp_classes')) {
    function count_bootcamp_classes($id = "", $type = "bootcamp")
    {
        $query = DB::table('bootcamp_live_classes')
            ->join('bootcamp_modules', 'bootcamp_live_classes.module_id', 'bootcamp_modules.id')
            ->join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id');
        if ($id && $type == 'bootcamp') {
            $query = $query->where('bootcamp_modules.bootcamp_id', $id);
        } elseif ($id && $type == 'module') {
            $query = $query->where('bootcamp_live_classes.module_id', $id);
        }
        return $query->count();
    }
}

// activated theme path
if (!function_exists('theme_path')) {
    function theme_path()
    {
        return 'frontend.' . get_frontend_settings('theme') . '.';
    }
}

// bootcamp purchase
if (!function_exists('is_purchased_bootcamp')) {
    function is_purchased_bootcamp($bootcamp_id, $user_id = null)
    {
        $user_id  = $user_id ?? auth()->user()->id;
        $purchase = App\Models\BootcampPurchase::where('user_id', $user_id)->where('bootcamp_id', $bootcamp_id)->count();
        return $purchase;
    }
}

// bootcamp enrolls
if (!function_exists('bootcamp_enrolls')) {
    function bootcamp_enrolls($bootcamp_id, $user_id = null)
    {
        $bootcamp = App\Models\Bootcamp::where('id', $bootcamp_id)->firstOrNew();
        $user_id  = $user_id ?? $bootcamp->user_id;

        $purchases = App\Models\BootcampPurchase::join('bootcamps', 'bootcamp_purchases.bootcamp_id', 'bootcamps.id')
            ->select('bootcamp_purchases.*', 'bootcamps.user_id as creator')
            ->where('bootcamp_purchases.bootcamp_id', $bootcamp_id)
            ->where('bootcamps.user_id', $user_id)->count();
        return $purchases;
    }
}

// check online class
if (!function_exists('class_started')) {
    function class_started($class_id)
    {
        $current_time  = time();
        $extended_time = $current_time + (60 * 15);

        $bootcamp = App\Models\BootcampLiveClass::where('id', $class_id)
            ->where('force_stop', 0)
            ->whereNotNull('joining_data')
            ->where('start_time', '<', $extended_time)
            ->where('end_time', '>', $current_time)
            ->firstOrNew();
        return $bootcamp ? true : null;
    }
}

// check online class
if (!function_exists('count_instructor_bootcamps')) {
    function count_instructor_bootcamps($user_id)
    {
        if ($user_id != '') {
            $count_course = DB::table('bootcamps')->where('status', 1)->where('user_id', $user_id)->count();
            return ($count_course > 1) ? "{$count_course} " . get_phrase('Bootcamps') : "{$count_course} " . get_phrase('Bootcamp');
        }
    }
}

// delete relevant bootcamp data
if (!function_exists('remove_bootcamp_data')) {
    function remove_bootcamp_data($id)
    {
        remove_module_data($id);
        App\Models\Bootcamp::where('id', $id)->latest('id')->delete();
    }
}

// delete relevant module
if (!function_exists('remove_module_data')) {
    function remove_module_data($id)
    {
        $modules = App\Models\BootcampModule::where('bootcamp_id', $id)->latest('id')->get();
        foreach ($modules as $module) {
            remove_live_class_data($module->id);
            remove_resource_data($module->id);
        }
        App\Models\BootcampModule::where('bootcamp_id', $id)->delete();
    }
}

// delete relevant live class
if (!function_exists('remove_live_class_data')) {
    function remove_live_class_data($id)
    {
        App\Models\BootcampLiveClass::where('module_id', $id)->delete();
    }
}

// delete relevant resource
if (!function_exists('remove_resource_data')) {
    function remove_resource_data($id)
    {
        App\Models\BootcampResource::where('module_id', $id)->delete();
    }
}

// player settings
if (! function_exists('get_player_settings')) {
    function get_player_settings($title = "", $return_type = false)
    {
        $value = App\Models\PlayerSettings::where('title', $title);
        if ($value->count() > 0) {
            if ($return_type === true) {
                return json_decode($value->value('description'), true);
            } elseif ($return_type === "object") {
                return json_decode($value->value('description'));
            } else {
                return $value->value('description');
            }
        } else {
            return false;
        }
    }
}

// get reserved team members
if (! function_exists('reserved_team_members')) {
    function reserved_team_members($package_id)
    {
        $count_members = App\Models\TeamPackageMember::where('team_package_id', $package_id)->count();
        return $count_members;
    }
}

// get team purchases
if (! function_exists('team_package_purchases')) {
    function team_package_purchases($package_id)
    {
        $count_purchase = App\Models\TeamPackagePurchase::where('package_id', $package_id)->count();
        return $count_purchase;
    }
}

// get team packages by course category
if (! function_exists('team_packages_by_course_category')) {
    function team_packages_by_course_category($category_id)
    {
        $course_ids          = App\Models\Course::where('category_id', $category_id)->pluck('id')->toArray();
        $count_team_packages = [];
        foreach ($course_ids as $course_id) {
            $count_team_packages[] = App\Models\TeamTrainingPackage::where('course_id', $course_id)->count();
        }
        return array_sum($count_team_packages);
    }
}

// team package purchase
if (! function_exists('is_purchased_package')) {
    function is_purchased_package($package_id, $user_id = null)
    {
        $user_id  = $user_id ?? auth()->user()->id;
        $purchase = App\Models\TeamPackagePurchase::where('user_id', $user_id)->where('package_id', $package_id)->firstOrNew();
        return $purchase;
    }
}

// get instructor course revenue
if (! function_exists('instructor_course_revenue')) {
    function instructor_course_revenue($user_id = null)
    {
        $id             = $user_id ?? auth()->user()->id;
        $course_revenue = App\Models\Course::join('payment_histories', 'courses.id', 'payment_histories.course_id')
            ->select('payment_histories.*', 'courses.id as course_id')
            ->where('courses.user_id', $id)
            ->sum('payment_histories.instructor_revenue');
        return $course_revenue;
    }
}

// get instructor bootcamp revenue
if (! function_exists('instructor_bootcamp_revenue')) {
    function instructor_bootcamp_revenue($user_id = null)
    {
        $id               = $user_id ?? auth()->user()->id;
        $bootcamp_revenue = App\Models\BootcampPurchase::join('bootcamps', 'bootcamp_purchases.bootcamp_id', 'bootcamps.id')
            ->where('bootcamps.user_id', $id)->sum('bootcamp_purchases.instructor_revenue');
        return $bootcamp_revenue;
    }
}

// get instructor team training revenue
if (! function_exists('instructor_team_training_revenue')) {
    function instructor_team_training_revenue($user_id = null)
    {
        $id      = $user_id ?? auth()->user()->id;
        $revenue = App\Models\TeamPackagePurchase::join('team_training_packages', 'team_package_purchases.package_id', 'team_training_packages.id')
            ->where('team_training_packages.user_id', $id)->sum('team_package_purchases.instructor_revenue');
        return $revenue;
    }
}

// get instructor total revenue
if (! function_exists('instructor_total_revenue')) {
    function instructor_total_revenue($user_id = null)
    {
        $id            = $user_id ?? auth()->user()->id;
        $total_revenue = instructor_course_revenue($id) + instructor_bootcamp_revenue($id) + instructor_team_training_revenue($id);
        return $total_revenue;
    }
}

// get instructor total payout
if (! function_exists('instructor_total_payout')) {
    function instructor_total_payout($user_id = null)
    {
        $id           = $user_id ?? auth()->user()->id;
        $total_payout = App\Models\Payout::where(['user_id' => $id, 'status' => 1])->sum('amount');
        return $total_payout;
    }
}

// get instructor available balance
if (! function_exists('instructor_available_balance')) {
    function instructor_available_balance($user_id = null)
    {
        // sum all the revenue sources (course, ebook, bootcamp, team_training etc)
        $id                = $user_id ?? auth()->user()->id;
        $available_balance = instructor_total_revenue($id) - instructor_total_payout($id);
        return $available_balance;
    }
}
