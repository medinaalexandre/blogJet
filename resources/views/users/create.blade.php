@extends('layouts.base')

@section('title','Adicionar novo Usuário')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1>Adicionando novo Usuário</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <form action="/users" method="POST" class="pb-5">
                    @include('users.form')
                    <button type="submit" class="btn btn-primary">Novo Usuário</button>
                </form>
            </div>
        </div>
    </div>
@endsection