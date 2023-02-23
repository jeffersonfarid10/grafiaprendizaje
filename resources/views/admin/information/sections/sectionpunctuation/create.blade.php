@extends('adminlte::page')

@section('title', 'Crear regla ortográfica')

@section('content_header')
    <h1 class="text-danger"><strong>Crear regla ortográfica de puntuación nivel dos</strong></h1>
@stop

@section('content')

<div>
    <div class="bg-dark text-white font-bold rounded">
        <a href="{{route('admin.sections.sectionpunctuation.index')}}">
            <button class="btn btn-info m-3">Volver al menú principal</button>
        </a>
    </div>
    <!-- MENSAJE DE SESION -->
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{Session::get('message')}}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            {{--<h4>Rellene los siguientes campos:</h4>--}}
            <h5 class="text-danger"><strong> Rellene los siguientes campos:</strong></h5>
        </div>

        <div class="card-body">
            <form action="{{route('admin.sections.sectionpunctuation.store')}}" method="POST" enctype="multipart/form-data">
                @csrf 

                <div class="form-group">
                    <label>Título</label>
                    <input type="text" name="name" id="name" placeholder="Ingrese el título" value="{{old('name')}}" class="form-control" required>

                    <!-- MENSAJE DE ERROR DE VALIDACION -->
                    @error('name')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Slug:</label>
                    <input type="text" name="slug" id="slug" placeholder="Slug de la publicación" value="{{old('slug')}}" class="form-control" required readonly>

                    <!-- MENSAJE DE ERROR DE VALIDACION -->
                    @error('slug')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Categoría nivel uno:</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option disabled selected>Seleccione una regla</option>
                        @foreach ($categories as $categorypunctuation)
                            <option value="{{$categorypunctuation->id}}">{{$categorypunctuation->name}}</option>
                        @endforeach
                    </select>

                    <!-- MENSAJE DE ERROR DE VALIDACION -->
                    @error('category_id')
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
                                @isset($sectionpunctuation->image)
                                    <img id="picture" src="{{Storage::url($sectionpunctuation->image)}}" alt="">

                                @else 

                                    {{--<img id="picture" src="/imagenesapp/imagenuno.jpg" alt="">--}}
                                    <img id="picture" src="/imagenesapp/imagenformulario.png" alt="" class="border">
                                @endisset
                            </div>
                        </div>
                        <div class="col">
                            <!-- FORMULARIO PARA SUBIR IMAGEN -->
                            <div class="form-group">
                                <label>Imagen:</label>
                                <input type="file" name="image" id="image" class="form-control-file" accept="image/*" value="{{old('image')}}" >

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
                    <textarea name="description" id="description" class="form-control" value="{{old('description')}}"></textarea>

                    <!-- MENSAJE DE ERROR DE VALIDACION -->
                    @error('description')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Contenido</label>
                    <textarea name="body" id="body" class="form-control" value="{{old('body')}}"></textarea>

                    <!-- MENSAJE DE ERROR DE VALIDACION -->
                    @error('body')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Ejemplos:</label>
                    <textarea name="example" id="example" class="form-control" value="{{old('example')}}"></textarea>

                    <!-- MENSAJE DE ERROR DE VALIDACION -->
                    @error('example')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Excepciones:</label>
                    <textarea name="exception" id="exception" class="form-control" value="{{old('exception')}}"></textarea>

                    <!-- MENSAJE DE ERROR DE VALIDACION -->
                    @error('exception')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Términos:</label>
                    <br>
                    <!-- CON EL ISSET SE COMPRUEBA SI HAY TERMINOS PARA MOSTRAR -->
                    @isset($words)
                        @foreach ($words as $glossary)
                            <ul>
                                <!-- SE PONE WORDS[] PORQUE SE VA A GUARDAR EN UN ARRAY LOS TERMINOS QUE EL USUARIO ELIJA Y WORDS
                                ES EL NOMBRE DE LA RELACION MUCHOS A MUCHOS ENTRE WORDS Y CATEGORIES-->
                                <input type="checkbox" name="words[]" value="{{$glossary->id}}">
                                {{$glossary->name}}
                            </ul>
                        @endforeach
                    @endisset
                </div>

                <button type="submit" class="btn btn-primary my-3">Crear regla</button>
            
            </form>

        </div>
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