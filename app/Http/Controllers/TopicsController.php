<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Auth;

//图片上传
use App\Handlers\ImageUploadHandler;
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
        $this->authorize('update', $topic);
        $data = $request->all();
        $topic->update($data);
        return redirect()->route('topics.show',$topic->id)->with('success',"更新成功");
    }

    public function edit(Topic $topic){
        $this->authorize('update', $topic);
        $categories = Category::all();
        return view('topics.create_and_edit',compact('topic','categories'));
    }

    public function destroy(Topic $topic){
        $this->authorize('destroy', $topic);
        $topic->delete();
        return redirect()->route('topics.index')->with('success', '成功删除！');
    }

    public function create(Topic $topic){
        $categories = Category::all();
        return view('topics.create_and_edit',compact('topic','categories'));
    }

    public function uploadImage(Request $request, ImageUploadHandler $uploader){
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        
        if($request->upload_file){
            $file = $request->upload_file;
            $result = $uploader->save($file, 'topics', \Auth::id(), 1024);
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }
}
