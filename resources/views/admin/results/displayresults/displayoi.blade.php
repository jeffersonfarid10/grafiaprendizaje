@extends('adminlte::page')

@section('title', 'Resultado pregunta')

@section('content_header')
    <h1>Resultado pregunta</h1>
@stop

@section('content')
    
<!-- //////////////////////////////////////////////////////NUEVA VISTA ADMIN RESULTADOS OI/////////////////////////// -->

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
        <p class="h2 mb-5 text-justify">A continuación, puedes ver en detalle la revisión de cada una de las respuestas</p>
    </div>




    <!-- ////////////////////////////////////////////REVISIONES DETALLADAS DE CADA RESPUESTA DEL USUARIO -->


    <!-- //////////////////////////////////////////////ORACION UNO -->
    <div class="container border border-dark rounded mb-5">
                
        <!-- TITULO -->
        <header class="px-5 py-4 border-bottom">
            <h2 class="text-red text-center"><strong>Revisión respuesta uno:</strong></h2>
        </header>
        <!-- OBSERVACION -->
        <div class="px-5 py-4 border-top border-bottom m-2">
            <h4 class="text-red mt-2 ml-4 mb-2"><strong>Observación:</strong></h4>
            <h4 class="text-center m-4">{{$respuestaEnunciadoUno}}</h4>
        </div>


        <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA -->
        <!-- SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL -->
        <!-- EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO 
        LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL-->
        @if ($resultadooiuno === 0.00)
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
                    @if ($existenEspaciosEnunciadoUno)
                        <label class="h6 text-justify">Si la respuesta posee "_" dentro del enunciado, significa que agregó espacios adicionales entre palabras o signos.</label>
                        <h4 class="text-justify m-4"><strong>{{$stringSeccionesEnunciadoUsuarioUno}}</strong></h4>
                        
                    @else
                    <h4 class="text-justify m-4"><strong>{{$stringSeccionesEnunciadoUsuarioUno}}</strong></h4>
                    @endif
                    
                </div>
                <!-- RESPUESTA CORRECTA -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-red pt-2 m-5"><strong>Respuesta correcta:</strong></h5>
                    <h4 class="text-justify m-4"><strong>{{$enunciadoCorrectoUno}}</strong></h4>
                </div>
            </div>

            <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA 
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES-->
                    @if (($hayUnEspacioEnBlancoEnunciadoUno === true) && 
                        (count($resultadoEnunciadoSignosIncorrectosUsuarioUno) === 0) && (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioUno) === 0) &&
                        (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioUno) === 0))
                        
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>
                        
                        </div>  
                    @else
                        
                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoUno === true)
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
                            <h4 id="enunciadousuariouno" class="text-justify mt-4">{{$enunciadoUsuarioUno}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta contiene elementos marcados de color verde, dichos elementos hacen falta en la respuesta. Estos elementos no se han encontrado en la respuesta por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">La respuesta no contiene la palabra marcada.</li>
                            <li class="text-start mt-4">La respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                            <li class="text-start mt-4">La respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                            <li class="text-start mt-4">Ha omitido la palabra marcada en la respuesta.</li>
                            <h4 id="enunciadocorrectouno" class="text-justify mt-4">{{$enunciadoCorrectoUno}}</h4>
                        </div>

                    @endif

            <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
            {{--<div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de tu respuesta:</strong></h5>
                <p class="text-start mt-4">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                <h4 id="enunciadousuariouno" class="text-justify mt-4">{{$enunciadoUsuarioUno}}</h4>
            </div>
            <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                <p class="text-start mt-4">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                <h4 id="enunciadocorrectouno" class="text-justify mt-4">{{$enunciadoCorrectoUno}}</h4>
            </div>--}}
        
        @else 
            <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
            <!-- RESPUESTA DEL USUARIO -->

            <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
            <div class="row">
                <!-- RESPUESTA USUARIO -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta usuario:</strong></h5>
                    <h4 id="enunciadousuariouno" class="text-justify mt-4"><strong>{{$enunciadoUsuarioUno}}</strong></h4>
                </div>
                <!-- RESPUESTA CORRECTA -->
                <div class="col-12 col-md-6 border">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta correcta:</strong></h5>
                    <h4 id="enunciadocorrectouno" class="text-justify mt-4"><strong>{{$enunciadoCorrectoUno}}</strong></h4>
                </div>
            </div>

        @endif

        <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
        EN LA RESPUESTA -->
        @if (count($resultadoSeccionesIncorrectasEnunciadoUsuarioUno) >0)
            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos incorrectos de la respuesta:</strong></h5>
                <p class="text-start mt-4">Los siguientes elementos de la respuesta son incorrectos.</p>

                <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach (array_unique($resultadoSeccionesIncorrectasEnunciadoUsuarioUno) as $key=>$elemento)
                    <span id="seccionesIncorrectasEnunciadoUsuarioUno" name="seccionesIncorrectasEnunciadoUsuarioUno" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
        @endif

        <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
        @if (count($resultadoEnunciadoSignosIncorrectosUsuarioUno) > 0)

            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos ortográficos incorrectos:</strong></h5>
                <p class="text-start mt-4">Los siguientes elementos ortográficos incorrectos fueron encontrados en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoEnunciadoSignosIncorrectosUsuarioUno as $elemento)
                    <span id="signosIncorrectosEnunciadoUsuarioUno" name="signosIncorrectosEnunciadoUsuarioUno" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>

        @endif


        <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
        NO PUSO EN SU RESPUESTA -->
        @if (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioUno) > 0)

            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Signos de puntuación no encontrados en la respuesta:</strong></h5>
                <p class="text-start mt-4">Los siguientes signos de puntuación no fueron encontrados en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioUno as $elemento)
                    <span id="signosQueLeFaltaronAlUsuarioUno" name="signosQueLeFaltaronAlUsuarioUno" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    
                @endforeach
                
            </div>
            
        @endif


        <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
        <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
        QUE ESTEN INCORRECTAS -->
        @if (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioUno) > 0)
            <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
            <div class="px-5 py-4 border-top border-bottom m-2">
                <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Secciones de la respuesta correcta no encontradas en la respuesta del usuario:</strong></h5>
                <p class="mt-4 text-justify">Las siguientes secciones no se encontraron en la respuesta.</p>

                
                <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                @foreach ($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioUno as $elemento)
                    <span id="signosQueLeFaltaronAlUsuarioUno" name="signosQueLeFaltaronAlUsuarioUno" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
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
                <h4 class="text-center m-4"><strong>{{$respuestaEnunciadoDos}}</strong></h4>
            </div>


            <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA -->
            <!-- SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL -->
            <!-- EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO 
            LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL-->
            @if ($resultadooidos === 0.00)
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
                        @if ($existenEspaciosEnunciadoDos)
                            <label class="h6 text-justify">Si la respuesta posee "_" dentro del enunciado, significa que agregó espacios adicionales entre palabras o signos.</label>
                            <h4 class="text-justify m-4"><strong>{{$stringSeccionesEnunciadoUsuarioDos}}</strong></h4>
                            
                        @else
                        <h4 class="text-justify m-4"><strong>{{$stringSeccionesEnunciadoUsuarioDos}}</strong></h4>
                        @endif
                        
                    </div>
                    <!-- RESPUESTA CORRECTA -->
                    <div class="col-12 col-md-6 border">
                        <h5 class="text-red pt-2 m-5"><strong>Respuesta correcta:</strong></h5>
                        <h4 class="text-justify m-4"><strong>{{$enunciadoCorrectoDos}}</strong></h4>
                    </div>
                </div>

                <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA 
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES-->
                    @if (($hayUnEspacioEnBlancoEnunciadoDos === true) && 
                        (count($resultadoEnunciadoSignosIncorrectosUsuarioDos) === 0) && (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioDos) === 0) &&
                        (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioDos) === 0))
                        
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>
                        
                        </div>  
                    @else
                        
                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoDos === true)
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
                            <h4 id="enunciadousuariodos" class="text-justify mt-4">{{$enunciadoUsuarioDos}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta contiene elementos marcados de color verde, dichos elementos hacen falta en la respuesta. Estos elementos no se han encontrado en la respuesta por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">La respuesta no contiene la palabra marcada.</li>
                            <li class="text-start mt-4">La respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                            <li class="text-start mt-4">La respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                            <li class="text-start mt-4">Ha omitido la palabra marcada en la respuesta.</li>
                            <h4 id="enunciadocorrectodos" class="text-justify mt-4">{{$enunciadoCorrectoDos}}</h4>
                        </div>

                    @endif

                <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                {{--<div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de tu respuesta:</strong></h5>
                    <p class="text-start mt-4">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                    <h4 id="enunciadousuariodos" class="text-justify mt-4">{{$enunciadoUsuarioDos}}</h4>
                </div>
                <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                    <p class="text-start mt-4">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                    <h4 id="enunciadocorrectodos" class="text-justify mt-4">{{$enunciadoCorrectoDos}}</h4>
                </div>--}}
            
            @else 
                <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
                <!-- RESPUESTA DEL USUARIO -->

                <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
                <div class="row">
                    <!-- RESPUESTA USUARIO -->
                    <div class="col-12 col-md-6 border">
                        <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta usuario:</strong></h5>
                        <h4 id="enunciadousuariodos" class="text-justify mt-4"><strong>{{$enunciadoUsuarioDos}}</strong></h4>
                    </div>
                    <!-- RESPUESTA CORRECTA -->
                    <div class="col-12 col-md-6 border">
                        <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta correcta:</strong></h5>
                        <h4 id="enunciadocorrectodos" class="text-justify mt-4"><strong>{{$enunciadoCorrectoDos}}</strong></h4>
                    </div>
                </div>

            @endif

            <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
            EN LA RESPUESTA -->
            @if (count($resultadoSeccionesIncorrectasEnunciadoUsuarioDos) >0)
                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos incorrectos de la respuesta:</strong></h5>
                    <p class="text-start mt-4">Los siguientes elementos de la respuesta son incorrectos.</p>

                    <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                    DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                    <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach (array_unique($resultadoSeccionesIncorrectasEnunciadoUsuarioDos) as $key=>$elemento)
                        <span id="seccionesIncorrectasEnunciadoUsuarioDos" name="seccionesIncorrectasEnunciadoUsuarioDos" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                        <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                        
                    @endforeach
                    
                </div>
            @endif

            <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosIncorrectosUsuarioDos) > 0)

                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos ortográficos incorrectos:</strong></h5>
                    <p class="text-start mt-4">Los siguientes elementos ortográficos incorrectos fueron encontrados en la respuesta.</p>

                    
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach ($resultadoEnunciadoSignosIncorrectosUsuarioDos as $elemento)
                        <span id="signosIncorrectosEnunciadoUsuarioDos" name="signosIncorrectosEnunciadoUsuarioDos" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                        <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                        
                    @endforeach
                    
                </div>

            @endif


            <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
            NO PUSO EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioDos) > 0)

                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Signos de puntuación no encontrados en la respuesta:</strong></h5>
                    <p class="text-start mt-4">Los siguientes signos de puntuación no fueron encontrados en la respuesta.</p>

                    
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach ($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioDos as $elemento)
                        <span id="signosQueLeFaltaronAlUsuarioDos" name="signosQueLeFaltaronAlUsuarioDos" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                        <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                        
                    @endforeach
                    
                </div>
                
            @endif


            <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
            QUE ESTEN INCORRECTAS -->
            @if (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioDos) > 0)
                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Secciones de la respuesta correcta no encontradas en tu respuesta:</strong></h5>
                    <p class="text-start mt-4">Las siguientes secciones no se encontraron en la respuesta.</p>

                    
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach ($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioDos as $elemento)
                        <span id="signosQueLeFaltaronAlUsuarioDos" name="signosQueLeFaltaronAlUsuarioDos" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
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
                <h4 class="text-center m-4">{{$respuestaEnunciadoTres}}</h4>
            </div>


            <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA -->
            <!-- SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL -->
            <!-- EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO 
            LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL-->
            @if ($resultadooitres === 0.00)
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
                        @if ($existenEspaciosEnunciadoTres)
                            <label class="h6 text-justify">Si la respuesta posee "_" dentro del enunciado, significa que agregó espacios adicionales entre palabras o signos.</label>
                            <h4 class="text-justify m-4"><strong>{{$stringSeccionesEnunciadoUsuarioTres}}</strong></h4>
                            
                        @else
                        <h4 class="text-justify m-4"><strong>{{$stringSeccionesEnunciadoUsuarioTres}}</strong></h4>
                        @endif
                        
                    </div>
                    <!-- RESPUESTA CORRECTA -->
                    <div class="col-12 col-md-6 border">
                        <h5 class="text-red pt-2 m-5"><strong>Respuesta correcta:</strong></h5>
                        <h4 class="text-justify m-4"><strong>{{$enunciadoCorrectoTres}}</strong></h4>
                    </div>
                </div>

                <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA 
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES-->
                    @if (($hayUnEspacioEnBlancoEnunciadoTres === true) && 
                        (count($resultadoEnunciadoSignosIncorrectosUsuarioTres) === 0) && (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioTres) === 0) &&
                        (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioTres) === 0))
                        
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>
                        
                        </div>  
                    @else
                        
                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoTres === true)
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
                            <h4 id="enunciadousuariotres" class="text-justify mt-4">{{$enunciadoUsuarioTres}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta contiene elementos marcados de color verde, dichos elementos hacen falta en la respuesta. Estos elementos no se han encontrado en la respuesta por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">La respuesta no contiene la palabra marcada.</li>
                            <li class="text-start mt-4">La respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                            <li class="text-start mt-4">La respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                            <li class="text-start mt-4">Ha omitido la palabra marcada en la respuesta.</li>
                            <h4 id="enunciadocorrectotres" class="text-justify mt-4">{{$enunciadoCorrectoTres}}</h4>
                        </div>

                    @endif

                <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                {{--<div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de tu respuesta:</strong></h5>
                    <p class="text-start mt-4">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                    <h4 id="enunciadousuariotres" class="text-justify mt-4">{{$enunciadoUsuarioTres}}</h4>
                </div>
                <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                    <p class="text-start mt-4">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                    <h4 id="enunciadocorrectotres" class="text-justify mt-4">{{$enunciadoCorrectoTres}}</h4>
                </div>--}}
            
            @else 
                <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
                <!-- RESPUESTA DEL USUARIO -->

                <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
                <div class="row">
                    <!-- RESPUESTA USUARIO -->
                    <div class="col-12 col-md-6 border">
                        <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta usuario:</strong></h5>
                        <h4 id="enunciadousuariotres" class="text-justify mt-4"><strong>{{$enunciadoUsuarioTres}}</strong></h4>
                    </div>
                    <!-- RESPUESTA CORRECTA -->
                    <div class="col-12 col-md-6 border">
                        <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta correcta:</strong></h5>
                        <h4 id="enunciadocorrectotres" class="text-justify mt-4"><strong>{{$enunciadoCorrectoTres}}</strong></h4>
                    </div>
                </div>

            @endif

            <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
            EN LA RESPUESTA -->
            @if (count($resultadoSeccionesIncorrectasEnunciadoUsuarioTres) >0)
                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos incorrectos de la respuesta:</strong></h5>
                    <p class="text-start mt-4">Los siguientes elementos de la respuesta son incorrectos.</p>

                    <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                    DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                    <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach (array_unique($resultadoSeccionesIncorrectasEnunciadoUsuarioTres) as $key=>$elemento)
                        <span id="seccionesIncorrectasEnunciadoUsuarioTres" name="seccionesIncorrectasEnunciadoUsuarioTres" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                        <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                        
                    @endforeach
                    
                </div>
            @endif

            <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosIncorrectosUsuarioTres) > 0)

                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos ortográficos incorrectos:</strong></h5>
                    <p class="text-start mt-4">Los siguientes elementos ortográficos incorrectos fueron encontrados en la respuesta.</p>

                    
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach ($resultadoEnunciadoSignosIncorrectosUsuarioTres as $elemento)
                        <span id="signosIncorrectosEnunciadoUsuarioTres" name="signosIncorrectosEnunciadoUsuarioTres" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                        <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                        
                    @endforeach
                    
                </div>

            @endif


            <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
            NO PUSO EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioTres) > 0)

                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Signos de puntuación no encontrados en la respuesta:</strong></h5>
                    <p class="text-start mt-4">Los siguientes signos de puntuación no fueron encontrados en la respuesta.</p>

                    
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach ($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioTres as $elemento)
                        <span id="signosQueLeFaltaronAlUsuarioTres" name="signosQueLeFaltaronAlUsuarioTres" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                        <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                        
                    @endforeach
                    
                </div>
                
            @endif


            <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
            QUE ESTEN INCORRECTAS -->
            @if (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioTres) > 0)
                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Secciones de la respuesta correcta no encontradas en la respuesta:</strong></h5>
                    <p class="text-justify mt-4">Las siguientes secciones no se encontraron en la respuesta.</p>

                    
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach ($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioTres as $elemento)
                        <span id="signosQueLeFaltaronAlUsuarioTres" name="signosQueLeFaltaronAlUsuarioTres" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
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
                <h4 class="text-center m-4">{{$respuestaEnunciadoCuatro}}</h4>
            </div>


            <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA -->
            <!-- SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL -->
            <!-- EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO 
            LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL-->
            @if ($resultadooicuatro === 0.00)
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
                        @if ($existenEspaciosEnunciadoTres)
                            <label class="h6 text-justify">Si la respuesta posee "_" dentro del enunciado, significa que agregó espacios adicionales entre palabras o signos.</label>
                            <h4 class="text-justify m-4"><strong>{{$stringSeccionesEnunciadoUsuarioCuatro}}</strong></h4>
                            
                        @else
                        <h4 class="text-justify m-4"><strong>{{$stringSeccionesEnunciadoUsuarioCuatro}}</strong></h4>
                        @endif
                        
                    </div>
                    <!-- RESPUESTA CORRECTA -->
                    <div class="col-12 col-md-6 border">
                        <h5 class="text-red pt-2 m-5"><strong>Respuesta correcta:</strong></h5>
                        <h4 class="text-justify m-4"><strong>{{$enunciadoCorrectoCuatro}}</strong></h4>
                    </div>
                </div>

                
                <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA 
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES-->
                    @if (($hayUnEspacioEnBlancoEnunciadoCuatro === true) && 
                        (count($resultadoEnunciadoSignosIncorrectosUsuarioCuatro) === 0) && (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCuatro) === 0) &&
                        (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCuatro) === 0))
                        
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>
                        
                        </div>  
                    @else
                        
                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoCuatro === true)
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
                            <h4 id="enunciadousuariocuatro" class="text-justify mt-4">{{$enunciadoUsuarioCuatro}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta contiene elementos marcados de color verde, dichos elementos hacen falta en la respuesta. Estos elementos no se han encontrado en la respuesta por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">La respuesta no contiene la palabra marcada.</li>
                            <li class="text-start mt-4">La respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                            <li class="text-start mt-4">La respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                            <li class="text-start mt-4">Ha omitido la palabra marcada en la respuesta.</li>
                            <h4 id="enunciadocorrectocuatro" class="text-justify mt-4">{{$enunciadoCorrectoCuatro}}</h4>
                        </div>

                    @endif


                <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                {{--<div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de tu respuesta:</strong></h5>
                    <p class="text-start mt-4">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                    <h4 id="enunciadousuariocuatro" class="text-justify mt-4">{{$enunciadoUsuarioCuatro}}</h4>
                </div>
                <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                    <p class="text-start mt-4">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                    <h4 id="enunciadocorrectocuatro" class="text-justify mt-4">{{$enunciadoCorrectoCuatro}}</h4>
                </div>--}}
            
            @else 
                <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
                <!-- RESPUESTA DEL USUARIO -->

                <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
                <div class="row">
                    <!-- RESPUESTA USUARIO -->
                    <div class="col-12 col-md-6 border">
                        <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta usuario:</strong></h5>
                        <h4 id="enunciadousuariocuatro" class="text-justify mt-4"><strong>{{$enunciadoUsuarioCuatro}}</strong></h4>
                    </div>
                    <!-- RESPUESTA CORRECTA -->
                    <div class="col-12 col-md-6 border">
                        <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta correcta:</strong></h5>
                        <h4 id="enunciadocorrectocuatro" class="text-justify mt-4"><strong>{{$enunciadoCorrectoCuatro}}</strong></h4>
                    </div>
                </div>

            @endif

            <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
            EN LA RESPUESTA -->
            @if (count($resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro) >0)
                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos incorrectos de la respuesta:</strong></h5>
                    <p class="text-start mt-4">Los siguientes elementos de la respuesta son incorrectos.</p>

                    <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                    DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                    <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach (array_unique($resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro) as $key=>$elemento)
                        <span id="seccionesIncorrectasEnunciadoUsuarioCuatro" name="seccionesIncorrectasEnunciadoUsuarioCuatro" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                        <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                        
                    @endforeach
                    
                </div>
            @endif

            <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosIncorrectosUsuarioCuatro) > 0)

                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos ortográficos incorrectos:</strong></h5>
                    <p class="text-start mt-4">Los siguientes elementos ortográficos incorrectos fueron encontrados en la respuesta.</p>

                    
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach ($resultadoEnunciadoSignosIncorrectosUsuarioCuatro as $elemento)
                        <span id="signosIncorrectosEnunciadoUsuarioCuatro" name="signosIncorrectosEnunciadoUsuarioCuatro" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                        <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> |</strong></span>
                        
                    @endforeach
                    
                </div>

            @endif


            <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
            NO PUSO EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCuatro) > 0)

                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Signos de puntuación no encontrados en la respuesta:</strong></h5>
                    <p class="text-start mt-4">Los siguientes signos de puntuación no fueron encontrados en la respuesta.</p>

                    
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach ($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCuatro as $elemento)
                        <span id="signosQueLeFaltaronAlUsuarioCuatro" name="signosQueLeFaltaronAlUsuarioCuatro" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                        <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                        
                    @endforeach
                    
                </div>
                
            @endif


            <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
            QUE ESTEN INCORRECTAS -->
            @if (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCuatro) > 0)
                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Secciones de la respuesta correcta no encontradas en la respuesta:</strong></h5>
                    <p class="text-justify mt-4">Las siguientes secciones no se encontraron en la respuesta.</p>

                    
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach ($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCuatro as $elemento)
                        <span id="signosQueLeFaltaronAlUsuarioCuatro" name="signosQueLeFaltaronAlUsuarioCuatro" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
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
                <h4 class="text-center m-4">{{$respuestaEnunciadoCinco}}</h4>
            </div>


            <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA -->
            <!-- SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL -->
            <!-- EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO 
            LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL-->
            @if ($resultadooicinco === 0.00)
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
                        @if ($existenEspaciosEnunciadoTres)
                            <label class="h6 text-justify">Si la respuesta posee "_" dentro del enunciado, significa que agregó espacios adicionales entre palabras o signos.</label>
                            <h4 class="text-justify m-4"><strong>{{$stringSeccionesEnunciadoUsuarioCinco}}</strong></h4>
                            
                        @else
                        <h4 class="text-justify m-4"><strong>{{$stringSeccionesEnunciadoUsuarioCinco}}</strong></h4>
                        @endif
                        
                    </div>
                    <!-- RESPUESTA CORRECTA -->
                    <div class="col-12 col-md-6 border">
                        <h5 class="text-red pt-2 m-5"><strong>Respuesta correcta:</strong></h5>
                        <h4 class="text-justify m-4"><strong>{{$enunciadoCorrectoCinco}}</strong></h4>
                    </div>
                </div>


                <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA 
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES-->
                    @if (($hayUnEspacioEnBlancoEnunciadoCinco === true) && 
                        (count($resultadoEnunciadoSignosIncorrectosUsuarioCinco) === 0) && (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCinco) === 0) &&
                        (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCinco) === 0))
                        
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>
                        
                        </div>  
                    @else
                        
                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoCinco === true)
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisa la respuesta original del usuario. Se ha agregado espacios en blanco adicionales "_" en la respuesta.</strong></h5>
                            
                            </div>
                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="px-5 py-4 border-top border-bottom m-2">
                                <h5 class="text-center text-red pt-2 mt-2 mb-2 ml-2">
                                    <strong>A continuación, puedes revisar los elementos incorrectos de la respuesta.</strong></h5>
                                <h5 class="text-center pt-2 mt-2 mb-2 ml-2">
                                    <strong>*Se han eliminado los espacios adicionales que agregaste en la respuesta*.</strong></h5>
                                
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
                            <h4 id="enunciadousuariocinco" class="text-justify mt-4">{{$enunciadoUsuarioCinco}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="px-5 py-4 border-top border-bottom m-2">
                            <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                            <p class="text-start mt-4">Si la respuesta contiene elementos marcados de color verde, dichos elementos hacen falta en la respuesta. Estos elementos no se han encontrado en la respuesta por alguna de las siguientes razones:</p>
                            <li class="text-start mt-4">La respuesta no contiene la palabra marcada.</li>
                            <li class="text-start mt-4">La respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                            <li class="text-start mt-4">La respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                            <li class="text-start mt-4">Ha omitido la palabra marcada en la respuesta.</li>
                            <h4 id="enunciadocorrectocinco" class="text-justify mt-4">{{$enunciadoCorrectoCinco}}</h4>
                        </div>

                    @endif


                <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                {{--<div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Revisión de tu respuesta:</strong></h5>
                    <p class="text-start mt-4">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                    <h4 id="enunciadousuariocinco" class="text-justify mt-4">{{$enunciadoUsuarioCinco}}</h4>
                </div>
                <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Comparación con la respuesta correcta:</strong></h5>
                    <p class="text-start mt-4">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                    <h4 id="enunciadocorrectocinco" class="text-justify mt-4">{{$enunciadoCorrectoCinco}}</h4>
                </div>--}}
            
            @else 
                <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
                <!-- RESPUESTA DEL USUARIO -->

                <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
                <div class="row">
                    <!-- RESPUESTA USUARIO -->
                    <div class="col-12 col-md-6 border">
                        <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta usuario:</strong></h5>
                        <h4 id="enunciadousuariocinco" class="text-justify mt-4"><strong>{{$enunciadoUsuarioCinco}}</strong></h4>
                    </div>
                    <!-- RESPUESTA CORRECTA -->
                    <div class="col-12 col-md-6 border">
                        <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Respuesta correcta:</strong></h5>
                        <h4 id="enunciadocorrectocinco" class="text-justify mt-4"><strong>{{$enunciadoCorrectoCinco}}</strong></h4>
                    </div>
                </div>

            @endif

            <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
            EN LA RESPUESTA -->
            @if (count($resultadoSeccionesIncorrectasEnunciadoUsuarioCinco) >0)
                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos incorrectos de la respuesta:</strong></h5>
                    <p class="text-start mt-4">Los siguientes elementos de la respuesta son incorrectos.</p>

                    <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                    DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                    <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach (array_unique($resultadoSeccionesIncorrectasEnunciadoUsuarioCinco) as $key=>$elemento)
                        <span id="seccionesIncorrectasEnunciadoUsuarioCinco" name="seccionesIncorrectasEnunciadoUsuarioCinco" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                        <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                        
                    @endforeach
                    
                </div>
            @endif

            <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosIncorrectosUsuarioCinco) > 0)

                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Elementos ortográficos incorrectos:</strong></h5>
                    <p class="text-start mt-4">Los siguientes elementos ortográficos incorrectos fueron encontrados en la respuesta.</p>

                    
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach ($resultadoEnunciadoSignosIncorrectosUsuarioCinco as $elemento)
                        <span id="signosIncorrectosEnunciadoUsuarioCinco" name="signosIncorrectosEnunciadoUsuarioCinco" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                        <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                        
                    @endforeach
                    
                </div>

            @endif


            <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
            NO PUSO EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCinco) > 0)

                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Signos de puntuación no encontrados en la respuesta:</strong></h5>
                    <p class="text-start mt-4">Los siguientes signos de puntuación no fueron encontrados en la respuesta.</p>

                    
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach ($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCinco as $elemento)
                        <span id="signosQueLeFaltaronAlUsuarioCinco" name="signosQueLeFaltaronAlUsuarioCinco" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
                        <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                        
                    @endforeach
                    
                </div>
                
            @endif


            <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
            QUE ESTEN INCORRECTAS -->
            @if (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCinco) > 0)
                <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                <div class="px-5 py-4 border-top border-bottom m-2">
                    <h5 class="text-start text-red pt-2 mt-2 mb-2 ml-2"><strong>Secciones de la respuesta correcta no encontradas en la respuesta:</strong></h5>
                    <p class="text-justify mt-4">Las siguientes secciones no se encontraron en la respuesta.</p>

                    
                    <span class="h4 text-red pt-2 mt-2 mb-2 ml-2"><strong> | </strong></span>
                    @foreach ($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCinco as $elemento)
                        <span id="signosQueLeFaltaronAlUsuarioCinco" name="signosQueLeFaltaronAlUsuarioCinco" class="h4 text-center mt-4"><strong>{{$elemento}}</strong></span>
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





