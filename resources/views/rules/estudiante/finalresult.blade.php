<x-app-layout>
    Resultados Finales

<!--CARD-->
<div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
    <!--CARD HEADER -->
    <div class="bg-gray-200 rounded-xl p-6 overflow-hidden border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
        <h1 class="text-2xl font-bold mb-2 ">Resultados: {{$evaluation->name}}</h1>
        <br>
        <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
            <h4>Preguntas Totales: {{$totalQuestions}}</h4>
            <h4>Preguntas Respondidas: {{$questionsAnsweredUnique}}</h4>
            <h1 class="text-2xl font-bold mb-2 ">Puntaje: {{$calificacion}}</h1>
        </div>
    </div>
    <!--CARD BODY-->
    <div class="bg-gray-200 rounded-xl p-6 overflow-hidden text-gray-800 leading-relaxed mb-6 ">
        <!-- PREGUNTAR CON UN IF SI EN LA TABLA RESULTS SE TIENE MAS DE UNA RESPUESTA DE X USUARIO ASOCIADA A UNA PREGUTA, SI ES ASI ENTONCES
        HAGA LO PRIMERO, ESTO SIRVE PARA LAS PREGUNTAS QUE TIENEN MAS DE 1 REGISTRO EN LA TABLA RESULTS COMO LAS DE ESCRIBIR 5 PALABRAS O 5 ORACIONES -->
        <!-- RECORRER EN CADA TARJETA TIPO CARTA A LA COLECCION DE ENUNCIADOS Y PREGUNTAS RESPONDIDAS POR EL USUARIO -->
        @foreach ($results as $key=>$result)
            @if (($result->question->type) === "OM")
                <!--CARD-->
                <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
                    <!--CARD HEADER -->
                    <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                        <!-- DESDE LA COLECCION $RESULT, SE INGRESA A LA RELACION CON LA TABLA QUESTIONS Y AL CAMPO TITLE DE LA TABLA -->
                        <h1 class="text-2xl font-bold mb-2 ">{{$key+1}}. {{$result->question->title}}</h1>
                    </div>
                    <!-- CARD BODY -->
                    <div class="text-gray-800 leading-relaxed mb-6 ">
                        <!-- INDICACIONES DE LA PREGUNTA -->
                        <li>
                            <strong>Indicaciones de pregunta</strong>
                            @php
                                $j = 0;
                                $indications = DB::table('indications')->where('question_id', $result->question_id)->get();
                                foreach ($indications as $key=>$ind) {
                                    echo '<ul class="text-indigo-600">'. $key+1 . ')  ' . $ind->indication . '</ul>';
                                }
                            @endphp
                        </li>
                        <br>
                            <!-- ABRIENDO PHP SE PUEDE ESCRIBIR CODIGO PHP EN LAS VISTAS -->
                            <!-- $I VA A ITERAR PARA PONER UN NUMERO A CADA OPCION DE RESPUESTA Y LA VARIABLE $ANSWERS CONTIENE LA COLECCION DE RESPUESTAS
                            DE LA TABLA ANSWERS (SON LAS RESPUESTAS QUE CREA EL ADMIN, NO LAS QUE EL USUARIO RESPONDIO) CUYO QUESTION_ID SEA EL MISMO QUE EL QUESTION_ID
                        QUE VIENE DESDE EL METODO DE EVALUACIONCONTROLLER QUE VIENE POR CADA RESULTADO-->
                        <li>
                            <strong>Opciones de respuesta:</strong>
                            <br>
                            @php 
                                $i=1;
                                $answers = DB::table('answers')->where('question_id', $result->question_id)->get();
                                foreach ($answers as $ans) {
                                    echo '<ul>'. $i++ . ')  ' . $ans->answer . '</ul>';
                                }
                            @endphp
                            <!-- MOSTRAR LA RESPUESTA QUE ELIGIO EL ESTUDIANTE A LA PREGUNTA ACTUAL -->
                            <!-- SE ACCEDE A LA VARIABLE RESULT QUE VIENE DESDE EVALUACIONCONTROLLER Y A LA RELACION ANSWER DEL MODELO RESULT Y FINALMENTE AL CAMPO ANSWER DE LA TABLA ANSWERS -->
                            <br>
                            <p>
                                <strong class="text-red-500">Tu respuesta:  <span class="text-black">{{$result->answer_user}}</span></strong>
                            </p>
                            <!-- CON CODIGO PHP, GUARDAR EN LA VARIABLE RIGHT ANSWERS LAS RESPUESTAS CORRECTAS -->
                            @php
                                $rightAnswers = DB::table('answers')->where('question_id', $result->question_id)->where('is_correct', true)->get();
                                //RECORRER LA COLECCION DE RESPUESTAS CORRECTAS Y SEÑALAR LA RESPUESTA CORRECTA EN LA VISTA
                                foreach ($rightAnswers as $ans) {
                                    echo '<br><strong class="text-red-500">' . "Respuesta correcta:   " . '<span class="text-black">' . $ans->answer . '</span>'.'</strong>';
                                }
                            @endphp
                            <!-- CON CODIGO PHP CALCULAR EL PUNTAJE DE ESTA PREGUNTA -->
                            @php 
                                $resultados = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->pluck('score')->toArray();
                                $sumaresultados = array_sum($resultados);
                                //is_array($resultados) SIRVE PARA PROBAR SI PASAN LOS DATOS BIEN DEL ARRAY DE RESULTADOS
                                echo '<br><br><strong class="text-red-500">' . "Puntaje pregunta:   " . '<span class="text-black">' . $sumaresultados . '</span><strong>'
                            @endphp
                            <br>
                            
                        </li>
                    
                    </div>
                    <!-- CARD-FOOTER-->
                    <div class="border-t border-gray-300 pt-6 flex items-center justify-between">
                        <li>
                            <strong class="text-amber-600">Justificaciones a la respuesta:</strong>
                            @php
                                $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                                foreach ($justifications as $key => $jus) {
                                    echo '<ul><strong class="text-blue-500">' . $jus->reason . '</ul></strong>';
                                }
                            @endphp
                            <br>
                            <strong class="text-teal-800">Reglas asociadas:</strong>
                            @php
                                $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                                foreach ($justifications as $key => $jus) {
                                    echo '<ul><strong class="text-cyan-700">' . $jus->rule . '</ul></strong>';
                                }
                            @endphp
                        </li>
                    </div>
                </div>
                
            @elseif(($result->question->type) === "PC")
                <!--CARD-->
                <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
                    <!--CARD HEADER -->
                    <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                        <!-- DESDE LA COLECCION $RESULT, SE INGRESA A LA RELACION CON LA TABLA QUESTIONS Y AL CAMPO TITLE DE LA TABLA -->
                        <h1 class="text-2xl font-bold mb-2 text-black">{{$key+1}}. {{$result->question->title}}</h1>
                    </div>
                    <!--CARD BODY-->
                    <div class="text-gray-800 leading-relaxed mb-6">
                        <!-- INDICACIONES DE LA PREGUNTA -->
                        <li>
                            <strong>Indicaciones de pregunta:</strong>
                            @php
                                $j = 0;
                                $indications = DB::table('indications')->where('question_id', $result->question_id)->get();
                                foreach ($indications as $key => $ind) {
                                    echo '<ul class="text-indigo-600">'. $key+1 . ')  ' . $ind->indication . '</ul>';
                                }
                            @endphp
                        </li>
                        <br>
                        <!-- ABRIR PHP PARA CAPTURAR EL LISTADO DE RESPUESTAS CORRECTAS QUE FORMAN PARTE DE LA MISMA QUESTION_ID DEL RESULT ACTUAL -->
                        <li>
                            <!-- PALABRAS VISIBLES-->
                            <strong class="text-green-600">Palabras que se mostraron:</strong>
                            @php
                                $visibles = DB::table('answers')->where('question_id', $result->question_id)->get();
                                foreach ($visibles as $key => $vis) {
                                    echo '<ul>' . $key+1 . ') ' . $vis->visible_answer . '</ul>';
                                }
                            @endphp 
                            <br>
                            <!-- PALABRAS CORRECTAS -->
                            <strong class="text-rose-500">Palabras correctas:</strong>
                            @php 
                                $correctas = DB::table('answers')->where('question_id', $result->question->id)->get();
                                foreach ($correctas as $key => $cor) {
                                    echo '<ul>' . $key+1 . ')' . $cor->answer . '</ul>';
                                }
                            @endphp
                            <br>
                            <!-- RESPUESTAS USUARIO -->
                            <strong class="text-blue-700">Tus respuestas:</strong>
                            @php 
                                $respuestas = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->get();
                                foreach ($respuestas as $key => $res) {
                                    echo '<ul>' . $key+1 . ')' . $res->answer_user . '</ul>';
                                }
                            @endphp
                            <br>
                            <!-- PUNTAJE PREGUNTA -->
                            @php 
                                $resultados = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->pluck('score')->toArray();
                                $sumaresultados = array_sum($resultados);
                                //is_array($resultados) SIRVE PARA PROBAR SI PASAN LOS DATOS BIEN DEL ARRAY DE RESULTADOS
                                echo '<br><br><strong class="text-red-500">' . "Puntaje pregunta:   " . '<span class="text-black">' . $sumaresultados . '</span><strong>'
                            @endphp
                            <br>
                        </li>
                    </div>
                    <!-- CARD FOOTER -->
                    <div class="border-t border-gray-300 pt-6 flex items-center justify-between">
                        <!-- CON CODIGO PHP CAPTURAR Y MOSTRAR LAS PALABRAS QUE EL USUARIO ACERTO -->
                        <li>
                            <strong class="text-amber-700">Palabras acertadas:</strong>
                            @php 
                                //CREAR UN ARRAY PARA ALMACENAR LAS ORACIONES ACERTADAS
                                $palabrasAcertadas = [];
                                //TRAER DESDE LA BDD LA COLECCION DE RESPUESTAS DEL USUARIO DE LA TABLA RESULTS
                                $respuestasUsuario = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->pluck('answer_user')->toArray();
                                //TRAER DESDE LA BDD LA COLECCION DE RESPUESTAS CORRECTAS DE LA TABLA ANSWERS
                                $respuestasCorrectas = DB::table('answers')->where('question_id', $result->question_id)->pluck('answer')->toArray();
                                //CONTAR EL NUMERO DE ELEMENTOS QUE TIENE EL ARRAY DE RESPUESTAS USUARIO
                                $answersU_count = count($respuestasUsuario);
                                //RECORRER CON UN FOR EL ARRAY DE RESPUESTAS CORRECTAS Y EL ARRAY DE RESPUESTAS DE USUARIO Y LAS QUE CONCIDAN SE GUARDAN EN EL ARRAY ORACIONES ACERTADAS
                                for($i=0; $i<$answersU_count; $i++){
                                    $comparacion = strcmp($respuestasCorrectas[$i], $respuestasUsuario[$i]);
                                    if($comparacion == 0){
                                        array_push($palabrasAcertadas, $respuestasUsuario[$i]);
                                    }
                                }        

                                //IMPRIMIR LAS ORACIONES ACERTADAS
                                foreach($palabrasAcertadas as $key=>$oracion){
                                    echo '<ul class="text-black">' . $key+1 . ')' . $oracion . '</ul>';
                                }
                        
                            @endphp 
                        </li>
                        <!-- CON CODIGO PHP CAPTURAR Y MOSTRAR LAS PALABRAS QUE EL USUARIO NO ACERTO -->
                        <li>
                            <strong class="text-pink-600">Palabras incorrectas:</strong>
                            @php 
                                //CREAR UN ARRAY PARA ALMACENAR LAS ORACIONES INCORRECTAS
                                $palabrasIncorrectas = [];
                                //TRAER DESDE LA BDD LA COLECCION DE RESPUESTAS DEL USUARIO DE LA TABLA RESULTS
                                $respuestasUsuario = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->pluck('answer_user')->toArray();
                                //TRAER DESDE LA BDD LA COLECCION DE RESPUESTAS CORRECTAS DE LA TABLA ANSWERS
                                $respuestasCorrectas = DB::table('answers')->where('question_id', $result->question_id)->pluck('answer')->toArray();
                                //CONTAR EL NUMERO DE ELEMENTOS QUE TIENE EL ARRAY DE RESPUESTAS USUARIO
                                $answersU_count = count($respuestasUsuario);
                                //RECORRER CON UN FOR EL ARRAY DE RESPUESTAS CORRECTAS Y EL ARRAY DE RESPUESTAS DE USUARIO Y LAS QUE CONCIDAN SE GUARDAN EN EL ARRAY ORACIONES ACERTADAS
                                for($i=0; $i<$answersU_count; $i++){
                                    $comparacion = strcmp($respuestasCorrectas[$i], $respuestasUsuario[$i]);
                                    if(!($comparacion == 0)){
                                        array_push($palabrasIncorrectas, $respuestasUsuario[$i]);
                                    }
                                }        

                                //IMPRIMIR LAS ORACIONES ACERTADAS
                                foreach($palabrasIncorrectas as $key=>$oracion){
                                    echo '<ul class="text-black">' . $key+1 . ')' . $oracion . '</ul>';
                                }
                        
                            @endphp 
                        </li>
                        <!-- JUSTIFICACIONES -->
                        <li>
                            <strong class="text-amber-600">Justificaciones a la respuesta:</strong>
                            @php
                                $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                                foreach ($justifications as $key => $jus) {
                                    echo '<ul><strong class="text-blue-500">' . $jus->reason . '</ul></strong>';
                                }
                            @endphp
                            <br>
                            <strong class="text-teal-800">Reglas asociadas:</strong>
                            @php
                                $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                                foreach ($justifications as $key => $jus) {
                                    echo '<ul><strong class="text-cyan-700">' . $jus->rule . '</ul></strong>';
                                }
                            @endphp
                        </li>
                    </div>
                </div>

            @elseif(($result->question->type) === "OMI")
                <!--CARD-->
                <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
                    <!--CARD HEADER -->
                    <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                        <!-- DESDE LA COLECCION $RESULT, SE INGRESA A LA RELACION CON LA TABLA QUESTIONS Y AL CAMPO TITLE DE LA TABLA -->
                        <h1 class="text-2xl font-bold mb-2 ">{{$key+1}}. {{$result->question->title}}</h1>
                    </div>
                    <!-- CARD BODY -->
                    <div class="text-gray-800 leading-relaxed mb-6 ">
                        <!-- INDICACIONES DE LA PREGUNTA -->
                        <li>
                            <strong>Indicaciones de pregunta</strong>
                            @php
                                $j = 0;
                                $indications = DB::table('indications')->where('question_id', $result->question_id)->get();
                                foreach ($indications as $key=>$ind) {
                                    echo '<ul class="text-indigo-600">'. $key+1 . ')  ' . $ind->indication . '</ul>';
                                }
                            @endphp
                        </li>
                        <br>
                        <!-- IMAGEN -->
                        <div>
                            <img id="image" name="image" src="/storage/{{$result->question->image}}" alt="" height="400px" width="700px">
                        </div>
                            <!-- ABRIENDO PHP SE PUEDE ESCRIBIR CODIGO PHP EN LAS VISTAS -->
                            <!-- $I VA A ITERAR PARA PONER UN NUMERO A CADA OPCION DE RESPUESTA Y LA VARIABLE $ANSWERS CONTIENE LA COLECCION DE RESPUESTAS
                            DE LA TABLA ANSWERS (SON LAS RESPUESTAS QUE CREA EL ADMIN, NO LAS QUE EL USUARIO RESPONDIO) CUYO QUESTION_ID SEA EL MISMO QUE EL QUESTION_ID
                        QUE VIENE DESDE EL METODO DE EVALUACIONCONTROLLER QUE VIENE POR CADA RESULTADO-->
                        <li>
                            <strong>Opciones de respuesta:</strong>
                            <br>
                            @php 
                                $i=1;
                                $answers = DB::table('answers')->where('question_id', $result->question_id)->get();
                                foreach ($answers as $ans) {
                                    echo '<ul>'. $i++ . ')  ' . $ans->answer . '</ul>';
                                }
                            @endphp
                            <!-- MOSTRAR LA RESPUESTA QUE ELIGIO EL ESTUDIANTE A LA PREGUNTA ACTUAL -->
                            <!-- SE ACCEDE A LA VARIABLE RESULT QUE VIENE DESDE EVALUACIONCONTROLLER Y A LA RELACION ANSWER DEL MODELO RESULT Y FINALMENTE AL CAMPO ANSWER DE LA TABLA ANSWERS -->
                            <br>
                            <p>
                                <strong class="text-red-500">Tu respuesta:  <span class="text-black">{{$result->answer_user}}</span></strong>
                            </p>
                            <!-- CON CODIGO PHP, GUARDAR EN LA VARIABLE RIGHT ANSWERS LAS RESPUESTAS CORRECTAS -->
                            @php
                                $rightAnswers = DB::table('answers')->where('question_id', $result->question_id)->where('is_correct', true)->get();
                                //RECORRER LA COLECCION DE RESPUESTAS CORRECTAS Y SEÑALAR LA RESPUESTA CORRECTA EN LA VISTA
                                foreach ($rightAnswers as $ans) {
                                    echo '<br><strong class="text-red-500">' . "Respuesta correcta:   " . '<span class="text-black">' . $ans->answer . '</span>'.'</strong>';
                                }
                            @endphp
                            <!-- CON CODIGO PHP CALCULAR EL PUNTAJE DE ESTA PREGUNTA -->
                            @php 
                                $resultados = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->pluck('score')->toArray();
                                $sumaresultados = array_sum($resultados);
                                //is_array($resultados) SIRVE PARA PROBAR SI PASAN LOS DATOS BIEN DEL ARRAY DE RESULTADOS
                                echo '<br><br><strong class="text-red-500">' . "Puntaje pregunta:   " . '<span class="text-black">' . $sumaresultados . '</span><strong>'
                            @endphp
                            <br>
                            
                        </li>
                    
                    </div>
                    <!-- CARD-FOOTER-->
                    <div class="border-t border-gray-300 pt-6 flex items-center justify-between">
                        <li>
                            <strong class="text-amber-600">Justificaciones a la respuesta:</strong>
                            @php
                                $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                                foreach ($justifications as $key => $jus) {
                                    echo '<ul><strong class="text-blue-500">' . $jus->reason . '</ul></strong>';
                                }
                            @endphp
                            <br>
                            <strong class="text-teal-800">Reglas asociadas:</strong>
                            @php
                                $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                                foreach ($justifications as $key => $jus) {
                                    echo '<ul><strong class="text-cyan-700">' . $jus->rule . '</ul></strong>';
                                }
                            @endphp
                        </li>
                    </div>
                </div>

            @elseif(($result->question->type) === "OMA")
                <!--CARD-->
                <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
                    <!--CARD HEADER -->
                    <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                        <!-- DESDE LA COLECCION $RESULT, SE INGRESA A LA RELACION CON LA TABLA QUESTIONS Y AL CAMPO TITLE DE LA TABLA -->
                        <h1 class="text-2xl font-bold mb-2 ">{{$key+1}}. {{$result->question->title}}</h1>
                    </div>
                    <!-- CARD BODY -->
                    <div class="text-gray-800 leading-relaxed mb-6 ">
                        <!-- INDICACIONES DE LA PREGUNTA -->
                        <li>
                            <strong>Indicaciones de pregunta</strong>
                            @php
                                $j = 0;
                                $indications = DB::table('indications')->where('question_id', $result->question_id)->get();
                                foreach ($indications as $key=>$ind) {
                                    echo '<ul class="text-indigo-600">'. $key+1 . ')  ' . $ind->indication . '</ul>';
                                }
                            @endphp
                        </li>
                        <br>
                        <!-- IMAGEN -->
                        <div>
                            <img id="image" name="image" src="/storage/{{$result->question->image}}" alt="" height="400px" width="700px">
                        </div>
                        <!-- AUDIO -->
                        <div>
                            <strong>Audio</strong>
                            <br>
                            <audio id="audio" name="audio" controls src="/storage/{{$result->question->audio}}" type="audio">Tu navegador no soporta este elemento, utiliza otro navegador.</audio>
                        </div>
                            <!-- ABRIENDO PHP SE PUEDE ESCRIBIR CODIGO PHP EN LAS VISTAS -->
                            <!-- $I VA A ITERAR PARA PONER UN NUMERO A CADA OPCION DE RESPUESTA Y LA VARIABLE $ANSWERS CONTIENE LA COLECCION DE RESPUESTAS
                            DE LA TABLA ANSWERS (SON LAS RESPUESTAS QUE CREA EL ADMIN, NO LAS QUE EL USUARIO RESPONDIO) CUYO QUESTION_ID SEA EL MISMO QUE EL QUESTION_ID
                        QUE VIENE DESDE EL METODO DE EVALUACIONCONTROLLER QUE VIENE POR CADA RESULTADO-->
                        <li>
                            <strong>Opciones de respuesta:</strong>
                            <br>
                            @php 
                                $i=1;
                                $answers = DB::table('answers')->where('question_id', $result->question_id)->get();
                                foreach ($answers as $ans) {
                                    echo '<ul>'. $i++ . ')  ' . $ans->answer . '</ul>';
                                }
                            @endphp
                            <!-- MOSTRAR LA RESPUESTA QUE ELIGIO EL ESTUDIANTE A LA PREGUNTA ACTUAL -->
                            <!-- SE ACCEDE A LA VARIABLE RESULT QUE VIENE DESDE EVALUACIONCONTROLLER Y A LA RELACION ANSWER DEL MODELO RESULT Y FINALMENTE AL CAMPO ANSWER DE LA TABLA ANSWERS -->
                            <br>
                            <p>
                                <strong class="text-red-500">Tu respuesta:  <span class="text-black">{{$result->answer_user}}</span></strong>
                            </p>
                            <!-- CON CODIGO PHP, GUARDAR EN LA VARIABLE RIGHT ANSWERS LAS RESPUESTAS CORRECTAS -->
                            @php
                                $rightAnswers = DB::table('answers')->where('question_id', $result->question_id)->where('is_correct', true)->get();
                                //RECORRER LA COLECCION DE RESPUESTAS CORRECTAS Y SEÑALAR LA RESPUESTA CORRECTA EN LA VISTA
                                foreach ($rightAnswers as $ans) {
                                    echo '<br><strong class="text-red-500">' . "Respuesta correcta:   " . '<span class="text-black">' . $ans->answer . '</span>'.'</strong>';
                                }
                            @endphp
                            <!-- CON CODIGO PHP CALCULAR EL PUNTAJE DE ESTA PREGUNTA -->
                            @php 
                                $resultados = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->pluck('score')->toArray();
                                $sumaresultados = array_sum($resultados);
                                //is_array($resultados) SIRVE PARA PROBAR SI PASAN LOS DATOS BIEN DEL ARRAY DE RESULTADOS
                                echo '<br><br><strong class="text-red-500">' . "Puntaje pregunta:   " . '<span class="text-black">' . $sumaresultados . '</span><strong>'
                            @endphp
                            <br>
                            
                        </li>
                    
                    </div>
                    <!-- CARD-FOOTER-->
                    <div class="border-t border-gray-300 pt-6 flex items-center justify-between">
                        
                        <li>
                            <strong class="text-amber-600">Justificaciones a la respuesta:</strong>
                            @php
                                $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                                foreach ($justifications as $key => $jus) {
                                    echo '<ul><strong class="text-blue-500">' . $jus->reason . '</ul></strong>';
                                }
                            @endphp
                            <br>
                            <strong class="text-teal-800">Reglas asociadas:</strong>
                            @php
                                $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                                foreach ($justifications as $key => $jus) {
                                    echo '<ul><strong class="text-cyan-700">' . $jus->rule . '</ul></strong>';
                                }
                            @endphp
                        </li>
                    </div>
                </div>
            
            @elseif(($result->question->type) === "OA")
                <!--CARD-->
                <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
                    <!--CARD HEADER -->
                    <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                        <!-- DESDE LA COLECCION $RESULT, SE INGRESA A LA RELACION CON LA TABLA QUESTIONS Y AL CAMPO TITLE DE LA TABLA -->
                        <h1 class="text-2xl font-bold mb-2 ">{{$key+1}}. {{$result->question->title}}</h1>
                    </div>
                    <!-- CARD BODY -->
                    <div class="text-gray-800 leading-relaxed mb-6 ">
                        <!-- INDICACIONES DE LA PREGUNTA -->
                        <li>
                            <strong>Indicaciones de pregunta</strong>
                            @php
                                $j = 0;
                                $indications = DB::table('indications')->where('question_id', $result->question_id)->get();
                                foreach ($indications as $key=>$ind) {
                                    echo '<ul class="text-indigo-600">'. $key+1 . ')  ' . $ind->indication . '</ul>';
                                }
                            @endphp
                        </li>
                        <br>
                        <!-- IMAGEN -->
                        <div>
                            <img id="image" name="image" src="/storage/{{$result->question->image}}" alt="" height="400px" width="700px">
                        </div>
                        <!-- AUDIO -->
                        <br>
                        <div>
                            <strong>Audio</strong>
                            <br>
                            <audio id="audio" name="audio" controls src="/storage/{{$result->question->audio}}" type="audio">Tu navegador no soporta este elemento, utiliza otro navegador.</audio>
                        </div>
                        <br>
                        <!-- ABRIR PHP PARA CAPTURAR EL LISTADO DE RESPUESTAS CORRECTAS QUE FORMAN PARTE DE LA MISMA QUESTION_ID DEL RESULT ACTUAL -->
                        <li>
                           
                            <!-- ORACIONES CORRECTAS -->
                            <strong class="text-rose-500">Palabras correctas:</strong>
                            @php 
                                $correctas = DB::table('answers')->where('question_id', $result->question->id)->get();
                                foreach ($correctas as $key => $cor) {
                                    echo '<ul>' . $key+1 . ')' . $cor->answer . '</ul>';
                                }
                            @endphp
                            <br>
                            <!-- RESPUESTAS USUARIO -->
                            <strong class="text-blue-700">Tus respuestas:</strong>
                            @php 
                                $respuestas = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->get();
                                foreach ($respuestas as $key => $res) {
                                    echo '<ul>' . $key+1 . ')' . $res->answer_user . '</ul>';
                                }
                            @endphp
                            <br>
                            <!-- PUNTAJE PREGUNTA -->
                            @php 
                                $resultados = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->pluck('score')->toArray();
                                $sumaresultados = array_sum($resultados);
                                //is_array($resultados) SIRVE PARA PROBAR SI PASAN LOS DATOS BIEN DEL ARRAY DE RESULTADOS
                                echo '<br><br><strong class="text-red-500">' . "Puntaje pregunta:   " . '<span class="text-black">' . $sumaresultados . '</span><strong>'
                            @endphp
                            <br>
                        </li>
                    
                    </div>
                    <!-- CARD-FOOTER-->
                    <div class="border-t border-gray-300 pt-6 flex items-center justify-between">
                        <!-- CON CODIGO PHP CAPTURAR Y MOSTRAR LAS ORACIONES QUE EL USUARIO ACERTO -->
                        <li>
                            <strong class="text-amber-700">Oraciones acertadas:</strong>
                            @php 
                                //CREAR UN ARRAY PARA ALMACENAR LAS ORACIONES ACERTADAS
                                $oracionesAcertadas = [];
                                //TRAER DESDE LA BDD LA COLECCION DE RESPUESTAS DEL USUARIO DE LA TABLA RESULTS
                                $respuestasUsuario = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->pluck('answer_user')->toArray();
                                //TRAER DESDE LA BDD LA COLECCION DE RESPUESTAS CORRECTAS DE LA TABLA ANSWERS
                                $respuestasCorrectas = DB::table('answers')->where('question_id', $result->question_id)->pluck('answer')->toArray();
                                //CONTAR EL NUMERO DE ELEMENTOS QUE TIENE EL ARRAY DE RESPUESTAS USUARIO
                                $answersU_count = count($respuestasUsuario);
                                //RECORRER CON UN FOR EL ARRAY DE RESPUESTAS CORRECTAS Y EL ARRAY DE RESPUESTAS DE USUARIO Y LAS QUE CONCIDAN SE GUARDAN EN EL ARRAY ORACIONES ACERTADAS
                                for($i=0; $i<$answersU_count; $i++){
                                    $comparacion = strcmp($respuestasCorrectas[$i], $respuestasUsuario[$i]);
                                    if($comparacion == 0){
                                        array_push($oracionesAcertadas, $respuestasUsuario[$i]);
                                    }
                                }        

                                //IMPRIMIR LAS ORACIONES ACERTADAS
                                foreach($oracionesAcertadas as $key=>$oracion){
                                    echo '<ul class="text-black">' . $key+1 . ')' . $oracion . '</ul>';
                                }
                        
                            @endphp 
                        </li>
                        <!-- CON CODIGO PHP CAPTURAR Y MOSTRAR LAS ORACIONES QUE EL USUARIO NO ACERTO -->
                        <li>
                            <strong class="text-pink-600">Oraciones incorrectas:</strong>
                            @php 
                                //CREAR UN ARRAY PARA ALMACENAR LAS ORACIONES INCORRECTAS
                                $oracionesIncorrectas = [];
                                //TRAER DESDE LA BDD LA COLECCION DE RESPUESTAS DEL USUARIO DE LA TABLA RESULTS
                                $respuestasUsuario = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->pluck('answer_user')->toArray();
                                //TRAER DESDE LA BDD LA COLECCION DE RESPUESTAS CORRECTAS DE LA TABLA ANSWERS
                                $respuestasCorrectas = DB::table('answers')->where('question_id', $result->question_id)->pluck('answer')->toArray();
                                //CONTAR EL NUMERO DE ELEMENTOS QUE TIENE EL ARRAY DE RESPUESTAS USUARIO
                                $answersU_count = count($respuestasUsuario);
                                //RECORRER CON UN FOR EL ARRAY DE RESPUESTAS CORRECTAS Y EL ARRAY DE RESPUESTAS DE USUARIO Y LAS QUE CONCIDAN SE GUARDAN EN EL ARRAY ORACIONES ACERTADAS
                                for($i=0; $i<$answersU_count; $i++){
                                    $comparacion = strcmp($respuestasCorrectas[$i], $respuestasUsuario[$i]);
                                    if(!($comparacion == 0)){
                                        array_push($oracionesIncorrectas, $respuestasUsuario[$i]);
                                    }
                                }        

                                //IMPRIMIR LAS ORACIONES ACERTADAS
                                foreach($oracionesIncorrectas as $key=>$oracion){
                                    echo '<ul class="text-black">' . $key+1 . ')' . $oracion . '</ul>';
                                }
                        
                            @endphp 
                        </li>
                        <!-- JUSTIFICACIONES -->
                        <li>
                            <strong class="text-amber-600">Justificaciones a la respuesta:</strong>
                            @php
                                $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                                foreach ($justifications as $key => $jus) {
                                    echo '<ul><strong class="text-blue-500">' . $jus->reason . '</ul></strong>';
                                }
                            @endphp
                            <br>
                            <strong class="text-teal-800">Reglas asociadas:</strong>
                            @php
                                $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                                foreach ($justifications as $key => $jus) {
                                    echo '<ul><strong class="text-cyan-700">' . $jus->rule . '</ul></strong>';
                                }
                            @endphp
                        </li>
                    </div>
                </div>

            @elseif(($result->question->type) === "OI")

                <!--CARD-->
                <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
                    <!--CARD HEADER -->
                    <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                        <!-- DESDE LA COLECCION $RESULT, SE INGRESA A LA RELACION CON LA TABLA QUESTIONS Y AL CAMPO TITLE DE LA TABLA -->
                        <h1 class="text-2xl font-bold mb-2 ">{{$key+1}}. {{$result->question->title}}</h1>
                    </div>
                    <!-- CARD BODY -->
                    <div class="text-gray-800 leading-relaxed mb-6 ">
                        <!-- INDICACIONES DE LA PREGUNTA -->
                        <li>
                            <strong>Indicaciones de pregunta</strong>
                            @php
                                $j = 0;
                                $indications = DB::table('indications')->where('question_id', $result->question_id)->get();
                                foreach ($indications as $key=>$ind) {
                                    echo '<ul class="text-indigo-600">'. $key+1 . ')  ' . $ind->indication . '</ul>';
                                }
                            @endphp
                        </li>
                        <br>
                        <!-- IMAGEN -->
                        <div>
                            <img id="image" name="image" src="/storage/{{$result->question->image}}" alt="" height="400px" width="700px">
                        </div>
                        <br>
                        <!-- ABRIR PHP PARA CAPTURAR EL LISTADO DE RESPUESTAS CORRECTAS QUE FORMAN PARTE DE LA MISMA QUESTION_ID DEL RESULT ACTUAL -->
                        <li>
                           
                            <!-- ORACIONES CORRECTAS -->
                            <strong class="text-rose-500">Palabras correctas:</strong>
                            @php 
                                $correctas = DB::table('answers')->where('question_id', $result->question->id)->get();
                                foreach ($correctas as $key => $cor) {
                                    echo '<ul>' . $key+1 . ')' . $cor->answer . '</ul>';
                                }
                            @endphp
                            <br>
                            <!-- RESPUESTAS USUARIO -->
                            <strong class="text-blue-700">Tus respuestas:</strong>
                            @php 
                                $respuestas = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->get();
                                foreach ($respuestas as $key => $res) {
                                    echo '<ul>' . $key+1 . ')' . $res->answer_user . '</ul>';
                                }
                            @endphp
                            <br>
                            <!-- PUNTAJE PREGUNTA -->
                            @php 
                                $resultados = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->pluck('score')->toArray();
                                $sumaresultados = array_sum($resultados);
                                //is_array($resultados) SIRVE PARA PROBAR SI PASAN LOS DATOS BIEN DEL ARRAY DE RESULTADOS
                                echo '<br><br><strong class="text-red-500">' . "Puntaje pregunta:   " . '<span class="text-black">' . $sumaresultados . '</span><strong>'
                            @endphp
                            <br>
                        </li>
                    
                    </div>
                    <!-- CARD-FOOTER-->
                    <div class="border-t border-gray-300 pt-6 flex items-center justify-between">
                        <!-- CON CODIGO PHP CAPTURAR Y MOSTRAR LAS ORACIONES QUE EL USUARIO ACERTO -->
                        <li>
                            <strong class="text-amber-700">Oraciones acertadas:</strong>
                            @php 
                                //CREAR UN ARRAY PARA ALMACENAR LAS ORACIONES ACERTADAS
                                $oracionesAcertadas = [];
                                //TRAER DESDE LA BDD LA COLECCION DE RESPUESTAS DEL USUARIO DE LA TABLA RESULTS
                                $respuestasUsuario = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->pluck('answer_user')->toArray();
                                //TRAER DESDE LA BDD LA COLECCION DE RESPUESTAS CORRECTAS DE LA TABLA ANSWERS
                                $respuestasCorrectas = DB::table('answers')->where('question_id', $result->question_id)->pluck('answer')->toArray();
                                //CONTAR EL NUMERO DE ELEMENTOS QUE TIENE EL ARRAY DE RESPUESTAS USUARIO
                                $answersU_count = count($respuestasUsuario);
                                //RECORRER CON UN FOR EL ARRAY DE RESPUESTAS CORRECTAS Y EL ARRAY DE RESPUESTAS DE USUARIO Y LAS QUE CONCIDAN SE GUARDAN EN EL ARRAY ORACIONES ACERTADAS
                                for($i=0; $i<$answersU_count; $i++){
                                    $comparacion = strcmp($respuestasCorrectas[$i], $respuestasUsuario[$i]);
                                    if($comparacion == 0){
                                        array_push($oracionesAcertadas, $respuestasUsuario[$i]);
                                    }
                                }        

                                //IMPRIMIR LAS ORACIONES ACERTADAS
                                foreach($oracionesAcertadas as $key=>$oracion){
                                    echo '<ul class="text-black">' . $key+1 . ')' . $oracion . '</ul>';
                                }
                        
                            @endphp 
                        </li>
                        <!-- CON CODIGO PHP CAPTURAR Y MOSTRAR LAS ORACIONES QUE EL USUARIO NO ACERTO -->
                        <li>
                            <strong class="text-pink-600">Oraciones incorrectas:</strong>
                            @php 
                                //CREAR UN ARRAY PARA ALMACENAR LAS ORACIONES INCORRECTAS
                                $oracionesIncorrectas = [];
                                //TRAER DESDE LA BDD LA COLECCION DE RESPUESTAS DEL USUARIO DE LA TABLA RESULTS
                                $respuestasUsuario = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->pluck('answer_user')->toArray();
                                //TRAER DESDE LA BDD LA COLECCION DE RESPUESTAS CORRECTAS DE LA TABLA ANSWERS
                                $respuestasCorrectas = DB::table('answers')->where('question_id', $result->question_id)->pluck('answer')->toArray();
                                //CONTAR EL NUMERO DE ELEMENTOS QUE TIENE EL ARRAY DE RESPUESTAS USUARIO
                                $answersU_count = count($respuestasUsuario);
                                //RECORRER CON UN FOR EL ARRAY DE RESPUESTAS CORRECTAS Y EL ARRAY DE RESPUESTAS DE USUARIO Y LAS QUE CONCIDAN SE GUARDAN EN EL ARRAY ORACIONES ACERTADAS
                                for($i=0; $i<$answersU_count; $i++){
                                    $comparacion = strcmp($respuestasCorrectas[$i], $respuestasUsuario[$i]);
                                    if(!($comparacion == 0)){
                                        array_push($oracionesIncorrectas, $respuestasUsuario[$i]);
                                    }
                                }        

                                //IMPRIMIR LAS ORACIONES ACERTADAS
                                foreach($oracionesIncorrectas as $key=>$oracion){
                                    echo '<ul class="text-black">' . $key+1 . ')' . $oracion . '</ul>';
                                }
                        
                            @endphp 
                        </li>
                        <!-- JUSTIFICACIONES -->
                        <li>
                            <strong class="text-amber-600">Justificaciones a la respuesta:</strong>
                            @php
                                $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                                foreach ($justifications as $key => $jus) {
                                    echo '<ul><strong class="text-blue-500">' . $jus->reason . '</ul></strong>';
                                }
                            @endphp
                            <br>
                            <strong class="text-teal-800">Reglas asociadas:</strong>
                            @php
                                $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                                foreach ($justifications as $key => $jus) {
                                    echo '<ul><strong class="text-cyan-700">' . $jus->rule . '</ul></strong>';
                                }
                            @endphp
                        </li>
                    </div>
                </div>

            @elseif(($result->question->type) === "TI")

            <!--CARD-->
            <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
                <!--CARD HEADER -->
                <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                    <!-- DESDE LA COLECCION $RESULT, SE INGRESA A LA RELACION CON LA TABLA QUESTIONS Y AL CAMPO TITLE DE LA TABLA -->
                    <h1 class="text-2xl font-bold mb-2 ">{{$key+1}}. {{$result->question->title}}</h1>
                </div>
                <!-- CARD BODY -->
                <div class="text-gray-800 leading-relaxed mb-6 ">
                    <!-- INDICACIONES DE LA PREGUNTA -->
                    <li>
                        <strong>Indicaciones de pregunta</strong>
                        @php
                            $j = 0;
                            $indications = DB::table('indications')->where('question_id', $result->question_id)->get();
                            foreach ($indications as $key=>$ind) {
                                echo '<ul class="text-indigo-600">'. $key+1 . ')  ' . $ind->indication . '</ul>';
                            }
                        @endphp
                    </li>
                    <br>
                    <!-- IMAGEN -->
                    <div>
                        <img id="image" name="image" src="/storage/{{$result->question->image}}" alt="" height="400px" width="700px">
                    </div>
                        <!-- ABRIENDO PHP SE PUEDE ESCRIBIR CODIGO PHP EN LAS VISTAS -->
                        <!-- $I VA A ITERAR PARA PONER UN NUMERO A CADA OPCION DE RESPUESTA Y LA VARIABLE $ANSWERS CONTIENE LA COLECCION DE RESPUESTAS
                        DE LA TABLA ANSWERS (SON LAS RESPUESTAS QUE CREA EL ADMIN, NO LAS QUE EL USUARIO RESPONDIO) CUYO QUESTION_ID SEA EL MISMO QUE EL QUESTION_ID
                    QUE VIENE DESDE EL METODO DE EVALUACIONCONTROLLER QUE VIENE POR CADA RESULTADO-->
                    <li>
                        <strong>Resultado:</strong>
                        <!-- MOSTRAR LA RESPUESTA QUE ELIGIO EL ESTUDIANTE A LA PREGUNTA ACTUAL -->
                        <!-- SE ACCEDE A LA VARIABLE RESULT QUE VIENE DESDE EVALUACIONCONTROLLER Y A LA RELACION ANSWER DEL MODELO RESULT Y FINALMENTE AL CAMPO ANSWER DE LA TABLA ANSWERS -->
                        <br>
                        <p>
                            <strong class="text-red-500">Tu respuesta:  <span class="text-black">{{$result->answer_user}}</span></strong>
                        </p>
                        <!-- CON CODIGO PHP, GUARDAR EN LA VARIABLE RIGHT ANSWERS LAS RESPUESTAS CORRECTAS -->
                        @php
                            $rightAnswers = DB::table('answers')->where('question_id', $result->question_id)->where('is_correct', true)->get();
                            //RECORRER LA COLECCION DE RESPUESTAS CORRECTAS Y SEÑALAR LA RESPUESTA CORRECTA EN LA VISTA
                            foreach ($rightAnswers as $ans) {
                                echo '<br><strong class="text-red-500">' . "Respuesta correcta:   " . '<span class="text-black">' . $ans->answer . '</span>'.'</strong>';
                            }
                        @endphp
                        <!-- CON CODIGO PHP CALCULAR EL PUNTAJE DE ESTA PREGUNTA -->
                        @php 
                            $resultados = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->pluck('score')->toArray();
                            $sumaresultados = array_sum($resultados);
                            //is_array($resultados) SIRVE PARA PROBAR SI PASAN LOS DATOS BIEN DEL ARRAY DE RESULTADOS
                            echo '<br><br><strong class="text-red-500">' . "Puntaje pregunta:   " . '<span class="text-black">' . $sumaresultados . '</span><strong>'
                        @endphp
                        <br>
                        
                    </li>
                
                </div>
                <!-- CARD-FOOTER-->
                <div class="border-t border-gray-300 pt-6 flex items-center justify-between">
                    <li>
                        <strong class="text-amber-600">Justificaciones a la respuesta:</strong>
                        @php
                            $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                            foreach ($justifications as $key => $jus) {
                                echo '<ul><strong class="text-blue-500">' . $jus->reason . '</ul></strong>';
                            }
                        @endphp
                        <br>
                        <strong class="text-teal-800">Reglas asociadas:</strong>
                        @php
                            $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                            foreach ($justifications as $key => $jus) {
                                echo '<ul><strong class="text-cyan-700">' . $jus->rule . '</ul></strong>';
                            }
                        @endphp
                    </li>
                </div>
                <!-- RESULTADO DETALLADO -->
                <div class="border-t border-gray-300 pt-6 flex items-center justify-between">
                    <li>
                        <strong class="text-sky-700">Respuesta detallada:</strong>
                        @php 
                            //REGISTRO DE LA TABLA ANSWERS TEXTO ORIGINAL
                            //$rightAnswers = DB::table('answers')->where('question_id', $result->question_id)->where('is_correct', true)->get()->first();
                            //CAPTURAR SOLO EL TEXTO ORIGINAL
                            //$res = $rightAnswers->answer;
                            //SEPARAR LA CADENA DE TEXTO EN PALABRAS
                            //$separador= [",", ":", ".", ";", ""]

                            //$se = "\n";
                            //$resultado = explode($se, $res);


                            //echo '<div>' . $resultado . '</div>';
                            

                     
                        @endphp 
                    </li>
                </div>
            </div>

            @elseif(($result->question->type) === "TA")

            <!--CARD-->
            <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
                <!--CARD HEADER -->
                <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                    <!-- DESDE LA COLECCION $RESULT, SE INGRESA A LA RELACION CON LA TABLA QUESTIONS Y AL CAMPO TITLE DE LA TABLA -->
                    <h1 class="text-2xl font-bold mb-2 ">{{$key+1}}. {{$result->question->title}}</h1>
                </div>
                <!-- CARD BODY -->
                <div class="text-gray-800 leading-relaxed mb-6 ">
                    <!-- INDICACIONES DE LA PREGUNTA -->
                    <li>
                        <strong>Indicaciones de pregunta</strong>
                        @php
                            $j = 0;
                            $indications = DB::table('indications')->where('question_id', $result->question_id)->get();
                            foreach ($indications as $key=>$ind) {
                                echo '<ul class="text-indigo-600">'. $key+1 . ')  ' . $ind->indication . '</ul>';
                            }
                        @endphp
                    </li>
                    <br>
                    <!-- IMAGEN -->
                    <div>
                        <img id="image" name="image" src="/storage/{{$result->question->image}}" alt="" height="400px" width="700px">
                    </div>

                    <!-- AUDIO -->
                    <br>
                    <div>
                        <strong>Audio</strong>
                        <br>
                        <audio id="audio" name="audio" controls src="/storage/{{$result->question->audio}}" type="audio">Tu navegador no soporta este elemento, utiliza otro navegador.</audio>
                    </div>
                    <br>


                        <!-- ABRIENDO PHP SE PUEDE ESCRIBIR CODIGO PHP EN LAS VISTAS -->
                        <!-- $I VA A ITERAR PARA PONER UN NUMERO A CADA OPCION DE RESPUESTA Y LA VARIABLE $ANSWERS CONTIENE LA COLECCION DE RESPUESTAS
                        DE LA TABLA ANSWERS (SON LAS RESPUESTAS QUE CREA EL ADMIN, NO LAS QUE EL USUARIO RESPONDIO) CUYO QUESTION_ID SEA EL MISMO QUE EL QUESTION_ID
                    QUE VIENE DESDE EL METODO DE EVALUACIONCONTROLLER QUE VIENE POR CADA RESULTADO-->
                    <li>
                        <strong>Resultado:</strong>
                        <!-- MOSTRAR LA RESPUESTA QUE ELIGIO EL ESTUDIANTE A LA PREGUNTA ACTUAL -->
                        <!-- SE ACCEDE A LA VARIABLE RESULT QUE VIENE DESDE EVALUACIONCONTROLLER Y A LA RELACION ANSWER DEL MODELO RESULT Y FINALMENTE AL CAMPO ANSWER DE LA TABLA ANSWERS -->
                        <br>
                        <p>
                            <strong class="text-red-500">Tu respuesta:  <span class="text-black">{{$result->answer_user}}</span></strong>
                        </p>
                        <!-- CON CODIGO PHP, GUARDAR EN LA VARIABLE RIGHT ANSWERS LAS RESPUESTAS CORRECTAS -->
                        @php
                            $rightAnswers = DB::table('answers')->where('question_id', $result->question_id)->where('is_correct', true)->get();
                            //RECORRER LA COLECCION DE RESPUESTAS CORRECTAS Y SEÑALAR LA RESPUESTA CORRECTA EN LA VISTA
                            foreach ($rightAnswers as $ans) {
                                echo '<br><strong class="text-red-500">' . "Respuesta correcta:   " . '<span class="text-black">' . $ans->answer . '</span>'.'</strong>';
                            }
                        @endphp
                        <!-- CON CODIGO PHP CALCULAR EL PUNTAJE DE ESTA PREGUNTA -->
                        @php 
                            $resultados = DB::table('results')->where('question_id', $result->question_id)->where('user_id', auth()->user()->id)->pluck('score')->toArray();
                            $sumaresultados = array_sum($resultados);
                            //is_array($resultados) SIRVE PARA PROBAR SI PASAN LOS DATOS BIEN DEL ARRAY DE RESULTADOS
                            echo '<br><br><strong class="text-red-500">' . "Puntaje pregunta:   " . '<span class="text-black">' . $sumaresultados . '</span><strong>'
                        @endphp
                        <br>
                        
                    </li>
                
                </div>
                <!-- CARD-FOOTER-->
                <div class="border-t border-gray-300 pt-6 flex items-center justify-between">
                    <li>
                        <strong class="text-amber-600">Justificaciones a la respuesta:</strong>
                        @php
                            $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                            foreach ($justifications as $key => $jus) {
                                echo '<ul><strong class="text-blue-500">' . $jus->reason . '</ul></strong>';
                            }
                        @endphp
                        <br>
                        <strong class="text-teal-800">Reglas asociadas:</strong>
                        @php
                            $justifications = DB::table('justifications')->where('question_id', $result->question_id)->get();
                            foreach ($justifications as $key => $jus) {
                                echo '<ul><strong class="text-cyan-700">' . $jus->rule . '</ul></strong>';
                            }
                        @endphp
                    </li>
                </div>
            </div>

            @endif

        


        @endforeach
    </div>

    <!-- FOOTER CON BOTON PARA REGRESAR A LA ZONA DE EVALUACION DIAGNOSTICO -->
    <div class="border-t border-gray-300 pt-6 flex items-center justify-between">
        <a href="{{route('estudiante.diagnostico')}}">
            <button class="px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all text-white bg-blue-500 hover:bg-blue-700 ring-blue-300 focus:ring">Regresar</button>
        </a>
    </div>
</div>
</x-app-layout>