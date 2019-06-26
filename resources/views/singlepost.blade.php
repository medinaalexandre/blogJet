@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1>
                    {{$post->title}}
                </h1>
                <span>Criado por <a href="/user/{{$post->user->id}}">{{$post->user->name}}</a> em {{ $post->created_at }}</span><br><br>
                <img src="/storage/images/{{$post->image}}" class="img-fluid">
                <p>{!! $post->post_body !!}</p>

                <hr><br><br>

                <h3>Comentários</h3>
                @foreach($post->comments as $c)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Comentário de {{ $c->user->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Postado em{{$c->created_at}}</h6>
                            <p class="card-text">{{$c->comment}}</p>
                        </div>
                    </div>
                @endforeach
                @guest
                    <br>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Você precisa estar <strong>logado</strong> para fazer comentários!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <span></span>
                @else
                <div class="row">
                    <div class="col-md-12">
                        <form action="/comments/create" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>

                            <div class="form-group">
                                <label for="comment">Comentário</label>
                                <textarea class="form-control" name='comment' placeholder="Escreva seu comentário aqui" rows="7">{{old("comment")}}</textarea>
                            </div>

                            <input type="hidden" name="post_id" value="{{$post->id}}">

                            <button type="submit" class="btn btn-outline-primary">Comentar</button>
                        </form>
                    </div>
                </div>
                @endguest
            </div>

            <div class="col-md-2">

            </div>
        </div>
    </div>
@endsection