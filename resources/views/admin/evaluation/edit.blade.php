@extends('adminlte::page')

@section('title', 'Editar evaluación')

@section('content_header')
    <h1>Editar evaluación</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Rellene los siguientes campos</h4>
    </div>
    <!-- MENSAJE DE SESION -->
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{Session::get('message')}}
        </div>
    @endif

    <div class="card-body">
        <form action="{{route('admin.evaluation.update', [$evaluation])}}" method="POST">
            @csrf
            {{method_field('PUT')}}

            <div class="form-group">
                <label>Nombre evaluación:</label>
                <input type="text" name="name" id="name" placeholder="Ingrese el nombre de la evaluación" value="{{$evaluation->name}}" class="form-control" required>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('name')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Slug evaluación:</label>
                <input type="text" name="slug" id="slug" placeholder="Slug de la evaluación" value="{{$evaluation->slug}}" class="form-control" required readonly>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('slug')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Descripción:</label>
                <textarea name="description" id="description" class="form-control" value="{{$evaluation->description}}" required>{{$evaluation->description}}</textarea>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('description')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Tipo de evaluación:</label>
                <select name="type" id="type" class="form-control" required>
                    <option disabled selected>Seleccione una opción</option>
                    <option value="D" @if($evaluationType === "D") selected @endif >Evaluación de diagnóstico</option>
                    <option value="PU" @if($evaluationType === "PU") selected @endif >Práctica Escritura</option>
                    <option value="PD" @if($evaluationType === "PD") selected @endif>Práctica Audio</option>
                    <option value="PT" @if($evaluationType === "PT") selected @endif>Práctica Visión</option>
                    <option value="F" @if($evaluationType === "F") selected @endif>Evaluación Final</option>
                </select>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('type')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Grupo evaluación</label>
                <select name="format" id="format" class="form-control" required>
                    <option disabled selected>Seleccione una opción</option>
                    <option value="1" @if($evaluationFormat === "1") selected @endif>Grupo 1</option>
                    <option value="2" @if($evaluationFormat === "2") selected @endif>Grupo 2</option>
                    <option value="3" @if($evaluationFormat === "3") selected @endif>Grupo 3</option>
                    <option value="4" @if($evaluationFormat === "4") selected @endif>Grupo 4</option>
                    <option value="5" @if($evaluationFormat === "51") selected @endif>Grupo 5</option>
                </select>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('format')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-success my-3">Actualizar evaluación</button>
        </form>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

<!--PLUGIN STRING TO SLUG-->
@section('js')
    
    <script src="{{asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js')}}"></script>

    <script>
        $(document).ready( function() {
            $("#name").stringToSlug({
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                space: '-'
            });
        });
    </script>
@stop