@extends('adminlte::page')

@section('title', 'Reporte notas general')

@section('content_header')
    <h1>Reporte de notas usuarios registrados</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <strong class="text-red">Reporte notas usuarios</strong>
    </div>

    <div class="card-body">
        <!-- CON EL IF SE PREGUNTA SI EL ARRAYNOTASPRACTICAUNO TIENE ELEMENTOS, SI ES ASI SE MUESTRA LA TABLA -->
        {{--@if (count($arrayNotas) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Evaluacion Diagnóstico</th>
                        <th>Nota Diagnóstico</th>
                        <th>Práctica Uno</th>
                        <th>Nota Práctica Uno</th>
                        <th>Práctica Dos</th>
                        <th>Nota Práctica Dos</th>
                        <th>Práctica Tres</th>
                        <th>Nota Práctica Tres</th>
                        <th>Evaluación Final</th>
                        <th>Nota Evaluación Final</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- SE RECORRE EL ARRAYNOTASDIAGNOSTICO -->
                    @foreach ($arrayNotas as $key=>$usuarionotas)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$usuarionotas['Estudiante']}}</td>
                            <td>{{$usuarionotas['Diagnostico']}}</td>
                            <td>{{$usuarionotas['NotaDiagnostico']}}</td>
                            <td>{{$usuarionotas['Uno']}}</td>
                            <td>{{$usuarionotas['NotaUno']}}</td>
                            <td>{{$usuarionotas['Dos']}}</td>
                            <td>{{$usuarionotas['NotaDos']}}</td>
                            <td>{{$usuarionotas['Tres']}}</td>
                            <td>{{$usuarionotas['NotaTres']}}</td>
                            <td>{{$usuarionotas['Final']}}</td>
                            <td>{{$usuarionotas['NotaFinal']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            
        @endif--}}


        <!-- ACTUALIZACION SE LLAMA A LA VARIABLE COLECCIONOTAS QUE ES EL ARRAYNOTAS QUE CONTIENE PAGINACION -->
        @if (count($coleccionNotas) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Usuario</th>
                    <th>Evaluacion Diagnóstico</th>
                    <th>Nota Diagnóstico</th>
                    <th>Práctica Uno</th>
                    <th>Nota Práctica Uno</th>
                    <th>Práctica Dos</th>
                    <th>Nota Práctica Dos</th>
                    <th>Práctica Tres</th>
                    <th>Nota Práctica Tres</th>
                    <th>Evaluación Final</th>
                    <th>Nota Evaluación Final</th>
                </tr>
            </thead>
            <tbody>
                <!-- SE RECORRE EL ARRAYNOTASDIAGNOSTICO -->
                @foreach ($coleccionNotas as $key=>$usuarionotas)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$usuarionotas['Estudiante']}}</td>
                        <td>{{$usuarionotas['Diagnostico']}}</td>
                        <td>{{$usuarionotas['NotaDiagnostico']}}</td>
                        <td>{{$usuarionotas['Uno']}}</td>
                        <td>{{$usuarionotas['NotaUno']}}</td>
                        <td>{{$usuarionotas['Dos']}}</td>
                        <td>{{$usuarionotas['NotaDos']}}</td>
                        <td>{{$usuarionotas['Tres']}}</td>
                        <td>{{$usuarionotas['NotaTres']}}</td>
                        <td>{{$usuarionotas['Final']}}</td>
                        <td>{{$usuarionotas['NotaFinal']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- PAGINACION CON BOOSTRAP -->
        <div class="d-flex justify-content-end">
            {{$coleccionNotas->links()}}
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