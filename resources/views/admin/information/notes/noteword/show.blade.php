@extends('adminlte::page')

@section('title', 'Ver regla')

@section('content_header')
    <h1>Información de la regla</h1>
@stop

@section('content')

<div>
    <div class="bg-dark text-white font-bold rounded">
        <a href="{{route('admin.notes.noteword.index')}}">
            <button class="btn btn-info m-3">Volver al menú principal</button>
        </a>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            <strong>Título:</strong>
            <br>
            <h1 class="card-title">{{$noteword->name}}</h1>
            <br>
            <strong>Regla principal a la que pertenece:</strong>
            <br>
            <h1 class="card-title">{{$noteword->rule->name}}</h1>
            <br>
        </div>
        <br>
        <div class="card-body">
            <!-- COMPROBAR SI EL CAMPO IMAGE TIENE CONTENIDO, SI TIENE CONTENIDO SE MUESTRA EL DIV, PERO SI EL CAMPO IMAGE ES NULL QUE NO SE MUESTRE LA SECCION -->
            @isset($noteword->image)
                <li class="list-group-item">
                    <strong>Imagen:</strong>
                    <br>
                    <img id="image" name="image" src="/storage/{{$noteword->image}}" alt="" height="400px" width="700px">
                </li>
            @endisset

            <!-- COMPROBAR SI EL CAMPO DESCRIPTION TIENE CONTENIDO, SI TIENE CONTENIDO SE MUESTRA EL CONTENIDO, PERO SI EL CAMPO ES NULL QUE NO SE MUESTRE LA SECCION -->
            @isset($noteword->description)
                <div>
                    <strong>Descripción:</strong>
                    <br>
                    <p class="card-text">{!!$noteword->description!!}</p>
                </div>
            @endisset


            <!-- CAMPO BODY -->
            <div>
                <strong>Contenido:</strong>
                <br>
                <p class="card-text">{!!$noteword->body!!}</p>
            </div>


            <!-- COMPROBAR SI EL CAMPO EXAMPLE TIENE CONTENIDO, SI TIENE CONTENIDO SE MUESTRA EL CONTENIDO, PERO SI EL CAMPO ES NULL QUE NO SE MUESTRE LA SECCION -->
            @isset($noteword->example)
                <div>
                    <strong>Ejemplos:</strong>
                    <br>
                    <p class="card-text">{!!$noteword->example!!}</p>
                </div>
            @endisset


            <!-- COMPROBAR SI EL CAMPO EXCEPTION TIENE CONTENIDO, SI TIENE CONTENIDO SE MUESTRA EL CONTENIDO, PERO SI EL CAMPO ES NULL QUE NO SE MUESTRE LA SECCION -->
            @isset($noteword->exception)
                <div>
                    <strong>Excepciones:</strong>
                    <br>
                    <p class="card-text">{!!$noteword->exception!!}</p>
                </div>
            @endisset

            <!-- CON EL IF SE CUENTA SI LA RELACION CATEGORIES WORDS TIENE 1 ELEMENTO O MAS 
            ES DECIR, SI EL USUARIO HA SELECCIONADO TERMINOS PARA LA REGLA -->
            @if (count($noteword->words) > 0)
                <div>
                    <strong>Términos asociados:</strong>
                    <br>
                    @foreach ($noteword->words as $word)
                        <strong class="text-red">{{$word->name}} :</strong>
                        <br>
                        <p class="card-text">{{$word->meaning}}</p>
                        <br>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="card-footer">
            <!-- INFORMACION DE A DONDE PERTENECE LA REGLA -->
            <strong>Categoria principal</strong>
            <h6>{{$noteword->type}}</h6>
            <br>
            <strong>Categoría secundaria: </strong>
            <h6>{{$category->name}}</h6>
            <br>
            <strong>Categoría terciaria:</strong>
            <h6>{{$section->name}}</h6>
            <br>
            <strong>Categoría cuatro:</strong>
            <h6>{{$post->name}}</h6>
            <br>
            <strong>Categoria cinco:</strong>
            <h6>{{$noteword->rule->name}}</h6>
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