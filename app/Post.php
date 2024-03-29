<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Post extends Model
{


    public static function boot(){
        parent::boot();

        static::created(function ($post) {
            if(is_null($post->slug))
                $post->update(['slug' => Str::slug($post->title,'-')]);
        });
    }
    protected $table = 'posts';

    protected $guarded = [];

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany( Category::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function isAuthUserLikedPost(){
        $like = $this->likes()->where('user_id', Auth::user()->id)->get();
        if($like->isEmpty()){
            return false;
        }
        return true;
    }
}
