<x-app-layout>
    
    <!-- /////////////////////////////////////////////////////////NUEVA VISTA EVALUACIONES DE PRACTICA /////////////////////////////////////////////// -->

    <!-- SE CREA UN DIV PADRE QUE VA A SER DE COLOR BLANCO -->
    <div class="bg-white">

        <!-- SE CREA UN DIV HIJO CON CLASS CONTAINER Y QUE DEBE TENER OBLIGATORIAMENTE UN PT-24 PORQUE SINO EL NAVBAR FIXED VA A OCULTAR LA INFORMACION  -->
        <div class="container mx-auto pt-24">

            <!-- MENSAJE DE SESION -->
            @if (Session::has('message'))
                <div class="bg-gray-200 rounded-xl p-6 overflow-hidden text-2xl font-bold mb-2">
                    {{Session::get('message')}}
                </div>
            @endif


            <!-- SECCION ACTIVIDADES DE PRACTICA -->
            <div class="container mx-auto p-10">
                <h3 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton text-green-700 m-5">Actividades de práctica:</h3>
                <p class="text-xl font-sora m-5">A continuación, puedes acceder a varias actividades de práctica divididas en tres secciones:</p>
                <li class="text-xl font-sora m-5">Actividades para poner en práctica tu escritura.</li>
                <li class="text-xl font-sora m-5">Actividades para poner en práctica la capacidad de escribir o diferenciar correctamente lo que escuchas.</li>
                <li class="text-xl font-sora m-5">Actividades para identificar de forma visual palabras o enunciados correctamente escritos.</li>
                <h3 class="text-2xl sm:text-3xl md:text-4xl text-center font-anton text-yellow-700 m-5">¡Ingresa a la sección de tu interés y completa las actividades!</h3>
                <!-- CONTENEDOR CON 3 CARD 1 PARA CADA TIPO DE REGLA ORTOGRAFICA-->
                <div class="container mx-auto py-16 bg-indigo-500 rounded-xl w-full">
                    <div class="mx-auto grid gap-6 md:w-3/4 lg:w-full lg:grid-cols-3">
                        
                        <!-- EN LA VARIABLE EVALUATIONS VIENE LA COLECCION DE EVALUACIONES DE PRACTICA QUE LE PERTENECEN AL USUARIO ACTUAL -->
                        <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $ISEVALUATIONASSIGNED ES VERDADERA, ES DECIR SI TIENE EXAMENES ASIGNADOS  -->
                        @if ($isEvaluationAssigned)
                            
                            @foreach ($evaluations as $key=>$evaluation)

                                <!-- CARD QUE SE DESPLIEGA POR CADA EVALUACION ASIGNADA, 3 EN TOTAL -->
                                <div class="bg-white rounded-2xl shadow-xl px-8 py-12 sm:px-12 lg:px-8 m-10 transform  hover:scale-125 transition duration-300">
                                    <div class="mb-12 space-y-4">
                                        <!-- MOSTRAR EL MISMO NOMBRE DE ACTIVIDADES DE PRÁCTICA -->
                                        <!-- SEGUN EL KEY+1 SE VAN ASIGNADO EL TIPO DE ACTIVIDADES -->
                                        {{--<h3 class="text-2xl font-semibold text-orange-600 font-anton">{{$evaluation->name}}</h3>--}}
                                        <h3 class="text-2xl font-semibold text-orange-600 font-anton">Actividades de @if ($key+1 === 1)
                                            escritura
                                        @elseif($key+1 === 2)
                                            audio
                                        @elseif($key+1 === 3)
                                            visión 
                                        @endif</h3>
                                        <p class="mb-6 font-sora">{{$evaluation->description}}</p>
                                        <p class="mb-6 text-justify font-sora mt-4">Número de preguntas: {{$evaluation->questions->count()}}</p>
                                        
                                        <!-- LOGICA PARA MOSTRAR EL BOTON DEE INGRESO, EL BOTON DE VER RESULTADOS O UN MENSAJE QUE DIGA QUE TIENE QUE COMPLETAR LA EVALUACION DE DIAGNOSTICO
                                        PARA PODER INGRESAR A ESTA SECCION -->

                                        <!-- NUEVA FORMA DE CONTROLAR EL INGRESO A LOS EXAMENES DE PRACTICA, EL BOTON DE INGRESAR AL EXAMEN O VER RESULTADOS SOLO VA A APARECER SI EL USUARIO HA RESPONDIDO
                                        A TODAS LAS PREGUNTAS DE LA PRUEBA DE DIAGNOSTICO ASIGNADA, ES DECIR, SI LA VARIABLE DIAGNOSTICO COMPLETADO ES TRUE -->
                                        @if ($diagnosticoCompletado === true)
                                            
                                            <!-- SI EL USUARIO HA COMPLETADO LA PRUEBA DE DIAGNOSTICO SE DESPRENDEN DOS OPCIONES -->
                                            <!-- 1. QUE EL USUARIO AUN NO TERMINE DE RESPONDER EL EXAMEN Y QUE LE APAREZCA EL BOTON DE RESPONDER EVALUACION -->
                                            <!-- 2. QUE EL USUARIO YA HAYA RESPONDIDO EL EXAMEN Y QUE LE APAREZCA EL BOTON DE VER RESULTADOS -->
                                            <!-- COMO ESTAMOS RECORRIENDO LA COLECCION DE EVALUACIONES ENTONCES SE DEBE PREGUNTA SI EL TYPE DE LA EVALUACION QUE SE
                                            ESTA RECORRIENDO ES PU = EVALUACION UNO, PD = EVALUACION DOS, PT = EVALUACION TRES Y SEGUN EL TYPE SE VAN CREANDO LOS BOTONES -->
                                            @if ($evaluation->type === "PU")
                                                <!-- SI LA EVALUACION ES TYPE = PU SIGNFICA QUE ES EVALUACION UNO, ENTONCES SE DEBE VERIFICAR SI EL USUARIO HA RESPONDIDO
                                                TODAS LAS PREGUNTAS DE ESTA EVALUACION, SI ES ASI SIGNIFICA QUE LA VARIABLE $UNOCOMPLETADO ES TRUE Y SE MUESTRA EL BOTON DE VER RESULTADOS
                                                CASO CONTRARIO SE MUESTRA EL BOTON DE RESPONDER EVALUACION -->
                                                @if ($unoCompletado === true)

                                                    <a href="/estudiante/resultado/{{auth()->user()->id}}/evaluacion/{{$evaluation->id}}">
                                                        <!-- BOTON DE VER RESULTADOS -->
                                                        <button type="button" class="border border-yellow-500 bg-yellow-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-yellow-600 focus:outline-none focus:shadow-outline">
                                                            Ver resultados
                                                        </button>
                                                    </a>
                                                @else
                                                    <a href="{{route('estudiante.preguntasevaluacion', $evaluation)}}">
                                                        <!-- BOTON DE INGRESO -->
                                                        <button type="button" class="border border-teal-500 bg-teal-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-teal-600 focus:outline-none focus:shadow-outline">
                                                            Responder evaluación
                                                        </button>
                                                    </a>
                                                @endif 


                                            @elseif($evaluation->type === "PD")
                                                <!-- SI LA EVALUACION ES TYPE = PD SIGNIFICA QUE ES EVALUACION DOS, ENTONCES SE DEBE VERIFICAR SI EL USUARIO HA RESPONDIDO
                                                TODAS LAS PREGUNTAS DE ESTA EVALUACION, SI ES ASI SIGNIFICA QUE LA VARIABLE $DOSCOMPLETADO ES TRUE Y SE MUESTRA EL BOTON DE VER RESULTADOS
                                                CASO CONTRARIO SE MUESTRA EL BOTON DE RESPONDER EVALUACION -->
                                                @if ($dosCompletado === true)

                                                    <a href="/estudiante/resultado/{{auth()->user()->id}}/evaluacion/{{$evaluation->id}}">
                                                        <!-- BOTON DE VER RESULTADOS -->
                                                        <button type="button" class="border border-yellow-500 bg-yellow-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-yellow-600 focus:outline-none focus:shadow-outline">
                                                            Ver resultados
                                                        </button>
                                                    </a>
                                                @else
                                                    <a href="{{route('estudiante.preguntasevaluacion', $evaluation)}}">
                                                        <!-- BOTON DE INGRESO -->
                                                        <button type="button" class="border border-teal-500 bg-teal-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-teal-600 focus:outline-none focus:shadow-outline">
                                                            Responder evaluación
                                                        </button>
                                                    </a>
                                                @endif     
                                            
                                            @elseif($evaluation->type === "PT")
                                                <!-- SI LA EVALUACION ES TYPE = PT SIGNIFICA QUE ES EVALUACION TRES, ENTONCES SE DEBE VERIFICAR SI EL USUARIO HA RESPONDIDO
                                                TODAS LAS PREGUNTAS DE ESTA EVALUACION, SI ES ASI SIGNIFICA QUE LA VARIABLE $TRESCOMPLETADO ES TRUE Y SE MUESTRA EL BOTON DE VER RESULTADOS
                                                CASO CONTRARIO SE MUESTRA EL BOTON DE RESPONDER EVALUACION -->
                                                @if ($tresCompletado === true)

                                                    <a href="/estudiante/resultado/{{auth()->user()->id}}/evaluacion/{{$evaluation->id}}">
                                                        <!-- BOTON DE VER RESULTADOS -->
                                                        <button type="button" class="border border-yellow-500 bg-yellow-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-yellow-600 focus:outline-none focus:shadow-outline">
                                                            Ver resultados
                                                        </button>
                                                    </a>
                                                @else
                                                    <a href="{{route('estudiante.preguntasevaluacion', $evaluation)}}">
                                                        <!-- BOTON DE INGRESO -->
                                                        <button type="button" class="border border-teal-500 bg-teal-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-teal-600 focus:outline-none focus:shadow-outline">
                                                            Responder evaluación
                                                        </button>
                                                    </a>
                                                @endif

                                            @endif
                                        @else
                                            <!-- SE MUESTRA UN MENSAJE DE ALERTA PARA QUE EL USUARIO COMPLETE LA EVALUACION DE DIAGNOSTICO PRIMERO PARA DESBLOQUEAR ESTA SECCION -->
                                            <div class="bg-lime-300 rounded-xl">
                                                <p class="mt-10 m-5 font-sora text-xl text-center">Para desbloquear esta sección debe completar la evaluación de diagnóstico: <strong class="text-red-500">{{$diagnostico->name}}</strong></p>
                                            </div>
                                        @endif

                                        
                                        
                                    </div>
                                </div>
                            @endforeach

                        @else
                            <div class="text-center text-white text-xl font-bold">No tienes actividades de práctica asignadas.</div>
                        @endif

                    </div>
                </div>
            </div>

        </div>

    </div>


    <!--///////////////////////////////////////////////////////// FIN NUEVA VISTA EVALUACIONES DE PRACTICA //////////////////////////////////////////// -->


    
</x-app-layout>