@extends('layouts.base')


@section('content')
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 mx-auto">
                <h1 class="my-4 text-center">Bem-vindo ao jetBlog</h1>

                @foreach ($posts as $post)
                    <div class="card mb-4">
                        <img class="card-img-top" @if(is_null($post->image)) src="{{asset('img/default_img_post.png')}}" @else src="/storage/images/{{$post->image}}" @endif  alt="Card image cap">
                        <div class="card-body">
                            <h2 class="card-title text-center">{{ $post->title }}</h2>
                            <p class="card-text"> {{ $post->description }} </p>
                            <a href="/post/{{ $post->slug }}" class="btn btn-primary">Read More &rarr;</a>
                        </div>
                        <div class="card-footer text-muted">
                            Posted {{ $post->created_at->diffForHumans() }} by
                            <a href="/user/{{$post->user->id}}">{{ $post->user->name }} </a>
                        </div>
                    </div>
                @endforeach
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
