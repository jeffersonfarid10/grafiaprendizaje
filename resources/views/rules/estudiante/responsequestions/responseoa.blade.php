<x-app-layout>

    <!-- /////////////////////////////////////////////////////////////NUEVA VISTA RESPONDER PREGUNTA OA//////////////////////////////  -->

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


            <!-- ACTUALIZACION -->
            <!-- SE CREA UN GRID QUE VA A TENER COLUMNA CUANDO LA PANTALLA SEA PEQUEÑA Y DOS COLUMNAS CUANDO LA PANTALLA SEA GRANDE
            EN LA COLUMNA DE LA IZQUIERDA SE COLOCAN LAS REGLAS ORTOGRAFICAS Y EN LA COLUMNA DE LA DERECHA EL EJERCICIO -->
            <!-- CON UN ISSET SE PREGUNTA SI ESTA ENVIANDO INFORMACION DE REGLAS ORTOGRAFICAS, LO QUE SIGNIFICA QUE EL USUARIO ESTA EN ALGUNA DE LAS ACTIVIDADES DE PRACTICA 
            SI ES ASI ENTONCES MUESTRA DOS COLUMNAS, CASO CONTRARIO SOLO MUESTRA LA COLUMNA DE RESPONDER PREGUNTA -->
            @isset($question->rule)
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <!-- COLUMNA INFORMACION REGLAS ORTOGRAFICAS -->
                    <div class="container mt-10 w-full mx-auto bg-amber-100 shadow-lg rounded-3xl border border-gray-200">
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


                    <!-- COLUMNA RESPONDER PREGUNTA -->
                    <div class="container mt-10 w-full mx-auto bg-amber-100 shadow-lg rounded-3xl border border-gray-200">
                        <header class="px-5 pt-4 mb-4">
                            <h2 class="font-semibold font-sora text-red-500 text-center text-2xl">Responda a la pregunta:</h2>
                        </header>
                        <!-- DIV QUE CONTIENE LA IMAGEN -->
                        <!-- IMAGEN -->
                        <div class="container mx-auto p-10">
                            <div class="mx-auto">
                                <!-- IMPORTANTE PONER LA LINEA DIAGONAL AL INICIO DE LA RUTA EN LAS IMAGENES DE LAS REGLAS DE NIVEL UNO PARA ADELANTE PORQUE SINO NO VA A APARECER LA IMAGEN -->
                                <img id="image" name="image" src="/storage/{{$question->image}}" alt="" class="w-full h-full object-cover object-center rounded-lg shadow-2xl">
                            </div>
                        </div> 
                        <!-- DIV QUE CONTIENE EL AUDIO -->
                        <div class="container mx-auto p-10 border-y border-slate-400">
                            <label class="font-title font-sora font-semibold mb-10 text-xl text-red-500">Reproduzca el audio: </label>
                            <div class="mt-10">
                                <audio id="audio" name="audio" controls src="/storage/{{$question->audio}}" type="audio" controls>Tu navegador no soporta este elemento, utiliza otro navegador.</audio>
                            </div>
                        </div>

                        <!-- DIV QUE CONTIENE LOS INPUT PARA LAS RESPUESTAS DEL USUARIO -->
                        <div class="container mx-auto mt-10 rounded"> 
                            <form action="{{route('estudiante.save.oa')}}" method="POST">
                                @csrf 
                                <div class="w-full mx-auto bg-amber-100 rounded-3xl">
                                    <header class="px-5 py-4 border-b border-gray-100">
                                        <h2 class="font-semibold text-red-500 font-sora text-lg">Escriba los enunciados correctamente:</h2>
                                    </header>
                                    <div class="p-3">
                                        <div class="overflow-x-auto">
                                            <table class="table-auto w-full">
                                                <tbody class="text-sm divide-y divide-gray-100">

                                                    <!-- MOSTRAR 5 INPUTS PARA QUE EL ESTUDIANTE INGRESE LAS ORACIONES -->
                                                    @for($i=0; $i<5; $i++)
                                                        <tr>
                                                            <td class="p-2 whitespace-nowrap ">
                                                                <div class="text-center text-lg font-sora font-bold inline-block">Respuesta al enunciado {{$i+1}} :</div>
                                                            </td>
                                                            <td class="p-2 whitespace-nowrap content-center w-4/5">
                                                                <input type="text" name="fanswers[]" class="inline-block rounded w-full" placeholder="Ingrese el enunciado correctamente escrito {{$i+1}}" value="{{old('answer_user')}}" spellcheck="false" autocomplete="off" required>
                                                            </td>
                                                        </tr> 
                                                        @endfor
                                                        

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- ID DE LA PREGUNTA ACTUAL -->
                                    <input type="hidden" name="question_id" value="{{$question->id}}">
                                    <br>
                                    <div class="px-5 py-4 border-b border-gray-100 text-center">
                                        
                                            <!-- BOTON DE INGRESO -->
                                            <button class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                                                Guardar respuesta
                                            </button>
                                    
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>


                </div>

            @else 
                <!-- SI EL ESTUDIANTE SE ENCUENTRA EN LA EVALUACION FINAL O EVALUACION DE DIAGNOSTICO ENTONCES QUE EN UNA COLUMNA SE MUESTRE LA IMAGEN Y EL AUDIO
                Y EN OTRA EL ESPACIO PARA RESPONDER -->
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <!-- COLUMNA PARA IMAGEN Y EL AUDIO -->
                    <div class="container mt-10 w-full mx-auto bg-amber-100 shadow-lg rounded-3xl border border-gray-200">
                        <header class="px-5 pt-4 mb-4">
                            <h2 class="font-semibold font-sora text-red-500 text-center text-2xl">Imagen y audio</h2>
                        </header>
                        <!-- DIV QUE CONTIENE LA IMAGEN -->
                        <!-- IMAGEN -->
                        <div class="container mx-auto p-10">
                            <div class="mx-auto">
                                <!-- IMPORTANTE PONER LA LINEA DIAGONAL AL INICIO DE LA RUTA EN LAS IMAGENES DE LAS REGLAS DE NIVEL UNO PARA ADELANTE PORQUE SINO NO VA A APARECER LA IMAGEN -->
                                <img id="image" name="image" src="/storage/{{$question->image}}" alt="" class="w-full h-full object-cover object-center rounded-lg shadow-2xl">
                            </div>
                        </div> 
                        <!-- DIV QUE CONTIENE EL AUDIO -->
                        <div class="container mx-auto p-10 border-y border-slate-400">
                            <label class="font-title font-sora font-semibold mb-10 text-xl text-red-500">Reproduzca el audio: </label>
                            <div class="mt-10">
                                <audio id="audio" name="audio" controls src="/storage/{{$question->audio}}" type="audio" controls>Tu navegador no soporta este elemento, utiliza otro navegador.</audio>
                            </div>
                        </div>
                    </div>
                    
                    <!-- COLUMNA PARA RESPONDER A LA PREGUNTA -->
                    <div class="container mt-10 w-full mx-auto bg-amber-100 shadow-lg rounded-3xl border border-gray-200">
                        <header class="px-5 pt-4 mb-4">
                            <h2 class="font-semibold font-sora text-red-500 text-center text-2xl">Responda a la pregunta:</h2>
                        </header>
                        <!-- DIV QUE CONTIENE LOS INPUT PARA LAS RESPUESTAS DEL USUARIO -->
                        <div class="container mx-auto mt-10 rounded"> 
                            <form action="{{route('estudiante.save.oa')}}" method="POST">
                                @csrf 
                                <div class="w-full mx-auto bg-amber-100 rounded-3xl">
                                    <header class="px-5 py-4 border-b border-gray-100">
                                        <h2 class="font-semibold text-red-500 font-sora text-lg">Escriba los enunciados correctamente:</h2>
                                    </header>
                                    <div class="p-3">
                                        <div class="overflow-x-auto">
                                            <table class="table-auto w-full">
                                                <tbody class="text-sm divide-y divide-gray-100">

                                                    <!-- MOSTRAR 5 INPUTS PARA QUE EL ESTUDIANTE INGRESE LAS ORACIONES -->
                                                    @for($i=0; $i<5; $i++)
                                                        <tr>
                                                            <td class="p-2 whitespace-nowrap ">
                                                                <div class="text-center text-lg font-sora font-bold inline-block">Respuesta al enunciado {{$i+1}} :</div>
                                                            </td>
                                                            <td class="p-2 whitespace-nowrap content-center w-4/5">
                                                                <input type="text" name="fanswers[]" class="inline-block rounded w-full" placeholder="Ingrese el enunciado correctamente escrito {{$i+1}}" value="{{old('answer_user')}}" spellcheck="false" autocomplete="off" required>
                                                            </td>
                                                        </tr> 
                                                        @endfor
                                                        

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- ID DE LA PREGUNTA ACTUAL -->
                                    <input type="hidden" name="question_id" value="{{$question->id}}">
                                    <br>
                                    <div class="px-5 py-4 border-b border-gray-100 text-center">
                                        
                                            <!-- BOTON DE INGRESO -->
                                            <button class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                                                Guardar respuesta
                                            </button>
                                    
                                    </div>
                                </div>
                            </form>
                        </div>

                    <div>
                </div>
            @endisset


            <!-- ACTUALIZACION -->
            <!-- SE COMPRUEBA SI EL EJERCICIO CONTIENE EL CAMPO RULES DE LA TABLA QUESTIONS
            SI ES ASÍ, ENTONCES SE MUESTRA LAS REGLAS ORTOGRAFICAS QUE SOLO SE DEBEN MOSTRAR EN LAS ACTIVIDADES DE PRACTICA -->
            {{--@isset ($question->rule)
                <div class="container mx-auto mt-10 rounded">
                    <div class="w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-200">
                        <header class="px-5 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-red-500 font-sora">Tome en cuenta las siguiente información para responder a la pregunta:</h2>
                        </header>
            --}}
                        <!-- PARA MOSTRAR EL TEXTO DE CK EDITOR CON LOS ESTILOS SE CORRE EL SIGUIENTE COMANDO -->
                        {{-- npm install -D @tailwindcss/typography --}}
                        <!-- Y SE DEBE CREAR UN DIV CON LA CLASE:  class="prose lg:prose-xl" -->
            {{--            <div class="p-4 ml-5 md:ml-10 lg:ml-20 overflow-auto prose lg:prose-2xl text-justify">
                                {!!$question->rule!!}
                        </div>
                    </div>
                </div>
            @endisset
            --}}

            <!-- DIV QUE CONTIENE LA IMAGEN -->
            <!-- IMAGEN -->
            {{--<div class="container mx-auto p-10">
                <div class="w-4/5 mx-auto">
                    <!-- IMPORTANTE PONER LA LINEA DIAGONAL AL INICIO DE LA RUTA EN LAS IMAGENES DE LAS REGLAS DE NIVEL UNO PARA ADELANTE PORQUE SINO NO VA A APARECER LA IMAGEN -->
                    <img id="image" name="image" src="/storage/{{$question->image}}" alt="" class="w-full h-full object-cover object-center rounded-lg shadow-red-200 shadow-2xl">
                </div>
            </div> --}}

            <!-- DIV QUE CONTIENE EL AUDIO -->
            {{--<div class="container mx-auto p-10 bg-slate-300 rounded-xl">
                <label class="font-title font-sora font-semibold mb-10 text-xl text-red-500">Reproduzca el audio: </label>
                <div class="mt-10">
                    <audio id="audio" name="audio" controls src="/storage/{{$question->audio}}" type="audio" controls>Tu navegador no soporta este elemento, utiliza otro navegador.</audio>
                </div>
            </div>--}}


            <!-- DIV QUE CONTIENE LOS INPUT PARA LAS RESPUESTAS DEL USUARIO -->
            {{--<div class="container mx-auto mt-10 rounded"> 
                <form action="{{route('estudiante.save.oa')}}" method="POST">
                    @csrf 
                    <div class="w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-200">
                        <header class="px-5 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-800 font-sora">Escriba las oraciones correctamente:</h2>
                        </header>
                        <div class="p-3">
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full">
                                    <tbody class="text-sm divide-y divide-gray-100">

                                        <!-- MOSTRAR 5 INPUTS PARA QUE EL ESTUDIANTE INGRESE LAS ORACIONES -->
                                        @for($i=0; $i<5; $i++)
                                            <tr>
                                                <td class="p-2 whitespace-nowrap ">
                                                    <div class="text-center text-lg font-sora font-bold inline-block">Respuesta a la oración {{$i+1}} :</div>
                                                </td>
                                                <td class="p-2 whitespace-nowrap content-center w-4/5">
                                                    <input type="text" name="fanswers[]" class="inline-block rounded w-full" placeholder="Ingrese la oración correctamente escrita {{$key+1}}" value="{{old('answer_user')}}" spellcheck="false" required>
                                                </td>
                                            </tr> 
                                            @endfor
                                             

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- ID DE LA PREGUNTA ACTUAL -->
                        <input type="hidden" name="question_id" value="{{$question->id}}">
                        <br>
                        <div class="px-5 py-4 border-b border-gray-100 text-center">
                            
                                <!-- BOTON DE INGRESO -->
                                <button class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                                    Guardar respuesta
                                </button>
                           
                        </div>
                    </div>
                </form>
            </div>--}}

        </div>  

    </div>


    <!-- ////////////////////////////////////////////////////////////////FIN NUEVA VISTA RESPONDER PREGUNTA OA//////////////////////////////// -->


    <!-- SCRIPT PARA DESHABILITAR EL BOTON DERECHO -->
    <script type="text/javascript">
        window.oncontextmenu = function () {
            console.log("Click derecho desactivado");
            return false;
        }
    </script>
    
</x-app-layout>