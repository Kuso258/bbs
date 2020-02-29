<?php

namespace APP\Handlers;

//字符串
use Illuminate\Support\Str;

//使用Image
use Image;

class ImageUploadHandler
{
    protected $allowed_ext = [
        "png",
        "jpg",
        "gif",
        "jpeg",
    ];

    public function save($file, $folder, $file_prefix, $max_width=false)
    {
        // 文件夹储存规则
        // uploads/images/avatars/201709/21/
        $folder_name = "uploads/images/$folder/".date("ym/d",time());

        // 文件具体的储存路径，获取`public`文件夹的物理路径。
        $upload_path = public_path().'/'.$folder_name;

        // 获取文件的后缀名
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        $filename = $file_prefix.'_'.time().'_'.Str::random(10).'.'.$extension;

        //如果上传的不是允许的图片
        if(!in_array($extension,$this->allowed_ext)){
            return false;
        }

        $file->move($upload_path,$filename);

        // 如果限制了图片宽度，就进行裁剪
        if ($max_width && $extension != 'gif') {

            // 此类中封装的函数，用于裁剪图片
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        $return_arr = [
            'path' => config('app.url')."/$folder_name/$filename",
        ];

        return $return_arr;
    }

    public function reduceSize($file_path,$max_width){
        $image = Image::make($file_path);

        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        $image->save();
    }
}
