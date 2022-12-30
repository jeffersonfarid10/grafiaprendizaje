@extends('adminlte::page')

@section('title', 'Preguntas opción múltiple con imágenes')

@section('content_header')
    <h1>Gestión de preguntas de opción múltiple con imágenes</h1>
@stop

@section('content')
<div class="card">
    <!--MENSAJE DE SESION-->
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{Session::get('message')}}
        </div>
    @endif

    <div class="card-header">
        <a href="{{route('admin.question.opcionmultiplei.create')}}">
            <button class="btn btn-success m-3">Crear nueva pregunta</button>
        </a>
    </div>

    <div class="card-body">
        @isset($questions)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Enunciado</th>
                        <th>Evaluación</th>
                        <th colspan="3" class="text-center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $key=>$opcionmultiplei)
                        <tr>
                            <td>{{$opcionmultiplei->id}}</td>
                            <td>{{$opcionmultiplei->title}}</td>
                            <td>{{$opcionmultiplei->evaluation->name}}</td>
                            <td>
                                <a href="{{route('admin.question.opcionmultiplei.show', $opcionmultiplei)}}">
                                    <button class="btn btn-secondary">Ver Pregunta</button>
                                </a>
                            </td>
                            <td>
                                <a href="{{route('admin.question.opcionmultiplei.edit', $opcionmultiplei)}}">
                                    <button class="btn btn-info">Editar</button>
                                </a>
                            </td>
                            <td>
                                <form action="{{route('admin.question.opcionmultiplei.destroy', $opcionmultiplei)}}" method="POST">
                                    @csrf 
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- PAGINACION CON BOOSTRAP -->
            <div class="d-flex justify-content-end">
                {{$questions->links()}}
            </div>
        @else 
            <strong>No hay preguntas disponibles.</strong>
        @endisset
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop