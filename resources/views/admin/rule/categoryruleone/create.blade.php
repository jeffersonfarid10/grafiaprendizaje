@extends('adminlte::page')

@section('title', 'Crear regla ortográfica')

@section('content_header')
    <h1>Crear regla ortográfica nivel uno</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">
        <h4>Rellene los siguientes campos:</h4>
        <div class="bg-dark text-white font-bold rounded">
            <a href="{{route('admin.information.category.index')}}">
                <button class="btn btn-info m-3">Volver al menú principal</button>
            </a>
        </div>
    </div>
    <!-- MENSAJE DE SESION -->
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{Session::get('message')}}
        </div>
    @endif

    <div class="card-body">
        <form action="{{route('admin.information.category.store')}}" method="POST" enctype="multipart/form-data">
            @csrf 

            <div class="form-group">
                <label>Título:</label>
                <input type="text" name="name" id="name" placeholder="Ingrese el título" value="{{old('title')}}" class="form-control" required>

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
                <div class="row mb-3">
                    <div class="col">
                        <div class="image-wrapper">
                            <!-- EL ISSET COMPRUEBA SI EN LA SECCION DE SUBIR IMAGEN EXISTE YA UNA IMAGEN (EN EL CASO DE EDITAR CATEGORY, QUE YA TIENE UNA IMAGEN CARGADA)
                            SI ES ASI, ENTONCES QUE MUESTRE ESA IMAGEN EN LA PREVISUALIZACION, CASO CONTRARIO QUE MUESTRE LA IMAGEN POR DEFECTO -->
                            <!-- CON EL ISSET VERIFICAR SI EXISTE UN OBJETO TIPO CATEGORY (COMO EN EL CASO DE LA VISTA EDITAR) Y SI ES ASI, ENTONCES MUESTRA LA IMAGEN RELACIONADA DE ESA PUBLICACION
                            CASO CONTRARIO (COMO ES EN LA VISTA CREAR CATEGORY QUE NO TIENE NINGUN OBJETO TIPO CATEGORY CREADO) SE MUESTRA LA IMAGEN POR DEFECTO -->
                            @isset($category->image)
                                <img id="picture" src="{{Storage::url($category->image)}}" alt="">

                            @else 
                                <img id="picture" src="/imagenesapp/imagenuno.jpg" alt="">
                            @endisset
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Imagen</label>
                            <input type="file" name="image" id="image" class="form-control-file" accept="image/*" value="{{old('image')}}" required>

                            <!-- ERROR DE VALIDACION -->
                            @error('image') 
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <p>Ingrese la imagen</p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Descripción:</label>
                <textarea name="description" id="description" cols="30" rows="10" class="form-control" value="{{old('description')}}"></textarea>

                <!-- ERROR DE VALIDACION -->
                @error('description') 
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Contenido:</label>
                <textarea name="body" id="body" cols="30" rows="10" class="form-control" value="{{old('description')}}"></textarea>
            </div>
        </form>
        
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop