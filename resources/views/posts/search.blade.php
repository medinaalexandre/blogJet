@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row py-5">
        <div class="col-md-12">
            <div class="card" style="width: 100%">
                <ul class="list-group list-group-flush my-3">
                    @foreach($posts as $post)
                        <li class="list-group-item"><a href="/post/{{ $post->slug }}">{{ $post->title }} </a> <div class="text-muted">Posted {{ $post->created_at->diffForHumans() }} by
                                    <a href="/user/{{$post->user->id}}">{{ $post->user->name }}</div></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
</ul>
@endsection