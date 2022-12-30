<x-app-layout>

    <!-- //////////////////////////////////////////////NUEVA VISTA INDICE DE PREGUNTAS CON EL BOTON DE RESULTADOS////////////////////////// -->

    <!-- SE CREA UN DIV PADRE QUE VA A SER DE COLOR BLANCO -->
    <div class="bg-white">

        <!-- SE CREA UN DIV HIJO CON CLASS CONTAINER Y QUE DEBE TENER OBLIGATORIAMENTE UN PT-24 PORQUE SINO EL NAVBAR FIXED VA A OCULTAR LA INFORMACION -->
        <div class="container mx-auto pt-24 p-12">

            <!-- BOTON PARA REGRESAR -->
            @if ($evaluation->type === "D")
                <!-- SI EL TIPO DE LA EVALUACION ES D ENTONCES QUE REGRESE A LA PAGINA DE DIAGNOSTICO -->
                <a href="{{route('estudiante.diagnostico')}}">
                    <button class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                        Regresar a la página principal de diagnóstico
                    </button>
                </a>

            @elseif(($evaluation->type === "PU") || ($evaluation->type === "PD") || ($evaluation->type === "PT"))
                <!-- SI EL TIPO DE EVALUACION CORRESPONDE A ALGUNA DE LAS DE PRACTICA, ENTONCES QUE REGRESE AL PANEL DE PRACTICA -->
                <a href="{{route('estudiante.practica')}}">
                    <button class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                        Regresar a la página principal de actividades de práctica 
                    </button>
                </a>
            
            @elseif(($evaluation->type === "F"))
                <!-- SI EL TIPO DE EVALUACION CORRESPONDE A LA EVALUACION FINAL, ENTONCES QUE REGRESE AL PANEL DE LA EVALUACION FINAL -->
                <a href="{{route('estudiante.final')}}" >
                    <button class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                        Regresar a la página principal de la evaluación final 
                    </button>
                </a>
            @endif

            <!-- DIV QUE CONTIENE EL TITULO DEL EXAMEN, LA DESCRIPCION Y DEMAS INFORMACION -->
            <div class="container mx-auto bg-cyan-100 rounded-3xl p-5">
                <h3 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton text-red-700 m-5">Resultados de la evaluación:</h3>
                <h3 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton text-slate-700 m-5">{{$evaluation->name}}</h3>
            </div>

            <!-- DIV QUE CONTIENE LAS PREGUNTAS TOTALES, PREGUNTAS RESPONDIDAS Y PUNTUACION -->
            <div class="container mx-auto mt-10 rounded">
                <div class="w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100 divide-y divide-slate-400">
                        <h2 class="font-semibold text-red-500 font-sora text-center m-4 text-4xl">Sus resultados:</h2>
                        <div>
                            <h4 class="font-semibold text-red-500 font-sora">Preguntas totales: </h4>
                            <h4 class="font-semibold text-gray-800 font-sora text-center text-3xl">{{$totalQuestions}}</h4>
                        </div>
                        <div>
                            <h4 class="font-semibold text-red-500 font-sora">Preguntas respondidas: </h4>
                            <h4 class="font-semibold text-gray-800 font-sora text-center text-3xl">{{$questionsAnsweredUnique}}</h4>
                        </div>
                        <div>
                            <h4 class="font-semibold text-red-500 font-sora">Puntaje: </h4>
                            <h4 class="font-semibold text-gray-800 font-sora text-center text-3xl">{{$calificacion}}</h4>
                        </div>
                    </header>
                </div>
            </div>


            <!-- DIV QUE CONTIENE LAS PREGUNTAS RESPONDIDAS JUNTO AL BOTON DE VER RESULTADO -->
            <div class="container mx-auto mt-10 rounded">

                <div class="w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <h2 class="font-semibold text-gray-800 font-sora">Resultados por pregunta:</h2>
                    </header>
                    <div class="p-3">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full">
                                <tbody class="text-sm divide-y divide-gray-100">

                                    <!-- RECORRER LA COLECCION DE PREGUNTAS RESPONDIDAS Y MOSTRAR CADA PREGUNTA -->
                                    @foreach ($coleccionQuestions as $key=>$question) 
                                        <tr>
                                            <td class="p-2 whitespace-nowrap ">
                                                <div class="text-left font-sora font-medium">{{$key+1}}. {{$question->title}} </div>
                                            </td>
                                            <td class="p-2 whitespace-nowrap content-center">
                                                <a href="/estudiante/{{$userId}}/evaluacion/{{$evaluationId}}/resultadopregunta/{{$question->id}}">
                                                    <!-- BOTON DE INGRESO -->
                                                    <button class="border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline">
                                                        Ver resultado
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach                                                                 
    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>


    <!-- ///////////////////////////////////////////////FIN NUEVA VISTA INDICE DE PREGUNTAS CON EL BOTON DE RESULTADOS////////////////////////// -->


    
</x-app-layout>  