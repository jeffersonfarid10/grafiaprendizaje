@extends('adminlte::page')

@section('title', 'Reglas nivel cuatro')

@section('content_header')
    <h1 class="text-white bg-dark font-bold pl-3">Gestión de reglas ortográficas nivel cuatro</h1>
@stop

@section('content')
    
<div class="m-4">

    <div class="row">
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-gray-dark">
                    Reglas ortográficas de palabras nivel 4
                </div>
                <div class="card-body">
                    <br>
                    <p class="card-text">Gestión de reglas ortográficas de palabras nivel 4.</p>
                    <a href="{{route('admin.rules.ruleword.index')}}" class="btn btn-primary">Ingresar</a>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-gray-dark">
                    Reglas ortográficas de acentuación nivel 4
                </div>
                <div class="card-body">
                    <br>
                    <p class="card-text">Gestión de reglas ortográficas de acentuación nivel 4.</p>
                    <a href="{{route('admin.rules.ruleacentuation.index')}}" class="btn btn-primary">Ingresar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-gray-dark">
                    Reglas ortográficas de puntuación nivel 4
                </div>
                <div class="card-body">
                    <br>
                    <p class="card-text">Gestión de reglas ortográficas de puntuación nivel 4.</p>
                    <a href="{{route('admin.rules.rulepunctuation.index')}}" class="btn btn-primary">Ingresar</a>
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