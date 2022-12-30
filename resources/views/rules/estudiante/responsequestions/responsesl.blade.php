<x-app-layout>

    <!-- ////////////////////////////////////////////////////////////////////NUEVA VISTA RESPONDER PREGUNTA SL/////////////////////////////////// -->

    <!-- SE CREA UN DIV PADRE QUE VA A SER DE COLOR BLANCO -->
    <div class="bg-white">

        <!-- SE CREA UN DIV HIJO CON CLASS CONTAINER Y QUE DEBE TENER OBLIGATORIAMENTE UN PT-24 PORQUE SINO EL NAVBAR FIXED VA A OCULTAR INFORMACION -->
        <div class="container mx-auto pt-24 p-12">


            <!-- BOTON DE REGRESAR AL LISTADO DE PREGUNTAS DEL EXAMEN -->
            <div class="px-5 py-4 border-b border-gray-300 text-left">

                <a href="{{route('estudiante.preguntasevaluacion', $evaluation)}}">
                    <!-- BOTON DE REGRESAR A LA EVALUACION -->
                    <button class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                        Regresar a las preguntas de la evaluación
                    </button>
                </a>

            </div>

            <!-- DIV QUE CONTIENE EL TITULO DE LA PREGUNTA Y LAS INDICACIONES -->
            <div class="container mx-auto rounded-3xl p-5">
                <h3 class="text-2xl md:text-3xl text-left font-anton text-slate-700">{{$question->title}}</h3>
                <br>
                <h4 class="text-2xl md:text-2xl text-left font-anton text-red-700 m-5 pb-5">Indicaciones de la pregunta:</h4>
                <!-- INDICACIONES -->
                @foreach ($question->indications as $key=>$indication)
                    <p class="text-xl font-sora mb-5 text-justify">{{$key+1}}. {{$indication->indication}}</p>
                @endforeach
                
            </div>

        </div>





        <!-- ACTUALIZACION -->
            <!-- SE COMPRUEBA SI EL EJERCICIO CONTIENE EL CAMPO RULES DE LA TABLA QUESTIONS
            SI ES ASÍ, ENTONCES SE MUESTRA LAS REGLAS ORTOGRAFICAS QUE SOLO SE DEBEN MOSTRAR EN LAS ACTIVIDADES DE PRACTICA -->
            @isset ($question->rule)
                <div class="container mt-10 w-3/5 mx-auto bg-amber-100 shadow-lg rounded-3xl border border-gray-200">
                    <div class="w-full mx-auto rounded-3xl">
                        <header class="px-5 py-4 ">
                            <h2 class="font-semibold text-red-500 font-sora text-2xl text-center">Tome en cuenta las siguiente información para responder a la pregunta:</h2>
                        </header>
                        <!-- PARA MOSTRAR EL TEXTO DE CK EDITOR CON LOS ESTILOS SE CORRE EL SIGUIENTE COMANDO -->
                        {{-- npm install -D @tailwindcss/typography --}}
                        <!-- Y SE DEBE CREAR UN DIV CON LA CLASE:  class="prose lg:prose-xl" -->
                        <div class="mx-auto p-5 overflow-auto prose lg:prose-lg text-justify">
                                {!!$question->rule!!}
                        </div>
                    </div>
                </div>
            @endisset



        <!-- DIV QUE CONTIENE DOS COLUMNAS PRINCIPALES EN LA PRIMERA SE MUESTRAN LAS ORACIONES A ENCONTRAR, EN LA SEGUNA LA SOPA DE LETRAS -->
        <div class="container mt-10 mb-20 w-full mx-auto bg-amber-100 shadow-lg rounded-3xl border border-gray-200">

            <!-- EN ESTA SECCION SE ENVIAN AL SCRIPT DE JS LAS PALABRAS PARA LA SOPA DE LETRAS -->
                    <!-- AQUI NO SE PONE ID = ANSWER COMO EN LAS DEMAS PREGUNTAS SINO QUE SE CAMBIA EL NOMBRE DE LA VARIABLE
                    PORQUE SINO DA ERROR AL LEER LAS DEMAS PREGUNTAS -->
                    <div class="row">
                        <div class="col" id="palabras_correctas">
                            {{--<h4>Palabras correctas</h4>--}}
                            <!-- ACTUALIZACIN -->
                            <!-- SE ENVIA LA VARIABLE $SOPALETRAS AL SCRIPT DE JS PARA QUE AGREGUE EN LA SOPA DE LETRAS, LAS PALABRAS ALEATORIAS ASIGNADAS -->
                            {{--@foreach ($question->answers as $key=>$answer)--}}
                            @foreach ($optionsopaletras as $key=>$answer)
                                <input type="hidden" name="answer" id="answer" value="{{$answer->answer}}">
                            @endforeach
                        </div>
                        <div class="col" id="palabras_incorrectas">
                            {{--<h4>Palabras incorrectas</h4>--}}
                            <!-- ACTUALIZACION -->
                            <!-- SE ENVIA LA VARIABLE $OPTIONSOPALETRAS AL SCRIPT DE JS PARA QUE AGREGUE EN LA SOPA DE LETRAS, LAS PALABRAS ALEATORIAS ASIGNADAS -->
                            {{--@foreach ($question->answers as $key=>$visible)--}}
                            @foreach ($optionsopaletras as $key=>$visible)
                                <input type="hidden" name="visible_answer" id="visible_answer" value="{{$visible->visible_answer}}">
                            @endforeach
                        </div>
                    </div>

            <header class="px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-red-500 font-sora">Haz click en "Iniciar juego" y encuentra las palabras correctas en la sopa de letras:</h2>
                <div class="text-center">

                        <!-- BOTON DE INICIAR JUEGO Y MOSTRAR LA SOPA DE LETRAS -->
                        <button id="empezar_juego" class="border border-teal-500 bg-teal-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-teal-600 focus:outline-none focus:shadow-outline">
                            Iniciar juego
                        </button>
                </div>
            </header>
           <!-- AQUI SE MUESTRAN LAS PALABRAS ENCONTRADAS -->
            <div class="container mx-auto px-5 py-4 border border-gray-700 rounded-xl bg-white w-full">
                <h2 class="font-semibold text-red-500 font-sora mb-4">Aquí puedes ver las palabras correctas que has encontrado:</h2>
                <h4 id="mensaje" class="font-semibold text-red-500 font-sora">Faltan 10 palabras por encontrar:</h4>
                <p id="listado_palabras" class="font-semibold text-green-700 font-sora m-4 overflow-auto"></p>

            </div>
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-red-500 font-sora">Haz click en "Finalizar juego" si has encontrado todas las palabras o quieres terminar el juego:</h2>
                <div class="text-center">

                        <!-- BOTON PARA FINALIZAR EL JUEGO Y MOSTRAR LA SOLUCION AL USUARIO -->
                        <button id="ver_respuesta" class="border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline">
                            Finalizar juego
                        </button>

                </div>
            </div>
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-red-500 font-sora">Haz click en el siguiente botón para guardar la respuesta y regresar al cuestionario:</h2>
                <div class="text-center">

                    <!-- FORMULARIO QUE CAPTURA LA RESPUESTA DEL USUARIO -->
                    <div>
                        <form action="{{route('estudiante.save.sl')}}" method="POST">
                            @csrf 

                            <!-- ACTUALIZACION -->
                            <!-- EN ESTE DIV SE CAPTURAN LAS PALABRAS QUE EL USUARIO DEBIA ENCONTRAR EN TOTAL Y SE ENVIAN AL CONTROLADOR -->
                            <div>
                                {{--<h4>Palabras correctas</h4>--}}
                                <!-- ACTUALIZACIN -->
                                <!-- SE ENVIA LA VARIABLE $SOPALETRAS AL SCRIPT DE JS PARA QUE AGREGUE EN LA SOPA DE LETRAS, LAS PALABRAS ALEATORIAS ASIGNADAS -->
                                {{--@foreach ($question->answers as $key=>$answer)--}}
                                @foreach ($optionsopaletras as $key=>$answer)
                                    <input type="hidden" name="palabrasporencontrar[]" value="{{$answer->id}}">
                                @endforeach
                            </div>
                
                            <!-- RESPUESTAS USUARIO -->
                            <div>
                                <input type="hidden" name="answer_user" id="answer_user" value="{{old('answer_user')}}">

                                <!-- ID DE LA PREGUNTA ACTUAL -->
                                <input type="hidden" name="question_id" value="{{$question->id}}">

                                <!-- ID DEL TOTAL DE PALABRAS QUE HA ENCONTRADO -->
                                <input type="hidden" name="totalpalabras" id="totalpalabras" value="{{old('totalpalabras')}}">

                                <!-- INPUT DONDE SE VAN A ALMACENAR LAS PALABRAS QUE VA ENCONTRANDO EL USUARIO -->
                                <input type="hidden" name="palabra_encontrada" id="palabra_encontrada" value="{{old('palabra_encontrada')}}"> 

                                <!-- INPUT DONDE SE GUARDA EL NUMERO TOTAL DE PALABRAS QUE INGRESARON MEDIANTE EL ALGORITMO A LA SOPA DE LETRAS -->
                                <input type="hidden" name="numeropalabrasasignadas" id="numeropalabrasasignadas" value="{{old('numeropalabrasasignadas')}}">

                                <!-- BOTON FORMULARIO -->
                                <button id="guardar_respuesta_sl" class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                                    Guardar respuesta
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <!-- AQUI SE MUESTRAN LAS PALABRAS ENCONTRADAS -->
            {{--<div class="container mx-auto px-5 py-4 border border-gray-700 rounded-xl bg-white w-full">
                <h2 class="font-semibold text-red-500 font-sora mb-4">Aquí puedes ver las palabras correctas que has encontrado:</h2>
                <h4 id="mensaje" class="font-semibold text-red-500 font-sora">Faltan 10 palabras por encontrar:</h4>
                <p id="listado_palabras" class="font-semibold text-green-700 font-sora m-4 overflow-auto"></p>

            </div>--}}
            
            <div class="grid grid-cols-1 lg:grid-cols-2 divide-x divide-gray-300 rounded" >
                <!-- COLUMNA PARA LAS ORACIONES -->
                <div class="col-span-1 ml-10 mb-10">
                    <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-lg">Cada enunciado posse una palabra escrita incorrectamente, encuentre la palabra bien escrita en la sopa de letras:</h5>
                    <div>
                        <!-- RECORRER LAS ORACIONES VISIBLES -->
                        <!-- ACTUALIZACION, LAS ORACIONES VISIBLES SE RECORREN EN FUNCION DE LAS PALABRAS ALEATORIAS ASIGNADAS -->
                        {{--@foreach ($question->answers as $key=>$oracion)--}}
                        @foreach ($optionsopaletras as $key=>$oracion)
                            <h2 class="font-semibold text-xl text-gray-800 font-sora m-5">{{$key+1}}. {{$oracion->second_answer}}</h2>
                        @endforeach
                        

                    </div>
                    
                </div>
                <!-- COLUMNA PARA LA SOPA DE LETRAS-->
                <div class="col-span-1 p-4 mx-auto bg-neutral-200 my-10">
                    
                    <!-- COLUMNA PARA LA SOPA DE LETRAS -->
                    <!-- LUGAR DONDE SE VA A CREAR LA SOPA DE LETRAS -->
                    
                    <div id="espacios">
                        <br>
                        
                        <br>
                        <div id="tabla"></div>
                        <br>
                        
                        <br> 
                    </div>
                </div>

            </div>
            
        </div>

    </div>




    <!-- ////////////////////////////////////////////////////////////////FIN NUEVA VISTA RESPONDER PREGUNTA SL/////////////////////////////////////// -->



    
    
    <!-- SCRIPT SOPA LETRAS -->
    <script src="{{asset('/js/sopaletraseventos.js')}}"></script>

    <!-- SCRIPT PARA DESHABILITAR EL BOTON DERECHO -->
    <script type="text/javascript">
        window.oncontextmenu = function () {
            console.log("Click derecho desactivado");
            return false;
        }
    </script>
</x-app-layout>