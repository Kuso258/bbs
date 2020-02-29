<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//引入Topic模型
use App\Models\Topic;

class TopicsController extends Controller
{   
    public function __construct()
    {   
        // authrize
        // $this->middleware('auth',[
        //     'except' => ['index','show'],
        // ]);
    }

    public function index(){
        $topics = Topic::paginate();
        return view('topics.index',compact('topics'));
    }

    public function show(Topic $topic){
        return view('topics.show',compact('topic'));
    }

    public function store(){
        echo 1111;
    }

    public function update(){
        echo 1111;
    }

    public function edit(){
        echo 1111;
    }

    public function destory(){
        echo 1111;
    }

    public function create(Topic $topic){
        return view('topics.create_and_edit',compact('topic'));
    }
}
