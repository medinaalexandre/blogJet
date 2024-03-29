<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view ('admin.users', compact('users'));
    }

    /**@
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $roles = Role::all();
        return view('users.create', compact('user','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        User::create($this->validateRequest());

        return redirect('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request->request->get('roles'));
        $user->update($this->validateRequest($request));

        return redirect('users/'.$user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('users');
    }

    public function validateRequest(){
        return request()->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);
    }

    public function singleUser(User $user){
        $posts = Post::where('user_id', $user->id)->paginate(5);

        return view('users.singleuser', compact('user', 'posts'));
    }

    public function myLikes(User $user){

        $likes = Like::where('user_id', $user->id)->paginate(5);
        if($user->id == Auth::user()->id)
            return view('users.myLikes', compact('likes'));
        else
            return redirect('home');
    }
}
