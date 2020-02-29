<?php

namespace App\Http\Controllers;

//普通请求
use Illuminate\Http\Request;

//引入表单请求验证(FormRequest) 是laravel框架提供的表单验证 
use App\Http\Requests\UserRequest;

//引入User模型，这样注入到类里面的方法中可以直接使用
use App\Models\User;

//图片上传
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller{
    
    public function show(User $user){
        return view('user.show',compact('user'));
    }

    public function edit(User $user){
        $this->authorize('update',$user);
        return view('user.edit',compact('user'));
    }

    public function update(UserRequest $request, User $user, ImageUploadHandler $uploader){
        $this->authorize('update',$user);
        $data = $request->all();
        //图片上传
        if($request->avatar){
            $result = $uploader->save($request->avatar,"avatars",$user->id,416);
            if($result){
                $data['avatar'] = $result['path'];
            }
        }
        // User Model 里面的 $fillable 必须加入
        $res = $user->update($data);
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功');
    }
}