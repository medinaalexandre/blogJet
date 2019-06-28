@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <h3 class="text-center py-3"><strong>{{ $user->name }}</strong></h3>
            <h5 class="text-center"><strong>Publicações:</strong> {{ $user->posts->count() }}</h5>
            <ul>

                @foreach($posts as $p)
                    <div class="list-group">
                        <a href="/post/{{$p->slug}}" class="list-group-item list-group-item-action flex-column align-items-start my-2">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $p->title }}</h5>
                                <small>{{ $p->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ $p->description }}</p>
                            <small><i class="far fa-thumbs-up"></i> {{ $p->likes()->count() }}</small>
                        </a>
                    </div>
                @endforeach

                {{ $posts->links() }}
            </ul>
        </div>
    </div>
@endsection

