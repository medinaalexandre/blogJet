@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-2">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Últimos posts</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-light">
                        <thead>
                            <th scope="col">ID</th>
                            <th scope="col">Título</th>
                            <th scope="col">Autor</th>
                            <th scope="col">Criado em</th>
                            <th scope="col">Categorias</th>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <th scope="row">{{ $post->id }}</th>
                                <td><a href="/posts/{{$post->id}}/edit">{{ $post->title }}</a></td>
                                <td><a href="/users/{{$post->user->id}}">{{ $post->user->name }}</a></td>
                                <td>{{ $post->created_at->format('d M Y - H:i:s') }}</td>
                                <td>
                                    @foreach($post->categories as $category)
                                        <a href="/categories/{{$category->id}}"><span class="badge badge-info">{{$category->name}}</span></a>
                                    @endforeach
                                </td>
                                <td><a href="/posts/{{ $post->id }}/edit"><button class="btn btn-primary">Editar</button></a></td>
                                <td>
                                    <form action="/posts/{{ $post->id }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection