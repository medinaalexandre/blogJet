@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-2">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <h1>Editando o usuário {{ $user->name }}</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <form action="/users/{{ $user->id }}" method="POST" class="pb-5">
                        @method('PATCH')
                        @include('users.form')
                        <button type="submit" class="btn btn-success">Salvar Usuário</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection