<?php

namespace App\Http\Controllers;

use App\Poll;
use App\Http\Resources\Poll as PollResource;
use Illuminate\Http\Request;
use Validator;

class PollsController extends Controller
{
    public function index(){
        return response()->json(Poll::paginate(1),200);
    }

    public function show($id){
        $poll = Poll::with('questions')->findorfail($id);
        //$response = new PollResource($poll,200);
        $response['poll'] = $poll;
        $response['questions'] = $poll->questions;
        return response()->json($response, 200);
    }

    public function store(Request $request){
        $rules = ['title' => 'required|max:255'];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $polls = Poll::create($request->all());
        return response()->json($polls,201);
    }

    public function update(Request $request,Poll $poll){
        $poll->update($request->all());
        return response()->json($poll,200);
    }

    public function delete(Poll $poll){
        $poll->delete();
        return response()->json(null, 204);
    }

    public function errors(){
        return response()->json(['msg' => 'Payment are required'],501);
    }

    public function questions(Request $request,Poll $poll){
        $questions = $poll->questions;
        return response()->json($questions,200);
    }

}
