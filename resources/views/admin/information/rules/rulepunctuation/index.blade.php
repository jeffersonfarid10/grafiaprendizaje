@extends('adminlte::page')

@section('title', 'Reglas de puntuación nivel cuatro')

@section('content_header')
    <h1>Gestión de reglas ortográficas de puntuación nivel cuatro</h1>
@stop

@section('content')

<div class="card"> 
    <div class="card-header">
        <!--MENSAJE DE SESION-->
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{Session::get('message')}}
            </div>
        @endif
    

        <div class="card-header">
            <a href="{{route('admin.rules.rulepunctuation.create')}}">
                <button class="btn btn-success m-3">Crear nueva regla ortográfica de puntuación nivel cuatro</button>
            </a>
        </div>
    </div>

    <!-- CON EL IF SE CUENTRA SI HAY 1 REGISTRO O MAS PARA MOSTRAR -->
    @if ($rules->count())
        <!-- MOSTRAR EL LISTADO DE REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 1 (CATEGORIES) -->
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Subclasificación</th>
                        <th colspan="3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rules as $rulepunctuation)
                        <tr>
                            <td>{{$rulepunctuation->id}}</td>
                            <td>{{$rulepunctuation->name}}</td>
                            <td>{{$rulepunctuation->type}}</td>
                            <td>{{$rulepunctuation->clasification}}</td>
                            <td>
                                <a href="{{route('admin.rules.rulepunctuation.show', $rulepunctuation)}}">
                                    <button class="btn btn-primary">Ver regla</button>
                                </a>
                            </td>
                            <td>
                                <a href="{{route('admin.rules.rulepunctuation.edit', $rulepunctuation)}}">
                                    <button class="btn btn-primary">Editar</button>
                                </a>
                            </td>
                            <td>
                                <form action="{{route('admin.rules.rulepunctuation.destroy', $rulepunctuation)}}" method="POST">
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
                {{$rules->links()}}
            </div> 
        </div>
    @else
        <div class="card-body">
            <strong class="text-red">No hay registros.</strong>
        </div>
    @endif
</div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop