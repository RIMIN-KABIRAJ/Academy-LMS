<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Knowledge_base;
use App\Models\Knowledge_base_topick;
use Google\Service\ContainerAnalysis\KnowledgeBase;
use Illuminate\Support\Facades\Session;


class KnowledgeBaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {           
        

        $query =Knowledge_base::query();
        if(isset($_GET['search']) && $_GET['search'] != ''){
           $query = $query->where('title', 'like', '%' . $_GET['search'] . '%');
        }
        $datas = $query->orderBy("created_at","desc")->paginate(10);
        return view('admin.knowledge_base.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        

        $request->validate([
            'title' => 'required | max:200 '
        ]);

        $query = new Knowledge_base;
        $query->title = $request->title;
        $done = $query->save();
        if ($done) {
            return redirect()->back()->with('success', get_phrase('successfullly added'));
        } else {
            return redirect()->back()->with('error', get_phrase('something wrong!'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required | max:200 '
        ]);

        $query = Knowledge_base::where('id', $id)->first();
        $query->title = $request->title;
        $done = $query->update();

        if ($done) {
            return redirect()->back()->with('success', get_phrase('updated successfully.'));
        } else {
            return redirect()->back()->with('error', get_phrase('no data found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


        $done = Knowledge_base_topick::where('knowledge_base_id', $id)->delete();
        $ok = Knowledge_base::where('id', $id)->delete();

        if ($done || $ok) {
            return redirect()->back()->with('success', get_phrase('successfully deleted.'));
        } else {
            return redirect()->back()->with('error', get_phrase('something went wrong.'));
        }
    }
}
