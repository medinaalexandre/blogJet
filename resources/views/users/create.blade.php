@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-2">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h1 class="text-center">Adicionando novo Usuário</h1>
                    <div class="form-group">
                        <form action="/users" method="POST" class="pb-5">
                            @include('users.form')
                            <button type="submit" class="btn btn-primary">Novo Usuário</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection