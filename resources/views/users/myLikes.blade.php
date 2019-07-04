@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="col-md-12">
            <h3 class="text-center py-3"><strong>{{ Auth::user()->name }}</strong></h3>
            <h5 class="text-center text-muted">Minhas curtidas</h5>
            <ul>
                @foreach($likes as $like)
                    <div class="list-group">
                        <a href="/post/{{$like->post->slug}}" class="list-group-item list-group-item-action flex-column align-items-start my-2">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $like->post->title }}</h5>
                                <small>{{ $like->post->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ $like->post->description }}</p>
                            <div class="d-flex w-100 justify-content-between">
                                <small><i class="far fa-thumbs-up"></i> {{ $like->post->likes()->count() }}</small>
                                <small>Curtido em {{ $like->created_at }}</small>
                            </div>
                        </a>
                    </div>
                @endforeach
                {{ $likes->links() }}
            </ul>
        </div>
    </div>
@endsection