@extends('adminlte::page')

@section('title', 'Preguntas evaluación')

@section('content_header')
    
@stop

@section('content')
<div class="card mt-3">
    <div class="card-header bg-info rounded">
        <h2><strong class="text-dark">Datos evaluación</strong></h2>
        <h3><strong class="text-dark">Nombre:</strong>  {{$evaluation->name}}</h3>
        <h3><strong class="text-dark">Descripción</strong>  {{$evaluation->description}}</h3>
        <h3><strong class="text-dark">Tipo:</strong> {{$evaluation->type}}</h3>
        <h3><strong class="text-dark">Grupo:</strong> {{$evaluation->format}}</h3>
    </div>
    <div class="bg-dark text-white font-bold rounded">
        <a href="{{route('admin.evaluation.index')}}"><button class="btn btn-info m-3">Volver al menú principal</button></a>
    </div>
    <div class="card-body">
        @foreach ($questions as $key=>$pregunta)
            @if (($pregunta->type) === "OM")
                <br>
                <div class="card m-2">
                    <div class="card-header bg-secondary">
                        <h4 class="card-title"><strong>{{$key+1}}. {{$pregunta->title}}</strong></h4>
                    </div>
                    <div class="card-body">
                        <!-- INDICACIONES -->
                        <li class="list-group-item">
                            <strong>Indicaciones:</strong>
                            <br>
                            @foreach ($pregunta->indications as $key=>$indicacion)
                                <h6 class="card-text">{{$key+1}}. {{$indicacion->indication}}</h6>
                            @endforeach
                        </li>
                        <!-- RESPUESTAS -->
                        <li class="list-group-item">
                            <strong>Respuestas:</strong>
                            <br>
                            @foreach ($pregunta->answers as $key=>$answer)
                                <h6 class="card-text">{{$key+1}}. {{$answer->answer}}
                                    @if($answer->is_correct)
                                        <span class="badge badge-success">Respuesta correcta</span>
                                    @endif
                                </h6>
                            @endforeach
                        </li>
                        <!-- JUSTIFICACIONES-->
                        <li class="list-group-item">
                            <strong>Justificaciones:</strong>
                            <br>
                            <div class="row m-3">
                                <div class="col">
                                    <h5 class="text-red font-bold">Justificaciones:</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                    <h6 class="card-text">{{$key+1}}. {{$justificacion->reason}}</h6>
                                    @endforeach
                                </div>
                                <div class="col">
                                    <h5 class="text-red font-bold">Reglas</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                        <h6 class="card-text">{{$key+1}}. {{$justificacion->rule}}</h6>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    </div>
                </div>
            @elseif(($pregunta->type) === "PC")
                <br>
                <div class="card m-2">
                    <div class="card-header bg-secondary">
                        <h4 class="card-title"><strong>{{$key+1}}. {{$pregunta->title}}</strong></h4>
                    </div>
                    <div class="card-body">
                        <!-- INDICACIONES -->
                        <li class="list-group-item">
                            <strong>Indicaciones:</strong>
                            <br>
                            @foreach ($pregunta->indications as $key=>$indicacion)
                                <h6 class="card-text">{{$key+1}}. {{$indicacion->indication}}</h6>
                            @endforeach
                        </li>
                        <!--RESPUESTAS-->
                        <li class="list-group-item">
                            <strong>Respuestas:</strong>
                            <br>
                            <div class="row m-3">
                                <div class="col">
                                    <h5 class="text-red font-bold">Palabras correctas:</h5>
                                    
                                    @foreach ($pregunta->answers as $key=>$answer)
                                        <h6 class="card-text">{{$key+1}}. {{$answer->answer}}</h6>
                                    @endforeach
                                </div>
                                <div class="col">
                                    <h5 class="text-red font-bold">Palabras visibles:</h5>
                                    
                                    @foreach ($pregunta->answers as $key=>$visible)
                                        <h6 class="card-text">{{$key+1}}. {{$visible->visible_answer}}</h6>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        <!-- JUSTIFICACIONES-->
                        <li class="list-group-item">
                            <strong>Justificaciones:</strong>
                            <br>
                            <div class="row m-3">
                                <div class="col">
                                    <h5 class="text-red font-bold">Justificaciones:</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                    <h6 class="card-text">{{$key+1}}. {{$justificacion->reason}}</h6>
                                    @endforeach
                                </div>
                                <div class="col">
                                    <h5 class="text-red font-bold">Reglas</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                        <h6 class="card-text">{{$key+1}}. {{$justificacion->rule}}</h6>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    </div>
                </div>
            @elseif(($pregunta->type) === "OMI")
                <br>
                <div class="card m-2">
                    <div class="card-header bg-secondary">
                        <h4 class="card-title"><strong>{{$key+1}}. {{$pregunta->title}}</strong></h4>
                    </div>
                    <div class="card-body">
                        <!-- INDICACIONES -->
                        <li class="list-group-item">
                            <strong>Indicaciones:</strong>
                            <br>
                            @foreach ($pregunta->indications as $key=>$indicacion)
                                <h6 class="card-text">{{$key+1}}. {{$indicacion->indication}}</h6>
                            @endforeach
                        </li>
                        <!-- IMAGEN -->
                        <li class="list-group-item">
                            <strong>Imagen</strong>
                            <br>
                            <img id="image" name="image" src="/storage/{{$pregunta->image}}" alt="" height="400px" width="700px">
                        </li>
                        <!-- RESPUESTAS -->
                        <li class="list-group-item">
                            <strong>Respuestas:</strong>
                            <br>
                            @foreach ($pregunta->answers as $key=>$answer)
                                <h6 class="card-text">{{$key+1}}. {{$answer->answer}}
                                    @if($answer->is_correct)
                                        <span class="badge badge-success">Respuesta correcta</span>
                                    @endif
                                </h6>
                            @endforeach
                        </li>
                        <!-- JUSTIFICACIONES-->
                        <li class="list-group-item">
                            <strong>Justificaciones:</strong>
                            <br>
                            <div class="row m-3">
                                <div class="col">
                                    <h5 class="text-red font-bold">Justificaciones:</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                    <h6 class="card-text">{{$key+1}}. {{$justificacion->reason}}</h6>
                                    @endforeach
                                </div>
                                <div class="col">
                                    <h5 class="text-red font-bold">Reglas</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                        <h6 class="card-text">{{$key+1}}. {{$justificacion->rule}}</h6>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    </div>
                </div>
            @elseif(($pregunta->type) === "OMA")
                <br>
                <div class="card m-2">
                    <div class="card-header bg-secondary">
                        <h4 class="card-title"><strong>{{$key+1}}. {{$pregunta->title}}</strong></h4>
                    </div>
                    <div class="card-body">
                        <!-- INDICACIONES -->
                        <li class="list-group-item">
                            <strong>Indicaciones:</strong>
                            <br>
                            @foreach ($pregunta->indications as $key=>$indicacion)
                                <h6 class="card-text">{{$key+1}}. {{$indicacion->indication}}</h6>
                            @endforeach
                        </li>
                        <!-- IMAGEN -->
                        <li class="list-group-item">
                            <strong>Imagen</strong>
                            <br>
                            <img id="image" name="image" src="/storage/{{$pregunta->image}}" alt="" height="400px" width="700px">
                        </li>
                        <!-- AUDIO -->
                        <li class="list-group-item">
                            <strong>Audio</strong>
                            <br>
                            <audio id="audio" name="audio" controls src="/storage/{{$pregunta->audio}}" type="audio">Tu navegador no soporta este elemento, utiliza otro navegador.</audio>
                        </li>
                        <!-- RESPUESTAS -->
                        <li class="list-group-item">
                            <strong>Respuestas:</strong>
                            <br>
                            @foreach ($pregunta->answers as $key=>$answer)
                                <h6 class="card-text">{{$key+1}}. {{$answer->answer}}
                                    @if($answer->is_correct)
                                        <span class="badge badge-success">Respuesta correcta</span>
                                    @endif
                                </h6>
                            @endforeach
                        </li>
                        <!-- JUSTIFICACIONES-->
                        <li class="list-group-item">
                            <strong>Justificaciones:</strong>
                            <br>
                            <div class="row m-3">
                                <div class="col">
                                    <h5 class="text-red font-bold">Justificaciones:</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                    <h6 class="card-text">{{$key+1}}. {{$justificacion->reason}}</h6>
                                    @endforeach
                                </div>
                                <div class="col">
                                    <h5 class="text-red font-bold">Reglas</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                        <h6 class="card-text">{{$key+1}}. {{$justificacion->rule}}</h6>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    </div>
                </div>
            @elseif(($pregunta->type) === "OA")
                <br>
                <div class="card m-2">
                    <div class="card-header bg-secondary">
                        <h4 class="card-title"><strong>{{$key+1}}. {{$pregunta->title}}</strong></h4>
                    </div>
                    <div class="card-body">
                        <!-- INDICACIONES -->
                        <li class="list-group-item">
                            <strong>Indicaciones:</strong>
                            <br>
                            @foreach ($pregunta->indications as $key=>$indicacion)
                                <h6 class="card-text">{{$key+1}}. {{$indicacion->indication}}</h6>
                            @endforeach
                        </li>
                        <!-- IMAGEN -->
                        <li class="list-group-item">
                            <strong>Imagen</strong>
                            <br>
                            <img id="image" name="image" src="/storage/{{$pregunta->image}}" alt="" height="400px" width="700px">
                        </li>
                        <!-- AUDIO -->
                        <li class="list-group-item">
                            <strong>Audio</strong>
                            <br>
                            <audio id="audio" name="audio" controls src="/storage/{{$pregunta->audio}}" type="audio">Tu navegador no soporta este elemento, utiliza otro navegador.</audio>
                        </li>
                        <!-- RESPUESTAS -->
                        <li class="list-group-item">
                            <strong>Oraciones correctas:</strong>
                            <br>
                            @foreach ($pregunta->answers as $key=>$answer)
                                <h6 class="card-text">{{$key+1}}. {{$answer->answer}}
                                </h6>
                            @endforeach
                        </li>
                        <!-- JUSTIFICACIONES-->
                        <li class="list-group-item">
                            <strong>Justificaciones:</strong>
                            <br>
                            <div class="row m-3">
                                <div class="col">
                                    <h5 class="text-red font-bold">Justificaciones:</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                    <h6 class="card-text">{{$key+1}}. {{$justificacion->reason}}</h6>
                                    @endforeach
                                </div>
                                <div class="col">
                                    <h5 class="text-red font-bold">Reglas</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                        <h6 class="card-text">{{$key+1}}. {{$justificacion->rule}}</h6>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    </div>
                </div>
            
            @elseif(($pregunta->type) === "OI")
                <br>
                <div class="card m-2">
                    <div class="card-header bg-secondary">
                        <h4 class="card-title"><strong>{{$key+1}}. {{$pregunta->title}}</strong></h4>
                    </div>
                    <div class="card-body">
                        <!-- INDICACIONES -->
                        <li class="list-group-item">
                            <strong>Indicaciones:</strong>
                            <br>
                            @foreach ($pregunta->indications as $key=>$indicacion)
                                <h6 class="card-text">{{$key+1}}. {{$indicacion->indication}}</h6>
                            @endforeach
                        </li>
                        <!-- IMAGEN -->
                        <li class="list-group-item">
                            <strong>Imagen</strong>
                            <br>
                            <img id="image" name="image" src="/storage/{{$pregunta->image}}" alt="" height="400px" width="700px">
                        </li>
                        <!-- RESPUESTAS -->
                        <li class="list-group-item">
                            <strong>Oraciones correctas:</strong>
                            <br>
                            @foreach ($pregunta->answers as $key=>$answer)
                                <h6 class="card-text">{{$key+1}}. {{$answer->answer}}
                                </h6>
                            @endforeach
                        </li>
                        <!-- JUSTIFICACIONES-->
                        <li class="list-group-item">
                            <strong>Justificaciones:</strong>
                            <br>
                            <div class="row m-3">
                                <div class="col">
                                    <h5 class="text-red font-bold">Justificaciones:</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                    <h6 class="card-text">{{$key+1}}. {{$justificacion->reason}}</h6>
                                    @endforeach
                                </div>
                                <div class="col">
                                    <h5 class="text-red font-bold">Reglas</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                        <h6 class="card-text">{{$key+1}}. {{$justificacion->rule}}</h6>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    </div>
                </div>
            @elseif(($pregunta->type) === "TI")

               <br>
                <div class="card m-2">
                    <div class="card-header bg-secondary">
                        <h4 class="card-title"><strong>{{$key+1}}. {{$pregunta->title}}</strong></h4>
                    </div>
                    <div class="card-body">
                        <!-- INDICACIONES -->
                        <li class="list-group-item">
                            <strong>Indicaciones:</strong>
                            <br>
                            @foreach ($pregunta->indications as $key=>$indicacion)
                                <h6 class="card-text">{{$key+1}}. {{$indicacion->indication}}</h6>
                            @endforeach
                        </li>
                        <!-- IMAGEN -->
                        <li class="list-group-item">
                            <strong>Imagen</strong>
                            <br>
                            <img id="image" name="image" src="/storage/{{$pregunta->image}}" alt="" height="400px" width="700px">
                        </li>
                        
                        <!-- PARRAFO CORRECTO -->
                        <li class="list-group-item">
                            <strong>Párrafo correcto:</strong>
                            <br>
                            <div class="bg-white">
                                @foreach ($pregunta->answers as $answer)
                                    {{$answer->answer}}
                                @endforeach
                            </div>
                        </li>
                        <!-- JUSTIFICACIONES-->
                        <li class="list-group-item">
                            <strong>Justificaciones:</strong>
                            <br>
                            <div class="row m-3">
                                <div class="col">
                                    <h5 class="text-red font-bold">Justificaciones:</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                    <h6 class="card-text">{{$key+1}}. {{$justificacion->reason}}</h6>
                                    @endforeach
                                </div>
                                <div class="col">
                                    <h5 class="text-red font-bold">Reglas</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                        <h6 class="card-text">{{$key+1}}. {{$justificacion->rule}}</h6>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    </div>
                </div>


            @elseif(($pregunta->type) === "TA")

            <br>
                <div class="card m-2">
                    <div class="card-header bg-secondary">
                        <h4 class="card-title"><strong>{{$key+1}}. {{$pregunta->title}}</strong></h4>
                    </div>
                    <div class="card-body">
                        <!-- INDICACIONES -->
                        <li class="list-group-item">
                            <strong>Indicaciones:</strong>
                            <br>
                            @foreach ($pregunta->indications as $key=>$indicacion)
                                <h6 class="card-text">{{$key+1}}. {{$indicacion->indication}}</h6>
                            @endforeach
                        </li>
                        <!-- IMAGEN -->
                        <li class="list-group-item">
                            <strong>Imagen</strong>
                            <br>
                            <img id="image" name="image" src="/storage/{{$pregunta->image}}" alt="" height="400px" width="700px">
                        </li>


                        <!-- AUDIO -->
                        <li class="list-group-item">
                            <strong>Audio</strong>
                            <br>
                            <audio id="audio" name="audio" controls src="/storage/{{$pregunta->audio}}" type="audio">Tu navegador no soporta este elemento, utiliza otro navegador.</audio>
                        </li>

                        <!-- PARRAFO CORRECTO -->
                        <li class="list-group-item">
                            <strong>Párrafo correcto:</strong>
                            <br>
                            <div class="bg-white">
                                @foreach ($pregunta->answers as $answer)
                                    {{$answer->answer}}
                                @endforeach
                            </div>
                        </li>
                        <!-- JUSTIFICACIONES-->
                        <li class="list-group-item">
                            <strong>Justificaciones:</strong>
                            <br>
                            <div class="row m-3">
                                <div class="col">
                                    <h5 class="text-red font-bold">Justificaciones:</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                    <h6 class="card-text">{{$key+1}}. {{$justificacion->reason}}</h6>
                                    @endforeach
                                </div>
                                <div class="col">
                                    <h5 class="text-red font-bold">Reglas</h5>
                                    
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                        <h6 class="card-text">{{$key+1}}. {{$justificacion->rule}}</h6>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    </div>
                </div>

            @elseif(($pregunta->type) === "JA")

                <br>
                <div class="card-m2">
                    <div class="card-header bg-secondary">
                        <h4 class="card-title"><strong>{{$key+1}}. {{$pregunta->title}}</strong></h4>
                    </div>
                    <div class="card-body">
                        <!-- INDICACIONES -->
                        <li class="list-group-item">
                            <strong>Indicaciones:</strong>
                            <br>
                            @foreach ($pregunta->indications as $key=>$indication)
                                <h6 class="card-text">{{$key+1}}. {{$indication->indication}}</h6>                                
                            @endforeach
                        </li>
                        <!-- PALABRA A BUSCAR Y ORACION GUIA-->
                        <li class="list-group-item">
                            <strong>Enunciado</strong>
                            @foreach ($pregunta->answers as $answer)
                                <h6 class="card-text">{{$answer->visible_answer}}</h6>
                            @endforeach
                            <br>
                            <strong>Palabra a encontrar</strong>
                            @foreach ($pregunta->answers as $answer)
                                <h6 class="card-text">{{$answer->answer}}</h6>
                            @endforeach
                        </li>
                        <!-- JUSTIFICACIONES -->
                        <li class="list-group-item">
                            <strong>Justificaciones:</strong>
                            <br>
                            <div class="row m-3">
                                <div class="col">
                                    <h5 class="text-red font-bold">Justificaciones:</h5>
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                        <h6 class="card-text">{{$key+1}}. {{$justificacion->reason}}</h6>
                                    @endforeach
                                </div>
                                <div class="col">
                                    <h5 class="text-red font-bold">Reglas</h5>
                                    @foreach ($pregunta->justifications as $key=>$justificacion)
                                        <h6 class="card-text">{{$key+1}}. {{$justificacion->rule}}</h6>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    </div>
                </div>

            @elseif(($pregunta->type) === "SL")

            <br>
            <div class="card m-2">
                <div class="card-header bg-secondary">
                    <h4 class="card-title"><strong>{{$key+1}}. {{$pregunta->title}}</strong></h4>
                </div>
                <div class="card-body">
                    <!-- INDICACIONES -->
                    <li class="list-group-item">
                        <strong>Indicaciones:</strong>
                        <br>
                        @foreach ($pregunta->indications as $key=>$indicacion)
                            <h6 class="card-text">{{$key+1}}. {{$indicacion->indication}}</h6>
                        @endforeach
                    </li>
                    <!-- RESPUESTAS -->
                    <li class="list-group-item">
                        <strong>Respuestas:</strong>
                        <br>
                        <div class="row mb-3">
                             <div class="col">
                                <h5 class="text-red font-bold">Palabras correctas:</h5>
                                @foreach ($pregunta->answers as $key=>$answer)
                                    <h6 class="card-text">{{$key+1}}. {{$answer->answer}}</h6>
                                @endforeach
                             </div>
                             <div class="col">
                                <h5 class="text-red font-bold">Palabras incorrectas:</h5>
                                @foreach ($pregunta->answers as $key=>$visible)
                                    <h6 class="card-text">{{$key+1}}. {{$visible->visible_answer}}</h6>
                                @endforeach
                             </div>
                             <div>
                                <h5 class="text-red font-bold">Oraciones:</h5>
                                @foreach ($pregunta->answers as $key=>$oracion)
                                    <h6 class="card-text">{{$key+1}}. {{$oracion->second_answer}}</h6>
                                @endforeach
                             </div>
                        </div>
                    </li>
                    <!-- JUSTIFICACIONES -->
                    <li class="list-group-item">
                        <strong>Justificaciones:</strong>
                        <br>
                        <div class="row m-3">
                            <div class="col">
                                <h5 class="text-red font-bold">Justificaciones:</h5>
                                @foreach ($pregunta->justifications as $key=>$justificacion)
                                    <h6 class="card-text">{{$key+1}}. {{$justificacion->reason}}</h6>
                                @endforeach
                            </div>
                            <div class="col">
                                <h5 class="text-red font-bold">Reglas</h5>
                                @foreach ($pregunta->justifications as $key=>$justificacion)
                                    <h6 class="card-text">{{$key+1}}. {{$justificacion->rule}}</h6>
                                @endforeach
                            </div>
                        </div>
                    </li>
                </div>
            </div>

            @endif
    
        @endforeach
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop