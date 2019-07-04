<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeComment extends Model
{
    protected $guarded = [];

    protected $table = 'like_comments';

    public function comment(){
        return $this->belongsTo(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
