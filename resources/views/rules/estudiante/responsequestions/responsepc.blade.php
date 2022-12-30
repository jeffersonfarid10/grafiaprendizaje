<x-app-layout>

    <!-- /////////////////////////////////////////////////////////////////////NUEVA VISTA RESPONDER PREGUNTA PC///////////////////////////////// -->

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
            <!-- SE CREA UN GRID QUE VA A TENER UNA COLUMNA CUANDO LA PANTALLA SEA PEQUEÑA Y DOS COLUMNAS CUANDO LA PANTALLA SEA GRANDE 
            EN LA COLUMNA DE LA IZQUIERDA SE COLOCAN LAS REGLAS ORTOGRAFICAS Y EN LA COLUMNA DE LA DERECHA EL EJERCICIO-->
            <!-- CON UN ISSET SE PREGUNTA SI ESTA ENVIANDO INFORMACION DE REGLAS ORTOGRAFICAS, LO QUE SIGNIFICA QUE EL USUARIO ESTA EN ALGUNA DE LAS ACTIVIDADES DE PRACTICA -->
            <!-- SI ES ASI ENTONCES MUESTRA LAS DOS COLUMNAS, CASO CONTRARIO SOLO MUESTRA LA COLUMNA DE RESPONDER PREGUNTA -->
            @isset($question->rule)
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <!-- COLUMNA INFORMACION REGLAS ORTOGRAFICAS -->
                    <div class="container mt-10 w-full mx-auto bg-amber-100 shadow-lg rounded-3xl border border-gray-200">
                        <div class="w-full mx-auto rounded-3xl">
                            <header class="px-5 py-4">
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

                    <!-- COLUMNA RESPONDER PREGUNTA -->
                    <div class="container mt-10 w-full mx-auto bg-amber-100 shadow-lg rounded-3xl border border-gray-200">
                        <header class="px-5 pt-4">
                            <h2 class="font-semibold font-sora text-red-500 text-center text-2xl">Responda a la pregunta:</h2>
                        </header>
                        <!-- DIV QUE CONTIENE LAS PALABRAS INCORRECTAS Y LOS INPUT PARA LAS RESPUESTAS DEL USUARIO -->
                        <!-- DIV QUE CONTIENE LAS PALABRAS INCORRECTAS Y LOS INPUT PARA LAS RESPUESTAS DEL USUARIO -->
                    <div class="container mx-auto mt-10 rounded"> 
                        <form action="{{route('estudiante.save.pc')}}" method="POST">
                            @csrf 
                            <div class="w-full mx-auto bg-amber-100">
                                <header class="px-5 py-4 border-b border-gray-100">
                                    <h2 class="font-semibold text-red-500 font-sora text-lg">Escriba las palabras correctamente:</h2>
                                </header>
                                <div class="p-3">
                                    <div class="overflow-x-auto">
                                        <table class="table-auto w-full">
                                            <tbody class="text-sm divide-y divide-gray-100">

                                                <!-- RECORRER LAS VISIBLES_ANSWERS QUE EL USUARIO DEBE CORREGIR -->
                                                <!-- ACTUALIZACION -->
                                                <!-- SE MUESTRAN 5 PALABRAS DEL BANCO DE PALABRAS DE 15 DISPONIBLES -->
                                                {{--@foreach ($question->answers as $key=>$answer)--}}
                                                @foreach ($optionsr as $key=>$answer)
                                                    <tr>
                                                        <td class="p-2 whitespace-nowrap ">
                                                            <div name="visible_answer" class="text-center text-xl font-sora font-bold inline-block">{{$answer->visible_answer}}</div>
                                                        </td>
                                                        <td class="p-2 whitespace-nowrap content-center">
                                                            <input type="text" name="fanswers[]" class="inline-block rounded" placeholder="Ingrese la respuesta {{$key+1}}" value="{{old('answer_user')}}" spellcheck="false" required>
                                                        </td>
                                                    </tr> 
                                                @endforeach
                                                    

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- ID DE LA PREGUNTA ACTUAL -->
                                <input type="hidden" name="question_id" value="{{$question->id}}">
                                <br>

                                <!-- ACTUALIZACION EN UN INPUT HIDDEN SE ENVIA LA COLECCION CON LAS PALABRAS RANDOM QUE SALIERON DEL BANCO DE PALABRAS PARA QUE RESPONDA EL USUARIO -->
                                <!-- SE RECORRE LA VARIABLE $optionsr COMO UN ARRAY PORQUE SI SE RECORRE COMO EN LA LINEA COMENTADA EN EL CONTROLADOR SE RECIBE COMO STRING -->
                                <!-- Y NECESITO RECIBIR UN ARRAY -->
                                {{--<input type="hidden" name="optionsr" value="{{$optionsr}}">--}}
                                @foreach ($optionsr as $optionfinal)
                                    <input type="hidden" name="opcionesfinales[]" value="{{$optionfinal->answer}}">
                                @endforeach

                                <!-- ADICIONALMENTE SE ENVIA SOLO LOS NUMS DE LAS OPCIONES DE RESPUESTA CORRECTAS -->
                                @foreach ($optionsr as $optionfinal)
                                    <input type="hidden" name="numfinales[]" value="{{$optionfinal->id}}">
                                @endforeach

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

                <!-- SI EL ESTUDIANTE SE ENCUENTRA EN LA EVALUACION DE DIAGNOSTICO O EVALUACION FINAL ENTONCES SOLO SE MUESTRA LA COLUMNA PARA ESCRIBIR LAS PALABRAS CORRECTAS -->
                <!-- COLUMNA RESPONDER PREGUNTA -->
                <div class="container mt-10 w-full lg:w-3/5 mx-auto bg-amber-100 shadow-lg rounded-3xl border border-gray-200 ">
                    <header class="px-5 pt-4">
                        <h2 class="font-semibold font-sora text-red-500 text-center text-2xl">Responda a la pregunta:</h2>
                    </header>
                    <!-- DIV QUE CONTIENE LAS PALABRAS INCORRECTAS Y LOS INPUT PARA LAS RESPUESTAS DEL USUARIO -->
                    <div class="container mx-auto mt-10 rounded"> 
                        <form action="{{route('estudiante.save.pc')}}" method="POST">
                            @csrf 
                            <div class="w-full mx-auto bg-amber-100">
                                <header class="px-5 py-4 border-b border-gray-100">
                                    <h2 class="font-semibold text-red-500 font-sora text-lg">Escriba las palabras correctamente:</h2>
                                </header>
                                <div class="p-3">
                                    <div class="overflow-x-auto">
                                        <table class="table-auto w-full">
                                            <tbody class="text-sm divide-y divide-gray-100">

                                                <!-- RECORRER LAS VISIBLES_ANSWERS QUE EL USUARIO DEBE CORREGIR -->
                                                <!-- ACTUALIZACION -->
                                                <!-- SE MUESTRAN 5 PALABRAS DEL BANCO DE PALABRAS DE 15 DISPONIBLES -->
                                                {{--@foreach ($question->answers as $key=>$answer)--}}
                                                @foreach ($optionsr as $key=>$answer)
                                                    <tr>
                                                        <td class="p-2 whitespace-nowrap ">
                                                            <div name="visible_answer" class="text-center text-xl font-sora font-bold inline-block">{{$answer->visible_answer}}</div>
                                                        </td>
                                                        <td class="p-2 whitespace-nowrap content-center">
                                                            <input type="text" name="fanswers[]" class="inline-block rounded" placeholder="Ingrese la respuesta {{$key+1}}" value="{{old('answer_user')}}" spellcheck="false" required>
                                                        </td>
                                                    </tr> 
                                                @endforeach
                                                    

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- ID DE LA PREGUNTA ACTUAL -->
                                <input type="hidden" name="question_id" value="{{$question->id}}">
                                <br>

                                <!-- ACTUALIZACION EN UN INPUT HIDDEN SE ENVIA LA COLECCION CON LAS PALABRAS RANDOM QUE SALIERON DEL BANCO DE PALABRAS PARA QUE RESPONDA EL USUARIO -->
                                <!-- SE RECORRE LA VARIABLE $optionsr COMO UN ARRAY PORQUE SI SE RECORRE COMO EN LA LINEA COMENTADA EN EL CONTROLADOR SE RECIBE COMO STRING -->
                                <!-- Y NECESITO RECIBIR UN ARRAY -->
                                {{--<input type="hidden" name="optionsr" value="{{$optionsr}}">--}}
                                @foreach ($optionsr as $optionfinal)
                                    <input type="hidden" name="opcionesfinales[]" value="{{$optionfinal->answer}}">
                                @endforeach

                                <!-- ADICIONALMENTE SE ENVIA SOLO LOS NUMS DE LAS OPCIONES DE RESPUESTA CORRECTAS -->
                                @foreach ($optionsr as $optionfinal)
                                    <input type="hidden" name="numfinales[]" value="{{$optionfinal->id}}">
                                @endforeach

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



            <!-- DIV QUE CONTIENE LAS PALABRAS INCORRECTAS Y LOS INPUT PARA LAS RESPUESTAS DEL USUARIO -->
            {{--<div class="container mx-auto mt-10 rounded"> 
                <form action="{{route('estudiante.save.pc')}}" method="POST">
                    @csrf 
                    <div class="w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-200">
                        <header class="px-5 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-800 font-sora">Escriba la palabra correctamente:</h2>
                        </header>
                        <div class="p-3">
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full">
                                    <tbody class="text-sm divide-y divide-gray-100">

                                        <!-- RECORRER LAS VISIBLES_ANSWERS QUE EL USUARIO DEBE CORREGIR -->
                                        @foreach ($question->answers as $key=>$answer)
                                            <tr>
                                                <td class="p-2 whitespace-nowrap ">
                                                    <div name="visible_answer" class="text-center text-xl font-sora font-bold inline-block">{{$answer->visible_answer}}</div>
                                                </td>
                                                <td class="p-2 whitespace-nowrap content-center">
                                                    <input type="text" name="fanswers[]" class="inline-block rounded" placeholder="Ingrese la respuesta {{$key+1}}" value="{{old('answer_user')}}" spellcheck="false" required>
                                                </td>
                                            </tr> 
                                        @endforeach
                                             

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


    <!-- //////////////////////////////////////////////////////////////////////FIN NUEVA VISTA RESPONDER PREGUNTA PC/////////////////////////////////////// -->


    <!-- SCRIPT PARA DESHABILITAR EL BOTON DERECHO -->
    <script type="text/javascript">
        window.oncontextmenu = function () {
            console.log("Click derecho desactivado");
            return false;
        }
    </script>
    
</x-app-layout>