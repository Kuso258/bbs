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