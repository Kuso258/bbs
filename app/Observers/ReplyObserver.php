<?php

namespace App\Observers;
use App\Models\Reply;
use App\Notifications\TopicReplied;

class ReplyObserver
{
    public function created(Reply $reply){  
        // $reply->topic->increment('reply_count',1);
        // $reply->topic->reply_count = $reply->topic->replies->count();
        // $reply->topic->save();
        $reply->topic->updateReplyCount();

        // 通知话题作者有新的评论
        //user模型使用了 trait —— Notifiable
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    public function creating(Reply $reply){
        $reply->content = htmlspecialchars($reply->content, ENT_NOQUOTES, 'UTF-8', false);
    }

    public function deleted(Reply $reply)
    {
        // $reply->topic->reply_count = $reply->topic->replies->count();
        // $reply->topic->save();
        $reply->topic->updateReplyCount();
    }
}
