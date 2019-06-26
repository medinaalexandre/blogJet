@extends('layouts.base')

@section('content')
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <h3>Posts do usuário <strong>{{ $user->name }}</strong></h3>
                </div>
                <ul>
                    @foreach($user->posts as $p)
                        <a href="/posts/{{$p->id}}"><li> {{ $p->title }}</li></a>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

