<?php

namespace App\Http\Controllers;

use App\Models\FileUploader;
use App\Models\SeoField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeoController extends Controller
{
    public function seo_settings($active_tab = "")
    {
        $page_data = array();
        $page_data['seo_meta_tags'] = SeoField::all();
        $page_data['active_tab'] = !empty($active_tab) ? $active_tab : 'Home';

        return view("admin.setting.seo_setting", $page_data);
    }

    function seo_settings_update(Request $request, $route = "")
    {
        if (!empty($request->all())) {
            $updateSeo = SeoField::where('route', $route)->first();
            $updateSeo->meta_title = $request->meta_title;
            $updateSeo->meta_keywords = $request->meta_keywords;
            $updateSeo->meta_description = $request->meta_description;
            $updateSeo->meta_robot = $request->meta_robot;
            $updateSeo->canonical_url = $request->canonical_url;
            $updateSeo->custom_url = $request->custom_url;
            $updateSeo->og_title = $request->og_title;
            $updateSeo->og_description = $request->og_description;
            $updateSeo->json_ld = $request->json_ld;

            if (isset($request->og_image)) {
                $originalFileName = $updateSeo->id . '-' . $request->og_image->getClientOriginalName();
                $destinationPath = 'public/uploads/seo-og-images/' . $originalFileName;

                // Move the file to the destination path
                FileUploader::upload($request->og_image, $destinationPath, 600);
                remove_file($updateSeo->og_image);
                $updateSeo->og_image = $destinationPath;
            }

            $updateSeo->save();
            $page_data = array();
            $page_data['seo_meta_tags'] = SeoField::all();
            $page_data['active_tab'] = $route;

            return redirect('/admin/seo_settings/' . $route)->with('success', 'SEO updated Successfully');
        }

        return redirect()->back()->with('error', 'Seo update failed');
    }
}
