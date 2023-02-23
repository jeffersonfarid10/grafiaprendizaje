@extends('adminlte::page')

@section('title', 'Preguntas')

@section('content_header')
    <h1 class="text-white bg-dark rounded py-3 text-center"><strong>Gestión de Actividades</strong></h1>
@stop

@section('content')

<div class="m-4">
    <div class="row">
        <div class="col">
            <div class="card m-5">
                <div class="card-header text-white bg-dark">
                    <h4 class="text-center"><strong>Actividades opción multiple</strong></h4>
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
                    
                    <h4 class="text-center"><strong>Actividades opción multiple con imagen</strong></h4>
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
                    
                    <h4 class="text-center"><strong>Actividades opción multiple con audio</strong></h4>
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
                    <h4 class="text-center"><strong>Actividades de oraciones con audio</strong></h4>
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
                    
                    <h4 class="text-center"><strong>Actividades de oraciones con imagen</strong></h4>
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
                    
                    <h4 class="text-center"><strong>Actividades de corrección de palabras</strong></h4>
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
                    <h4 class="text-center"><strong>Actividades de juego del ahorcado</strong></h4>
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
                    
                    <h4 class="text-center"><strong>Actividades de texto con imagen</strong></h4>
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
                   
                    <h4 class="text-center"><strong>Actividades de texto con audio</strong></h4>
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
                        
                        <h4 class="text-center"><strong>Actividades de sopa de letras</strong></h4>
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