<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Live_class;
use Illuminate\Http\Request;

class LiveClassController extends Controller
{
    function live_class_join($id)
    {
        $live_class = Live_class::where('id', $id)->first();

        if ($live_class->provider == 'zoom') {
            if(get_settings('zoom_web_sdk') == 'active'){
                return view('course_player.live_class.zoom_live_class', ['live_class' => $live_class]);
            }else{
                $meeting_info = json_decode($live_class->additional_info, true);
                return redirect($meeting_info['start_url']);
            }
        } else {
            return view('course_player.live_class.zoom_live_class', ['live_class' => $live_class]);
        }
    }
}
