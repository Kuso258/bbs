<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    //本地作用域
    //需简单在对应 Eloquent 模型方法前加上一个 scope 前缀，作用域总是返回 查询构建器
    public function scopeWithOrder($query,$order){
        switch($order){
            case 'recent':
                $query->recent();
                break;
            
            default:
                $query->recentReplied();
                break;
        }
    }

    public function scopeRecentReplied($query){
        return $query->orderBy('updated_at','desc');
    }

    public function scopeRecent($query){
        return $query->orderBy('created_at','desc');
    }
}
