@extends('adminlte::page')

@section('title', 'Notas evaluación de práctica tres')

@section('content_header')
    <h1 class="text-danger"><strong>Listado de notas evaluación de práctica tres</strong></h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <h6 class="text-center"><strong class="text-red">Reporte notas estudiantes evaluación de práctica tres</strong></h6>
    </div>

    <div class="card-body">
        <!-- CON EL IF SE PREGUNTA SI EL ARRAYNOTASPRACTICAUNO TIENE ELEMENTOS, SI ES ASI SE MUESTRA LA TABLA -->
        {{--@if (count($arrayNotasPracticaTres) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Nombre evaluación</th>
                        <th>Nota</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- SE RECORRE EL ARRAYNOTASDIAGNOSTICO -->
                    @foreach ($arrayNotasPracticaTres as $usuarionotas)
                        <tr>
                            <td>{{$usuarionotas['Estudiante']}}</td>
                            <td>{{$usuarionotas['Evaluacion']}}</td>
                            <td>{{$usuarionotas['Nota']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            
        @endif--}}



        <!-- ACTUALIZACION SE LLAMA A LA VARIABLE COLECCIONNOTASPRACTICATRES QUE ES EL ARRAYNOTASPRACTICA TRES QUE CONTIENE PAGINACION -->
        @if (count($coleccionNotasPracticaTres) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Correo electrónico</th>
                        <th>Nombre evaluación</th>
                        <th>Nota</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- SE RECORRE EL ARRAYNOTASDIAGNOSTICO -->
                    @foreach ($coleccionNotasPracticaTres as $usuarionotas)
                        <tr>
                            <td>{{$usuarionotas['Estudiante']}}</td>
                            <td>{{$usuarionotas['Correo']}}</td>
                            <td>{{$usuarionotas['Evaluacion']}}</td>
                            <td>{{$usuarionotas['Nota']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
             <!-- PAGINACION CON BOOSTRAP -->
             <div class="d-flex justify-content-end">
                {{$coleccionNotasPracticaTres->links()}}
            </div> 
        @else
            <strong>No hay registros.</strong>
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