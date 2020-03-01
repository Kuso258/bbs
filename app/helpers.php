<?php
function route_class(){
    return str_replace('.',',',Route::currentRouteName());
}

function is_categories_active($paths,$number){
    $paths = trim($paths,'/');
    //对应topics路由
    if($paths == "topics" && $number == 0){
        return 'active';
    }
    //对应categories路由
    $path = explode('/',$paths);
    if(is_array($path) && count($path) == 2){
        if($path[0] == "categories" && $path[1] == $number){
            return "active";
        }
    }
    return false;
}