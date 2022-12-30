@extends('adminlte::page')

@section('title', 'Glosario')

@section('content_header')
    <h1>Gestión de glosario de términos</h1>
@stop

@section('content')
    
<div class="card">
    <!-- MENSAJE DE SESION -->
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{Session::get('message')}}
        </div>
    @endif

    <div class="card-header">
        <a href="{{route('admin.glossary.create')}}">
            <button class="btn btn-success m-3">Crear nuevo término</button>
        </a>
    </div>

    <div class="card-body">
        @isset($glossaries)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Término</th>
                        <th>Definición</th>
                        <th colspan="3" class="text-center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($glossaries as $key=>$glossary)
                        <tr>
                            <td>{{$glossary->id}}</td>
                            <td>{{$glossary->name}}</td>
                            <td>{{$glossary->meaning}}</td>
                            <td>
                                <a href="{{route('admin.glossary.show', $glossary)}}">
                                    <button class="btn btn-primary">Ver término</button>
                                </a>
                            </td>
                            <td>
                                <a href="{{route('admin.glossary.edit', $glossary)}}">
                                    <button class="btn btn-info">Editar</button>
                                </a>
                                <td>
                                    <form action="{{route('admin.glossary.destroy', $glossary)}}" method="POST">
                                        @csrf 
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- PAGINACION CON BOOSTRAP -->
            <div class="d-flex justify-content-end">
                {{$glossaries->links()}}
            </div> 
        @else 
            <strong>
                No hay términos disponibles.
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