@extends('adminlte::page')

@section('title', 'Evaluaciones asignadas')

@section('content_header')
    <h1>Evaluaciones asignadas</h1>
@stop

@section('content')
    
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <strong class="text-red">Evaluaciones asignadas al usuario {{$user->name}}</strong> 
        </div>
    </div>
    <div class="card-body">
        <!-- MEDIANTE LA VARIABLE ISEVALUATIONASSIGNED SE REVISA SI ES TRUE, ES DECIR SI TIENE EXAMENES ASIGNADOS EL USUARIO ACTUAL
        PARA MOSTRAR LA TABLA CON LOS EXAMENES ASIGNADOS, PERO SI ES FALSE SE MUESTRA UN MENSAJE -->
        @if ($isEvaluationAssigned === true)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Evaluacion</th>
                        <th>Grupo</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- SE RECORREN LAS EVALUACIONES ASIGNADAS AL USUARIO ACTUAL -->
                    @foreach ($evaluations as $evaluation)
                        <tr>
                            <td>{{$evaluation->id}}</td>
                            <td>{{$evaluation->name}}</td>
                            <td>{{$evaluation->format}}</td>
                            <td>
                                <a href="/admin/results/{{$user->id}}/{{$evaluation->id}}">
                                    <button class="btn btn-info">Ver resultados</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <strong>El usuario {{$user->name}} no tiene evaluaciones asignadas.</strong>
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