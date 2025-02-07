<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Knowledge_base;
use App\Models\Knowledge_base_topick;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
            'title' => 'required | max:200',
            'description'=> 'required'
        ]);
        $article = new Knowledge_base_topick;
        $article->topic_name = $request->title;
        $article->description = $request->description;
        $article->knowledge_base_id = $request->topick_id;
        $done = $article->save();
        if ($done) {
            return redirect()->route('admin.articles',['id'=> $request->topick_id])->with('success', get_phrase('article saved.'));
        } else {
            return redirect()->route('admin.articles',['id'=> $request->topick_id])->with('error', get_phrase('article not saved.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $articleTitle = Knowledge_base::where('id', $id)->first();
        if (!$articleTitle) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }
        $articles = Knowledge_base_topick::where('knowledge_base_id', $id)->orderBy('updated_at', 'desc')->paginate(10);


        return view("admin.articles.index" , ["articleTitle"=> $articleTitle], ['articles'=> $articles]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $articleTitle = Knowledge_base::where('id', $id)->first();
        if (!$articleTitle) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }
        return view('admin.articles.create', ['articleTitle'=>$articleTitle]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $article = Knowledge_base_topick::where('id', $id)->first();
        if (!$article) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }


        $knowledgeBaseId = $article->knowledge_base_id;
        $article->topic_name = $request->topic_name; 
        $article->description = $request->description;
        $done = $article->update();
        if ($done) {
            return redirect()->route('admin.articles',['id'=> $knowledgeBaseId])->with('success', get_phrase('successfully updated.'));
        } else {
            return redirect()->route('admin.articles',['id'=> $knowledgeBaseId])->with('error', get_phrase('not updated.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Knowledge_base_topick::where('id', $id)->first();

        if (!$article) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $knowledgeBaseId = $article->knowledge_base_id;
        $done = $article->delete();
        if ($done) {
            return redirect()->route('admin.articles', ['id'=> $knowledgeBaseId])->with('success', get_phrase('article deleted'));
        } else {
            return redirect()->route('admin.articles', ['id'=> $knowledgeBaseId])->with('error', get_phrase('article not deleted'));
        }
        
    }
}
