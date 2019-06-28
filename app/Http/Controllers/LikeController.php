<?php

namespace App\Http\Controllers;

use App\Like;
use App\LikeComment;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(){
        $like = Like::where(['post_id' => request()->post_id,
                             'user_id' => request()->user_id])->first();
        if(is_null($like)){
            Like::create(request()->validate([
                'user_id' => 'required',
                'post_id' => 'required',
            ]));
        }else{
            $like->delete();
        }
        return response()->json(['reponse'=>'success']);
    }

    public function storeLikeComment(){

        $likeComment = LikeComment::where(['user_id' => request()->user_id,
                                            'comment_id' => request()->comment_id])->first();

        if(is_null($likeComment)){
            LikeComment::create(request()->validate([
                'user_id' => 'required',
                'comment_id' => 'required',
            ]));
        }else{
            $likeComment->delete();
        }

        return response()->json(['reponse'=>'success']);
    }
}
