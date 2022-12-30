@extends('adminlte::page')

@section('title', 'Editar regla ortográfica')

@section('content_header')
    <h1>Editar regla ortográfica de puntuación nivel cinco</h1>
@stop

@section('content')

<div class="bg-dark text-white font-bold rounded">
    <a href="{{route('admin.notes.notepunctuation.index')}}">
        <button class="btn btn-info m-3">Volver al menú principal</button>
    </a>
</div>
<div class="card">
    <!-- MENSAJE DE SESION -->
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{Session::get('message')}}
        </div>
    @endif
    <div class="card-header">
        <h4>Rellene los siguientes campos:</h4>
    </div>
    <div class="card-body">
        <form action="{{route('admin.notes.notepunctuation.update', $notepunctuation)}}" method="POST" enctype="multipart/form-data">
            @csrf 
            {{ method_field('PUT')}}

            <div class="form-group">
                <label>Título</label>
                <input type="text" name="name" id="name" placeholder="Ingrese el título" value="{{$notepunctuation->name}}" class="form-control" required>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('name')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Slug:</label>
                <input type="text" name="slug" id="slug" placeholder="Slug de la publicación" value="{{$notepunctuation->slug}}" class="form-control" required readonly>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('slug')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Regla nivel cuatro:</label>
                <select name="rule_id" id="rule_id" class="form-control" required>
                    
                    @foreach ($rules as $rulepunctuation)
                        <option value="{{$rulepunctuation->id}}" @if($rulepunctuation->id === $notepunctuation->rule_id) selected @endif>{{$rulepunctuation->name}}</option>
                    @endforeach
                </select>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('rule_id')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <br>

            <div class="form-group">
                <div class="row mb-3">
                    <div class="col">
                        <div class="image-wrapper">
                            <!-- EL ISSET COMPRUEBA SI EN LA SECCION DE SUBIR IMAGEN EXISTE YA UNA IMAGEN (EN EL CASO DE EDITAR CATEGORYWORD, QUE YA TIENE UNA IMAGEN CARGADA) 
                            SI ES ASI, ENTONCES QUE MUESTRE ESA IMAGEN EN LA PREVISUALIZACION, CASO CONTRARIO QUE MUESTRE LA IMAGEN POR DEFECTO 
                            CON EL ISSET VERIFICAR SI EXISTE UN OBJETI TIPO CATEGORYWORD (COMO EN EL CASO DE LA VISTA EDITAR)  Y SI ES ASI, ENTONCES MUESTRA LA IMAGEN RELACIONADA DE ESA PUBLICACION
                            CASO CONTRARIO (COMO ES EN LA VISTA CREAR QUE NO TIENE NINGUN OBJETO TIPO CATEGORYWORD CREADO) SE MUESTRA LA IMAGEN POR DEFECTO -->
                            @isset($notepunctuation->image)
                                <img id="picture" src="/storage/{{$notepunctuation->image}}" alt="">
                                
                            @else 

                                <img id="picture" src="/imagenesapp/imagenuno.jpg" alt="">
                            @endisset
                        </div>
                    </div>
                    <div class="col">
                        <!-- FORMULARIO PARA SUBIR IMAGEN -->
                        <div class="form-group">
                            <label>Imagen:</label>
                            <input type="file" name="image" id="image" class="form-control-file" accept="image/*" value="{{$notepunctuation->image}}" >

                            <!-- MENSAJE DE ERROR DE VALIDACION -->
                            @error('image')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <p>Ingrese la imagen.</p>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label>Descripción:</label>
                <textarea name="description" id="description" class="form-control" value="{{$notepunctuation->description}}">{{$notepunctuation->description}}</textarea>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('description')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Contenido</label>
                <textarea name="body" id="body" class="form-control" value="{{$notepunctuation->body}}">{{$notepunctuation->body}}</textarea>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('body')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Ejemplos:</label>
                <textarea name="example" id="example" class="form-control" value="{{$notepunctuation->example}}">{{$notepunctuation->example}}</textarea>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('example')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Excepciones:</label>
                <textarea name="exception" id="exception" class="form-control" value="{{$notepunctuation->exception}}">{{$notepunctuation->exception}}</textarea>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('exception')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Términos:</label>
                <br>
                <!-- CON EL FOREACH SE RECORRE TODA LA COLECCION DE WORDS -->
                @foreach ($words as $glossary)
                    <ul>
                        <!-- EN EL IF SE PREGUNTA SI EL ID DEL GLOSSARY ACTUAL ESTA EN EL ARRAY SELECTEDWORDS LO QUE SIGNIFICA QUE ESA WORDS
                        FUE SELECCIONADA POR EL USUARIO, SI ES ASI ENTONCES QUE SE MARQUE -->
                        <input type="checkbox" name="words[]" value="{{$glossary->id}}" @if(in_array($glossary->id, $selectedWords)) checked @endif>
                        {{$glossary->name}} 
                    </ul>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary my-3">Actualizar regla</button>
        </form>
    </div>
</div>

@stop


<!-- CLASES DE CSS CREADAS PARA LA SECCION DE SUBIR IMAGEN: IMAGE-WRAPPER, IMAGE-WRAPPER IMG-->
@section('css')
    <style>
        .image-wrapper{
            position: relative;
            padding-bottom: 56.25%;
        }

        .image-wrapper img{
            position: absolute;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    </style>
@stop

<!-- LLAMAR AL PLUGIN STRING TO SLUG -->
@section('js')
    <!-- LLAMAR AL SCRIPT STRING TO SLUG -->
    <script src="{{asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js')}}"></script>
    <!-- LLAMAR A CK EDITOR QUE ESTA EN PUBLIC -->
    <script src="{{asset('ckeditor/ckeditor5-build-classic/ckeditor.js')}}"></script>

    

    <script>
        $(document).ready( function() {
            $("#name").stringToSlug({
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                space: '-'
            });
        });

        //REEMPLAZAR TEXTARE DEL BODY CON CKEDITOR
        ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );

        ClassicEditor
        .create( document.querySelector( '#description' ) )
        .catch( error => {
            console.error( error );
        } );


        ClassicEditor
        .create( document.querySelector( '#example' ) )
        .catch( error => {
            console.error( error );
        } );

        ClassicEditor
        .create( document.querySelector( '#exception' ) )
        .catch( error => {
            console.error( error );
        } );


        //CAMBIAR IMAGEN QUE SE MUESTRA POR DEFECTO, POR LA IMAGEN QUE VA A SUBIR EL USUARIO EN LA PREVISUALIZACION
        document.getElementById("image").addEventListener('change', cambiarImagen);

        function cambiarImagen(event){
            var file = event.target.files[0];

            var reader = new FileReader();
            reader.onload = (event) => {
                document.getElementById("picture").setAttribute('src', event.target.result);
            };

            reader.readAsDataURL(file);
        }


        


        
    </script>

    
@stop