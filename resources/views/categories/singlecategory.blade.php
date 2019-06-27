@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 mx-auto">
                <h1 class="my-4 text-center">Bem-vindo ao jetBlog</h1>
                <h3 class="my-3 text-center">Posts da categoria <strong>{{ $category->name }}</strong></h3>

                @if($category->posts()->count() == 0)
                    <p class="text-center">Ainda não temos post nesta categoria :(</p>
                @else
                    @foreach ($category->posts as $post)
                        <div class="card mb-4">
                            <img class="card-img-top" @if(is_null($post->image)) src="{{asset('img/default_img_post.png')}}" @else src="/storage/images/{{$post->image}}" @endif  alt="Card image cap">
                            <div class="card-body">
                                <h2 class="card-title text-center">{{ $post->title }}</h2>
                                <p class="card-text"> {{ $post->description }} </p>
                                <a href="/post/{{ $post->slug }}" class="btn btn-primary">Veja o post completo &rarr;</a>
                            </div>
                            <div class="card-footer text-muted">
                                Posted {{ $post->created_at->diffForHumans() }} by
                                <a href="/user/{{$post->user->id}}">{{ $post->user->name }} </a>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>

@endsection