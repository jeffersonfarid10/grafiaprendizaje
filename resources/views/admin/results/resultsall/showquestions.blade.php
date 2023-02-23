@extends('adminlte::page')

@section('title', 'Preguntas asignadas')

@section('content_header')
    <h1 class="text-danger text-center"><strong>Resultados de la evaluación</strong></h1>
@stop

@section('content')
    
<div class="card">
    <div class="card-header">
        <h3><strong class="text-red">Resultados del estudiante: </strong> <strong>{{$userObject->name}}</strong></h3>
        <br>
        <h3><strong class="text-red">A la evaluación: </strong><strong>{{$evaluationObject->name}}</strong></h3>

        <div class="card-header border border-5 border-warning">
            <h2 class="text-center text-danger"><strong>Resultados:</strong></h2>
            <br>
            <div>
                <h4><strong class="text-danger">Preguntas totales:</strong><strong> {{$totalQuestions}}</strong></h4>
                <h4><strong class="text-danger">Preguntas respondidas:</strong> <strong>{{$questionsAnsweredUnique}}</strong></h4>
                <h4><strong class="text-danger">Calificación: </strong><strong>{{$calificacion}}</strong></h4>
            </div>
        </div>
    </div>

    <div class="card-body">
        <!-- MOSTRAR PREGUNTAS RESPONDIDAS -->
        <table class="table table-striped">
            <h4 class="text-center"><strong class="text-red">Preguntas respondidas:</strong></h4>
            <br>
            <tbody>
                @foreach ($coleccionQuestions as $key=>$question)
                    <tr>
                        <td><strong>{{$key+1}}.</strong> {{$question->title}}</td>
                        <td>
                            <a href="/admin/results/{{$userObject->id}}/evaluacion/{{$evaluationObject->id}}/pregunta/{{$question->id}}">
                                <button class="btn btn-success">Ver respuesta</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- MOSTRAR PREGUNTAS SIN RESPONDER -->
        <!-- CON EL IF SE PREGUNTA SI EL ARRAY COLECCIONSINRESPONDER TIENE MAS DE UN ELEMENTO SI ES ASI SE MUESTRA 
        LA TABLA CASO CONTRARIO NO  -->
        @if (count($coleccionSinResponder) > 0)
            <table class="table table-striped">
                <h4 class="text-center"><strong class="text-red">Preguntas sin responder:</strong></h4>
                <br>
                <tbody>
                    @foreach ($coleccionSinResponder as $key=>$question)
                        <tr>
                            <td><strong>{{$key+1}}.</strong> {{$question->title}}</td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
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