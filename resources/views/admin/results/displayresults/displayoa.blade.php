@extends('adminlte::page')

@section('title', 'Resultado pregunta')

@section('content_header')
    <h1>Resultado pregunta</h1>
@stop

@section('content')
   

<!-- ////////////////////////////////////////////////NUEVA VISTA ADMIN RESULTADOS PREGUNTA OA///////////////////////////// -->

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


    <!-- DIV QUE CONTIENE EL ANALISIS GENERAL DE LAS RESPUESTAS DEL USUARIO -->
    <div class="container border border-dark rounded mb-5" >
        <header class="px-5 py-4 border-bottom">
            <h2 class="text-red text-center"><strong>Revisión general de las respuestas:</strong></h2>
        </header>
        <!-- GRID CON DOS COLUMNAS QUE CONTIENE LAS PALABRAS CORRECTAS Y PALABRAS INCORRECTAS DEL USUARIO -->
        <div class="row">
            <!-- RESPUESTA USUARIO -->
            <div class="col-12 col-md-6 border">
                <h5 class="text-red mt-4 ml-4 mb-2"><strong>Respuestas correctas del usuario:</strong></h5>
                <div class="container-fluid mx-auto p-5">
                    <!-- RECORRER LAS RESPUESTAS CORRECTAS DEL USUARIO -->
                    @foreach ($oracionesAcertadas as $correcta)
                        <h4 class="text-start m-4 border border-bottom"><strong>{{$correcta}}</strong></h4>
                    @endforeach

                </div>
            </div>
            <!-- RESPUESTA CORRECTA -->
            <div class="col-12 col-md-6 border">
                <h5 class="text-red mt-4 ml-4 mb-2"><strong>Respuestas incorrectas del usuario:</strong></h5>
                <div class="container-fluid mx-auto p-5">
                    <!-- RECORRER LAS RESPUESTAS INCORRECTAS DEL USUARIO -->
                    @foreach ($oracionesIncorrectas as $incorrecta)
                        <h4 class="text-start m-4 border-bottom"><strong>{{$incorrecta}}</strong></h4>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>


    <!-- DIV QUE CONTIENE LAS ORACIONES DEL USUARIO Y LAS ORACIONES CORRECTAS -->
    <div class="container border border-dark rounded mb-5" >
        <header class="px-5 py-4 border-bottom">
            <h2 class="text-red text-center"><strong>Oraciones que se analizaron:</strong></h2>
        </header>
        <!-- GRID CON DOS COLUMNAS QUE CONTIENE LAS PALABRAS CORRECTAS Y PALABRAS INCORRECTAS DEL USUARIO -->
        <div class="row">
            <!-- RESPUESTA USUARIO -->
            <div class="col-12 col-md-6 border">
                <h5 class="text-red mt-4 ml-4 mb-2"><strong>Oraciones usuario:</strong></h5>
                <div class="container-fluid mx-auto p-5">

                    <!-- MOSTRAR LAS PALABRAS VISIBLES -->
                    @foreach ($coleccionResults as $result)
                        <h4 class="text-left m-4 border-bottom"><strong>{{$result->answer_user}}</strong></h4>
                    @endforeach
                </div>
            </div>
            <!-- RESPUESTA CORRECTA -->
            <div class="col-12 col-md-6 border">
                <h5 class="text-red mt-4 ml-4 mb-2"><strong>Oraciones correctas:</strong></h5>
                <div class="container-fluid mx-auto p-5">

                    <!-- MOSTRAR LAS PALABRAS CORRECTAS -->
                    @foreach ($questionType->answers as $answer)
                        <h4 class="text-left m-4 border-bottom"><strong>{{$answer->answer}}</strong></h4>
                    @endforeach
                    

                </div>
            </div>
        </div>
    </div>

    <!-- DIV QUE CONTIENE EL TITULO DE ANALISIS DE CADA RESPUESTA Y UNA DESCRIPCION -->
    <div class="p-5">
        <h1 class="text-start text-red m-5 pb-5"><strong>Revisión de cada respuesta:</strong></h1>
        <p class="h2 mb-5 text-justify">A continuación, puedes ver en detalle la revisión de cada una de las respuestas.</p>
    </div>


    <!-- ///////////////////////////////////////////REVISIONES DETALLADAS DE CADA RESPUESTA DEL USUARIO -->


    <!--//////////////////////////////////////////ORACION UNO -->


    <div class="container border border-dark rounded mb-5">
                
        <!-- TITULO -->
        <header class="px-5 py-4 border-bottom">
            <h2 class="text-red text-center"><strong>Revisión respuesta uno:</strong></h2>
        </header>
        <!-- OBSERVACION -->
        <div class="px-5 py-4 border-top border-bottom m-2">
            <h4 class="text-red mt-2 ml-4 mb-2"><strong>Observación:</strong></h4>
            <h4 class="text-center m-4">{{$respuestaOracionUno}}</h4>
        </div>


        <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA -->
        <!-- SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL -->
        <!-- EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO 
        LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL-->
        @if ($resultadooauno === 0.00)
            <!-- SI LA RESPUESTA DEL USUARIO ES INCORRECTA ENTONCES SE ENVIAN LOS SIGUIENTES DATOS -->

            <!-- LA RESPUESTA DEL USUARIO ORIGINAL SE MUESTRA MEDIANTE LA VARIABLE $stringSeccionesEnunciadoUsuarioUno QUE VA A MOSTRAR  
            DONDE EL USUARIO HA COLOCADO ESPACIOS DEMAS SI FUESE EL CASO-->
            <!-- ESTA SECCION SE PUEDE COMENTAR POR EL ELEMENTO $enunciadoUsuarioUno SI LUEGO NO QUIERO QUE SE MUESTREN LOS ESPACIOS AGREGADOS POR EL USUARIO-->
            
            <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
            <div class="row">
                <!-- RESPUESTA USUARIO -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-red pt-2 m-5"><strong>Respuesta usuario:</strong></h5>

                    <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                    MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->
                    @if ($existenEspaciosOracionUno)
                        <label class="h6 text-justify">Si la respuesta posee "_" dentro del enunciado, significa que agregó espacios adicionales entre palabras o signos.</label>
                        <h4 class="text-justify m-4"><strong>{{$stringSeccionesOracionUsuarioUno}}</strong></h4>
                        
                    @else
                    <h4 class="text-justify m-4"><strong>{{$stringSeccionesOracionUsuarioUno}}</strong></h4>
                    @endif
                    
                </div>
                <!-- RESPUESTA CORRECTA -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-red pt-2 m-5"><strong>Respuesta correcta:</strong></h5>
                    <h4 class="text-justify m-4"><strong>{{$oracionCorrectaUno}}</strong></h4>
                </div>
            </div>

                    <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES -->
                    @if (($hayUnEspacioEnBlancoOracionUno === true) && (count($resultadoSignosIncorrectosUsuarioUno) === 0) &&
                        (count($resultadoSignosQueLeFaltaronAlUsuarioUno) === 0) && (count($resultadoSeccionesQueLeFaltaronAlUsuarioUno) === 0))
                        
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>

                        </div>  

                    @else

                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoOracionUno === true)
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>
                            
                            </div>
                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2">
                                    <strong>A continuación, puedes revisar los elementos incorrectos de la respuesta.</strong></h5>
                                <h5 class="text-center pt-2 mt-2 mb-2 ml-2">
                                    <strong>*Se han eliminado los espacios adicionales que agregó en la respuesta*</strong></h5>
                                
                            </div>
                        @else 

                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2">
                                    <strong>A continuación, puedes revisar los elementos incorrectos de la respuesta.</strong></h5>
                                
                            </div>

                        @endif
                        
                        <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de tu respuesta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta tiene elementos marcados de color rojo, posee elementos incorrectos. Estos elementos son incorrectos por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">Ha agregado palabras incorrectas.</li>
                            <li class="text-start mt-4">Ha agregado signos de puntuación de forma incorrecta.</li>
                            <li class="text-start mt-4">Ha agregado una misma palabra más veces de las necesarias.</li>
                            <h4 id="oracionusuariouno" class="text-justify mt-4">{{$oracionUsuarioUno}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta contiene elementos marcados de color verde, dichos elementos hacen falta en la respuesta. Estos elementos no se han encontrado en la respuesta por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">La respuesta no contiene la palabra marcada.</li>
                            <li class="text-start mt-4">La respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                            <li class="text-start mt-4">La respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                            <li class="text-start mt-4">Ha omitido la palabra marcada en la respuesta.</li>
                            <h4 id="oracioncorrectauno" class="text-justify mt-4">{{$oracionCorrectaUno}}</h4>
                        </div>
                        
                    @endif

            <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
            {{--<div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de tu respuesta:</strong></h5>
                <p class="text-start mt-4">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                <h4 id="oracionusuariouno" class="text-justify mt-4">{{$oracionUsuarioUno}}</h4>
            </div>
            <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2">Comparación con la respuesta correcta:</h5>
                <p class="text-start mt-4">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                <h4 id="oracioncorrectauno" class="text-justify mt-4">{{$oracionCorrectaUno}}</h4>
            </div>--}}
        
        @else 
            <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
            <!-- RESPUESTA DEL USUARIO -->

            <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
            <div class="row">
                <!-- RESPUESTA USUARIO -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta usuario:</strong></h5>
                    <h4 id="oracionusuariouno" class="text-justify mt-4"><strong>{{$oracionUsuarioUno}}</strong></h4>
                </div>
                <!-- RESPUESTA CORRECTA -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta correcta:</strong></h5>
                    <h4 id="oracioncorrectauno" class="text-justify mt-4"><strong>{{$oracionCorrectaUno}}</strong></h4>
                </div>
            </div>

        @endif

        <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
        EN LA RESPUESTA -->
        @if (count($resultadoSeccionesIncorrectasOracionUsuarioUno) >0)
            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos incorrectos de la respuesta:</strong></h5>
                <p class="text-start mt-4">Los siguientes elementos de la respuesta son incorrectos.</p>

                <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach (array_unique($resultadoSeccionesIncorrectasOracionUsuarioUno) as $key=>$elemento)
                    <span id="seccionesIncorrectasOracionUsuarioUno" name="seccionesIncorrectasOracionUsuarioUno" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
        @endif

        <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
        @if (count($resultadoSignosIncorrectosUsuarioUno) > 0)

            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos ortográficos incorrectos:</strong></h5>
                <p class="text-start mt-4">Los siguientes elementos ortográficos incorrectos fueron encontrados en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSignosIncorrectosUsuarioUno as $elemento)
                    <span id="signosIncorrectosOracionUsuarioUno" name="signosIncorrectosOracionUsuarioUno" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>

        @endif


        <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
        NO PUSO EN SU RESPUESTA -->
        @if (count($resultadoSignosQueLeFaltaronAlUsuarioUno) > 0)

            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Signos de puntuación no encontrados en la respuesta:</strong></h5>
                <p class="text-start mt-4">Los siguientes signos de puntuación no fueron encontrados en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSignosQueLeFaltaronAlUsuarioUno as $elemento)
                    <span id="signosQueLeFaltaronAlUsuario" name="signosQueLeFaltaronAlUsuario" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
            
        @endif


        <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
        QUE ESTEN INCORRECTAS -->
        @if (count($resultadoSeccionesQueLeFaltaronAlUsuarioUno) > 0)
            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Secciones de la respuesta correcta no encontradas en la respuesta:</strong></h5>
                <p class="text-justify mt-4">Las siguientes secciones no se encontraron en la respuesta.
                </p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSeccionesQueLeFaltaronAlUsuarioUno as $elemento)
                    <span id="seccionesQueLeFaltaronAlUsuarioUno" name="seccionesQueLeFaltaronAlUsuarioUno" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
        @endif 
        

    </div>




    <!--//////////////////////////////////////////ORACION DOS -->


    <div class="container border border-dark rounded mb-5">
                
        <!-- TITULO -->
        <header class="px-5 py-4 border-bottom">
            <h2 class="text-red text-center"><strong>Revisión respuesta dos:</strong></h2>
        </header>
        <!-- OBSERVACION -->
        <div class="px-5 py-4 border-top border-bottom m-2">
            <h4 class="text-red mt-2 ml-4 mb-2"><strong>Observación:</strong></h4>
            <h4 class="text-center m-4">{{$respuestaOracionDos}}</h4>
        </div>


        <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA -->
        <!-- SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL -->
        <!-- EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO 
        LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL-->
        @if ($resultadooados === 0.00)
            <!-- SI LA RESPUESTA DEL USUARIO ES INCORRECTA ENTONCES SE ENVIAN LOS SIGUIENTES DATOS -->

            <!-- LA RESPUESTA DEL USUARIO ORIGINAL SE MUESTRA MEDIANTE LA VARIABLE $stringSeccionesEnunciadoUsuarioUno QUE VA A MOSTRAR  
            DONDE EL USUARIO HA COLOCADO ESPACIOS DEMAS SI FUESE EL CASO-->
            <!-- ESTA SECCION SE PUEDE COMENTAR POR EL ELEMENTO $enunciadoUsuarioUno SI LUEGO NO QUIERO QUE SE MUESTREN LOS ESPACIOS AGREGADOS POR EL USUARIO-->
            
            <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
            <div class="row">
                <!-- RESPUESTA USUARIO -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-red pt-2 m-5"><strong>Respuesta usuario:</strong></h5>

                    <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                    MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->
                    @if ($existenEspaciosOracionDos)
                        <label class="h6 text-justify">Si la respuesta posee "_" dentro del enunciado, significa que agregó espacios adicionales entre palabras o signos.</label>
                        <h4 class="text-justify m-4"><strong>{{$stringSeccionesOracionUsuarioDos}}</strong></h4>
                        
                    @else
                    <h4 class="text-justify m-4"><strong>{{$stringSeccionesOracionUsuarioDos}}</strong></h4>
                    @endif
                    
                </div>
                <!-- RESPUESTA CORRECTA -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-red pt-2 m-5"><strong>Respuesta correcta:</strong></h5>
                    <h4 class="text-justify m-4"><strong>{{$oracionCorrectaDos}}</strong></h4>
                </div>
            </div>

                    <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES -->
                    @if (($hayUnEspacioEnBlancoOracionDos === true) && (count($resultadoSignosIncorrectosUsuarioDos) === 0) &&
                        (count($resultadoSignosQueLeFaltaronAlUsuarioDos) === 0) && (count($resultadoSeccionesQueLeFaltaronAlUsuarioDos) === 0))
                        
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>

                        </div>  

                    @else

                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoOracionDos === true)
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>
                            
                            </div>
                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2">
                                    <strong>A continuación, puedes revisar los elementos incorrectos de la respuesta.</strong></h5>
                                <h5 class="text-center pt-2 mt-2 mb-2 ml-2">
                                    <strong>*Se han eliminado los espacios adicionales que agregó en la respuesta*</strong></h5>
                                
                            </div>
                        @else 

                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2">
                                    <strong>A continuación, puedes revisar los elementos incorrectos de la respuesta.</strong></h5>
                                
                            </div>

                        @endif
                        
                        <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de la respuesta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta tiene elementos marcados de color rojo, posee elementos incorrectos. Estos elementos son incorrectos por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">Ha agregado palabras incorrectas.</li>
                            <li class="text-start mt-4">Ha agregado signos de puntuación de forma incorrecta.</li>
                            <li class="text-start mt-4">Ha agregado una misma palabra más veces de las necesarias.</li>
                            <h4 id="oracionusuariodos" class="text-justify mt-4">{{$oracionUsuarioDos}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta contiene elementos marcados de color verde, dichos elementos hacen falta en la respuesta. Estos elementos no se han encontrado en la respuesta por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">La respuesta no contiene la palabra marcada.</li>
                            <li class="text-start mt-4">La respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                            <li class="text-start mt-4">La respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                            <li class="text-start mt-4">Ha omitido la palabra marcada en la respuesta.</li>
                            <h4 id="oracioncorrectados" class="text-justify mt-4">{{$oracionCorrectaDos}}</h4>
                        </div>
                        
                    @endif

            <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
            {{--<div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de tu respuesta:</strong></h5>
                <p class="text-start mt-4">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                <h4 id="oracionusuariodos" class="text-justify mt-4">{{$oracionUsuarioDos}}</h4>
            </div>
            <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                <p class="text-start mt-4">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                <h4 id="oracioncorrectados" class="text-justify mt-4">{{$oracionCorrectaDos}}</h4>
            </div>--}}
        
        @else 
            <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
            <!-- RESPUESTA DEL USUARIO -->

            <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
            <div class="row">
                <!-- RESPUESTA USUARIO -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta usuario:</strong></h5>
                    <h4 id="oracionusuariodos" class="text-justify mt-4"><strong>{{$oracionUsuarioDos}}</strong></h4>
                </div>
                <!-- RESPUESTA CORRECTA -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta correcta:</strong></h5>
                    <h4 id="oracioncorrectados" class="text-justify mt-4"><strong>{{$oracionCorrectaDos}}</strong></h4>
                </div>
            </div>

        @endif

        <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
        EN LA RESPUESTA -->
        @if (count($resultadoSeccionesIncorrectasOracionUsuarioDos) >0)
            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos incorrectos de la respuesta:</strong></h5>
                <p class="text-start mt-4">Los siguientes elementos de la respuesta son incorrectos.</p>

                <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach (array_unique($resultadoSeccionesIncorrectasOracionUsuarioDos) as $key=>$elemento)
                    <span id="seccionesIncorrectasOracionUsuarioDos" name="seccionesIncorrectasOracionUsuarioDos" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
        @endif

        <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
        @if (count($resultadoSignosIncorrectosUsuarioDos) > 0)

            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos ortográficos incorrectos:</strong></h5>
                <p class="text-start mt-4">Los siguientes elementos ortográficos incorrectos fueron encontrados en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSignosIncorrectosUsuarioDos as $elemento)
                    <span id="signosIncorrectosOracionUsuarioDos" name="signosIncorrectosOracionUsuarioDos" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>

        @endif


        <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
        NO PUSO EN SU RESPUESTA -->
        @if (count($resultadoSignosQueLeFaltaronAlUsuarioDos) > 0)

            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Signos de puntuación no encontrados en la respuesta:</strong></h5>
                <p class="text-start mt-4">Los siguientes signos de puntuación no fueron encontrados en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSignosQueLeFaltaronAlUsuarioDos as $elemento)
                    <span id="signosQueLeFaltaronAlUsuarioDos" name="signosQueLeFaltaronAlUsuarioDos" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
            
        @endif


        <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
        QUE ESTEN INCORRECTAS -->
        @if (count($resultadoSeccionesQueLeFaltaronAlUsuarioDos) > 0)
            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Secciones de la respuesta correcta no encontradas en la respuesta:</strong></h5>
                <p class="text-justify mt-4">Las siguientes secciones no se encontraron en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSeccionesQueLeFaltaronAlUsuarioDos as $elemento)
                    <span id="seccionesQueLeFaltaronAlUsuarioDos" name="seccionesQueLeFaltaronAlUsuarioDos" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
        @endif 
        

    </div>




    <!--//////////////////////////////////////////ORACION TRES -->


    <div class="container border border-dark rounded mb-5">
                
        <!-- TITULO -->
        <header class="px-5 py-4 border-bottom">
            <h2 class="text-red text-center"><strong>Revisión respuesta tres:</strong></h2>
        </header>
        <!-- OBSERVACION -->
        <div class="px-5 py-4 border-top border-bottom m-2">
            <h4 class="text-red mt-2 ml-4 mb-2"><strong>Observación:</strong></h4>
            <h4 class="text-center m-4">{{$respuestaOracionTres}}</h4>
        </div>


        <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA -->
        <!-- SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL -->
        <!-- EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO 
        LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL-->
        @if ($resultadooatres === 0.00)
            <!-- SI LA RESPUESTA DEL USUARIO ES INCORRECTA ENTONCES SE ENVIAN LOS SIGUIENTES DATOS -->

            <!-- LA RESPUESTA DEL USUARIO ORIGINAL SE MUESTRA MEDIANTE LA VARIABLE $stringSeccionesEnunciadoUsuarioUno QUE VA A MOSTRAR  
            DONDE EL USUARIO HA COLOCADO ESPACIOS DEMAS SI FUESE EL CASO-->
            <!-- ESTA SECCION SE PUEDE COMENTAR POR EL ELEMENTO $enunciadoUsuarioUno SI LUEGO NO QUIERO QUE SE MUESTREN LOS ESPACIOS AGREGADOS POR EL USUARIO-->
            
            <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
            <div class="row">
                <!-- RESPUESTA USUARIO -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-red pt-2 m-5"><strong>Respuesta usuario:</strong></h5>

                    <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                    MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->
                    @if ($existenEspaciosOracionTres)
                        <label class="h6 text-justify">Si la respuesta posee "_" dentro del enunciado, significa que agregó espacios adicionales entre palabras o signos.</label>
                        <h4 class="text-justify m-4"><strong>{{$stringSeccionesOracionUsuarioTres}}</strong></h4>
                        
                    @else
                    <h4 class="text-justify m-4"><strong>{{$stringSeccionesOracionUsuarioTres}}</strong></h4>
                    @endif
                    
                </div>
                <!-- RESPUESTA CORRECTA -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-red pt-2 m-5"><strong>Respuesta correcta:</strong></h5>
                    <h4 class="text-justify m-4"><strong>{{$oracionCorrectaTres}}</strong></h4>
                </div>
            </div>

            <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES -->
                    @if (($hayUnEspacioEnBlancoOracionTres === true) && (count($resultadoSignosIncorrectosUsuarioTres) === 0) &&
                        (count($resultadoSignosQueLeFaltaronAlUsuarioTres) === 0) && (count($resultadoSeccionesQueLeFaltaronAlUsuarioTres) === 0))
                        
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>

                        </div>  

                    @else

                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoOracionTres === true)
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>
                            
                            </div>
                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2">
                                    <strong>A continuación, puedes revisar los elementos incorrectos de la respuesta.</strong></h5>
                                <h5 class="text-center pt-2 mt-2 mb-2 ml-2">
                                    <strong>*Se han eliminado los espacios adicionales que agregó en la respuesta*</strong></h5>
                                
                            </div>
                        @else 

                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2">
                                    <strong>A continuación, puedes revisar los elementos incorrectos de la respuesta.</strong></h5>
                                
                            </div>

                        @endif
                        
                        <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de la respuesta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta tiene elementos marcados de color rojo, posee elementos incorrectos. Estos elementos son incorrectos por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">Ha agregado palabras incorrectas.</li>
                            <li class="text-start mt-4">Ha agregado signos de puntuación de forma incorrecta.</li>
                            <li class="text-start mt-4">Ha agregado una misma palabra más veces de las necesarias.</li>
                            <h4 id="oracionusuariotres" class="text-justify mt-4">{{$oracionUsuarioTres}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta contiene elementos marcados de color verde, dichos elementos hacen falta en la respuesta. Estos elementos no se han encontrado en la respuesta por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">La respuesta no contiene la palabra marcada.</li>
                            <li class="text-start mt-4">La respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                            <li class="text-start mt-4">La respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                            <li class="text-start mt-4">Ha omitido la palabra marcada en la respuesta.</li>
                            <h4 id="oracioncorrectatres" class="text-justify mt-4">{{$oracionCorrectaTres}}</h4>
                        </div>
                        
                    @endif

            <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
            {{--<div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de tu respuesta:</strong></h5>
                <p class="text-start mt-4">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                <h4 id="oracionusuariotres" class="text-justify mt-4">{{$oracionUsuarioTres}}</h4>
            </div>
            <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                <p class="text-start mt-4">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                <h4 id="oracioncorrectatres" class="text-justify mt-4">{{$oracionCorrectaTres}}</h4>
            </div>--}}
        
        @else 
            <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
            <!-- RESPUESTA DEL USUARIO -->

            <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
            <div class="row">
                <!-- RESPUESTA USUARIO -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta usuario:</strong></h5>
                    <h4 id="oracionusuariotres" class="text-justify mt-4"><strong>{{$oracionUsuarioTres}}</strong></h4>
                </div>
                <!-- RESPUESTA CORRECTA -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta correcta:</strong></h5>
                    <h4 id="oracioncorrectatres" class="text-justify mt-4"><strong>{{$oracionCorrectaTres}}</strong></h4>
                </div>
            </div>

        @endif

        <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
        EN LA RESPUESTA -->
        @if (count($resultadoSeccionesIncorrectasOracionUsuarioTres) >0)
            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos incorrectos de la respuesta:</strong></h5>
                <p class="text-start mt-4">Los siguientes elementos de la respuesta son incorrectos.</p>

                <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach (array_unique($resultadoSeccionesIncorrectasOracionUsuarioTres) as $key=>$elemento)
                    <span id="seccionesIncorrectasOracionUsuarioTres" name="seccionesIncorrectasOracionUsuarioTres" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
        @endif

        <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
        @if (count($resultadoSignosIncorrectosUsuarioTres) > 0)

            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos ortográficos incorrectos:</strong></h5>
                <p class="text-start mt-4">Los siguientes elementos ortográficos incorrectos fueron encontrados en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSignosIncorrectosUsuarioTres as $elemento)
                    <span id="signosIncorrectosOracionUsuarioTres" name="signosIncorrectosOracionUsuarioTres" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>

        @endif


        <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
        NO PUSO EN SU RESPUESTA -->
        @if (count($resultadoSignosQueLeFaltaronAlUsuarioTres) > 0)

            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Signos de puntuación no encontrados en la respuesta:</strong></h5>
                <p class="text-start mt-4">Los siguientes signos de puntuación no fueron encontrados en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSignosQueLeFaltaronAlUsuarioTres as $elemento)
                    <span id="signosQueLeFaltaronAlUsuarioTres" name="signosQueLeFaltaronAlUsuarioTres" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
            
        @endif


        <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
        QUE ESTEN INCORRECTAS -->
        @if (count($resultadoSeccionesQueLeFaltaronAlUsuarioTres) > 0)
            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Secciones de la respuesta correcta no encontradas en la respuesta:</strong></h5>
                <p class="text-justify mt-4">Las siguientes secciones no se encontraron en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSeccionesQueLeFaltaronAlUsuarioTres as $elemento)
                    <span id="seccionesQueLeFaltaronAlUsuarioTres" name="seccionesQueLeFaltaronAlUsuarioTres" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
        @endif 
        

    </div>





    <!--//////////////////////////////////////////ORACION CUATRO -->


    <div class="container border border-dark rounded mb-5">
                
        <!-- TITULO -->
        <header class="px-5 py-4 border-bottom">
            <h2 class="text-red text-center"><strong>Revisión respuesta cuatro:</strong></h2>
        </header>
        <!-- OBSERVACION -->
        <div class="px-5 py-4 border-top border-bottom m-2">
            <h4 class="text-red mt-2 ml-4 mb-2"><strong>Observación:</strong></h4>
            <h4 class="text-center m-4">{{$respuestaOracionCuatro}}</h4>
        </div>


        <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA -->
        <!-- SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL -->
        <!-- EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO 
        LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL-->
        @if ($resultadooacuatro === 0.00)
            <!-- SI LA RESPUESTA DEL USUARIO ES INCORRECTA ENTONCES SE ENVIAN LOS SIGUIENTES DATOS -->

            <!-- LA RESPUESTA DEL USUARIO ORIGINAL SE MUESTRA MEDIANTE LA VARIABLE $stringSeccionesEnunciadoUsuarioUno QUE VA A MOSTRAR  
            DONDE EL USUARIO HA COLOCADO ESPACIOS DEMAS SI FUESE EL CASO-->
            <!-- ESTA SECCION SE PUEDE COMENTAR POR EL ELEMENTO $enunciadoUsuarioUno SI LUEGO NO QUIERO QUE SE MUESTREN LOS ESPACIOS AGREGADOS POR EL USUARIO-->
            
            <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
            <div class="row">
                <!-- RESPUESTA USUARIO -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-red pt-2 m-5"><strong>Respuesta usuario:</strong></h5>

                    <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                    MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->
                    @if ($existenEspaciosOracionCuatro)
                        <label class="h6 text-justify">Si la respuesta posee "_" dentro del enunciado, significa que agregó espacios adicionales entre palabras o signos.</label>
                        <h4 class="text-justify m-4"><strong>{{$stringSeccionesOracionUsuarioCuatro}}</strong></h4>
                        
                    @else
                    <h4 class="text-justify m-4"><strong>{{$stringSeccionesOracionUsuarioCuatro}}</strong></h4>
                    @endif
                    
                </div>
                <!-- RESPUESTA CORRECTA -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-red pt-2 m-5"><strong>Respuesta correcta:</strong></h5>
                    <h4 class="text-justify m-4"><strong>{{$oracionCorrectaCuatro}}</strong></h4>
                </div>
            </div>

            <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES -->
                    @if (($hayUnEspacioEnBlancoOracionCuatro === true) && (count($resultadoSignosIncorrectosUsuarioCuatro) === 0) &&
                        (count($resultadoSignosQueLeFaltaronAlUsuarioCuatro) === 0) && (count($resultadoSeccionesQueLeFaltaronAlUsuarioCuatro) === 0))
                        
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>

                        </div>  

                    @else

                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoOracionCuatro === true)
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>
                            
                            </div>
                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2">
                                    <strong>A continuación, puedes revisar los elementos incorrectos de la respuesta.</strong></h5>
                                <h5 class="text-center pt-2 mt-2 mb-2 ml-2">
                                    <strong>*Se han eliminado los espacios adicionales que agregó en la respuesta*</strong></h5>
                                
                            </div>
                        @else 

                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2">
                                    <strong>A continuación, puedes revisar los elementos incorrectos de la respuesta.</strong></h5>
                                
                            </div>

                        @endif
                        
                        <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de la respuesta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta tiene elementos marcados de color rojo, posee elementos incorrectos. Estos elementos son incorrectos por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">Ha agregado palabras incorrectas.</li>
                            <li class="text-start mt-4">Ha agregado signos de puntuación de forma incorrecta.</li>
                            <li class="text-start mt-4">Ha agregado una misma palabra más veces de las necesarias.</li>
                            <h4 id="oracionusuariocuatro" class="text-justify mt-4">{{$oracionUsuarioCuatro}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta contiene elementos marcados de color verde, dichos elementos hacen falta en la respuesta. Estos elementos no se han encontrado en la respuesta por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">La respuesta no contiene la palabra marcada.</li>
                            <li class="text-start mt-4">La respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                            <li class="text-start mt-4">La respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                            <li class="text-start mt-4">Ha omitido la palabra marcada en la respuesta.</li>
                            <h4 id="oracioncorrectacuatro" class="text-justify mt-4">{{$oracionCorrectaCuatro}}</h4>
                        </div>
                        
                    @endif

            <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
            {{--<div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de tu respuesta:</strong></h5>
                <p class="text-start mt-4">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                <h4 id="oracionusuariocuatro" class="text-justify mt-4">{{$oracionUsuarioCuatro}}</h4>
            </div>
            <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                <p class="text-start mt-4">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                <h4 id="oracioncorrectacuatro" class="text-justify mt-4">{{$oracionCorrectaCuatro}}</h4>
            </div>--}}
        
        @else 
            <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
            <!-- RESPUESTA DEL USUARIO -->

            <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
            <div class="row">
                <!-- RESPUESTA USUARIO -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta usuario:</strong></h5>
                    <h4 id="oracionusuariocuatro" class="text-justify mt-4"><strong>{{$oracionUsuarioCuatro}}</strong></h4>
                </div>
                <!-- RESPUESTA CORRECTA -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta correcta:</strong></h5>
                    <h4 id="oracioncorrectacuatro" class="text-justify mt-4"><strong>{{$oracionCorrectaCuatro}}</strong></h4>
                </div>
            </div>

        @endif

        <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
        EN LA RESPUESTA -->
        @if (count($resultadoSeccionesIncorrectasOracionUsuarioCuatro) >0)
            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos incorrectos de la respuesta:</strong></h5>
                <p class="text-start mt-4">Los siguientes elementos de la respuesta son incorrectos.</p>

                <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach (array_unique($resultadoSeccionesIncorrectasOracionUsuarioCuatro) as $key=>$elemento)
                    <span id="seccionesIncorrectasOracionUsuarioCuatro" name="seccionesIncorrectasOracionUsuarioCuatro" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
        @endif

        <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
        @if (count($resultadoSignosIncorrectosUsuarioCuatro) > 0)

            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos ortográficos incorrectos:</strong></h5>
                <p class="text-start mt-4">Los siguientes elementos ortográficos incorrectos fueron encontrados en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSignosIncorrectosUsuarioCuatro as $elemento)
                    <span id="signosIncorrectosOracionUsuarioCuatro" name="signosIncorrectosOracionUsuarioCuatro" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>

        @endif


        <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
        NO PUSO EN SU RESPUESTA -->
        @if (count($resultadoSignosQueLeFaltaronAlUsuarioCuatro) > 0)

            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Signos de puntuación no encontrados en la respuesta:</strong></h5>
                <p class="text-start mt-4">Los siguientes signos de puntuación no fueron encontrados en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSignosQueLeFaltaronAlUsuarioCuatro as $elemento)
                    <span id="signosQueLeFaltaronAlUsuarioCuatro" name="signosQueLeFaltaronAlUsuarioCuatro" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
            
        @endif


        <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
        QUE ESTEN INCORRECTAS -->
        @if (count($resultadoSeccionesQueLeFaltaronAlUsuarioCuatro) > 0)
            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Secciones de la respuesta correcta no encontradas en la respuesta:</strong></h5>
                <p class="text-start mt-4">Las siguientes secciones no se encontraron en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSeccionesQueLeFaltaronAlUsuarioCuatro as $elemento)
                    <span id="seccionesQueLeFaltaronAlUsuarioCuatro" name="seccionesQueLeFaltaronAlUsuarioCuatro" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
        @endif 
        

    </div>



    <!--//////////////////////////////////////////ORACION CINCO -->


    <div class="container border border-dark rounded mb-5">
                
        <!-- TITULO -->
        <header class="px-5 py-4 border-bottom">
            <h2 class="text-red text-center"><strong>Revisión respuesta cinco:</strong></h2>
        </header>
        <!-- OBSERVACION -->
        <div class="px-5 py-4 border-top border-bottom m-2">
            <h4 class="text-red mt-2 ml-4 mb-2"><strong>Observación:</strong></h4>
            <h4 class="text-center m-4">{{$respuestaOracionCinco}}</h4>
        </div>


        <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA -->
        <!-- SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL -->
        <!-- EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO 
        LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL-->
        @if ($resultadooacinco === 0.00)
            <!-- SI LA RESPUESTA DEL USUARIO ES INCORRECTA ENTONCES SE ENVIAN LOS SIGUIENTES DATOS -->

            <!-- LA RESPUESTA DEL USUARIO ORIGINAL SE MUESTRA MEDIANTE LA VARIABLE $stringSeccionesEnunciadoUsuarioUno QUE VA A MOSTRAR  
            DONDE EL USUARIO HA COLOCADO ESPACIOS DEMAS SI FUESE EL CASO-->
            <!-- ESTA SECCION SE PUEDE COMENTAR POR EL ELEMENTO $enunciadoUsuarioUno SI LUEGO NO QUIERO QUE SE MUESTREN LOS ESPACIOS AGREGADOS POR EL USUARIO-->
            
            <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
            <div class="row">
                <!-- RESPUESTA USUARIO -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-red pt-2 m-5"><strong>Respuesta usuario:</strong></h5>

                    <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                    MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->
                    @if ($existenEspaciosOracionCinco)
                        <label class="h6 text-justify">Si la respuesta posee "_" dentro del enunciado, significa que agregó espacios adicionales entre palabras o signos.</label>
                        <h4 class="text-justify m-4"><strong>{{$stringSeccionesOracionUsuarioCinco}}</strong></h4>
                        
                    @else
                    <h4 class="text-justify m-4"><strong>{{$stringSeccionesOracionUsuarioCinco}}</strong></h4>
                    @endif
                    
                </div>
                <!-- RESPUESTA CORRECTA -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-red pt-2 m-5"><strong>Respuesta correcta:</strong></h5>
                    <h4 class="text-justify m-4"><strong>{{$oracionCorrectaCinco}}</strong></h4>
                </div>
            </div>

            <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES -->
                    @if (($hayUnEspacioEnBlancoOracionCinco === true) && (count($resultadoSignosIncorrectosUsuarioCinco) === 0) &&
                        (count($resultadoSignosQueLeFaltaronAlUsuarioCinco) === 0) && (count($resultadoSeccionesQueLeFaltaronAlUsuarioCinco) === 0))
                        
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>

                        </div>  

                    @else

                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoOracionCinco === true)
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>
                            
                            </div>
                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2">
                                    <strong>A continuación, puedes revisar los elementos incorrectos de la respuesta.</strong></h5>
                                <h5 class="text-center pt-2 mt-2 mb-2 ml-2">
                                    <strong>*Se han eliminado los espacios adicionales que agregó en la respuesta*</strong></h5>
                                
                            </div>
                        @else 

                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2">
                                    <strong>A continuación, puedes revisar los elementos incorrectos de la respuesta.</strong></h5>
                                
                            </div>

                        @endif
                        
                        <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de la respuesta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta tiene elementos marcados de color rojo, posee elementos incorrectos. Estos elementos son incorrectos por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">Ha agregado palabras incorrectas.</li>
                            <li class="text-start mt-4">Ha agregado signos de puntuación de forma incorrecta.</li>
                            <li class="text-start mt-4">Ha agregado una misma palabra más veces de las necesarias.</li>
                            <h4 id="oracionusuariocinco" class="text-justify mt-4">{{$oracionUsuarioCinco}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta contiene elementos marcados de color verde, dichos elementos hacen falta en la respuesta. Estos elementos no se han encontrado en la respuesta por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">La respuesta no contiene la palabra marcada.</li>
                            <li class="text-start mt-4">La respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                            <li class="text-start mt-4">La respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                            <li class="text-start mt-4">Ha omitido la palabra marcada en la respuesta.</li>
                            <h4 id="oracioncorrectacinco" class="text-justify mt-4">{{$oracionCorrectaCinco}}</h4>
                        </div>
                        
                    @endif


            <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
            {{--<div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de tu respuesta:</strong></h5>
                <p class="text-start mt-4">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                <h4 id="oracionusuariocinco" class="text-justify mt-4">{{$oracionUsuarioCinco}}</h4>
            </div>
            <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                <p class="text-start mt-4">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                <h4 id="oracioncorrectacinco" class="text-justify mt-4">{{$oracionCorrectaCinco}}</h4>
            </div>--}}
        
        @else 
            <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
            <!-- RESPUESTA DEL USUARIO -->

            <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
            <div class="row">
                <!-- RESPUESTA USUARIO -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta usuario:</strong></h5>
                    <h4 id="oracionusuariocinco" class="text-justify mt-4"><strong>{{$oracionUsuarioCinco}}</strong></h4>
                </div>
                <!-- RESPUESTA CORRECTA -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta correcta:</strong></h5>
                    <h4 id="oracioncorrectacinco" class="text-justify mt-4"><strong>{{$oracionCorrectaCinco}}</strong></h4>
                </div>
            </div>

        @endif

        <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
        EN LA RESPUESTA -->
        @if (count($resultadoSeccionesIncorrectasOracionUsuarioCinco) >0)
            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos incorrectos de la respuesta:</strong></h5>
                <p class="text-start mt-4">Los siguientes elementos de la respuesta son incorrectos.</p>

                <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach (array_unique($resultadoSeccionesIncorrectasOracionUsuarioCinco) as $key=>$elemento)
                    <span id="seccionesIncorrectasOracionUsuarioCinco" name="seccionesIncorrectasOracionUsuarioCinco" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
        @endif

        <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
        @if (count($resultadoSignosIncorrectosUsuarioCinco) > 0)

            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos ortográficos incorrectos:</strong></h5>
                <p class="text-start mt-4">Los siguientes elementos ortográficos incorrectos fueron encontrados en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSignosIncorrectosUsuarioCinco as $elemento)
                    <span id="signosIncorrectosOracionUsuarioCinco" name="signosIncorrectosOracionUsuarioCinco" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>

        @endif


        <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
        NO PUSO EN SU RESPUESTA -->
        @if (count($resultadoSignosQueLeFaltaronAlUsuarioCinco) > 0)

            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Signos de puntuación no encontrados en la respuesta:</strong></h5>
                <p class="text-start mt-4">Los siguientes signos de puntuación no fueron encontrados en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSignosQueLeFaltaronAlUsuarioCinco as $elemento)
                    <span id="signosQueLeFaltaronAlUsuarioCinco" name="signosQueLeFaltaronAlUsuarioCinco" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
            
        @endif


        <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
        QUE ESTEN INCORRECTAS -->
        @if (count($resultadoSeccionesQueLeFaltaronAlUsuarioCinco) > 0)
            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Secciones de la respuesta correcta no encontradas en la respuesta:</strong></h5>
                <p class="text-justify mt-4">Las siguientes secciones no se encontraron en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoSeccionesQueLeFaltaronAlUsuarioCinco as $elemento)
                    <span id="seccionesQueLeFaltaronAlUsuarioCinco" name="seccionesQueLeFaltaronAlUsuarioCinco" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
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
        <li class="h5 mb-5 text-justify">Adicionalmente, se presentan algunas aclaraciones sobre la actividad.</li>
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





<!-- //////////////////////////////////////////////////FIN NUEVA VISTA ADMIN RESULTADOS PREGUNTA OA////////////////////////////////// -->






@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>

    <!-- SCRIPT JUEGO -->
    <script src="{{asset('/js/resaltaroaadmin.js')}}"></script>
@stop