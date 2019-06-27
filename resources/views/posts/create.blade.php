@extends('layouts.app')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>

    <div class="row">
        <div class="col-md-2">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h1 class="text-center">Adicionando novo Post</h1>
                    <div class="form-group">
                        <form action="/posts" method="POST" class="pb-5" enctype="multipart/form-data">
                            @include('posts.form')
                            <button type="submit" class="btn btn-primary">Novo Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#summernote').summernote();
    </script>

    @include('admin.floatingbutton')
@endsection