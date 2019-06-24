@extends('layouts.base')

@section('title','Adicionar novo Post')

@section('aditionalhead')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1>Adicionando novo post</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <form action="/posts" method="POST" class="pb-5" enctype="multipart/form-data">
                    @include('posts.form')
                    <button type="submit" class="btn btn-primary">Novo Post</button>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#summernote').summernote();
    </script>
@endsection