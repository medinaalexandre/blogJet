@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-md-2">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{ $user->name }}</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <p><strong>Criado em: </strong> {{ $user->created_at->format('d M Y - H:i:s') }}</p>
                    <p><strong>Atualizado pela última vez em: </strong> {{ $user->updated_at->format('d M Y - H:i:s') }}</p>
                    <p><strong>Email: </strong>{{ $user->email }}</p>
                    <p><strong>Funções:</strong>@foreach($user->roles as $role)
                            <span class="badge badge-info">{{$role->name}}</span>
                        @endforeach</p>
                    <p><strong>Senha: </strong>{{ $user->password }}</p>
                </div>
                <a href="/users/{{ $user->id }}/edit">Editar usuário</a>
                <form action="/users/{{ $user->id }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
@endsection
