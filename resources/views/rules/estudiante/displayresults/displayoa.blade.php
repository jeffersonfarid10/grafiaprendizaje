<x-app-layout>

    
    <!-- ///////////////////////////////////////////////////NUEVA VISTA RESULTADOS PREGUNTA OA////////////////////////////// -->



    <!-- SE CREA UN DIV PADRE QUE VA A SER DE COLOR BLANCO -->
    <div class="bg-white">

        <!-- SE CREA UN DIV HIJO CON CLASS CONTAINER Y QUE DEBE TENER OBLIGATORIAMENTE UN PT-24 PORQUE SINO EL NAVBAR FIXED VA A OCULTAR INFORMACION -->
        <div class="container mx-auto pt-24 p-12">

            <!-- BOTON REGRESAR -->
            <div>
                <a href="/estudiante/resultado/{{$userId}}/evaluacion/{{$evaluationId}}">
                    <button class="px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all text-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
                        Regresar
                    </button>
                </a>
            </div>

            <!-- DIV QUE CONTIENE EL TITULO DE LA PREGUNTA Y LAS INDICACIONES -->
            <div class="container mx-auto rounded-3xl p-5">
                <h3 class="text-2xl md:text-3xl text-left font-anton text-slate-700">{{$questionType->title}}</h3>
                <br>
                <h4 class="text-2xl md:text-2xl text-left font-anton text-red-700 m-5 pb-5">Indicaciones de la pregunta:</h4>
                <!-- INDICACIONES -->
                @foreach ($questionType->indications as $key=>$indication)
                    <p class="text-xl font-sora mb-5 text-justify">{{$key+1}}. {{$indication->indication}}</p>
                @endforeach
                
            </div>


            <!-- DIV QUE CONTIENE LA IMAGEN -->
            <!-- IMAGEN -->
            <div class="container mx-auto p-10">
                <div class="mx-auto w-full lg:w-3/5">
                    <!-- IMPORTANTE PONER LA LINEA DIAGONAL AL INICIO DE LA RUTA EN LAS IMAGENES DE LAS REGLAS DE NIVEL UNO PARA ADELANTE PORQUE SINO NO VA A APARECER LA IMAGEN -->
                    <img id="image" name="imagen" src="/storage/{{$questionType->image}}" alt="" class="w-full h-full object-cover object-center rounded-lg">
                </div>
            </div> 


            <!-- DIV QUE CONTIENE EL AUDIO -->
            <div class="container mx-auto p-10 bg-slate-300 rounded-xl">
                <label class="font-title font-sora font-semibold mb-10 text-xl text-red-500">Audio de la actividad: </label>
                <div class="mt-10">
                    <audio id="audio" name="audio" controls src="/storage/{{$questionType->audio}}" type="audio" controls>Tu navegador no soporta este elemento, utiliza otro navegador.</audio>
                </div>
            </div>



            <!-- DIV QUE CONTIENE LA PUNTUACION DE LA PREGUNTA -->
            <div class="container mx-auto mt-10 rounded">
                <div class="w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <h2 class="font-semibold text-red-500 font-sora text-center m-4">Resultados de tu respuesta:</h2>
                        <h4 class="font-semibold text-red-500 font-sora">Puntaje: </h4>
                        <h4 class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$sumaresultados}}</h4>
                    </header>
                </div>
            </div>


            <!-- DIV QUE CONTIENE EL ANALISIS GENERAL DE LAS RESPUESTAS DEL USUARIO -->
            <div class="container mt-10 w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-600" >
                <header class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-red-500 font-sora text-center">Revisión general de tus respuestas:</h2>
                </header>
                <!-- GRID CON DOS COLUMNAS QUE CONTIENE LAS PALABRAS CORRECTAS Y PALABRAS INCORRECTAS DEL USUARIO -->
                <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                    <!-- RESPUESTA USUARIO -->
                    <div class="grid grid-cols-1">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tus respuestas correctas:</h5>
                        <div class="container mx-auto p-5 divide-y divide-gray-300">
                            <!-- RECORRER LAS RESPUESTAS CORRECTAS DEL USUARIO -->
                            @foreach ($oracionesAcertadas as $correcta)
                                <h4 class="font-semibold text-gray-800 font-sora text-center text-2xl m-2">{{$correcta}}</h4>
                            @endforeach

                        </div>
                    </div>
                    <!-- RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tus respuestas incorrectas:</h5>
                        <div class="container mx-auto p-5 divide-y divide-gray-300">
                            <!-- RECORRER LAS RESPUESTAS INCORRECTAS DEL USUARIO -->
                            @foreach ($oracionesIncorrectas as $incorrecta)
                                <h4 class="font-semibold text-gray-800 font-sora text-center text-2xl m-2">{{$incorrecta}}</h4>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>


            <!-- DIV QUE CONTIENE LAS ORACIONES DEL USUARIO Y LAS ORACIONES CORRECTAS -->
            <div class="container mt-10 w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-600" >
                <header class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-red-500 font-sora text-center">Oraciones que se analizaron:</h2>
                </header>
                <!-- GRID CON DOS COLUMNAS QUE CONTIENE LAS PALABRAS CORRECTAS Y PALABRAS INCORRECTAS DEL USUARIO -->
                <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                    <!-- RESPUESTA USUARIO -->
                    <div class="grid-cols-1">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tus oraciones:</h5>
                        <div class="container mx-auto p-5 divide-y divide-gray-300">

                            <!-- MOSTRAR LAS ORACIONES DEL USUARIO -->
                            @foreach ($coleccionResults as $result)
                                <h4 class="font-semibold text-gray-800 font-sora text-center text-2xl m-2">{{$result->answer_user}}</h4>
                            @endforeach
                        </div>
                    </div>
                    <!-- RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Oraciones correctas:</h5>
                        <div class="container mx-auto p-5 divide-y divide-gray-300">

                            <!-- MOSTRAR LAS ORACIONES CORRECTAS -->
                            @foreach ($questionType->answers as $answer)
                                <h4 class="font-semibold text-gray-800 font-sora text-center text-2xl m-2">{{$answer->answer}}</h4>
                            @endforeach
                            

                        </div>
                    </div>
                </div>
            </div>


            <!-- DIV QUE CONTIENE EL TITULO DE ANALISIS DE CADA RESPUESTA Y UNA DESCRIPCION -->
            <div class="container mx-auto rounded-3xl p-5">
                <h4 class="text-2xl md:text-2xl text-left font-anton text-red-700 m-5 pb-5">Revisión de cada respuesta:</h4>
                <p class="text-xl font-sora mb-5 text-justify">A continuación puedes ver en detalle la revisión de cada una de tus respuestas.</p>
            </div>


            <!-- ////////////////////////////////////////REVISIONES DETALLADAS DE CADA RESPUESTA DEL USUARIO -->

            <!--//////////////////////////////////////////ORACION UNO -->


            <div class="container mt-10 w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-600">
                
                <!-- TITULO -->
                <header class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-red-500 font-sora text-center">Revisión respuesta uno:</h2>
                </header>
                <!-- OBSERVACION -->
                <div class="px-5 py-4 border-b border-gray-100">
                    <h4 class="font-semibold text-red-500 font-sora">Observación: </h4>
                    <h4 class="font-semibold text-gray-800 font-sora text-center text-xl">{{$respuestaOracionUno}}</h4>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                        <!-- RESPUESTA USUARIO -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tu respuesta:</h5>

                            <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                            MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->
                            @if ($existenEspaciosOracionUno)
                                <label class="text-gray-500">Si tu respuesta posee "_" dentro del enunciado, significa que agregaste espacios adicionales entre palabras o signos.</label>
                                <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$stringSeccionesOracionUsuarioUno}}</h4>
                                
                            @else
                            <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$stringSeccionesOracionUsuarioUno}}</h4>
                            @endif
                            
                        </div>
                        <!-- RESPUESTA CORRECTA -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Respuesta correcta:</h5>
                            <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$oracionCorrectaUno}}</h4>
                        </div>
                    </div>

                    <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES -->
                    @if (($hayUnEspacioEnBlancoOracionUno === true) && (count($resultadoSignosIncorrectosUsuarioUno) === 0) &&
                        (count($resultadoSignosQueLeFaltaronAlUsuarioUno) === 0) && (count($resultadoSeccionesQueLeFaltaronAlUsuarioUno) === 0))
                        
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">Revisa tu respuesta. Haz agregado espacios en blanco adicionales "_" en tu respuesta.</h5>

                        </div>  

                    @else

                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoOracionUno === true)
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">Revisa tu respuesta original. Haz agregado espacios en blanco adicionales "_" en tu respuesta.</h5>
                            
                            </div>
                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">
                                    A continuación, se muestra la revisión detallada de la respuesta.</h5>
                                <h5 class="font-bold font-sora text-black mt-4 ml-4 mb-5 text-center text-xl">
                                    *Se han eliminado los espacios adicionales que agregaste en tu respuesta*</h5>
                                
                            </div>
                        @else 

                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">
                                    A continuación, se muestra la revisión detallada de la respuesta.</h5>
                                
                            </div>

                        @endif
                        
                        <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Revisión de tu respuesta:</h5>
                            <p class="text-lg mt-4 ml-4 mb-5">Si tu respuesta tiene elementos marcados de color rojo, posee elementos incorrectos. Estos elementos son incorrectos por alguna de las siguientes razones:</p>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado palabras incorrectas.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado signos de puntuación de forma incorrecta.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado una misma palabra más veces de las necesarias.</li>
                            <h4 id="oracionusuariouno" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionUsuarioUno}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Comparación con la respuesta correcta:</h5>
                            <p class="text-lg mt-4 ml-4 mb-5">Si tu respuesta contiene elementos marcados de color verde, dichos elementos hacen falta en tu respuesta. Estos elementos no se han encontrado en tu respuesta por alguna de las siguientes razones:</p>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta no contiene la palabra marcada.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Has omitido la palabra marcada en tu respuesta.</li>
                            <h4 id="oracioncorrectauno" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionCorrectaUno}}</h4>
                        </div>
                        
                    @endif

                    <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                    {{--<div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Revisión de tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                        <h4 id="oracionusuariouno" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionUsuarioUno}}</h4>
                    </div>
                    <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Comparación con la respuesta correcta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                        <h4 id="oracioncorrectauno" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionCorrectaUno}}</h4>
                    </div>--}}
                
                @else 
                    <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
                    <!-- RESPUESTA DEL USUARIO -->

                    <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                        <!-- RESPUESTA USUARIO -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tu respuesta:</h5>
                            <h4 id="oracionusuariouno" class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$oracionUsuarioUno}}</h4>
                        </div>
                        <!-- RESPUESTA CORRECTA -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Respuesta correcta:</h5>
                            <h4 id="oracioncorrectauno" class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$oracionCorrectaUno}}</h4>
                        </div>
                    </div>

                @endif

                <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
                EN LA RESPUESTA -->
                @if (count($resultadoSeccionesIncorrectasOracionUsuarioUno) >0)
                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Elementos incorrectos de tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes elementos de tu respuesta son incorrectos.</p>

                        <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                        DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                        <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach (array_unique($resultadoSeccionesIncorrectasOracionUsuarioUno) as $key=>$elemento)
                                <span id="seccionesIncorrectasOracionUsuarioUno" name="seccionesIncorrectasOracionUsuarioUno" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>
                @endif

                <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
                @if (count($resultadoSignosIncorrectosUsuarioUno) > 0)

                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Elementos ortográficos incorrectos:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes elementos ortográficos incorrectos fueron encontrados en tu respuesta.</p>

                        
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSignosIncorrectosUsuarioUno as $elemento)
                                <span id="signosIncorrectosOracionUsuarioUno" name="signosIncorrectosOracionUsuarioUno" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>

                @endif


                <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
                NO PUSO EN SU RESPUESTA -->
                @if (count($resultadoSignosQueLeFaltaronAlUsuarioUno) > 0)

                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Signos de puntuación no encontrados en tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes signos de puntuación no fueron encontrados en tu respuesta.</p>

                        
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSignosQueLeFaltaronAlUsuarioUno as $elemento)
                                <span id="signosQueLeFaltaronAlUsuario" name="signosQueLeFaltaronAlUsuario" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>
                    
                @endif


                <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
                QUE ESTEN INCORRECTAS -->
                @if (count($resultadoSeccionesQueLeFaltaronAlUsuarioUno) > 0)
                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Secciones de la respuesta correcta no encontradas en tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Las siguientes secciones no se encontraron en tu respuesta.</p>

                        
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSeccionesQueLeFaltaronAlUsuarioUno as $elemento)
                                <span id="seccionesQueLeFaltaronAlUsuarioUno" name="seccionesQueLeFaltaronAlUsuarioUno" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>
                @endif 
                

            </div>




            <!--//////////////////////////////////////////ORACION DOS -->


            <div class="container mt-10 w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-600">
                
                <!-- TITULO -->
                <header class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-red-500 font-sora text-center">Revisión respuesta dos:</h2>
                </header>
                <!-- OBSERVACION -->
                <div class="px-5 py-4 border-b border-gray-100">
                    <h4 class="font-semibold text-red-500 font-sora">Observación: </h4>
                    <h4 class="font-semibold text-gray-800 font-sora text-center text-xl">{{$respuestaOracionDos}}</h4>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                        <!-- RESPUESTA USUARIO -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tu respuesta:</h5>

                            <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                            MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->
                            @if ($existenEspaciosOracionDos)
                                <label class="text-gray-500">Si tu respuesta posee "_" dentro del enunciado, significa que agregaste espacios adicionales entre palabras o signos.</label>
                                <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$stringSeccionesOracionUsuarioDos}}</h4>
                                
                            @else
                            <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$stringSeccionesOracionUsuarioDos}}</h4>
                            @endif
                            
                        </div>
                        <!-- RESPUESTA CORRECTA -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Respuesta correcta:</h5>
                            <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$oracionCorrectaDos}}</h4>
                        </div>
                    </div>


                    <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES -->
                    @if (($hayUnEspacioEnBlancoOracionDos === true) && (count($resultadoSignosIncorrectosUsuarioDos) === 0) &&
                        (count($resultadoSignosQueLeFaltaronAlUsuarioDos) === 0) && (count($resultadoSeccionesQueLeFaltaronAlUsuarioDos) === 0))
                        
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">Revisa tu respuesta. Haz agregado espacios en blanco adicionales "_" en tu respuesta.</h5>

                        </div>  

                    @else

                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoOracionDos === true)
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">Revisa tu respuesta original. Haz agregado espacios en blanco adicionales "_" en tu respuesta.</h5>
                            
                            </div>
                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">
                                    A continuación, se muestra la revisión detallada de la respuesta.</h5>
                                <h5 class="font-bold font-sora text-black mt-4 ml-4 mb-5 text-center text-xl">
                                    *Se han eliminado los espacios adicionales que agregaste en tu respuesta*</h5>
                                
                            </div>
                        @else 

                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">
                                    A continuación, se muestra la revisión detallada de la respuesta.</h5>
                                
                            </div>

                        @endif

                        <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Revisión de tu respuesta:</h5>
                            <p class="text-lg mt-4 ml-4 mb-5">Si tu respuesta tiene elementos marcados de color rojo, posee elementos incorrectos. Estos elementos son incorrectos por alguna de las siguientes razones:</p>
                                <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado palabras incorrectas.</li>
                                <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado signos de puntuación de forma incorrecta.</li>
                                <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado una misma palabra más veces de las necesarias.</li>
                            <h4 id="oracionusuariodos" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionUsuarioDos}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Comparación con la respuesta correcta:</h5>
                            <p class="text-lg mt-4 ml-4 mb-5">Si tu respuesta contiene elementos marcados de color verde, dichos elementos hacen falta en tu respuesta. Estos elementos no se han encontrado en tu respuesta por alguna de las siguientes razones:</p>
                                <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta no contiene la palabra marcada.</li>
                                <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                                <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                                <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Has omitido la palabra marcada en tu respuesta.</li>
                            <h4 id="oracioncorrectados" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionCorrectaDos}}</h4>
                        </div>
                        
                    @endif 


                    <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                    {{--<div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Revisión de tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                        <h4 id="oracionusuariodos" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionUsuarioDos}}</h4>
                    </div>
                    <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Comparación con la respuesta correcta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                        <h4 id="oracioncorrectados" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionCorrectaDos}}</h4>
                    </div>--}}
                
                @else 
                    <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
                    <!-- RESPUESTA DEL USUARIO -->

                    <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                        <!-- RESPUESTA USUARIO -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tu respuesta:</h5>
                            <h4 id="oracionusuariodos" class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$oracionUsuarioDos}}</h4>
                        </div>
                        <!-- RESPUESTA CORRECTA -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Respuesta correcta:</h5>
                            <h4 id="oracioncorrectados" class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$oracionCorrectaDos}}</h4>
                        </div>
                    </div>

                @endif

                <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
                EN LA RESPUESTA -->
                @if (count($resultadoSeccionesIncorrectasOracionUsuarioDos) >0)
                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Elementos incorrectos de tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes elementos de tu respuesta son incorrectos.</p>

                        <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                        DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                        <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach (array_unique($resultadoSeccionesIncorrectasOracionUsuarioDos) as $key=>$elemento)
                                <span id="seccionesIncorrectasOracionUsuarioDos" name="seccionesIncorrectasOracionUsuarioDos" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>
                @endif

                <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
                @if (count($resultadoSignosIncorrectosUsuarioDos) > 0)

                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Elementos ortográficos incorrectos:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes elementos ortográficos incorrectos fueron encontrados en tu respuesta.</p>

                        
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSignosIncorrectosUsuarioDos as $elemento)
                                <span id="signosIncorrectosOracionUsuarioDos" name="signosIncorrectosOracionUsuarioDos" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>

                @endif


                <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
                NO PUSO EN SU RESPUESTA -->
                @if (count($resultadoSignosQueLeFaltaronAlUsuarioDos) > 0)

                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Signos de puntuación no encontrados en tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes signos de puntuación no fueron encontrados en tu respuesta.</p>

                        
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSignosQueLeFaltaronAlUsuarioDos as $elemento)
                                <span id="signosQueLeFaltaronAlUsuarioDos" name="signosQueLeFaltaronAlUsuarioDos" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>
                    
                @endif


                <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
                QUE ESTEN INCORRECTAS -->
                @if (count($resultadoSeccionesQueLeFaltaronAlUsuarioDos) > 0)
                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Secciones de la respuesta correcta no encontradas en tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Las siguientes secciones no se encontraron en tu respuesta.</p>

                        
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSeccionesQueLeFaltaronAlUsuarioDos as $elemento)
                                <span id="seccionesQueLeFaltaronAlUsuarioDos" name="seccionesQueLeFaltaronAlUsuarioDos" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>
                @endif 
                

            </div>



            <!--//////////////////////////////////////////ORACION TRES -->


            <div class="container mt-10 w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-600">
                
                <!-- TITULO -->
                <header class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-red-500 font-sora text-center">Revisión respuesta tres:</h2>
                </header>
                <!-- OBSERVACION -->
                <div class="px-5 py-4 border-b border-gray-100">
                    <h4 class="font-semibold text-red-500 font-sora">Observación: </h4>
                    <h4 class="font-semibold text-gray-800 font-sora text-center text-xl">{{$respuestaOracionTres}}</h4>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                        <!-- RESPUESTA USUARIO -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tu respuesta:</h5>

                            <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                            MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->
                            @if ($existenEspaciosOracionTres)
                                <label class="text-gray-500">Si tu respuesta posee "_" dentro del enunciado, significa que agregaste espacios adicionales entre palabras o signos.</label>
                                <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$stringSeccionesOracionUsuarioTres}}</h4>
                                
                            @else
                            <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$stringSeccionesOracionUsuarioTres}}</h4>
                            @endif
                            
                        </div>
                        <!-- RESPUESTA CORRECTA -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Respuesta correcta:</h5>
                            <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$oracionCorrectaTres}}</h4>
                        </div>
                    </div>


                    <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES -->
                    @if (($hayUnEspacioEnBlancoOracionTres === true) && (count($resultadoSignosIncorrectosUsuarioTres) === 0) &&
                        (count($resultadoSignosQueLeFaltaronAlUsuarioTres) === 0) && (count($resultadoSeccionesQueLeFaltaronAlUsuarioTres) === 0))
                        
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">Revisa tu respuesta. Haz agregado espacios en blanco adicionales "_" en tu respuesta.</h5>

                        </div>  

                    @else

                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoOracionTres === true)
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">Revisa tu respuesta original. Haz agregado espacios en blanco adicionales "_" en tu respuesta.</h5>
                            
                            </div>
                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">
                                    A continuación, se muestra la revisión detallada de la respuesta.</h5>
                                <h5 class="font-bold font-sora text-black mt-4 ml-4 mb-5 text-center text-xl">
                                    *Se han eliminado los espacios adicionales que agregaste en tu respuesta*</h5>
                                
                            </div>
                        @else 

                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">
                                    A continuación, se muestra la revisión detallada de la respuesta.</h5>
                                
                            </div>

                        @endif

                        <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Revisión de tu respuesta:</h5>
                            <p class="text-lg mt-4 ml-4 mb-5">Si tu respuesta tiene elementos marcados de color rojo, posee elementos incorrectos. Estos elementos son incorrectos por alguna de las siguientes razones:</p>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado palabras incorrectas.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado signos de puntuación de forma incorrecta.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado una misma palabra más veces de las necesarias.</li>
                            <h4 id="oracionusuariotres" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionUsuarioTres}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Comparación con la respuesta correcta:</h5>
                            <p class="text-lg mt-4 ml-4 mb-5">Si tu respuesta contiene elementos marcados de color verde, dichos elementos hacen falta en tu respuesta. Estos elementos no se han encontrado en tu respuesta por alguna de las siguientes razones:</p>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta no contiene la palabra marcada.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Has omitido la palabra marcada en tu respuesta.</li>
                            <h4 id="oracioncorrectatres" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionCorrectaTres}}</h4>
                        </div>

                    @endif 

                    <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                    {{--<div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Revisión de tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                        <h4 id="oracionusuariotres" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionUsuarioTres}}</h4>
                    </div>
                    <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Comparación con la respuesta correcta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                        <h4 id="oracioncorrectatres" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionCorrectaTres}}</h4>
                    </div>--}}
                
                @else 
                    <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
                    <!-- RESPUESTA DEL USUARIO -->

                    <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                        <!-- RESPUESTA USUARIO -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tu respuesta:</h5>
                            <h4 id="oracionusuariotres" class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$oracionUsuarioTres}}</h4>
                        </div>
                        <!-- RESPUESTA CORRECTA -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Respuesta correcta:</h5>
                            <h4 id="oracioncorrectatres" class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$oracionCorrectaTres}}</h4>
                        </div>
                    </div>

                @endif

                <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
                EN LA RESPUESTA -->
                @if (count($resultadoSeccionesIncorrectasOracionUsuarioTres) >0)
                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Elementos incorrectos de tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes elementos de tu respuesta son incorrectos.</p>

                        <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                        DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                        <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach (array_unique($resultadoSeccionesIncorrectasOracionUsuarioTres) as $key=>$elemento)
                                <span id="seccionesIncorrectasOracionUsuarioTres" name="seccionesIncorrectasOracionUsuarioTres" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>
                @endif

                <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
                @if (count($resultadoSignosIncorrectosUsuarioTres) > 0)

                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Elementos ortográficos incorrectos:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes elementos ortográficos incorrectos fueron encontrados en tu respuesta.</p>

                        
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSignosIncorrectosUsuarioTres as $elemento)
                                <span id="signosIncorrectosOracionUsuarioTres" name="signosIncorrectosOracionUsuarioTres" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>

                @endif


                <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
                NO PUSO EN SU RESPUESTA -->
                @if (count($resultadoSignosQueLeFaltaronAlUsuarioTres) > 0)

                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Signos de puntuación no encontrados en tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes signos de puntuación no fueron encontrados en tu respuesta.</p>

                   
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSignosQueLeFaltaronAlUsuarioTres as $elemento)
                                <span id="signosQueLeFaltaronAlUsuarioTres" name="signosQueLeFaltaronAlUsuarioTres" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                   
                        
                    </div>
                    
                @endif


                <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
                QUE ESTEN INCORRECTAS -->
                @if (count($resultadoSeccionesQueLeFaltaronAlUsuarioTres) > 0)
                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Secciones de la respuesta correcta no encontradas en tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Las siguientes secciones no se encontraron en tu respuesta.</p>

                        
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSeccionesQueLeFaltaronAlUsuarioTres as $elemento)
                                <span id="seccionesQueLeFaltaronAlUsuarioTres" name="seccionesQueLeFaltaronAlUsuarioTres" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>
                @endif 
                

            </div>




            <!--//////////////////////////////////////////ORACION CUATRO -->


            <div class="container mt-10 w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-600">
                
                <!-- TITULO -->
                <header class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-red-500 font-sora text-center">Revisión respuesta cuatro:</h2>
                </header>
                <!-- OBSERVACION -->
                <div class="px-5 py-4 border-b border-gray-100">
                    <h4 class="font-semibold text-red-500 font-sora">Observación: </h4>
                    <h4 class="font-semibold text-gray-800 font-sora text-center text-xl">{{$respuestaOracionCuatro}}</h4>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                        <!-- RESPUESTA USUARIO -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tu respuesta:</h5>

                            <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                            MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->
                            @if ($existenEspaciosOracionCuatro)
                                <label class="text-gray-500">Si tu respuesta posee "_" dentro del enunciado, significa que agregaste espacios adicionales entre palabras o signos.</label>
                                <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$stringSeccionesOracionUsuarioCuatro}}</h4>
                                
                            @else
                            <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$stringSeccionesOracionUsuarioCuatro}}</h4>
                            @endif
                            
                        </div>
                        <!-- RESPUESTA CORRECTA -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Respuesta correcta:</h5>
                            <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$oracionCorrectaCuatro}}</h4>
                        </div>
                    </div>

                     <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES -->
                    @if (($hayUnEspacioEnBlancoOracionCuatro === true) && (count($resultadoSignosIncorrectosUsuarioCuatro) === 0) &&
                        (count($resultadoSignosQueLeFaltaronAlUsuarioCuatro) === 0) && (count($resultadoSeccionesQueLeFaltaronAlUsuarioCuatro) === 0))
                        
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">Revisa tu respuesta. Haz agregado espacios en blanco adicionales "_" en tu respuesta.</h5>

                        </div>  

                    @else

                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoOracionCuatro === true)
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">Revisa tu respuesta original. Haz agregado espacios en blanco adicionales "_" en tu respuesta.</h5>
                            
                            </div>
                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">
                                    A continuación, se muestra la revisión detallada de la respuesta.</h5>
                                <h5 class="font-bold font-sora text-black mt-4 ml-4 mb-5 text-center text-xl">
                                    *Se han eliminado los espacios adicionales que agregaste en tu respuesta*</h5>
                                
                            </div>
                        @else 

                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">
                                    A continuación, se muestra la revisión detallada de la respuesta.</h5>
                                
                            </div>

                        @endif

                        <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Revisión de tu respuesta:</h5>
                            <p class="text-lg mt-4 ml-4 mb-5">Si tu respuesta tiene elementos marcados de color rojo, posee elementos incorrectos. Estos elementos son incorrectos por alguna de las siguientes razones:</p>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado palabras incorrectas.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado signos de puntuación de forma incorrecta.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado una misma palabra más veces de las necesarias.</li>
                            <h4 id="oracionusuariocuatro" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionUsuarioCuatro}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Comparación con la respuesta correcta:</h5>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta no contiene la palabra marcada.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Has omitido la palabra marcada en tu respuesta.</li>
                            <h4 id="oracioncorrectacuatro" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionCorrectaCuatro}}</h4>
                        </div>


                    @endif 

                    <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                    {{--<div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Revisión de tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                        <h4 id="oracionusuariocuatro" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionUsuarioCuatro}}</h4>
                    </div>
                    <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Comparación con la respuesta correcta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                        <h4 id="oracioncorrectacuatro" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionCorrectaCuatro}}</h4>
                    </div>--}}
                
                @else 
                    <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
                    <!-- RESPUESTA DEL USUARIO -->

                    <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                        <!-- RESPUESTA USUARIO -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tu respuesta:</h5>
                            <h4 id="oracionusuariocuatro" class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$oracionUsuarioCuatro}}</h4>
                        </div>
                        <!-- RESPUESTA CORRECTA -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Respuesta correcta:</h5>
                            <h4 id="oracioncorrectacuatro" class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$oracionCorrectaCuatro}}</h4>
                        </div>
                    </div>

                @endif

                <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
                EN LA RESPUESTA -->
                @if (count($resultadoSeccionesIncorrectasOracionUsuarioCuatro) >0)
                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Elementos incorrectos de tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes elementos de tu respuesta son incorrectos.</p>

                        <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                        DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                        <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach (array_unique($resultadoSeccionesIncorrectasOracionUsuarioCuatro) as $key=>$elemento)
                                <span id="seccionesIncorrectasOracionUsuarioCuatro" name="seccionesIncorrectasOracionUsuarioCuatro" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>
                @endif

                <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
                @if (count($resultadoSignosIncorrectosUsuarioCuatro) > 0)

                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Elementos ortográficos incorrectos:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes elementos ortográficos incorrectos fueron encontrados en tu respuesta.</p>

                        
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSignosIncorrectosUsuarioCuatro as $elemento)
                                <span id="signosIncorrectosOracionUsuarioCuatro" name="signosIncorrectosOracionUsuarioCuatro" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>

                @endif


                <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
                NO PUSO EN SU RESPUESTA -->
                @if (count($resultadoSignosQueLeFaltaronAlUsuarioCuatro) > 0)

                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Signos de puntuación no encontrados en tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes signos de puntuación no fueron encontrados en tu respuesta.</p>

                        
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSignosQueLeFaltaronAlUsuarioCuatro as $elemento)
                                <span id="signosQueLeFaltaronAlUsuarioCuatro" name="signosQueLeFaltaronAlUsuarioCuatro" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>
                    
                @endif


                <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
                QUE ESTEN INCORRECTAS -->
                @if (count($resultadoSeccionesQueLeFaltaronAlUsuarioCuatro) > 0)
                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Secciones de la respuesta correcta no encontradas en tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Las siguientes secciones no se encontraron en tu respuesta.</p>

                        
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSeccionesQueLeFaltaronAlUsuarioCuatro as $elemento)
                                <span id="seccionesQueLeFaltaronAlUsuarioCuatro" name="seccionesQueLeFaltaronAlUsuarioCuatro" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>
                @endif 
                

            </div>




            <!--//////////////////////////////////////////ORACION CINCO -->


            <div class="container mt-10 w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-600">
                
                <!-- TITULO -->
                <header class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-red-500 font-sora text-center">Revisión respuesta cinco:</h2>
                </header>
                <!-- OBSERVACION -->
                <div class="px-5 py-4 border-b border-gray-100">
                    <h4 class="font-semibold text-red-500 font-sora">Observación: </h4>
                    <h4 class="font-semibold text-gray-800 font-sora text-center text-xl">{{$respuestaOracionCinco}}</h4>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                        <!-- RESPUESTA USUARIO -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tu respuesta:</h5>

                            <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $existenEspaciosEnunciadoUno ES TRUE, ENTONCES MUESTRA LA RESPUESTA CON LOS "_" Y EL
                            MENSAJE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA, PERO SI ES FALSE, ES DECIR NO TIENE ESPACIOS, SOLO SE MUESTRA LA RESPUESTA DEL USUARIO -->
                            @if ($existenEspaciosOracionCinco)
                                <label class="text-gray-500">Si tu respuesta posee "_" dentro del enunciado, significa que agregaste espacios adicionales entre palabras o signos.</label>
                                <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$stringSeccionesOracionUsuarioCinco}}</h4>
                                
                            @else
                            <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$stringSeccionesOracionUsuarioCinco}}</h4>
                            @endif
                            
                        </div>
                        <!-- RESPUESTA CORRECTA -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Respuesta correcta:</h5>
                            <h4 class="font-semibold text-gray-800 font-sora text-justify text-2xl">{{$oracionCorrectaCinco}}</h4>
                        </div>
                    </div>


                     <!-- LAS SIGUIENTES SECCIONES SOLO SE MUESTRAN SI EL USUARIO HA OMITIDO SIGNOS O PALABRAS EN SU RESPUESTA
                    SI SOLO TIENE ESPACIOS ADICIONALES EN BLANCO, NO SE MUESTRAN ESTAS SECCIONES -->
                    @if (($hayUnEspacioEnBlancoOracionCinco === true) && (count($resultadoSignosIncorrectosUsuarioCinco) === 0) &&
                        (count($resultadoSignosQueLeFaltaronAlUsuarioCinco) === 0) && (count($resultadoSeccionesQueLeFaltaronAlUsuarioCinco) === 0))
                        
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">Revisa tu respuesta. Haz agregado espacios en blanco adicionales "_" en tu respuesta.</h5>

                        </div>  

                    @else

                        <!-- SI LA RESPUESTA TIENE ESPACIOS EN BLANCO Y ADEMAS TIENE OTROS ELEMENTOS INCORRECTOS QUE APAREZCA ESTE MENSAJE -->
                        @if ($mensajeEspacioBlancoOracionCinco === true)
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">Revisa tu respuesta original. Haz agregado espacios en blanco adicionales "_" en tu respuesta.</h5>
                            
                            </div>
                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">
                                    A continuación, se muestra la revisión detallada de la respuesta.</h5>
                                <h5 class="font-bold font-sora text-black mt-4 ml-4 mb-5 text-center text-xl">
                                    *Se han eliminado los espacios adicionales que agregaste en tu respuesta*</h5>
                                
                            </div>
                        @else 

                            <!-- TITULO PARA MOSTRAR LA REVISION DETALLADA DE LA RESPUESTA -->
                            <div class="grid grid-cols-1 border-2 p-4">
                                <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">
                                    A continuación, se muestra la revisión detallada de la respuesta.</h5>
                                
                            </div>

                        @endif

                        <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Revisión de tu respuesta:</h5>
                            <p class="text-lg mt-4 ml-4 mb-5">Si tu respuesta tiene elementos marcados de color rojo, posee elementos incorrectos. Estos elementos son incorrectos por alguna de las siguientes razones:</p>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado palabras incorrectas.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado signos de puntuación de forma incorrecta.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Haz agregado una misma palabra más veces de las necesarias.</li>
                            <h4 id="oracionusuariocinco" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionUsuarioCinco}}</h4>
                        </div>
                        <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                        <div class="grid grid-cols-1 border-2 p-4">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Comparación con la respuesta correcta:</h5>
                            <p class="text-lg mt-4 ml-4 mb-5">Si tu respuesta contiene elementos marcados de color verde, dichos elementos hacen falta en tu respuesta. Estos elementos no se han encontrado en tu respuesta por alguna de las siguientes razones:</p>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta no contiene la palabra marcada.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta tiene la palabra marcada escrita de forma incorrecta.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Tu respuesta tiene signos de puntuación mal colocados en la sección de color verde.</li>
                            <li class="text-sm ml-4 mb-5 text-gray-800 font-semibold">Has omitido la palabra marcada en tu respuesta.</li>
                            <h4 id="oracioncorrectacinco" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionCorrectaCinco}}</h4>
                        </div>

                    @endif 

                    <!-- GRID QUE MUESTRA DE COLOR ROJO LOS ELEMENTOS INCORRECTOS DE LA RESPUESTA DEL USUARIO -->
                    {{--<div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Revisión de tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Se marcan de color rojo los elementos incorrectos de tu respuesta.</p>
                        <h4 id="oracionusuariocinco" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionUsuarioCinco}}</h4>
                    </div>
                    <!-- GRID QUE MUESTRA DE COLOR VERDE LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA ORACION DEL USUARIO -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Comparación con la respuesta correcta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Se marcan de color verde los elementos de la respuesta correcta que no se encontraron en tu respuesta.</p>
                        <h4 id="oracioncorrectacinco" class="font-semibold text-gray-800 font-sora text-justify text-xl md:text-2xl">{{$oracionCorrectaCinco}}</h4>
                    </div>--}}
                
                @else 
                    <!-- SI LA RESPUESTA ES CORRECTA SOLO SE MUESTRAN LA RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL -->
                    <!-- RESPUESTA DEL USUARIO -->

                    <!-- GRID CON DOS COLUMNAS UNA MUESTRA LA RESPUESTA DEL USUARIO Y OTRA LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                        <!-- RESPUESTA USUARIO -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tu respuesta:</h5>
                            <h4 id="oracionusuariocinco" class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$oracionUsuarioCinco}}</h4>
                        </div>
                        <!-- RESPUESTA CORRECTA -->
                        <div class="container mx-auto p-5">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Respuesta correcta:</h5>
                            <h4 id="oracioncorrectacinco" class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$oracionCorrectaCinco}}</h4>
                        </div>
                    </div>

                @endif

                <!-- PALABRAS Y SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA PALABRAS O SECCIONES INCORRECTAS
                EN LA RESPUESTA -->
                @if (count($resultadoSeccionesIncorrectasOracionUsuarioCinco) >0)
                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Elementos incorrectos de tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes elementos de tu respuesta son incorrectos.</p>

                        <!-- SE CAMBIO EL RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO POR EL RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO QUE ANALIZA TANTO PALABRAS COMO SECCIONES
                        DE LA RESPUESTA DEL USUARIO QUE ESTEN INCORRECTAS -->
                        <!-- SE AGREGA ARRAY_UNIQUE AL ARRAY PARA QUE NO MUESTRE ELEMENTOS REPETIDOS -->
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach (array_unique($resultadoSeccionesIncorrectasOracionUsuarioCinco) as $key=>$elemento)
                                <span id="seccionesIncorrectasOracionUsuarioCinco" name="seccionesIncorrectasOracionUsuarioCinco" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>
                @endif

                <!-- SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS INCORRECTOS EN SU RESPUESTA -->
                @if (count($resultadoSignosIncorrectosUsuarioCinco) > 0)

                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Elementos ortográficos incorrectos:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes elementos ortográficos incorrectos fueron encontrados en tu respuesta.</p>

                        
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSignosIncorrectosUsuarioCinco as $elemento)
                                <span id="signosIncorrectosOracionUsuarioCinco" name="signosIncorrectosOracionUsuarioCinco" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>

                @endif


                <!-- SIGNOS QUE LE FALTARON AL USUARIO UNO -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SIGNOS DE LA ORACION CORRECTA QUE
                NO PUSO EN SU RESPUESTA -->
                @if (count($resultadoSignosQueLeFaltaronAlUsuarioCinco) > 0)

                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Signos de puntuación no encontrados en tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Los siguientes signos de puntuación no fueron encontrados en tu respuesta.</p>

                        
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSignosQueLeFaltaronAlUsuarioCinco as $elemento)
                                <span id="signosQueLeFaltaronAlUsuarioCinco" name="signosQueLeFaltaronAlUsuarioCinco" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>
                    
                @endif


                <!-- SECCIONES QUE ESTAN INCORRECTAS DEL USUARIO UNO -->
                <!-- SE PONE CON IF PARA QUE EL DIV SOLO APAREZCA CUANDO EL USUARIO TENGA SECCIONES DE SU RESPUESTA
                QUE ESTEN INCORRECTAS -->
                @if (count($resultadoSeccionesQueLeFaltaronAlUsuarioCinco) > 0)
                    <!-- GRID QUE MUESTRA LAS PALABRAS O ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA -->
                    <div class="grid grid-cols-1 border-2 p-4">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Secciones de la respuesta correcta no encontradas en tu respuesta:</h5>
                        <p class="text-lg mt-4 ml-4 mb-5">Las siguientes secciones no se encontraron en tu respuesta.</p>

                        
                        <div>
                            <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                            @foreach ($resultadoSeccionesQueLeFaltaronAlUsuarioCinco as $elemento)
                                <span id="seccionesQueLeFaltaronAlUsuarioCinco" name="seccionesQueLeFaltaronAlUsuarioCinco" class="font-semibold text-gray-800 font-sora text-center text-xl md:text-2xl ml-4">{{$elemento}}</span>
                                <span class="font-semibold text-red-500 font-sora text-center text-xl md:text-2xl ml-4"> | </span>
                                
                            @endforeach
                        </div>
                        
                    </div>
                @endif 
                

            </div>




            


            <!-- DIV QUE CONTIENE EL TITULO DE REGLAS QUE SE TOMARON EN CUENTA Y UNA DESCRIPCION -->
            <div class="container mx-auto rounded-3xl p-5">
                <h4 class="text-2xl md:text-2xl text-left font-anton text-red-700 m-5 pb-5">Reglas ortográficas que se tomaron en cuenta para esta actividad:</h4>
                <li class="text-xl font-sora mb-5 text-justify">En la siguiente sección se presentan las reglas ortográficas que se emplearon para la realización de esta actividad.</li>
                <li class="text-xl font-sora mb-5 text-justify">Haz click en la regla ortográfica de tu interés y accede a más información sobre el uso de esa regla ortográfica.</li>
                <li class="text-xl font-sora mb-5 text-justify">Adicionalmente, tienes algunas aclaraciones sobre la actividad que acabas de realizar.</li>
            </div>


            <!-- DIV QUE CONTIENE LAS REGLAS ORTOGRÁFICAS ASOCIADAS Y LAS JUSTIFICACIONES -->
            <div class="container mt-10 w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-600" >
                {{--<header class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-red-500 font-sora">Reglas ortográficas tomaron en cuenta para esta actividad:</h2>
                </header>--}}

                <!-- TABLA CON DOS COLUMNAS QUE CONTIENE LAS JUSTIFICACIONES Y LA REGLA ASOCIADA -->
                <div class="p-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full">
                            <thead class=" bg-gray-200 rounded-2xl">
                                <tr>
                                    {{--<th class="p-2 whitespace-nowrap">
                                        <div class=" text-center font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Regla ortográfica</div>
                                    </th>--}}
                                    <th class="p-2 whitespace-nowrap">
                                        <div class=" text-center font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Explicación a la respuesta:</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100">

                                <!-- RECORRER LAS JUSTIFICACIONES DE RESPUESTA -->
                                @foreach ($questionType->justifications as $justification)
                                    <tr>
                                        {{--<td class="p-2 whitespace-nowrap ">
                                            <div class="text-center font-sora font-medium text-xl">{{$justification->rule}}</div>
                                        </td>--}}
                                        <td>
                                            <p class="text-justify font-sora text-lg m-2">{{$justification->reason}}</p>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>



                




                <!-- SECCION QUE CONTIENE LAS REGLAS PARA IR A CADA UNA DE ELLAS -->
                <!-- ESTE DIV CONTIENE A LOS 3 TIPOS DE REGLAS ORTOGRAFICAS -->
                <div class="grid grid-cols-1  divide-y md:divide-y-0 md:divide-x-0 divide-gray-800 rounded">
                    <div class="container bg-slate-300 border-y border-slate-200">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">Haz click en la regla ortográfica de tu interés a continuación para acceder a más información:</h5>
                    </div>

                    <!-- REGLAS ORTOGRAFICAS DE PALABRAS -->
                    <!-- CON EL IF SE PREGUNTA MEDIANTE LAS VARIABLES HAYPALABRAS SI ALGUNA DE ELLAS ES TRUE, LO QUE SIGNIFICA QUE HAY REGLAS ORTOGRAFICAS DE ESE NIVEL -->
                    @if (($haypalabrasencategories === true) || ($haypalabrasensections === true) || ($haypalabrasenposts === true) || ($haypalabrasenrules === true) || ($haypalabrasennotes === true))
                        <div class="grid grid-cols-1">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4">Reglas ortográficas de palabras:</h5>
                            <div class="container mx-auto p-5">

                                <!-- SI HAY REGLAS ORTOGRAFICAS DE PALABRAS DE CUALQUIER NIVEL, AHORA PREGUNTAR INDIVIDUALMENTE PARA IR MOSTRANDO LAS REGLAS ORTOGRAFICAS -->
                                @if ($haypalabrasencategories === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL UNO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION CATEGORIES -->
                                    @foreach ($questionType->categories as $categoryrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES PALABRAS -->
                                        @if ($categoryrule->type === "Reglas ortográficas de palabras")
                                            {{--<a href="/estudiante/letters/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$categoryrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/letters/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$categoryrule->name}}</button>
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
                                            <a href="/estudiante/letters/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$sectionrule->name}}  </button>
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
                                            <a href="/estudiante/letters/{{$categorypalabras->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$postrule->name}} </button>
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
                                            <a href="/estudiante/letters/{{$categoryrulepalabras->slug}}/{{$sectionrulepalabras->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$rulerule->name}}</button>
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
                                            <a href="/estudiante/letters/{{$categoryrulepalabras->slug}}/{{$sectionrulepalabras->slug}}/{{$postrulepalabras->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$noterule->name}}</button>
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
                        <div class="grid grid-cols-1">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4">Reglas ortográficas de acentuación:</h5>
                            <div class="container mx-auto p-5">
                                <!-- SI HAY REGLAS ORTOGRAFICAS DE ACENTUACION DE CUALQUIER NIVEL, AHORA PREGUNTA INDIVIDUALMENTE PARA IR MOSTRANDO LAS REGLAS ORTOGRAFICAS -->
                                @if ($hayacentuacionencategories === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL UNO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION CATEGORIES -->
                                    @foreach ($questionType->categories as $categoryrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES ACENTUACION -->
                                        @if ($categoryrule->type === "Reglas ortográficas de acentuación")
                                            {{--<a href="/estudiante/acentuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$categoryrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/acentuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$categoryrule->name}}</button>
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
                                            <a href="/estudiante/acentuation/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$sectionrule->name}}</button>
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
                                            <a href="/estudiante/acentuation/{{$categoryacentuacion->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$postrule->name}}</button>
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
                                            <a href="/estudiante/acentuation/{{$categoryruleacentuacion->slug}}/{{$sectionruleacentuacion->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$rulerule->name}}</button>
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
                                            <a href="/estudiante/acentuation/{{$categoryruleacentuacion->slug}}/{{$sectionruleacentuacion->slug}}/{{$postruleacentuacion->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$noterule->name}}</button>
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
                        <div class="grid grid-cols-1">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4">Reglas ortográficas de puntuación:</h5>
                            <div class="container mx-auto p-5">
                                <!-- SI HAY REGLAS ORTOGRAFICAS DE PUNTUACION DE CUALQUIER NIVEL, AHORA PREGUNTAR INDIVIDUALMENTE PARA IR MOSTRANDO LAS REGLAS ORTOGRAFICAS -->
                                @if ($haypuntuacionencategories === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL UNO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION CATEGORIES -->
                                    @foreach ($questionType->categories as $categoryrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PUNTUACION -->
                                        @if ($categoryrule->type === "Reglas ortográficas de puntuación")
                                            {{--<a href="/estudiante/punctuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$categoryrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/punctuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$categoryrule->name}}</button>
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
                                            <a href="/estudiante/punctuation/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$sectionrule->name}}</button>
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
                                            <a href="/estudiante/punctuation/{{$categorypuntuacion->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$postrule->name}}</button>
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
                                            <a href="/estudiante/punctuation/{{$categoryrulepuntuacion->slug}}/{{$sectionrulepuntuacion->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$rulerule->name}}</button>
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
                                            <a href="/estudiante/punctuation/{{$categoryrulepuntuacion->slug}}/{{$sectionrulepuntuacion->slug}}/{{$postrulepuntuacion->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$noterule->name}}</button>
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

    </div>





    <!-- ///////////////////////////////////////////////////////FIN NUEVA VISTA RESULTADOS PREGUNTA OA/////////////////////////////////// -->

   

    <!-- SCRIPT JUEGO -->
    <script src="{{asset('/js/resaltaroa.js')}}"></script>
</x-app-layout>