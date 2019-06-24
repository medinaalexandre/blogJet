<?php

namespace App\Http\Controllers;

use App\Commentary;
use Illuminate\Http\Request;

class CommentariesController extends Controller
{
    public function store(){
        $commentary = new Commentary();
        $commentary->commentary = request('commentary');

        return back();
    }

    public function create(){
        //
    }
}
