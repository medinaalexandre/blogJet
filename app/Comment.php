<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{

    protected $guarded = [];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function likes(){
        return $this->hasMany(LikeComment::class);
    }

    public function isAuthUserLikedComment(){
        $like = $this->likes()->where('user_id', Auth::user()->id)->get();
        if($like->isEmpty()){
            return false;
        }
        return true;
    }
}
