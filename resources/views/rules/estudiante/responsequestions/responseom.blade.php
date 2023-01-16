<x-app-layout>

    <!-- ///////////////////////////////////////////////////////NUEVA VISTA RESPONDER PREGUNTA OM/////////////////////////////////////// -->

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
            <!-- SE CREA UN GRID QUE VA A TENER UNA COLUMNA CUANDO LA PANTALLA SEA PEQUEÑA Y DOS COLUMNAS CUANDO LA PANTALLA SEA GRANDE 
            EN LA COLUMNA DE LA IZQUIERDA SE COLOCAN LAS REGLAS ORTOGRAFICAS Y EN LA COLUMNA DE LA DERECHA EL EJERCICIO-->
            <!-- CON UN ISSET SE PREGUNTA SI ESTA ENVIANDO INFORMACION DE REGLAS ORTOGRAFICAS, LO QUE SIGNIFICA QUE EL USUARIO ESTA EN ALGUNA DE LAS ACTIVIDADES DE PRACTICA
            SI ES ASI ENTONCES MUESTRA LAS DOS COLUMNAS, CASO CONTRARIO SOLO MUESTRA LA COLUMNA DE RESPONDER A LA PREGUNTA -->
            @isset($question->rule)
                 <div class="grid grid-cols-1 lg:grid-cols-2">
                    <!-- COLUMNA INFORMACION REGLAS ORTOGRAFICAS -->
                    <div class="container mt-10 w-full mx-auto bg-amber-100 shadow-lg rounded-3xl border border-gray-200">
                        <div class="w-full mx-auto">
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
                        <!-- DIV QUE CONTIENE LAS OPCIONES DE RESPUESTA -->
                        <div class="container mx-auto mt-10 rounded">

                            <div class="container mx-auto bg-amber-100 rounded-3xl">
                                <header class="px-5 py-4 border-b border-gray-100">
                                    <h2 class="font-semibold text-red-500 font-sora text-lg">Elija la opción correcta:</h2>
                                </header>
                                <!-- FORMULARIO PARA CAPTURAR LA RESPUESTA DEL USUARIO -->
                                <form action="{{route('estudiante.save.om')}}" method="POST">
                                    @csrf 
                                    <div class="p-3">
                                        <div class="overflow-x-auto">
                                            <table class="table-auto w-full">
                                                <tbody class="text-sm divide-y divide-gray-500 bg-white rounded-xl">

                                                    
                                                        
                                                        <!-- OPCIONES DE RESPUESTA -->
                                                        @foreach ($question->answers as $key=>$answer)
                                                            <tr>
                                                                <td class="p-2">
                                                                    <div class="text-left font-sora font-medium inline-block text-lg"><span class="text-red-500 font-semibold">Opción de respuesta {{$key+1}}.</span><br> {{$answer->answer}}</div>
                                                                </td>
                                                                <td class="p-2 whitespace-nowrap content-center">
                                                                    <input type="radio" name="answer_user" class="inline-block" value="{{$answer->answer}}" required> 
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                        <!-- ID PREGUNTA ACTUAL -->
                                                        <input type="hidden" name="question_id" value="{{$question->id}}">
                                                        <br>                                                      

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="px-5 py-4 border-b border-gray-100 text-center">

                                            <!-- BOTON DE INGRESO -->
                                            <button class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                                                Guardar respuesta
                                            </button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>         

                 </div>


            @else 
                 <!-- SI EL USUARIO ESTA EN LA EVALUACION DE DIAGNOSTICO O EVALUACION FINAL SOLO SE MUESTRA EL ESPACIO PARA RESPONDER A LA PREGUNTA -->
                 <!-- COLUMNA RESPONDER PREGUNTA -->
                 <div class="container mt-10 w-full mx-auto bg-amber-100 shadow-lg rounded-3xl border border-gray-200">
                    <header class="px-5 pt-4 mb-4">
                        <h2 class="font-semibold font-sora text-red-500 text-center text-2xl">Responda a la pregunta:</h2>
                    </header>
                    <!-- DIV QUE CONTIENE LAS OPCIONES DE RESPUESTA -->
                    <div class="container mx-auto mt-10 rounded">

                        <div class="container mx-auto bg-amber-100 rounded-3xl">
                            <header class="px-5 py-4 border-b border-gray-100">
                                <h2 class="font-semibold text-red-500 font-sora text-lg">Elija la opción correcta:</h2>
                            </header>
                            <!-- FORMULARIO PARA CAPTURAR LA RESPUESTA DEL USUARIO -->
                            <form action="{{route('estudiante.save.om')}}" method="POST">
                                @csrf 
                                <div class="p-3">
                                    <div class="overflow-x-auto">
                                        <table class="table-auto w-full">
                                            <tbody class="text-sm divide-y divide-gray-500 bg-white rounded-xl">

                                                
                                                    
                                                    <!-- OPCIONES DE RESPUESTA -->
                                                    @foreach ($question->answers as $key=>$answer)
                                                        <tr>
                                                            <td class="p-2">
                                                                <div class="text-left font-sora font-medium inline-block text-lg"><span class="text-red-500 font-semibold">Opción de respuesta {{$key+1}}.</span><br> {{$answer->answer}}</div>
                                                            </td>
                                                            <td class="p-2 whitespace-nowrap content-center">
                                                                <input type="radio" name="answer_user" class="inline-block" value="{{$answer->answer}}" required> 
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    <!-- ID PREGUNTA ACTUAL -->
                                                    <input type="hidden" name="question_id" value="{{$question->id}}">
                                                    <br>                                                      

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="px-5 py-4 border-b border-gray-100 text-center">

                                        <!-- BOTON DE INGRESO -->
                                        <button class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                                            Guardar respuesta
                                        </button>

                                </div>
                            </form>
                        </div>
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


            <!-- DIV QUE CONTIENE LAS OPCIONES DE RESPUESTA -->
            {{--<div class="container mx-auto mt-10 rounded">

                <div class="w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <h2 class="font-semibold text-gray-800 font-sora">Elija la opción correcta:</h2>
                    </header>
                    <!-- FORMULARIO PARA CAPTURAR LA RESPUESTA DEL USUARIO -->
                    <form action="{{route('estudiante.save.om')}}" method="POST">
                        @csrf 
                        <div class="p-3">
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full">
                                    <tbody class="text-sm divide-y divide-gray-100">

                                        
                                            
                                            <!-- OPCIONES DE RESPUESTA -->
                                            @foreach ($question->answers as $key=>$answer)
                                                <tr>
                                                    <td class="p-2 whitespace-nowrap ">
                                                        <div class="text-left font-sora font-medium inline-block">{{$key+1}}. {{$answer->answer}}</div>
                                                    </td>
                                                    <td class="p-2 whitespace-nowrap content-center">
                                                        <input type="radio" name="answer_user" class="inline-block" value="{{$answer->answer}}" required> 
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <!-- ID PREGUNTA ACTUAL -->
                                            <input type="hidden" name="question_id" value="{{$question->id}}">
                                            <br>                                                      

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="px-5 py-4 border-b border-gray-100 text-center">

                                <!-- BOTON DE INGRESO -->
                                <button class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                                    Guardar respuesta
                                </button>

                        </div>
                    </form>
                </div>
            </div>--}}

        </div>

    </div>


    <!-- ////////////////////////////////////////////////////////////FIN NUEVA VISTA RESPONDER PREGUNTA OM////////////////////////////////// -->


    <!-- SCRIPT PARA DESHABILITAR EL BOTON DERECHO -->
    <script type="text/javascript">
        window.oncontextmenu = function () {
            console.log("Click derecho desactivado");
            return false;
        }
    </script>
    
</x-app-layout>