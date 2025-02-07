<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function select_lng(Request $request)
    {
        session(['language' => strtolower($request->language)]);
        return redirect()->back();
    }
}
