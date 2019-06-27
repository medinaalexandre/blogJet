@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-2">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <form action="/categories" method="POST" class="pb-5">
                            <div class="form-group">
                                <label for="name" >Nome:</label>
                                <input type="text" name="name" placeholder="Nome" value="{{ old('name') ?? $c->name }}" class="form-control">
                                <div>{{ $errors->first('name') }}</div>
                            </div>
                            @csrf
                            <button type="submit" class="btn btn-primary">Nova Categoria</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h1>Categorias</h1>
                    <table class="table table-striped table-hover post-table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Criada em</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <th scope="row">{{ $category->id }}</th>
                                <td><a href="categories/{{$category->id}}">{{ $category->name }}</a></td>
                                <td>{{ $category->created_at->format('d M Y - H:i:s') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @include('admin.floatingbutton')
    </div>
@endsection
</div>