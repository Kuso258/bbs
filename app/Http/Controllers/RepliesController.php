<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use Auth;
use App\Http\Requests\ReplyRequest;

class RepliesController extends Controller
{   
    public function __construct()
    {   
        //auth认证
        $this->middleware('auth');
    }
    public function store(ReplyRequest $request, Reply $reply){
        // $data = $request->all();
        $reply->content = $request->content;
        $reply->user_id = Auth::id();
        $reply->topic_id = $request->topic_id;
        $reply->save();
        return redirect()->to(route('topics.show',$reply->topic->id))->with('success','创建评论成功');
    }

    public function destroy(Reply $reply){
        $this->authorize('destroy',$reply);
        $reply->delete();
        return redirect()->to(route('topics.show',$reply->topic->id))->with('success',"评论删除成功");
    }
}
