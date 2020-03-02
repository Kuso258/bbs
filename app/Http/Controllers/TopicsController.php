<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Auth;

//引入Topic模型
use App\Models\Topic;

class TopicsController extends Controller
{   
    public function __construct()
    {   
        // authrize
        $this->middleware('auth',[
            'except' => ['index','show'],
        ]);
    }

    public function index(Request $request,Topic $topic){
        $topics = $topic->withOrder($request->order)
                        ->with('user','category') //laravel预加载
                        ->paginate(20);

        return view('topics.index',compact('topics'));
    }

    public function show(Topic $topic){
        return view('topics.show',compact('topic'));
    }

    public function store(TopicRequest $request, Topic $topic){
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();
        return redirect()->route('topics.show',$topic->id)->with('success',"创建帖子成功");
    }

    public function update(TopicRequest $request, Topic $topic){
        return view();
    }

    public function edit(){
        echo 1111;
    }

    public function destory(){
        echo 1111;
    }

    public function create(Topic $topic){
        $categories = Category::all();
        return view('topics.create_and_edit',compact('topic','categories'));
    }
}
