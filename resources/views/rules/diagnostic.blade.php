<x-app-layout>
    
    <!---////////////////////////////////////////////////////// NUEVA VISTA EVALUACION DE DIAGNOSTICO ///////////////////////////-->

    <!-- SE CREA UN DIV PADRE QUE VA A SER DE COLOR BLANCO -->
    <div class="bg-white">

        <!-- SE CREA UN DIV HIJO CON CLASS CONTAINER Y QUE DEBE TENER OBLIGATORIAMENTE UN PT-24 PORQUE SINO EL NAVBAR FIXED VA A OCULTAR INFORMACION -->
        <div class="container mx-auto pt-24 p-12">

            <!-- MENSAJE DE SESION -->
            @if (Session::has('message'))
                <div class="bg-gray-200 rounded-xl p-6 overflow-hidden text-2xl font-bold mb-2">
                    {{Session::get('message')}}
                </div>
            @endif

            <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $ISEVALUATIONASSIGNED ES VERDADERA, ES DECIR SI EL USUARIO TIENE EXAMENES ASIGNADOS -->
            @if ($isEvaluationAssigned)


                    <!-- CONTENEDOR CON LA EVALUACION EN GOOGLE FORMS -->
                    {{--<div class="container mx-auto p-10">
                        <h3 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton text-slate-700 m-5">Antes de continuar</h3>
                        <p class="text-xl font-sora m-5">Por favor, antes de resolver la evaluación de diagnóstico, ingresa al link y responde al siguiente cuestionario.</p>
                        <div class="container mx-auto py-16 bg-amber-200 rounded-xl w-full">
                            <h3 class="text-2xl sm:text-3xl md:text-4xl font-semibold text-blue-600 font-anton text-center">Cuestionario: 
                                <a class="text-red-600" href="https://forms.office.com/r/ZcH3X6dkUR" target="_blank" rel="noopener noreferrer">
                                    https://forms.office.com/r/ZcH3X6dkUR
                                </a>
                            </h3>
                            
                        </div>
                    </div>--}}

            @endif 


            <!-- CONTENEDOR CON LA TARJETA DE LA EVALUACION ASIGNADA -->
            <div class="container mx-auto p-10">
                <h3 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton text-slate-700 m-5">Evaluación de diagnóstico</h3>
                <p class="text-xl font-sora m-5">Haz click en el botón "Ingresar" para acceder y responder a las preguntas que te han sido asignadas.</p>
 
                                
                                <!-- CON EL IF SE PREGUNTA SI LA VARIABLE $ISEVALUATIONASSIGNED ES VERDADERA, ES DECIR SI EL USUARIO TIENE EXAMENES ASIGNADOS -->
                                @if ($isEvaluationAssigned)
                                    
                                    <!-- RECORDAR QUE EVALUATIONS ES UNA COLECCION DE ELEMENTOS, PERO QUE TIENE UN SOLO ELEMENTO LLAMANDO DIAGNOSTICO PORQUE 
                                    LA COLECCION SOLO CAPTURO LAS EVALUACIONES QUE SON TPYE D, ES DECIR DIAGNOSTICO Y QUE LE PERTENECEN AL USUARIO ACTUAL -->
                                    @foreach ($evaluations as $evaluation)

                                            <!-- CONTENEDOR CON 1 CARD PARA MOSTRAR LA EVALUACION DE DIAGNOSTICO -->
                                            <div class="container mx-auto py-16 bg-amber-200 rounded-xl w-full">
                                                <div class="mx-auto grid grid-cols-1 lg:w-1/2">
                                                    <!-- CARD UNO -->
                                                <div class="bg-white rounded-2xl shadow-xl px-8 py-12 sm:px-12 lg:px-8 m-10 transform  hover:scale-125 transition duration-300">
                                                    <div class="mb-12 space-y-4">
                                                        <!-- SE COMENTA ESTA LINEA PARA QUE APAREZCA EL MISMO TITULO PARA TODAS LAS EVALUACIONES -->
                                                        {{--<h3 class="text-2xl font-semibold text-blue-600 font-anton">{{$evaluation->name}}</h3>--}}
                                                        <h3 class="text-2xl font-semibold text-blue-600 font-anton">Evaluación de Diagnóstico</h3>
                                                        <p class="mb-6 text-justify">{{$evaluation->description}}</p>
                                                        <p class="mb-6 text-justify font-sora mt-4">Número de preguntas: {{$evaluation->questions->count()}}</p>

                                                        <!-- LOGICA PARA MOSTRAR EL BOTON DE INGRESO O VER RESULTADOS -->

                                                        <!-- NUEVA FORMA DE CONTROLAR EL INGRESO AL EXAMEN DE DIAGNOSTICO, EL BOTON DE VER RESULTADOS SOLO APARECERA SI EL USUARIO HA RESPONDIDO A TODAS LAS PREGUNTAS -->
                                                        <!-- ES DECIR, SI LA VARIABLE $DIAGNOSTICOCOMPLETADO ES TRUE, SIGNIFICA QUE HA RESPONDIDO TODAS LAS PREGUNTAS DE ESTE EXAMEN Y APARECE EL BOTON DE VER RESULTADOS 
                                                        CASO CONTRARIO, APARECE EL BOTON DE RESPONDER EXAMEN-->
                                                        @if ($diagnosticoCompletado === true)
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
                                                        
                                                    </div>
                                                </div>
                                                </div>
                                            </div>

                                    @endforeach

                                @else
                                    <div class="text-center text-red-500 text-xl font-bold">No tienes evaluación de diagnóstico asignada.</div>
                                @endif

            </div>

        </div>

    </div>


    <!--- /////////////////////////////////////////////////////////////FIN NUEVA VISTA EVALUACION DE DIAGNOSTICO///////////////////////////// -->

    
    

    
</x-app-layout>