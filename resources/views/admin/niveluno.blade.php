@extends('adminlte::page')

@section('title', 'Reglas nivel uno')

@section('content_header')
    <h1 class="text-white bg-dark py-3 text-center"><strong>Gestión de reglas ortográficas nivel uno</strong></h1>
@stop

@section('content')
    
<div class="m-4">

    <div class="row">
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-gray-dark">
                    
                    <h4 class="text-center"><strong>Reglas ortográficas de palabras nivel 1</strong></h4>
                </div>
                <div class="card-body">
                    <br>
                    <p class="card-text">Gestión de reglas ortográficas de palabras nivel 1.</p>
                    <a href="{{route('admin.categories.categoryword.index')}}" class="btn btn-primary">Ingresar</a>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-gray-dark">
                    
                    <h4 class="text-center"><strong>Reglas ortográficas de acentuación nivel 1</strong></h4>
                </div>
                <div class="card-body">
                    <br>
                    <p class="card-text">Gestión de reglas ortográficas de acentuación nivel 1.</p>
                    <a href="{{route('admin.categories.categoryacentuation.index')}}" class="btn btn-primary">Ingresar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-gray-dark">
                    
                    <h4 class="text-center"><strong>Reglas ortográficas de puntuación nivel 1</strong></h4>
                </div>
                <div class="card-body">
                    <br>
                    <p class="card-text">Gestión de reglas ortográficas de puntuación nivel 1.</p>
                    <a href="{{route('admin.categories.categorypunctuation.index')}}" class="btn btn-primary">Ingresar</a>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop