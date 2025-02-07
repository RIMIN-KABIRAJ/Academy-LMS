<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'type'    => 'required',
            'answer'  => 'required',
            'options' => 'required_if:type,mcq',
        ], [
            'options.required_if' => 'When type is MCQ, options are required.',
        ]);

        if ($validator->fails()) {
            return json_encode(array('validationError' => $validator->getMessageBag()->toArray()));
        }

        $answer = null;
        if ($request->type == 'mcq') {
            $answer          = json_encode($request->answer);
            $data['options'] = json_encode(array_column(json_decode($request->options, true), 'value'));
        } elseif ($request->type == 'fill_blanks') {
            $answers = json_decode($request->answer);
            $answer  = json_encode(array_column($answers, 'value'));
        } elseif ($request->type == 'true_false') {
            $answer = $request->answer;
        }

        $data['quiz_id'] = $request->quiz_id;
        $data['title']   = $request->title;
        $data['type']    = $request->type;
        $data['answer']  = $answer;

        Question::insert($data);

        return response()->json([
            'status'       => true,
            'success'      => get_phrase('Question has been added.'),
            'functionCall' => 'responseBack()',
        ]);
    }

    public function delete($id)
    {
        $question = Question::where('id', $id)->first();
        if (! $question) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $question->delete();
        Session::flash('success', get_phrase('Question has been deleted.'));
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $question = Question::where('id', $id)->first();
        if (! $question) {
            return response()->json_encode([
                'error' => get_phrase('Data not found.'),
            ]);
        }

        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'type'    => 'required',
            'answer'  => 'required',
            'options' => 'required_if:type,mcq',
        ], [
            'options.required_if' => 'When type is MCQ, options are required.',
        ]);

        if ($validator->fails()) {
            return json_encode(array('validationError' => $validator->getMessageBag()->toArray()));
        }

        $answer = $data['options'] = null;
        if ($request->type == 'mcq') {
            $answer          = json_encode($request->answer);
            $data['options'] = json_encode(array_column(json_decode($request->options, true), 'value'));
        } elseif ($request->type == 'fill_blanks') {
            $answers = json_decode($request->answer);
            $answer  = json_encode(array_column($answers, 'value'));
        } elseif ($request->type == 'true_false') {
            $answer = $request->answer;
        }

        $data['quiz_id'] = $request->quiz_id;
        $data['title']   = $request->title;
        $data['type']    = $request->type;
        $data['answer']  = $answer;

        Question::where('id', $id)->update($data);

        return response()->json([
            'status'       => true,
            'success'      => get_phrase('Question has been updated.'),
            'functionCall' => 'responseBack()',
        ]);
    }

    public function sort(Request $request)
    {
        $question = json_decode($request->itemJSON);
        foreach ($question as $key => $value) {
            $updater = $key + 1;
            Question::where('id', $value)->update(['sort' => $updater]);
        }
        Session::flash('success', get_phrase('Questions has been sorted.'));
    }

    public function load_type(Request $request)
    {
        $page_data = [];
        $types     = [
            'mcq'         => 'mcq',
            'fill_blanks' => 'fill_blanks',
            'true_false'  => 'true_false',
        ];

        if (isset($types[$request->type])) {
            $action = $request->id ? 'edit' : 'create';
            $path   = "admin.questions.{$action}_{$types[$request->type]}";

            if ($request->id) {
                $page_data['question'] = Question::where('id', $request->id)->first();
            }
        }

        return view($path, $page_data);
    }
}