<!-- ////////////////////////////////////////////////////FIN NUEVA VISTA ADMIN RESULTADOS OI////////////////////////////////////////// -->





<!-- VISTA ADMIN RESULTADOS OI ORIGINAL -->

<div class="card" hidden>
    <div class="card-header">
        <!-- TITULO DE LA PREGUNTA -->
        <h1><strong>{{$questionType->title}}</strong></h1>
    </div>

    <div class="card-footer">
        <!-- INDICACIONES DE LA PREGUNTA -->
        <li>
            <strong>Indicaciones de la pregunta:</strong>
            @foreach ($questionType->indications as $indication)
                <ul class="text-info">{{$indication->indication}}</ul>
            @endforeach
        </li>
        <!-- IMAGEN -->
        <div>
            <strong>Imagen:</strong>
            <br>
            <img id="image" name="imagen" src="/storage/{{$questionType->image}}" alt="" height="400px" width="700px">
        </div>
        <br>
        <!-- PALABRAS VISIBLES -->
        <br>
        <!-- RESPUESTA USUARIO -->
        <li>
            <strong class="text-red">Tus respuestas:</strong>
            @foreach ($coleccionResults as $result)
                <ul>{{$result->answer_user}}</ul>
            @endforeach
        </li>
        <!-- RESPUESTAS CORRECTAS -->
        <li>
            <strong class="text-red">Oraciones correctas:</strong>
            @foreach ($questionType->answers as $answer)
                <ul>{{$answer->answer}}</ul>
            @endforeach
        </li>
        <br>
        <!-- RESULTADOS -->
        <div>
            <strong class="text-red">Puntaje pregunta:</strong>
            <label>{{$sumaresultados}}</label>
        </div>
    </div>


    <div class="card-footer">
        <!-- PALABRAS ACERTADAS -->
        <li>
            <strong class="text-red">Oraciones acertadas:</strong>
            @foreach ($oracionesAcertadas as $correcta)
                <ul>{{$correcta}}</ul>
            @endforeach
        </li>
        <!-- PALABRAS ERRADAS -->
        <li>
            <strong class="text-red">Oraciones incorrectas:</strong>
            @foreach ($oracionesIncorrectas as $incorrecta)
                <ul>{{$incorrecta}}</ul> 
            @endforeach
        </li>
        <!-- JUSTIFICACIONES DE RESPUESTA -->
        <li class="text-info">
            <strong>Justificaciones a la respuesta:</strong>
            @foreach ($questionType->justifications as $justification)
                <ul>{{$justification->reason}}</ul>
            @endforeach
        </li>
        <!-- REGLAS ASOCIADAS    -->
        <li class="text-success">
            <strong>Reglas asociadas:</strong>
            @foreach ($questionType->justifications as $justification)
                <ul>{{$justification->rule}}</ul>
            @endforeach
        </li>
    </div>
    <br>



    <!-- DIV INFORMACION DETALLADA DE CADA ORACION -->
        <!--ORACION UNO -->
        <div>
            <strong class="text-red">Revisión oración uno:</strong>
            <div>
                <strong class="text-warning">Observación:</strong>
                <br>
                <h2>{{$respuestaEnunciadoUno}}</h2>
            </div>

            <!-- RESPUESTA DEL USUARIO -->
            {{--<div>
                <strong class="text-red-500">Tu respuesta:</strong>
                <br>
                <h2 id="enunciadousuariouno" >{{$enunciadoUsuarioUno}}</h2>
            </div>
            <!-- RESPUESTA CORRECTA -->
            <div>
                <strong class="text-red-500">Respuesta correcta:</strong>
                <br>
                <h2 id="enunciadocorrectouno" >{{$enunciadoCorrectoUno}}</h2>
            </div>--}}


            <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA
            SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL
            EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO,
            LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL -->

            @if ($resultadooiuno === 0.00)
                <!-- SI LA RESPUESTA DEL USUARIO ES INCORRECTA ENTONCES SE ENVIAN LOS SIGUIENTES DATOS -->

                <!--LA RESPUESTA DEL USUARIO ORIGINAL SE MUESTRA MEDIANTE LA VARIABLE $stringSeccionesEnunciadoUsuarioUno QUE VA A MOSTRAR
                DONDE EL USUARIO HA COLOCADO ESPACIOS DEMAS SI FUESE EL CASO -->
                <!-- ESTA SECCION SE PUEDE COMENTAR POR EL ELEMENTO $enunciadoUsuarioUno  SI LUEGO NO QUIERO QUE SE MUESTREN LOS AGREGADOS POR EL USUARIO-->
                <div>
                    <strong class="text-red">Tu respuesta:</strong>
                    <br>
                    <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                    MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->

                    @if ($existenEspaciosEnunciadoUno)
                        <label class="text-secondary">Si tu respuesta posee "_" dentro del enunciado, significa que agregaste espacios adicionales entre palabras o signos.</label>
                        <br>
                        <label>{{$stringSeccionesEnunciadoUsuarioUno}}</label>
                    @else
                        <label>{{$stringSeccionesEnunciadoUsuarioUno}}</label>
                    @endif
                </div>


                <!-- LA REVISION DE LA RESPUESTA DEL USUARIO DONDE SE VAN A PINTAR LOS ERRORES ORTOGRAFICOS -->
                <div>
                    <strong class="text-red">Revisión de tu respuesta:</strong>
                    <br>
                    <label class="text-secondary">Se marcan de rojo los elementos incorrectos de tu respuesta.</label>
                    <br>
                    <h2 id="enunciadousuariouno" >{{$enunciadoUsuarioUno}}</h2>
                </div>

                <!-- RESPUESTA CORRECTA ORIGINAL -->
                <div>
                    <strong class="text-red">Respuesta correcta:</strong>
                    <br>
                    <label>{{$enunciadoCorrectoUno}}</label>
                </div>

                <!-- REVISION DE LA RESPUESTA CORRECTA DONDE SE PINTAN LAS PALABRAS QUE EL USUARIO NO COLOCO EN SU RESPUESTA -->
                <div>
                    <strong class="text-red">Comparación respuesta correcta:</strong>
                    <br>
                    <label class="text-secondary">Se marcan de verde los elementos que no se encontraron en tu respuesta.</label>
                    <br>
                    <h2 id="enunciadocorrectouno" >{{$enunciadoCorrectoUno}}</h2>
                </div>

            @else
                
                <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
                <!-- RESPUESTA DEL USUARIO -->
                <div>
                    <strong class="text-red">Tu respuesta:</strong>
                    <br>
                    <label id="enunciadousuariouno">{{$enunciadoUsuarioUno}}</label>
                </div>

                <!-- RESPUESTA CORRECTA -->
                <div>
                    <strong class="text-red">Respuesta correcta:</strong>
                    <br>
                    <label id="enunciadocorrectouno" >{{$enunciadoCorrectoUno}}</label>
                </div>
            @endif



            <!-- PALABRAS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS INCORRECTAS
            EN LA RESPUESTA -->


            {{--@if (count($resultadoEnunciadoPalabrasIncorrectasUsuarioUno) > 0)--}}
            @if (count($resultadoSeccionesIncorrectasEnunciadoUsuarioUno) >0)
                
                <strong class="text-red">Elementos de tu respuesta que son incorrectos:</strong>
                <br>
                <label>En tu respuesta se marcan de color rojo las secciones incorrectas de tu oración: </label>
                <br>
                <div class="text-red">
                    
                   {{--@foreach ($resultadoEnunciadoPalabrasIncorrectasUsuarioUno as $key=>$elemento)
                       <label class="text-black">{{$elemento}}</label>
                   @endforeach--}}

                   <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                    DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                    <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                    @foreach (array_unique($resultadoSeccionesIncorrectasEnunciadoUsuarioUno) as $key=>$elemento)
                        <label> | </label>
                        <label id="seccionesIncorrectasEnunciadoUsuarioUno" name="seccionesIncorrectasEnunciadoUsuarioUno" class="text-black">{{$elemento}}</label>
                        <label> | </label>
                    @endforeach
                </div>
            @endif
            {{--<div>
                <strong class="text-red-500">Palabras de tu respuesta que son incorrectas:</strong>

                @if (count($resultadoPalabrasIncorrectasUsuarioUno) > 0)
                    <h2>Hay mas de un elemento</h2> 
                @else
                    <h2>No hay elementos en el array</h2>
                @endif
            </div>--}}

            <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosIncorrectosUsuarioUno) > 0)
                <strong class="text-red">Signos ortográficos de tu respuesta que son incorrectos o están mal colocados:</strong>
                <br>
                <div class="text-red">
                    
                    @foreach ($resultadoEnunciadoSignosIncorrectosUsuarioUno as $elemento)
                        <label id="signosIncorrectosEnunciadoUsuarioUno" name="signosIncorrectosEnunciadoUsuarioUno" class="text-black">{{$elemento}}</label>
                        <label> |</label>
                    @endforeach
                </div>
            @endif

            <!-- PALABRAS QUE LE FALTARON AL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS DE LA ORACION CORRECTA 
            QUE NO PUSO EN SU RESPUESTA -->
            {{--@if (count($resultadoPalabrasQueLeFaltaronAlUsuarioUno) > 0)
                <li class="text-red-500">
                    <strong class="text-red-500">Palabras que olvidaste agregar a tu respuesta:</strong>
                    @foreach ($resultadoPalabrasQueLeFaltaronAlUsuarioUno as $elemento)
                        <ul class="text-black">{{$elemento}}</ul>
                    @endforeach
                </li>
            @endif--}}

            <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
            NO PUSO EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioUno) > 0)

                <strong class="text-red">Signos de puntuación que olvidaste agregar a tu respuesta:</strong>
                <br>
                <div class="text-red">
                    
                    @foreach ($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioUno as $elemento)
                        <label id="signosQueLeFaltaronAlUsuarioUno" name="signosQueLeFaltaronAlUsuarioUno"  class="text-black">{{$elemento}}</label>
                        <label> |</label>
                    @endforeach
                </div>
            @endif

            <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
            QUE ESTEN INCORRECTAS -->
            @if (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioUno) > 0)

                <strong class="text-red">Secciones de la respuesta correcta no encontradas en tu respuesta:</strong>
                <br>
                <label>Las siguientes secciones no se encontraron en tu respuesta debido a que colocastee incorrectamente ciertos signos de puntuación o escribiste palabras incorrectamente.</label>
                <br>
                <label>En la respuesta correcta se marcan de color verde las secciones que no se encontraron en tu oración: </label>
                <br>
                <div>
                    <br>
                    @foreach ($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioUno as $elemento)
                        <label id="seccionesEnunciadoQueLeFaltaronAlUsuarioUno" name="seccionesEnunciadoQueLeFaltaronAlUsuarioUno" class="text-black">{{$elemento}}</label>
                    @endforeach
                </div>
            @endif

        </div>
        <br>




        <!--ORACION DOS -->
        <div>
            <strong class="text-red">Revisión oración dos:</strong>
            <div>
                <strong class="text-warning">Observación:</strong>
                <br>
                <h2>{{$respuestaEnunciadoDos}}</h2>
            </div>

            {{--<!-- RESPUESTA DEL USUARIO -->
            <div>
                <strong class="text-red-500">Tu respuesta:</strong>
                <br>
                <h2 id="enunciadousuariodos" >{{$enunciadoUsuarioDos}}</h2>
            </div>
            <!-- RESPUESTA CORRECTA -->
            <div>
                <strong class="text-red-500">Respuesta correcta:</strong>
                <br>
                <h2 id="enunciadocorrectodos" >{{$enunciadoCorrectoDos}}</h2>
            </div>--}}


             <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA
            SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL
            EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO,
            LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL -->

            @if ($resultadooidos === 0.00)
                <!-- SI LA RESPUESTA DEL USUARIO ES INCORRECTA ENTONCES SE ENVIAN LOS SIGUIENTES DATOS -->

                <!--LA RESPUESTA DEL USUARIO ORIGINAL SE MUESTRA MEDIANTE LA VARIABLE $stringSeccionesEnunciadoUsuarioUno QUE VA A MOSTRAR
                DONDE EL USUARIO HA COLOCADO ESPACIOS DEMAS SI FUESE EL CASO -->
                <!-- ESTA SECCION SE PUEDE COMENTAR POR EL ELEMENTO $enunciadoUsuarioUno  SI LUEGO NO QUIERO QUE SE MUESTREN LOS AGREGADOS POR EL USUARIO-->
                <div>
                    <strong class="text-red">Tu respuesta:</strong>
                    <br>
                    <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                    MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->

                    @if ($existenEspaciosEnunciadoDos)
                        <label class="text-secondary">Si tu respuesta posee "_" dentro del enunciado, significa que agregaste espacios adicionales entre palabras o signos.</label>
                        <br>
                        <label>{{$stringSeccionesEnunciadoUsuarioDos}}</label>
                    @else
                        <label>{{$stringSeccionesEnunciadoUsuarioDos}}</label>
                    @endif
                </div>


                <!-- LA REVISION DE LA RESPUESTA DEL USUARIO DONDE SE VAN A PINTAR LOS ERRORES ORTOGRAFICOS -->
                <div>
                    <strong class="text-red">Revisión de tu respuesta:</strong>
                    <br>
                    <label class="text-secondary">Se marcan de rojo los elementos incorrectos de tu respuesta.</label>
                    <br>
                    <label id="enunciadousuariodos" >{{$enunciadoUsuarioDos}}</label>
                </div>

                <!-- RESPUESTA CORRECTA ORIGINAL -->
                <div>
                    <strong class="text-red">Respuesta correcta:</strong>
                    <br>
                    <label>{{$enunciadoCorrectoDos}}</label>
                </div>

                <!-- REVISION DE LA RESPUESTA CORRECTA DONDE SE PINTAN LAS PALABRAS QUE EL USUARIO NO COLOCO EN SU RESPUESTA -->
                <div>
                    <strong class="text-red">Comparación respuesta correcta:</strong>
                    <br>
                    <label class="text-secondary">Se marcan de verde los elementos que no se encontraron en tu respuesta.</label>
                    <br>
                    <label id="enunciadocorrectodos" >{{$enunciadoCorrectoDos}}</label>
                </div>

            @else
                
                <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
                <!-- RESPUESTA DEL USUARIO -->
                <div>
                    <strong class="text-red">Tu respuesta:</strong>
                    <br>
                    <label id="enunciadousuariodos"  >{{$enunciadoUsuarioDos}}</label>
                </div>

                <!-- RESPUESTA CORRECTA -->
                <div>
                    <strong class="text-red">Respuesta correcta:</strong>
                    <br>
                    <label id="enunciadocorrectodos" >{{$enunciadoCorrectoDos}}</label>
                </div>
            @endif



            <!-- PALABRAS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS INCORRECTAS
            EN LA RESPUESTA -->

            {{--@if (count($resultadoEnunciadoPalabrasIncorrectasUsuarioDos) > 0)--}}
            @if (count($resultadoSeccionesIncorrectasEnunciadoUsuarioDos) >0)

                <strong class="text-red">Elementos de tu respuesta que son incorrectos:</strong>
                <br>
                <label>En tu respuesta se marcan de color rojo las secciones incorrectas de tu oración: </label>
                <br>
                <div class="text-red">
                   
                   {{--@foreach ($resultadoEnunciadoPalabrasIncorrectasUsuarioDos as $key=>$elemento)
                       <ul class="text-black">{{$elemento}}</ul>
                   @endforeach--}}

                   <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                    DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                    <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                    @foreach (array_unique($resultadoSeccionesIncorrectasEnunciadoUsuarioDos) as $key=>$elemento)
                        <label> | </label>
                        <label id="seccionesIncorrectasEnunciadoUsuarioDos" name="seccionesIncorrectasEnunciadoUsuarioDos" class="text-black">{{$elemento}}</label>
                        <label> | </label>
                    @endforeach
                </div>
            @endif
            {{--<div>
                <strong class="text-red-500">Palabras de tu respuesta que son incorrectas:</strong>

                @if (count($resultadoPalabrasIncorrectasUsuarioUno) > 0)
                    <h2>Hay mas de un elemento</h2> 
                @else
                    <h2>No hay elementos en el array</h2>
                @endif
            </div>--}}

            <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosIncorrectosUsuarioDos) > 0)

                <strong class="text-red">Signos ortográficos de tu respuesta que son incorrectos o están mal colocados:</strong>
                <br>
                <div class="text-red">
                    
                    @foreach ($resultadoEnunciadoSignosIncorrectosUsuarioDos as $elemento)
                        <label id="signosIncorrectosEnunciadoUsuarioDos" name="signosIncorrectosEnunciadoUsuarioDos" class="text-black">{{$elemento}}</label>
                        <label> |</label>
                    @endforeach
                </div>
            @endif

            <!-- PALABRAS QUE LE FALTARON AL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS DE LA ORACION CORRECTA 
            QUE NO PUSO EN SU RESPUESTA -->
            {{--@if (count($resultadoPalabrasQueLeFaltaronAlUsuarioUno) > 0)
                <li class="text-red-500">
                    <strong class="text-red-500">Palabras que olvidaste agregar a tu respuesta:</strong>
                    @foreach ($resultadoPalabrasQueLeFaltaronAlUsuarioUno as $elemento)
                        <ul class="text-black">{{$elemento}}</ul>
                    @endforeach
                </li>
            @endif--}}

            <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
            NO PUSO EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioDos) > 0)

                <strong class="text-red">Signos de puntuación que olvidaste agregar a tu respuesta:</strong>
                <br>
                <div class="text-red">
                    
                    @foreach ($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioDos as $elemento)
                        <label id="signosQueLeFaltaronAlUsuarioDos" name="signosQueLeFaltaronAlUsuarioDos" class="text-black">{{$elemento}}</label>
                        <label> |</label>
                    @endforeach
                </div>
            @endif

            <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
            QUE ESTEN INCORRECTAS -->
            @if (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioDos) > 0)

                <strong class="text-red">Secciones de la respuesta correcta no encontradas en tu respuesta:</strong>
                <br>
                <label>Las siguientes secciones no se encontraron en tu respuesta debido a que colocastee incorrectamente ciertos signos de puntuación o escribiste palabras incorrectamente.</label>
                <br>
                <label>En la respuesta correcta se marcan de color verde las secciones que no se encontraron en tu oración: </label>
                <br>
                <div>
                    <br>
                    @foreach ($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioDos as $elemento)
                        <label id="seccionesEnunciadoQueLeFaltaronAlUsuarioDos" name="seccionesEnunciadoQueLeFaltaronAlUsuarioDos" class="text-black">{{$elemento}}</label>
                        <br>
                    @endforeach
                </div>
            @endif

        </div>
        <br>



        <!--ORACION TRES -->
        <div>
            <strong class="text-red">Revisión oración tres:</strong>
            <div>
                <strong class="text-warning">Observación:</strong>
                <br>
                <h2>{{$respuestaEnunciadoTres}}</h2>
            </div>

            {{--<!-- RESPUESTA DEL USUARIO -->
            <div>
                <strong class="text-red-500">Tu respuesta:</strong>
                <br>
                <h2 id="enunciadousuariotres" >{{$enunciadoUsuarioTres}}</h2>
            </div>
            <!-- RESPUESTA CORRECTA -->
            <div>
                <strong class="text-red-500">Respuesta correcta:</strong>
                <br>
                <h2 id="enunciadocorrectotres" >{{$enunciadoCorrectoTres}}</h2>
            </div>--}}



            <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA
            SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL
            EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO,
            LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL -->

            @if ($resultadooitres === 0.00)
                <!-- SI LA RESPUESTA DEL USUARIO ES INCORRECTA ENTONCES SE ENVIAN LOS SIGUIENTES DATOS -->

                <!--LA RESPUESTA DEL USUARIO ORIGINAL SE MUESTRA MEDIANTE LA VARIABLE $stringSeccionesEnunciadoUsuarioUno QUE VA A MOSTRAR
                DONDE EL USUARIO HA COLOCADO ESPACIOS DEMAS SI FUESE EL CASO -->
                <!-- ESTA SECCION SE PUEDE COMENTAR POR EL ELEMENTO $enunciadoUsuarioUno  SI LUEGO NO QUIERO QUE SE MUESTREN LOS AGREGADOS POR EL USUARIO-->
                <div>
                    <strong class="text-red">Tu respuesta:</strong>
                    <br>
                    <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                    MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->

                    @if ($existenEspaciosEnunciadoTres)
                        <label class="text-secondary">Si tu respuesta posee "_" dentro del enunciado, significa que agregaste espacios adicionales entre palabras o signos.</label>
                        <br>
                        <label>{{$stringSeccionesEnunciadoUsuarioTres}}</label>
                    @else
                        <label>{{$stringSeccionesEnunciadoUsuarioTres}}</label>
                    @endif
                </div>


                <!-- LA REVISION DE LA RESPUESTA DEL USUARIO DONDE SE VAN A PINTAR LOS ERRORES ORTOGRAFICOS -->
                <div>
                    <strong class="text-red">Revisión de tu respuesta:</strong>
                    <br>
                    <label class="text-secondary">Se marcan de rojo los elementos incorrectos de tu respuesta.</label>
                    <br>
                    <h2 id="enunciadousuariotres" >{{$enunciadoUsuarioTres}}</h2>
                </div>

                <!-- RESPUESTA CORRECTA ORIGINAL -->
                <div>
                    <strong class="text-red">Respuesta correcta:</strong>
                    <br>
                    <label>{{$enunciadoCorrectoTres}}</label>
                </div>

                <!-- REVISION DE LA RESPUESTA CORRECTA DONDE SE PINTAN LAS PALABRAS QUE EL USUARIO NO COLOCO EN SU RESPUESTA -->
                <div>
                    <strong class="text-red">Comparación respuesta correcta:</strong>
                    <br>
                    <label class="text-secondary">Se marcan de verde los elementos que no se encontraron en tu respuesta.</label>
                    <br>
                    <h2 id="enunciadocorrectotres" >{{$enunciadoCorrectoTres}}</h2>
                </div>

            @else
                
                <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
                <!-- RESPUESTA DEL USUARIO -->
                <div>
                    <strong class="text-red">Tu respuesta:</strong>
                    <br>
                    <label id="enunciadousuariotres">{{$enunciadoUsuarioTres}}</label>
                </div>

                <!-- RESPUESTA CORRECTA -->
                <div>
                    <strong class="text-red">Respuesta correcta:</strong>
                    <br>
                    <label id="enunciadocorrectotres" >{{$enunciadoCorrectoTres}}</label>
                </div>
            @endif




            <!-- PALABRAS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS INCORRECTAS
            EN LA RESPUESTA -->

            {{--@if (count($resultadoEnunciadoPalabrasIncorrectasUsuarioTres) > 0)--}}
            @if (count($resultadoSeccionesIncorrectasEnunciadoUsuarioTres) >0)

                <strong class="text-red">Elementos de tu respuesta que son incorrectos:</strong>
                <br>
                <label>En tu respuesta se marcan de color rojo las secciones incorrectas de tu oración: </label>
                <br>
                <div class="text-red">
                   
                   {{--@foreach ($resultadoEnunciadoPalabrasIncorrectasUsuarioTres as $key=>$elemento)
                       <ul class="text-black">{{$elemento}}</ul>
                   @endforeach--}}


                   <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                    DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                    <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                    @foreach (array_unique($resultadoSeccionesIncorrectasEnunciadoUsuarioTres) as $key=>$elemento)
                        <label> | </label>
                        <label id="seccionesIncorrectasEnunciadoUsuarioTres" name="seccionesIncorrectasEnunciadoUsuarioTres" class="text-black">{{$elemento}}</label>
                        <label> | </label>
                    @endforeach
                </div>
            @endif
            {{--<div>
                <strong class="text-red-500">Palabras de tu respuesta que son incorrectas:</strong>

                @if (count($resultadoPalabrasIncorrectasUsuarioUno) > 0)
                    <h2>Hay mas de un elemento</h2> 
                @else
                    <h2>No hay elementos en el array</h2>
                @endif
            </div>--}}

            <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosIncorrectosUsuarioTres) > 0)

                <strong class="text-red">Signos ortográficos de tu respuesta que son incorrectos o están mal colocados:</strong>
                <br>
                <div class="text-red">
                    
                    @foreach ($resultadoEnunciadoSignosIncorrectosUsuarioTres as $elemento)
                        <label id="signosIncorrectosEnunciadoUsuarioTres" name="signosIncorrectosEnunciadoUsuarioTres" class="text-black">{{$elemento}}</label>
                        <label> |</label> 
                    @endforeach
                </div>
            @endif

            <!-- PALABRAS QUE LE FALTARON AL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS DE LA ORACION CORRECTA 
            QUE NO PUSO EN SU RESPUESTA -->
            {{--@if (count($resultadoPalabrasQueLeFaltaronAlUsuarioUno) > 0)
                <li class="text-red-500">
                    <strong class="text-red-500">Palabras que olvidaste agregar a tu respuesta:</strong>
                    @foreach ($resultadoPalabrasQueLeFaltaronAlUsuarioUno as $elemento)
                        <ul class="text-black">{{$elemento}}</ul>
                    @endforeach
                </li>
            @endif--}}

            <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
            NO PUSO EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioTres) > 0)

                <strong class="text-red">Signos de puntuación que olvidaste agregar a tu respuesta:</strong>
                <br>
                <div class="text-red">
                    
                    @foreach ($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioTres as $elemento)
                        <label id="signosQueLeFaltaronAlUsuarioTres" name="signosQueLeFaltaronAlUsuarioTres" class="text-black">{{$elemento}}</label>
                        <label> |</label>
                    @endforeach
                </div>
            @endif

            <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
            QUE ESTEN INCORRECTAS -->
            @if (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioTres) > 0)

                <strong class="text-red">Secciones de la respuesta correcta no encontradas en tu respuesta:</strong>
                <br>
                <label>Las siguientes secciones no se encontraron en tu respuesta debido a que colocastee incorrectamente ciertos signos de puntuación o escribiste palabras incorrectamente.</label>
                <br>
                <label>En la respuesta correcta se marcan de color verde las secciones que no se encontraron en tu oración: </label>
                <br>
                <label>
                    
                    @foreach ($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioTres as $elemento)
                        <label id="seccionesEnunciadoQueLeFaltaronAlUsuarioTres" name="seccionesEnunciadoQueLeFaltaronAlUsuarioTres" class="text-black">{{$elemento}}</label>
                        <br>
                    @endforeach
                </label>
            @endif

        </div>
        <br>



        <!--ORACION CUATRO -->
        <div>
            <strong class="text-red">Revisión oración cuatro:</strong>
            <div>
                <strong class="text-warning">Observación:</strong>
                <br>
                <h2>{{$respuestaEnunciadoCuatro}}</h2>
            </div>

            {{--<!-- RESPUESTA DEL USUARIO -->
            <div>
                <strong class="text-red-500">Tu respuesta:</strong>
                <br>
                <h2 id="enunciadousuariocuatro" >{{$enunciadoUsuarioCuatro}}</h2>
            </div>
            <!-- RESPUESTA CORRECTA -->
            <div>
                <strong class="text-red-500">Respuesta correcta:</strong>
                <br>
                <h2 id="enunciadocorrectocuatro" >{{$enunciadoCorrectoCuatro}}</h2>
            </div>--}}


            <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA
            SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL
            EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO,
            LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL -->

            @if ($resultadooicuatro === 0.00)
                <!-- SI LA RESPUESTA DEL USUARIO ES INCORRECTA ENTONCES SE ENVIAN LOS SIGUIENTES DATOS -->

                <!--LA RESPUESTA DEL USUARIO ORIGINAL SE MUESTRA MEDIANTE LA VARIABLE $stringSeccionesEnunciadoUsuarioUno QUE VA A MOSTRAR
                DONDE EL USUARIO HA COLOCADO ESPACIOS DEMAS SI FUESE EL CASO -->
                <!-- ESTA SECCION SE PUEDE COMENTAR POR EL ELEMENTO $enunciadoUsuarioUno  SI LUEGO NO QUIERO QUE SE MUESTREN LOS AGREGADOS POR EL USUARIO-->
                <div>
                    <strong class="text-red">Tu respuesta:</strong>
                    <br>
                    <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                    MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->

                    @if ($existenEspaciosEnunciadoCuatro)
                        <label class="text-secondary">Si tu respuesta posee "_" dentro del enunciado, significa que agregaste espacios adicionales entre palabras o signos.</label>
                        <br>
                        <label>{{$stringSeccionesEnunciadoUsuarioCuatro}}</label>
                    @else
                        <label>{{$stringSeccionesEnunciadoUsuarioCuatro}}</label>
                    @endif
                </div>


                <!-- LA REVISION DE LA RESPUESTA DEL USUARIO DONDE SE VAN A PINTAR LOS ERRORES ORTOGRAFICOS -->
                <div>
                    <strong class="text-red">Revisión de tu respuesta:</strong>
                    <br>
                    <label class="text-secondary">Se marcan de rojo los elementos incorrectos de tu respuesta.</label>
                    <br>
                    <h2 id="enunciadousuariocuatro" >{{$enunciadoUsuarioCuatro}}</h2>
                </div>

                <!-- RESPUESTA CORRECTA ORIGINAL -->
                <div>
                    <strong class="text-red">Respuesta correcta:</strong>
                    <br>
                    <label>{{$enunciadoCorrectoCuatro}}</label>
                </div>

                <!-- REVISION DE LA RESPUESTA CORRECTA DONDE SE PINTAN LAS PALABRAS QUE EL USUARIO NO COLOCO EN SU RESPUESTA -->
                <div>
                    <strong class="text-red">Comparación respuesta correcta:</strong>
                    <br>
                    <label class="text-secondary">Se marcan de verde los elementos que no se encontraron en tu respuesta.</label>
                    <br>
                    <h2 id="enunciadocorrectocuatro" >{{$enunciadoCorrectoCuatro}}</h2>
                </div>

            @else
                
                <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
                <!-- RESPUESTA DEL USUARIO -->
                <div>
                    <strong class="text-red">Tu respuesta:</strong>
                    <br>
                    <label id="enunciadousuariocuatro">{{$enunciadoUsuarioCuatro}}</label>
                </div>

                <!-- RESPUESTA CORRECTA -->
                <div>
                    <strong class="text-red">Respuesta correcta:</strong>
                    <br>
                    <label id="enunciadocorrectocuatro" >{{$enunciadoCorrectoCuatro}}</label>
                </div>
            @endif



            <!-- PALABRAS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS INCORRECTAS
            EN LA RESPUESTA -->

            {{--@if (count($resultadoEnunciadoPalabrasIncorrectasUsuarioCuatro) > 0)--}}
            @if (count($resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro) >0)

                <strong class="text-red">Elementos de tu respuesta que son incorrectos:</strong>
                <br>
                <label>En tu respuesta se marcan de color rojo las secciones incorrectas de tu oración: </label>
                <br>
                <div class="text-red">
                    
                   {{--@foreach ($resultadoEnunciadoPalabrasIncorrectasUsuarioCuatro as $key=>$elemento)
                       <ul class="text-black">{{$elemento}}</ul>
                   @endforeach--}}

                   <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                    DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                    <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                    @foreach (array_unique($resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro) as $key=>$elemento)
                        <label> | </label>
                        <label id="seccionesIncorrectasEnunciadoUsuarioCuatro" name="seccionesIncorrectasEnunciadoUsuarioCuatro" class="text-black">{{$elemento}}</label>
                        <label> | </label>
                    @endforeach
                </div>
            @endif
            {{--<div>
                <strong class="text-red-500">Palabras de tu respuesta que son incorrectas:</strong>

                @if (count($resultadoPalabrasIncorrectasUsuarioUno) > 0)
                    <h2>Hay mas de un elemento</h2> 
                @else
                    <h2>No hay elementos en el array</h2>
                @endif
            </div>--}}

            <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosIncorrectosUsuarioCuatro) > 0)

                <strong class="text-red">Signos ortográficos de tu respuesta que son incorrectos o están mal colocados:</strong>
                <br>
                <div class="text-red">
                    
                    @foreach ($resultadoEnunciadoSignosIncorrectosUsuarioCuatro as $elemento)
                        <label id="signosIncorrectosEnunciadoUsuarioCuatro" name="signosIncorrectosEnunciadoUsuarioCuatro" class="text-black">{{$elemento}}</label>
                        <label> |</label> 
                    @endforeach
                </div>
            @endif

            <!-- PALABRAS QUE LE FALTARON AL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS DE LA ORACION CORRECTA 
            QUE NO PUSO EN SU RESPUESTA -->
            {{--@if (count($resultadoPalabrasQueLeFaltaronAlUsuarioUno) > 0)
                <li class="text-red-500">
                    <strong class="text-red-500">Palabras que olvidaste agregar a tu respuesta:</strong>
                    @foreach ($resultadoPalabrasQueLeFaltaronAlUsuarioUno as $elemento)
                        <ul class="text-black">{{$elemento}}</ul>
                    @endforeach
                </li>
            @endif--}}

            <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
            NO PUSO EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCuatro) > 0)

                <strong class="text-red">Signos de puntuación que olvidaste agregar a tu respuesta:</strong>
                <br>
                <div class="text-red">
                    
                    @foreach ($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCuatro as $elemento)
                        <label id="signosQueLeFaltaronAlUsuarioCuatro" name="signosQueLeFaltaronAlUsuarioCuatro" class="text-black">{{$elemento}}</label>
                        <label> |</label>
                    @endforeach
                </div>
            @endif

            <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
            QUE ESTEN INCORRECTAS -->
            @if (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCuatro) > 0)

                <strong class="text-red">Secciones de la respuesta correcta no encontradas en tu respuesta:</strong>
                <br>
                <label>Las siguientes secciones no se encontraron en tu respuesta debido a que colocastee incorrectamente ciertos signos de puntuación o escribiste palabras incorrectamente.</label>
                <br>
                <label>En la respuesta correcta se marcan de color verde las secciones que no se encontraron en tu oración: </label>
                <br>
                <div>
                    
                    @foreach ($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCuatro as $elemento)
                        <label id="seccionesEnunciadoQueLeFaltaronAlUsuarioCuatro" name="seccionesEnunciadoQueLeFaltaronAlUsuarioCuatro" class="text-black">{{$elemento}}</label>
                        <br>
                    @endforeach
                </div>
            @endif

        </div>
        <br>




        <!--ORACION CINCO -->
        <div>
            <strong class="text-red">Revisión oración cinco:</strong>
            <div>
                <strong class="text-warning">Observación:</strong>
                <br>
                <h2>{{$respuestaEnunciadoCinco}}</h2>
            </div>

            {{--<!-- RESPUESTA DEL USUARIO -->
            <div>
                <strong class="text-red-500">Tu respuesta:</strong>
                <br>
                <h2 id="enunciadousuariocinco" >{{$enunciadoUsuarioCinco}}</h2>
            </div>
            <!-- RESPUESTA CORRECTA -->
            <div>
                <strong class="text-red-500">Respuesta correcta:</strong>
                <br>
                <h2 id="enunciadocorrectocinco" >{{$enunciadoCorrectoCinco}}</h2>
            </div>--}}


            <!-- CON EL IF SE PREGUNTA SI LA VARIABLE RESULTADOOIUNO ES IGUAL A CERO, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA
            SI ES ASI ENTONCES QUE APAREZCAN CUATRO ELEMENTOS: EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL, EL ENUNCIADO CORRECTO ORIGINAL
            EL ENUNCIADO DE RESPUESTA DEL USUARIO REVISADO Y EL TEXTO CORRECTO REVISADO, PERO SI LA RESPUESTA DEL USUARIO ES DIFERENTE DE CERO,
            LO QUE SIGNIFICA QUE ES CORRECTA, SOLO SE MUESTRA EL ENUNCIADO DE RESPUESTA DEL USUARIO ORIGINAL Y EL ENUNCIADO CORRECTO ORIGINAL -->

            @if ($resultadooicinco === 0.00)
                <!-- SI LA RESPUESTA DEL USUARIO ES INCORRECTA ENTONCES SE ENVIAN LOS SIGUIENTES DATOS -->

                <!--LA RESPUESTA DEL USUARIO ORIGINAL SE MUESTRA MEDIANTE LA VARIABLE $stringSeccionesEnunciadoUsuarioUno QUE VA A MOSTRAR
                DONDE EL USUARIO HA COLOCADO ESPACIOS DEMAS SI FUESE EL CASO -->
                <!-- ESTA SECCION SE PUEDE COMENTAR POR EL ELEMENTO $enunciadoUsuarioUno  SI LUEGO NO QUIERO QUE SE MUESTREN LOS AGREGADOS POR EL USUARIO-->
                <div>
                    <strong class="text-red">Tu respuesta:</strong>
                    <br>
                    <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                    MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->

                    @if ($existenEspaciosEnunciadoCinco)
                        <label class="text-secondary">Si tu respuesta posee "_" dentro del enunciado, significa que agregaste espacios adicionales entre palabras o signos.</label>
                        <br>
                        <label>{{$stringSeccionesEnunciadoUsuarioCinco}}</label>
                    @else
                        <label>{{$stringSeccionesEnunciadoUsuarioCinco}}</label>
                    @endif
                </div>


                <!-- LA REVISION DE LA RESPUESTA DEL USUARIO DONDE SE VAN A PINTAR LOS ERRORES ORTOGRAFICOS -->
                <div>
                    <strong class="text-red">Revisión de tu respuesta:</strong>
                    <br>
                    <label class="text-secondary">Se marcan de rojo los elementos incorrectos de tu respuesta.</label>
                    <br>
                    <h2 id="enunciadousuariocinco" >{{$enunciadoUsuarioCinco}}</h2>
                </div>

                <!-- RESPUESTA CORRECTA ORIGINAL -->
                <div>
                    <strong class="text-red">Respuesta correcta:</strong>
                    <br>
                    <label>{{$enunciadoCorrectoCinco}}</label>
                </div>

                <!-- REVISION DE LA RESPUESTA CORRECTA DONDE SE PINTAN LAS PALABRAS QUE EL USUARIO NO COLOCO EN SU RESPUESTA -->
                <div>
                    <strong class="text-red">Comparación respuesta correcta:</strong>
                    <br>
                    <label class="text-secondary">Se marcan de verde los elementos que no se encontraron en tu respuesta.</label>
                    <br>
                    <h2 id="enunciadocorrectocinco" >{{$enunciadoCorrectoCinco}}</h2>
                </div>

            @else
                
                <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
                <!-- RESPUESTA DEL USUARIO -->
                <div>
                    <strong class="text-red">Tu respuesta:</strong>
                    <br>
                    <label id="enunciadousuariocinco">{{$enunciadoUsuarioCinco}}</label>
                </div>

                <!-- RESPUESTA CORRECTA -->
                <div>
                    <strong class="text-red">Respuesta correcta:</strong>
                    <br>
                    <label id="enunciadocorrectocinco" >{{$enunciadoCorrectoCinco}}</label>
                </div>
            @endif




            <!-- PALABRAS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS INCORRECTAS
            EN LA RESPUESTA -->

            {{--@if (count($resultadoEnunciadoPalabrasIncorrectasUsuarioCinco) > 0)--}}
            @if (count($resultadoSeccionesIncorrectasEnunciadoUsuarioCinco) >0)

                <strong class="text-red">Elementos de tu respuesta que son incorrectos:</strong>
                <br>
                <label>En tu respuesta se marcan de color rojo las secciones incorrectas de tu oración: </label>
                <br>
                <div class="text-red">
                   
                   {{--@foreach ($resultadoEnunciadoPalabrasIncorrectasUsuarioCinco as $key=>$elemento)
                       <ul class="text-black">{{$elemento}}</ul>
                   @endforeach--}}

                   <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                    DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                    <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                    @foreach (array_unique($resultadoSeccionesIncorrectasEnunciadoUsuarioCinco) as $key=>$elemento)
                        <label> | </label>
                        <label id="seccionesIncorrectasEnunciadoUsuarioCinco" name="seccionesIncorrectasEnunciadoUsuarioCinco" class="text-black">{{$elemento}}</label>
                        <label> | </label>
                    @endforeach
                </div>
            @endif
            {{--<div>
                <strong class="text-red-500">Palabras de tu respuesta que son incorrectas:</strong>

                @if (count($resultadoPalabrasIncorrectasUsuarioUno) > 0)
                    <h2>Hay mas de un elemento</h2> 
                @else
                    <h2>No hay elementos en el array</h2>
                @endif
            </div>--}}

            <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosIncorrectosUsuarioCinco) > 0)

                <strong class="text-red">Signos ortográficos de tu respuesta que son incorrectos o están mal colocados:</strong>
                <br>
                <div class="text-red">
                    
                    @foreach ($resultadoEnunciadoSignosIncorrectosUsuarioCinco as $elemento)
                        <label id="signosIncorrectosEnunciadoUsuarioCinco" name="signosIncorrectosEnunciadoUsuarioCinco" class="text-black">{{$elemento}}</label>
                        <label> |</label> 
                    @endforeach
                </div>
            @endif

            <!-- PALABRAS QUE LE FALTARON AL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS DE LA ORACION CORRECTA 
            QUE NO PUSO EN SU RESPUESTA -->
            {{--@if (count($resultadoPalabrasQueLeFaltaronAlUsuarioUno) > 0)
                <li class="text-red-500">
                    <strong class="text-red-500">Palabras que olvidaste agregar a tu respuesta:</strong>
                    @foreach ($resultadoPalabrasQueLeFaltaronAlUsuarioUno as $elemento)
                        <ul class="text-black">{{$elemento}}</ul>
                    @endforeach
                </li>
            @endif--}}

            <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
            NO PUSO EN SU RESPUESTA -->
            @if (count($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCinco) > 0)
                
                <strong class="text-red">Signos de puntuación que olvidaste agregar a tu respuesta:</strong>
                <br>
                <div class="text-red">
                    
                    @foreach ($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCinco as $elemento)
                        <label id="signosQueLeFaltaronAlUsuarioCinco" name="signosQueLeFaltaronAlUsuarioCinco"  class="text-black">{{$elemento}}</label>
                        <label> |</label>
                    @endforeach
                </div>
            @endif

            <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
            <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
            QUE ESTEN INCORRECTAS -->
            @if (count($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCinco) > 0)

                <strong class="text-red">Secciones de la respuesta correcta no encontradas en tu respuesta:</strong>
                <br>
                <label>Las siguientes secciones no se encontraron en tu respuesta debido a que colocastee incorrectamente ciertos signos de puntuación o escribiste palabras incorrectamente.</label>
                <br>
                <label>En la respuesta correcta se marcan de color verde las secciones que no se encontraron en tu oración: </label>
                <br>
                <div>
                    
                    @foreach ($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCinco as $elemento)
                        <label id="seccionesEnunciadoQueLeFaltaronAlUsuarioCinco" name="seccionesEnunciadoQueLeFaltaronAlUsuarioCinco" class="text-black">{{$elemento}}</label>
                        <br>
                    @endforeach
                </div>
            @endif

        </div>
        <br>



        <!-- REGLAS ORTOGRAFICAS ASOCIADAS -->
        
        <!-- REGLAS ORTOGRAFICAS DE PALABRAS -->
        <!-- CON EL IF SE PREGUNTA MEDIANTE LAS VARIABLES HAYPALABRAS SI ALGUNA DE ELLAS ES TRUE, LO QUE SIGNIFICA QUE HAY REGLAS ORTOGRAFICAS DE ESE NIVEL -->
        @if (($haypalabrasencategories === true) || ($haypalabrasensections === true) || ($haypalabrasenposts === true) || ($haypalabrasenrules === true) || ($haypalabrasennotes === true))
            <div>
                <strong class="text-red">Reglas ortográficas de palabras</strong>
                <br>
                <!-- SI HAY REGLAS ORTOGRAFICAS DE PALABRAS DE CUALQUIER NIVEL, AHORA PREGUNTAR INDIVIDUALMENTE PARA IR MOSTRANDO LAS REGLAS ORTOGRAFICAS -->
                @if ($haypalabrasencategories === true)
                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL UNO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION CATEGORIES -->
                    @foreach ($questionType->categories as $categoryrule)
                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES PALABRAS -->
                        @if ($categoryrule->type === "Reglas ortográficas de palabras")
                            <a href="/estudiante/letters/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$categoryrule->name}}
                            </a>
                        @endif
                        <br>
                    @endforeach
                @endif

                @if ($haypalabrasensections === true)
                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL DOS ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION SECTIONS -->
                    @foreach ($questionType->sections as $sectionrule)
                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PALABRAS -->
                        @if ($sectionrule->type === "Reglas ortográficas de palabras")
                            <a href="/estudiante/letters/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$sectionrule->name}}   
                            </a>
                        @endif
                        <br>
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
                            <a href="/estudiante/letters/{{$categorypalabras->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$postrule->name}}
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
                            <a href="/estudiante/letters/{{$categoryrulepalabras->slug}}/{{$sectionrulepalabras->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$rulerule->name}}
                            </a>

                        @endif
                        <br>
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
                            <a href="/estudiante/letters/{{$categoryrulepalabras->slug}}/{{$sectionrulepalabras->slug}}/{{$postrulepalabras->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$noterule->name}}
                            </a>

                        @endif
                    @endforeach
                @endif
            </div>
        @endif
        <br>



        <!-- REGLAS ORTOGRAFICAS DE ACENTUACION -->
        <!-- CON EL IF SE PREGUNTA MEDIANTE LAS VARIABLAS HAYACENTUACION SI ALGUNA DE ELLAS ES TRUE, LO QUE SIGNIFICA QUE HAY REGLAS ORTOGRAFICAS DE ESE NIVEL -->
        @if (($hayacentuacionencategories === true ) || ($hayacentuacionensections === true) || ($hayacentuacionenposts === true) || ($hayacentuacionenrules === true) || ($hayacentuacionennotes === true))
            <div>
                <strong class="text-red">Reglas ortográficas de acentuación</strong>
                <br>
                <!-- SI HAY REGLAS ORTOGRAFICAS DE ACENTUACION DE CUALQUIER NIVEL, AHORA PREGUNTA INDIVIDUALMENTE PARA IR MOSTRANDO LAS REGLAS ORTOGRAFICAS -->
                @if ($hayacentuacionencategories === true)
                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL UNO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION CATEGORIES -->
                    @foreach ($questionType->categories as $categoryrule)
                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES ACENTUACION -->
                        @if ($categoryrule->type === "Reglas ortográficas de acentuación")
                            <a href="/estudiante/acentuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$categoryrule->name}}
                            </a>
                        @endif
                        <br>
                    @endforeach
                @endif

                @if ($hayacentuacionensections === true)
                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL DOS ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION SECTIONS -->
                    @foreach ($questionType->sections as $sectionrule)
                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE ACENTUACION -->
                        @if ($sectionrule->type === "Reglas ortográficas de acentuación")
                            <a href="/estudiante/acentuation/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$sectionrule->name}}    
                            </a>
                        @endif
                        <br>
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
                            <a href="/estudiante/acentuation/{{$categoryacentuacion->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$postrule->name}}
                            </a>
                        @endif
                        <br>
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
                            <a href="/estudiante/acentuation/{{$categoryruleacentuacion->slug}}/{{$sectionruleacentuacion->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$rulerule->name}}
                            </a>
                        @endif
                        <br>
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
                            <a href="/estudiante/acentuation/{{$categoryruleacentuacion->slug}}/{{$sectionruleacentuacion->slug}}/{{$postruleacentuacion->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$noterule->name}}
                            </a>

                        @endif
                    @endforeach
                @endif
            </div>
        @endif




        <!-- REGLAS ORTOGRAFICAS DE PUNTUACION -->
        <!-- CON EL IF SE PREGUNTA MEDIANTE LAS VARIABLES HAYPUNTUACION SI ALGUNA DE ELLAS ES TRUE, LO QUE SIGNIFICA QUE HAY REGLAS ORTOGRAFICAS DE ESE NIVEL -->
        @if (($haypuntuacionencategories === true) || ($haypuntuacionensections === true) || ($haypuntuacionenposts === true) || ($haypuntuacionenrules === true) || ($haypuntuacionennotes === true))
            <div>
                <strong class="text-red">Reglas ortográficas de puntuación</strong>
                <br>
                <!-- SI HAY REGLAS ORTOGRAFICAS DE PUNTUACION DE CUALQUIER NIVEL, AHORA PREGUNTAR INDIVIDUALMENTE PARA IR MOSTRANDO LAS REGLAS ORTOGRAFICAS -->
                @if ($haypuntuacionencategories === true)
                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL UNO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION CATEGORIES -->
                    @foreach ($questionType->categories as $categoryrule)
                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PUNTUACION -->
                        @if ($categoryrule->type === "Reglas ortográficas de puntuación")
                            <a href="/estudiante/punctuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$categoryrule->name}}
                            </a>
                        @endif
                        <br>
                    @endforeach
                @endif

                @if ($haypuntuacionensections === true)
                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL DOS ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION SECTIONS -->
                    @foreach ($questionType->sections as $sectionrule)
                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PUNTUACION -->
                        @if ($sectionrule->type === "Reglas ortográficas de puntuación")
                            <a href="/estudiante/punctuation/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$sectionrule->name}}
                            </a>
                        @endif
                        <br>
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
                            <a href="/estudiante/punctuation/{{$categorypuntuacion->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$postrule->name}}
                            </a>
                        @endif
                        <br>
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
                            <a href="/estudiante/punctuation/{{$categoryrulepuntuacion->slug}}/{{$sectionrulepuntuacion->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$rulerule->name}}
                            </a>
                        @endif
                        <br>
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
                            <a href="/estudiante/punctuation/{{$categoryrulepuntuacion->slug}}/{{$sectionrulepuntuacion->slug}}/{{$postrulepuntuacion->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                {{$noterule->name}}
                                <br>
                            </a>
                        @endif
                        <br>
                    @endforeach
                @endif
            </div>          
        @endif


        <br>
    <!-- BOTON REGRESAR -->
    <div>
        <a href="/admin/results/{{$userId}}/{{$evaluationId}}">
            <button class="btn btn-info">Regresar</button>
        </a>
    </div> 

</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>

    <!-- SCRIPT JUEGO -->
    <script src="{{asset('/js/resaltaroiadmin.js')}}"></script>
@stop