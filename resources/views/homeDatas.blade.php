@extends('layouts.masterMinton')
@section('content')
    <div class="container" id="app-management">

        <div class="row">
            <div class="col">
                <div class="card-box">
                    hola soy ales verificando informacion
                </div>
            </div><!-- end col -->
<div class="save-model">
    <h1 class="save-model__title">{{$resultSaveModel["success"]?"Se guardo Correctamente":"No se Guardo correctamtent"}}</h1>
@if(!$resultSaveModel["success"])
    @foreach($resultSaveModel["errors"]  as $key => $error  )

        <span> {{$error}}</span>
        @endforeach
    @endif
</div>
        </div>
    </div>
@endsection
