<x-app-layout>

    <!-- ///////////////////////////////////////////////////////////////////////////NUEVA VISTA RESULTADOS PREGUNTA OMI//////////////////////////////////// -->


    <!-- SE CREA UN DIV PADRE QUE VA A SER DE COLOR BLANCO -->
    <div class="bg-white">

        <!-- SE CREA UN DIV HIJO CON CLASS CONTAINER Y QUE DEBE TENER OBLIGATORIAMENTE UN PT-24 PORQUE SINO EL NAVBAR FIXED VA A OCULTAR INFORMACION -->
        <div class="container mx-auto pt-24 p-12">

            <!-- BOTON REGRESAR -->
            <div>
                <a href="/estudiante/resultado/{{$userId}}/evaluacion/{{$evaluationId}}">
                    <button class="px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all text-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
                        Regresar
                    </button>
                </a>
            </div>

            <!-- DIV QUE CONTIENE EL TITULO DE LA PREGUNTA Y LAS INDICACIONES -->
            <div class="container mx-auto rounded-3xl p-5">
                <h3 class="text-2xl md:text-3xl text-left font-anton text-slate-700">{{$questionType->title}}</h3>
                <br>
                <h4 class="text-2xl md:text-2xl text-left font-anton text-red-700 m-5 pb-5">Indicaciones de la pregunta:</h4>
                <!-- INDICACIONES -->
                @foreach ($questionType->indications as $key=>$indication)
                    <p class="text-xl font-sora mb-5 text-justify">{{$key+1}}. {{$indication->indication}}</p>
                @endforeach
                
            </div>


            <!-- DIV QUE CONTIENE LA IMAGEN -->
            <!-- IMAGEN -->
            <div class="container mx-auto p-10">
                <div class="mx-auto w-full lg:w-3/5">
                    <!-- IMPORTANTE PONER LA LINEA DIAGONAL AL INICIO DE LA RUTA EN LAS IMAGENES DE LAS REGLAS DE NIVEL UNO PARA ADELANTE PORQUE SINO NO VA A APARECER LA IMAGEN -->
                    <img id="image" name="imagen" src="/storage/{{$questionType->image}}" alt="" class="w-full h-full object-cover object-center rounded-lg">
                </div>
            </div> 

            <!-- DIV QUE CONTIENE LA PUNTUACION DE LA PREGUNTA -->
            <div class="container mx-auto mt-10 rounded">
                <div class="w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <h2 class="font-semibold text-red-500 font-sora text-center m-4">Resultados de tu respuesta:</h2>
                        <h4 class="font-semibold text-red-500 font-sora">Puntaje: </h4>
                        <h4 class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$sumaresultados}}</h4>
                    </header>
                </div>
            </div>


            <!-- DIV QUE CONTIENE EL ANALISIS DE LA RESPUESTA DEL USUARIO -->
            <div class="container mt-10 w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-600" >
                <header class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-red-500 font-sora">Revisión de respuesta:</h2>
                </header>
                <!-- OBSERVACION -->
                {{--<div class="px-5 py-4 border-b border-gray-100">
                    <h4 class="font-semibold text-red-500 font-sora">Observación: </h4>
                    <h4 class="font-semibold text-gray-800 font-sora text-center text-xl">Su respuesta es correcta.</h4>
                </div>--}}
                <!-- GRID CON DOS COLUMNAS QUE CONTIENE LA RESPUESTA DEL USUARIO EN UNA COLUMNA Y LA RESPUESTA CORRECTA EN OTRA COLUMNA -->
                <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-800 rounded">
                    <!-- RESPUESTA USUARIO -->
                    <div class="container mx-auto p-5">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Tu respuesta:</h5>
                        
                        <h4 class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$resultUser->answer_user}}</h4>
                        
                        
                    </div>
                    <!-- RESPUESTA CORRECTA -->
                    <div class="container mx-auto p-5">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Respuesta correcta:</h5>
                        <h4 class="font-semibold text-gray-800 font-sora text-center text-2xl">{{$answerCorrecta->answer}}</h4>
                    </div>
                </div>
                <!-- GRID CON UNA COLUMNA QUE CONTIENE LAS OPCIONES DE RESPUESTA DE LA PREGUNTA -->
                <div class="p-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full">
                            <thead class=" bg-gray-200 rounded-2xl">
                                <tr>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class=" text-left font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Opciones de respuesta disponibles:</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100">

                                <!-- RECORRER Y MOSTRAR LAS OPCIONES DE RESPUESTA -->
                                @foreach ($questionType->answers as $answer)
                                    <tr>
                                        <td class="p-2 whitespace-nowrap ">
                                            <div class="text-left font-sora font-medium text-2xl">{{$answer->answer}}</div>
                                        </td>
                                        <!-- CON EL IF SE PREGUNTA SI EL ID DE LA RESPUESTA CORRECTA COINCIDE CON EL ID DE LA OPCION DE RESPUESTA QUE SE ESTA RECORRIENDO, SI ES ASI
                                        ENTONCES QUE APAREZCA UN BADGE EN LA OPCION DE RESPUESTA CORRECTA -->
                                        @if ($answerCorrecta->id === $answer->id)
                                            <td>
                                                <span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">
                                                    Opción correcta</span>
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- DIV QUE CONTIENE EL TITULO DE REGLAS QUE SE TOMARON EN CUENTA Y UNA DESCRIPCION -->
            <div class="container mx-auto rounded-3xl p-5">
                <h4 class="text-2xl md:text-2xl text-left font-anton text-red-700 m-5 pb-5">Reglas ortográficas que se tomaron en cuenta para esta actividad:</h4>
                <li class="text-xl font-sora mb-5 text-justify">En la siguiente sección se presentan las reglas ortográficas que se emplearon para la realización de esta actividad.</li>
                <li class="text-xl font-sora mb-5 text-justify">Haz click en la regla ortográfica de tu interés y accede a más información sobre el uso de esa regla ortográfica.</li>
                <li class="text-xl font-sora mb-5 text-justify">Adicionalmente, tienes algunas aclaraciones sobre la actividad que acabas de realizar.</li>
            </div>


            <!-- DIV QUE CONTIENE LAS REGLAS ORTOGRÁFICAS ASOCIADAS Y LAS JUSTIFICACIONES -->
            <div class="container mt-10 w-full mx-auto bg-white shadow-lg rounded-3xl border border-gray-600" >
                {{--<header class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-red-500 font-sora">Reglas ortográficas tomaron en cuenta para esta actividad:</h2>
                </header>--}}

                <!-- TABLA CON DOS COLUMNAS QUE CONTIENE LAS JUSTIFICACIONES Y LA REGLA ASOCIADA -->
                <div class="p-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full">
                            <thead class=" bg-gray-200 rounded-2xl">
                                <tr>
                                    {{--<th class="p-2 whitespace-nowrap">
                                        <div class=" text-center font-bold font-sora text-red-500 mt-4 ml-4 mb-5">Regla ortográfica</div>
                                    </th>--}}
                                    <th class="p-2 whitespace-nowrap">
                                        <div class=" text-center font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-xl">Explicación sobre la actividad:</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100">

                                <!-- RECORRER LAS JUSTIFICACIONES DE RESPUESTA -->
                                @foreach ($questionType->justifications as $justification)
                                    <tr>
                                        {{--<td class="p-2 whitespace-nowrap ">
                                            <div class="text-center font-sora font-medium text-xl">{{$justification->rule}}</div>
                                        </td>--}}
                                        <td>
                                            <p class="text-justify font-sora text-lg m-2">{{$justification->reason}}</p>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>



                <!-- SECCION QUE CONTIENE LAS REGLAS PARA IR A CADA UNA DE ELLAS -->
                <!-- ESTE DIV CONTIENE A LOS 3 TIPOS DE REGLAS ORTOGRAFICAS -->
                <div class="grid grid-cols-1  divide-y md:divide-y-0 md:divide-x-0 divide-gray-800 rounded">
                    <div class="container bg-slate-300 border-y border-slate-200">
                        <h5 class="font-bold font-sora text-red-500 mt-4 ml-4 mb-5 text-center text-xl">Haz click en la regla ortográfica de tu interés para acceder a más información:</h5>
                    </div>

                    <!-- REGLAS ORTOGRAFICAS DE PALABRAS -->
                    <!-- CON EL IF SE PREGUNTA MEDIANTE LAS VARIABLES HAYPALABRAS SI ALGUNA DE ELLAS ES TRUE, LO QUE SIGNIFICA QUE HAY REGLAS ORTOGRAFICAS DE ESE NIVEL -->
                    @if (($haypalabrasencategories === true) || ($haypalabrasensections === true) || ($haypalabrasenposts === true) || ($haypalabrasenrules === true) || ($haypalabrasennotes === true))
                        <div class="grid grid-cols-1">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4">Reglas ortográficas de palabras:</h5>
                            <div class="container mx-auto p-5">

                                <!-- SI HAY REGLAS ORTOGRAFICAS DE PALABRAS DE CUALQUIER NIVEL, AHORA PREGUNTAR INDIVIDUALMENTE PARA IR MOSTRANDO LAS REGLAS ORTOGRAFICAS -->
                                @if ($haypalabrasencategories === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL UNO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION CATEGORIES -->
                                    @foreach ($questionType->categories as $categoryrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES PALABRAS -->
                                        @if ($categoryrule->type === "Reglas ortográficas de palabras")
                                            {{--<a href="/estudiante/letters/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$categoryrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/letters/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$categoryrule->name}}</button>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                @endif

                                @if ($haypalabrasensections === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL DOS ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION SECTIONS -->
                                    @foreach ($questionType->sections as $sectionrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PALABRAS -->
                                        @if ($sectionrule->type === "Reglas ortográficas de palabras")
                                            {{--<a href="/estudiante/letters/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$sectionrule->name}}   
                                            </a>--}}
                                            <a href="/estudiante/letters/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$sectionrule->name}}  </button>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                @endif

                                @if ($haypalabrasenposts === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL TRES ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION POSTS -->
                                    @foreach ($questionType->posts as $postrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PALABRAS -->
                                        @if ($postrule->type === "Reglas ortográficas de palabras")
                                            @php 
                                                //CATEGORY_ID PARA BUSCAR LA CATEGORIA NIVEL 1 QUE CONTIENE A LA REGLA DE NIVEL 3
                                                $category_idpalabras = $postrule->section->category_id;
                                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 3 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                                $categorypalabras = DB::table('categories')->find($category_idpalabras);
                                            @endphp

                                            <!-- CON EL OBJETO CATEGORY MEDIANTE SU CAMPO SLUG, SE REFERENCIA A LA CATEGORIA NIVEL 1 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                                            {{--<a href="/estudiante/letters/{{$categorypalabras->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$postrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/letters/{{$categorypalabras->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$postrule->name}} </button>
                                            </a>
                                        @endif
                                    @endforeach
                                @endif

                                @if ($haypalabrasenrules === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL CUATRO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION RULES -->
                                    @foreach ($questionType->rules as $rulerule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PALABRAS -->
                                        @if ($rulerule->type === "Reglas ortográficas de palabras")
                                            
                                            @php
                                                //MEDIANTE EL CAMPO SECTION_ID DE LA RELACION POST, SE BUSCA EL REGISTRO DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 4
                                                $sectionrule_idpalabras = $rulerule->post->section_id;
                                                //BUSCAR EN LA TABLA SECTIONS LA REGLA DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 4 MEDIANTE EL CAMPO SECTION_ID DE POST
                                                $sectionrulepalabras = DB::table('sections')->find($sectionrule_idpalabras);

                                                //MEDIANTE EL CAMPO CATEGORY_ID DE LA VARIABLE SECTIONRULEPALABRAS SE BUSCA EL REGISTRO DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 4
                                                $categoryrule_idpalabras = $sectionrulepalabras->category_id;
                                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 4 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                                $categoryrulepalabras = DB::table('categories')->find($categoryrule_idpalabras);

                                            @endphp
                                    
                                            <!-- CON EL OBJETO CATEGORY MEDIANTE SU CAMPO SLUG, SE REFERENCIA A LA CATEGORIA NIVEL 1 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                                            {{--<a href="/estudiante/letters/{{$categoryrulepalabras->slug}}/{{$sectionrulepalabras->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$rulerule->name}}
                                            </a>--}}
                                            <a href="/estudiante/letters/{{$categoryrulepalabras->slug}}/{{$sectionrulepalabras->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$rulerule->name}}</button>
                                            </a>

                                        @endif
                                    
                                    @endforeach
                                @endif

                                @if ($haypalabrasennotes === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL CINCO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION NOTES -->
                                    @foreach ($questionType->notes as $noterule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PALABRAS -->
                                        @if ($noterule->type === "Reglas ortográficas de palabras")
                                            
                                            @php
                                                //MEDIANTE EL CAMPO POST_ID DE LA RELACION RULE, SE BUSCA EL REGISTRO NIVEL 3 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                                $postrule_idpalabras = $noterule->rule->post_id;
                                                //BUSCAR EN LA TABLA SECTIONS LA REGLA DE NIVEL 3 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO POST_ID DE RULE
                                                $postrulepalabras = DB::table('posts')->find($postrule_idpalabras);

                                                //MEDIANTE EL CAMPO SECTION_ID DE LA VARIABLE POSTRULEPALABRAS SE BUSCA EL REGISTRO NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                                $sectionrule_idpalabras = $postrulepalabras->section_id;
                                                //BUSCAR EN LA TABLA SECTION LA REGLA DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO SECTION_ID DE POST
                                                $sectionrulepalabras = DB::table('sections')->find($sectionrule_idpalabras);

                                                //MEDIANTE EL CAMPO CATEGORY_ID DE LA VARIABLE SECTIONRULEPALABRAS SE BUSCA EL REGISTRO NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                                $categoryrule_idpalabras = $sectionrulepalabras->category_id;
                                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                                $categoryrulepalabras = DB::table('categories')->find($categoryrule_idpalabras);

                                            @endphp
                                    
                                            <!-- CON EL OBJETO CATEGORY MEDIANTE SU CAMPO SLUG, SE REFERENCIA A LA CATEGORIA NIVEL 1 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                                            {{--<a href="/estudiante/letters/{{$categoryrulepalabras->slug}}/{{$sectionrulepalabras->slug}}/{{$postrulepalabras->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$noterule->name}}
                                            </a>--}}
                                            <a href="/estudiante/letters/{{$categoryrulepalabras->slug}}/{{$sectionrulepalabras->slug}}/{{$postrulepalabras->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$noterule->name}}</button>
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif



                    <!-- REGLAS ORTOGRAFICAS DE ACENTUACION -->
                    <!-- CON EL IF SE PREGUNTA MEDIANTE LAS VARIABLAS HAYACENTUACION SI ALGUNA DE ELLAS ES TRUE, LO QUE SIGNIFICA QUE HAY REGLAS ORTOGRAFICAS DE ESE NIVEL -->
                    @if (($hayacentuacionencategories === true ) || ($hayacentuacionensections === true) || ($hayacentuacionenposts === true) || ($hayacentuacionenrules === true) || ($hayacentuacionennotes === true))
                        <div class="grid grid-cols-1">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4">Reglas ortográficas de acentuación:</h5>
                            <div class="container mx-auto p-5">
                                <!-- SI HAY REGLAS ORTOGRAFICAS DE ACENTUACION DE CUALQUIER NIVEL, AHORA PREGUNTA INDIVIDUALMENTE PARA IR MOSTRANDO LAS REGLAS ORTOGRAFICAS -->
                                @if ($hayacentuacionencategories === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL UNO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION CATEGORIES -->
                                    @foreach ($questionType->categories as $categoryrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES ACENTUACION -->
                                        @if ($categoryrule->type === "Reglas ortográficas de acentuación")
                                            {{--<a href="/estudiante/acentuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$categoryrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/acentuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$categoryrule->name}}</button>
                                            </a>
                                        @endif
                                       
                                    @endforeach
                                @endif

                                @if ($hayacentuacionensections === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL DOS ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION SECTIONS -->
                                    @foreach ($questionType->sections as $sectionrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE ACENTUACION -->
                                        @if ($sectionrule->type === "Reglas ortográficas de acentuación")
                                            {{--<a href="/estudiante/acentuation/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$sectionrule->name}}    
                                            </a>--}}
                                            <a href="/estudiante/acentuation/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$sectionrule->name}}</button>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                @endif

                                @if ($hayacentuacionenposts === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL TRES ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION POSTS -->
                                    @foreach ($questionType->posts as $postrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE ACENTUACION -->
                                        @if ($postrule->type === "Reglas ortográficas de acentuación")
                                            @php 
                                                //CATEGORY_IDACENTUACION PARA BUSCAR LA CATEGORIA DE NIVEL 1 QUE CONTIENE A LA REGLA DE NIVEL 3
                                                $category_idacentuacion = $postrule->section->category_id;
                                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 3 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                                $categoryacentuacion = DB::table('categories')->find($category_idacentuacion);
                                            @endphp

                                            <!-- CON EL OBJETO CATEGORY MEDIANTE SU CAMPO SLUG, SE REFERENCIA A LA CATEGORIA NIVEL 1 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                                            {{--<a href="/estudiante/acentuation/{{$categoryacentuacion->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$postrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/acentuation/{{$categoryacentuacion->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$postrule->name}}</button>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                @endif

                                @if ($hayacentuacionenrules === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL CUATRO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION RULES -->
                                    @foreach ($questionType->rules as $rulerule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE ACENTUACION -->
                                        @if ($rulerule->type === "Reglas ortográficas de acentuación")
                                            @php 

                                                //MEDIANTE EL CAMPO SECTION_ID DE LA RELACION POST, SE BUSCA EL REGISTRO NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 4
                                                $sectionrule_idacentuacion = $rulerule->post->section_id;
                                                //BUSCAR EN LA TABLA SECTIONS LA REGLA DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 4 MEDIANTE EL CAMPO SECTION_ID DE POST
                                                $sectionruleacentuacion = DB::table('sections')->find($sectionrule_idacentuacion);


                                                //MEDIANTE EL CAMPO CATEGORY_ID DE LA VARIABLE SECTIONRULEACENTUACION SE BUSCA EL REGISTRO NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 4
                                                $categoryrule_idacentuacion = $sectionruleacentuacion->category_id;
                                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 4 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                                $categoryruleacentuacion = DB::table('categories')->find($categoryrule_idacentuacion);
                                            @endphp

                                            <!-- CON EL OBJETO CATEGORY MEDIANTE SU CAMPO SLUG, SE REFERENCIA A LA CATEGORIA NIVEL 1 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                                            <!-- CON EL OBJETO SECTION MEDIANTE SU CAMPO SLUG SE REFERENCIA A LA SECTION NIVEL 2 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                                            {{--<a href="/estudiante/acentuation/{{$categoryruleacentuacion->slug}}/{{$sectionruleacentuacion->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$rulerule->name}}
                                            </a>--}}
                                            <a href="/estudiante/acentuation/{{$categoryruleacentuacion->slug}}/{{$sectionruleacentuacion->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$rulerule->name}}</button>
                                            </a>
                                        @endif
                                       
                                    @endforeach
                                @endif


                                @if ($hayacentuacionennotes === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL CINCO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION NOTES -->
                                    @foreach ($questionType->notes as $noterule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPEE DE LA REGLA QUE SE RECORRE ES DE ACENTUACION -->
                                        @if ($noterule->type === "Reglas ortográficas de acentuación")
                                            
                                            @php 

                                                //MEDIANTE EL CAMPO POST_ID DE LA RELACION RULE, SE BUSCA EL REGISTRO NIVEL 3 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                                $postrule_idacentuacion = $noterule->rule->post_id;
                                                //BUSCAR EN LA TABLA SECTIONS LA REGLA DE NIVEL 3 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO POST_ID DE RULE
                                                $postruleacentuacion = DB::table('posts')->find($postrule_idacentuacion);

                                                //MEDIANTE EL CAMPO SECTION_ID DE LA VARIABLE POSTRULEACENTUACION SE BUSCA EL REGISTRO NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                                $sectionrule_idacentuacion = $postruleacentuacion->section_id;
                                                //BUSCAR EN LA TABLA SECTION LA REGLA DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO SECTION_ID DE POST
                                                $sectionruleacentuacion = DB::table('sections')->find($sectionrule_idacentuacion);

                                                //MEDIANTE EL CAMPO CATEGORY_ID DE LA VARIABLE SECTIONRULEACENTUACION SE BUSCA EL REGISTRO NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                                $categoryrule_idacentuacion = $sectionruleacentuacion->category_id;
                                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                                $categoryruleacentuacion = DB::table('categories')->find($categoryrule_idacentuacion);
                                            @endphp

                                            <!-- CON EL OBJETO CATEGORY MEDIANTE SU CAMPO SLUG, SE REFERENCIA A LA CATEGORIA NIVEL 1 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                                            <!-- CON EL OBJETO SECTION MEDIANTE SU CAMPO SLUG SE REFERENCIA A LA SECTION NIVEL 2 EN LA RUTA DE LA REGLA ORTOGRAFICA -->
                                            {{--<a href="/estudiante/acentuation/{{$categoryruleacentuacion->slug}}/{{$sectionruleacentuacion->slug}}/{{$postruleacentuacion->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$noterule->name}}
                                            </a>--}}
                                            <a href="/estudiante/acentuation/{{$categoryruleacentuacion->slug}}/{{$sectionruleacentuacion->slug}}/{{$postruleacentuacion->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$noterule->name}}</button>
                                            </a>

                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                        


                    <!-- REGLAS ORTOGRAFICAS DE PUNTUACION -->
                    <!-- CON EL IF SE PREGUNTA MEDIANTE LAS VARIABLES HAYPUNTUACION SI ALGUNA DE ELLAS ES TRUE, LO QUE SIGNIFICA QUE HAY REGLAS ORTOGRAFICAS DE ESE NIVEL -->
                    @if (($haypuntuacionencategories === true) || ($haypuntuacionensections === true) || ($haypuntuacionenposts === true) || ($haypuntuacionenrules === true) || ($haypuntuacionennotes === true))
                        <div class="grid grid-cols-1">
                            <h5 class="font-bold font-sora text-red-500 mt-4 ml-4">Reglas ortográficas de puntuación:</h5>
                            <div class="container mx-auto p-5">
                                <!-- SI HAY REGLAS ORTOGRAFICAS DE PUNTUACION DE CUALQUIER NIVEL, AHORA PREGUNTAR INDIVIDUALMENTE PARA IR MOSTRANDO LAS REGLAS ORTOGRAFICAS -->
                                @if ($haypuntuacionencategories === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL UNO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION CATEGORIES -->
                                    @foreach ($questionType->categories as $categoryrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PUNTUACION -->
                                        @if ($categoryrule->type === "Reglas ortográficas de puntuación")
                                            {{--<a href="/estudiante/punctuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$categoryrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/punctuation/{{$categoryrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$categoryrule->name}}</button>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                @endif

                                @if ($haypuntuacionensections === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL DOS ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION SECTIONS -->
                                    @foreach ($questionType->sections as $sectionrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PUNTUACION -->
                                        @if ($sectionrule->type === "Reglas ortográficas de puntuación")
                                            {{--<a href="/estudiante/punctuation/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$sectionrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/punctuation/{{$sectionrule->category->slug}}/{{$sectionrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$sectionrule->name}}</button>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                    
                                @endif

                                @if ($haypuntuacionenposts === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL TRES ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION POSTS -->
                                    @foreach ($questionType->posts as $postrule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PUNTUACION -->
                                        @if ($postrule->type === "Reglas ortográficas de puntuación")
                                            @php 
                                                //CATEGORY_IDPUNTUACION PARA BUSCAR LA CATEGORIA DE NIVEL 1 QUE CONTIENE A LA REGLA DE NIVEL 3
                                                $category_idpuntuacion = $postrule->section->category_id;
                                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 3 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                                $categorypuntuacion = DB::table('categories')->find($category_idpuntuacion);

                                            @endphp
                                            {{--<a href="/estudiante/punctuation/{{$categorypuntuacion->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$postrule->name}}
                                            </a>--}}
                                            <a href="/estudiante/punctuation/{{$categorypuntuacion->slug}}/{{$postrule->section->slug}}/{{$postrule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$postrule->name}}</button>
                                            </a>
                                        @endif
                                       
                                    @endforeach
                                @endif

                                @if ($haypuntuacionenrules === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL CUATRO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION RULES -->
                                    @foreach ($questionType->rules as $rulerule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DE LA REGLA QUE SE RECORRE ES DE PUNTUACION -->
                                        @if ($rulerule->type === "Reglas ortográficas de puntuación")
                                            @php 
                                                    
                                                //MEDIANTE EL CAMPO SECTION_ID DE LA RELACION POST, SE BUSCA EL REGISTRO NIVEL 2 QUE CONTIENE A ESTA REGLA NIVEL 4
                                                $sectionrule_idpuntuacion = $rulerule->post->section_id;
                                                //BUSCAR EN LA TABLA SECTIONS LA REGLA DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 4 MEDIANTE EL CAMPO SECTION_ID DE POST
                                                $sectionrulepuntuacion = DB::table('sections')->find($sectionrule_idpuntuacion);

                                                //MEDIANTE EL CAMPO CATEGORY_ID DE LA VARIABLE SECTIONRULEPUNTUACION SE BUSCA EL REGISTRO DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 4
                                                $categoryrule_idpuntuacion = $sectionrulepuntuacion->category_id;
                                                $categoryrulepuntuacion = DB::table('categories')->find($categoryrule_idpuntuacion);

                                            @endphp
                                            {{--<a href="/estudiante/punctuation/{{$categoryrulepuntuacion->slug}}/{{$sectionrulepuntuacion->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$rulerule->name}}
                                            </a>--}}
                                            <a href="/estudiante/punctuation/{{$categoryrulepuntuacion->slug}}/{{$sectionrulepuntuacion->slug}}/{{$rulerule->post->slug}}/{{$rulerule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$rulerule->name}}</button>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                @endif


                                @if ($haypuntuacionennotes === true)
                                    <!-- SI HAY REGLAS ORTOGRAFICAS DE NIVEL CINCO ENTONCES MOSTRAR LAS REGLAS RECORRIENDO LA COLECCION DE LA PREGUNTA CON LA RELACION NOTES -->
                                    @foreach ($questionType->notes as $noterule)
                                        <!-- CON EL IF SE PREGUNTA SI EL TYPE DEE LA REGLA QUE SE RECORRE ES DE PUNTUACION -->
                                        @if ($noterule->type === "Reglas ortográficas de puntuación")
                                            @php 
                                                    
                                                //MEDIANTE EL CAMPO POST_ID DE LA RELACION RULE, SE BUSCA EL REGISTRO NIVEL 3 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                                $postrule_idpuntuacion = $noterule->rule->post_id;
                                                //BUSCAR EN LA TABLA SECTIONS LA REGLA DE NIVEL 3 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO POST_ID DE RULE
                                                $postrulepuntuacion = DB::table('posts')->find($postrule_idpuntuacion);

                                                //MEDIANTE EL CAMPO SECTION_ID DE LA VARIABLE POSTRULEPUNTUACION SE BUSCA EL REGISTRO NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                                $sectionrule_idpuntuacion = $postrulepuntuacion->section_id;
                                                //BUSCAR EN LA TABLA SECTION LA REGLA DE NIVEL 2 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO SECTION_ID DE POST
                                                $sectionrulepuntuacion = DB::table('sections')->find($sectionrule_idpuntuacion);

                                                //MEDIANTE EL CAMPO CATEGORY_ID DE LA VARIABLE SECTIONRULEPUNTUACION SE BUSCA EL REGISTRO NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 5
                                                $categoryrule_idpuntuacion = $sectionrulepuntuacion->category_id;
                                                //BUSCAR EN LA TABLA CATEGORIES LA REGLA DE NIVEL 1 QUE CONTIENE A ESTA REGLA DE NIVEL 5 MEDIANTE EL CAMPO CATEGORY_ID DE SECTION
                                                $categoryrulepuntuacion = DB::table('categories')->find($categoryrule_idpuntuacion);

                                            @endphp
                                            {{--<a href="/estudiante/punctuation/{{$categoryrulepuntuacion->slug}}/{{$sectionrulepuntuacion->slug}}/{{$postrulepuntuacion->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" class="text-blue-500">
                                                {{$noterule->name}}
                                                <br>
                                            </a>--}}
                                            <a href="/estudiante/punctuation/{{$categoryrulepuntuacion->slug}}/{{$sectionrulepuntuacion->slug}}/{{$postrulepuntuacion->slug}}/{{$noterule->rule->slug}}/{{$noterule->slug}}" target="_blank" rel="noopener noreferrer" >
                                                <button class="text-left text-lg font-sora font-semibold text-blue-700 block my-2">{{$noterule->name}}</button>
                                            </a>
                                        @endif
                                        
                                    @endforeach
                                @endif
                            </div>
                        </div>          
                    @endif




                </div>

            </div>



        </div>

    </div>




    <!-- //////////////////////////////////////////////////////////////////////////FIN NUEVA VISTA RESULTADOS PREGUNTA OMI///////////////////////////////////////////// -->


    
</x-app-layout>