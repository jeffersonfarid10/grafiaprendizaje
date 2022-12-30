<x-app-layout>
    

    <!-- ///////////////////////////////////////////////////////////////////////NUEVA VISTA EVALUACION FINAL////////////////////////////////////// -->

    <!-- SE CREA UN DIV PADRE QUE VA A SER DE COLOR BLANCO -->
    <div class="bg-white">

        <!-- SE CREA UN DIV HIJO CON CLASS CONTAINER Y QUE DEBE TENER OBLIGATORIAMENTE UN PT-24 PORQUE SINO EL NAVBAR FIXED VA A TAPAR EL CONTENIDO -->
        <div class="container mx-auto pt-24 p-12">

            <!-- MENSAJE DE SESION -->
            @if (Session::has('message'))
                <div class="bg-gray-200 rounded-xl p-6 overflow-hidden text-2xl font-bold mb-2">
                    {{Session::get('message')}}
                </div>
            @endif

            <!-- CONTENEDOR CON LA TARJETA DE LA EVALUACION ASIGNADA -->
            <div class="container mx-auto p-10">
                <h3 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton text-slate-700 m-5">Evaluación final</h3>
                <p class="text-xl font-sora m-5">En la evaluación final responderás a varias preguntas relacionadas con las actividades que has realizado ¡suerte!</p>
                
                     <!-- EN LA COLECCION EVALUATIONS VIENE LA EVALUACION FINAL POR ESO HAY QUE RECORRER ESA COLECCION -->
                     <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $ISEVALUATIONASSIGNED ES VERDADERA, ES DECIR, SI EL USUARIO TIENE EXAMENES ASIGNADOS  -->
                     @if ($isEvaluationAssigned)
                        
                        @foreach ($evaluations as $evaluation)
                            <!-- CONTENEDOR CON LA TARJETA DE LA EVALUACION ASIGNADA -->
                            <div class="container mx-auto p-10">
                               
                                <!-- CONTENEDOR CON 1 CARD PARA MOSTRAR LA EVALUACION DE DIAGNOSTICO -->
                                <div class="container mx-auto py-16 bg-emerald-300 rounded-xl w-full">
                                    <div class="mx-auto grid grid-cols-1 lg:w-1/2">
                                        <!-- CARD UNO -->
                                    <div class="bg-white rounded-2xl shadow-xl px-8 py-12 sm:px-12 lg:px-8 m-10 transform  hover:scale-125 transition duration-300">
                                        <div class="mb-12 space-y-4">
                                            <!-- MOSTRAR EL MISMO NOMBRE PARA LA EVALUACION FINAL -->
                                            {{--<h3 class="text-2xl font-semibold text-blue-600 font-anton">{{$evaluation->name}}</h3>--}}
                                            <h3 class="text-2xl font-semibold text-blue-600 font-anton">Evaluación Final</h3>
                                            <p class="mb-6 text-justify">{{$evaluation->description}}</p>
                                            <p class="mb-6 text-justify font-sora mt-4">Número de preguntas: {{$evaluation->questions->count()}}</p>

                                            <!-- LOGICA PARA ACCEDER AL BOTON DE INGRESO, VER RESULTADOS O MENSAJE -->
                                            <!-- NUEVA FORMA DE CONTROLAR EL INGRESO AL EXAMEN FINAL, EL BOTON DE INGRESAR AL EXAMEN O VER RESULTADOS SOLO VA A APARECER SI EL USUARIO HA RESPONDIDO 
                                            A LA PRUEBA DE DIAGNOSTICO Y A LAS 3 PRUEBAS DE PRACTICA-->
                                            @if (($diagnosticoCompletado === true) && ($unoCompletado === true) && ($dosCompletado === true) && ($tresCompletado === true))
                                                <!-- SI TODAS LAS EVALUACIONES ANTERIORES FUERON COMPLETADAS ENTONCES SE PREGUNTA SI LA VARIABLE FINACOMPLETADO ES TRUE, LO QUE SIGNIFCA QUE EL USUARIO
                                                HA TERMINADO EL EXAMEN FINAL Y QUE APAREZCA EL BOTON DE VER RESULTADOS, CASO CONTRARIO QUE APAREZCA EL BOTON DE RESPONDER EVALUACION -->
                                                @if ($finalCompletado === true)
                                                    <a href="/estudiante/resultado/{{auth()->user()->id}}/evaluacion/{{$evaluation->id}}">
                                                        <!-- BOTON DE VER RESULTADOS -->
                                                        <button type="button" class="border border-yellow-500 bg-yellow-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-yellow-600 focus:outline-none focus:shadow-outline">
                                                            Ver resultados
                                                        </button>
                                                    </a>
                                                @else 
                                                    <a href="{{route('estudiante.preguntasevaluacion', $evaluation)}}">
                                                        <!-- BOTON DE INGRESO -->
                                                        <button type="button" class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                                                            Ingresar
                                                        </button>
                                                    </a>
                                                @endif
                                            @else 
                                                <!-- SE MUESTRA UN MENSAJE DE ALERTA PARA QUE EL USUARIO COMPLETE LA EVALUACION DE DIAGNOSTICO PRIMERO PARA DESBLOQUEAR ESTA SECCION -->
                                                <div class="bg-sky-500 rounded-xl">
                                                    <p class="mt-10 m-5 font-sora text-xl text-center font-bold">Para ingresar, debe completar primero las siguientes secciones:</p>
                                                    
                                                    <br>
                                                    <!-- CUANDO AL USUARIO LE FALTEN ALGUN EXAMEN POR RESPONDER, CON LOS IF SE PREGUNTA CUAL EXAMEN FALTA POR RESPONDER PARA MOSTRARLO EN LA VISTA -->
                                                    @if ($diagnosticoCompletado === false)
                                                        <div class="text-center text-white text-xl font-bold">{{$diagnostico->name}}</div>
                                                        <br>
                                                    @endif

                                                    @if ($unoCompletado === false)
                                                        <div class="text-center text-white text-xl font-bold">{{$evaluacionUno->name}}</div>
                                                        <br>
                                                    @endif

                                                    @if ($dosCompletado === false)
                                                        <div class="text-center text-white text-xl font-bold">{{$evaluacionDos->name}}</div>
                                                        <br>
                                                    @endif

                                                    @if ($tresCompletado === false)
                                                        <div class="text-center text-white text-xl font-bold">{{$evaluacionTres->name}}</div>
                                                    @endif
                                                </div>
                                            @endif
                                            
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                     @else
                         <div class="text-center text-red-500 text-xl font-bold">No tienes evaluación final asignada</div>
                     @endif
            </div>

        </div>

    </div>


    <!-- //////////////////////////////////////////////////////////////////////////FIN NUEVA VISTA EVALUACION FINAL////////////////////////////////////// -->


</x-app-layout>