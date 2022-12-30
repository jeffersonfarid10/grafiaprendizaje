@extends('adminlte::page')

@section('title', 'Crear término')

@section('content_header')
    <h1>Crear término</h1>
@stop

@section('content')
    
<div class="card">
    <div class="card-header">
        <h4>Rellene los siguientes campos:</h4>
    </div>
    <!-- MENSAJE DE SESION -->
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{Session::get('message')}}
        </div>
    @endif

    <div class="card-body">
        <form action="{{route('admin.glossary.store')}}" method="POST">
            @csrf 

            <div class="form-group">
                <label>Nombre del término:</label>
                <input type="text" name="name" id="name" placeholder="Ingrese el nombre del término" value="{{old('name')}}" class="form-control" required>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('name')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>


            <div class="form-group">
                <label>Definición:</label>
                <textarea name="meaning" id="meaning" cols="30" rows="10" class="form-control" value="{{old('meaning')}}" required></textarea>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('meaning')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>


            <div class="form-group">
                <label>Fuente:</label>
                <input type="text" name="font" id="font" placeholder="Ingrese la fuente del término (opcional)" value="{{old('font')}}" class="form-control">
            </div>


            <button type="submit" class="btn btn-primary m-3">Crear término</button>
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