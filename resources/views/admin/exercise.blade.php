@extends('adminlte::page')

@section('title', 'Preguntas')

@section('content_header')
    <h1 class="text-white bg-dark font-bold rounded pl-3">Gestión de Preguntas</h1>
@stop

@section('content')

<div class="m-4">
    <div class="row">
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-dark">
                    Preguntas opción multiple
                </div>
                <div class="card-body">
                    
                    <br>
                    <p class="card-text">Sección para crear, editar y eliminar las preguntas y ejercicios de opción multiple.</p>
                    <a href="{{route('admin.question.opcionmultiple.index')}}" class="btn btn-primary">Ingresar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-dark">
                    Preguntas opción multiple con imagen
                </div>
                <div class="card-body">
                    
                    <br>
                    <p class="card-text">Sección para crear, editar y eliminar las preguntas y ejercicios de opción multiple que contienen imágenes.</p>
                    <a href="{{route('admin.question.opcionmultiplei.index')}}" class="btn btn-primary">Ingresar</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-dark">
                    Preguntas opción multiple con audio
                </div>
                <div class="card-body">
                    
                    <br>
                    <p class="card-text">Sección para crear, editar y eliminar las preguntas y ejercicios de opción multiple que contienen audios.</p>
                    <a href="{{route('admin.question.opcionmultiplea.index')}}" class="btn btn-primary">Ingresar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-dark">
                    Preguntas oraciones con audio
                </div>
                <div class="card-body">
                    
                    <br>
                    <p class="card-text">Sección para crear, editar y eliminar las preguntas y ejercicios de oraciones con audios.</p>
                    <a href="{{route('admin.question.oracionaudio.index')}}" class="btn btn-primary">Ingresar</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-dark">
                    Preguntas oraciones con imagen
                </div>
                <div class="card-body">
                    
                    <br>
                    <p class="card-text">Sección para crear, editar y eliminar las preguntas y ejercicios de oraciones con imagen.</p>
                    <a href="{{route('admin.question.oracionimagen.index')}}" class="btn btn-primary">Ingresar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-dark">
                    Preguntas corrección de palabras
                </div>
                <div class="card-body">
                    
                    <br>
                    <p class="card-text">Sección para crear, editar y eliminar las preguntas y ejercicios de corrección de palabras.</p>
                    <a href="{{route('admin.question.palabracorreccion.index')}}" class="btn btn-primary">Ingresar</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-dark">
                    Preguntas juego ahorcado
                </div>
                <div class="card-body">
                    
                    <br>
                    <p class="card-text">Sección para crear, editar y eliminar las preguntas y ejercicios del juego del ahorcado.</p>
                    <a href="{{route('admin.question.juego.index')}}" class="btn btn-primary">Ingresar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-dark">
                    Preguntas texto con imagen
                </div>
                <div class="card-body">
                    
                    <br>
                    <p class="card-text">Sección para crear, editar y eliminar las preguntas y ejercicios de texto con imagenes.</p>
                    <a href="{{route('admin.question.textoimagen.index')}}" class="btn btn-primary">Ingresar</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-dark">
                    Preguntas texto con audio
                </div>
                <div class="card-body">
                    
                    <br>
                    <p class="card-text">Sección para crear, editar y eliminar las preguntas y ejercicios de texto con audios.</p>
                    <a href="{{route('admin.question.textoaudio.index')}}" class="btn btn-primary">Ingresar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="col">
                <div class="card m-5">
                    <div class="card-header text-white bg-dark">
                        Preguntas sopa de letras
                    </div>
                    <div class="card-body">
                        
                        <br>
                        <p class="card-text">Sección para crear, editar y eliminar las preguntas y ejercicios de sopa de letras.</p>
                        <a href="{{route('admin.question.sopaletras.index')}}" class="btn btn-primary">Ingresar</a>
                    </div>
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