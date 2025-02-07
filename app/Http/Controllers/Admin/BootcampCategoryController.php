<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BootcampCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BootcampCategoryController extends Controller
{
    public function index()
    {
        $page_data['categories'] = BootcampCategory::paginate(32);
        return view('admin.bootcamp_category.index', $page_data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:bootcamp_categories,title',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['title'] = $request->title;
        $data['slug']  = slugify($request->title);

        BootcampCategory::insert($data);

        Session::flash('success', get_phrase('Category has been created.'));
        return redirect()->back();
    }

    public function delete($id)
    {
        $category = BootcampCategory::where('id', $id);
        if ($category->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }
        $category->delete();

        Session::flash('success', get_phrase('Category has been deleted.'));
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $category = BootcampCategory::where('id', $id);
        if ($category->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:bootcamp_categories,title,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['title'] = $request->title;
        $data['slug']  = slugify($request->title);

        $category->update($data);

        Session::flash('success', get_phrase('Category has been updated.'));
        return redirect()->back();
    }
}
