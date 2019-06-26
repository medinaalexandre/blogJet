<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Post;
use App\User;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $post = Post::create($this->validateRequest());
        if(is_null($post->slug)) {
            $post->slug = Str::slug($post->title, '-');
            $post->save();
        }
        $this->storeImage($post);

        return redirect('posts');

    }

    private function storeImage(Post $post)
    {
        if(request()->hasFile('image')){
            $url = Storage::put('public/images', request()->image, 'public');
            $post->image = $url;
            $post->image = Str::substr($post->image, 14);
            $post->save();
        }
    }

    public function storeComment(Request $request)
    {
        $comment = Comment::create($this->validateCommentRequest());

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
        if(request()->hasFile('image')){
            $url = Storage::put('public/images', request()->image, 'public');
            $post->image = $url;
            $post->image = Str::substr($post->image, 14);
            $post->save();
        }

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

        if(is_null(Like::where(['post_id' => $post->id,
                                'user_id' => Auth::user()->id])->first())){
            $like = 0;
        }else{
            $like = 1;
        }

        return view('singlepost', compact('post', 'like'));
    }

    public function search(){
        $posts = Post::where('title', 'LIKE', '%'. request()->search. '%')->get();

        return view('posts.search', compact('posts'));
    }
}
