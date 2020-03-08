<?php
function route_class(){
    return str_replace('.',',',Route::currentRouteName());
}

function make_excerpt($value, $length = 200){
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return Str::limit($excerpt,$length);
}

function is_categories_active($paths,$number){
    $paths = trim($paths,'/');
    $path = explode('/',$paths);
    //对应topics路由
    if($path[0] == "topics" && $number == 0){
        return 'active';
    }
    //对应categories路由
    if(is_array($path) && count($path) == 2){
        if($path[0] == "categories"){
            $category_id = explode('?',$path[1]);
            if(is_array($category_id) && $category_id[0] == $number){
                return "active";
            }
        }
    }
    return false;
}

function is_order_by_active($order,$number){
    $active = '';
    if($order == 'default' && $number == 1 ){
        $active = "active";
    }elseif($order == "recent" && $number == 2){
        $active = "active";
    }elseif($order == '' && $number == 1){
        $active = "active";
    }
    return $active;
}

function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix = '')
{
    // 获取数据模型的复数蛇形命名
    $model_name = model_plural_name($model);

    // 初始化前缀
    $prefix = $prefix ? "/$prefix/" : '/';

    // 使用站点 URL 拼接全量 URL
    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

    // 拼接 HTML A 标签，并返回
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    // 从实体中获取完整类名，例如：App\Models\User
    $full_class_name = get_class($model);

    // 获取基础类名，例如：传参 `App\Models\User` 会得到 `User`
    $class_name = class_basename($full_class_name);

    // 蛇形命名，例如：传参 `User`  会得到 `user`, `FooBar` 会得到 `foo_bar`
    $snake_case_name = Str::snake($class_name);

    // 获取子串的复数形式，例如：传参 `user` 会得到 `users`
    return Str::plural($snake_case_name);
}