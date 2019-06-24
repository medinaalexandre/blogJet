<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view ('admin.posts', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $post = new Post();
        $categories = Category::all();

        return view('posts.create',compact('users', 'post', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post)
    {
        Post::create($this->validateRequest());
        $post->where('id' , $post->id)->update(['slug' => Str::slug($post->title,'-')]);



        return redirect('posts');

    }

    public function storeComment(Request $request)
    {
        Comment::create($this->validateCommentRequest());

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $users = User::all();
        $comments = Comment::where('post');
        return view('posts.show', compact('post', 'users', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $users = User::all();
        $categories = Category::all();

        return view('posts.edit', compact('post', 'users', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->categories()->sync($request->request->get('categories'));
        $post->update($this->validateRequest($request));

        return redirect('admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('posts');
    }

    public function validateRequest(){
        $validatedData = request()->validate([
            'title' => 'required|min:5',
            'description' => 'required',
            'user_id' => 'required',
            'slug' => 'sometimes',
            'post_body' => 'required',
            'image' => 'sometimes|file|image|max:5000',
        ],[
            'title.required' => "O título é obrigatório!",
            'title.required' => "O título precisa ter mais que 5 caracteres!",
            'description.required' => "A descrição é obrigatória!",
        ]);

        return $validatedData;
    }

    public function validateCommentRequest(){
        return request()->validate([
           'user_id' => 'required',
           'post_id' => 'required',
           'comment' => 'required|min:5',
        ]);
    }

    public function singlePost($slug){
        $post = Post::where(['slug' => $slug])->firstOrFail();

        return view('singlepost', compact('post'));
    }
}
