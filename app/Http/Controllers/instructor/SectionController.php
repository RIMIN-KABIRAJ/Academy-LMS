<?php

namespace App\Http\Controllers\instructor;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class SectionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        // check duplicate
        if (Section::where('course_id', $request->course_id)->where('title', $request->title)->exists()) {
            Session::flash('error', get_phrase('Section already exists.'));
            return redirect()->back();
        }

        // insert section
        $section            = new Section();
        $section->title     = $request->title;
        $section->user_id   = auth()->user()->id;
        $section->course_id = $request->course_id;
        $done               = $section->save();

        // redirect back
        Session::flash('success', get_phrase('Section added successfully'));
        return redirect()->back();
    }


    public function update(Request $request)
    {
        // check duplicate
        if (Section::where('title', $request->title)->exists()) {
            Session::flash('error', get_phrase('Section already exists.'));
            return redirect()->back();
        }

        // update data
        Section::where('id', $request->section_id)->update(['title' => $request->up_title]);

        // redirect back
        Session::flash('success', get_phrase('update successfully'));
        return redirect()->back();
    }

    public function delete($id)
    {
        Section::where('id', $id)->delete();
        Session::flash('success', get_phrase('Delete successfully'));
        return redirect()->back();
    }

    public function sort(Request $request)
    {
        $sections = json_decode($request->itemJSON);
        foreach ($sections as $key => $value) {
            $updater = $key + 1;
            Section::where('id', $value)->update(['sort' => $updater]);
        }
    }
}
