@extends('adminlte::page')

@section('title', 'Notas evaluación diagnóstico')

@section('content_header')
    <h1>Listado de notas evaluación diagnóstico</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <strong class="text-red">Reporte notas estudiantes evaluación diagnóstico</strong>
    </div>

    <div class="card-body">
        <!-- CON EL IF SE PREGUNTA SI EL ARRAYNOTASDIAGNOSTICO TIENE ELEMENTOS, SI ES ASI SE MUESTRA LA TABLA -->
        {{--@if (count($arrayNotasDiagnostico) > 0)
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
                    @foreach ($arrayNotasDiagnostico as $usuarionotas)
                        <tr>
                            <td>{{$usuarionotas['Estudiante']}}</td>
                            <td>{{$usuarionotas['Evaluacion']}}</td>
                            <td>{{$usuarionotas['Nota']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        @else
            <strong>No hay registros</strong>
        @endif--}}

        

        <!-- ACTULIZACION SE LLAMA A LA VARIABLE COLECCIONNOTASDIAGNOSTICO QUE ES EL ARRAYNOTASDIAGNOSTICO QUE POSEE PAGINACION -->
        @if (count($coleccionNotasDiagnostico) > 0)
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
                    @foreach ($coleccionNotasDiagnostico as $usuarionotas)
                        <tr>
                            <td>{{$usuarionotas['Estudiante']}}</td>
                            <td>{{$usuarionotas['Evaluacion']}}</td>
                            <td>{{$usuarionotas['Nota']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- PAGINACION CON BOOSTRAP -->
            <div class="d-flex justify-content-end">
                {{$coleccionNotasDiagnostico->links()}}
            </div> 
        @else
            <strong>No hay registros</strong>
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