<x-app-layout>

    <!-- ////////////////////////////////////////////////////////////////NUEVA VISTA RESPONDER PREGUNTA JA////////////////////////////// -->

    <!-- SE CREA UN DIV PADRE QUE VA A SER DE COLOR BLANCO -->
    <div class="bg-white">

        <!-- SE CREA UN DIV HIJO CON CLASS CONTAINER Y QUE DEBE TENER OBLIGATORIAMENTE UN PT-24 PORQUE SINO EL NAVBAR FIXED VA A OCULTAR LA INFORMACION -->
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



            <!-- ACTUALIZACION -->
            <!-- SE COMPRUEBA SI EL EJERCICIO CONTIENE EL CAMPO RULES DE LA TABLA QUESTIONS
            SI ES ASÍ, ENTONCES SE MUESTRA LAS REGLAS ORTOGRAFICAS QUE SOLO SE DEBEN MOSTRAR EN LAS ACTIVIDADES DE PRACTICA -->
            @isset ($question->rule)
                <div class="container mt-10 w-3/5 mx-auto bg-amber-100 shadow-lg rounded-3xl border border-gray-200">
                    <div class="w-full mx-auto rounded-3xl">
                        <header class="px-5 py-4">
                            <h2 class="font-semibold text-red-500 font-sora text-2xl text-center">Tome en cuenta la siguiente información para responder a la pregunta:</h2>
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




            <!-- DIV QUE CONTIENE UN GRID CON 3 COLUMNAS, 1 COLUMNA ES PARA CADA TECLADO -->
            <div class="container mt-10 w-full mx-auto bg-amber-100 shadow-lg rounded-3xl border border-gray-200">
                <header class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-red-500 font-sora">Haz click en iniciar juego y encuentra la palabra faltante de la siguiente oración:</h2>
                    
                    <!-- MOSTRAR LA ORACION VISIBLE -->
                    @foreach ($question->answers as $answer)
                        <h1 class="font-semibold text-xl text-gray-800 font-sora m-5">{{$answer->visible_answer}}</h1>
                    @endforeach
                    

                     <!-- INPUT HIDDEN DONDE SE GUARDA LA RESPUESTA DEL JUEGO QUE SE VA A JS -->
                    <!-- AQUI NO SE PONE ID = ANSWER COMO EN LAS DEMAS PREGUNTAS SINO QUE SE CAMBIA EL NOMBRE DE LA VARIABLE
                    PORQUE SINO DA ERROR AL LEER LAS DEMAS PREGUNTAS -->
                    @foreach ($question->answers as $answer)
                        <input type="hidden" name="answerjuego" id="answerjuego" value="{{$answer->answer}}">
                    @endforeach

                </header>
                <div class="px-5 py-4 border-b border-gray-100 text-center">
                    <!-- BOTON INICIAR JUEGO -->
                    <a href="#">
                        <!-- BOTON DE INGRESO -->
                        <button id="iniciar_juego" class="border border-teal-500 bg-teal-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-teal-600 focus:outline-none focus:shadow-outline"
                        >
                            Iniciar juego
                        </button>
                    </a>
                </div>
                <div class="px-5 py-4 border-b border-gray-100 text-center">
                    <h2 class="font-semibold text-red-500 font-sora text-left">Tu respuesta:</h2>
                    <p id="palabra_adivinar" class="h-20 m-4 p-4">
                        <!-- AQUI SE VAN A MOSTRAR LOS GUIONES Y LAS LETRAS DE LA PALABRA SEGUN EL USUARIO VAYA JUGANDO -->
                    </p>
                </div>
                <div class="px-5 py-4 border-b border-gray-100 text-center">
                    <h2 class="font-semibold text-red-500 font-sora text-left">Tu resultado:</h2>
                    <!-- MOSTRAR UN MENSAJE DE SI EL USUARIO HA GANADO O PERDIDO -->
                    <p id="resultado" class="text-lg font-bold"></p>
                </div>
                <div id="letras" class="grid grid-cols-1 lg:grid-cols-4 divide-x divide-gray-300 rounded" >
                    <!-- IMAGEN -->
                    <div class="col-span-1 container mx-auto p-10 object-center">
                        <div class="w-4/5 mx-auto">
                            <!-- IMPORTANTE PONER LA LINEA DIAGONAL AL INICIO DE LA RUTA EN LAS IMAGENES DE LAS REGLAS DE NIVEL UNO PARA ADELANTE PORQUE SINO NO VA A APARECER LA IMAGEN -->
                            {{--<img src="/img/img0.png" id="imagen_juego" alt="" class=" object-cover object-center rounded-lg shadow-2xl">--}}
                            <!-- IMAGENES FINALES -->
                            <img src="{{asset('/imagenesja/imagen0.png')}}" id="imagen_juego" alt="" class=" object-cover object-center rounded-lg shadow-2xl">
                        </div>
                    </div>
                    <!-- DIV CON LOS BOTONES PARA QUE EL USUARIO HAGA CLICK EN EL BOTON -->
                    {{--<div id="letras" class="grid grid-cols-1 lg:grid-cols-3 divide-x divide-gray-300 rounded">--}}
                        <!-- COLUMNA CON LETRAS MAYUSCULAS -->
                        <div class="col-span-1">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Letras Mayúsculas</h5>
                            <div class="flex flex-wrap gap-2 m-4">
                                
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">A</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">B</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">C</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">D</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">E</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">F</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">G</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">H</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">I</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">J</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">K</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">L</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">M</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">N</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">Ñ</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">O</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">P</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">Q</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">R</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">S</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">T</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">U</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">V</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">W</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">X</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">Y</button>
                                <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">Z</button>
                            </div>
                        </div>
                        <!-- COLUMNA CON LETRAS MINUSCULAS -->
                        <div class="col-span-1">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Letras Minúsculas</h5>
                            <div class="flex flex-wrap gap-2 m-4">
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">a</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">b</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">c</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">d</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">e</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">f</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">g</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">h</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">i</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">j</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">k</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">l</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">m</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">n</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">ñ</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">o</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">p</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">q</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">r</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">s</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">t</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">u</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">v</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">w</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">x</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">y</button>
                                <button class="px-0 py-1 text-center w-6 bg-orange-500 rounded">z</button>
                            </div>
                        </div>
                        <!-- COLUMNA CON LETRAS CON TILDE Y DIERESIS -->
                        <div class="col-span-1">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4">Letras con tilde y diéresis</h5>
                            <div class="flex flex-wrap gap-2 m-4">
                                <button class="px-0 py-1 text-center w-6 bg-sky-400 rounded">á</button>
                                <button class="px-0 py-1 text-center w-6 bg-sky-400 rounded">é</button>
                                <button class="px-0 py-1 text-center w-6 bg-sky-400 rounded">í</button>
                                <button class="px-0 py-1 text-center w-6 bg-sky-400 rounded">ó</button>
                                <button class="px-0 py-1 text-center w-6 bg-sky-400 rounded">ú</button>
                                <button class="px-0 py-1 text-center w-6 bg-sky-400 rounded">ü</button>
                            </div>
                        </div>
                    {{--</div>--}}
                        
                </div>

                <!-- FORMULARIO QUE CAPTURA LA RESPUESTA DEL USUARIO SI GANO O PERDIO DESDE JS -->

                <div class="px-5 py-4 border-b border-gray-100 text-center">
                    <form action="{{route('estudiante.save.ja')}}" method="POST">
                        @csrf 

                        <!-- CAPTURAR SI LA RESPUESTA ES CORRECTA O INCORRECTA -->
                        <input type="hidden" name="answer_user" id="answer_user" value="{{old('answer_user')}}">

                        <!-- ID DE LA PREGUNTA ACTUAL -->
                        <input type="hidden" name="question_id" value="{{$question->id}}">

                        <h2 class="font-semibold text-red-500 font-sora text-left">Haz click en el siguiente botón para guardar la respuesta y regresar al cuestionario:</h2>

                            <!-- BOTON FORMULARIO -->
                            <button id="guardar_respuesta"   class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                                Guardar respuesta
                            </button>
                    </form>
                </div>
            </div>

        </div>

    </div>



    <!-- ///////////////////////////////////////////////////////////////FIN NUEVA VISTA RESPONDER PREGUNTA JA//////////////////////////////////// -->
 
   

    <!-- SCRIPT JUEGO -->
    {{--<script src="{{asset('/js/juegoahorcado.js')}}"></script>--}}
    <script src="{{asset('/js/juegoahorcadoimagenesfinales.js')}}"></script>

    <!-- SCRIPT PARA DESHABILITAR EL BOTON DERECHO -->
    <script type="text/javascript">
        window.oncontextmenu = function () {
            console.log("Click derecho desactivado");
            return false;
        }
    </script>
</x-app-layout>