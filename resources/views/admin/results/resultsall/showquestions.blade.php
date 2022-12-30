@extends('adminlte::page')

@section('title', 'Preguntas asignadas')

@section('content_header')
    <h1>Resultados de la evaluación</h1>
@stop

@section('content')
    
<div class="card">
    <div class="card-header">
        <strong class="text-red">Resultados del estudiante: </strong> <strong>{{$userObject->name}}</strong>
        <br>
        <strong class="text-red">A la evaluación: </strong><strong>{{$evaluationObject->name}}</strong>

        <div class="card-header">
            <h2>Resultados:</h2>
            <br>
            <div>
                <h4>Preguntas totales: {{$totalQuestions}}</h4>
                <h4>Preguntas respondidas: {{$questionsAnsweredUnique}}</h4>
                <h4>Calificación: <strong>{{$calificacion}}</strong></h4>
            </div>
        </div>
    </div>

    <div class="card-body">
        <!-- MOSTRAR PREGUNTAS RESPONDIDAS -->
        <table class="table table-striped">
            <strong class="text-red">Preguntas respondidas:</strong>
            <br>
            <tbody>
                @foreach ($coleccionQuestions as $question)
                    <tr>
                        <td>{{$question->title}}</td>
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
            <table class="table-table-stripeed">
                <strong class="text-red">Preguntas sin responder:</strong>
                @foreach ($coleccionSinResponder as $question)
                    <tr>
                        <td>{{$question->title}}</td>
                    </tr>
                @endforeach
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