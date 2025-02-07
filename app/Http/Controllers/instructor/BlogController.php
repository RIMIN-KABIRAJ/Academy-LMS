<?php

namespace App\Http\Controllers\instructor;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\FileUploader;
use App\Models\SeoField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    public function index()
    {
        $query = Blog::where('user_id', auth()->user()->id);

        // if route has any query
        if (request()->has('search')) {
            $query = $query->where('title', 'LIKE', '%' . request()->query('search') . '%');
        }

        $page_data["blogs"] = $query->paginate(10)->appends(request()->query());
        return view("instructor.blog.index", $page_data);
    }

    public function create()
    {
        $page_data["category"] = BlogCategory::all();
        return view("instructor.blog.create", $page_data);
    }

    public function store(Request $request)
    {
        $data['category_id'] = $request->category_id;
        $data['user_id']     = Auth()->user()->id;
        $data['title']       = $request->title;
        $data['keywords']    = $request->keywords;
        $data['description'] = $request->description;
        if (isset($request->thumbnail) && $request->thumbnail != '') {
            $data['thumbnail'] = "uploads/blog/thumbnail/" . nice_file_name($request->title, $request->thumbnail->extension());
            FileUploader::upload($request->thumbnail, $data['thumbnail'], 400, null, 200, 200);
        }
        if (isset($request->banner) && $request->banner != '') {
            $data['banner'] = "uploads/blog/banner/" . nice_file_name($request->title, $request->banner->extension());
            FileUploader::upload($request->banner, $data['banner'], 400, null, 200, 200);
        }
        $data['is_popular'] = $request->is_popular;
        $data['status']     = 0;

        Blog::insert($data);
        Session::flash('success', get_phrase('Blog added successfully'));
        return redirect()->route('instructor.blogs');
    }

    public function edit($id)
    {
        $page_data["blog_data"] = Blog::where('id', $id)->where('user_id', auth()->user()->id)->first();
        $page_data["category"]  = BlogCategory::all();
        return view("instructor.blog.edit", $page_data);
    }
    public function update(Request $request, $id)
    {
        $data['category_id'] = $request->category_id;
        $data['user_id']     = Auth()->user()->id;
        $data['title']       = $request->title;
        $data['keywords']    = $request->keywords;
        $data['description'] = $request->description;
        if (isset($request->thumbnail) && $request->thumbnail != '') {
            $data['thumbnail'] = "uploads/blog/thumbnail/" . nice_file_name($request->title, $request->thumbnail->extension());
            FileUploader::upload($request->thumbnail, $data['thumbnail'], 400, null, 200, 200);
        }
        if (isset($request->banner) && $request->banner != '') {
            $data['banner'] = "uploads/blog/banner/" . nice_file_name($request->title, $request->banner->extension());
            FileUploader::upload($request->banner, $data['banner'], 400, null, 200, 200);
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




        Session::flash('success', get_phrase('Blog updated successfully'));
        return redirect()->route('instructor.blogs');
    }

    public function delete($id)
    {
        $query = Blog::where("id", $id);
        remove_file($query->first()->thumbnail);
        remove_file($query->first()->banner);
        $query->delete();
        Session::flash('success', get_phrase('Blog deleted successfully'));
        return redirect()->back();
    }

    public function pending()
    {
        $query = Blog::where('user_id', auth()->user()->id)->where('status', 0);

        // if route has any query
        if (request()->has('search')) {
            $query = $query->where('title', 'LIKE', '%' . request()->query('search') . '%');
        }

        $page_data["blogs"] = $query->paginate(10)->appends(request()->query());
        return view("instructor.blog.pending", $page_data);
    }
}
