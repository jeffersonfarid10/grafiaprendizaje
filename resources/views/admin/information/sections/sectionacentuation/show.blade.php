@extends('adminlte::page')

@section('title', 'Ver regla')

@section('content_header')
    <h1 class="text-danger"><strong>Información de la publicación</strong></h1>
@stop

@section('content')

<div>
    <div class="bg-dark text-white font-bold rounded">
        <a href="{{route('admin.sections.sectionacentuation.index')}}">
            <button class="btn btn-info m-3">Volver al menú principal</button>
        </a>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            <strong class="text-danger">Título:</strong>
            <br>
            <h1 class="card-title">{{$sectionacentuation->name}}</h1>
            <br>
            <strong class="text-danger">Categoría a la que pertenece:</strong>
            <br>
            <h1 class="card-title">{{$sectionacentuation->category->name}}</h1>
            <br>
        </div>
        <br>
        <div class="card-body">
            <!-- COMPROBAR SI EL CAMPO IMAGE TIENE CONTENIDO, SI TIENE CONTENIDO SE MUESTRA EL DIV, PERO SI EL CAMPO IMAGE ES NULL QUE NO SE MUESTRE LA SECCION -->
            @isset($sectionacentuation->image)
                <li class="list-group-item">
                    <strong class="text-danger">Imagen:</strong>
                    <br>
                    <img id="image" name="image" src="/storage/{{$sectionacentuation->image}}" alt="" height="400px" width="700px">
                </li>
            @endisset

            <!-- COMPROBAR SI EL CAMPO DESCRIPTION TIENE CONTENIDO, SI TIENE CONTENIDO SE MUESTRA EL CONTENIDO, PERO SI EL CAMPO ES NULL QUE NO SE MUESTRE LA SECCION -->
            @isset($sectionacentuation->description)
                <div>
                    <strong>Descripción:</strong>
                    <br>
                    <p class="card-text">{!!$sectionacentuation->description!!}</p>
                </div>
            @endisset


            <!-- CAMPO BODY -->
            <div>
                <h4><strong class="text-danger">Contenido:</strong></h4>
                <br>
                <p class="card-text">{!!$sectionacentuation->body!!}</p>

                <!-- Bibliografía -->
                <h5><strong>Bibliografía:</strong></h5>
                <p>RAE (Real Academia Española) y ASALE (Asociación de Academias de la Lengua Española). (2012). Ortografía básica de la lengua española. Espasa. </p>
            </div>


            <!-- COMPROBAR SI EL CAMPO EXAMPLE TIENE CONTENIDO, SI TIENE CONTENIDO SE MUESTRA EL CONTENIDO, PERO SI EL CAMPO ES NULL QUE NO SE MUESTRE LA SECCION -->
            @isset($sectionacentuation->example)
                <div>
                    <strong>Ejemplos:</strong>
                    <br>
                    <p class="card-text">{!!$sectionacentuation->example!!}</p>
                </div>
            @endisset


            <!-- COMPROBAR SI EL CAMPO EXCEPTION TIENE CONTENIDO, SI TIENE CONTENIDO SE MUESTRA EL CONTENIDO, PERO SI EL CAMPO ES NULL QUE NO SE MUESTRE LA SECCION -->
            @isset($sectionacentuation->exception)
                <div>
                    <strong>Excepciones:</strong>
                    <br>
                    <p class="card-text">{!!$sectionacentuation->exception!!}</p>
                </div>
            @endisset

            <!-- CON EL IF SE CUENTA SI LA RELACION CATEGORIES WORDS TIENE 1 ELEMENTO O MAS 
            ES DECIR, SI EL USUARIO HA SELECCIONADO TERMINOS PARA LA REGLA -->
            @if (count($sectionacentuation->words) > 0)
                <div>
                    <strong>Términos asociados:</strong>
                    <br>
                    @foreach ($sectionacentuation->words as $word)
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
            <strong class="text-danger">Categoría principal: </strong>
            <h6>{{$sectionacentuation->type}}</h6>
            <br>
            <strong class="text-danger">Categoría secundaria:</strong>
            <h6>{{$category->name}}</h6>
        </div>

        <!-- CON EL IF SE COMPRUEBA SI EXISTE MAS DE UNA REGLA DE NIVEL 3 ASOCIADAS A LA REGLA SECTIONWORD -->
        @if(count($sectionacentuation->posts) > 0)
            <div class="card-footer">
                <!-- REGLAS DE NIVEL 2 ASOCIADAS -->
                <strong class="text-danger">Reglas nivel tres asociadas:</strong>
                <br>
                @foreach ($sectionacentuation->posts as $post)
                    <h6>{{$post->name}}</h6>
                @endforeach
            </div>
        @endif
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop