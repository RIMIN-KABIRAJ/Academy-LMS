<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModalController extends Controller
{

    public function common_view_function($view_path = "", Request $request)
    {
        $page_data = array();
        foreach ($request->all() as $key => $value) :
            $page_data[$key] = $value;
        endforeach;

        return view($view_path, $page_data);
    }
}
