@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-2">
            @include('layouts.sidebar')
        </div>

        @include('admin.floatingbutton')
    </div>
@endsection