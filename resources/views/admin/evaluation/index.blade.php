@extends('adminlte::page')

@section('title', 'Evaluaciones')

@section('content_header')
    <h1 class="text-danger"><strong>Gestión de Evaluaciones</strong></h1>
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
            <a href="{{route('admin.evaluation.create')}}">
                <button class="btn btn-success m-3">Crear nueva evaluación</button>
            </a>
        </div>

        <div class="card-body">
            @isset($evaluations)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Examen</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Grupo</th>
                            <th colspan="3" class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($evaluations as $key=>$evaluation)
                            <tr>
                                <td>{{$evaluation->id}}</td>
                                <td>{{$evaluation->name}}</td>
                                <td>{{$evaluation->description}}</td>
                                <td>{{$evaluation->type}}</td>
                                <td>{{$evaluation->format}}</td>
                                <td>
                                    <a href="{{route('admin.evaluation.questions', $evaluation)}}">
                                        <button class="btn btn-primary">Ver Preguntas</button>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('admin.evaluation.edit', $evaluation)}}">
                                        <button class="btn btn-info">Editar</button>
                                    </a>
                                </td>
                                <td>
                                    <form action="{{route('admin.evaluation.destroy', $evaluation)}}" method="POST">
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
                    {{$evaluations->links()}}
                </div>
            @else 
                <strong>
                    No hay evaluaciones disponibles.
                </strong>
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