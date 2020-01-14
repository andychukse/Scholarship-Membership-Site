<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    //
    public static function createViewLog($post) {
        $postView = new PostView();
        $postView->post_id = $post->id;
        $postView->session_id = \Request::getSession()->getId();
        $postView->user_id = (\Auth::id());
        $postView->ip = \Request::getClientIp();
        $postView->agent = \Request::header('User-Agent');
        $postView->save();
    }
}
