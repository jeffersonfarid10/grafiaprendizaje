@extends('adminlte::page')

@section('title', 'Resultado pregunta')

@section('content_header')
    <h1>Resultado pregunta</h1>
@stop

@section('content')
    

<!-- ///////////////////////////////////////////////NUEVA VISTA ADMIN RESULTADOS TA////////////////////////////////////// -->

    <!-- BOTON REGRESAR -->
    <div>
        <a href="/admin/results/{{$userId}}/{{$evaluationId}}">
            <button class="btn btn-info">Regresar</button>
        </a>
    </div> 


<div class="container-fluid card p-5">


    <div class="card-header">
        <!-- TITULO -->
        <h2 class="m-2 text-center"><strong class="text-red">{{$questionType->title}}</strong></h2>
        <!-- INDICACIONES DE LA PREGUNTA -->
        <div class="m-2">
            <strong class="text-red">Indicaciones de la pregunta:</strong>
            @foreach ($questionType->indications as $indication)
                <li class="ml-4">{{$indication->indication}}</li>
            @endforeach
        </div>
    </div>


    <!-- DIV QUE CONTIENE LA IMAGEN DE LA PREGUNTA -->
    <div class="container-fluid w-75 mx-auto py-5">
        <h4 class="text-red pt-2"><strong>Imagen mostrada:</strong></h4>
        <img class="img-fluid" id="image" name="image" src="/storage/{{$questionType->image}}" alt="" >
    </div>

    <!-- DIV QUE CONTIENE EL AUDIO DE LA PREGUNTA -->
    <div class="container-fluid w-75 mx-auto py-5">
        <h4 class="text-red pt-2"><strong>Audio:</strong></h4>
        <audio id="audio" name="audio" controls src="/storage/{{$questionType->audio}}" type="audio'">Tu navegador no soporta este elemento tipo audio. Utiliza otro navegador.</audio>

    </div>

    <br>
    <!-- DIV RESULTADOS DE LA RESPUESTA -->
    <div class="card p-4 m-5 border border-danger">
        <div class="card-header">
            <h3 class="text-center"><strong class="text-red">Resultado de la pregunta</strong></h3>
            
        </div>
        <h4 class="text-red pt-2"><strong>Puntaje:</strong></h4>
        <h4 class="text-center"><strong>{{$sumaresultados}}</strong></h4>
    </div>


    <!-- ////////////////////////////////////////////////////////////REVISION DETALLADA DE CADA RESPUESTA DEL USUARIO -->



    <!-- ////////////////////////////////////TEXTO AUDIO -->

    <div class="container border border-dark rounded mb-5">
                
        <!-- TITULO -->
        <header class="px-5 py-4 border-bottom">
            <h2 class="text-red text-center"><strong>Revisión respuesta:</strong></h2>
        </header>
        <!-- OBSERVACION -->
        <div class="px-5 py-4 border-top border-bottom m-2">
            <h4 class="text-red mt-2 ml-4 mb-2"><strong>Observación:</strong></h4>
            <h4 class="text-center m-4">{{$respuestaTextoUno}}</h4>
        </div>


        <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOTIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA
        ES INCORRECTA, SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL TEXTO DE RESPUESTA DEL USUARIO ORIGINAL,
        EL TEXTO CORRECTO ORIGINAL, EL TEXTO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO
        PERO SI LA VARIABLE RESULTADO ES DIFERENTE DE CERO, LO QUE SIGNIFICA QUE ESTA BIEN, SOLO SE MUESTRE EL TEXTO 
        RESPUESTA DEL USUARIO ORIGINAL Y EL TEXTO CORRECTO ORIGINAL-->
        <!-- RESPUESTA USUARIO -->
        @if ($resultadotauno === 0.00)
            <!-- SI LA RESPUESTA DEL USUARIO ES INCORRECTA ENTONCES SE ENVIAN LOS SIGUIENTES DATOS -->

            <!-- LA RESPUESTA DEL USUARIO ORIGINAL SE MUESTRA MEDIANTE LA VARIABLE  stringseccionestextotausuario 
            QUE VA A MOSTRAR DONDE EL USUARIO HA COLOCADO ESPACIOS DEMAS SI FUESE EL CASO -->
            <!-- ESTA SECCION SE PUEDE COMENTAR POR EL ELEMENTO $textoUsuario SI LUEGO NO QUIERO QUE SE MUESTREN LOS ESPACIOS AÑADIDOS -->
            
            <!-- ESTE GRID CONTIENE LA RESPUESTA ORIGINAL DEL USUARIO Y LA RESPUESTA CORRECTA EN DOS COLUMNAS SE COMENTO PARA AGREGAR
            EN LA PARTE DE ABAJAO EN DOS FILAS DIFERENTES EL TEXTO DEL USUARIO Y EL TEXTO CORRECTO -->
            <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
            {{--<div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                <!-- RESPUESTA USUARIO -->
                <div class="container mx-auto p-5">
                    <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tu respuesta:</h5>

                    <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenespacios ES TRUE, ENTONCES SE MUESTRA LA RESPUESTA DEL USUARIO CON LOS "_" Y EL
                    MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->
                    @if ($existenespaciosti)
                        <label class="text-gray-500">Si tu respuesta posee "_" dentro del enunciado, significa que agregaste espacios adicionales entre palabras o signos.</label>
                        <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$stringseccionestextotiusuario}}</h4>
                        
                    @else
                    <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$stringseccionestextotiusuario}}</h4>
                    @endif
                    
                </div>
                <!-- RESPUESTA CORRECTA -->
                <div class="container mx-auto p-5">
                    <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Respuesta correcta:</h5>
                    <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$textoCorrecto}}</h4>
                </div>
            </div>--}}

            <!-- GRID QUE MUESTRA LA RESPUESTA DEL USUARIO -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Tu respuesta:</strong></h5>
                <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenespacios ES TRUE, ENTONCES SE MUESTRA LA RESPUESTA DEL USUARIO CON LOS "_" Y EL
                MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->
                    @if ($existenespacios)
                        <label class="h6 text-justify">Si tu respuesta posee "_" dentro del enunciado, significa que agregaste espacios adicionales entre palabras o signos.</label>
                        <h4 class="text-justify m-4"><strong>{{$stringseccionestextotausuario}}</strong></h4>
                        
                    @else
                        <h4 class="text-justify m-4"><strong>{{$stringseccionestextotausuario}}</strong></h4>
                    @endif
            </div>
            <!-- GRID QUE MUESTRA LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Texto correcto:</strong></h5>
                <h4 class="text-justify m-4"><strong>{{$textoCorrecto}}</strong></h4>
            </div>

            <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES -->
                    @if (($hayUnEspacioEnBlancoTextoAudio === true) && 
                        (count($resultadoSignosIncorrectosTextoUsuario) === 0) && (count($resultadoSignosQueLeFaltaronTextoUsuario) === 0) &&
                        (count($resultadoSeccionesQueLeFaltaronTextoUsuario) === 0))
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa tu respuesta. Haz agregado espacios en blanco adicionales "_" en tu respuesta.</strong></h5>

                        </div>   
                    @else
                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoTextoAudio === true)
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa tu respuesta original. Haz agregado espacios en blanco adicionales "_" en tu respuesta.</strong></h5>
                            
                            </div>
                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2">
                                    <strong>A continuación puedes revisar los elementos incorrectos de tu respuesta.</strong></h5>
                                <h5 class="text-center pt-2 mt-2 mb-2 ml-2">
                                    <strong>*Se han eliminado los espacios adicionales que agregaste en tu respuesta*.</strong></h5>
                                
                            </div>
                        @else 

                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2">
                                    <strong>A continuación puedes revisar los elementos incorrectos de tu respuesta.</strong></h5>
                                
                            </div>

                        @endif

                        <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de tu respuesta:</strong></h5>
                            <p class="text-start mt-4">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                            <h4 id="textousuario" class="text-justify mt-4">{{$textoUsuario}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                            <p class="text-start mt-4">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                            <h4 id="textocorrecto" class="text-justify mt-4">{{$textoCorrecto}}</h4>
                        </div>
                    @endif

            <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
            {{--<div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de tu respuesta:</strong></h5>
                <p class="text-start mt-4">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                <h4 id="textousuario" class="text-justify mt-4">{{$textoUsuario}}</h4>
            </div>
            <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                <p class="text-start mt-4">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                <h4 id="textocorrecto" class="text-justify mt-4">{{$textoCorrecto}}</h4>
            </div>--}}
        
        @else 
            <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
            <!-- RESPUESTA DEL USUARIO -->

            <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
            {{--<div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                <!-- RESPUESTA USUARIO -->
                <div class="container mx-auto p-5">
                    <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tu respuesta:</h5>
                    <h4 id="textousuario" class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$textoUsuario}}</h4>
                </div>
                <!-- RESPUESTA CORRECTA -->
                <div class="container mx-auto p-5">
                    <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Respuesta correcta:</h5>
                    <h4 id="textocorrecto" class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$textoCorrecto}}</h4>
                </div>
            </div>--}}

            <!-- RESPUESTA USUARIO -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Tu respuesta:</strong></h5>
                <h4 id="textousuario" class="text-justify mt-4"><strong>{{$textoUsuario}}</strong></h4>
            </div>
            <!-- RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta correcta:</strong></h5>
                <h4 id="textocorrecto" class="text-justify mt-4"><strong>{{$textoCorrecto}}</strong></h4>
            </div>

        @endif

        <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
        EN LA RESPUESTA -->
        @if (count($resultadoSeccionesTextoUsuarioIncorrectas) > 0)
            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos incorrectos de tu respuesta:</strong></h5>
                <p class="text-start mt-4">Los siguientes elementos de tu respuesta son incorrectos.</p>

                <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach (array_unique($resultadoSeccionesTextoUsuarioIncorrectas) as $key=>$elemento)
                    <span id="palabrasIncorrectasTextoUsuario" name="palabrasIncorrectasTextoUsuario" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
        @endif

        <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
        @if (count($resultadoSignosIncorrectosTextoUsuario) > 0)

            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos ortográficos incorrectos:</strong></h5>
                <p class="text-start mt-4">Los siguientes elementos ortográficos incorrectos fueron encontrados en tu respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSignosIncorrectosTextoUsuario as $elemento)
                    <span id="signosIncorrectosTextoUsuario" name="signosIncorrectosTextoUsuario" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>

        @endif


        <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
        NO PUSO EN SU RESPUESTA -->
        @if (count($resultadoSignosQueLeFaltaronTextoUsuario) > 0)

            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Signos de puntuación no encontrados en tu respuesta:</strong></h5>
                <p class="text-start mt-4">Los siguientes signos de puntuación no fueron encontrados en tu respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSignosQueLeFaltaronTextoUsuario as $elemento)
                    <span id="signosQueLeFaltaronAlUsuario" name="signosQueLeFaltaronAlUsuario" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
            
        @endif


        <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
        QUE ESTEN INCORRECTAS -->
        @if (count($resultadoSeccionesQueLeFaltaronTextoUsuario) > 0)
            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2">Secciones de la respuesta correcta no encontradas en tu respuesta:</h5>
                <p class="text-justify mt-4">Las siguientes secciones no se encontraron en tu respuesta debido a que colocaste incorrectamente ciertos signos de puntuación o escribiste palabras incorrectamente.
                    En la respuesta correcta se marcan de color verde las secciones que no se encontraron en tu texto.
                </p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSeccionesQueLeFaltaronTextoUsuario as $elemento)
                    <span id="seccionesQueLeFaltaronAlUsuario" name="seccionesQueLeFaltaronAlUsuario" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
        @endif 
        

    </div>


    <!-- DIV QUE CONTIENE EL TITULO DE REGLAS QUE SE TOMARON EN CUENTA Y UNA DESCRIPCION -->
    <div class="p-5">
        <h1 class="text-start text-red m-5 pb-5"><strong>Reglas ortográficas que se tomaron en cuenta para esta actividad:</strong></h1>
        <li class="h5 mb-5 text-justify">En la siguiente sección se presentan las reglas ortográficas que se emplearon para la realización de esta actividad.</li>
        <li class="h5 mb-5 text-justify">Haz click en la regla ortográfica de tu interés y accede a más información sobre el uso de esa regla ortográfica.</li>
        <li class="h5 mb-5 text-justify">Adicionalmente, tienes algunas aclaraciones sobre la actividad que acabas de realizar.</li>
    </div>


            <!-- DIV QUE CONTIENE LAS REGLAS ORTOGRÁFICAS ASOCIADAS Y LAS JUSTIFICACIONES -->
            <div class="container-fluid bg-white border border-dark rounded" >
                {{--<header class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-red-500 font-sora">Reglas ortográficas tomaron en cuenta para esta actividad:</h2>
                </header>--}}
        
                <!-- TABLA CON DOS COLUMNAS QUE CONTIENE LAS JUSTIFICACIONES Y LA REGLA ASOCIADA -->
                <div class="p-3">
                    <div class="overflow-auto">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    {{--<th>
                                        <div class="text-center">Regla ortográfica</div>
                                    </th>--}}
                                    <th>
                                        <div class="text-center text-red">Explicación a la respuesta:</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
        
                                <!-- RECORRER LAS JUSTIFICACIONES DE RESPUESTA -->
                                @foreach ($questionType->justifications as $justification)
                                    <tr>
                                        {{--<td>
                                            <div class="text-center text-red"><strong>{{$justification->rule}}</strong></div>
                                        </td>--}}
                                        <td>
                                            <p class="text-justify">{{$justification->reason}}</p>
                                        </td>
                                    </tr>
                                @endforeach
        
                            </tbody>
                        </table>
                    </div>
                </div>
        
        
        
                <!-- SECCION QUE CONTIENE LAS REGLAS PARA IR A CADA UNA DE ELLAS -->
                <!-- ESTE DIV CONTIENE A LOS 3 TIPOS DE REGLAS ORTOGRAFICAS -->
                <div class="container-fluid">
                    <h5 class="text-start text-red mt-4 ml-4 mb-5"><strong>Haz click en la regla ortográfica de tu interés a continuación para acceder a más información:</strong></h5>
        
                    <!-- REGLAS ORTOGRAFICAS DE PALABRAS -->
                    <!-- CON EL IF SE PREGUNTA MEDIANTE LAS VARIABLES HAYPALABRAS SI ALGUNA DE ELLAS ES TRUE, LO QUE SIGNIFICA QUE HAY REGLAS ORTOGRAFICAS DE ESE NIVEL -->
                    @if (($haypalabrasencategories === true) || ($haypalabrasensections === true) || ($haypalabrasenposts === true) || ($haypalabrasenrules === true) || ($haypalabrasennotes === true))
                        <div class="row row-cols-1">
                            <h5 class="text-red mt-4 ml-2"><strong>Reglas ortográficas de palabras:</strong></h5>
                            <div class="p-2">
        
                                <!-- SI HAY REGLAS ORTOGRAFICAS DE PALABRAS DE CUALQUIER NIVEL, AHORA PREGUNTAR INDIVIDUALMENTE PARA IR MOSTRANDO LAS REGLAS ORTOGRAFICAS -->
                                @if ($haypalabrasencategories === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL UNO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION CATEGORIES -->
                                    @foreach ($questionType->categories as $categoryrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES PALABRAS -->
                                        @if ($categoryrule->type === "Reglas ortográficas de palabras")
                                            {{--<a href="/estudiante/letters/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$categoryrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/letters/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block">
                                                <strong>{{$categoryrule->name}}</strong>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                @endif
        
                                @if ($haypalabrasensections === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL DOS ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION SECTIONS -->
                                    @foreach ($questionType->sections as $sectionrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PALABRAS -->
                                        @if ($sectionrule->type === "Reglas ortográficas de palabras")
                                            {{--<a href="/estudiante/letters/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$sectionrule->name}}   
                                            </a>--}}
                                            <a href="/estudiante/letters/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block" >
                                                <strong>{{$sectionrule->name}}  </strong>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                @endif
        
                                @if ($haypalabrasenposts === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL TRES ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION POSTS -->
                                    @foreach ($questionType->posts as $postrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PALABRAS -->
                                        @if ($postrule->type === "Reglas ortográficas de palabras")
                                            @php 
                                                //CATEGORY_ID PARA BUSCAR LA CATEGORIA NIVEL 1 QUE CONTIENE A LA REGLA DE NIVEL 3
                                                $category_idpalabras = $postrule->section->category_id;
                                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 3 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                                $categorypalabras = DB::table('categories')->find($category_idpalabras);
                                            @endphp
        
                                            <!-- CON EL OBJETO CATEGORY MEDIANTE SU CAMPO SLUG, SE REFERENCIA A LA CATEGORIA NIVEL 1 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                                            {{--<a href="/estudiante/letters/{{$categorypalabras->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$postrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/letters/{{$categorypalabras->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block" >
                                                <strong>{{$postrule->name}} </strong>
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
        
                                @if ($haypalabrasenrules === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL CUATRO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION RULES -->
                                    @foreach ($questionType->rules as $rulerule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PALABRAS -->
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
                                            {{--<a href="/estudiante/letters/{{$categoryrulepalabras->slug}}/{{$sectionrulepalabras->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$rulerule->name}}
                                            </a>--}}
                                            <a href="/estudiante/letters/{{$categoryrulepalabras->slug}}/{{$sectionrulepalabras->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block">
                                                <strong>{{$rulerule->name}}</strong>
                                            </a>
        
                                        @endif
                                    
                                    @endforeach
                                @endif
        
                                @if ($haypalabrasennotes === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL CINCO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION NOTES -->
                                    @foreach ($questionType->notes as $noterule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PALABRAS -->
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
                                            {{--<a href="/estudiante/letters/{{$categoryrulepalabras->slug}}/{{$sectionrulepalabras->slug}}/{{$postrulepalabras->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$noterule->name}}
                                            </a>--}}
                                            <a href="/estudiante/letters/{{$categoryrulepalabras->slug}}/{{$sectionrulepalabras->slug}}/{{$postrulepalabras->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block">
                                                <strong>{{$noterule->name}}</strong>
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
        
        
        
                    <!-- REGLAS ORTOGRAFICAS DE ACENTUACION -->
                    <!-- CON EL IF SE PREGUNTA MEDIANTE LAS VARIABLAS HAYACENTUACION SI ALGUNA DE ELLAS ES TRUE, LO QUE SIGNIFICA QUE HAY REGLAS ORTOGRAFICAS DE ESE NIVEL -->
                    @if (($hayacentuacionencategories === true ) || ($hayacentuacionensections === true) || ($hayacentuacionenposts === true) || ($hayacentuacionenrules === true) || ($hayacentuacionennotes === true))
                        <div class="row row-cols-1">
                            <h5 class="text-red mt-4 ml-2"><strong>Reglas ortográficas de acentuación:</strong></h5>
                            <div class="p-2">
                                <!-- SI HAY REGLAS ORTOGRAFICAS DE ACENTUACION DE CUALQUIER NIVEL, AHORA PREGUNTA INDIVIDUALMENTE PARA IR MOSTRANDO LAS REGLAS ORTOGRAFICAS -->
                                @if ($hayacentuacionencategories === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL UNO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION CATEGORIES -->
                                    @foreach ($questionType->categories as $categoryrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES ACENTUACION -->
                                        @if ($categoryrule->type === "Reglas ortográficas de acentuación")
                                            {{--<a href="/estudiante/acentuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$categoryrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/acentuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block">
                                                <strong>{{$categoryrule->name}}</strong>
                                            </a>
                                        @endif
                                       
                                    @endforeach
                                @endif
        
                                @if ($hayacentuacionensections === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL DOS ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION SECTIONS -->
                                    @foreach ($questionType->sections as $sectionrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE ACENTUACION -->
                                        @if ($sectionrule->type === "Reglas ortográficas de acentuación")
                                            {{--<a href="/estudiante/acentuation/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$sectionrule->name}}    
                                            </a>--}}
                                            <a href="/estudiante/acentuation/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block">
                                                <strong>{{$sectionrule->name}}</strong>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                @endif
        
                                @if ($hayacentuacionenposts === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL TRES ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION POSTS -->
                                    @foreach ($questionType->posts as $postrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE ACENTUACION -->
                                        @if ($postrule->type === "Reglas ortográficas de acentuación")
                                            @php 
                                                //CATEGORY_IDACENTUACION PARA BUSCAR LA CATEGORIA DE NIVEL 1 QUE CONTIENE A LA REGLA DE NIVEL 3
                                                $category_idacentuacion = $postrule->section->category_id;
                                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 3 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                                $categoryacentuacion = DB::table('categories')->find($category_idacentuacion);
                                            @endphp
        
                                            <!-- CON EL OBJETO CATEGORY MEDIANTE SU CAMPO SLUG, SE REFERENCIA A LA CATEGORIA NIVEL 1 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                                            {{--<a href="/estudiante/acentuation/{{$categoryacentuacion->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$postrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/acentuation/{{$categoryacentuacion->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block">
                                                <strong>{{$postrule->name}}</strong>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                @endif
        
                                @if ($hayacentuacionenrules === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL CUATRO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION RULES -->
                                    @foreach ($questionType->rules as $rulerule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE ACENTUACION -->
                                        @if ($rulerule->type === "Reglas ortográficas de acentuación")
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
                                            {{--<a href="/estudiante/acentuation/{{$categoryruleacentuacion->slug}}/{{$sectionruleacentuacion->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$rulerule->name}}
                                            </a>--}}
                                            <a href="/estudiante/acentuation/{{$categoryruleacentuacion->slug}}/{{$sectionruleacentuacion->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block">
                                                <strong>{{$rulerule->name}}</strong>
                                            </a>
                                        @endif
                                       
                                    @endforeach
                                @endif
        
        
                                @if ($hayacentuacionennotes === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL CINCO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION NOTES -->
                                    @foreach ($questionType->notes as $noterule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPEE DE LA REGLA QUE SE RECORRE ES DE ACENTUACION -->
                                        @if ($noterule->type === "Reglas ortográficas de acentuación")
                                            
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
                                            {{--<a href="/estudiante/acentuation/{{$categoryruleacentuacion->slug}}/{{$sectionruleacentuacion->slug}}/{{$postruleacentuacion->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$noterule->name}}
                                            </a>--}}
                                            <a href="/estudiante/acentuation/{{$categoryruleacentuacion->slug}}/{{$sectionruleacentuacion->slug}}/{{$postruleacentuacion->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block">
                                                <strong>{{$noterule->name}}</strong>
                                            </a>
        
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                        
        
        
                    <!-- REGLAS ORTOGRAFICAS DE PUNTUACION -->
                    <!-- CON EL IF SE PREGUNTA MEDIANTE LAS VARIABLES HAYPUNTUACION SI ALGUNA DE ELLAS ES TRUE, LO QUE SIGNIFICA QUE HAY REGLAS ORTOGRAFICAS DE ESE NIVEL -->
                    @if (($haypuntuacionencategories === true) || ($haypuntuacionensections === true) || ($haypuntuacionenposts === true) || ($haypuntuacionenrules === true) || ($haypuntuacionennotes === true))
                        <div class="row row-cols-1">
                            <h5 class="text-red mt-4 ml-2"><strong>Reglas ortográficas de puntuación:</strong></h5>
                            <div class="p-2">
                                <!-- SI HAY REGLAS ORTOGRAFICAS DE PUNTUACION DE CUALQUIER NIVEL, AHORA PREGUNTAR INDIVIDUALMENTE PARA IR MOSTRANDO LAS REGLAS ORTOGRAFICAS -->
                                @if ($haypuntuacionencategories === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL UNO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION CATEGORIES -->
                                    @foreach ($questionType->categories as $categoryrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PUNTUACION -->
                                        @if ($categoryrule->type === "Reglas ortográficas de puntuación")
                                            {{--<a href="/estudiante/punctuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$categoryrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/punctuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block">
                                                <strong>{{$categoryrule->name}}</strong>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                @endif
        
                                @if ($haypuntuacionensections === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL DOS ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION SECTIONS -->
                                    @foreach ($questionType->sections as $sectionrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PUNTUACION -->
                                        @if ($sectionrule->type === "Reglas ortográficas de puntuación")
                                            {{--<a href="/estudiante/punctuation/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$sectionrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/punctuation/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block">
                                                <strong>{{$sectionrule->name}}</strong>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                    
                                @endif
        
                                @if ($haypuntuacionenposts === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL TRES ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION POSTS -->
                                    @foreach ($questionType->posts as $postrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PUNTUACION -->
                                        @if ($postrule->type === "Reglas ortográficas de puntuación")
                                            @php 
                                                //CATEGORY_IDPUNTUACION PARA BUSCAR LA CATEGORIA DE NIVEL 1 QUE CONTIENE A LA REGLA DE NIVEL 3
                                                $category_idpuntuacion = $postrule->section->category_id;
                                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 3 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                                $categorypuntuacion = DB::table('categories')->find($category_idpuntuacion);
        
                                            @endphp
                                            {{--<a href="/estudiante/punctuation/{{$categorypuntuacion->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$postrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/punctuation/{{$categorypuntuacion->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block">
                                                <strong>{{$postrule->name}}</strong>
                                            </a>
                                        @endif
                                       
                                    @endforeach
                                @endif
        
                                @if ($haypuntuacionenrules === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL CUATRO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION RULES -->
                                    @foreach ($questionType->rules as $rulerule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PUNTUACION -->
                                        @if ($rulerule->type === "Reglas ortográficas de puntuación")
                                            @php 
                                                    
                                                //MEDIANTE EL CAMPO SECTION_ID DE LA RELACION POST, SE BUSCA EL REGISTRO NIVEL 2 QUE CONTIENE A ESTA REGLA NIVEL 4
                                                $sectionrule_idpuntuacion = $rulerule->post->section_id;
                                                //BUSCAR EN LA TABLA SECTIONS LA REGLA DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 4 MEDIANTE EL CAMPO SECTION_ID DE POST
                                                $sectionrulepuntuacion = DB::table('sections')->find($sectionrule_idpuntuacion);
        
                                                //MEDIANTE EL CAMPO CATEGORY_ID DE LA VARIABLE SECTIONRULEPUNTUACION SE BUSCA EL REGISTRO DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 4
                                                $categoryrule_idpuntuacion = $sectionrulepuntuacion->category_id;
                                                $categoryrulepuntuacion = DB::table('categories')->find($categoryrule_idpuntuacion);
        
                                            @endphp
                                            {{--<a href="/estudiante/punctuation/{{$categoryrulepuntuacion->slug}}/{{$sectionrulepuntuacion->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$rulerule->name}}
                                            </a>--}}
                                            <a href="/estudiante/punctuation/{{$categoryrulepuntuacion->slug}}/{{$sectionrulepuntuacion->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block">
                                                <strong>{{$rulerule->name}}</strong>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                @endif
        
        
                                @if ($haypuntuacionennotes === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL CINCO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION NOTES -->
                                    @foreach ($questionType->notes as $noterule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DEE LA REGLA QUE SE RECORRE ES DE PUNTUACION -->
                                        @if ($noterule->type === "Reglas ortográficas de puntuación")
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
                                            {{--<a href="/estudiante/punctuation/{{$categoryrulepuntuacion->slug}}/{{$sectionrulepuntuacion->slug}}/{{$postrulepuntuacion->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$noterule->name}}
                                                <br>
                                            </a>--}}
                                            <a href="/estudiante/punctuation/{{$categoryrulepuntuacion->slug}}/{{$sectionrulepuntuacion->slug}}/{{$postrulepuntuacion->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" class="h5 text-start text-blue mt-2 mb-2 d-block">
                                                <strong>{{$noterule->name}}</strong>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                @endif
                            </div>
                        </div>          
                    @endif
        
        
        
        
                </div>
        
            </div>



</div>





<!-- /////////////////////////////////////////////////FIN NUEVA VISTA ADMIN RESULTADOS TA//////////////////////////////////////////////////// -->








@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <!-- SCRIPT JUEGO -->
    <script src="{{asset('/js/resaltartaadmin.js')}}"></script>
@stop