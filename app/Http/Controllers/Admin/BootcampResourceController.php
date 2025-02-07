<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bootcamp;
use App\Models\BootcampLiveClass;
use App\Models\BootcampModule;
use App\Models\BootcampResource;
use App\Models\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BootcampResourceController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'module_id'   => 'required|numeric',
            'upload_type' => 'required|in:resource,record',
            'files'       => 'required|array',
            'files.*'     => 'required|file',
        ]);

        if ($validator->fails()) {
            return response()->back()->withErrors($validator)->withInput();
        }

        $module = BootcampModule::join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->select('bootcamp_modules.*', 'bootcamps.title as bootcamp_title')
            ->where('bootcamp_modules.id', $request->module_id)->first();
        if (! $module) {
            Session::flash('error', get_phrase('Module not found.'));
            return redirect()->back();
        }

        $data['module_id']   = $module->id;
        $data['upload_type'] = $request->upload_type;

        $allowed_extensions = ['mp4', 'mov', 'avi', 'wmv', 'webm'];
        $files              = $request->file('files');
        foreach ($files as $file) {
            if ($request->upload_type == 'record' && ! in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                Session::flash('error', get_phrase("Failed to upload. File type must be a video."));
                return redirect()->back();
            }
            $file_name     = $file->getClientOriginalName();
            $data['title'] = replace_url_symbol($file_name);
            $data['file']  = 'uploads/bootcamp/resource/' . auth()->user()->name . '/' . $module->bootcamp_title . '/' . $module->title . '/' . $data['title'];

            $query = BootcampResource::where('title', $data['title']);
            if ($query->exists()) {
                Session::flash('error', get_phrase("File already exists."));
                return redirect()->back();
            }
            $query->insert($data);
            FileUploader::upload($file, $data['file']);
        }
        Session::flash('success', get_phrase(ucfirst($request->upload_type) . ' has been uploaded.'));
        return redirect()->back();
    }

    public function delete($id)
    {
        $resource = BootcampResource::where('id', $id)->first();
        if (! $resource) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $file_path = public_path($resource->file);
        if (file_exists($file_path)) {
            remove_file($file_path);
        }
        $resource->delete();

        Session::flash('success', get_phrase(ucfirst($resource->upload_type) . ' has been deleted.'));
        return redirect()->back();
    }

    public function download($id)
    {
        $resource = BootcampResource::where('id', $id);
        if ($resource->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $file      = $resource->first();
        $file_path = public_path($file->file);
        if (! file_exists($file_path)) {
            Session::flash('error', get_phrase('File does not exists.'));
            return redirect()->back();
        }
        return response()->download($file_path);
    }
}
