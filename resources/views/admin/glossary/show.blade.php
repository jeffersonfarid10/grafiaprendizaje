@extends('adminlte::page')

@section('title', 'Ver término')

@section('content_header')
    <h1>Información del término</h1>
@stop

@section('content')

<div class="bg-dark text-white font-bold rounded">
    <a href="{{route('admin.glossary.index')}}">
        <button class="btn btn-info m-3">
            Volver al menú principal
        </button>
    </a>
</div>
<br>
<div class="card">
    <div class="card-header">
        <strong>Término:</strong>
        <br>
        <h1 class="card-title">{{$glossary->name}}</h1>
    </div>
    <div class="card-body">
        <strong>Definición:</strong>
        <br>
        <h4 class="card-title">{{$glossary->meaning}}</h4>
    </div>

    <!-- COMPROBAR QUE SI SOLO EL CAMPO FONT, TIENE CONTENIDO, SE MUESTRE EL DIV, SI EL CAMPO FONT ES NULL QUE NO SE MUESTRE EL DIV -->
    @isset($glossary->font)
        <div class="card-footer">
            <strong>Fuente:</strong>
            <br>
            <h6 class="card-text">{{$glossary->font}}</h6>
        </div>
    @endisset
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop