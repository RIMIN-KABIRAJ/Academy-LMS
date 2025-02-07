<?php

namespace App\Http\Controllers\frontend;
use App\Models\Knowledge_base_topick;
use App\Models\Knowledge_base;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class KnowledgeBaseTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $articles = Knowledge_base::orderBy('updated_at', 'desc')->paginate(10);

        return view('frontend.default.knowledge_base_topics.index', ['articles'=> $articles]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    { 
        $query = Knowledge_base_topick::where('id', $id)->first();

        if($query){

            $title =Knowledge_base::where('id',$query->knowledge_base_id)->first();
        }

        if (!$query) {

            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->route('knowledge.base.topicks');
        }
        return view('frontend.default.knowledge_base_topics.article_single', ['title'=> $title,'article'=> $query]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
