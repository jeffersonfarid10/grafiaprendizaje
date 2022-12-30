<x-app-layout>


    <!-- /////////////////////////////////////////////////////NUEVA VISTA CUESTIONARIO DE PREGUNTAS////////////////////////// -->

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
                <h3 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton text-slate-700 m-5">{{$evaluation->name}}</h3>
                <h4 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton text-red-700 m-5 p-5">Indicaciones generales:</h4>
                <li class="text-xl font-sora m-5">A continuación, se presentan 10 actividades las cuales debes responder.</li>
                <li class="text-xl font-sora m-5">Puedes regresar a esta página las veces que desees, hasta que termines de realizar todas las actividades.</li>
                <li class="text-xl font-sora m-5">Solo puedes responder una vez a cada actividad.</li>
            </div>

            <!-- MENSAJE DE SESION -->
            @if (Session::has('message'))
                <div class="bg-gray-200 rounded-xl p-6 overflow-hidden text-2xl font-bold mb-2">
                    {{Session::get('message')}}
                </div>
            @endif

            <!-- BARRA DE PROGRESO LA BARRA SE CARGA SEGUN LA VARIABLE NROPREGUNTASRESPONDIDAS QUE VIENE DESDE EL CONTROLADOR EVALUACIONCONTROLLER-->
            <h4 class="text-lg sm:text-xl md:text-2xl text-left font-anton text-red-700 m-5 p-5">Progreso de la evaluación:</h4>
            <h3 class="text-lg sm:text-xl md:text-2xl text-left font-anton text-slate-700 m-5 pl-5">{{$nroPreguntasRespondidas}} de 10 preguntas totales</h3>
            <div class="w-full bg-gray-200 rounded-full border-black dark:bg-gray-700 my-10">
                <div class="bg-green-600 text-lg font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: {{$nroPreguntasRespondidas*10}}%">{{$nroPreguntasRespondidas*10}}%</div>
              </div>

            
            <!-- DIV QUE CONTIENE LAS PREGUNTAS -->
            <div class="container mx-auto mt-10 rounded">

                @isset($evaluationQuestions)
                    
                    <div class="w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-200">
                        <header class="px-5 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-800 font-sora">Responda las siguientes preguntas:</h2>
                        </header>
                        <div class="p-3">
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full">
                                    <tbody class="text-sm divide-y divide-gray-100">

                                        <!-- RECORRER LA COLECCION DE PREGUNTAS -->
                                        @foreach ($evaluationQuestions as $key=>$question)

                                            <!-- SE MUESTRA LA PREGUNTA -->
                                            <tr>
                                                <td class="p-2 whitespace-nowrap ">
                                                    <div class="text-left font-sora font-medium">{{$key+1}}. {{$question->title}}</div>
                                                </td>
                                                <td class="p-2 whitespace-nowrap content-center">

                                                    <!-- LOGICA PARA EL BOTON DE RESPONDER PREGUNTA -->

                                                        <!--PHP -->
                                                        <!-- CON CODIGO PHP SE CONSULTA EN LAS TABLAS SI UNA PREGUNTA HA SIDO RESPONDIDA O NO POR EL USUARIO ACTUAL
                                                        SI NO ES ASI QUE LE APAREZCA EL BOTON DE RESPONDER, Y SI YA HA RESPONDIDO QUE LE APAREZA UN MENSAJE DE PREGUNTA RESPONDIDA -->
                                                        @php
                                                            //CREAR UN ARRAY DONDE SE GUARDARAN LOS IDS DE LAS PREGUNTAS YA RESPONDIDAS POR EL USUARIO ACTUAL LOGEADO
                                                            $attemptedQuestion = [];
                                                            //MENSAJE QUE APARECE EN EL BOTON SI LA PREGUNTA AUN NO HA SIDO RESPONDIDA
                                                            $sinresponder = "Responder pregunta";
                                                            //MENSAJE QUE APARECE SI LA PREGUNTA YA HA SIDO RESPONDIDA
                                                            $respondida = "Pregunta respondida";
                                                            //CAPTURAR EL ID DEL USUARIO ACTUAL
                                                            $authUser = auth()->user()->id;
                                                            //EN LA VARIABLE USER SE VAN A GUARDAR LOS REGISTROS DE LA TABLA RESULTS QUE TENGAN EL USER_ID DEL USUARIO ACTUAL
                                                            //ES DECIR, LAS PREGUNTAS QUE EL USUARIO YA HA RESPONDIDO
                                                            $user = DB::table('results')->where('user_id', $authUser)->get();
                                                            //EN EL ARRAY ATTEMPTEDQUESTION SE VAN A GUARDAR LOS IDS DE LOS REGISTROS DE LA TABLA RESULTS QUE SE HAN ENCONTRADO
                                                            foreach($user as $u){
                                                                array_push($attemptedQuestion, $u->question_id);
                                                            }

                                                            //CON EL IF SE PREGUNTA SI LAS QUESTIONS DE UNA EVALUATION ACTUAL HAN SIDO RESPONDIDAS O NO
                                                            //SI NO HAN SIDO RESPONDIDAS QUE APAREZCA EL BOTON PARA INGRESAR A LA PREGUNTA
                                                            //Y SI YA HA SIDO RESPONDIDA ENTONCES QUE APAREZCA UN BADGE 
                                                            if(!in_array($question->id, $attemptedQuestion)){
                                                                echo '<a href="/estudiante/evaluacion/' . $evaluation->id . '/question' . '/' . $question->id . '"><button class="px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all text-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">' . $sinresponder . '</button></a>';

                                                            }
                                                            else{
                                                                echo '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900">' . $respondida . '</span>';
                                                            }                                        
                                                        @endphp

                                                </td>
                                            </tr>
                                        @endforeach                      
                            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- FOOTER CON EL BOTON DE FINALIZAR EVALUACION O REGRESAR -->
                        <div class="px-5 py-4 border-b border-gray-100 text-center">
                            
                            <!-- NUEVA ACTUALIZACION DE BOTON DE LA SECCION DE EXAMENES -->
                            <!-- SI LA VARIABLE EXAMENCOMPLETADO ES TRUE, SIGNIFICA QUE EL USUARIO HA RESPONDIDO TODAS LAS PREGUNTAS Y ENTONCES QUE LE APAREZCA EL BOTON DE FINALIZAR EXAMEN -->
                            <!-- SI EXAMENCOMPLETADO ES FALSE ENTONCES QUE APAREZCA EL BOTON REGRESAR Y QUE REDIRIGA A LA PAGINA DE EVALUACION DE DIAGNOSTICO, O PRACTICA O EVALUACION FINAL SEGUN CORRESPONDA -->
                            @if ($examenCompletado === true)
                            <a href="/estudiante/resultado/{{auth()->user()->id}}/evaluacion/{{$evaluation->id}}">
                                <button class="px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all text-white bg-red-500 hover:bg-red-700 ring-red-300 focus:ring">Finalizar evaluación</button>
                            </a>
                            @else
                                
                                <!-- SI EL TYPE DE LA EVALUACION ACTUAL ES D ENTONCES QUE APAREZCA EL BOTON QUE REDIRIGE A LA PAGINA DE EVALUACIONES DE DIAGNOSTICO -->
                                @if ($tipoExamen === "D")
                                    <a href="/estudiante/diagnostico">
                                        <button class="border border-yellow-500 bg-yellow-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-yellow-600 focus:outline-none focus:shadow-outline">Regresar</button>
                                    </a>
                                @elseif (($tipoExamen === "PU") || ($tipoExamen === "PD") || ($tipoExamen === "PT"))
                                    <a href="/estudiante/practica">
                                        <button class="border border-yellow-500 bg-yellow-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-yellow-600 focus:outline-none focus:shadow-outline">Regresar</button>
                                    </a>
                                @elseif ($tipoExamen === "F")
                                    <a href="/estudiante/final">
                                        <button class="border border-yellow-500 bg-yellow-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-yellow-600 focus:outline-none focus:shadow-outline">Regresar</button>
                                    </a>
                                @endif
                            @endif

                        </div>
                    </div>
                @else 
                    <strong>No hay preguntas para mostrar</strong>
                @endisset
            </div>

        </div>

    </div>

    <!-- //////////////////////////////////////////////////FINAL NUEVA VISTA CUESTIONARIO DE PREGUNTAS//////////////////////////////// -->

    <!-- SCRIPT PARA DESHABILITAR EL BOTON DERECHO -->
    <script type="text/javascript">
        window.oncontextmenu = function () {
            console.log("Click derecho desactivado");
            return false;
        }
    </script>
    
</x-app-layout>