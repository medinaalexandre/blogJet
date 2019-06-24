@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-2">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <h3>Posts na categoria <strong>{{ $category->name }}</strong></h3>
                </div>
                <ul>
                    @foreach($category->posts as $p)
                        <a href="/posts/{{$p->id}}"><li> {{ $p->title }}</li></a>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

