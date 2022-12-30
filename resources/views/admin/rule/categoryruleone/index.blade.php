@extends('adminlte::page')

@section('title', 'Reglas nivel 1')

@section('content_header')
    <h1>Gestión de reglas ortográficas nivel uno</h1>
@stop

@section('content')
<div>
    <div class="card-header">
        <!--MENSAJE DE SESION-->
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{Session::get('message')}}
            </div>
        @endif

        <div class="card-header">
            <a href="{{route('admin.information.category.create')}}">
                <button class="btn btn-success m-3">Crear nueva regla ortográfica nivel 1</button>
            </a>
        </div>
    </div>


    <!-- CON EL IF SE CUENTA SI HAY 1 REGISTRO O MAS PARA MOSTRAR -->
    @if ($categories->count())
        <!-- MOSTRAR EL LISTADO DE REGLAS ORTOGRAFICAS NIVEL 1 (CATEGORIES) -->
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Subclasificación</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->type}}</td>
                            <td>{{$category->clasification}}</td>
                            <td>
                                <a href="{{route('admin.information.category.show', $category)}}">
                                    <button class="btn btn-primary">Ver</button>
                                </a>
                            </td>
                            <td>
                                <a href="{{route('admin.information.category.edit', $category)}}">
                                    <button class="btn btn-info">Editar</button>
                                </a>
                            </td>
                            <td>
                                <form action="{{route('admin.information.category.destroy', $category)}}" method="POST">
                                    @csrf 
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>        
    @else
        <div class="card-body">
            <strong>No hay registros.</strong>
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