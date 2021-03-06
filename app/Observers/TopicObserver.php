<?php

namespace App\Observers;
// use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;
//Eloquent 模型会触发许多事件（Event），我们可以对模型的生命周期内多个时间点进行监控：
// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored


// 当一个新模型被初次保存将会触发 creating 以及 created 事件。如果一个模型已经存在于数据库且调用了 save 方法，将会触发 updating 和 updated 事件。在这两种情况下都会触发 saving 和 saved 事件。

class TopicObserver{
    public function saving(Topic $topic){
        //xxs过滤
        // $topic->body = clean($topic->body, 'user_topic_body');

        $topic->excerpt = make_excerpt($topic->body);
    }

    public function saved(Topic $topic)
    {   
        if (!$topic->slug) {
            dispatch(new TranslateSlug($topic));
        }
    }

    public function deleted(Topic $topic)
    {
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}