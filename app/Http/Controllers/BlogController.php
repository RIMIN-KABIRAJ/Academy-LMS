<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\FileUploader;
use App\Models\FrontendSetting;
use App\Models\SeoField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $query = Blog::query();
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $query = $query->where('title', 'LIKE', '%' . $_GET['search'] . '%');
        }
        $page_data['blogs'] = $query->paginate(10);
        return view("admin.blog.index", $page_data);
    }
    public function create()
    {
        $page_data["category"] = BlogCategory::all();
        return view("admin.blog.create", $page_data);
    }

    public function store(Request $request)
    {
        $rules = [
            "title"       => "required|unique:blogs",
            "category_id" => "required",
            "description" => "required",
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        

        $data['category_id'] = $request->category_id;
        $data['user_id']     = Auth()->user()->id;
        $data['title']       = $request->title;
        $data['slug']        = slugify($request->title);
        $data['keywords']    = $request->keywords;
        $data['description'] = $request->description;
        if (isset($request->thumbnail) && $request->thumbnail != '') {
            $data['thumbnail'] = "uploads/blog/thumbnail/" . nice_file_name($request->title, $request->thumbnail->extension());
            FileUploader::upload($request->thumbnail, $data['thumbnail'], 400, null, 200, 200);
        }
        if (isset($request->banner) && $request->banner != '') {
            $data['banner'] = "uploads/blog/banner/" . nice_file_name($request->title, $request->banner->extension());
            FileUploader::upload($request->banner, $data['banner'], 1400, null, 200, 200);
        }
        $data['is_popular'] = $request->is_popular;
        $data['status']     = 1;

        Blog::insert($data);
        return redirect(route('admin.blogs'))->with('success', get_phrase('Blog add successfully'));
    }

    public function delete($id)
    {
        $query = Blog::where("id", $id);
        if ($query->doesntExist()) {
            Session::flash('success', get_phrase('Data not found.'));
            return redirect()->back();
        }
        remove_file($query->first()->thumbnail);
        remove_file($query->first()->banner);
        $query->delete();
        Session::flash('success', get_phrase('Blog delete successfully'));
        return redirect()->back();
    }

    public function edit($id)
    {
        $query = Blog::where("id", $id);
        if ($query->doesntExist()) {
            Session::flash('success', get_phrase('Data not found.'));
            return redirect()->back();
        }
        $page_data["blog_data"] = Blog::where('id', $id)->first();
        $page_data["category"]  = BlogCategory::all();
        return view("admin.blog.edit", $page_data);
    }
    public function update(Request $request, $id)
    {
        $query = Blog::where("id", $id);
        if ($query->doesntExist()) {
            Session::flash('success', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $rules = [
            "title"       => "required",
            "category_id" => "required",
            "description" => "required",
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['category_id'] = $request->category_id;
        $data['user_id']     = Auth()->user()->id;
        $data['title']       = $request->title;
        $data['slug']        = slugify($request->title);
        $data['keywords']    = $request->keywords;
        $data['description'] = $request->description;
        if (isset($request->thumbnail) && $request->thumbnail != '') {
            $data['thumbnail'] = "uploads/blog/thumbnail/" . nice_file_name($request->title, $request->thumbnail->extension());
            FileUploader::upload($request->thumbnail, $data['thumbnail'], 400, null, 200, 200);
        }
        if (isset($request->banner) && $request->banner != '') {
            $data['banner'] = "uploads/blog/banner/" . nice_file_name($request->title, $request->banner->extension());
            FileUploader::upload($request->banner, $data['banner'], 1400, null, 200, 200);
        }
        $data['is_popular'] = $request->is_popular;
        Blog::where('id', $id)->update($data);


        // Blog SEO
        $blog_details = Blog::where('id', $id)->first();
        $SeoField = SeoField::where('name_route', 'blog.details')->where('blog_id', $blog_details->id)->first();
        $seo_data['blog_id'] = $id;
        $seo_data['route'] = 'Blog Details';
        $seo_data['name_route'] = 'blog.details';
        $seo_data['meta_title'] = $request->meta_title;
        $seo_data['meta_description'] = $request->meta_description;
        $seo_data['meta_robot'] = $request->meta_robot;
        $seo_data['canonical_url'] = $request->canonical_url;
        $seo_data['custom_url'] = $request->custom_url;
        $seo_data['json_ld'] = $request->json_ld;
        $seo_data['og_title'] = $request->og_title;
        $seo_data['og_description'] = $request->og_description;
        $seo_data['created_at'] = date('Y-m-d H:i:s');
        $seo_data['updated_at'] = date('Y-m-d H:i:s');

        $meta_keywords_arr = json_decode($request->meta_keywords, true);
        $meta_keywords = '';
        if (is_array($meta_keywords_arr)) {
            foreach ($meta_keywords_arr as $arr_key => $arr_val) {
                $meta_keywords .= $meta_keywords == '' ? $arr_val['value'] : ', ' . $arr_val['value'];
            }
            $seo_data['meta_keywords'] = $meta_keywords;
        }

        if ($request->og_image) {
            $originalFileName = $blog_details->id . '-' . $request->og_image->getClientOriginalName();
            $destinationPath = 'uploads/seo-og-images/' . $originalFileName;
            // Move the file to the destination path
            FileUploader::upload($request->og_image, $destinationPath, 600);
            $seo_data['og_image'] = $destinationPath;
        }

        if ($SeoField) {
            if ($request->og_image) {
                remove_file($SeoField->og_image);
            }
            SeoField::where('name_route', 'blog.details')->where('blog_id', $blog_details->id)->update($seo_data);
        } else {
            SeoField::insert($seo_data);
        }
        // Blog SEO Ended

        return redirect(route('admin.blogs'))->with('success', get_phrase('Blog update successfully'));
    }

    public function status($id)
    {
        $blog = Blog::where("id", $id);
        if ($blog->doesntExist()) {
            Session::flash('success', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $data["status"] = $blog->first()->status ? 0 : 1;
        Blog::where("id", $id)->update($data);

        $response = [
            'success' => get_phrase('Status has been updated.'),
        ];
        return json_encode($response);
    }

    public function pending()
    {
        $query = Blog::where('status', 0);
        if (request()->has('search')) {
            $query = $query->where('title', 'LIKE', '%' . request()->query('search') . '%');
        }
        $page_data['blogs'] = $query->paginate(10);
        return view("admin.blog.pending", $page_data);
    }

    public function settings()
    {
        return view('admin.blog.setting');
    }

    public function update_settings(Request $request)
    {
        $data['value'] = $request->instructors_blog_permission;
        FrontendSetting::where('key', 'instructors_blog_permission')->update($data);

        $data['value'] = $request->blog_visibility_on_the_home_page;
        FrontendSetting::where('key', 'blog_visibility_on_the_home_page')->update($data);

        Session::flash('success', get_phrase('Setting Update successfully'));
        return redirect()->back();
    }
}
