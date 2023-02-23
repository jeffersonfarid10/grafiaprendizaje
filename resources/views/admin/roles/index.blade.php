@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1 class="text-danger"><strong>Gestión de roles de usuarios</strong></h1>
@stop

@section('content')

<div class="card">

    <!--MENSAJE DE SESION-->
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{Session::get('message')}}
        </div>
    @endif

    <div class="card-body">
        @if (count($users) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th colspan="2" class="text-center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <!-- BOTON DE EDITAR -->
                            <td>
                                <a href="{{route('admin.user.edit', $user)}}">
                                    <button class="btn btn-info">Editar rol</button>
                                </a>
                            </td>
                            <!-- BOTON DE ELIMINAR  -->
                            <td>
                                <form action="{{route('admin.user.destroy', $user)}}" method="POST">
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
                {{$users->links()}}
            </div>
        @else
            <strong>No hay usuarios disponibles</strong>
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