@extends('adminlte::page')

@section('title', 'Editar usuario')

@section('content_header')
    <h1 class="text-danger"><strong>Editar rol</strong></h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <p class="h6 text-danger"><strong>Nombre:</strong></p>
        <br>
        <p class="h5"><strong>{{$user->name}}</strong></p>
    </div>

    <div class="card-body">
        <!-- LISTADO DE ROLES -->
        <form action="{{route('admin.user.update', $user)}}" method="POST">
            @csrf 
            {{method_field('PUT')}}

            

            <div class="form-group">
                <label class="text-danger"><strong>Roles disponibles:</strong></label>
                <br>
                
                @foreach ($roles as $rol)
                    <div>
                        <label>
                            <input type="checkbox" name="rolesseleccionados[]" value="{{$rol->id}}" class="mr-1" @if(in_array($rol->id, $selectedRoles)) checked @endif>
                            {{$rol->name}}
                        </label>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Asignar rol</button>
        </form>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop