@extends('adminlte::page')

@section('title', 'Reglas puntuación nivel uno')

@section('content_header')
    <h1 class="text-danger"><strong>Gestión de reglas ortográficas de puntuación nivel uno</strong></h1>
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
            <a href="{{route('admin.categories.categorypunctuation.create')}}">
                <button class="btn btn-success m-3">Crear nueva regla ortográfica de puntuación nivel uno</button>
            </a>
        </div>
    </div>

    <!-- CON EL IF SE CUENTRA SI HAY 1 REGISTRO O MAS PARA MOSTRAR -->
    @if ($categories->count())
        <!-- MOSTRAR EL LISTADO DE REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 1 (CATEGORIES) -->
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        {{--<th>Subclasificación</th>--}}
                        <th colspan="3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $categorypunctuation)
                        <tr>
                            <td>{{$categorypunctuation->id}}</td>
                            <td>{{$categorypunctuation->name}}</td>
                            <td>{{$categorypunctuation->type}}</td>
                            {{--<td>{{$categorypunctuation->clasification}}</td>--}}
                            <td>
                                <a href="{{route('admin.categories.categorypunctuation.show', $categorypunctuation)}}">
                                    <button class="btn btn-primary">Ver regla</button>
                                </a>
                            </td>
                            <td>
                                <a href="{{route('admin.categories.categorypunctuation.edit', $categorypunctuation)}}">
                                    <button class="btn btn-primary">Editar</button>
                                </a>
                            </td>
                            <td>
                                <form action="{{route('admin.categories.categorypunctuation.destroy', $categorypunctuation)}}" method="POST">
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
                {{$categories->links()}}
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