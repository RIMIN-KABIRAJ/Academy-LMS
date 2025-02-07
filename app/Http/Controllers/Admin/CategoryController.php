<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\FileUploader;

class CategoryController extends Controller
{
    //


    public function index()
    {
        $page_data['categories'] = Category::where('parent_id', 0)->orderBy('sort', 'asc')->get();
        return view('admin.category.index', $page_data);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'parent_id' => 'required|numeric|min:0',
            'icon' => 'required',
            'keywords' => 'max:400',
            'description' => 'max:500',
        ]);

        if (Category::where('slug', slugify($request->title))->count() > 0) {
            return redirect(route('admin.categories'))->with('error', get_phrase('There cannot be more than one category with the same name. Please change your category name'));
        }

        $data['parent_id'] = $request->parent_id;
        $data['title'] = $request->title;
        $data['slug'] = slugify($request->title);
        $data['icon'] = $request->icon;
        $data['sort'] = 0;
        $data['keywords'] = $request->keywords;
        $data['description'] = $request->description;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        if(isset($request->thumbnail)){
            $data['thumbnail'] = "uploads/category-thumbnail/" . nice_file_name($request->title, $request->thumbnail->extension());
            FileUploader::upload($request->thumbnail, $data['thumbnail'], 500, null, 200, 200);
        }

        if(isset($request->category_logo)){
            $data['category_logo'] = "uploads/category-logo/" . nice_file_name($request->title.' logo', $request->category_logo->extension());
            FileUploader::upload($request->category_logo, $data['category_logo'], 400, null, 200, 200);
        }

        Category::insert($data);

        return redirect(route('admin.categories'))->with('success', get_phrase('Category added successfully'));
    }

    public function edit()
    {
    }

    public function update(Request $request, $id)
    {
        $query = Category::where('id', $id);
        $pre_data = Category::where('id', $id)->first();

        $validated = $request->validate([
            'title' => 'required|max:255',
            'parent_id' => 'required|numeric|min:0',
            'icon' => 'required',
            'keywords' => 'max:400',
            'description' => 'max:500',
        ]);

        if (Category::where('slug', slugify($request->title))->where('id', '!=', $id)->count() > 0) {
            return redirect(route('admin.categories'))->with('error', get_phrase('There cannot be more than one category with the same name. Please change your category name'));
        }

        $data['parent_id'] = $request->parent_id;
        $data['title'] = $request->title;
        $data['slug'] = slugify($request->title);
        $data['icon'] = $request->icon;
        $data['keywords'] = $request->keywords;
        $data['description'] = $request->description;
        $data['updated_at'] = date('Y-m-d H:i:s');

        if (isset($request->thumbnail) && $request->thumbnail != '') {
            $data['thumbnail'] = "uploads/category-thumbnail/" . nice_file_name($request->title, $request->thumbnail->extension());
            FileUploader::upload($request->thumbnail, $data['thumbnail'], 500, null, 200, 200);
            remove_file($pre_data->thumbnail);
        }

        if(isset($request->category_logo)){
            $data['category_logo'] = "uploads/category-logo/" . nice_file_name($request->title.'-logo', $request->category_logo->extension());
            FileUploader::upload($request->category_logo, $data['category_logo'], 400, null, 200, 200);
            remove_file($pre_data->category_logo);
        }

        $query->update($data);

        return redirect(route('admin.categories'))->with('success', get_phrase('Category updated successfully'));
    }

    public function delete($id)
    {
        $query = Category::where('id', $id);

        if ($query->first()->parent_id > 0) {
            remove_file($query->first()->thumbnail);
            $query->delete();
        } else {
            foreach ($query->first()->childs as $sub_category) {
                $sub_query = Category::where('id', $sub_category->id);
                remove_file($sub_query->first()->thumbnail);
                $sub_query->delete();
            }
            remove_file($query->first()->thumbnail);
            $query->delete();
        }

        return redirect(route('admin.categories'))->with('success', get_phrase('Category deleted successfully'));
    }
}
