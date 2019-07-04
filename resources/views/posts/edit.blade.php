@extends('layouts.app')

@section('title','Editando o post "'. $post->title .'""')

@section('aditionalhead')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Editando o post "{{ $post->title }}"</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form action="/posts/{{ $post->id }}" method="POST" class="pb-5" enctype="multipart/form-data">
                    @method('PATCH')
                    @include('posts.form')
                    <button type="submit" class="btn btn-success">Salvar Post</button>
                </form>
            </div>
        </div>

        <script type="text/javascript">
            $('#summernote').summernote();
        </script>
    </div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
@endsection