@extends('layouts.base')

@section('title', $post->title)


@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>{{ $post->title }}</h1>
            <img src="{{asset($post->image) }}" alt="">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Categorias</h3>
            @foreach($post->categories as $category)
                <a href="/categories/{{$category->id}}"><span class="badge badge-info">{{$category->name}}</span></a>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Comentários</h3>

            @foreach($post->comments as $comment)
                <p><strong>Comentário de {{ $comment->user->name }}: </strong>{{ $comment->comment }}</p>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="/comments/create" method="POST">
                @csrf
                <div class="form-group">
                    <label for="user_id">Autor:</label>
                    <select name="user_id" class="form-control">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $post->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="comment">Comentário</label>
                    <textarea class="form-control" name='comment' placeholder="Escreva seu comentário aqui" rows="7">{{old("comment")}}</textarea>
                </div>

                <input type="hidden" name="post_id" value="{{$post->id}}">

                <button type="submit" class="btn btn-outline-primary">Comentar</button>
            </form>
        </div>
    </div>
@endsection

