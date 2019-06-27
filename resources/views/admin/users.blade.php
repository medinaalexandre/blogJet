@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-2">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Usuários</h1>

                    <a href="/users/create"><button class="btn btn-info">Adicionar novo Usuário</button></a>

                    <table class="table table-striped table-hover post-table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Criado em</th>
                            <th scope="col">Funções</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td><a href="/users/{{$user->id}}">{{ $user->name }}</a></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d M Y - H:i:s') }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge badge-info">{{$role->name}}</span>
                                    @endforeach
                                </td>
                                <td><a href="/users/{{$user->id}}/edit"><button class="btn"><i class="fas fa-pencil-alt"></i></button></a></td>
                                <td><form action="/users/{{ $user->id }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn"><i class="fas fa-trash"></i></button>
                                </form></td>
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