<?php

namespace App\Http\Controllers;

use App\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::orderByDesc('created_at')->paginate(10);
        return view('home', compact('posts'));
    }
}
