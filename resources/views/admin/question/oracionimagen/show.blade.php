@extends('adminlte::page')

@section('title', 'Ver pregunta')

@section('content_header')
    <h1 class="text-danger"><strong>Datos de la pregunta</strong></h1>
@stop

@section('content')
<div class="bg-dark text-white font-bold rounded">
    <a href="{{route('admin.question.oracionimagen.index')}}"><button class="btn btn-info m-3">Volver al menú principal</button></a>
</div>
<br>
<div class="card">
    <div class="card-header">
        <strong class="text-danger">Título: </strong>
        <br><h1 class="card-title">{{$oracionimagen->title}}</h1>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <strong class="text-danger">Evaluación a la que pertenece:</strong>
                <br>
                <h1 class="card-title">{{$oracionimagen->evaluation->name}}</h1>
            </li>
            <li class="list-group-item">
                <strong class="text-danger">Grupo al que pertenece:</strong>
                <br>
                <h1 class="card-title">{{$oracionimagen->evaluation->format}}</h1>
            </li>
            <li class="list-group-item">
                <strong class="text-danger">Indicaciones:</strong>
                <br>
                @foreach ($oracionimagen->indications as $key=>$indicacion)
                    <h6 class="card-text">{{$key+1}}. {{$indicacion->indication}}</h6>
                @endforeach
            </li>

            <!-- ACTUALIZACION, SI LA PREGUNTA TIENE EL CAMPO RULE QUE SE MUESTRE EL CONTENIDO -->
            @if ($oracionimagen->rule)
                <li class="list-group-item">
                    <strong class="text-danger">Información de reglas ortográficas:</strong>
                    <br>
                    <p class="card-text">{!!$oracionimagen->rule!!}</p>
                </li>
            @endif

            <li class="list-group-item">
                <strong class="text-danger">Imagen</strong>
                <br>
                <img id="image" name="image" src="/storage/{{$oracionimagen->image}}" alt="" height="400px" width="700px">
            </li>
            
            <li class="list-group-item">
                <strong class="text-danger">Respuestas:</strong>
                <br>
                @foreach ($oracionimagen->answers as $key=>$answer)
                    <h6 class="card-text">
                        {{$key+1}}. {{$answer->answer}}
                    </h6>
                @endforeach
            </li>
            <li class="list-group-item">
                <strong class="text-danger">Justificaciones:</strong>
                <br>
                <div class="row m-3">
                    <div class="col">
                        {{--<h5 class="text-red font-bold">Justificaciones:</h5>--}}
                        <strong class="text-danger">Justificaciones</strong>
                        @foreach ($oracionimagen->justifications as $key=>$justificacion)
                        <h6 class="card-text">{{$key+1}}. {{$justificacion->reason}}</h6>
                        @endforeach
                    </div>
                    {{--<div class="col">--}}
                        {{--<h5 class="text-red font-bold">Reglas</h5>--}}
                    {{--    <strong class="text-danger">Reglas</strong>
                        
                        @foreach ($oracionimagen->justifications as $key=>$justificacion)
                            <h6 class="card-text">{{$key+1}}. {{$justificacion->rule}}</h6>
                        @endforeach
                    </div>--}}
                </div>
            </li>
        </ul>
    </div>


    <!-- REGLAS ORTOGRAFICAS ASOCIADAS -->
    <div class="card-footer">
        <h5 class="text-center"><strong>Reglas ortográficas asociadas:</strong></h5>
        
        <!-- REGLAS DE PALABRAS -->
        <div class="row">
            <!-- CON EL IF SE PREGUNTA SI LA PREGUNTA TIENE REGLAS DE NIVEL 1 YA SEA DE PALABRAS, ACENTUACION O PUNTUACION, SI ES ASI SE MUESTRAN -->
            @if (count($oracionimagen->categories) > 0)
                <div class="col">
                    <br>
                    <strong class="text-red">Reglas de nivel uno:</strong>
                    <br>
                    @foreach ($oracionimagen->categories as $categoryrule)
                        <br>
                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES PALABRAS, ACENTUACION O PUNTUACION
                        SEGUN EL TYPE QUE SEA SE LE ENVIA A UNA RUTA DE NIVEL 1 DIFERENTE BASANDONOS EN LAS RUTAS DE WEB.PHP PARA MOSTRAR REGLAS ORTOGRAFICAS ESPECIFICAS -->
                        @if ($categoryrule->type === "Reglas ortográficas de palabras")
                            <a href="/estudiante/letters/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$categoryrule->name}}
                            </a>
                        @elseif($categoryrule->type === "Reglas ortográficas de acentuación")
                            <a href="/estudiante/acentuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$categoryrule->name}}
                            </a>
                        @elseif($categoryrule->type === "Reglas ortográficas de puntuación")
                            <a href="/estudiante/punctuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$categoryrule->name}}
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif

            <!-- CON EL IF SE PREGUNTA SI LA PREGUNTA TIENE REGLAS DE NIVEL 2 YA SEA DE PALABRAS, ACENTUACION O PUNTUACION, SI ES ASI SE MUESTRAN -->
            @if (count($oracionimagen->sections) > 0)
                <div class="col">
                    <br>
                    <strong class="text-red">Reglas de nivel dos:</strong>
                    <br>
                    @foreach ($oracionimagen->sections as $sectionrule)
                        <br>
                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES PALABRAS, ACENTUACION O PUNTUACION
                        SEGUN EL TYPE QUE SEA SE LE ENVIA A UNA RUTA DE NIVEL 2 DIFERENTE BASANDONOS EN LAS RUTAS DE WEB.PHP PARA MOSTRAR REGLAS ORTOGRAFICAS ESPECIFICAS -->
                        @if ($sectionrule->type === "Reglas ortográficas de palabras")
                            <a href="/estudiante/letters/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$sectionrule->name}}
                                
                            </a>
                        @elseif($sectionrule->type === "Reglas ortográficas de acentuación")
                            <a href="/estudiante/acentuation/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$sectionrule->name}}
                                
                            </a>
                        @elseif($sectionrule->type === "Reglas ortográficas de puntuación")
                            <a href="/estudiante/punctuation/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$sectionrule->name}}
                                
                            </a>
                        @endif
                        
                    @endforeach
                </div>
            @endif

            <!-- CON EL IF SE PREGUNTA SI LA PREGUNTA TIENE REGLAS DE NIVEL 3 YA SEA DE PALABRAS ACENTUACION O PUNTUACION, SI ES ASI SE MUESTRAN -->
            @if (count($oracionimagen->posts) > 0)
                <div class="col">
                    <br>
                    <strong class="text-red">Reglas de nivel tres:</strong>
                    <br>
                    @foreach ($oracionimagen->posts as $postrule)
                        <br>
                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES PALABRAS, ACENTUACION O PUNTUACION
                        SEGUN EL TYPE QUE SEA SE LE ENVIA A UNA RUTA DE NIVEL 3 DIFERENTE BASANDONOS EN LAS RUTAS DE WEB.PHP PARA MOSTRAR REGLAS ORTOGRAFICAS ESPECIFICAS -->
                        @if ($postrule->type === "Reglas ortográficas de palabras")
                            
                            @php
                                //CATEGORY_ID PARA BUSCAR LA CATEGORIA NIVEL 1 QUE CONTIENE A LA REGLA DE NIVEL 3
                                $category_idpalabras = $postrule->section->category_id;
                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 3 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                $categorypalabras= DB::table('categories')->find($category_idpalabras);
                            @endphp
                            
                            <!-- CON EL OBJETO CATEGORY MEDIANTE SU CAMPO SLUG, SE REFERENCIA A LA CATEGORIA NIVEL 1 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                            <a href="/estudiante/letters/{{$categorypalabras->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$postrule->name}}
                            </a> 

                        @elseif($postrule->type === "Reglas ortográficas de acentuación")

                            @php 
                                //CATEGORY_IDACENTUACION PARA BUSCAR LA CATEGORIA DE NIVEL 1 QUE CONTIENE A LA REGLA DE NIVEL 3
                                $category_idacentuacion = $postrule->section->category_id;
                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 3 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                $categoryacentuacion = DB::table('categories')->find($category_idacentuacion);
                            @endphp

                            <!-- CON EL OBJETO CATEGORY MEDIANTE SU CAMPO SLUG, SE REFERENCIA A LA CATEGORIA NIVEL 1 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                            <a href="/estudiante/acentuation/{{$categoryacentuacion->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$postrule->name}}
                            </a>

                        
                        @elseif($postrule->type === "Reglas ortográficas de puntuación")

                            @php 
                                //CATEGORY_IDPUNTUACION PARA BUSCAR LA CATEGORIA DE NIVEL 1 QUE CONTIENE A LA REGLA DE NIVEL 3
                                $category_idpuntuacion = $postrule->section->category_id;
                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 3 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                $categorypuntuacion = DB::table('categories')->find($category_idpuntuacion);

                            @endphp
                            <a href="/estudiante/punctuation/{{$categorypuntuacion->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$postrule->name}}
                                
                            </a>
                        @endif
                        
                    @endforeach
                </div>
            @endif



            <!-- CON EL IF SE PREGUNTA SI LA PREGUNTA TIENE REGLAS DE NIVEL 4 YA SEA DE PALABRAS ACENTUACION O PUNTUACION, SI ES ASI SE MUESTRAN -->
            @if (count($oracionimagen->rules) > 0)
                <div class="col">
                    <br>
                    <strong class="text-red">Reglas de nivel cuatro:</strong>
                    <br>
                    @foreach ($oracionimagen->rules as $rulerule)
                        <br>
                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES PALABRAS, ACENTUACION O PUNTUACION
                        SEGUN EL TYPE QUE SEA SE LE ENVIA A UNA RUTA DE NIVEL 3 DIFERENTE BASANDONOS EN LAS RUTAS DE WEB.PHP PARA MOSTRAR REGLAS ORTOGRAFICAS ESPECIFICAS -->
                        @if ($rulerule->type === "Reglas ortográficas de palabras")
                            
                            @php
                                //MEDIANTE EL CAMPO SECTION_ID DE LA RELACION POST, SE BUSCA EL REGISTRO DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 4
                                $sectionrule_idpalabras = $rulerule->post->section_id;
                                //BUSCAR EN LA TABLA SECTIONS LA REGLA DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 4 MEDIANTE EL CAMPO SECTION_ID DE POST
                                $sectionrulepalabras = DB::table('sections')->find($sectionrule_idpalabras);

                                //MEDIANTE EL CAMPO CATEGORY_ID DE LA VARIABLE SECTIONRULEPALABRAS SE BUSCA EL REGISTRO DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 4
                                $categoryrule_idpalabras = $sectionrulepalabras->category_id;
                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 4 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                $categoryrulepalabras = DB::table('categories')->find($categoryrule_idpalabras);

                            @endphp
                            
                            <!-- CON EL OBJETO CATEGORY MEDIANTE SU CAMPO SLUG, SE REFERENCIA A LA CATEGORIA NIVEL 1 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                            <a href="/estudiante/letters/{{$categoryrulepalabras->slug}}/{{$sectionrulepalabras->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$rulerule->name}}
                            </a>

                        @elseif($rulerule->type === "Reglas ortográficas de acentuación")

                            @php 

                                //MEDIANTE EL CAMPO SECTION_ID DE LA RELACION POST, SE BUSCA EL REGISTRO NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 4
                                $sectionrule_idacentuacion = $rulerule->post->section_id;
                                //BUSCAR EN LA TABLA SECTIONS LA REGLA DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 4 MEDIANTE EL CAMPO SECTION_ID DE POST
                                $sectionruleacentuacion = DB::table('sections')->find($sectionrule_idacentuacion);


                                //MEDIANTE EL CAMPO CATEGORY_ID DE LA VARIABLE SECTIONRULEACENTUACION SE BUSCA EL REGISTRO NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 4
                                $categoryrule_idacentuacion = $sectionruleacentuacion->category_id;
                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 4 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                $categoryruleacentuacion = DB::table('categories')->find($categoryrule_idacentuacion);
                            @endphp

                            <!-- CON EL OBJETO CATEGORY MEDIANTE SU CAMPO SLUG, SE REFERENCIA A LA CATEGORIA NIVEL 1 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                            <!-- CON EL OBJETO SECTION MEDIANTE SU CAMPO SLUG SE REFERENCIA A LA SECTION NIVEL 2 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                            <a href="/estudiante/acentuation/{{$categoryruleacentuacion->slug}}/{{$sectionruleacentuacion->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$rulerule->name}}
                            </a>
                            
                        
                        @elseif($rulerule->type === "Reglas ortográficas de puntuación")

                            @php 
                                
                                //MEDIANTE EL CAMPO SECTION_ID DE LA RELACION POST, SE BUSCA EL REGISTRO NIVEL 2 QUE CONTIENE A ESTA REGLA NIVEL 4
                                $sectionrule_idpuntuacion = $rulerule->post->section_id;
                                //BUSCAR EN LA TABLA SECTIONS LA REGLA DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 4 MEDIANTE EL CAMPO SECTION_ID DE POST
                                $sectionrulepuntuacion = DB::table('sections')->find($sectionrule_idpuntuacion);

                                //MEDIANTE EL CAMPO CATEGORY_ID DE LA VARIABLE SECTIONRULEPUNTUACION SE BUSCA EL REGISTRO DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 4
                                $categoryrule_idpuntuacion = $sectionrulepuntuacion->category_id;
                                $categoryrulepuntuacion = DB::table('categories')->find($categoryrule_idpuntuacion);

                            @endphp
                            <a href="/estudiante/punctuation/{{$categoryrulepuntuacion->slug}}/{{$sectionrulepuntuacion->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$rulerule->name}}
                            </a>
                        @endif
                        
                    @endforeach
                </div>
            @endif


            <!-- CON EL IF SE PREGUNTA SI LA PREGUNTA TIENE REGLAS DE NIVEL 5 YA SEA DE PALABRAS ACENTUACION O PUNTUACION, SI ES ASI SE MUESTRAN -->
            @if (count($oracionimagen->notes) > 0)
                <div class="col">
                    <br>
                    <strong class="text-red">Reglas de nivel cinco:</strong>
                    <br>
                    @foreach ($oracionimagen->notes as $noterule)
                        <br>
                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES PALABRAS, ACENTUACION O PUNTUACION
                        SEGUN EL TYPE QUE SEA SE LE ENVIA A UNA RUTA DE NIVEL 3 DIFERENTE BASANDONOS EN LAS RUTAS DE WEB.PHP PARA MOSTRAR REGLAS ORTOGRAFICAS ESPECIFICAS -->
                        @if ($noterule->type === "Reglas ortográficas de palabras")
                            
                            @php
                                //MEDIANTE EL CAMPO POST_ID DE LA RELACION RULE, SE BUSCA EL REGISTRO NIVEL 3 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                $postrule_idpalabras = $noterule->rule->post_id;
                                //BUSCAR EN LA TABLA SECTIONS LA REGLA DE NIVEL 3 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO POST_ID DE RULE
                                $postrulepalabras = DB::table('posts')->find($postrule_idpalabras);

                                //MEDIANTE EL CAMPO SECTION_ID DE LA VARIABLE POSTRULEPALABRAS SE BUSCA EL REGISTRO NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                $sectionrule_idpalabras = $postrulepalabras->section_id;
                                //BUSCAR EN LA TABLA SECTION LA REGLA DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO SECTION_ID DE POST
                                $sectionrulepalabras = DB::table('sections')->find($sectionrule_idpalabras);

                                //MEDIANTE EL CAMPO CATEGORY_ID DE LA VARIABLE SECTIONRULEPALABRAS SE BUSCA EL REGISTRO NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                $categoryrule_idpalabras = $sectionrulepalabras->category_id;
                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                $categoryrulepalabras = DB::table('categories')->find($categoryrule_idpalabras);

                            @endphp
                            
                            <!-- CON EL OBJETO CATEGORY MEDIANTE SU CAMPO SLUG, SE REFERENCIA A LA CATEGORIA NIVEL 1 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                            <a href="/estudiante/letters/{{$categoryrulepalabras->slug}}/{{$sectionrulepalabras->slug}}/{{$postrulepalabras->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$noterule->name}}
                            </a>

                        @elseif($noterule->type === "Reglas ortográficas de acentuación")

                            @php 

                                //MEDIANTE EL CAMPO POST_ID DE LA RELACION RULE, SE BUSCA EL REGISTRO NIVEL 3 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                $postrule_idacentuacion = $noterule->rule->post_id;
                                //BUSCAR EN LA TABLA SECTIONS LA REGLA DE NIVEL 3 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO POST_ID DE RULE
                                $postruleacentuacion = DB::table('posts')->find($postrule_idacentuacion);

                                //MEDIANTE EL CAMPO SECTION_ID DE LA VARIABLE POSTRULEACENTUACION SE BUSCA EL REGISTRO NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                $sectionrule_idacentuacion = $postruleacentuacion->section_id;
                                //BUSCAR EN LA TABLA SECTION LA REGLA DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO SECTION_ID DE POST
                                $sectionruleacentuacion = DB::table('sections')->find($sectionrule_idacentuacion);

                                //MEDIANTE EL CAMPO CATEGORY_ID DE LA VARIABLE SECTIONRULEACENTUACION SE BUSCA EL REGISTRO NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                $categoryrule_idacentuacion = $sectionruleacentuacion->category_id;
                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                $categoryruleacentuacion = DB::table('categories')->find($categoryrule_idacentuacion);
                            @endphp

                            <!-- CON EL OBJETO CATEGORY MEDIANTE SU CAMPO SLUG, SE REFERENCIA A LA CATEGORIA NIVEL 1 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                            <!-- CON EL OBJETO SECTION MEDIANTE SU CAMPO SLUG SE REFERENCIA A LA SECTION NIVEL 2 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                            <a href="/estudiante/acentuation/{{$categoryruleacentuacion->slug}}/{{$sectionruleacentuacion->slug}}/{{$postruleacentuacion->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$noterule->name}}
                            </a>
                            
                        
                        @elseif($noterule->type === "Reglas ortográficas de puntuación")

                            @php 
                                
                                //MEDIANTE EL CAMPO POST_ID DE LA RELACION RULE, SE BUSCA EL REGISTRO NIVEL 3 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                $postrule_idpuntuacion = $noterule->rule->post_id;
                                //BUSCAR EN LA TABLA SECTIONS LA REGLA DE NIVEL 3 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO POST_ID DE RULE
                                $postrulepuntuacion = DB::table('posts')->find($postrule_idpuntuacion);

                                //MEDIANTE EL CAMPO SECTION_ID DE LA VARIABLE POSTRULEPUNTUACION SE BUSCA EL REGISTRO NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                $sectionrule_idpuntuacion = $postrulepuntuacion->section_id;
                                //BUSCAR EN LA TABLA SECTION LA REGLA DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO SECTION_ID DE POST
                                $sectionrulepuntuacion = DB::table('sections')->find($sectionrule_idpuntuacion);

                                //MEDIANTE EL CAMPO CATEGORY_ID DE LA VARIABLE SECTIONRULEPUNTUACION SE BUSCA EL REGISTRO NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                $categoryrule_idpuntuacion = $sectionrulepuntuacion->category_id;
                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                $categoryrulepuntuacion = DB::table('categories')->find($categoryrule_idpuntuacion);

                            @endphp
                            <a href="/estudiante/punctuation/{{$categoryrulepuntuacion->slug}}/{{$sectionrulepuntuacion->slug}}/{{$postrulepuntuacion->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer">
                                {{$noterule->name}}
                                <br>
                            </a>
                        @endif
                        
                    @endforeach
                </div>
            @endif
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