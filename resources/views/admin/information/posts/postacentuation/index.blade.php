@extends('adminlte::page')

@section('title', 'Reglas de acentuación nivel tres')

@section('content_header')
    <h1 class="text-danger"><strong>Gestión de reglas ortográficas de acentuación nivel tres</strong></h1>
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
            <a href="{{route('admin.posts.postacentuation.create')}}">
                <button class="btn btn-success m-3">Crear nueva regla ortográfica de acentuación nivel tres</button>
            </a>
        </div>
    </div>

    <!-- CON EL IF SE CUENTRA SI HAY 1 REGISTRO O MAS PARA MOSTRAR -->
    @if ($posts->count())
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
                    @foreach ($posts as $postacentuation)
                        <tr>
                            <td>{{$postacentuation->id}}</td>
                            <td>{{$postacentuation->name}}</td>
                            <td>{{$postacentuation->type}}</td>
                            {{--<td>{{$postacentuation->clasification}}</td>--}}
                            <td>{{$postacentuation->section->name}}</td>
                            <td>
                                <a href="{{route('admin.posts.postacentuation.show', $postacentuation)}}">
                                    <button class="btn btn-primary">Ver regla</button>
                                </a>
                            </td>
                            <td>
                                <a href="{{route('admin.posts.postacentuation.edit', $postacentuation)}}">
                                    <button class="btn btn-primary">Editar</button>
                                </a>
                            </td>
                            <td>
                                <form action="{{route('admin.posts.postacentuation.destroy', $postacentuation)}}" method="POST">
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
                {{$posts->links()}}
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