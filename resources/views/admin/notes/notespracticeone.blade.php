@extends('adminlte::page')

@section('title', 'Notas evaluación de práctica uno')

@section('content_header')
    <h1 class="text-danger"><strong>Listado de notas evaluación de práctica uno</strong></h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <h6 class="text-center"><strong class="text-red">Reporte notas estudiantes evaluación de práctica uno</strong></h6>
    </div>

    <div class="card-body">
        <!-- CON EL IF SE PREGUNTA SI EL ARRAYNOTASPRACTICAUNO TIENE ELEMENTOS, SI ES ASI SE MUESTRA LA TABLA -->
        {{--@if (count($arrayNotasPracticaUno) > 0)
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
                    @foreach ($arrayNotasPracticaUno as $usuarionotas)
                        <tr>
                            <td>{{$usuarionotas['Estudiante']}}</td>
                            <td>{{$usuarionotas['Evaluacion']}}</td>
                            <td>{{$usuarionotas['Nota']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <strong>No hay registros.</strong>
        @endif--}}


        <!-- ACTUALIZACION SE LLAMA A LA VARIABLA COLECCIONNOTASPRACTICAUNO QUE ES EL ARRAYNOTASPRACTICAUNO QUE TIENE PAGINACION -->
        @if (count($coleccionNotasPracticaUno) > 0)
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
                @foreach ($coleccionNotasPracticaUno as $usuarionotas)
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
            {{$coleccionNotasPracticaUno->links()}}
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