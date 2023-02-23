@extends('adminlte::page')

@section('title', 'Preguntas de texto con audio')

@section('content_header')
    <h1 class="text-danger"><strong>Gestión de actividades de texto con audio</strong></h1>
@stop

@section('content')
<div class="card">
    <!--MENSAJE DE SESION-->
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{Session::get('message')}}
        </div>
    @endif

    <div class="card-header">
        <a href="{{route('admin.question.textoaudio.create')}}">
            <button class="btn btn-success m-3">Crear nueva pregunta</button>
        </a>
    </div>

    <div class="card-body">
        @isset($questions)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Enunciado</th>
                        <th>Evaluación</th>
                        <th colspan="3" class="text-center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $key=>$textoaudio)
                        <tr>
                            <td>{{$textoaudio->id}}</td>
                            <td>{{$textoaudio->title}}</td>
                            <td>{{$textoaudio->evaluation->name}}</td>
                            <td>
                                <a href="{{route('admin.question.textoaudio.show', $textoaudio)}}">
                                    <button class="btn btn-secondary">Ver Pregunta</button>
                                </a>
                            </td>
                            <td>
                                <a href="{{route('admin.question.textoaudio.edit', $textoaudio)}}">
                                    <button class="btn btn-info">Editar</button>
                                </a>
                            </td>
                            <td>
                                <form action="{{route('admin.question.textoaudio.destroy', $textoaudio)}}" method="POST">
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
                {{$questions->links()}}
            </div>
        @else 
            <strong>No hay preguntas disponibles.</strong>
        @endisset
    </div>
</div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop