<?php

namespace App\Http\Controllers;

use App\Post;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        {
            if (request()->user()->hasRole('admin')) {
                $posts = Post::all()->sortByDesc('created_at');
                return view('admin.dashboard', compact('posts'));
            }else{
                return redirect('home');
            }
        }
    }

    public function posts(){
        $posts = Post::all();
        return view('admin.posts', compact('posts'));
    }


}
