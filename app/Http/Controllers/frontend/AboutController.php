<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $page_data['instructors'] = User::where('role', 'instructor')->inRandomOrder()->take(8)->get();
        $view_path = 'frontend.' . get_frontend_settings('theme') . '.about_us.index';
        return view($view_path, $page_data);
    }
}
