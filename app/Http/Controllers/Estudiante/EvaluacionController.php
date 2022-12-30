<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evaluation;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
use App\Models\Result;
use App\Models\Answer;
use PDO;

class EvaluacionController extends Controller
{
    //METODO PARA OBTENER LAS PREGUNTAS DEL EXAMEN ACTUAL
    //PARA QUE EL USUARIO RESPONDA
    public function getEvaluationQuestions(Evaluation $evaluation){

        //CAPTURAR EL ID DEL USUARIO ACTUAL 
        $authUser = auth()->user()->id;

        //VIDEO 93 HANDLING SITUATION
        //CONTROLAR QUE UN USUARIO NO PUEDA ENTRAR A UN EXAMEN QUE NO LE PERTENECE
        //EN LA VARIABLE USERID GUARDAR UN ARRAY QUE CONTIENE LOS REGISTROS DE LA TABLA EVALUATION_USER QUE TIENEN EL ID DEL USUARIO ACTUAL LOGEADO
        //ES DECIR, DE SUS EXAMENES ASIGNADOS, LUEGO CON EL METODO PLUCK SOLO ALMACENAR EN EL ARRAY, LOS IDS ENCONTRADOS EEN LA TABLA EVALUATION_USER
        //$userId = DB::table('evaluation_user')->where('user_id', $authUser)->pluck('evaluation_id')->toArray();

        //return $userId;
        //CON EL IF SE PREGUNTA SI EN EL ARRAY DE IDS DE EXAMENES ASIGNADOS AL USUARIO ACTUAL, ESTA EL ID DEL EXAMEN AL QUE ESTA INTENTANDO ENTRAR
        //SI ESE ID DEL EXAMEN NO ESTA AHI, ENTONCES NO PUEDE ENTRAR
        //if(!in_array($quizId, $userId)){
        //   return redirect()->to('/student')->with('error', 'No tienes asignado ese examen');
        //}

        ////////////////////////////////////////////////////////ACTUALIZACION CONTROLAR QUE UN USUARIO NO PUEDA ENTRAR A UN EXAMEN QUE NO LE PERTENECE

        //EN LA VARIABLE EVALUACIONESASIGNADAS SE GUARDA UN ARRAY QUE CONTIENE LOS CAMPOS EVALUATION_ID DE LA TABLA EVALUATION_USER QUE CONTIENE LOS 
        //EXAMENES ASIGNADOS AL USUARIO ACTUAL LOGEADO
        $evaluacionesAsignadas = DB::table('evaluation_user')->where('user_id', $authUser)->pluck('evaluation_id')->toArray();

        //CON UN IF SE PREGUNTA SI EL ID DE LA EVALUACION ACTUAL A LA QUE EL ESTUDIANTE ESTA INTENTANDO INGRESAR ESTA DENTRO
        //DEL ARRAY DE EVALUACIONES ASIGNADAS AL ESTUDIANTE ACTUAL LOGEADO
        //SI ESTA DENTRO DE LAS EVALUACIONES ASIGNADAS ENTONCES QUE MUESTRE LAS PREGUNTAS ACTUALES AL ESTUDIANTE
        //PERO SI NO ESTA ASIGNADA ESA EVALUACION QUE LO ENVIE A LA PAGINA PRINCIPAL CON UN MENSAJE

        if(in_array($evaluation->id, $evaluacionesAsignadas)){
            //SI TIENE EL EXAMEN ASIGNADO ENTONCES QUE MUESTRE LAS PREGUNTAS ASIGNADAS CON EL SIGUIENTE PROCESO

            //EN LA VARIABLE EVALUATIONQUESTIONS SE GUARDA LA COLECCION DE ENUNCIADOS DE PREGUNTA DE LA EVALUATION A RESOLVER
            $evaluationQuestions = Question::where('evaluation_id', $evaluation->id)->get();

            //EN LA VARIABLE AUTHUSERHASPLAYEDEVALUATION SE VAN GUARDANDO LOS REGISTROS DE LA TABLA RESULTS, LOS CUALES TENGAN
            //EL USERID DEL USUARIO ACTUAL Y EL QUIZID DEL EXAMEN ACTUAL QUE ESTA RESOLVIENDO
            //ES DECIR, SE VA GUARDANDO LA COLECCION DE PREGUNTAS QUE VA RESPONDIENDO
            //CUANDO SE VAYA A BUSCAR REGISTROS EN UNA TABLA SEGUN VARIAS COLUMNAS, SE ENVIA ESAS COLUMNAS EN UN ARRAY
            $authUserHasPlayedEvaluation = Result::where(['user_id' => $authUser, 'evaluation_id' => $evaluation->id])->get();


            ///////////////////////////////////////////////////////////////////////////////////////////////////////////

            //EN LA VARIABLE PREGUNTAS ASIGNADAS SE VA A CAPTURAR LOS IDS DE LAS PREGUNTAS DE LA EVALUACION ACTUAL
            $preguntasAsignadas = DB::table('questions')->where('evaluation_id', $evaluation->id)->pluck('id')->toArray();

            //EN LA VARIABLE NROPREGUNTASEXAMEN SE GUARDA EL NUMERO DE PREGUNTAS DEL EXAMEN ACTUAL
            $nropreguntasExamen = count($evaluation->questions);

            //EN LA VARIABLE PREGUNTASRESPONDIDAS SE VA A CAPTURAR LA COLECCION DE PREGUNTAS QUE EL USUARIO HA RESPONDIDO DEL EXAMEN ACTUAL
            //Y QUE ESTEN EN LA TABLA RESULTS, QUE TENGAN EL MISMO EVALUATION_ID, QUE TENGAN EL MISMO QUESTION_ID DE LAS PREGUNTAS DE LA EVALUACION ACTUAL
            //Y QUE TENGAN EL MISMO ID QUE EL USUARIO ACTUAL LOGEADO
            $preguntasRespondidas = DB::table('results')->where('evaluation_id', $evaluation->id)->where('user_id', $authUser)->whereIn('question_id', $preguntasAsignadas)->get();

            //COMO EN LA TABLA RESULTS SE ALMACENAN VARIAS RESPUESTAS SEGUN EL TIPO DE PREGUNTA, POR EJEMPLO LA QUESTION OM GUARDA 1 REGISTRO EN RESULTS PERO LA QUESTION PC GUARDA 5 REGISTROS
            //POR LO QUE LA COLECCION DE PREGUNTASRESPONDIDAS QUE VIENE DESDE LA TABLA RESULTS SOLO SE CAPTURA LOS PRIMEROS ELEMENTOS CON QUESTION_ID DIFERENTES
            $resultadoPreguntasRespondidas = $preguntasRespondidas->unique('question_id')->values();

            //EN LA VARIABLE NROPREGUNTASRESPONDIDAS SE GUARDA EL NUMERO DE QUESTIONS RESPONDIDAS POR EL USUARIO SEGUN LA TABLA RESULTS
            $nroPreguntasRespondidas = count($resultadoPreguntasRespondidas);

            //AHORA, EN LA VARIABLE EXAMENCOMPLETADO QUE ES TIPO BOOLEAN SE ENVIA TRUE SI EL NUMERO DE QUESTIONS DEL EXAMEN COINCIDE CON EL NUMERO DE QUESTIONS RESPONDIDAS
            //POR EL USUARIO ACTUAL QUE VIENE DE LA TABLA RESULTS, ESTO SIRVE PARA SEGUN SI ES TRUE O FALSE MOSTRAR EL BOTON DE FINALIZAR EXAMEN O REGRESAR
            $examenCompletado = false;
            if($nropreguntasExamen === $nroPreguntasRespondidas){
                $examenCompletado = true;
            }

            //EN LA VARIABLE TIPOEXAMEN SE CAPTURA EL TIPO DE EXAMEN SI ES DIAGNOSTICO, PRACTICA O FINAL PARA SEGUN ESO REDIRIGIR A LA PAGINA ANTERIOR MIENTRAS NO HAYA TERMINADO EL EXAMEN
            $tipoExamen = $evaluation->type;

            //VARIABLE QUE BUSCA EN LA TABLA RESULTS Y DEVUELVE EL NUMERO DE PREGUNTAS QUE EL USUARIO HA RESPONDIDO HASTA AHORA
            //return $nroPreguntasRespondidas;

            return view('rules.estudiante.questions', compact('evaluation', 'evaluationQuestions', 'authUserHasPlayedEvaluation', 'examenCompletado', 'tipoExamen', 'nroPreguntasRespondidas'));

        }else{
            //SI NO TIENE EL EXAMEN ASIGNADO ENTONCES QUE LO ENVIE A LA PAGINA DE INICIO CON UN MENSAJE
            return redirect()->route('estudiante.letterslevelone')->with('message', 'No tienes asignado ese examen');
        }
    

        //////////////////////////////////////////////////////////////////////////////////////////////////

        

        


        

    } 


    //METODO PARA MOSTRAR UNA POR UNA LAS PREGUNTAS PARA QUE EL USUARIO RESPONDA
    public function responseQuestion($evaluacionId, $questionId){
        

        ////OBTENER LA PREGUNTA ACTUAL A LA QUE EL USUARIO TRATA DE INGRESAR A RESPONDER
        //////$question = Question::find($questionId);

        ///////////////////////CONTROLAR QUE EL USUARIO NO PUEDA INGRESAR A LA PREGUNTA QUE YA RESPONDIO

        ////CAPTURAR ID DEL USUARIO ACTUAL
        ////$authUser = auth()->user()->id;

        ////EN QUESTIONWASCOMPLETED SE BUSCA SI EN LA TABLA RESULTS YA EXISTE UN REGISTRO DONDE TENGA EL ID DEL USUARIO ACTUAL, 
        ////EL ID DE LA EVALUATION ACTUAL Y EL ID DE LA QUESTION ACTUAL
        //////$questionWasCompleted = Result::where('user_id', $authUser)->where('evaluation_id', $evaluacionId)->where('question_id', $questionId)->exists();

        ////BUSCAR EN LA TABLA EVALUATION LA EVALUACION ACTUAL QUE ESTA RESPONDIENDO
        /////$evaluation = Evaluation::find($evaluacionId);

        ////CON EL IF SE PREGUNTA SI EXISTE ESE REGISTRO DE LA PREGUNTA ACTUAL QUE YA HA SIDO RESPONDIDA
        ////SI ES ASI, SIGNIFICA QUE YA HA RESPONDIDO LA PREGUNTA Y NO LO DEJE ENTRAR DE NUEVO
        
        //if($questionWasCompleted){
        //    //return redirect()->route('estudiante.preguntasevaluacion', $evaluation)->with('message', 'Ya has respondido la pregunta')->with('questionWasCompleted', $questionWasCompleted);
        /////    return redirect()->route('estudiante.preguntasevaluacion', $evaluation)->with('message', 'Ya has respondido la pregunta');
        //}
        //else{
        //    return view('rules.estudiante.response', compact('question'));
        //}


        //////////////////////////////////////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////////////////CODIGO IR A LA PREGUNTA DE LA VISTA RULES.ESTUDIANTE.RESPONSE////////////////////////////////////////////////

        ////OBTENER LA PREGUNTA ACTUAL A LA QUE EL USUARIO TRATA DE INGRESAR A RESPONDER
        //$question = Question::find($questionId);

        ////BUSCAR EN LA TABLA EVALUATION LA EVALUACION ACTUAL QUE ESTA RESPONDIENDO
        //$evaluation = Evaluation::find($evaluacionId);

        ////CAPTURAR EL ID DEL USUARIO ACTUAL LOGEADO
        //$authUser = auth()->user()->id;
        
        ////EN LA VARIABLE ASSIGNEDQUESTIONSID SE VA A TOMAR SOLO LOS IDS DEL USUARIO ACTUAL Y TODAS LAS QUESTIONS DE LA EVALUACION ACTUAL
        ////QUE QUIERE RESOLVER
        ////PRIMERO SE CAPTURA EL EXAMEN ACTUAL QUE EL USUARIO QUIERE RESOLVER
        //$evaluacionActual = Evaluation::find($evaluacionId);
        ////YA TENIENDO EL EXAMEN VAMOS A BUSCAR EN LA TABLA QUESTIONS, TODAS LAS QUESTIONS DE ESE EXAMEN ESPECIFICO
        ////DE ESA COLECCION SOLO SE VA A SACAR LOS IDS DE LAS QUESTIONS Y SE LOS ALMACENA EN UN ARRAY
        //$questionsActuales = Question::where('evaluation_id', $evaluacionActual->id)->pluck('id')->toArray();

        ////EN LA VARIABLE WASQUESTIONCOMPLETED SE CONSULTA EEN LA TABLA RESULT LOS REGISTROS CUYO CAMPO USER_ID COINCIDAN CON EL ID DEL USUARIO ACTUAL
        ////Y A ESOS REGISTROS QUE COINCIDAN, CON EL METODO WHEREIN() SE VA COMPROBANDO SI EL CAMPO QUESTION_ID DE ESOS REGISTROS COINCIDEE CON LOS IDS
        ////DE LAS PREGUNTAS QUE EL USUARIO YA RESPONDIO (POR ESO SE CREA UNA INSTANCIA DEL MODELO QUESTION Y SE INVOCA AL METODO HASQUESTIONATTEMPTED PARA COMPROBARLOS)
        ////Y CUANDO ENCUENTRE ESOS REGISTROS QUE COINCIDEN, ENTONCES CON EL METODO PLUCK() SOLO VA A SACAR EL CAMPO QUESTION_ID DE ESOS REGISTROS
        ////Y LOS VA A ALMACENAR EN EL ARRAY WASQUESTIONCOMPLETED
        //$wasQuestionCompleted = Result::where('user_id', $authUser)->whereIn('question_id', (new Question)->hasQuestionAttempted())->pluck('question_id')->toArray();

        ////EN LA VARIABLE QUESTIONWASCOMPLETED SE VA A COMPROBAR SI EN LA TABLA RESULTS YA EXISTE UN REGISTRO DONDE TENGA EL ID DEL USUARIO ACTUAL,
        ////EL ID DE LA EVALUACION ACTUAL Y EL ID DE LA QUESTION ACTUAL
        //$questionWasCompleted = Result::where('user_id', $authUser)->where('evaluation_id', $evaluacionId)->where('question_id', $questionId)->exists();

        ////CON EL IF SE PREGUNTA SI EXISTE ESE REGISTRO DE LA PREGUNTA A LA QUE TRATA DE INGRESAR EN LA TABLA RESULTS, LO QUE SIGNIFICA QUE YA HA SIDO RESPONDIDA
        ////SI ES ASI, ENTONCES QUE NO LO DEJE ENTRAR DE NUEVO A LA PREGUNTA
        //if($questionWasCompleted){
        //    return redirect()->route('estudiante.preguntasevaluacion', $evaluation)->with('message', 'Ya has respondido la pregunta.');  
        //}
        //else{
        //    return view('rules.estudiante.response', compact('question'));
        //}

        ///////////////////////////////////////////////////////////////////////////////////////FIN CODIGO IR A LA PREGUNTA DE LA VISTA RULES.ESTUDIANTE.RESPONSE///////////////////////////////////////



        //////////////////////////////////////////////ACTUALIZACION

        //////////////////////////////////////////////////////CONTROLAR QUE UN USUARIO NO PUEDA INGRESAR A UNA QUESTION DE UN EXAMEN QUE NO HA SIDO ASIGNADO A ESE USUARIO

        //ID DEL USUARIO ACTUAL LOGEADO
        $authUser= auth()->user()->id;
        
        //EN LA VARIABLE EVALUACIONES ASIGNADAS SE GUARDA UN ARRAY QUE CONTIENE LOS CAMPOS EVALUATION_ID DE LA TABLA EVALUATION_USER QUE SON
        //LOS EXAMNES ASIGNADOS AL USUARIO ACTUAL LOGEADO
        $evaluacionesAsignadas = DB::table('evaluation_user')->where('user_id', $authUser)->pluck('evaluation_id')->toArray();

        //CON UN IF SE PREGUNTA SI EL ID DE LA EVALUACION ACTUAL DE LA PREGUNTA A LA QUE EL ESTUDIANTE ESTA TRATANDO DE INGRESAR ESTA DENTRO
        //DEL ARRAY DEE EVALUACIONES ASIGNADAS AL ESTUDIANTE ACTUAL LOGEADO
        //SI ESTA DENTRO DE LAS EVALUACIONES ASIGNADAS ENTONCES QUE MUESTRE LA PREGUNTA A LA QUE ESTABA INTENTANDO INGRESAR
        //PERO SI NO ESTA ASIGNADA ESA EVALUACION QUE LO ENVIE A LA PAGINA PRINCIPAL CON UN MENSAJE
        
        if(in_array($evaluacionId, $evaluacionesAsignadas)){
            //SI TIENE EL EXAMEN ASIGNADO ENTONCES QUE MUESTRE LA PREGUNTA A LA QUE ESTABA INTENTANDO ACCEDER
            //AQUI SE DESPRENDEN DOS CASOS MAS:
            //1. SI AUN NO HA RESPONDIDO, SE MUESTRA LA PREGUNTA PARA QUE RESPONDA
            //2. SI YA HA RESPONDIDO NO PUEDE INGRESAR DE NUEVO A LA PREGUNTA


            ////////////////////////////////////////////////////////////////////////////////////NUEVO CODIGO PARA IR A UNA VISTA DIFERENTE SEGUN EL TIPO DE PREGUNTA//////////////////////////////////////////////////

            //OBTENER LA PREGUNTA ACTUAL A LA QUE EL USUARIO TRATA DE INGRESAR A RESPONDER
            $question = Question::find($questionId);

            //BUSCAR EN LA TABLA EVALUATION LA EVALUACION ACTUAL QUE ESTA RESPONDIENDO
            //ACTUALIZACION SE ENVIA ESTA VARIABLE A LA VISTA PARA UTILIZARLA EN EL BOTON DE REGRESAR DE LA VENTANA DE RESPONDER UNA PREGUNTA ESPECIFICA
            //AL LISTADO DE PREGUNTAS ASIGNADAS
            $evaluation = Evaluation::find($evaluacionId); 


            //CAPTURAR EL ID DEL USUARIO ACTUAL LOGEADO
            //$authUser = auth()->user()->id;


            //EN LA VARIABLE ASSIGNEDQUESTIONSID SE VA  A TOMAR SOLO LOS IDS DEL USUARIO ACTUAL Y TODAS LAS QUESTIONS DE LA EVALUACION ACTUAL
            //QUE EL ESTUDIANTE ACTUAL LOGEADO QUIERE RESOLVER
            //PRIMERO SE CAPTURA EL EXAMEN ACTUAL QUE EL USUARIO QUIERE RESOLVER
            $evaluacionActual = Evaluation::find($evaluacionId);
            //YA TENIENDO EL EXAMEN VAMOS A BUSCAR EN LA TABLA QUESTIONS, TODAS LAS QUESTIONS DE ESE EXAMEN ESPECIFICO
            //DE ESA COLECCION DE QUESTIONS, SOLO SE VA A SACAR LOS IDS DE LAS QUESTIONS Y SE LOS ALMACENA EN UN ARRAY
            $questionsActuales = Question::where('evaluation_id', $evaluacionActual->id)->pluck('id')->toArray();

            //EN LA VARIABLE WASQUESTIONCOMPLETED SE CONSULTA EN LA TABLA RESULTS LOS REGISTROS CUYO CAMPO USER_ID COINCIDAN CON EL ID DEL USUARIO ACTUAL
            //Y A ESOS REGISTROS QUE COINCIDAN, CON EL METODO WHEREIN() SE VA COMPROBANDO SI EL CAMPO QUESTION_ID DE ESOS REGISTROS COINCIDE CON LOS IDS
            //DE LAS PREGUNTAS QUE EL USUARIO YA RESPONDIO (POR ESO SE CREA UNA INSTANCIA  DEL MODELO QUESTION Y SE INVOCA AL METODO HASQUESTIONATTEMPTED PARA COMPROBARLOS)
            //Y CUANDO ENCUENTRE ESOS REGISTROS QUE COINCIDEN, ENTONCES CON EL METODO PLUCK() SOLO VA A SACAR EL CAMPO QUESTION_ID DE ESOS REGISTROS
            //Y LOS VA A ALMACENAR EN EL ARRAY WASQUESTIONCOMPLETED
            $wasQuestionCompleted = Result::where('user_id', $authUser)->whereIn('question_id', (new Question)->hasQuestionAttempted())->pluck('question_id')->toArray();

            //EN LA VARIABLE QUESTIONWASCOMPLETED SE VA A COMPROBAR SI EN LA TABLA RESULTS YA EXISTE UN REGISTRO DONDE TENGA EL ID DEL USUARIO ACTUAL
            //EL ID DE LA EVALUACION ACTUAL Y EL ID DE LA QUESTION ACTUAL
            $questionWasCompleted = Result::where('user_id', $authUser)->where('evaluation_id', $evaluacionId)->where('question_id', $questionId)->exists();

            //CON EL IF SE PREGUNTA SI EXISTE ESE REGISTRO DE LA PREGUNTA A LA QUE TRATA DE INGRESAR EN LA TABLA RESULTS, LO QUE SIGNIFICA QUE YA RESPONDIO ESA PREGUNTA
            //SI ES ASI, ENTONCES QUE NO LO DEJE ENTRAR DE NUEVO A LA PREGUNTA
            if($questionWasCompleted){
                return redirect()->route('estudiante.preguntasevaluacion', $evaluation)->with('message', 'Ya has respondido la pregunta.'); 
            }
            else{

                //    return view('rules.estudiante.response', compact('question'));
                //SI EL USUARIO AUN NO RESPONDE LA PREGUNTA, ENTONCES QUE LO ENVIE A LA VISTA RESPONSE SEGUN EL TIPO DE PREGUNTA QUE SEA
                //return $question; 
                if($question->type === "OM"){
                    return view('rules.estudiante.responsequestions.responseom', compact('question', 'evaluation'));
                }
                elseif($question->type === "OMI"){
                    return view('rules.estudiante.responsequestions.responseomi', compact('question', 'evaluation')); 
                }
                elseif($question->type === "OMA"){
                    return view('rules.estudiante.responsequestions.responseoma', compact('question', 'evaluation')); 
                }
                elseif($question->type === "PC"){

                    //ACTUALIZACION
                    //DEL BANCO DE OPCIONES DE RESPUESTA DE 15 PALABRAS, SE ENVIAN 5 ALEATORIAS
                    
                    //CAPTURAR 5 PALABRAS ALEATORIAS PARA QUE EL USUARIO RESPONDA
                    $optionsr = $question->answers->random(5);
                    //return $optionsr;
                    return view('rules.estudiante.responsequestions.responsepc', compact('question', 'evaluation', 'optionsr')); 
                }
                elseif($question->type === "OA"){
                    return view('rules.estudiante.responsequestions.responseoa', compact('question', 'evaluation')); 
                }
                elseif($question->type === "OI"){
                    return view('rules.estudiante.responsequestions.responseoi', compact('question', 'evaluation')); 
                }
                elseif($question->type === "TI"){
                    return view('rules.estudiante.responsequestions.responseti', compact('question', 'evaluation')); 
                }
                elseif($question->type === "TA"){
                    return view('rules.estudiante.responsequestions.responseta', compact('question', 'evaluation')); 
                }
                elseif($question->type === "JA"){
                    return view('rules.estudiante.responsequestions.responseja', compact('question', 'evaluation')); 
                }
                elseif($question->type === "SL"){

                    //ACTUALIZACION
                    //DEL BANCO DE OPCIONES DE RESPUESTA DE 30 PALABRAS, SE ENVIAN 10 ALEATORIAS

                    //CAPTURAR 10 PALABRAS ALEATORIAS PARA QUE EL USUARIO ENCUENTRE EN LA SOPA DE LETRAS
                    $optionsopaletras = $question->answers->random(10);
                    return view('rules.estudiante.responsequestions.responsesl', compact('question', 'evaluation', 'optionsopaletras')); 
                }
                
            }

            ///////////////////////////////////////////////////////////////////////////////////////FIN DE CODIGO PARA IR A UNA VISTA DIFERENTE SEGUN EL TIPO DE PREGUNTA/////////////////////////////////////////////
        }
        else{
            
            //SI NO TIENE EL EXAMEN ASIGNADO ENTONCES NO PUEDE INGRESAR A LA PREGUNTA Y LO ENVIA A LA PAGINA DE INICIO CON UN MENSAJE
            return redirect()->route('estudiante.letterslevelone')->with('message', 'No tienes asignada esa pregunta');

        }
        

        
    }



    

    //METODO PARA GUARDAR LA RESPUESTA DEL USUARIO DE LA QUESTION OPCION MULTIPLE
    public function storeResponseOM(Request $request){
        
        
        //CAPTURAR LA RESPUESTA DEL USUARIO
        $respuestaUsuario = $request->answer_user;

        //CAPTURAR EL ID DEL USUARIO ACTUAL LOGEADO
        $userId = auth()->user()->id;

        //CAPTURAR LA QUESTION ID DE LA PREGUNTA QUE SE VA A RESPONDER
        $questionId = $request->question_id;

        //CAPTURAR EL EVALUATION_ID ACTUAL DEL EXAMEN QUE ESTA RESPONDIENDO
        $questionComplete = Question::find($questionId);
        //$evaluation = Evaluation::where('id', $questionComplete->evaluation_id)->get();
        $evaluation = Evaluation::find($questionComplete->evaluation_id);

        //CAPTURAR LA RESPUESTA CORRECTA QUE VIENE DESDE LA TABLA ANSWERS DONDE SU CAMPO IS_CORRECT ES TRUE
        $respuestaCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->value('answer');

        //VARIABLE PARA ALMACENAR LA RESPUESTA
        $respuesta = '';
        //VARIABLE PARA GUARDAR EL PUNTAJE
        $puntaje = 0;

        //COMPARAR SI COINCIDE LA RESPUESTA DEL USUARIO CON LA RESPUESTA CORRECTA 
        $comparacion = strcmp($respuestaCorrecta, $respuestaUsuario);

        //CON EL IF SE PREGUNTA SI LA RESPUESTA DEL USUARIO COINCIDE CON LA RESPUESTA CORRECTA
        if($comparacion === 0){
            $respuesta = 'Ha elegido la respuesta correcta';
            $puntaje = 1;
        }
        else{
            $respuesta = 'Ha elegido la respuesta incorrecta';
            $puntaje = 0;
        }

        //CAPTURAR EL ID DE LA RESPUESTA CORRECTA DE LA TABLA ANSWERS YA QUE ES OPCION MULTIPLE
        $correctAnswer = Answer::where('question_id', $questionId)->where('is_correct', true)->value('id');

        
        //CREAR REGISTRO DE RESPUESTA DEL USUARIO
        Result::create([
            'answer_user' => $request->answer_user,
            'score' => $puntaje,
            'user_id' => $userId,
            'question_id' => $questionId,
            //ENVIAR EL ID DE LA RESPUESTA CORRECTA DE LA TABLA ANSWERS RELACIONADA CON LA PREGUNTA ACTUAL
            'answer_id' => $correctAnswer,
            'evaluation_id' => $evaluation->id,
        ]);

        return redirect()->route('estudiante.preguntasevaluacion', $evaluation)->with('message', 'Pregunta respondida.');
    }


    //METODO PARA GUARDAR LA RESPUESTA DEL USUARIO DE LA QUESTION PALABRA CORRECCION
    public function storeResponsePC (Request $request){

        //return $request;
        
        //CAPTURAR LAS RESPUESTAS DEL USUARIO Y GUARDARLAS EN UN ARRAY
        //CON TRIM SE QUITAN LOS ESPACIOS EN BLANCO DEL INICIO Y FINAL DE LA RESPUESTA DEL USUARIO PARA CALIFICARLA 
        $respuestasUsuario = [];
        foreach($request['fanswers'] as $fanswer){
            array_push($respuestasUsuario, trim($fanswer));
        }

        //return $request->opcionesfinales;

        //CAPTURAR LA VARIABLE OPCIONESFINALES QUE CONTIENE LA COLECCION DE PALABRAS ALEATORIAS CORRECTAS QUE EL USUARIO DEBIA CORREJIR CORRECTAMENTE
        $respuestasOpcionesFinalesCorrectas = [];
        foreach($request['opcionesfinales'] as $opcioncorrecta){
            array_push($respuestasOpcionesFinalesCorrectas, $opcioncorrecta);
        }

        //return $respuestasUsuario;

        //CAPTURAR LA VARIABLE NUMFINALES QUE CONTIENE LOS IDS DE LAS PALABRAS ALEATORIAS CORRECTAS QUE EL USUARIO DEBIA CORREGIR CORRECTAMENTE
        $idOpcionesFinalesCorrectas = [];
        foreach($request['numfinales'] as $idcorrecta){
            array_push($idOpcionesFinalesCorrectas, $idcorrecta);
        }
        
        //return $idOpcionesFinalesCorrectas;

        //CAPTURAR EL ID DEL USUARIO ACTUAL LOGEADO
        $userId = auth()->user()->id;

        //CAPTURAR LA QUESTION ID DE LA PREGUNTA QUE SE VA A RESPONDER
        $questionId = $request->question_id;

        //CAPTURAR LA EVALUATION A LA QUE PERTENECE LA PREGUNTA QUE ESTA RESPONDIENDO
        $questionComplete = Question::find($questionId);
        $evaluation = Evaluation::find($questionComplete->evaluation_id);

        //CAPTURAR EN UN ARRAY LAS RESPUESTAS CORRECTAS QUE VIENEN DESDE LA TABLA ANSWERS
        $respuestasCorrectas = DB::table('answers')->where('question_id', $questionId)->where('is_correct', true)->pluck('answer')->toArray();

        //VARIABLE PARA ALMACENAR LA RESPUESTA
        $respuesta = '';
        //VARIABLE PARA ALMACENAR EL PUNTAJE
        $puntaje = 0;

        //RECORRER EL ARRAY DE RESPUESTAS CORRECTAS Y EL ARRAY DE RESPUESTAS DE USUARIO
        //Y COMPARAR SI LA RESPUESTA DEL USUARIO EN X POSICION COINCIDE CON LA RESPUESTA CORRECTA EN LA MISMA POSICION
        //Y CAPTURAR EL NUMERO DE ELEMENTOS DE CADA ARRAY
        $respuestasIncorrectas = [];
        $respuestasAcertadas = [];
        $puntajesarray = [];
        $answers_count = count($respuestasCorrectas);
        $answersU_count = count($respuestasUsuario);
        for($i=0; $i<$answersU_count; $i++){
            //ACTUALIZACION
            //EN LA $COMPARACION YA NO SE COMPARA CON LA VARIABLE $RESPUESTASCORRECTAS, SINO CON LA VARIABLE $RESPUESTASOPCIONESFINALESCORRECTAS
            //YA QUE ESA VARIABLE CONTIENE LAS PALABRAS CORRECTAS EN LA MISMA POSICION QUE EL ARRAY QUE CONTIENE LAS RESPUESTAS DEL USUARIO
            //$comparacion = strcmp($respuestasCorrectas[$i], $respuestasUsuario[$i]);
            
            $comparacion = strcmp($respuestasOpcionesFinalesCorrectas[$i], $respuestasUsuario[$i]);
            if($comparacion === 0){
                $puntaje = 0.20;
                array_push($respuestasAcertadas, $respuestasUsuario[$i]);
            }
            else{
                $puntaje = 0;
                array_push($respuestasIncorrectas, $respuestasUsuario[$i]);
            }
            array_push($puntajesarray, $puntaje);
        }

        //CAPTURAR EN UN ARRAY SOLO LOS IDS DE LAS RESPUESTAS CORRECTAS QUE VIENEN DE LA TABLA ANSWERS
        //$correctAnswer = DB::table('answers')->where('question_id', $questionId)->where('is_correct', true)->pluck('id')->toArray();

        //return $correctAnswer;

        //CREAR LOS REGISTROS DE RESPUESTA DE CADA PALABRA 
        for($j=0; $j<$answersU_count; $j++){
            Result::create([
                'answer_user' => $respuestasUsuario[$j],
                'score' => $puntajesarray[$j],
                'user_id' => $userId,
                'question_id' => $questionId,
                //ENVIAR EL ID DE LA RESPUESTA CORRECTA DE LA PREGUNTA ACTUAL
                //'answer_id' => $correctAnswer[$j],
                'answer_id' => $idOpcionesFinalesCorrectas[$j],
                'evaluation_id' =>$evaluation->id
            ]);
        }

        return redirect()->route('estudiante.preguntasevaluacion', $evaluation)->with('message', 'Pregunta respondida');


    }


    //METODO PARA GUARDAR LA RESPUESTA DEL USUARIO DE LA QUESTION OPCION MULTIPLE
    public function storeResponseOMI(Request $request){

       
        //CAPTURAR LA RESPUESTA DEL USUARIO
        $respuestaUsuario = $request->answer_user;

        //CAPTURAR EL ID DEL USUARIO ACTUAL LOGEADO
        $userId = auth()->user()->id;

        //CAPTURAR LA QUESTION ID DE LA PREGUNTA QUE SE VA A RESPONDER
        $questionId = $request->question_id;

        //CAPTURAR EL EVALUATION_ID ACTUAL DEL EXAMEN QUE ESTA RESPONDIENDO
        $questionComplete = Question::find($questionId);
        //$evaluation = Evaluation::where('id', $questionComplete->evaluation_id)->get();
        $evaluation = Evaluation::find($questionComplete->evaluation_id);

        //CAPTURAR LA RESPUESTA CORRECTA QUE VIENE DESDE LA TABLA ANSWERS DONDE SU CAMPO IS_CORRECT ES TRUE
        $respuestaCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->value('answer');

        //VARIABLE PARA ALMACENAR LA RESPUESTA
        $respuesta = '';
        //VARIABLE PARA GUARDAR EL PUNTAJE
        $puntaje = 0;

        //COMPARAR SI COINCIDE LA RESPUESTA DEL USUARIO CON LA RESPUESTA CORRECTA 
        $comparacion = strcmp($respuestaCorrecta, $respuestaUsuario);

        //CON EL IF SE PREGUNTA SI LA RESPUESTA DEL USUARIO COINCIDE CON LA RESPUESTA CORRECTA
        if($comparacion === 0){
            $respuesta = 'Ha elegido la respuesta correcta';
            $puntaje = 1;
        }
        else{
            $respuesta = 'Ha elegido la respuesta incorrecta';
            $puntaje = 0;
        }

        //CAPTURAR EL ID DE LA RESPUESTA CORRECTA DE LA TABLA ANSWERS YA QUE ES OPCION MULTIPLE
        $correctAnswer = Answer::where('question_id', $questionId)->where('is_correct', true)->value('id');

        
        //CREAR REGISTRO DE RESPUESTA DEL USUARIO
        Result::create([
            'answer_user' => $request->answer_user,
            'score' => $puntaje,
            'user_id' => $userId,
            'question_id' => $questionId,
            //ENVIAR EL ID DE LA RESPUESTA CORRECTA DE LA TABLA ANSWERS RELACIONADA CON LA PREGUNTA ACTUAL
            'answer_id' => $correctAnswer,
            'evaluation_id' => $evaluation->id,
        ]);

        return redirect()->route('estudiante.preguntasevaluacion', $evaluation)->with('message', 'Pregunta respondida.');
    }


    //METODO PARA GUARDAR LA RESPUESTA DEL USUARIO DE LA QUESTION OPCION MULTIPLE
    public function storeResponseOMA(Request $request){

        
        //CAPTURAR LA RESPUESTA DEL USUARIO
        $respuestaUsuario = $request->answer_user;

        //CAPTURAR EL ID DEL USUARIO ACTUAL LOGEADO
        $userId = auth()->user()->id;

        //CAPTURAR LA QUESTION ID DE LA PREGUNTA QUE SE VA A RESPONDER
        $questionId = $request->question_id;

        //CAPTURAR EL EVALUATION_ID ACTUAL DEL EXAMEN QUE ESTA RESPONDIENDO
        $questionComplete = Question::find($questionId);
        //$evaluation = Evaluation::where('id', $questionComplete->evaluation_id)->get();
        $evaluation = Evaluation::find($questionComplete->evaluation_id);

        //CAPTURAR LA RESPUESTA CORRECTA QUE VIENE DESDE LA TABLA ANSWERS DONDE SU CAMPO IS_CORRECT ES TRUE
        $respuestaCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->value('answer');

        //VARIABLE PARA ALMACENAR LA RESPUESTA
        $respuesta = '';
        //VARIABLE PARA GUARDAR EL PUNTAJE
        $puntaje = 0;

        //COMPARAR SI COINCIDE LA RESPUESTA DEL USUARIO CON LA RESPUESTA CORRECTA 
        $comparacion = strcmp($respuestaCorrecta, $respuestaUsuario);

        //CON EL IF SE PREGUNTA SI LA RESPUESTA DEL USUARIO COINCIDE CON LA RESPUESTA CORRECTA
        if($comparacion === 0){
            $respuesta = 'Ha elegido la respuesta correcta';
            $puntaje = 1;
        }
        else{
            $respuesta = 'Ha elegido la respuesta incorrecta';
            $puntaje = 0;
        }

        //CAPTURAR EL ID DE LA RESPUESTA CORRECTA DE LA TABLA ANSWERS YA QUE ES OPCION MULTIPLE
        $correctAnswer = Answer::where('question_id', $questionId)->where('is_correct', true)->value('id');

        
        //CREAR REGISTRO DE RESPUESTA DEL USUARIO
        Result::create([
            'answer_user' => $request->answer_user,
            'score' => $puntaje,
            'user_id' => $userId,
            'question_id' => $questionId,
            //ENVIAR EL ID DE LA RESPUESTA CORRECTA DE LA TABLA ANSWERS RELACIONADA CON LA PREGUNTA ACTUAL
            'answer_id' => $correctAnswer,
            'evaluation_id' => $evaluation->id,
        ]);

        return redirect()->route('estudiante.preguntasevaluacion', $evaluation)->with('message', 'Pregunta respondida.');

    }


    //METODO PARA GUARDAR LAS RESPUESTAS DEL USUARIO DE LA QUESTION ORACION AUDIO
    public function storeResponseOA (Request $request){

    

        //CAPTURAR LAS RESPUESTAS DEL USUARIO Y GUARDARLAS EN UN ARRAY
        //CON TRIM SE QUITAN LOS ESPACIOS EN BLANCO DEL INICIO Y FINAL DE LA RESPUESTA DEL USUARIO PARA CALIFICARLA 
        $respuestasUsuario = [];
        foreach($request['fanswers'] as $fanswer){
            array_push($respuestasUsuario, trim($fanswer));
        }

        //CAPTURAR EL ID DEL USUARIO ACTUAL LOGEADO 
        $userId = auth()->user()->id;

        //CAPTURAR LA QUESTION ID DE LA PREGUNTA QUE SE VA A RESPONDER
        $questionId = $request->question_id;

        //CAPTURAR LA EVALUATION A LA QUE PERTENECE LA PREGUNTA QUE ESTA RESPONDIENDO
        $questionComplete = Question::find($questionId);
        $evaluation = Evaluation::find($questionComplete->evaluation_id);

        //CAPTURAR EN UN ARRAY LAS RESPUESTAS CORRECTAS QUE VIENN DESDE LA TABLA ANSWERS
        $respuestasCorrectas = DB::table('answers')->where('question_id', $questionId)->where('is_correct', true)->pluck('answer')->toArray();

        //VARIABLE PARA ALMACENAR LA RESPUESTA
        $respuesta = '';
        //VARIABLA PARA ALMACENAR EL PUNTAJE
        $puntaje = 0;

        //RECORRER EL ARRAY DE RESPUESTAS CORRECTAS Y EL ARRAY DE RESPUESTAS DE USUARIO
        //Y COMPARAR SI LA RESPUESTA DEL USUARIO EN X POSICION COINCIDE CON LA RESPUESTA CORRECTA EN LA MISMA POSICION
        //Y CAPTURAR EL NUMERO DE ELEMENTOS DE CADA ARRAY
        $respuestasIncorrectas = [];
        $respuestasAcertadas = [];
        $puntajesarray = [];
        $answers_count = count($respuestasCorrectas);
        $answersU_count = count($respuestasUsuario);
        for($i=0; $i<$answersU_count; $i++){
            $comparacion = strcmp($respuestasCorrectas[$i], $respuestasUsuario[$i]);
            if($comparacion == 0){
                $puntaje = 0.20;
                array_push($respuestasAcertadas, $respuestasUsuario[$i]);
            }
            else{
                $puntaje = 0;
                array_push($respuestasIncorrectas, $respuestasUsuario[$i]);
            }
            array_push($puntajesarray, $puntaje);
        }


        //CAPTURAR EN UN ARRAY SOLO LOS IDS DE LAS RESPUESTAS CORRECTAS QUE VIENEN DE LA TABLA ANSWERS
        $correctAnswer = DB::table('answers')->where('question_id', $questionId)->where('is_correct', true)->pluck('id')->toArray();

        //CREAR LOS REGISTROS DE RESPUESTA DE CADA PALABRA
        for($j=0; $j<$answersU_count; $j++){
            Result::create([
                'answer_user' => $respuestasUsuario[$j],
                'score' => $puntajesarray[$j],
                'user_id' => $userId,
                'question_id' => $questionId,
                //ENVIAR EEL ID DE LA RESPUESTA CORRECTA DE LA PREGUNTA ACTUAL
                'answer_id' => $correctAnswer[$j],
                'evaluation_id' => $evaluation->id

            ]);
        }

        return redirect()->route('estudiante.preguntasevaluacion', $evaluation)->with('message', 'Pregunta respondida.');

    }


    //METODO PARA GUARDAR LAS RESPUESTAS DEL USUARIO DE LA QUESTION ORACION IMAGEN
    public function storeResponseOI (Request $request){

        
        //CAPTURAR LAS RESPUESTAS DEL USUARIO Y GUARDARLAS EN UN ARRAY
        //CON TRIM SE QUITAN LOS ESPACIOS EN BLANCO DEL INICIO Y FINAL DE LA RESPUESTA DEL USUARIO PARA CALIFICARLA 
        $respuestasUsuario = [];
        foreach($request['fanswers'] as $fanswer){
            array_push($respuestasUsuario, trim($fanswer));
        }

        //CAPTURAR EL ID DEL USUARIO ACTUAL LOGEADO 
        $userId = auth()->user()->id;

        //CAPTURAR LA QUESTION ID DE LA PREGUNTA QUE SE VA A RESPONDER
        $questionId = $request->question_id;

        //CAPTURAR LA EVALUATION A LA QUE PERTENECE LA PREGUNTA QUE ESTA RESPONDIENDO
        $questionComplete = Question::find($questionId);
        $evaluation = Evaluation::find($questionComplete->evaluation_id);

        //CAPTURAR EN UN ARRAY LAS RESPUESTAS CORRECTAS QUE VIENN DESDE LA TABLA ANSWERS
        $respuestasCorrectas = DB::table('answers')->where('question_id', $questionId)->where('is_correct', true)->pluck('answer')->toArray();

        //VARIABLE PARA ALMACENAR LA RESPUESTA
        $respuesta = '';
        //VARIABLA PARA ALMACENAR EL PUNTAJE
        $puntaje = 0;

        //RECORRER EL ARRAY DE RESPUESTAS CORRECTAS Y EL ARRAY DE RESPUESTAS DE USUARIO
        //Y COMPARAR SI LA RESPUESTA DEL USUARIO EN X POSICION COINCIDE CON LA RESPUESTA CORRECTA EN LA MISMA POSICION
        //Y CAPTURAR EL NUMERO DE ELEMENTOS DE CADA ARRAY
        $respuestasIncorrectas = [];
        $respuestasAcertadas = [];
        $puntajesarray = [];
        $answers_count = count($respuestasCorrectas);
        $answersU_count = count($respuestasUsuario);
        for($i=0; $i<$answersU_count; $i++){
            $comparacion = strcmp($respuestasCorrectas[$i], $respuestasUsuario[$i]);
            if($comparacion == 0){
                $puntaje = 0.20;
                array_push($respuestasAcertadas, $respuestasUsuario[$i]);
            }
            else{
                $puntaje = 0;
                array_push($respuestasIncorrectas, $respuestasUsuario[$i]);
            }
            array_push($puntajesarray, $puntaje);
        }


        //CAPTURAR EN UN ARRAY SOLO LOS IDS DE LAS RESPUESTAS CORRECTAS QUE VIENEN DE LA TABLA ANSWERS
        $correctAnswer = DB::table('answers')->where('question_id', $questionId)->where('is_correct', true)->pluck('id')->toArray();

        //CREAR LOS REGISTROS DE RESPUESTA DE CADA PALABRA
        for($j=0; $j<$answersU_count; $j++){
            Result::create([
                'answer_user' => $respuestasUsuario[$j],
                'score' => $puntajesarray[$j],
                'user_id' => $userId,
                'question_id' => $questionId,
                //ENVIAR EEL ID DE LA RESPUESTA CORRECTA DE LA PREGUNTA ACTUAL
                'answer_id' => $correctAnswer[$j],
                'evaluation_id' => $evaluation->id

            ]);
        }

        return redirect()->route('estudiante.preguntasevaluacion', $evaluation)->with('message', 'Pregunta respondida');

    }


    //METODO PARA GUARDAR LA RESPUESTA DEL USUARIO DE LA QUESTION TEXTO IMAGEN
    public function storeResponseTI(Request $request){

        
        //CAPTURAR LA RESPUESTA DEL USUARIO  
        //CON TRIM SE QUITAN LOS ESPACIOS EN BLANCO DEL INICIO Y FINAL DE LA RESPUESTA DEL USUARIO PARA CALIFICARLA 
        $respuestaUsuario = trim($request->answer_user);

        //CAPTURAR EL ID DEL USUARIO ACTUAL LOGEADO
        $userId = auth()->user()->id;

        //CAPTURAR LA QUESTION ID DE LA PREGUNTA QUE SE VA A RESPONDER
        $questionId = $request->question_id;

        //CAPTURAR EL EVALUATION ID ACTUAL DEL EXAMEN QUE ESTA RESPONDIENDO
        $questionComplete = Question::find($questionId);
        $evaluation = Evaluation::find($questionComplete->evaluation_id);

        //CAPTURAR LA RESPUEESTA CORRECTA QUE VIENE DESDE LA TABLA ANSWERS DONDE SU CAMPO IS_CORRECT ES TRUE
        $respuestaCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->value('answer');

        //VARIABLE PARA ALMACENAR LA RESPUESTA
        $respuesta = '';
        //VARIABLE PARA GUARDAR EL PUNTAJE
        $puntaje = 0;

        //COMPARAR SI COINCIDE LA RESPUESTA DEL USUARIO CON LA RESPUESTA CORRECTA
        $comparacion = strcmp($respuestaCorrecta, $respuestaUsuario);

        //CON EL IF SE PREGUNTA SI LA RESPUESTA DEL USUARIO COINCIDE CON LA RESPUESTA CORRECTA
        if($comparacion === 0){
            $respuesta = 'El parrafo ingresado por el estudiante es correcto';
            $puntaje = 1;
        }else{
            $respuesta = 'El parrafo ingresado por el estudiante es incorrecto';
            $puntaje = 0;
        }


        //CAPTURAR EL ID DE LA RESPUESTA CORRECTA DE LA TABLA ANSWERS
        $correctAnswer = Answer::where('question_id', $questionId)->where('is_correct', true)->value('id');


        //CREAR EL REGISTRO DE RESPUESTA DEL USUARIO
        Result::create([
            'answer_user' => $request->answer_user,
            'score' => $puntaje,
            'user_id' => $userId,
            'question_id' => $questionId,
            //ENVIAR EL ID DE LA RESPUESTA CORRECTA DE LA TABLA ANSWERS RELACIONADA CON LA PREGUNTA ACTUAL
            'answer_id' => $correctAnswer,
            'evaluation_id' => $evaluation->id,
        ]);

        return redirect()->route('estudiante.preguntasevaluacion', $evaluation)->with('message', 'Pregunta respondida.');
        
    }



    //METODO PARA GUARDAR LA RESPUESTA DEL USUARIO DE LA QUESTION TEXTO AUDIO
    public function storeResponseTA(Request $request){

        //CAPTURAR LA RESPUESTA DEL USUARIO
        //CON TRIM SE QUITAN LOS ESPACIOS EN BLANCO DEL INICIO Y FINAL DE LA RESPUESTA DEL USUARIO PARA CALIFICARLA   
        $respuestaUsuario = trim($request->answer_user);

        //CAPTURAR EL ID DEL USUARIO ACTUAL LOGEADO
        $userId = auth()->user()->id;

        //CAPTURAR LA QUESTION ID DE LA PREGUNTA QUE SE VA A RESPONDER
        $questionId = $request->question_id;

        //CAPTURAR EL EVALUATION ID ACTUAL DEL EXAMEN QUE ESTA RESPONDIENDO
        $questionComplete = Question::find($questionId);
        $evaluation = Evaluation::find($questionComplete->evaluation_id);

        //CAPTURAR LA RESPUEESTA CORRECTA QUE VIENE DESDE LA TABLA ANSWERS DONDE SU CAMPO IS_CORRECT ES TRUE
        $respuestaCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->value('answer');

        //VARIABLE PARA ALMACENAR LA RESPUESTA
        $respuesta = '';
        //VARIABLE PARA GUARDAR EL PUNTAJE
        $puntaje = 0;

        //COMPARAR SI COINCIDE LA RESPUESTA DEL USUARIO CON LA RESPUESTA CORRECTA
        $comparacion = strcmp($respuestaCorrecta, $respuestaUsuario);

        //CON EL IF SE PREGUNTA SI LA RESPUESTA DEL USUARIO COINCIDE CON LA RESPUESTA CORRECTA
        if($comparacion === 0){
            $respuesta = 'El parrafo ingresado por el estudiante es correcto';
            $puntaje = 1;
        }else{
            $respuesta = 'El parrafo ingresado por el estudiante es incorrecto';
            $puntaje = 0;
        }


        //CAPTURAR EL ID DE LA RESPUESTA CORRECTA DE LA TABLA ANSWERS
        $correctAnswer = Answer::where('question_id', $questionId)->where('is_correct', true)->value('id');


        //CREAR EL REGISTRO DE RESPUESTA DEL USUARIO
        Result::create([
            'answer_user' => $request->answer_user,
            'score' => $puntaje,
            'user_id' => $userId,
            'question_id' => $questionId,
            //ENVIAR EL ID DE LA RESPUESTA CORRECTA DE LA TABLA ANSWERS RELACIONADA CON LA PREGUNTA ACTUAL
            'answer_id' => $correctAnswer,
            'evaluation_id' => $evaluation->id,
        ]);

        return redirect()->route('estudiante.preguntasevaluacion', $evaluation)->with('message', 'Pregunta respondida.');
    }

    //METODO PARA GUARDAR LA RESPUESTA DEL USUARIO DE LA QUESTION JUEGO
    public function storeResponseJA (Request $request){
        
    
        //CAPTURAR LA RESPUESTA DEL USUARIO PUEDE SER CORRECTO SI ADIVINO LA PALABRA
        //O INCORRECTO SI NO ADIVINO LA PALABRA
        $respuestaUsuario = $request->answer_user;

        //CAPTURAR EL ID DEL USUARIO ACTUAL LOGEADO
        $userId = auth()->user()->id;

        //CAPTURAR LA QUESTION ID DE LA PREGUNTA QUE SE VA A RESPONDER
        $questionId = $request->question_id;

        //CAPTURAR EL EVALUATION ID ACTUAL DEL EXAMEN QUE ESTA RESPONDIENDO
        $questionComplete = Question::find($questionId);
        $evaluation = Evaluation::find($questionComplete->evaluation_id);

        //CAPTURAR LA RESPUESTA CORRECTA QUE VIENE DESDE LA TABLA ANSWERS DONDE SU CAMPO IS_CORRECT ES TRUE
        $respuestaCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->value('answer');

        //VARIABLE PARA ALMACENAR LA RESPUESTA
        $respuesta = '';
        //VARIABLE PARA GUARDAR EL PUNTAJE
        $puntaje = 0;

        //COMPARAR SI COINCIDE LA RESPUESTA DEL USUARIO CON LA RESPUESTA CORRECTA
        $comparacion = strcmp($respuestaCorrecta, $respuestaUsuario);



        //CON EL IF SE PREGUNTA SI LA RESPUESTAUSUARIO ES CORRECTA O INCORRECTA
        if($comparacion === 0){
            $respuesta = 'La respuesta es correcta';
            $puntaje = 1;
        }
        else{
            $respuesta = 'La respuesta es incorrecta';
            $puntaje = 0;
        }

        //CAPTURAR EL ID DE LA RESPUESTA CORRECTA DE LA TABLA ANSWERS
        $correctAnswer = Answer::where('question_id', $questionId)->where('is_correct', true)->value('id');

        //CREAR EL REGISTRO DE RESPUESTA DEL USUARIO
        Result::create([
            'answer_user' => $request->answer_user,
            'score' => $puntaje,
            'user_id' => $userId,
            'question_id' => $questionId,
            //ENVIAR EL ID DE LA RESPUESTA CORRECTA DE LA TABLA ANSWERS RELACIONADA CON LA PREGUNTA ACTUAL
            'answer_id' => $correctAnswer,
            'evaluation_id' => $evaluation->id
        ]);

        return redirect()->route('estudiante.preguntasevaluacion', $evaluation)->with('message', 'Pregunta respondida');
    }



    //METODO PARA GUARDAR LA RESPUESTA DEL USUARIO DE LA QUESTION SOPA LETRAS
    public function storeResponseSL(Request $request){
        //return $request;

        //CUANDO SE GUARDA LA SOPA DE LETRAS EL REQUEST VIENE CON LOS SIGUIENTES DATOS
        //ANSWER_USER QUE ES "Incorrecto" SI EL USUARIO NO ENCUENTRA TODAS LAS PALABRAS O ES "Correcto" SI EL USUARIO ENCUENTRA TODAS LAS PALABRAS
        //QUESTION_ID QUE CONTIENE EL ID DE LA PREGUNTA QUE SE ESTA RESPONDIENDO
        //TOTALPALABRAS QUE CONTIENE EL NUMERO DE LAS PALABRAS QUE EL USUARIO HA ENCONTRADO
        //PALABRA_ENCONTRADA QUE CONTIENE LAS PALABRAS EN MAYUSCULAS QUE EL USUARIO HA ENCONTRADO
        //NUMEROPALABRASASIGNADAS QUE CONTIENE EL NUMERO DE LAS PALABRAS ASIGNADAS AL USUARIO EN LA SOPA DE LETRAS
        //POR LO QUE SE CAPTURA CADA ELEMENTO

        //SE CAPTURA LAS RESPUESTAS DEL USUARIO QUE VIENEN EN UN STRING LLAMADO PALABRA_ENCONTRADA Y SE GUARDA CADA 
        //PALABRA EN UN ARRAY CONVERTIDAS A MINUSCULAS
        //CREAR UN ARRAY DONDE SE ALMACENARAN LAS PALABRAS ENCONTRADAS POR EL USUARIO EN LA SOPA DE LETRAS
        $respuestasUsuario = [];
        //DIVIDIR EL STRING QUE VIENE DESDE LA VISTA EN PALABRAS Y ALMACENARLAS EN RESPUESTASUSUARIO
        $respuestasUsuario = explode(",", $request->palabra_encontrada);
        //CON UN FOR RECORRER EL ARRAY RESPUESTAS USUARIO E IR HACIENDO MINUSCULAS A CADA PALABRA
        $respuestasUsuarioMin = [];

        for($i=0; $i< count($respuestasUsuario); $i++){
            array_push($respuestasUsuarioMin, strtolower($respuestasUsuario[$i]));
        }

        

        //CAPTURAR EL ID DEL USUARIO ACTUAL LOGEADO
        $userId = auth()->user()->id;

        //CAPTURAR LA QUESTION ID DE LA PREGUNTA QUE SE VA A RESPONDER
        $questionId = $request->question_id;

        //CAPTURAR LA EVALUATION A LA QUE PERTENECE LA PREGUNTA QUE ESTA RESPONDIENDO
        $questionComplete = Question::find($questionId);
        $evaluation = Evaluation::find($questionComplete->evaluation_id);

        //CAPTURAR EN UN ARRAY LAS RESPUESTAS CORRECTAS QUE VIENEN DESDE LA TABLA ANSWERS
        $respuestasCorrectas = DB::table('answers')->where('question_id', $questionId)->where('is_correct', true)->pluck('answer')->toArray();

        //VARIABLE QUE CONTIENE EL PUNTAJE
        //AQUI SE CALCULA CUANTO VALE CADA PALABRA QUE EL USUARIO A ELEGIDO EN BASE AL NUMERO TOTAL DE PALABRAS QUE TENIA EN LA SOPA
        //SE DIVIDE EL 1 QUE EQUIVALE A CUANTO VALE LA PREGUNTA EN GENERAL DIVIDIVO PARA EL NUMERO DE PALABRAS QUE ESTABAN EN LA SOPA DE LETRAS
        $numeroPalabrasAsignadas = $request->numeropalabrasasignadas;
        $puntaje = (1/$numeroPalabrasAsignadas);

        //CAPTURAR EN UN ARRAY SOLO LOS IDS DE LAS RESPUESTAS CORRECTAS QUE VIENEN DE LA TABLA ANSWERS
        //$correctAnswer = DB::table('answers')->where('question_id', $questionId)->where('is_correct', true)->pluck('id')->toArray();


        //AL MOMENTO DE CREAR LOS REGISTROS EN LA TABLA RESULTS ES DIFERENTE EL METODO
        //EN EL CAMPO ANSWER_ID SE COLOCA LA SIGUIENTE CONSULTA, DONDE VA BUSCANDO QUE RESPUESTA DE LA TABLA ANSWERS EN SU CAMPO ANSWER
        //COINCIDE CON LA PALABRA QUE EL USUARIO ENCONTRO EN LA SOPA DE LETRAS, BUSCANDO ES PALABRA EN LA CONSULTA
        //SI LUEGO HAY QUE CAMBIAR Y AGREGAR A LA SOPA NOMBRE PROPIOS EJEMPLO: Ecuador, España en lugar de solo palabras que sean con minúsculas
        //EXISTE UN METODO SIMILAR A strtolower PARA TRANSFORMAR PRIMERO LAS PALABRAS QUE ENCUENTRE EL USUARIO EN LA SOPA DE LETRAS
        //A SOLO MINUSCULAS Y LUEGO TRANSFORMAR LA PRIMERA LETRA DE LA PALABRA A MAYUSCULAS
        //ESE PROCESO SE DEBE HACER ANTES DE CREAR LOS REGISTROS EN LA TABLA RESULTS PARA COMPARAR MEDIANTE EL METODO STRCMP EL CAMPO ANSWER
        //DE LA CONSULTA CORRECT_ANSWER QUE VA EN EL CAMPO ANSWER_ID AL MOMENTO DE CREAR UN REGISTRO
        //$correctAnswer = DB::table('answers')->where('question_id', $questionId)->where('is_correct', true)->where('answer', $respuestasUsuarioMin[1])->pluck('id')->toArray();


        //SE CREA UN ARRAY QUE VA A CONTENER LOS IDS DE LAS PALABRAS QUE EL USUARIO HAYA ENCONTRADO
        //ES DECIR, LAS RESPUESTAS O PALABRAS QUE EL USUARIO ENCONTRO EN LA SOPA DE LETRAS Y QUE SE GUARDAN EN LA TABLA RESULTS
        $palabrasRespondidas = [];

        //PARA GUARDAR LOS REGISTROS DE LAS PALABRAS ENCONTRADAS POR EL USUARIO SE RECORRE EL ARRAY RESPUESTASUSUARIOMIN QUE CONTIENE LAS PALABRAS QUE HA ENCONTRADO EL USUARIO
        for($j=0; $j<count($respuestasUsuarioMin); $j++){

            $consulta = DB::table('answers')->where('question_id', $questionId)->where('is_correct', true)->where('answer', $respuestasUsuarioMin[$j])->pluck('id')->toArray();
            //COMO LA CONSULTA DEVUELVE UN ARRAY SE DEBE CAPTURAR EL PRIMER ELEMENTO DE ESE ARRAY
            $consultaId = reset($consulta);


            $registro = Result::create([
                'answer_user' => $respuestasUsuarioMin[$j],
                'score' => $puntaje,
                'user_id' => $userId,
                'question_id' => $questionId,
                //SE ENVIA EL ID DE LA RESPUESTA CORRECTA HACIENDO UNA CONSULTA EN LA TABLA ANSWERS Y BUSCANDO EL ID DE LA ANSWER CORRECTA SEGUN LA PALABRA QUE HA ENCONTRADO EL USUARIO
                //EN LA SOPA DE LETRAS
                'answer_id' => $consultaId, 
                'evaluation_id' => $evaluation->id
                
            ]);


            //SE GUARDA EN EL ARRAY $PALABRASRESPONDIDAS LOS IDS DE LAS RESPUESTAS DEL USUARIO, EL CAMPO ANSWER_ID
            array_push($palabrasRespondidas, $registro->answer_id);
        }

        //ACTUALIZACION
        //DESDE LA VISTA VIENEN LA COLECCION DE PALABRAS ALEATORIAS QUE EL USUARIO DEBIA ENCONTRAR, VIENE SOLO LOS 10 IDS DE LAS ANSWERS
        //ALEATORIAS ASIGNADAS Y VIENEN EN UN ARRAY
        //SE CREA EL ARRAY $idPalabrasVacias QUE VA A CONTENER LOS IDS DE LA TABLA ANSWERS DE LAS PALABRAS QUE EL USUARIO NO ENCONTRO
        $idPalabrasVacias = [];

        //CON EL IF SE PREGUNTA SI EL ARRAY PALABRASRESPONDIDAS ES MAYOR QUE EL ARRAY PALABRASPORENCONTRAR O VICEVERSA, LO QUE SIGNIFICA QUE EL USUARIO NO ENCONTRO TODAS LAS PALABRAS
        //SI ES ASI, ENTONCES SE GUARDAN LOS SIGUIENTES REGISTROS CON PUNTAJE CERO
        if((count($palabrasRespondidas) < count($request->palabrasporencontrar)) || (count($palabrasRespondidas) > count($request->palabrasporencontrar)) ){
            //EN LA VARIABLE $idsPalabrasNoEncontradas SE VA A GUARDAR LOS IDS DE LAS PALABRAS QUE EL USUARIO NO ENCONTRO DE LA TABLA ANSWERS
            $idsPalabrasNoEncontradas = [];
            //CON EL IF SE PREGUNTA SI EL ID QUE SE ESTA REVISANDO DE LOS IDS TOTALES DE LAS PALABRAS QUE EL USUARIO DEBIA ENCONTRAR ESTA EN EL ARRAY PALABRASRESPONDIDAS
            //SI ES ASI ENTONCES NO SE GUARDA, PERO SI ES ASI, ENTONCES ESE ID SE GUARDA EN EL ARRAY IDPALABRASVACIAS
            for($p=0; $p<count($request->palabrasporencontrar); $p++){
                if(!in_array($request->palabrasporencontrar[$p], $palabrasRespondidas)){
                    array_push($idPalabrasVacias, $request->palabrasporencontrar[$p]);
                }
            }


            for($k=0; $k<count($idPalabrasVacias); $k++){
                //SE GUARDAN LOS REGISTROS DE LAS PALABRAS VACIAS
                $registro = Result::create([
                    'answer_user' => "Palabra no encontrada",
                    'score' => 0.00,
                    'user_id' => $userId,
                    'question_id' => $questionId,
                    //EL ID DE ESTAS RESPUESTAS VA A SER LOS IDS QUE ESTAN EN EL ARRAY PALABRASVACIAS
                    'answer_id' => $idPalabrasVacias[$k], 
                    'evaluation_id' => $evaluation->id
                    
                ]);
            }
        }


        return redirect()->route('estudiante.preguntasevaluacion', $evaluation)->with('message', 'Pregunta respondida');
        
        
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////

    //METODO PARA MOSTRAR AL ESTUDIANTE SUS RESPUESTAS A LOS EXAMENES
    public function viewResultDiagnostic($userId, $evaluationId){

        //EN EVALUATION HAS RESULTS SE BUSCA SI EN LA TABLA RESULTS EXISTE AL MENOS UNA RESPUESTA AL EXAMEN ACTUAL 
        //RESPONDIDA POR EL USUARIO ACTUAL
        $evaluationHasResults = Result::where('user_id', $userId)->where('evaluation_id', $evaluationId)->exists();

        //EN EVALUATION SE GUARDA EL REGISTRO DE LA EVALUATION ACTUAL
        $evaluation = Evaluation::find($evaluationId);

        //CAPTURAR EL NUMEERO TOTAL DE PREGUNTAS QUE TIENE EL EXAMEN
        //LAS PREGUNTAS QUE TIENE EN TOTAL, NO LAS PREGUNTAS QUE HA RESPONDIDO EL USUARIO
        $totalQuestions = Question::where('evaluation_id', $evaluationId)->count();


        //CAPTURAR EL NUMERO DE PREGUNTAS RESPONDIDAS POR EL USUARIO
        $questionsAnswered = Result::where('evaluation_id', $evaluationId)->where('user_id', $userId)->get();
        $questionsAnsweredUnique = $questionsAnswered->unique('question_id')->values()->count();


        //CAPTURAR EL NUMERO DE RESPUESTAS RESPONDIDAS CORRECTAMENTE POR EL USUARIO
        //$correctAnswers = Result::where('evaluation_id', $evaluationId)->where('user_id', $userId)->where('score' != 0)->get();
        //return $correctAnswers;

        //CONTAR EL NUMERO DE RESPUESTAS RESPONDIDAS INCORRECTAMENTE
        //$incorrectAnswers = Result::where('evaluation_id', $evaluationId)->where('user_id', $userId)->where('score', 0)->count();

       //EN LA VARIABLE QUESTIONSANSWERS SE CAPTURA LAS PREGUNTAS DEL EXAMEN Y LAS OPCIONES DE RESPUESTA A TRAVES DE LA RELACION ANSWERS
       $questionsAnswers = Question::where('evaluation_id', $evaluationId)->with('answers')->get();

       //EN LA VARIABLE RESULTSUNO, SE ALMACENA UNA COLECCION DE REGISTROS DEE LA TABLA RESULTS, QUE CONTIENEN LAS RESPUESTAS DEL USUARIO
       //ACTUAL AL EXAMEN ACTUAL
       $resultsuno = Result::where('user_id', $userId)->where('evaluation_id', $evaluationId)->get();
       //AHORA QUE TENEMOS LA COLECCION DE RESPUESTAS DEL USUARIO ACTUAL AL EXAMEN ACTUAL
       //EN LA VARIABLE RESULTS, SE GUARDAN SOLO LOS PRIMEROS REGISTROS DE RESPUESTA
       $results = $resultsuno->unique('question_id')->values();

       //EN LA VARIABLE NOTAS SE CAPTURA TODOS LOS REGISTROS QUE LA TABLA RESULTS QUE SEAN DEL USUARIO ACTUAL Y DEL EXAMEN ACTUAL
       $notas = Result::where('user_id', $userId)->where('evaluation_id', $evaluationId)->get();
       //EN LA VARIABLE PUNTAJES SE CAPTURAR DE LA COLECCION NOTAS, SOLO EL CAMPO PUNTAJE DE CADA REGISTRO
       $puntajes = Result::where('user_id', $userId)->where('evaluation_id', $evaluationId)->pluck('score')->toArray();
       //EN LA VARIABLE CALIFICACION SE SUMA TODOS LOS VALORES QUE CONTIENE EL ARRAY PUNTAJES
       $calificacion = array_sum($puntajes);

        //CON EL IF SE PREGUNTA SI EVALUATION HAS RESULTS ES TRUE, LO QUE SIGNIFICA QUE EL USUARIO TIENE RESPUESTAS GUARDADAS
        //SI ES ASI ENTONCES QUE LO ENVIE A LA PAGINA DE EVALUACION DE DIAGNOSTICO 
        if($evaluationHasResults){
            //return redirect()->route('estudiante.diagnostico')->with('message', 'Evaluación Finalizada');
            return view('rules.estudiante.finalresult', compact('evaluation', 'userId', 'evaluationId', 'totalQuestions', 'questionsAnsweredUnique', 'results', 'questionsAnswers', 'calificacion'));
        }
        else{
            //CASO CONTRARIO QUE SOLO ENVIE UN MENSAJE QUE DIGA QUE DEBE RESPONDER AL MENOS UNA PREGUNTA PARA SALIR
            return redirect()->back()->with('message', 'Debes responder al menos una pregunta para salir.');
        }
        //return $evaluationHasResults;
    }



    //METODO DE PRUEBA
    public function viewResult($userId, $evaluationId){

        //EN EVALUATIONS HAS RESULTS SE BUSCA SI EN LA TABLA RESULTS EXISTE AL MENOS UNA RESPUESTA EL EXAMEN ACTUAL
        //RESPONDIDA POR EL USUARIO ACTUAL
        $evaluationHasResults = Result::where('user_id', $userId)->where('evaluation_id', $evaluationId)->exists();

        //EN EVALUATION SE GUARDA EL REGISTRO DE LA EVALUATION ACTUAL
        $evaluation = Evaluation::find($evaluationId);

        //CAPTURAR EL NUMERO TOTAL DE PREGUNTAS QUE TIENE EL EXAMEN
        //LAS PREGUNTAS QUE TIENE EN TOTAL, NO LAS PREGUNTAS QUE HA RESPONDIDO EL USUARIO
        $totalQuestions = Question::where('evaluation_id', $evaluationId)->count();

        //CAPTURAR EL NUMERO DE PREGUNTAS RESPONDIDAS POR EL USUARIO
        $questionsAnswered = Result::where('evaluation_id', $evaluationId)->where('user_id', $userId)->get();
        $questionsAnsweredUnique = $questionsAnswered->unique('question_id')->values()->count();

        //EN LA VARIABLE QUESTIONS ANSWERS SE CAPTURA LAS PREGUNTAS DEL EXAMEN Y LAS OPCIONES DE RESPUESTA A TRAVES DE LA RELACION
        //ANSWERS
        $questionsAnswers = Question::where('evaluation_id', $evaluationId)->get();


        //EN LA VARIABLE NOTAS SE CAPTURA TODOS LOS REGISTROS DE LA TABLA RESULTS QUE SEAN DEL USUARIO ACTUAL Y DEL EXAMEN ACTUAL
        $notas = Result::where('user_id', $userId)->where('evaluation_id', $evaluationId)->get();
        //EN LA VARIABLE PUNTAJES SE CAPTURA DE LA COLECCION NOTAS, SOLO EL CAMPO PUNTAJE DE CADA REGISTRO
        $puntajes = Result::where('user_id', $userId)->where('evaluation_id', $evaluationId)->pluck('score')->toArray();
        //EN LA VARIABLE CALIFICACION SE SUMA TODOS LOS VALORES QUE CONTIENE EL ARRAY PUNTAJES
        $calificacion = array_sum($puntajes);

 

        ////NUEVO AGREGADO////////////////////////////////////////////////////////////////////////////////////////////

        //EN LA VARIABLE QUESTIONSANSWEREDBYUSER SE GUARDA UN ARRAY CON EL CAMPO QUESTION_ID DE LOS REGISTROS DE LA TABLA RESULTS
        //LO QUE SIGNIFICA QUE ESTOY CAPTURANDO LOS IDS DE LAS PREGUNTAS QUE EL USUARIO ACTUAL HA RESPONDIDO
        $questionsAnsweredByUser = Result::where('user_id', $userId)->where('evaluation_id', $evaluationId)->pluck('question_id')->toArray();
        //EN QUESTIONS RESPONDIDAS SE ALMACENAN EN UN ARRAY LOS IDS DE LAS QUESTIONS QUE EL USUARIO RESPONDIO, ESTOS IDS VIENEN DE LA TABLA RESULTS
        //Y SE USA EL METODO ARRAY_UNIQUE PORQUE COMO HAY 5 RESULTADOS EN LAS PREGUNTAS QUE TIENEN VARIOS RESULTADOS, ENTONCES SOLO NECESITO SABER
        //UN QUESTION_ID POR CADA GRUPO DE RESPUESTAS
        $questionsRespondidas = array_unique($questionsAnsweredByUser);
        //EN LA VARIABLE COLECCIONQUESTIONS SE VA A GUARDAR UNA COLECCION DE REGISTROS DE LA TABLA QUESTIONS QUE CONTIENEN LAS PREGUNTAS QUE EL USUARIO HA 
        //RESPONDIDO
        $coleccionQuestions = Question::where('evaluation_id', $evaluationId)->whereIn('id', $questionsRespondidas)->get();
        //EN LA VARIABLE COLECCIONSINRESPONDER SE VA A GUARDAR UNA COLECCION DE REGISTROS DE LA TABLA QUESTIONS QUE CONTIENEN LAS PREGUNTAS QUE EL USUARIO NO
        //HA RESPONDIDO
        $coleccionSinResponder = Question::where('evaluation_id', $evaluationId)->whereNotIn('id', $questionsRespondidas)->get();


        ////////////////////////////////////////////////////////////////////////////////////////////////////////////


        //CON EL IF SE PREGUNTA SI EVALUATIONSHASRTESULTS ES TRUE, LO QUE SIGNIFICA QUE EL USUARIO TIENE RESPUESTAS GUARDADAS
        //SI ES ASI, ENTONCES QUE LO ENVIE A LA PAGINA DE EVALUACION 
        if($evaluationHasResults){
            return view('rules.estudiante.results', compact('evaluation', 'userId', 'evaluationId', 'totalQuestions', 'questionsAnsweredUnique', 'questionsAnswers', 'calificacion', 'coleccionQuestions', 'coleccionSinResponder'));
        }
        else{
            //CASO CONTRARIO QUE SOLO ENVIE UN MENSAJE QUE DIGA QUE DEBE RESPONDER AL MENOS UNA PREGUNTA PARA SALIR
            return redirect()->back()->with('message', 'Debes responder al menos una pregunta para salir');
        }


    } 


    //METODO PARA MOSTRAR LA SOLUCION A UNA PREGUNTA RESPONDIDA POR EL USUARIO SEGUN EL TIPO DE PREGUNTA QUE SEA
    public function viewQuestionResults($userId, $evaluationId, $questionId){
        
        //BUSCAR EL REGISTRO DE LA QUESTION ID ACTUAL Y SACAR EL CAMPO TYPE 
        $questionType = Question::find($questionId);

        //CON EL IF SE PREGUNTA SI LA QUESTION PERTENECE A UN TYPE ESPECIFICO Y SEGUN ESO SE HACE EL CODIGO
        //PARA ENVIAR LA INFORMACION REQUERIDA A LA VISTA 
        if(($questionType->type) === "OM"){

            //CAPTURAR LA RESPUESTA DEL USUARIO A LA QUESTION OM MEDIANTE EL USERID Y EVALUATIONID
            $answersUser = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->get();

            //CAPTURAR EL PUNTAJE QUE TIENE EL ESTUDIANTE EN LA PREGUNTA ACTUAL
            $resultados = DB::table('results')->where('question_id', $questionId)->where('user_id', $userId)->pluck('score')->toArray();
            $sumaresultados = array_sum($resultados);

            //COMO ES OPCION MULTIPLE SE DEBE CAPTURAR LA RESPUESTA CORRECTA, PARA ELLO SE TRAE EN UN ARRAY LA COLECCION DE RESPUESTAS CORRECTAS
            //DESDE LA TABLA ANSWER
            $resCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->pluck('id')->toArray();
            //COMO ES OPCION MULTIPLE SOLO TIENE UNA RESPUESTA CORRECTA, ENTONCES DEL ARRAY DE RESCORRECTA SOLO SE CAPTURA EL PRIMER ELEMENTO
            $idAnswerCorrecta = reset($resCorrecta);
            //YA TENIENDO EL ID DE LA RESPUESTA CORRECTA, SE CAPTURA EL REGISTRO COMPLETO DE ANSWER
            $answerCorrecta = Answer::find($idAnswerCorrecta);



            //ACTUALIZACION
            //PARA MOSTRAR LAS REGLAS ORTOGRAFICAS ASOCIADAS A LA PREGUNTA CLASIFICADAS POR PALABRAS, PUNTUACION Y ACENTUACION
            //SE DECLARA TRES VARIABLES QUE VAN A A ENVIAR TRUE SI HAY REGLAS ASOCIADAS DE PALABRAS, PUNTUACION O ACENTUACION
            //ESTO SIRVE PARA QUE EN LA VISTA DE MUESTREN LAS SECCIONES SOLO SI HAY REGLAS DE ESE TIPO ASOCIADAS
            
            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 1 CATEGORIES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasencategories = false;
            $hayacentuacionencategories = false;
            $haypuntuacionencategories = false;

            for($a=0; $a<count($questionType->categories); $a++){

                if($questionType->categories[$a]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionencategories = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 2 SECTIONS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasensections = false;
            $hayacentuacionensections = false;
            $haypuntuacionensections = false;

            for($b=0; $b<count($questionType->sections); $b++){

                if($questionType->sections[$b]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionensections = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 3 POSTS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenposts = false;
            $hayacentuacionenposts = false;
            $haypuntuacionenposts = false;

            for($c=0; $c<count($questionType->posts); $c++){

                if($questionType->posts[$c]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenposts = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 4 RULES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenrules = false;
            $hayacentuacionenrules = false;
            $haypuntuacionenrules = false;

            for($d=0; $d<count($questionType->rules); $d++){

                if($questionType->rules[$d]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenrules = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 5 NOTES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasennotes = false;
            $hayacentuacionennotes = false;
            $haypuntuacionennotes = false;

            for($e=0; $e<count($questionType->notes); $e++){

                if($questionType->notes[$e]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionennotes = true;
                }
            }


            return view('rules.estudiante.displayresults.displayom', compact('questionType', 'answersUser', 'sumaresultados', 'answerCorrecta', 'userId', 'evaluationId'
                        , 'haypalabrasencategories', 'hayacentuacionencategories', 'haypuntuacionencategories', 'haypalabrasensections', 'hayacentuacionensections', 'haypuntuacionensections'
                        , 'haypalabrasenposts', 'hayacentuacionenposts', 'haypuntuacionenposts', 'haypalabrasenrules', 'hayacentuacionenrules', 'haypuntuacionenrules'
                        , 'haypalabrasennotes', 'hayacentuacionennotes', 'haypuntuacionennotes'));
        } 
        elseif(($questionType->type) === "PC"){

            //CAPTURAR LAS 5 RESPUESTAS DEL USUARIO A LA QUESTION PC MEDIANTE EL USERID Y EVALUATIONID Y SE CREA UN ARRAY CON LOS IDS DE LOS RESULTADOS
            $answersUser = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->pluck('id')->toArray();
            
            //CON LOS IDS DE LOS RESULTADOS SE BUSCA UNA A UNA LA RESPUESTA EN LA TABLA RESULTS PARA TENERLOS LISTOS COMO STRINGS
            //SE ACCEDE ASI A LA RESPUESTA TIPO STRING: $palabrauno->answer_user
            $palabrauno = Result::find($answersUser[0]);
            $palabrados = Result::find($answersUser[1]);
            $palabratres = Result::find($answersUser[2]);
            $palabracuatro = Result::find($answersUser[3]);
            $palabracinco = Result::find($answersUser[4]);

            

            //GUARDAR LAS RESPUESTAS DEL USUARIO EN UN ARRAY PARA ENVIARLAS A LA VISTA
            //$arrayResults = [$palabrauno, $palabrados, $palabratres, $palabracuatro, $palabracinco];
            $coleccionResults = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->get();


            //CAPTURAR EL PUNTAJE QUE TIENE EL ESTUDIANTE EN LA PREGUNTA ACTUAL
            $resultados = DB::table('results')->where('question_id', $questionId)->where('user_id', $userId)->pluck('score')->toArray();
            $sumaresultados = array_sum($resultados);

            //COMO ES PALABRA CORRECION SON 5 RESPUESTAS DE LA TABLA ANSWERS ENTONCES SE CAPTURA PRIMERO LA COLECCION DE RESPUESTAS
            //$resCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->pluck('id')->toArray();

            //ACTUALIZACION, COMO AHORA SON UN BANCO DE 15 PALABRAS, SE DEBE CAPTURAR LAS 5 PALABRAS RANDOM QUE SE LE ASIGNARON AL USUARIO ACTUAL
            //ENTONCES EN LA VARIABLE $IDSANSWERSUSER SE GUARDAN LOS IDS DE CADA ANSWER A LA QUE EL USUARIO RESPONDIO
            $idsAnswersUser = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->pluck('answer_id')->toArray();
            //EN LA VARIABLE $RESCORRECTA SE CAPTURAN LOS REGISTROS DE LA TABLA ANSWER QUE SON LAS PALABRAS CORRECTAS QUE EL USUARIO DEBIA CORREJIR
            $resCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->whereIn('id', $idsAnswersUser)->pluck('id')->toArray();


            
            //CON LOS IDS DE LAS ANSWERS CORRECTAS SE BUSCA UNA A UNA LA RESPUESTA EN LA TABLA ANSWERS PARA TENERLOS LISTOS COMO STRINGS
            //SE ACCEDE ASI A LA ANSWER TIPO STRING: $rescorrectauno->answer;
            $rescorrectauno = Answer::find($resCorrecta[0]);
            $rescorrectados = Answer::find($resCorrecta[1]);
            $rescorrectatres = Answer::find($resCorrecta[2]);
            $rescorrectacuatro = Answer::find($resCorrecta[3]);
            $rescorrectacinco = Answer::find($resCorrecta[4]);



            //GUARDAR LAS ANSWERS CORRECTAS EN UN ARRAY PARA ENVIARLAS A LA VISTA
            $coleccionCorrectas = Answer::where('question_id', $questionId)->where('is_correct', true)->get();

            //CAPTURAR LAS PALABRAS ACERTADAS Y LAS PALABRAS INCORRECTAS
            $answers = Answer::where('question_id', $questionId)->where('is_correct', true)->pluck('answer')->toArray();
            $responses = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->pluck('answer_user')->toArray();
            //$palabrasAcertadas = [];
            //$palabrasIncorrectas = [];
            $answersU_count = count($responses);
            //RECORRER CON UN FOR EL ARRAY DE RESPUESTAS CORRECTAS Y EL ARRAY DE RESPUESTAS DEL USUARIO Y LAS QUE COINCIDAN SE GUARDAN EN EL ARRAY 
            //DE PALABRAS ACERTADAS Y LAS QUE NO COINCIDAN EN EL ARRAY DE PALABRASINCORRECTAS
            //for($i=0; $i<$answersU_count; $i++){
            //    $comparacion = strcmp($answers[$i], $responses[$i]);
            //   if($comparacion == 0){
            //        array_push($palabrasAcertadas, $responses[$i]);
            //    }
            //    else{
            //        array_push($palabrasIncorrectas, $responses[$i]);
            //    }
            //}

            //ACTUALIZACION CAPTURAR EN EL ARRAY $PALABRASACERTADAS LAS PALABRAS CORRECTAS DEL USUARIO Y EN EL ARRAY $PALABRASINCORRECTAS LAS PALABRAS INCORRECTAS
            $palabrasAcertadas = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->where('score', 0.20)->pluck('answer_user')->toArray();
            $palabrasIncorrectas = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->where('score', 0.00)->pluck('answer_user')->toArray();
    
            //return $palabrasIncorrectas;
            ////////////////////////////////////////////////////NUEVO CODIGO

            //GUARDAR EN UNA VARIABLE CADA PALABRA DE LAS 5 RESPUESTAS DEL USUARIO
            //CON TRIM SE QUITAN LOS ESPACIOS DEL INICIO Y DEL FINAL DE LAS PALABRAS
            $palabraUsuarioUno = trim($palabrauno->answer_user);
            $palabraUsuarioDos = trim($palabrados->answer_user);
            $palabraUsuarioTres = trim($palabratres->answer_user);
            $palabraUsuarioCuatro = trim($palabracuatro->answer_user);
            $palabraUsuarioCinco = trim($palabracinco->answer_user);

            //GUARDAR EN UNA VARIABLE CADA PALABRA CORRECTA
            //CON TRIM SE QUITAN LOS ESPACIOS DEL INICIO Y DEL FINAL DE LAS PALABRAS
            $palabraCorrectaUno = trim($rescorrectauno->answer);
            $palabraCorrectaDos = trim($rescorrectados->answer);
            $palabraCorrectaTres = trim($rescorrectatres->answer);
            $palabraCorrectaCuatro = trim($rescorrectacuatro->answer);
            $palabraCorrectaCinco = trim($rescorrectacinco->answer);


            //VARIABLE QUE MOSTRARA UN MENSAJE EN LA SECCION DE DETALLE DE LA RESPUESTA
            $respuestaCasoUno = "";
            $respuestaCasoDos = "";
            $respuestaCasoTres = "";
            $respuestaCasoCuatro = "";
            $respuestaCasoCinco = "";

            //VARIABLES GLOBALES PARA ANALIZAR CADA PALABRA 

            //PALABRA UNO
            $letrasIncorrectasUno = [];
            $letrasBienColocadasUno = [];
            $letrasMalColocadasUno = [];
            $palabraLetrasCorrectasUno = [];
            $palabraLetrasIncorrectasUno = [];

            $arrayPalabrasUno = [];

            //ACTUALIZACION SOLO VAN STRINGS LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS
            $resultadoLetrasIncorrectasUno = [];
            $resultadoLetrasBienColocadasUno = "";
            $resultadoLetrasMalColocadasUno = [];
            $resultadoPalabraLetrasCorrectasUno = "";
            $resultadoPalabraLetrasIncorrectasUno = [];
            //ACTUALIZACION SE AGREGA EL ARRAY RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO
            $resultadoSeccionesQueLeFaltaronALaPalabraUno = [];

            //COMPROBACION PALABRA UNO
            //PRIMERO SE DEBE COMPROBAR SI LAS PALABRAS SON IGUALES, ES DECIR SI SON CORRECTAS O INCORRECTAS
            $comparacionUno = strcmp($palabraCorrectaUno, $palabraUsuarioUno);


            //CON EL IF SE PREGUNTA SI LA COMPARACION ES IGUAL A 0, ES DECIR SI SON IGUALES. O ES IGUAL A DIFERENTE DE 0, ES DECIR, LA PALABRA DEL USUARIO ES INCORRECTA
            if($comparacionUno === 0){
                //SI ES IGUAL A CERO, LA PALABRA DEL USUARIO ES CORRECTA
                $respuestaCasoUno = "Su respuesta a la primera palabra es correcta";

                //COMO EN EL COMPACT SIEMPRE TIENEN QUE IR LOS 5 STRING QUE SON LOS RESULTADOS DE LOS 5 ARRAYS ENTONCES EN ESTE CASO SE ENVIA LO SIGUIENTE
                //$resultadoLetrasIncorrectasUno = "La palabra uno no tiene letras incorrectas.";
                //$resultadoLetrasBienColocadasUno = "La palabra uno tiene sus letras en el orden correcto.";
                //$resultadoLetrasMalColocadasUno = "La palabra uno no tiene letras en desorden.";
                //$resultadoPalabraLetrasCorrectasUno = $palabraCorrectaUno;
                //$resultadoPalabraLetrasIncorrectasUno = "No hay letras incorrectas en la palabra.";

                //ACTUALIZACION
                //EN LAS VARIABLES LLAMADAS RESULTADO YA NO SE ENVIAN STRINGS, SINO SOLO ARRAYS
                $resultadoLetrasIncorrectasUno = [];
                //SI LA RESPUESTA ES CORRECTA ENTONCES LA SIGUIENTE VARIABLE VA VACIA
                //$resultadoLetrasBienColocadasUno = "Tu respuesta no tiene elementos incorrectos.";
                $resultadoLetrasBienColocadasUno = "";
                $resultadoLetrasMalColocadasUno = [];
                //SI LA RESPUESTA ES CORRECTA ENTONCES LA SIGUIENTE VARIABLE VA VACIA
                //$resultadoPalabraLetrasCorrectasUno = $palabraUsuarioUno;
                $resultadoPalabraLetrasCorrectasUno = "";
                $resultadoPalabraLetrasIncorrectasUno = [];
                //ACTUALIZACION SE AGREGO ESTE NUEVO ARRAY
                $resultadoSeccionesQueLeFaltaronALaPalabraUno = [];
            } 
            else{
                //SI ES DIFERENTE DE 0, LA PALABRA DEL USUARIO ES INCORRECTA
                //HAY DOS CASOS PRINCIPALES PARA QUE UNA PALABRA ESTE MAL
                //1. QUE LA CADENA INGRESADA TENGA MAS DE UNA PALABRA
                //2. QUE LA CADENA TENGA UNA SOLA PALABRA O CONJUNTO DE CARACTERES Y DE AHI SE DESPRENDEN 3 SUBCASOS


                //1. SI LA CADENA INGRESADA TIENE MAS DE UNA PALABRA HACER LO SIGUIENTE
                //EL METODO EXPLODE SIRVE PARA SEPARAR PALABRA DE UN STRING MEDIANTE UN ESPACIO Y GUARDA LAS PALABRAS EN UN ARRAY, POR LO QUE
                //HAY QUE CONTAR SI EN EL ARRAY HAY UNA O MAS PALABRAS
                $arrayPalabrasUno = explode(' ', $palabraUsuarioUno);
                //DEL ARRAY, CONTAR EL NUMERO DE PALABRAS QUE TIENE
                $numeroPalabrasUno = count($arrayPalabrasUno);

                //CON EL IF SE PREGUNTA SI HAY DOS PALABRAS O MAS
                if($numeroPalabrasUno>1){

                    //SI HAY DOS O MAS PALABRAS SOLO DEVUELVE LOS RESULTADOS Y NO HACE NINGUN ANALISIS
                    //$resultadoLetrasIncorrectasUno = "Su respuesta tiene más de una palabra.";
                    //$resultadoLetrasBienColocadasUno = "Hay más de una palabra.";
                    //$resultadoLetrasMalColocadasUno = $palabraUsuarioUno;
                    //$resultadoPalabraLetrasCorrectasUno = "No se admiten más de una palabra";
                    //$resultadoPalabraLetrasIncorrectasUno = $palabraUsuarioUno;
                    $respuestaCasoUno = "Respuesta incorrecta, no se puede agregar más de una palabra.";

                    //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIAN COMO ARRAY
                    $resultadoLetrasIncorrectasUno = [];
                    //SI LA RESPUESTA TIENE DOS PALABRAS ENTONCES ESTA VARIABLE VA VACIA
                    //$resultadoLetrasBienColocadasUno = "Resultado incorrecto, hay más de una palabra.";
                    $resultadoLetrasBienColocadasUno = "";
                    $resultadoLetrasMalColocadasUno = [];
                    //$resultadoPalabraLetrasCorrectasUno = "No se admite más de una palabra";
                    $resultadoPalabraLetrasCorrectasUno = "";
                    $resultadoPalabraLetrasIncorrectasUno = [];
                    //ACTUALIZACION
                    $resultadoSeccionesQueLeFaltaronALaPalabraUno = [];

                }else{
                    //SI HAY SOLO UNA PALABRA SE ABACA EL CASO 2 Y SUS 3 OPCIONES
                    //2.1. QUE LA CADENA TENGA IGUAL NUMERO DE CARACTERES PERO QUE NO SEAN LOS MISMOS EN CADA POSICION
                    //2.2. QUE LA CADENA TENGA MENOS CARACTERES QUE LA PALABRA CORRECTA
                    //2.3. QUE LA CADENA TENGA MAS CARACTERES QUE LA PALABRA CORRECTA

                    //APARA SABER QUE CASO CONVIENE A CADA PALABRA, HAY QUE CONTAR CUANTOS CARACTERES HAY EN EL STRING
                    //DE LA PALABRA CORRECTA Y EL STRING DE LA RESPUESTA DEL USUARIO
                    //CON EL METODO MB_STRLEN SE CUENTA EL NUMERO DE CARACTERES QUE TIENE LA RESPUESTA DEL USUARIO
                    //ESTE METODO TOMA EN CUENTA LOS ESPACIOS QUE SE DEJA AL INICIO, AL FINAL Y ENTRE EL ENUNCIADO, POR ESO 
                    //A LAS PALABRAS CORRECTAS Y RESPUESTAS SE LES APLICO EL METODO TRIM()
                    $nroLetrasPalabraUsuarioUno = mb_strlen($palabraUsuarioUno, 'UTF-8');
                    $nroLetrasPalabraCorrectaUno = mb_strlen($palabraCorrectaUno, 'UTF-8');
                    //SE DEBE HACER UN ARRAY DE LA PALABRA DEL USUARIO COMO DE LA PALABRA CORRECTA PARA POSTERIOMENTE COMPROBAR LETRA A LETRA
                    $arrayPalabraUsuarioUno = mb_str_split($palabraUsuarioUno);
                    $arrayPalabraCorrectaUno = mb_str_split($palabraCorrectaUno);

                    //CON EL IF SE PREGUNTA SI LA PALABRA TIENE IGUAL NUMERO DE CARACTERES, SI TIENE MAS O MENOS CARACTERES Y SE ANALIZA SEGUN SEA EL CASO
                    if($nroLetrasPalabraCorrectaUno === $nroLetrasPalabraUsuarioUno){
                        //SI EL NUMERO DE LETRAS DE LA PALABRA CORRECTA ES IGUAL AL NUMERO DE LETRAS DE LA PALABRA DEL USUARIO SE INGRESA AL CASO UNO
                        //2.1. QUE LA CADENA TENGA IGUAL NUMERO DE CARACTERES PERO QUE NO SEAN LOS MISMOS EN CADA POSICION

                        //CON UN FOR SE ANALIZA EN BASE A LA PALABRA CORRECTA, LAS LETRAS DE LA PALABRA DEL USUARIO QUE NO COINCIDAN CON LAS LETRAS DE LA PALABRA CORRECTA
                        //EN X POSICION, AQUI TAMBIEN SE CAPTURAN, SIGNOS, SIMBOLOS QUE NO COINCIDAN CON LA PALABRA CORRECTA Y SE ALMACENAN EN EL ARRAY LETRASINCORRECTASUNO
                        for($i=0; $i<$nroLetrasPalabraUsuarioUno; $i++){
                            //CON EL IF SE PREGUNTA SI LA LETRA DE LA RESPUESTA CORRECTA EN X POSICION ES DIFERENTE A LA LETRA DEL USUARIO EN LA MISMA POSICION
                            //SI SE CUMPLE LA CONDICION ENTONCES EN EL ARRAY LETRASINCORRECTASUNO, SE GUARDA LA LETRA INCORRECTA DE LA PALABRA DEL USUARIO
                            if($arrayPalabraCorrectaUno[$i] !== $arrayPalabraUsuarioUno[$i]){
                                array_push($letrasIncorrectasUno, $arrayPalabraUsuarioUno[$i]);
                            }
                        }


                        //AHORA QUE EN EL ARRAY LETRASINCORRECTASUNO SE TIENEN LAS LETRAS DE LA PALABRA DEL USUARIO QUE ESTAN MAL
                        //SE CREAN DOS ARRAY MAS, UNO PARA CONTENER LAS LETRAS ERRONEAS PERO QUE SI ESTAN EN ALGUN LUGAR DE LA PALABRA
                        //Y OTRO PARA COLOCAR LAS LETRAS O CARACTERES QUE NO TIENEN RELACION CON LA PALABRA CORRECTA
                        //ADEMAS HAY QUE CONTAR EL NUMERO DE LETRAS QUE CONTIENE EL ARRAY LETRAS INCORRECTASUNO
                        $nroLetrasIncorrectasUno = count($letrasIncorrectasUno);

                        //CON UN FOR SE RECORREN LA PALABRA CORRECTA Y LA PALABRA DEL USUARIO Y SE VAN LLENADO LOS ARRAYS PARA ENVIARLOS 
                        //A LA VISTA CON LAS PALABRAS QUE SE NECESITAN
                        //ESTE FOR SIRVE PARA MOSTAR AL USUARIO LAS LETRAS QUE PUSO CORRECTAMENTE EN LA PALABRA 
                        for($e=0; $e<$nroLetrasPalabraCorrectaUno; $e++){
                            if(strncmp($arrayPalabraCorrectaUno[$e], $arrayPalabraUsuarioUno[$e], $e+1) === 0){
                                array_push($palabraLetrasCorrectasUno, $arrayPalabraUsuarioUno[$e]);
                                array_push($letrasBienColocadasUno, $arrayPalabraUsuarioUno[$e]);
                            }else{
                                array_push($palabraLetrasCorrectasUno, '_');
                                array_push($letrasMalColocadasUno, $arrayPalabraUsuarioUno[$e]);
                            }
                        }

                        //ESTE FOR SIRVE PARA MOSTRAR AL USUARIO LAS LETRAS INCORRECTAS DE SU RESPUESTA
                        for($f=0; $f<$nroLetrasPalabraCorrectaUno; $f++){
                            if(strncmp($arrayPalabraCorrectaUno[$f], $arrayPalabraUsuarioUno[$f], $f+1) !== 0){
                                array_push($palabraLetrasIncorrectasUno, $arrayPalabraUsuarioUno[$f]);
                            }
                            else{
                                array_push($palabraLetrasIncorrectasUno, '_');
                            }
                        }



                        //ACTUALIZACION
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA OPCION CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraUno = [];
                        for($t=0; $t<$nroLetrasPalabraCorrectaUno; $t++){
                            if(!in_array($arrayPalabraCorrectaUno[$t], $arrayPalabraUsuarioUno)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraUno, $arrayPalabraCorrectaUno[$t]);
                            }
                        }

                        

                        //UNA VEZ TENIENDO TODOS LOS DATOS LISTOS, SE PROCEDE A CAMBIAR LOS ARRAYS A STRINGS PARA ENVIARLOS 
                        //A LA VISTA
                        //$resultadoLetrasIncorrectasUno = implode("",$letrasIncorrectasUno);
                        //$resultadoLetrasBienColocadasUno = implode(", ", $letrasBienColocadasUno);
                        //$resultadoLetrasMalColocadasUno = implode(", ", $letrasMalColocadasUno);
                        //$resultadoPalabraLetrasCorrectasUno = implode(" ", $palabraLetrasCorrectasUno);
                        //$resultadoPalabraLetrasIncorrectasUno = implode(" ", $palabraLetrasIncorrectasUno);
                        $respuestaCasoUno = "Su respuesta es incorrecta. Revise que las letras estén bien posicionadas en la palabra.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCODASUNO SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasUno = $letrasIncorrectasUno;
                        $resultadoLetrasBienColocadasUno = implode(", ", array_unique($letrasBienColocadasUno));
                        $resultadoLetrasMalColocadasUno = $letrasMalColocadasUno;
                        $resultadoPalabraLetrasCorrectasUno = implode(" ", $palabraLetrasCorrectasUno);
                        $resultadoPalabraLetrasIncorrectasUno = $palabraLetrasIncorrectasUno;
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraUno = $arrayLetrasQueLeFaltaronALaPalabraUno;


                    }elseif($nroLetrasPalabraCorrectaUno < $nroLetrasPalabraUsuarioUno){
                        //SI EL NUMERO DE LETRAS DE LA PALABRA CORRECTA ES MENOR QUE EL NUMERO DE LETRAS DE LA PALABRA DEL USUARIO
                        //SIGNIFICA QUE EL USUARIO AGREGO MAS LETRAS O CARACTERES DE LAS QUE NECESITABA
                        //CASO 2.2. QUE LA CADENA TENGA MAS CARACTERES QUE LA PALABRA CORRECTA

                        //CUANDO LA CADENA PALABRA USUARIO TIENE MAS CARACTERES QUE LA PALABRA CORRECTA SE CORTA LA CADENA DE PALABRA USUARIO
                        //ENTONCES PARA ELLO UTILIZAMOS ARRAYPALABRAUSUARIOUNO QUE CONTIENE LA RESPUESTA DEL USUARIO Y NROLETRASPALABRACORRECTAUNO QUE TIENE 
                        //LA LONGITUD DE HASTA DONDE SE VA A CORTAR EL ARRAY DE RESPUESTA USUARIO PARA PODER COMPARAR LUEGO LOS ARRAYS
                        //$arrayPalabraUsuarioUnoCortada = array_slice($arrayPalabraUsuarioUno, 0, $nroLetrasPalabraCorrectaUno);
                        //$stringPalabraUsuarioUnoCortada = implode("", $arrayPalabraUsuarioUnoCortada);
                        //$nroLetrasPalabraUsuarioUnoCortada = mb_strlen($stringPalabraUsuarioUnoCortada, 'UTF-8');

                        //DE LAS LAS LETRAS QUE TIENE EL USUARIO VER QUE LETRAS SI PERTENECEN A LA PALABRA CORRECTA
                        //SE CREAN DOS ARRAYS PARA GUARDAR LAS LETRAS DE LA RESPUESTA DEL USUARIO SEGUN CORRESPONDA
                        $letrasQueSiFormanParte = [];
                        $letrasQueNoFormanParte = [];
                        //SE CREA UN ARRAY QUE CONTIENE LA PALABRA CON LAS LETRAS QUE SI COINCIDEN DE LA RESPUESTA DEL USUARIO
                        $palabraCoincidente = [];

                        //CON UN FOR SE RECORRE LAS LETRAS QUE TIENEN LA RESPUESTA DEL USUARIO
                        //IMPORTANTE
                        //SI EN ALGUN LADO DA ERROR, SE PUEDE PROBAR CAMBIANDO EN EL FOR EN LUGAR DE NROLETRASPALABRAUSUARIOUNO
                        //POR NROLETRASPALABRACORRECTAUNO ASI NO SE DESBORDA EL ARRAY 
                        //Y EN EL IF SE CAMBIA EL ANALISIS, EN LUGAR DE BUSCAR EN ARRAYPALABRAUSUARIO[$I] QUE SE BUSQUE
                        //EN ARRAYPALABRACORRECTAUNO[$I] Y ARRAYPALABRAUSUARIOUNO PASA A SER EL ARRAY DONDE SE COMPRUEBA QUE ESTE
                        //UNA LETRA EN ESPECIFICO, ES DECIR, CAMBIAN DE LUGAR
                        for($n=0; $n<$nroLetrasPalabraUsuarioUno; $n++){
                            //CON EL IF SE PREGUNTA SI LA LETRA DE LA PALABRA DEL USUARIO EN X POSICION COINCIDE CON ALGUNA LETRA
                            //DE LA PALABRA CORRECTA, SI ES ASI ENTONCES ESA LETRA SE GUARDA EN EL ARRAY DE LETRASQUESIFORMANPARTE
                            //SI NO ES ASI, LA LETRA SE GUARDA EN EL ARRAY DE LETRAS QUE NO COINCIDEN
                            if(in_array($arrayPalabraUsuarioUno[$n], $arrayPalabraCorrectaUno)){
                                array_push($letrasQueSiFormanParte, $arrayPalabraUsuarioUno[$n]);
                            }
                            else{
                                array_push($letrasQueNoFormanParte, $arrayPalabraUsuarioUno[$n]);
                            }
                        }

                        //EN EL ARRAY LETRASQUESIFORMANPARTE PUEDEN TENER LETRAS REPETIDAS, HAY QUE BUSCAR LA FORMA
                        //DE QUE SOLO GUARDE UNA LETRA Y NO LETRAS REPETIDAS


                        //CON EL FOR SE RECORRE EL ARRAY DE LA PALABRA CORRECTA
                        for($p=0; $p<$nroLetrasPalabraCorrectaUno; $p++){
                            //CON EL IF SE PREGUNTA SI EN LA LETRA X DEL ARRAY QUE CONTIENE LAS LETRAS DE LA PALABRA CORRECTA
                            //COINCIDE CON ALGUNA LETRA DEL ARRAY DE LETRASQUESIFORMANPARTE
                            //SI ES ASI, ENTONCES EN EL ARRAY PALABRACOINCIDENTE, SE GUARDA ESA LETRA EN LA POSICION DE LA PALABRA CORRECTA
                            //SI NO ES ASI, EN LA POSICION DE LA LETRA ACTUAL DE LA PALABRA CORRECTA SE PONE UNA RAYA
                            if(in_array($arrayPalabraCorrectaUno[$p], $letrasQueSiFormanParte)){
                                array_push($palabraCoincidente, $arrayPalabraCorrectaUno[$p]);
                            }
                            else{
                                array_push($palabraCoincidente, '_');
                            } 
                        }


                        //ACTUALIZACION     
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA RESPUESTA CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraUno = [];
                        for($f=0; $f<$nroLetrasPalabraCorrectaUno; $f++){
                            if(!in_array($arrayPalabraCorrectaUno[$f], $arrayPalabraUsuarioUno)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraUno, $arrayPalabraCorrectaUno[$f]);
                            }
                        }

                        
                        

                        //UNA VEZ TENIENDO LOS DATOS LISTOS, SE PROCEDE A CAMBIAR LOS ARRAY A STRING PARA ENVIARLOS A LA VISTA
                        //$resultadoLetrasIncorrectasUno = implode("", $letrasQueNoFormanParte);
                        //$resultadoLetrasBienColocadasUno = implode(", ", $letrasQueSiFormanParte);
                        //$resultadoLetrasMalColocadasUno = implode(", ", $letrasQueNoFormanParte);
                        //$resultadoPalabraLetrasCorrectasUno = implode(" ", $palabraCoincidente);
                        //$resultadoPalabraLetrasIncorrectasUno = "Las letras incorrectas de su respuesta no van en la palabra.";
                        $respuestaCasoUno = "Su respuesta tiene más letras o caracteres de los necesarios.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCODASUNO SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasUno = $letrasQueNoFormanParte;
                        $resultadoLetrasBienColocadasUno = implode(", ", array_unique($letrasQueSiFormanParte));
                        $resultadoLetrasMalColocadasUno = $letrasQueNoFormanParte;
                        $resultadoPalabraLetrasCorrectasUno = implode(" ", $palabraCoincidente);
                        $resultadoPalabraLetrasIncorrectasUno = [];
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraUno = $arrayLetrasQueLeFaltaronALaPalabraUno;

                        
                    }
                    elseif($nroLetrasPalabraCorrectaUno > $nroLetrasPalabraUsuarioUno){
                        //SI EL NUMERO DE LETRAS DE LA PALABRA CORRECTA ES MAYOR QUE EL NUMERO DE LETRAS DE LA PALABRA DEL USUARIO
                        //SIGNIFICA QUEE EL USUARIO AGREGO MENOS LETRAS O CARACTERES DE LOS QUE SE NECESITAN
                        //CASO 2.3. QUE LA CADENA TENGA MENOS CARACTERES QUE LA PALABRA CORRECTA

                        //SI LA PALABRA DEL USUARIO TIENE MENOS LETRAS QUE LA PALABRA CORRECTA, AL FINAL DE LA PALABRA SE AGREGAN LAS LETRAS
                        //QUE FALTEN PARA COMPLETAR EL NUMERO DE LETRAS QUE TIENE LA PALABRA CORRECTA Y PODER COMPARARLAS
                        //CALCULAR CON CUANTAS LETRAS HAY QUE LLENAR LA PALABRA DEL USUARIO RESTANDO EL NUMERO DE LETRAS DE LA PALABRA CORRECTA
                        //CON LAS LETRAS DE LA PALABRA DEL USUARIO
                        
                        //DE LAS PALABRA DEL USUARIO VER QUE LETRAS SI PERTENECEN A LA PALABRA CORRECTA
                        //SE CREAN DOS ARRAYS PARA GUARDAR LAS LETRAS DE LA RESPUESTA DEL USUARIO SEGUN CORRESPONDA
                        $letrasQueSiCoinciden = [];
                        $letrasQueNoCoinciden = [];
                        //EN EL ARRAY PALABRAFINAL SE GUARDA LA PALABRA CORRECTA CON LAS LETRAS DE LA RESPUESTA DEL USUARIO QUE SI VAN EN LA PALABRA
                        $palabraFinal = [];

                        //CON UN FOR SE RECORRE LAS LETRAS QUE TIENEN LA RESPUESTA DEL USUARIO
                        //IMPORTANTE
                        //SI EN ALGUN LADO DA ERROR, SE PUEDE PROBAR CAMBIANDO EN EL FOR EN LUGAR DE NROLETRASPALABRAUSUARIOUNO
                        //POR NROLETRASPALABRACORRECTAUNO ASI NO SE DESBORDA EL ARRAY 
                        //Y EN EL IF SE CAMBIA EL ANALISIS, EN LUGAR DE BUSCAR EN ARRAYPALABRAUSUARIO[$I] QUE SE BUSQUE
                        //EN ARRAYPALABRACORRECTAUNO[$I] Y ARRAYPALABRAUSUARIOUNO PASA A SER EL ARRAY DONDE SE COMPRUEBA QUE ESTE
                        //UNA LETRA EN ESPECIFICO, ES DECIR, CAMBIAN DE LUGAR
                        for($l=0; $l<$nroLetrasPalabraUsuarioUno; $l++){
                            //CON EL IF SE PREGUNTA SI LA LETRA DE LA PALABRA DEL USUARIO EN X POSICION COINCIDE CON ALGUNA LETRA
                            //DE LA PALABRA CORRECTA, SI ES ASI ENTONCES ESA LETRA SE GUARDA EN EL ARRAY DE LETRASQUESICOINCIDEN
                            //SI NO ES ASI, LA LETRA SE GUARDA EN EL ARRAY DE LETRAS QUE NO COINCIDEN
                            if(in_array($arrayPalabraUsuarioUno[$l], $arrayPalabraCorrectaUno)){
                                array_push($letrasQueSiCoinciden, $arrayPalabraUsuarioUno[$l]);
                            }else{
                                array_push($letrasQueNoCoinciden, $arrayPalabraUsuarioUno[$l]);
                            }
            
                        }

                        //EL ARRAY LETRAS QUE SI COINCIDEN PUEDE TENER LETRAS REPETIDAS, HAY QUE BUSCAR LA FORMA 
                        //DE QUE SOLO GUARDE UNA LETRA Y NO LETRAS REPETIDAS

                        //CON EL FOR SE RECORRE EL ARRAY DE LA PALABRA CORRECTA
                        for($f=0; $f<$nroLetrasPalabraCorrectaUno; $f++){
                            //CON EL IF SE PREGUNTA SI EN LA LETRA X DEL ARRAY QUE CONTIENE LAS LETRAS DE LA PALABRA CORRECTA
                            //COINCIDE CON ALGUNA LETRA DEL ARRAY LETRAS QUE SI COINCIDEN
                            //SI ES ASI, ENTONCES EN EL ARRAY PALABRAFINAL, SE GUARDA ESA LETRA EN LA POSICION DE LA PALABRA CORRECTA
                            //SI NO ES ASI, EN LA POSICION DE LA LETRA ACTUAL DE LA PALABRA CORRECTA SE PONE UNA RAYA
                            if(in_array($arrayPalabraCorrectaUno[$f], $letrasQueSiCoinciden)){
                                array_push($palabraFinal, $arrayPalabraCorrectaUno[$f]);
                            }
                            else{
                                array_push($palabraFinal, '_');
                            }
                        }


                        //ACTUALIZACION
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA OPCION CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraUno = [];
                        for($t=0; $t<$nroLetrasPalabraCorrectaUno; $t++){
                            if(!in_array($arrayPalabraCorrectaUno[$t], $arrayPalabraUsuarioUno)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraUno, $arrayPalabraCorrectaUno[$t]);
                            }
                        }

                        //UNA VEZ TENIENDO LOS DATOS LISTOS, SE PROCEDE A CAMBIAR LOS ARRAY A STRINGS PARA ENVIARLOS A LA VISTA
                        //$resultadoLetrasIncorrectasUno = implode("", $letrasQueNoCoinciden);
                        //$resultadoLetrasBienColocadasUno = implode(", ", $letrasQueSiCoinciden);
                        //$resultadoLetrasMalColocadasUno = implode(", ", $letrasQueNoCoinciden);
                        //$resultadoPalabraLetrasCorrectasUno = implode(" ", $palabraFinal);
                        //$resultadoPalabraLetrasIncorrectasUno = "Las letras incorrectas de su respuesta no van en la palabra.";
                        $respuestaCasoUno = "Su respuesta tiene menos letras de las que debería.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCODASUNO SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasUno = $letrasQueNoCoinciden;
                        $resultadoLetrasBienColocadasUno = implode(", ", array_unique($letrasQueSiCoinciden));
                        $resultadoLetrasMalColocadasUno = $letrasQueNoCoinciden;
                        $resultadoPalabraLetrasCorrectasUno = implode(" ", $palabraFinal);
                        $resultadoPalabraLetrasIncorrectasUno = [];
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraUno = $arrayLetrasQueLeFaltaronALaPalabraUno;

                    }
                }
            }


            //COMPROBACION PALABRA DOS
            
            //VARIABLES GLOBALES PARA ANALIZAR CADA PALABRA
            //PALABRA DOS
            $letrasIncorrectasDos = [];
            $letrasBienColocadasDos = [];
            $letrasMalColocadasDos = [];
            $palabraLetrasCorrectasDos = [];
            $palabraLetrasIncorrectasDos = [];

            $arrayPalabrasDos = [];

            //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIAN COMO STRING Y LOS DEMAS COMO ARRAY
            $resultadoLetrasIncorrectasDos = [];
            $resultadoLetrasBienColocadasDos = "";
            $resultadoLetrasMalColocadasDos = [];
            $resultadoPalabraLetrasCorrectasDos = "";
            $resultadoPalabraLetrasIncorrectasDos = [];
            //ACTUALIZACION SE AGREGA EL ARRAY RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO
            $resultadoSeccionesQueLeFaltaronALaPalabraDos = [];

            //COMPROBACIO PALABRA DOS
            //PRIMERO SE DEBE COMPROBAR SI LAS PALABRAS SON IGUALES, ES DECIR, SI SON CORRECTAS O INCORRECTAS
            $comparacionDos = strcmp($palabraCorrectaDos, $palabraUsuarioDos);

            //CON EL IF SE PREGUNTA SI LA COMPARACION ES IGUAL A 0, ES DECIR, SI SON IGUALES. O ES DIFERENTE DE 0, ES DECIR,
            //LA PALABRA DEL USUARIO ES INCORRECTA
            if($comparacionDos === 0){
                //SI ES IGUAL A CERO, LA PALABRA DEL USUARIO ES CORRECTA
                $respuestaCasoDos = "Su respuesta a la segunda palabra es correcta.";

                //COMO EN EL COMPACT SIEMPRE TIENEN QUE IR LOS 5 STRING QUE SON LOS RESULTADOS DE LOS 5 ARRAYS, EN ESTE CASO SE ENVIA LO SIGUENTE
                //$resultadoLetrasIncorrectasDos = "La palabra no tiene letras incorrectas";
                //$resultadoLetrasBienColocadasDos = "Todas sus letras están en el orden correcto.";
                //$resultadoLetrasMalColocadasDos = "La palabra no tiene letras incorrectas";
                //$resultadoPalabraLetrasCorrectasDos = $palabraCorrectaDos;
                //$resultadoPalabraLetrasIncorrectasDos = "No hay letras incorrectas.";

                //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                $resultadoLetrasIncorrectasDos = [];
                //SI LA RESPUESTA ES CORRECTA ENTONCES LA SIGUIENTE VARIABLE VA VACIA
                //$resultadoLetrasBienColocadasDos = "Tu respuesta no tiene elementos incorrectos.";
                $resultadoLetrasBienColocadasDos = "";
                $resultadoLetrasMalColocadasDos = [];
                //SI LA RESPUESTA ES CORRECTA ENTONCES LA SIGUIENTE VARIABLE VA VACIA
                //$resultadoPalabraLetrasCorrectasDos = $palabraUsuarioDos;
                $resultadoPalabraLetrasCorrectasDos = "";
                $resultadoPalabraLetrasIncorrectasDos = [];
                //ACTUALIZACION SE AGREGO ESTE NUEVO ARRAY
                $resultadoSeccionesQueLeFaltaronALaPalabraDos = [];
            }
            else{
                //SI ES DIFERENTE DE 0, LA PALABRA DEL USUARIO ES INCORRECTA
                //HAY DOS CASOS PRINCIPALES PARA QUE UNA PALABRA ESTE MAL
                //1. QUE LA CADENA INGRESADA TENGA MAS DE UN PALABRA
                //2. QUE LA CADENA TENGA UNA SOLA PALABRA O CONJUNTO DE CARACTERES Y DE AHI SE DESPRENDEN 3 SUBCASOS

                //1. SI LA CADENA INGRESADA TIENE MAS DE UNA PALABRA HACER LO SIGUENTE:
                //EL METODO EXPLODE SIRVE PARA SEPARAR PALABRAS DE UN STRING MEDIANTE UN ESPACIO Y GUARDA LAS PALABRAS EN UN ARRAY,
                //POR LO QUE HAY QUE CONTAR SI EN EL ARRAY HAY UNA O MAS PALABRAS
                $arrayPalabrasDos = explode(' ', $palabraUsuarioDos);
                //DEL ARRAY, CONTAR EL NUMERO DE PALABRAS QUE TIENE
                $numeroPalabrasDos = count($arrayPalabrasDos);

                //CON EL IF SE PREGUNTA SI HAY DOS PALABRAS O MAS
                if($numeroPalabrasDos>1){

                    //SI HAY DOS O MAS PALABRAS SOLO DEVUELVE LOS RESULTADOS Y NO HACE NINGÚN ANÁLISIS
                    //$resultadoLetrasIncorrectasDos = "Su respuesta tiene más de un elemento o palabra.";
                    //$resultadoLetrasBienColocadasDos = "Hay más de un elemento o palabra.";
                    //$resultadoLetrasMalColocadasDos = $palabraUsuarioDos;
                    //$resultadoPalabraLetrasCorrectasDos = "No se admiten dos o más elementos o palabras.";
                    //$resultadoPalabraLetrasIncorrectasDos = $palabraUsuarioDos;
                    $respuestaCasoDos = "Respuesta incorrecta, no se puede agregar más de una palabra.";

                    //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                    $resultadoLetrasIncorrectasDos = [];
                    //SI LA RESPUESTA TIENE DOS PALABRAS ENTONCES ESTA VARIABLE VA VACIA
                    //$resultadoLetrasBienColocadasDos = "Resultado Incorrecto, hay más de una palabra.";
                    $resultadoLetrasBienColocadasDos = "";
                    $resultadoLetrasMalColocadasDos = [];
                    //$resultadoPalabraLetrasCorrectasDos = "No se admite más de una palabra.";
                    $resultadoPalabraLetrasCorrectasDos = "";
                    $resultadoPalabraLetrasIncorrectasDos = [];
                    //ACTUALIZACION
                    $resultadoSeccionesQueLeFaltaronALaPalabraDos = [];

                }else{
                    //SI HAY SOLO UNA PALABRA ABARCA EL CASO 2 Y SUS 3 OPCIONES
                    //2.1. QUE LA CADENA TENGA IGUAL NUMERO DE CARACTERES PERO QUE NO SEAN LOS MISMOS EN CADA POSICION
                    //2.2. QUE LA CADENA TENGA MENOS CARACTERES QUE LA PALABRA CORRECTA
                    //2.3. QUE LA CADENA TENGA MAS CARACTERES QUE LA PALABRA CORRECTA

                    //PARA SABER QUE CASO CONVIENE A CADA PALABRA, HAY QUE CONTAR CUANTOS CARACTEREES HAY EN EL STRING
                    //DE LA PALABRA CORRECTA Y EL STRING DE LA RESPUESTA DEL USUARIO
                    //CON EL METODO MB_STRLEN SE CUENTA EL NUMERO DE CARACTERES QUE TIENE LA RESPUESTA DEL USUARIO 
                    //ESTE METODO TOMA EN CUENTA LOS ESPACIOS QUE SE DEJA AL INICIO, AL FINAL Y ENTRE EL ENUNCIADO, POR ESO
                    //A LAS PALABRAS CORRECTAS Y RESPUESTAS SE LES APLICO EL METODO TRIM
                    $nroLetrasPalabraUsuarioDos = mb_strlen($palabraUsuarioDos, 'UTF-8');
                    $nroLetrasPalabraCorrectaDos = mb_strlen($palabraCorrectaDos, 'UTF-8');
                    //SE DEBE HACER UN ARRAY DE LA PALABRA DEL USUARIO COMO DE LA PALABRACORRECTA PARA POSTERIORMENTE COMPROBAR LETRA A LETRA
                    $arrayPalabraUsuarioDos = mb_str_split($palabraUsuarioDos);
                    $arrayPalabraCorrectaDos = mb_str_split($palabraCorrectaDos);

                    //CON EL IF SE PREGUNTA SI LA PALABRA TIENE IGUAL NUMERO DE CARACTERES, SI TIENE MAS O MENOS CARACTERES
                    //Y SE ANALIZA SEGUN SEA EL CASO
                    if($nroLetrasPalabraCorrectaDos === $nroLetrasPalabraUsuarioDos){
                        //SI EL NUMERO DE LETRAS DE LA PALABRA CORRECTA ES IGUAL AL NUMERO DE LETRAS DE LA PALABRA DEL USUARIO SE INGRESA AL CASO UNO
                        //2.1. QUE LA CADENA TENGA IGUAL NUMERO DE CARACTERES PERO QUE NO SEAN LOS MISMOS EN CADA POSICION

                        //CON UN FOR SE ANALIZA EN BASE A LA PALABRA CORRECTA, LAS LETRAS DE LA PALABRA DEL USUARIO QUE NO COINCIDAN CON LAS LETRAS DE LA PALABRA CORRECTA
                        //EN X POSICION, AQUI TAMBIEN SE CAPTURAN, SIGNOS, SIMBOLOS QUE NO COINCIDAN CON LA PALABRA CORRECTA Y SE ALMACENAN EN EL ARRAY LETRAS INCORRECTASDOS
                        for($a=0; $a<$nroLetrasPalabraUsuarioDos; $a++){
                            //CON EL IF SE PREGUNTA SI LA LETRA DE LA RESPUESTA CORRECTA EN X POSICION ES DIFERENTE A LA LETRA DEL USUARIO EN LA MISMA POSICION
                            //SI SE CUMPLE LA CONDICION ENTONCES EN EL ARRAY LETRASINCORRECTADOS, SE GUARDA LA LETRA INCORRECTA DE LA PALABRA DEL USUARIO
                            if($arrayPalabraCorrectaDos[$a] !== $arrayPalabraUsuarioDos[$a]){
                                array_push($letrasIncorrectasDos, $arrayPalabraUsuarioDos[$a]);
                            }
                        }

                        //AHORA QUE EN EL ARRAY LETRASINCORRECTASDOS SE TIENEN LAS LETRAS DE LA PALABRA DEL USUARIO QUE ESTAN MAL
                        //SE CREAN DOS ARRAY MAS, UNO PARA CONTENER LAS LETRAS ERRONEAS PERO QUE SI ESTAN EN ALGUN LUGAR DE LA PALABRA
                        //Y OTRO PARA COLOCAR LAS LETRAS O CARACTERES QUE NO TIENEN RELACION CON LA PALABRA CORRECTA
                        //ADEMAS HAY QUE CONTAR EL NUMERO DE LETRAS QUE TIENE EL ARRAY LETRAS INCORRECTASDOS
                        $nroLetrasIncorrectasDos = count($letrasIncorrectasDos);

                        //CON UN FOR SE RECORREN LA PALABRA CORRECTA Y LA PALABRA DEL USUARIO Y SE VAN LLENANDO LOS ARRAYS PARA ENVIARLOS
                        //A LA VISTA CON LAS PALABRAS QUE NECESITAN
                        //ESTE FOR SIRVE PARA MOSTRAR AL USUARIO LAS LETRAS QUE PUSO CORRECTAMENTE EN LA PALABRA Y LLENAR TAMBIEN 
                        //LOS ARRAY DE LETRASBIENCOLOCADASDOS Y LETRASMALCOLOCADASDOS
                        for($c=0; $c<$nroLetrasPalabraCorrectaDos; $c++){
                            if(strncmp($arrayPalabraCorrectaDos[$c], $arrayPalabraUsuarioDos[$c], $c+1) === 0){
                                array_push($palabraLetrasCorrectasDos, $arrayPalabraUsuarioDos[$c]);
                                array_push($letrasBienColocadasDos, $arrayPalabraUsuarioDos[$c]);
                            }
                            else{
                                array_push($palabraLetrasCorrectasDos, '_');
                                array_push($letrasMalColocadasDos, $arrayPalabraUsuarioDos[$c]);
                            }
                        }

                        //ESTE FOR SIRVE PARA MOSTRAR AL USUARIO LAS LETRAS INCORRECTAS DE SU RESPUESTA
                        for($d=0; $d<$nroLetrasPalabraCorrectaDos; $d++){
                            if(strncmp($arrayPalabraCorrectaDos[$d], $arrayPalabraUsuarioDos[$d], $d+1) !== 0){
                                array_push($palabraLetrasIncorrectasDos, $arrayPalabraUsuarioDos[$d]);
                            }
                            else{
                                array_push($palabraLetrasIncorrectasDos, '_');
                            }
                        }


                        //ACTUALIZACION
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA OPCION CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraDos = [];
                        for($t=0; $t<$nroLetrasPalabraCorrectaDos; $t++){
                            if(!in_array($arrayPalabraCorrectaDos[$t], $arrayPalabraUsuarioDos)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraDos, $arrayPalabraCorrectaDos[$t]);
                            }
                        }

                        //UNA VEZ TENIENDO TODOS LOS DATOS LISTOS, SE PROCEDE A CAMBIAR LOS ARRAYS A STRINGS PARA ENVIARLOS A LA VISTA
                        //$resultadoLetrasIncorrectasDos = implode("", $letrasIncorrectasDos);
                        //$resultadoLetrasBienColocadasDos = implode(",", $letrasBienColocadasDos);
                        //$resultadoLetrasMalColocadasDos = implode(",", $letrasMalColocadasDos);
                        //$resultadoPalabraLetrasCorrectasDos = implode(" ", $palabraLetrasCorrectasDos);
                        //$resultadoPalabraLetrasIncorrectasDos = implode(" ", $palabraLetrasIncorrectasDos);
                        $respuestaCasoDos = "Su respuesta es incorrecta.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCODASDOS SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasDos = $letrasIncorrectasDos;
                        $resultadoLetrasBienColocadasDos = implode(", ", array_unique($letrasBienColocadasDos));
                        $resultadoLetrasMalColocadasDos = $letrasMalColocadasDos;
                        $resultadoPalabraLetrasCorrectasDos = implode(" ", $palabraLetrasCorrectasDos);
                        $resultadoPalabraLetrasIncorrectasDos = $palabraLetrasIncorrectasDos;
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraDos = $arrayLetrasQueLeFaltaronALaPalabraDos;

                    }
                    elseif($nroLetrasPalabraCorrectaDos < $nroLetrasPalabraUsuarioDos){
                        //SI EL NUMERO DE LETRAS DE LA PALABRA CORRECTA ES MENOR QUE EL NUMERO DE LETRAS DE LA PALABRA DEL USUARIO
                        //SIGNIFICA QUE EL USUARIO AGREGO MAS LETRAS O CARACTERES DE LAS QUE NECESITABA
                        //CASO 2.2. QUE LA CADENA TENGA MAS CARACTERES QUE LA PALABRA CORRECTA

                        //DE LAS LETRAS QUE TIENE EL USUARIO VER QUE LETRAS SI PERTENECEN A LA PALABRA CORRECTA
                        //SE CREAN DOS ARRAYS PARA GUARDAR LAS LETRAS DE LA RESPUESTA DEL USUARIO SEGUN CORRESPONDA
                        $letrasQueSiFormanParteDos = [];
                        $letrasQueNoFormanParteDos = [];
                        //SE CREA UN ARRAY QUE CONTIENE LA PALABRA CON LAS LETRAS QUE SI COINCIDEN DE LA RESPUESTA DEL USUARIO
                        $palabraCoincidenteDos = [];

                        //CON UN FOR SE RECORRE LAS LETRAS QUE TIENEN LA RESPUESTA DEL USUARIO
                        //IMPORTANTE
                        //SI EN ALGUN LADO DA ERROR, SE PUEDE PROBAR CAMBIANDO EN EL FOR EN LUGAR DE NROLETRASPALABRAUSUARIODOS
                        //POR NROLETRASPALABRACORRECTADOS Y ASI NO SE DESBORDA EL ARRAY
                        //Y EN EL IF SE CAMBIA EL ANALISIS, EN LUGAR DE BUSCAR ARRAYPALABRAUSUARIODOS[$I] QUE SE BUSQUEE
                        //EN ARRAYPALABRACORRECTADOS[$I] Y ARRAYPALABRAUSUARIODOS PASA A SER EL ARRAY DONDE SE COMPRUEBA QUE ESTÉ
                        //UNA LETRA EN ESPECIFICO, ES DECIR, CAMBIAN DE LUGAR.
                        for($g=0; $g<$nroLetrasPalabraUsuarioDos; $g++){
                            //CON EL IF SE PREGUNTA SI LA LETRA DE LA PALABRA DEL USUARIO EN X POSICION COINCIDE CON ALGUNA LETRA 
                            //DE LA PALABRA CORRECTA, SI ES ASI ENTONCES ESA LETRA SE GUARDA EN EL ARRAY DE LETRAS QUESIFORMANPARTEDOS
                            //SI NO ES ASI, LA LETRA SE GUARDA EN EL ARRAY DE LETRASQUENOFORMANPARTEDOS
                            if(in_array($arrayPalabraUsuarioDos[$g], $arrayPalabraCorrectaDos)){
                                array_push($letrasQueSiFormanParteDos, $arrayPalabraUsuarioDos[$g]);
                            }
                            else{
                                array_push($letrasQueNoFormanParteDos, $arrayPalabraUsuarioDos[$g]);
                            }
                        }


                        //EN EL ARRAY LETRASQUESIFORMANPARTE PUEDEN TENER LETRAS REPETIDAS, HAY QUEE BUSCAR LA FORMA
                        //DE QUE SOLO GUARDE UNA LETRA Y NO LETRAS REPETIDAS

                        //CON EL FOR SE RECORRE EL ARRAY DE LA PALABRA CORRECTA
                        for($k=0; $k<$nroLetrasPalabraCorrectaDos; $k++){
                            //CON EL IF SE PREGUNTA SI EN LA LETRA X DEL ARRAY QUE CONTIENEE LAS LETRAS DE LA PALABRA CORRECTA
                            //COINCIDE CON ALGUNA LETRA DELE ARRAY DE LETRAS QUE SI FORMAN PARTE
                            //SI ES ASI, ENTONCES EN EL ARRAY PALABRACOINCIDENTEDOS, SE GUARDA ESA LETRA EN LA POSICION DE LA PALABRA CORRECTA
                            //SI NO ES ASI, EN LA POSICION DE LA LETRA ACTUAL DE LA PALABRA CORRECTA SE PONE UNA RAYA
                            if(in_array($arrayPalabraCorrectaDos[$k], $letrasQueSiFormanParteDos)){
                                array_push($palabraCoincidenteDos, $arrayPalabraCorrectaDos[$k]);
                            }
                            else{
                                array_push($palabraCoincidenteDos, '_');
                            }
                        }


                        //ACTUALIZACION     
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA RESPUESTA CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraDos = [];
                        for($f=0; $f<$nroLetrasPalabraCorrectaDos; $f++){
                            if(!in_array($arrayPalabraCorrectaDos[$f], $arrayPalabraUsuarioDos)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraDos, $arrayPalabraCorrectaDos[$f]);
                            }
                        }

                        //UNA VEZ TENIENDO LOS DATOS LISTOS, SE PROCEDE A CAMBIAR LOS ARRAY A STRING PARA ENVIARLOS A LA VISTA
                        //$resultadoLetrasIncorrectasDos = implode("", $letrasQueNoFormanParteDos);
                        //$resultadoLetrasBienColocadasDos = implode(", ", $letrasQueSiFormanParteDos);
                        //$resultadoLetrasMalColocadasDos = implode(", ", $letrasQueNoFormanParteDos);
                        //$resultadoPalabraLetrasCorrectasDos = implode(" ", $palabraCoincidenteDos);
                        //$resultadoPalabraLetrasIncorrectasDos = "Las letras incorrectas de su respuesta no van en la palabra.";
                        $respuestaCasoDos = "Su respuesta es incorrecta. Tiene más letras o caracteres de los necesarios.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCODASDOS SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasDos = $letrasQueNoFormanParteDos;
                        $resultadoLetrasBienColocadasDos = implode(", ", array_unique($letrasQueSiFormanParteDos));
                        $resultadoLetrasMalColocadasDos = $letrasQueNoFormanParteDos;
                        $resultadoPalabraLetrasCorrectasDos = implode(" ", $palabraCoincidenteDos);
                        $resultadoPalabraLetrasIncorrectasDos = [];
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraDos = $arrayLetrasQueLeFaltaronALaPalabraDos;
                    
                    }
                    elseif($nroLetrasPalabraCorrectaDos > $nroLetrasPalabraUsuarioDos){
                        //SI EL NUMERO DE LETRAS DE LA PALABRA CORRECTA ES MAYOR QUE EL NUMERO DE LETRAS DE LA PALABRA DEL USUARIO
                        //SIGNIFICA QUE EL USUARIO AGREGO MENOS LETRAS O CARACTERES DE LOS QUE SE NECESITAN
                        //CASO 2.3. QUE LA CADENA TENGA MENOS CARACTERES QUEE LA PALABRA CORRECTA

                        //DE LA PALABRA DEL USUARIO VER QUE LETRAS SI PERTENECEN A LA PALABRA CORRECTA
                        //SE CREAN DOS ARRAY PARA GUARDAR LAS LETRAS DE LA RESPUESTA DEL USUARIO SEGUN CORRESPONDA
                        $letrasQueSiCoincidenDos = [];
                        $letrasQueNoCoincidenDos = [];
                        //EN EL ARRAY PALABRAFINALDOS SE GUARDA LA PALABRA CORRECTA CON LAS LETRAS DE LA RESPUESTA DEL USUARIO QUE SI VAN EN LA
                        //PALABRA CORRECTA
                        $palabraFinalDos = [];

                        //CON UN FOR SE RECORREE LAS LETRAS QUE TIENEN LA RESPUESTA DEL USUARIO
                        //IMPORTANTE
                        //SI EN ALGUN LADO DA ERROR, SE PUEDE PROBAR CAMBIANDO EN EL FOR EN LUGAR DE NROLETRASPALABRAUSUARIODOS
                        //POR NROLETRASPALABRACORRECTADOS ASI NO SE DESBORDA EL ARRAY
                        //Y EN EL IF SE CAMBIA EL ANALISIS, EN LUGAR DE BUSCAR EN ARRAYPALABRAUSUARIO[$I] QUE SE BUSQUE
                        //EN ARRAYPALABRACORRECTADOS[$I] Y ARRAYPALABRAUSUARIODOS PASA A SER EL ARRAY DONDE SE COMPRUEBA QUE ESTE
                        //UNA LETRA EN ESPECIFICO, ES DECIR, CAMBIAN DE LUGAR
                        for($h=0; $h<$nroLetrasPalabraUsuarioDos; $h++){
                            //CON EL IF SE PREGUNTA SI LA LETRA DE LA PALABRA DEL USUARIO EN X POSICION COINCIDE CON ALGUNA LETRA
                            //DE LA PALABRA CORRECTA, SI ES ASI ENTONCES ESA LETRA SE GUARDA EN EL ARRAY DE LETRASQUESICOINCIDENDOS
                            //SI NO ES ASI, LA LETRA SE GUARDA ENE EL ARRAY DE LETRAS QUE NO COINCIDEN
                            if(in_array($arrayPalabraUsuarioDos[$h], $arrayPalabraCorrectaDos)){
                                array_push($letrasQueSiCoincidenDos, $arrayPalabraUsuarioDos[$h]);
                            }
                            else{
                                array_push($letrasQueNoCoincidenDos, $arrayPalabraUsuarioDos[$h]);
                            }
                        }

                        //EL ARRAY LETRAS QUE SI COINCIDEN PUEDE TENER LETRAS REPETIDAS, HAY QUE BUSCAR LA FORMA
                        //DE QUE SOLO GUARDE UNA LETRA Y NO LETRAS REPETIDAS

                        //CON EL FOR SE RECORRE EL ARRAY DE LA PALABRA CORRECTA
                        for($j=0; $j<$nroLetrasPalabraCorrectaDos; $j++){
                            //CON EL IF SE PREGUNTA SI EN LA LETRA X DEL ARRAY QUE CONTIENE LAS LETRAS DE LA PALABRA CORRECTA
                            //COINCIDE CON ALGUNA LETRA DEL ARRAY LETRAS QUE SI COINCIDEN
                            //SI ES ASI, ENTONCES EN EL ARRAY PALABRAFINALDOS, SE GUARDA ESA LETRA EN LA POSICION DE LA PALABRA CORRECTA
                            //SI NO ES ASI, EN LA POSICION DE LA LETRA ACTUAL DE LA PALABRA CORRECTA SE PONE UNA RAYA
                            if(in_array($arrayPalabraCorrectaDos[$j], $letrasQueSiCoincidenDos)){
                                array_push($palabraFinalDos, $arrayPalabraCorrectaDos[$j]);
                            }
                            else{
                                array_push($palabraFinalDos, '_');
                            }
                        }


                        //ACTUALIZACION
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA OPCION CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraDos = [];
                        for($t=0; $t<$nroLetrasPalabraCorrectaDos; $t++){
                            if(!in_array($arrayPalabraCorrectaDos[$t], $arrayPalabraUsuarioDos)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraDos, $arrayPalabraCorrectaDos[$t]);
                            }
                        }

                        //UNA VEZ TENIENDO LOS DATOS LISTOS, SE PROCEDE A CAMBIAR LOS ARRAY A STRINGS PARA ENVIARLOS A LA VISTA
                        //$resultadoLetrasIncorrectasDos = implode("", $letrasQueNoCoincidenDos);
                        //$resultadoLetrasBienColocadasDos = implode(", ", $letrasQueSiCoincidenDos);
                        //$resultadoLetrasMalColocadasDos = implode(", ", $letrasQueNoCoincidenDos);
                        //$resultadoPalabraLetrasCorrectasDos = implode(" ", $palabraFinalDos);
                        //$resultadoPalabraLetrasIncorrectasDos = "Las letras incorrectas de su respuesta no van en la palabra.";
                        $respuestaCasoDos = "Su respuesta tiene menos letras de las que debería.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCODASDOS SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasDos = $letrasQueNoCoincidenDos;
                        $resultadoLetrasBienColocadasDos = implode(", ", array_unique($letrasQueSiCoincidenDos));
                        $resultadoLetrasMalColocadasDos = $letrasQueNoCoincidenDos;
                        $resultadoPalabraLetrasCorrectasDos = implode(" ", $palabraFinalDos);
                        $resultadoPalabraLetrasIncorrectasDos = [];
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraDos = $arrayLetrasQueLeFaltaronALaPalabraDos;

                    }
                }
            }


            //COMPROBACION PALABRA TRES

            $letrasIncorrectasTres = [];
            $letrasBienColocadasTres = [];
            $letrasMalColocadasTres = [];
            $palabraLetrasCorrectasTres = [];
            $palabraLetrasIncorrectasTres = [];

            $arrayPalabrasTres = [];


            //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIAN COMO STRINGS Y LAS DEMAS COMO ARRAY
            $resultadoLetrasIncorrectasTres = [];
            $resultadoLetrasBienColocadasTres = "";
            $resultadoLetrasMalColocadasTres = [];
            $resultadoPalabraLetrasCorrectasTres = "";
            $resultadoPalabraLetrasIncorrectasTres = [];
            //ACTUALIZACION SE AGREGA EL ARRAY RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO
            $resultadoSeccionesQueLeFaltaronALaPalabraTres = [];


            $comparacionTres = strcmp($palabraCorrectaTres, $palabraUsuarioTres);

            if($comparacionTres === 0){
                
                $respuestaCasoTres = "Su respuesta a la tercera palabra es correcta.";

                
                //$resultadoLetrasIncorrectasTres = "La palabra no tiene letras incorrectas";
                //$resultadoLetrasBienColocadasTres = "Todas sus letras están en el orden correcto.";
                //$resultadoLetrasMalColocadasTres = "La palabra no tiene letras incorrectas";
                //$resultadoPalabraLetrasCorrectasTres = $palabraCorrectaTres;
                //$resultadoPalabraLetrasIncorrectasTres = "No hay letras incorrectas.";

                //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRACORRECTAS SE ENVIA COMO STRING
                $resultadoLetrasIncorrectasTres = [];
                //SI LA RESPUESTA ES CORRECTA ENTONCES LA SIGUIENTE VARIABLE VA VACIA
                //$resultadoLetrasBienColocadasTres = "Tu respuesta no tiene elementos incorrectos.";
                $resultadoLetrasBienColocadasTres = "";
                $resultadoLetrasMalColocadasTres = [];
                //SI LA RESPUESTA ES CORRECTA ENTONCES LA SIGUIENTE VARIABLE VA VACIA
                //$resultadoPalabraLetrasCorrectasTres = $palabraUsuarioTres;
                $resultadoPalabraLetrasCorrectasTres = "";
                $resultadoPalabraLetrasIncorrectasTres = [];
                //ACTUALIZACION SE AGREGO ESTE NUEVO ARRAY
                $resultadoSeccionesQueLeFaltaronALaPalabraTres = [];


            }else{

                $arrayPalabrasTres = explode(' ', $palabraUsuarioTres);
                $numeroPalabrasTres = count($arrayPalabrasTres);

                if($numeroPalabrasTres>1){

                    
                    //$resultadoLetrasIncorrectasTres = "Su respuesta tiene más de un elemento o palabra.";
                    //$resultadoLetrasBienColocadasTres = "Hay más de un elemento o palabra.";
                    //$resultadoLetrasMalColocadasTres = $palabraUsuarioTres;
                    //$resultadoPalabraLetrasCorrectasTres = "No se admiten dos o más elementos o palabras.";
                    //$resultadoPalabraLetrasIncorrectasTres = $palabraUsuarioTres;
                    $respuestaCasoTres = "Respuesta incorrecta, no se puede agregar más de una palabra.";

                    //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING
                    $resultadoLetrasIncorrectasTres = [];
                    //SI LA RESPUESTA TIENE DOS PALABRAS ENTONCES ESTA VARIABLE VA VACIA
                    //$resultadoLetrasBienColocadasTres = "Resultado incorrecto, hay más de una palabra.";
                    $resultadoLetrasBienColocadasTres = "";
                    $resultadoLetrasMalColocadasTres = [];
                    //$resultadoPalabraLetrasCorrectasTres = "No se admite más de una palabra.";
                    $resultadoPalabraLetrasCorrectasTres = "";
                    $resultadoPalabraLetrasIncorrectasTres = [];
                    //ACTUALIZACION
                    $resultadoSeccionesQueLeFaltaronALaPalabraTres = [];
                }
                else{

                    $nroLetrasPalabraUsuarioTres = mb_strlen($palabraUsuarioTres, 'UTF-8');
                    $nroLetrasPalabraCorrectaTres = mb_strlen($palabraCorrectaTres, 'UTF-8');

                    $arrayPalabraUsuarioTres = mb_str_split($palabraUsuarioTres);
                    $arrayPalabraCorrectaTres = mb_str_split($palabraCorrectaTres);


                    if($nroLetrasPalabraCorrectaTres === $nroLetrasPalabraUsuarioTres){
                        

                        for($a=0; $a<$nroLetrasPalabraUsuarioTres; $a++){
                            
                            if($arrayPalabraCorrectaTres[$a] !== $arrayPalabraUsuarioTres[$a]){
                                array_push($letrasIncorrectasTres, $arrayPalabraUsuarioTres[$a]);
                            }
                        }

                        
                        $nroLetrasIncorrectasTres = count($letrasIncorrectasTres);

                        
                        for($c=0; $c<$nroLetrasPalabraCorrectaTres; $c++){
                            if(strncmp($arrayPalabraCorrectaTres[$c], $arrayPalabraUsuarioTres[$c], $c+1) === 0){
                                array_push($palabraLetrasCorrectasTres, $arrayPalabraUsuarioTres[$c]);
                                array_push($letrasBienColocadasTres, $arrayPalabraUsuarioTres[$c]);
                            }
                            else{
                                array_push($palabraLetrasCorrectasTres, '_');
                                array_push($letrasMalColocadasTres, $arrayPalabraUsuarioTres[$c]);
                            }
                        }

                        
                        for($d=0; $d<$nroLetrasPalabraCorrectaTres; $d++){
                            if(strncmp($arrayPalabraCorrectaTres[$d], $arrayPalabraUsuarioTres[$d], $d+1) !== 0){
                                array_push($palabraLetrasIncorrectasTres, $arrayPalabraUsuarioTres[$d]);
                            }
                            else{
                                array_push($palabraLetrasIncorrectasTres, '_');
                            }
                        }

                        //ACTUALIZACION
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA OPCION CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraTres = [];
                        for($t=0; $t<$nroLetrasPalabraCorrectaTres; $t++){
                            if(!in_array($arrayPalabraCorrectaTres[$t], $arrayPalabraUsuarioTres)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraTres, $arrayPalabraCorrectaTres[$t]);
                            }
                        }


                        //$resultadoLetrasIncorrectasTres = implode("", $letrasIncorrectasTres);
                        //$resultadoLetrasBienColocadasTres = implode(",", $letrasBienColocadasTres);
                        //$resultadoLetrasMalColocadasTres = implode(",", $letrasMalColocadasTres);
                        //$resultadoPalabraLetrasCorrectasTres = implode(" ", $palabraLetrasCorrectasTres);
                        //$resultadoPalabraLetrasIncorrectasTres = implode(" ", $palabraLetrasIncorrectasTres);
                        $respuestaCasoTres = "Su respuesta es incorrecta.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCODASTRES SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasTres = $letrasIncorrectasTres;
                        $resultadoLetrasBienColocadasTres = implode(",", array_unique($letrasBienColocadasTres));
                        $resultadoLetrasMalColocadasTres = $letrasMalColocadasTres;
                        $resultadoPalabraLetrasCorrectasTres = implode(" ", $palabraLetrasCorrectasTres);
                        $resultadoPalabraLetrasIncorrectasTres = $palabraLetrasIncorrectasTres;
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraTres = $arrayLetrasQueLeFaltaronALaPalabraTres;

                    }
                    elseif($nroLetrasPalabraCorrectaTres < $nroLetrasPalabraUsuarioTres){
                        
                        $letrasQueSiFormanParteTres = [];
                        $letrasQueNoFormanParteTres = [];
                        

                        $palabraCoincidenteTres = [];

                        
                        for($g=0; $g<$nroLetrasPalabraUsuarioTres; $g++){
                            
                            if(in_array($arrayPalabraUsuarioTres[$g], $arrayPalabraCorrectaTres)){
                                array_push($letrasQueSiFormanParteTres, $arrayPalabraUsuarioTres[$g]);
                            }
                            else{
                                array_push($letrasQueNoFormanParteTres, $arrayPalabraUsuarioTres[$g]);
                            }
                        }


                        
                        for($k=0; $k<$nroLetrasPalabraCorrectaTres; $k++){
                            
                            if(in_array($arrayPalabraCorrectaTres[$k], $letrasQueSiFormanParteTres)){
                                array_push($palabraCoincidenteTres, $arrayPalabraCorrectaTres[$k]);
                            }
                            else{
                                array_push($palabraCoincidenteTres, '_');
                            }
                        }

                        //ACTUALIZACION     
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA RESPUESTA CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraTres = [];
                        for($f=0; $f<$nroLetrasPalabraCorrectaTres; $f++){
                            if(!in_array($arrayPalabraCorrectaTres[$f], $arrayPalabraUsuarioTres)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraTres, $arrayPalabraCorrectaTres[$f]);
                            }
                        }

                        
                        //$resultadoLetrasIncorrectasTres = implode("", $letrasQueNoFormanParteTres);
                        //$resultadoLetrasBienColocadasTres = implode(", ", $letrasQueSiFormanParteTres);
                        //$resultadoLetrasMalColocadasTres = implode(", ", $letrasQueNoFormanParteTres);
                        //$resultadoPalabraLetrasCorrectasTres = implode(" ", $palabraCoincidenteTres);
                        //$resultadoPalabraLetrasIncorrectasTres = "Las letras incorrectas de su respuesta no van en la palabra.";
                        $respuestaCasoTres = "Su respuesta es incorrecta. Tiene más letras o caracteres de los necesarios.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCODASTRES SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasTres = $letrasQueNoFormanParteTres;
                        $resultadoLetrasBienColocadasTres = implode(", ", array_unique($letrasQueSiFormanParteTres));
                        $resultadoLetrasMalColocadasTres = $letrasQueNoFormanParteTres;
                        $resultadoPalabraLetrasCorrectasTres = implode(" ", $palabraCoincidenteTres);
                        $resultadoPalabraLetrasIncorrectasTres = [];
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraTres = $arrayLetrasQueLeFaltaronALaPalabraTres;
                    
                    }
                    elseif($nroLetrasPalabraCorrectaTres > $nroLetrasPalabraUsuarioTres){
                        
                        $letrasQueSiCoincidenTres = [];
                        $letrasQueNoCoincidenTres = [];
                        
                        $palabraFinalTres = [];

                        
                        for($h=0; $h<$nroLetrasPalabraUsuarioTres; $h++){
                            
                            if(in_array($arrayPalabraUsuarioTres[$h], $arrayPalabraCorrectaTres)){
                                array_push($letrasQueSiCoincidenTres, $arrayPalabraUsuarioTres[$h]);
                            }
                            else{
                                array_push($letrasQueNoCoincidenTres, $arrayPalabraUsuarioTres[$h]);
                            }
                        }

                        
                        for($j=0; $j<$nroLetrasPalabraCorrectaTres; $j++){
                            
                            if(in_array($arrayPalabraCorrectaTres[$j], $letrasQueSiCoincidenTres)){
                                array_push($palabraFinalTres, $arrayPalabraCorrectaTres[$j]);
                            }
                            else{
                                array_push($palabraFinalTres, '_');
                            }
                        }


                        //ACTUALIZACION
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA OPCION CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraTres = [];
                        for($t=0; $t<$nroLetrasPalabraCorrectaTres; $t++){
                            if(!in_array($arrayPalabraCorrectaTres[$t], $arrayPalabraUsuarioTres)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraTres, $arrayPalabraCorrectaTres[$t]);
                            }
                        }

                        
                        //$resultadoLetrasIncorrectasTres = implode("", $letrasQueNoCoincidenTres);
                        //$resultadoLetrasBienColocadasTres = implode(", ", $letrasQueSiCoincidenTres);
                        //$resultadoLetrasMalColocadasTres = implode(", ", $letrasQueNoCoincidenTres);
                        //$resultadoPalabraLetrasCorrectasTres = implode(" ", $palabraFinalTres);
                        //$resultadoPalabraLetrasIncorrectasTres = "Las letras incorrectas de su respuesta no van en la palabra.";
                        $respuestaCasoTres = "Su respuesta tiene menos letras de las que debería.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCODASTRES SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasTres = $letrasQueNoCoincidenTres;
                        $resultadoLetrasBienColocadasTres = implode(", ", array_unique($letrasQueSiCoincidenTres));
                        $resultadoLetrasMalColocadasTres = $letrasQueNoCoincidenTres;
                        $resultadoPalabraLetrasCorrectasTres = implode(" ", $palabraFinalTres);
                        $resultadoPalabraLetrasIncorrectasTres = [];
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraTres = $arrayLetrasQueLeFaltaronALaPalabraTres;
                    }
                }
            }


            //COMPARACION PALABRA CUATRO

            $letrasIncorrectasCuatro = [];
            $letrasBienColocadasCuatro = [];
            $letrasMalColocadasCuatro = [];
            $palabraLetrasCorrectasCuatro = [];
            $palabraLetrasIncorrectasCuatro = [];

            $arrayPalabrasCuatro = [];

            //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIAN COMO STRINGS Y LAS DEMAS COMO ARRAY
            $resultadoLetrasIncorrectasCuatro = [];
            $resultadoLetrasBienColocadasCuatro = "";
            $resultadoLetrasMalColocadasCuatro = [];
            $resultadoPalabraLetrasCorrectasCuatro = "";
            $resultadoPalabraLetrasIncorrectasCuatro = [];
            //ACTUALIZACION SE AGREGA EL ARRAY RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO
            $resultadoSeccionesQueLeFaltaronALaPalabraCuatro = [];


            $comparacionCuatro = strcmp($palabraCorrectaCuatro, $palabraUsuarioCuatro);

            if($comparacionCuatro === 0){
                
                $respuestaCasoCuatro = "Su respuesta a la cuarta palabra es correcta.";

                
                //$resultadoLetrasIncorrectasCuatro = "La palabra no tiene letras incorrectas";
                //$resultadoLetrasBienColocadasCuatro = "Todas sus letras están en el orden correcto.";
                //$resultadoLetrasMalColocadasCuatro = "La palabra no tiene letras incorrectas";
                //$resultadoPalabraLetrasCorrectasCuatro = $palabraCorrectaCuatro;
                //$resultadoPalabraLetrasIncorrectasCuatro = "No hay letras incorrectas.";

                //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING
                $resultadoLetrasIncorrectasCuatro = [];
                //SI LA RESPUESTA ES CORRECTA ENTONCES LA SIGUIENTE VARIABLE VA VACIA
                //$resultadoLetrasBienColocadasCuatro = "Tu respuesta no tiene elementos incorrectos.";
                $resultadoLetrasBienColocadasCuatro = "";
                $resultadoLetrasMalColocadasCuatro = [];
                //SI LA RESPUESTA ES CORRECTA ENTONCES LA SIGUIENTE VARIABLE VA VACIA
                //$resultadoPalabraLetrasCorrectasCuatro = $palabraUsuarioCuatro;
                $resultadoPalabraLetrasCorrectasCuatro = "";
                $resultadoPalabraLetrasIncorrectasCuatro = [];
                //ACTUALIZACION SE AGREGO ESTE NUEVO ARRAY
                $resultadoSeccionesQueLeFaltaronALaPalabraCuatro = [];

            }
            else{

                $arrayPalabrasCuatro = explode(' ', $palabraUsuarioCuatro);
                $numeroPalabrasCuatro = count($arrayPalabrasCuatro);

                if($numeroPalabrasCuatro>1){

                    
                    //$resultadoLetrasIncorrectasCuatro = "Su respuesta tiene más de un elemento o palabra.";
                    //$resultadoLetrasBienColocadasCuatro = "Hay más de un elemento o palabra.";
                    //$resultadoLetrasMalColocadasCuatro = $palabraUsuarioCuatro;
                    //$resultadoPalabraLetrasCorrectasCuatro = "No se admiten dos o más elementos o palabras.";
                    //$resultadoPalabraLetrasIncorrectasCuatro = $palabraUsuarioCuatro;
                    $respuestaCasoCuatro = "Respuesta incorrecta, no se puede agregar más de una palabra.";

                    //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING
                    $resultadoLetrasIncorrectasCuatro = [];
                    //SI LA RESPUESTA TIENE DOS PALABRAS ENTONCES ESTA VARIABLE VA VACIA
                    //$resultadoLetrasBienColocadasCuatro = "Resultado incorrecto, hay más de una palabra.";
                    $resultadoLetrasBienColocadasCuatro = "";
                    $resultadoLetrasMalColocadasCuatro = [];
                    //$resultadoPalabraLetrasCorrectasCuatro = "No se admite más de una palabra";
                    $resultadoPalabraLetrasCorrectasCuatro = "";
                    $resultadoPalabraLetrasIncorrectasCuatro = [];
                    //ACTUALIZACION
                    $resultadoSeccionesQueLeFaltaronALaPalabraCuatro = [];

                }
                else{

                    $nroLetrasPalabraUsuarioCuatro = mb_strlen($palabraUsuarioCuatro, 'UTF-8');
                    $nroLetrasPalabraCorrectaCuatro = mb_strlen($palabraCorrectaCuatro, 'UTF-8');

                    $arrayPalabraUsuarioCuatro = mb_str_split($palabraUsuarioCuatro);
                    $arrayPalabraCorrectaCuatro = mb_str_split($palabraCorrectaCuatro);


                    if($nroLetrasPalabraCorrectaCuatro === $nroLetrasPalabraUsuarioCuatro){
                        

                        for($a=0; $a<$nroLetrasPalabraUsuarioCuatro; $a++){
                            
                            if($arrayPalabraCorrectaCuatro[$a] !== $arrayPalabraUsuarioCuatro[$a]){
                                array_push($letrasIncorrectasCuatro, $arrayPalabraUsuarioCuatro[$a]);
                            }
                        }

                        
                        $nroLetrasIncorrectasCuatro = count($letrasIncorrectasCuatro);

                        
                        for($c=0; $c<$nroLetrasPalabraCorrectaCuatro; $c++){
                            if(strncmp($arrayPalabraCorrectaCuatro[$c], $arrayPalabraUsuarioCuatro[$c], $c+1) === 0){
                                array_push($palabraLetrasCorrectasCuatro, $arrayPalabraUsuarioCuatro[$c]);
                                array_push($letrasBienColocadasCuatro, $arrayPalabraUsuarioCuatro[$c]);
                            }
                            else{
                                array_push($palabraLetrasCorrectasCuatro, '_');
                                array_push($letrasMalColocadasCuatro, $arrayPalabraUsuarioCuatro[$c]);
                            }
                        }

                        
                        for($d=0; $d<$nroLetrasPalabraCorrectaCuatro; $d++){
                            if(strncmp($arrayPalabraCorrectaCuatro[$d], $arrayPalabraUsuarioCuatro[$d], $d+1) !== 0){
                                array_push($palabraLetrasIncorrectasCuatro, $arrayPalabraUsuarioCuatro[$d]);
                            }
                            else{
                                array_push($palabraLetrasIncorrectasCuatro, '_');
                            }
                        }


                        
                        //ACTUALIZACION
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA OPCION CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraCuatro = [];
                        for($t=0; $t<$nroLetrasPalabraCorrectaCuatro; $t++){
                            if(!in_array($arrayPalabraCorrectaCuatro[$t], $arrayPalabraUsuarioCuatro)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraCuatro, $arrayPalabraCorrectaCuatro[$t]);
                            }
                        }


                        //$resultadoLetrasIncorrectasCuatro = implode("", $letrasIncorrectasCuatro);
                        //$resultadoLetrasBienColocadasCuatro = implode(",", $letrasBienColocadasCuatro);
                        //$resultadoLetrasMalColocadasCuatro = implode(",", $letrasMalColocadasCuatro);
                        //$resultadoPalabraLetrasCorrectasCuatro = implode(" ", $palabraLetrasCorrectasCuatro);
                        //$resultadoPalabraLetrasIncorrectasCuatro = implode(" ", $palabraLetrasIncorrectasCuatro);
                        $respuestaCasoCuatro = "Su respuesta es incorrecta.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCODASCUATRO SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasCuatro = $letrasIncorrectasCuatro;
                        $resultadoLetrasBienColocadasCuatro = implode(",", array_unique($letrasBienColocadasCuatro));
                        $resultadoLetrasMalColocadasCuatro = $letrasMalColocadasCuatro;
                        $resultadoPalabraLetrasCorrectasCuatro = implode(" ", $palabraLetrasCorrectasCuatro);
                        $resultadoPalabraLetrasIncorrectasCuatro = $palabraLetrasIncorrectasCuatro;
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraCuatro = $arrayLetrasQueLeFaltaronALaPalabraCuatro;

                    }
                    elseif($nroLetrasPalabraCorrectaCuatro < $nroLetrasPalabraUsuarioCuatro){
                        
                        $letrasQueSiFormanParteCuatro = [];
                        $letrasQueNoFormanParteCuatro = [];
                        

                        $palabraCoincidenteCuatro = [];

                        
                        for($g=0; $g<$nroLetrasPalabraUsuarioCuatro; $g++){
                            
                            if(in_array($arrayPalabraUsuarioCuatro[$g], $arrayPalabraCorrectaCuatro)){
                                array_push($letrasQueSiFormanParteCuatro, $arrayPalabraUsuarioCuatro[$g]);
                            }
                            else{
                                array_push($letrasQueNoFormanParteCuatro, $arrayPalabraUsuarioCuatro[$g]);
                            }
                        }


                        
                        for($k=0; $k<$nroLetrasPalabraCorrectaCuatro; $k++){
                            
                            if(in_array($arrayPalabraCorrectaCuatro[$k], $letrasQueSiFormanParteCuatro)){
                                array_push($palabraCoincidenteCuatro, $arrayPalabraCorrectaCuatro[$k]);
                            }
                            else{
                                array_push($palabraCoincidenteCuatro, '_');
                            }
                        }


                        //ACTUALIZACION     
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA RESPUESTA CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraCuatro = [];
                        for($f=0; $f<$nroLetrasPalabraCorrectaCuatro; $f++){
                            if(!in_array($arrayPalabraCorrectaCuatro[$f], $arrayPalabraUsuarioCuatro)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraCuatro, $arrayPalabraCorrectaCuatro[$f]);
                            }
                        }

                        
                        //$resultadoLetrasIncorrectasCuatro = implode("", $letrasQueNoFormanParteCuatro);
                        //$resultadoLetrasBienColocadasCuatro = implode(", ", $letrasQueSiFormanParteCuatro);
                        //$resultadoLetrasMalColocadasCuatro = implode(", ", $letrasQueNoFormanParteCuatro);
                        //$resultadoPalabraLetrasCorrectasCuatro = implode(" ", $palabraCoincidenteCuatro);
                        //$resultadoPalabraLetrasIncorrectasCuatro = "Las letras incorrectas de su respuesta no van en la palabra.";
                        $respuestaCasoCuatro = "Su respuesta es incorrecta. Tiene más letras o caracteres de los necesarios.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCADASCUATRO SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasCuatro = $letrasQueNoFormanParteCuatro;
                        $resultadoLetrasBienColocadasCuatro = implode(", ", array_unique($letrasQueSiFormanParteCuatro));
                        $resultadoLetrasMalColocadasCuatro = $letrasQueNoFormanParteCuatro;
                        $resultadoPalabraLetrasCorrectasCuatro = implode(" ", $palabraCoincidenteCuatro);
                        $resultadoPalabraLetrasIncorrectasCuatro = [];
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraCuatro = $arrayLetrasQueLeFaltaronALaPalabraCuatro;

                    }
                    elseif($nroLetrasPalabraCorrectaCuatro > $nroLetrasPalabraUsuarioCuatro){
                        
                        $letrasQueSiCoincidenCuatro = [];
                        $letrasQueNoCoincidenCuatro = [];
                        
                        $palabraFinalCuatro = [];

                        
                        for($h=0; $h<$nroLetrasPalabraUsuarioCuatro; $h++){
                            
                            if(in_array($arrayPalabraUsuarioCuatro[$h], $arrayPalabraCorrectaCuatro)){
                                array_push($letrasQueSiCoincidenCuatro, $arrayPalabraUsuarioCuatro[$h]);
                            }
                            else{
                                array_push($letrasQueNoCoincidenCuatro, $arrayPalabraUsuarioCuatro[$h]);
                            }
                        }

                        
                        for($j=0; $j<$nroLetrasPalabraCorrectaCuatro; $j++){
                            
                            if(in_array($arrayPalabraCorrectaCuatro[$j], $letrasQueSiCoincidenCuatro)){
                                array_push($palabraFinalCuatro, $arrayPalabraCorrectaCuatro[$j]);
                            }
                            else{
                                array_push($palabraFinalCuatro, '_');
                            }
                        }

                        //ACTUALIZACION
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA OPCION CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraCuatro = [];
                        for($t=0; $t<$nroLetrasPalabraCorrectaCuatro; $t++){
                            if(!in_array($arrayPalabraCorrectaCuatro[$t], $arrayPalabraUsuarioCuatro)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraCuatro, $arrayPalabraCorrectaCuatro[$t]);
                            }
                        }
                        
                        //$resultadoLetrasIncorrectasCuatro = implode("", $letrasQueNoCoincidenCuatro);
                        //$resultadoLetrasBienColocadasCuatro = implode(", ", $letrasQueSiCoincidenCuatro);
                        //$resultadoLetrasMalColocadasCuatro = implode(", ", $letrasQueNoCoincidenCuatro);
                        //$resultadoPalabraLetrasCorrectasCuatro = implode(" ", $palabraFinalCuatro);
                        //$resultadoPalabraLetrasIncorrectasCuatro = "Las letras incorrectas de su respuesta no van en la palabra.";
                        $respuestaCasoCuatro = "Su respuesta tiene menos letras de las que debería.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCADASCUATRO SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasCuatro = $letrasQueNoCoincidenCuatro;
                        $resultadoLetrasBienColocadasCuatro = implode(", ", array_unique($letrasQueSiCoincidenCuatro));
                        $resultadoLetrasMalColocadasCuatro = $letrasQueNoCoincidenCuatro;
                        $resultadoPalabraLetrasCorrectasCuatro = implode(" ", $palabraFinalCuatro);
                        $resultadoPalabraLetrasIncorrectasCuatro = [];
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraCuatro = $arrayLetrasQueLeFaltaronALaPalabraCuatro;
                    }
                }
            }


            //COMPARACION PALABRA CINCO

            $letrasIncorrectasCinco = [];
            $letrasBienColocadasCinco = [];
            $letrasMalColocadasCinco = [];
            $palabraLetrasCorrectasCinco = [];
            $palabraLetrasIncorrectasCinco = [];

            $arrayPalabrasCinco = [];

            //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIAN COMO STRINGS Y LAS DEMAS COMO ARRAY
            $resultadoLetrasIncorrectasCinco = [];
            $resultadoLetrasBienColocadasCinco = "";
            $resultadoLetrasMalColocadasCinco = [];
            $resultadoPalabraLetrasCorrectasCinco = "";
            $resultadoPalabraLetrasIncorrectasCinco = [];
            //ACTUALIZACION SE AGREGA EL ARRAY RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO
            $resultadoSeccionesQueLeFaltaronALaPalabraCinco = [];


            $comparacionCinco = strcmp($palabraCorrectaCinco, $palabraUsuarioCinco);


            if($comparacionCinco === 0){
                
                $respuestaCasoCinco = "Su respuesta a la quinta palabra es correcta.";

                
                //$resultadoLetrasIncorrectasCinco = "La palabra no tiene letras incorrectas";
                //$resultadoLetrasBienColocadasCinco = "Todas sus letras están en el orden correcto.";
                //$resultadoLetrasMalColocadasCinco = "La palabra no tiene letras incorrectas";
                //$resultadoPalabraLetrasCorrectasCinco = $palabraCorrectaCinco;
                //$resultadoPalabraLetrasIncorrectasCinco = "No hay letras incorrectas.";

                //ACTUALIZACION YA NO SE ENVIAN STRINGS SOLO ARRAYS
                $resultadoLetrasIncorrectasCinco = [];
                //SI LA RESPUESTA ES CORRECTA ENTONCES LA SIGUIENTE VARIABLE VA VACIA
                //$resultadoLetrasBienColocadasCinco = "Tu respuesta no tiene elementos incorrectos.";
                $resultadoLetrasBienColocadasCinco = "";
                $resultadoLetrasMalColocadasCinco = [];
                //SI LA RESPUESTA ES CORRECTA ENTONCES LA SIGUIENTE VARIABLE VA VACIA
                //$resultadoPalabraLetrasCorrectasCinco = $palabraUsuarioCinco;
                $resultadoPalabraLetrasCorrectasCinco = "";
                $resultadoPalabraLetrasIncorrectasCinco = [];
                //ACTUALIZACION SE AGREGO ESTE NUEVO ARRAY
                $resultadoSeccionesQueLeFaltaronALaPalabraCinco = [];

            }
            else{

                $arrayPalabrasCinco = explode(' ', $palabraUsuarioCinco);
                $numeroPalabrasCinco = count($arrayPalabrasCinco);


                if($numeroPalabrasCinco>1){

                    
                    //$resultadoLetrasIncorrectasCinco = "Su respuesta tiene más de un elemento o palabra.";
                    //$resultadoLetrasBienColocadasCinco = "Hay más de un elemento o palabra.";
                    //$resultadoLetrasMalColocadasCinco = $palabraUsuarioCinco;
                    //$resultadoPalabraLetrasCorrectasCinco = "No se admiten dos o más elementos o palabras.";
                    //$resultadoPalabraLetrasIncorrectasCinco = $palabraUsuarioCinco;
                    $respuestaCasoCinco = "Respuesta incorrecta, no se puede agregar más de una palabra.";

                    //ACTUALIZACION LETRAS BIEN COLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING
                    $resultadoLetrasIncorrectasCinco = [];
                    //SI LA RESPUESTA TIENE DOS PALABRAS ENTONCES ESTA VARIABLE VA VACIA
                    //$resultadoLetrasBienColocadasCinco = "Resultado incorrecto, hay más de una palabra.";
                    $resultadoLetrasBienColocadasCinco = "";
                    $resultadoLetrasMalColocadasCinco = [];
                    //$resultadoPalabraLetrasCorrectasCinco = "No se admite más de una palabra.";
                    $resultadoPalabraLetrasCorrectasCinco = "";
                    $resultadoPalabraLetrasIncorrectasCinco = [];
                    //ACTUALIZACION
                    $resultadoSeccionesQueLeFaltaronALaPalabraCinco = [];
                }
                else{

                    $nroLetrasPalabraUsuarioCinco = mb_strlen($palabraUsuarioCinco, 'UTF-8');
                    $nroLetrasPalabraCorrectaCinco = mb_strlen($palabraCorrectaCinco, 'UTF-8');

                    $arrayPalabraUsuarioCinco = mb_str_split($palabraUsuarioCinco);
                    $arrayPalabraCorrectaCinco = mb_str_split($palabraCorrectaCinco);

                    if($nroLetrasPalabraCorrectaCinco === $nroLetrasPalabraUsuarioCinco){
                        

                        for($a=0; $a<$nroLetrasPalabraUsuarioCinco; $a++){
                            
                            if($arrayPalabraCorrectaCinco[$a] !== $arrayPalabraUsuarioCinco[$a]){
                                array_push($letrasIncorrectasCinco, $arrayPalabraUsuarioCinco[$a]);
                            }
                        }

                        
                        $nroLetrasIncorrectasCinco = count($letrasIncorrectasCinco);

                        
                        for($c=0; $c<$nroLetrasPalabraCorrectaCinco; $c++){
                            if(strncmp($arrayPalabraCorrectaCinco[$c], $arrayPalabraUsuarioCinco[$c], $c+1) === 0){
                                array_push($palabraLetrasCorrectasCinco, $arrayPalabraUsuarioCinco[$c]);
                                array_push($letrasBienColocadasCinco, $arrayPalabraUsuarioCinco[$c]);
                            }
                            else{
                                array_push($palabraLetrasCorrectasCinco, '_');
                                array_push($letrasMalColocadasCinco, $arrayPalabraUsuarioCinco[$c]);
                            }
                        }

                        
                        for($d=0; $d<$nroLetrasPalabraCorrectaCinco; $d++){
                            if(strncmp($arrayPalabraCorrectaCinco[$d], $arrayPalabraUsuarioCinco[$d], $d+1) !== 0){
                                array_push($palabraLetrasIncorrectasCinco, $arrayPalabraUsuarioCinco[$d]);
                            }
                            else{
                                array_push($palabraLetrasIncorrectasCinco, '_');
                            }
                        }

                        //ACTUALIZACION
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA OPCION CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraCinco = [];
                        for($t=0; $t<$nroLetrasPalabraCorrectaCinco; $t++){
                            if(!in_array($arrayPalabraCorrectaCinco[$t], $arrayPalabraUsuarioCinco)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraCinco, $arrayPalabraCorrectaCinco[$t]);
                            }
                        }


                        //$resultadoLetrasIncorrectasCinco = implode("", $letrasIncorrectasCinco);
                        //$resultadoLetrasBienColocadasCinco = implode(",", $letrasBienColocadasCinco);
                        //$resultadoLetrasMalColocadasCinco = implode(",", $letrasMalColocadasCinco);
                        //$resultadoPalabraLetrasCorrectasCinco = implode(" ", $palabraLetrasCorrectasCinco);
                        //$resultadoPalabraLetrasIncorrectasCinco = implode(" ", $palabraLetrasIncorrectasCinco);
                        $respuestaCasoCinco = "Su respuesta es incorrecta.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCADASCINCO SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasCinco = $letrasIncorrectasCinco;
                        $resultadoLetrasBienColocadasCinco = implode(",", array_unique($letrasBienColocadasCinco));
                        $resultadoLetrasMalColocadasCinco = $letrasMalColocadasCinco;
                        $resultadoPalabraLetrasCorrectasCinco = implode(" ", $palabraLetrasCorrectasCinco);
                        $resultadoPalabraLetrasIncorrectasCinco = $palabraLetrasIncorrectasCinco;
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraCinco = $arrayLetrasQueLeFaltaronALaPalabraCinco;

                    }
                    elseif($nroLetrasPalabraCorrectaCinco < $nroLetrasPalabraUsuarioCinco){
                        
                        $letrasQueSiFormanParteCinco = [];
                        $letrasQueNoFormanParteCinco = [];
                        

                        $palabraCoincidenteCinco = [];

                        
                        for($g=0; $g<$nroLetrasPalabraUsuarioCinco; $g++){
                            
                            if(in_array($arrayPalabraUsuarioCinco[$g], $arrayPalabraCorrectaCinco)){
                                array_push($letrasQueSiFormanParteCinco, $arrayPalabraUsuarioCinco[$g]);
                            }
                            else{
                                array_push($letrasQueNoFormanParteCinco, $arrayPalabraUsuarioCinco[$g]);
                            }
                        }


                        
                        for($k=0; $k<$nroLetrasPalabraCorrectaCinco; $k++){
                            
                            if(in_array($arrayPalabraCorrectaCinco[$k], $letrasQueSiFormanParteCinco)){
                                array_push($palabraCoincidenteCinco, $arrayPalabraCorrectaCinco[$k]);
                            }
                            else{
                                array_push($palabraCoincidenteCinco, '_');
                            }
                        }

                        //ACTUALIZACION     
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA RESPUESTA CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraCinco = [];
                        for($f=0; $f<$nroLetrasPalabraCorrectaCinco; $f++){
                            if(!in_array($arrayPalabraCorrectaCinco[$f], $arrayPalabraUsuarioCinco)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraCinco, $arrayPalabraCorrectaCinco[$f]);
                            }
                        }

                        
                        //$resultadoLetrasIncorrectasCinco = implode("", $letrasQueNoFormanParteCinco);
                        //$resultadoLetrasBienColocadasCinco = implode(", ", $letrasQueSiFormanParteCinco);
                        //$resultadoLetrasMalColocadasCinco = implode(", ", $letrasQueNoFormanParteCinco);
                        //$resultadoPalabraLetrasCorrectasCinco = implode(" ", $palabraCoincidenteCinco);
                        //$resultadoPalabraLetrasIncorrectasCinco = "Las letras incorrectas de su respuesta no van en la palabra.";
                        $respuestaCasoCinco = "Su respuesta es incorrecta. Tiene más letras o caracteres de los necesarios.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCADASCINCO SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasCinco = $letrasQueNoFormanParteCinco;
                        $resultadoLetrasBienColocadasCinco = implode(", ", array_unique($letrasQueSiFormanParteCinco));
                        $resultadoLetrasMalColocadasCinco = $letrasQueNoFormanParteCinco;
                        $resultadoPalabraLetrasCorrectasCinco = implode(" ", $palabraCoincidenteCinco);
                        $resultadoPalabraLetrasIncorrectasCinco = [];
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraCinco = $arrayLetrasQueLeFaltaronALaPalabraCinco;
                    
                    }
                    elseif($nroLetrasPalabraCorrectaCinco > $nroLetrasPalabraUsuarioCinco){
                        
                        $letrasQueSiCoincidenCinco = [];
                        $letrasQueNoCoincidenCinco = [];
                        
                        $palabraFinalCinco = [];

                        
                        for($h=0; $h<$nroLetrasPalabraUsuarioCinco; $h++){
                            
                            if(in_array($arrayPalabraUsuarioCinco[$h], $arrayPalabraCorrectaCinco)){
                                array_push($letrasQueSiCoincidenCinco, $arrayPalabraUsuarioCinco[$h]);
                            }
                            else{
                                array_push($letrasQueNoCoincidenCinco, $arrayPalabraUsuarioCinco[$h]);
                            }
                        }

                        
                        for($j=0; $j<$nroLetrasPalabraCorrectaCinco; $j++){
                            
                            if(in_array($arrayPalabraCorrectaCinco[$j], $letrasQueSiCoincidenCinco)){
                                array_push($palabraFinalCinco, $arrayPalabraCorrectaCinco[$j]);
                            }
                            else{
                                array_push($palabraFinalCinco, '_');
                            }
                        }


                        //ACTUALIZACION
                        //EN EL NUEVO ARRAY LLAMADO RESULTADOSECCIONESQUELEFALTARONALAPALABRAUNO SE VAN A GUARDAR LAS LETRAS DE LA OPCION CORRECTA
                        //QUE EL USUARIO NO PUSO EN SU RESPUESTA
                        $arrayLetrasQueLeFaltaronALaPalabraCinco = [];
                        for($t=0; $t<$nroLetrasPalabraCorrectaCinco; $t++){
                            if(!in_array($arrayPalabraCorrectaCinco[$t], $arrayPalabraUsuarioCinco)){
                                array_push($arrayLetrasQueLeFaltaronALaPalabraCinco, $arrayPalabraCorrectaCinco[$t]);
                            }
                        }

                        
                        //$resultadoLetrasIncorrectasCinco = implode("", $letrasQueNoCoincidenCinco);
                        //$resultadoLetrasBienColocadasCinco = implode(", ", $letrasQueSiCoincidenCinco);
                        //$resultadoLetrasMalColocadasCinco = implode(", ", $letrasQueNoCoincidenCinco);
                        //$resultadoPalabraLetrasCorrectasCinco = implode(" ", $palabraFinalCinco);
                        //$resultadoPalabraLetrasIncorrectasCinco = "Las letras incorrectas de su respuesta no van en la palabra.";
                        $respuestaCasoCinco = "Su respuesta tiene menos letras de las que debería.";

                        //ACTUALIZACION LETRASBIENCOLOCADAS Y PALABRALETRASCORRECTAS SE ENVIA COMO STRING 
                        //EL ARRAY LETRASBIENCOLOCADASCINCO SE ENVIA COMO ARRAY_UNIQUE PARA QUE NO ENVIE LETRAS DUPLICADAS
                        $resultadoLetrasIncorrectasCinco = $letrasQueNoCoincidenCinco;
                        $resultadoLetrasBienColocadasCinco = implode(", ", array_unique($letrasQueSiCoincidenCinco));
                        $resultadoLetrasMalColocadasCinco = $letrasQueNoCoincidenCinco;
                        $resultadoPalabraLetrasCorrectasCinco = implode(" ", $palabraFinalCinco);
                        $resultadoPalabraLetrasIncorrectasCinco = [];
                        //ACTUALIZACION EN EL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO SE ENVIA UN ARRAY CON LAS LETRAS DE LA PALABRA CORRECTA
                        //QUE EL USUARIO NO COLOCO EN SU RESPUESTA
                        $resultadoSeccionesQueLeFaltaronALaPalabraCinco = $arrayLetrasQueLeFaltaronALaPalabraCinco;
                    }
                }

            }

            //return $palabraCoincidente;



            //ACTUALIZACION
            //PARA MOSTRAR LAS REGLAS ORTOGRAFICAS ASOCIADAS A LA PREGUNTA CLASIFICADAS POR PALABRAS, PUNTUACION Y ACENTUACION
            //SE DECLARA TRES VARIABLES QUE VAN A A ENVIAR TRUE SI HAY REGLAS ASOCIADAS DE PALABRAS, PUNTUACION O ACENTUACION
            //ESTO SIRVE PARA QUE EN LA VISTA DE MUESTREN LAS SECCIONES SOLO SI HAY REGLAS DE ESE TIPO ASOCIADAS
            
            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 1 CATEGORIES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasencategories = false;
            $hayacentuacionencategories = false;
            $haypuntuacionencategories = false;

            for($a=0; $a<count($questionType->categories); $a++){

                if($questionType->categories[$a]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionencategories = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 2 SECTIONS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasensections = false;
            $hayacentuacionensections = false;
            $haypuntuacionensections = false;

            for($b=0; $b<count($questionType->sections); $b++){

                if($questionType->sections[$b]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionensections = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 3 POSTS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenposts = false;
            $hayacentuacionenposts = false;
            $haypuntuacionenposts = false;

            for($c=0; $c<count($questionType->posts); $c++){

                if($questionType->posts[$c]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenposts = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 4 RULES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenrules = false;
            $hayacentuacionenrules = false;
            $haypuntuacionenrules = false;

            for($d=0; $d<count($questionType->rules); $d++){

                if($questionType->rules[$d]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenrules = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 5 NOTES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasennotes = false;
            $hayacentuacionennotes = false;
            $haypuntuacionennotes = false;

            for($e=0; $e<count($questionType->notes); $e++){

                if($questionType->notes[$e]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionennotes = true;
                }
            }




            //ACTUALIZACION, SE ENVIA LA COLECCION $PALABRASRANDOMASIGNADAS A LA VISTA, ESTA VARIABLE CONTIENE LAS PALABRAS ALEATORIAS QUE DEBIA RESPONDER EL USUARIO
            $palabrasRandomAsignadas = Answer::where('question_id', $questionId)->where('is_correct', true)->whereIn('id', $idsAnswersUser)->get();

            


            //return view('rules.estudiante.displayresults.displaypc', compact('questionType', 'coleccionResults', 'sumaresultados', 'coleccionCorrectas', 'userId', 'evaluationId', 'palabrasAcertadas', 'palabrasIncorrectas'
            //            , 'resultadoLetrasIncorrectasUno', 'resultadoLetrasBienColocadasUno', 'resultadoLetrasMalColocadasUno', 'resultadoPalabraLetrasCorrectasUno'
            //        , 'resultadoPalabraLetrasIncorrectasUno', 'palabraUsuarioUno', 'palabraCorrectaUno', 'respuestaCasoUno', 'resultadoSeccionesQueLeFaltaronALaPalabraUno'
            //        , 'resultadoLetrasIncorrectasDos', 'resultadoLetrasBienColocadasDos', 'resultadoLetrasMalColocadasDos', 'resultadoPalabraLetrasCorrectasDos'
            //        , 'resultadoPalabraLetrasIncorrectasDos', 'palabraUsuarioDos', 'palabraCorrectaDos', 'respuestaCasoDos', 'resultadoSeccionesQueLeFaltaronALaPalabraDos'
            //        , 'resultadoLetrasIncorrectasTres', 'resultadoLetrasBienColocadasTres', 'resultadoLetrasMalColocadasTres', 'resultadoPalabraLetrasCorrectasTres'
            //        , 'resultadoPalabraLetrasIncorrectasTres', 'palabraUsuarioTres', 'palabraCorrectaTres', 'respuestaCasoTres', 'resultadoSeccionesQueLeFaltaronALaPalabraTres'
            //        , 'resultadoLetrasIncorrectasCuatro', 'resultadoLetrasBienColocadasCuatro', 'resultadoLetrasMalColocadasCuatro', 'resultadoPalabraLetrasCorrectasCuatro'
            //        , 'resultadoPalabraLetrasIncorrectasCuatro', 'palabraUsuarioCuatro', 'palabraCorrectaCuatro', 'respuestaCasoCuatro', 'resultadoSeccionesQueLeFaltaronALaPalabraCuatro'
            //        , 'resultadoLetrasIncorrectasCinco', 'resultadoLetrasBienColocadasCinco', 'resultadoLetrasMalColocadasCinco', 'resultadoPalabraLetrasCorrectasCinco'
            //        , 'resultadoPalabraLetrasIncorrectasCinco', 'palabraUsuarioCinco', 'palabraCorrectaCinco', 'respuestaCasoCinco', 'resultadoSeccionesQueLeFaltaronALaPalabraCinco'
            //    ));


            return view('rules.estudiante.displayresults.displaypc', compact('questionType', 'coleccionResults', 'sumaresultados', 'coleccionCorrectas', 'userId', 'evaluationId', 'palabrasAcertadas', 'palabrasIncorrectas'
                        , 'resultadoLetrasIncorrectasUno', 'resultadoLetrasBienColocadasUno', 'resultadoLetrasMalColocadasUno', 'resultadoPalabraLetrasCorrectasUno'
                    , 'resultadoPalabraLetrasIncorrectasUno', 'palabraUsuarioUno', 'palabraCorrectaUno', 'respuestaCasoUno', 'resultadoSeccionesQueLeFaltaronALaPalabraUno'
                    , 'resultadoLetrasIncorrectasDos', 'resultadoLetrasBienColocadasDos', 'resultadoLetrasMalColocadasDos', 'resultadoPalabraLetrasCorrectasDos'
                    , 'resultadoPalabraLetrasIncorrectasDos', 'palabraUsuarioDos', 'palabraCorrectaDos', 'respuestaCasoDos', 'resultadoSeccionesQueLeFaltaronALaPalabraDos'
                    , 'resultadoLetrasIncorrectasTres', 'resultadoLetrasBienColocadasTres', 'resultadoLetrasMalColocadasTres', 'resultadoPalabraLetrasCorrectasTres'
                    , 'resultadoPalabraLetrasIncorrectasTres', 'palabraUsuarioTres', 'palabraCorrectaTres', 'respuestaCasoTres', 'resultadoSeccionesQueLeFaltaronALaPalabraTres'
                    , 'resultadoLetrasIncorrectasCuatro', 'resultadoLetrasBienColocadasCuatro', 'resultadoLetrasMalColocadasCuatro', 'resultadoPalabraLetrasCorrectasCuatro'
                    , 'resultadoPalabraLetrasIncorrectasCuatro', 'palabraUsuarioCuatro', 'palabraCorrectaCuatro', 'respuestaCasoCuatro', 'resultadoSeccionesQueLeFaltaronALaPalabraCuatro'
                    , 'resultadoLetrasIncorrectasCinco', 'resultadoLetrasBienColocadasCinco', 'resultadoLetrasMalColocadasCinco', 'resultadoPalabraLetrasCorrectasCinco'
                    , 'resultadoPalabraLetrasIncorrectasCinco', 'palabraUsuarioCinco', 'palabraCorrectaCinco', 'respuestaCasoCinco', 'resultadoSeccionesQueLeFaltaronALaPalabraCinco'
                    , 'haypalabrasencategories', 'hayacentuacionencategories', 'haypuntuacionencategories', 'haypalabrasensections', 'hayacentuacionensections', 'haypuntuacionensections'
                    , 'haypalabrasenposts', 'hayacentuacionenposts', 'haypuntuacionenposts', 'haypalabrasenrules', 'hayacentuacionenrules', 'haypuntuacionenrules'
                    , 'haypalabrasennotes', 'hayacentuacionennotes', 'haypuntuacionennotes'
                    , 'palabrasRandomAsignadas'));

            /////////////////////////////////////////////////////FIN NUEVO CODIGO 
            

            //////////////////////////////////////////////////////////

            //COLOCAR AQUI LO QUE ESTAN EN EL BLOC DE NOTAS


            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //return view('rules.estudiante.displayresults.displaypc', compact('questionType', 'coleccionResults', 'sumaresultados', 'coleccionCorrectas', 'userId', 'evaluationId', 'palabrasAcertadas', 'palabrasIncorrectas', 'stringletrasincorrectasUno',
            //            'stringusuariocorrectasUno', 'stringusuarioincorrectasUno', 'stringletrascorrectasUno', 'stringletrassinrelacionUno', 'pusuariouno', 'pcorrectauno'));

            //return view('rules.estudiante.displayresults.displaypc', compact('questionType', 'coleccionResults', 'sumaresultados', 'coleccionCorrectas', 'userId', 'evaluationId', 'palabrasAcertadas', 'palabrasIncorrectas'));
        }
        elseif(($questionType->type) === "OMA"){

            //CAPTURAR LA RESPUESTA DEL USUARIO A LA QUESTION OMA MEDIANTE EL USER ID Y EVALUATION ID
            $answerUser = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->pluck('id')->toArray();
            //SACAR EL ID DE LA RESPUESTA DEL ARRAY
            $idCorrecta = reset($answerUser);
            //CAPTURAR EL REGISTRO DE RESPUESTA DEL USUARIO DE LA TABLA RESULTS
            $resultUser = Result::find($idCorrecta);

            //CAPTURAR EL PUNTAJE QUE TIENE EL ESTUDIANTE EN LA PREGUNTA ACTUAL
            $resultados = DB::table('results')->where('question_id', $questionId)->where('user_id', $userId)->pluck('score')->toArray();
            $sumaresultados = array_sum($resultados);

            //COMO ES OPCIONMULTIPLE SE DEBE CAPTURAR LA RESPUESTA CORRECTA, PARA ELLO SE TRAE UN ARRAY EN LA COLECCION DE RESPUESTAS CORRECTAS
            //DESDE LA TABLA ANSWER
            $resCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->pluck('id')->toArray();
            //COMO ES OPCION MULTIPLE SOLO TIENE UNA RESPUESTA CORRECTA, ENTONCES DEL ARRAY DE RESCORRECTA SOLO SE CAPTURA EL PRIMER ELEMENTO
            $idAnswerCorrecta = reset($resCorrecta);
            //YA TENIENDO EL ID DE LA RESPUESTA CORRECTA, SE CAPTURA EL REGISTRO COMPLETO DE ANSWER
            $answerCorrecta = Answer::find($idAnswerCorrecta);


            //ACTUALIZACION
            //PARA MOSTRAR LAS REGLAS ORTOGRAFICAS ASOCIADAS A LA PREGUNTA CLASIFICADAS POR PALABRAS, PUNTUACION Y ACENTUACION
            //SE DECLARA TRES VARIABLES QUE VAN A A ENVIAR TRUE SI HAY REGLAS ASOCIADAS DE PALABRAS, PUNTUACION O ACENTUACION
            //ESTO SIRVE PARA QUE EN LA VISTA DE MUESTREN LAS SECCIONES SOLO SI HAY REGLAS DE ESE TIPO ASOCIADAS
            
            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 1 CATEGORIES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasencategories = false;
            $hayacentuacionencategories = false;
            $haypuntuacionencategories = false;

            for($a=0; $a<count($questionType->categories); $a++){

                if($questionType->categories[$a]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionencategories = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 2 SECTIONS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasensections = false;
            $hayacentuacionensections = false;
            $haypuntuacionensections = false;

            for($b=0; $b<count($questionType->sections); $b++){

                if($questionType->sections[$b]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionensections = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 3 POSTS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenposts = false;
            $hayacentuacionenposts = false;
            $haypuntuacionenposts = false;

            for($c=0; $c<count($questionType->posts); $c++){

                if($questionType->posts[$c]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenposts = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 4 RULES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenrules = false;
            $hayacentuacionenrules = false;
            $haypuntuacionenrules = false;

            for($d=0; $d<count($questionType->rules); $d++){

                if($questionType->rules[$d]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenrules = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 5 NOTES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasennotes = false;
            $hayacentuacionennotes = false;
            $haypuntuacionennotes = false;

            for($e=0; $e<count($questionType->notes); $e++){

                if($questionType->notes[$e]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionennotes = true;
                }
            }


            //return view('rules.estudiante.displayresults.displayoma', compact('questionType', 'resultUser', 'sumaresultados', 'answerCorrecta', 'userId', 'evaluationId'));

            return view('rules.estudiante.displayresults.displayoma', compact('questionType', 'resultUser', 'sumaresultados', 'answerCorrecta', 'userId', 'evaluationId'
                        , 'haypalabrasencategories', 'hayacentuacionencategories', 'haypuntuacionencategories', 'haypalabrasensections', 'hayacentuacionensections', 'haypuntuacionensections'
                        , 'haypalabrasenposts', 'hayacentuacionenposts', 'haypuntuacionenposts', 'haypalabrasenrules', 'hayacentuacionenrules', 'haypuntuacionenrules'
                        , 'haypalabrasennotes', 'hayacentuacionennotes', 'haypuntuacionennotes'));


        }
        elseif(($questionType->type) === "OMI"){

            //CAPTURAR LA RESPUESTA DEL USUARIO A LA QUESTION OMI MEDIANTE EL USER ID Y EVALUATION ID
            $answerUser = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->pluck('id')->toArray();
            //SACAR EL ID DE LA RESPUESTA DEL ARRAY
            $idCorrecta = reset($answerUser);
            //CAPTURAR EL REGISTRO DE RESPUESTA DEL USUARIO DE LA TABLA RESULTS
            $resultUser = Result::find($idCorrecta);

            //CAPTURAR EL PUNTAJE QUE TIENE EL ESTUDIANTE EN LA PREGUNTA ACTUAL
            $resultados = DB::table('results')->where('question_id', $questionId)->where('user_Id', $userId)->pluck('score')->toArray();
            $sumaresultados = array_sum($resultados);

            //COMO ES OPCION MULTIPLE SE DEBE CAPTURAR LA RESPUESTA CORRECTA, PARA ELLO SE TRAE UN ARRAY EN LA COLECCION DE RESPUESTAS CORRECTAS
            //DESDE LA TABLA ANSWER
            $resCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->pluck('id')->toArray();
            //COMO ES OPCION MULTIPLE SOLO TIENE UNA RESPUESTA CORRECTA, ENTONCES DEL ARRAY DE RESCORRECTA SOLO SE CAPTURA EL PRIMER ELEMENTO
            $idAnswerCorrecta = reset($resCorrecta);
            //YA TIENEN EL ID DE LA RESPUESTA CORRECTA, SE CAPTURA EL REGISTRO COMPLETO DE ANSWERCORRECTA
            $answerCorrecta = Answer::find($idAnswerCorrecta);



            //ACTUALIZACION
            //PARA MOSTRAR LAS REGLAS ORTOGRAFICAS ASOCIADAS A LA PREGUNTA CLASIFICADAS POR PALABRAS, PUNTUACION Y ACENTUACION
            //SE DECLARA TRES VARIABLES QUE VAN A A ENVIAR TRUE SI HAY REGLAS ASOCIADAS DE PALABRAS, PUNTUACION O ACENTUACION
            //ESTO SIRVE PARA QUE EN LA VISTA DE MUESTREN LAS SECCIONES SOLO SI HAY REGLAS DE ESE TIPO ASOCIADAS
            
            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 1 CATEGORIES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasencategories = false;
            $hayacentuacionencategories = false;
            $haypuntuacionencategories = false;

            for($a=0; $a<count($questionType->categories); $a++){

                if($questionType->categories[$a]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionencategories = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 2 SECTIONS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasensections = false;
            $hayacentuacionensections = false;
            $haypuntuacionensections = false;

            for($b=0; $b<count($questionType->sections); $b++){

                if($questionType->sections[$b]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionensections = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 3 POSTS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenposts = false;
            $hayacentuacionenposts = false;
            $haypuntuacionenposts = false;

            for($c=0; $c<count($questionType->posts); $c++){

                if($questionType->posts[$c]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenposts = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 4 RULES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenrules = false;
            $hayacentuacionenrules = false;
            $haypuntuacionenrules = false;

            for($d=0; $d<count($questionType->rules); $d++){

                if($questionType->rules[$d]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenrules = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 5 NOTES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasennotes = false;
            $hayacentuacionennotes = false;
            $haypuntuacionennotes = false;

            for($e=0; $e<count($questionType->notes); $e++){

                if($questionType->notes[$e]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionennotes = true;
                }
            }




            //return view('rules.estudiante.displayresults.displayomi', compact('questionType', 'resultUser', 'sumaresultados', 'answerCorrecta', 'userId', 'evaluationId'));

            return view('rules.estudiante.displayresults.displayomi', compact('questionType', 'resultUser', 'sumaresultados', 'answerCorrecta', 'userId', 'evaluationId'
                        , 'haypalabrasencategories', 'hayacentuacionencategories', 'haypuntuacionencategories', 'haypalabrasensections', 'hayacentuacionensections', 'haypuntuacionensections'
                        , 'haypalabrasenposts', 'hayacentuacionenposts', 'haypuntuacionenposts', 'haypalabrasenrules', 'hayacentuacionenrules', 'haypuntuacionenrules'
                        , 'haypalabrasennotes', 'hayacentuacionennotes', 'haypuntuacionennotes'));

        }
        elseif(($questionType->type) === "OA"){

            //CAPTURAR LAS 5 RESPUESTAS DEL USUARIO A LA QUESTION OA MEDIANTE EL USERID Y EVALUATIONID Y SE CREA UN ARRAY CON LOS IDS DE LOS RESULTADOS
            $answersUser = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->pluck('id')->toArray();
            //CON LOS IDS DE LOS RESULTADOS SE BUSCA UNA A UNA LA ORACION ESCRITA POR EL USUARIO EN LA TABLA RESULTS PARA TENERLOS LISTOS COMO STRINGS
            //SE ACCEDE ASI A LA RESPUESTA TIPO STRING: $oracionuno->answer_user;
            $oracionuno = Result::find($answersUser[0]);
            $oraciondos = Result::find($answersUser[1]);
            $oraciontres = Result::find($answersUser[2]);
            $oracioncuatro = Result::find($answersUser[3]);
            $oracioncinco = Result::find($answersUser[4]);

            //GUARDAR LAS RESPUESTAS DEL USUARIO EN UN ARRAY PARA ENVIARLAS A LA VISTA
            $coleccionResults = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->get();

            //CAPTURAR EL PUNTAJE QUE TIENE EL ESTUDIANTE EN LA PREGUNTA ACTUAL
            $resultados = DB::table('results')->where('question_id', $questionId)->where('user_id', $userId)->pluck('score')->toArray();
            $sumaresultados = array_sum($resultados);

            //COMO ES ORACION AUDIO SON 5 ORACIONES DE LA TABLA ANSWERS ENTONCES SE CAPTURA PRIMERO LA COLECCION DE RESPUESTAS
            $resCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->pluck('id')->toArray();
            //CON LOS IDS DE LAS ANSWERS CORRECTAS SE BUSCA UNA A UNA LA RESPUESTA EN LA TABLA ANSWERS PARA TENERMOS LISTOS COMO STRINGS
            //SE ACCEDE ASI A LA ANSWER TIPO STRING: $resoracioncorrectauno->answer;
            $resoracioncorrectauno = Answer::find($resCorrecta[0]);
            $resoracioncorrectados = Answer::find($resCorrecta[1]);
            $resoracioncorrectatres = Answer::find($resCorrecta[2]);
            $resoracioncorrectacuatro = Answer::find($resCorrecta[3]);
            $resoracioncorrectacinco = Answer::find($resCorrecta[4]);

            //GUARDAR LAS ANSWERS CORRECTAS EN UN ARRAY PARA ENVIARLAS A LA VISTA
            $coleccionCorrectas = Answer::where('question_id', $questionId)->where('is_correct', true)->get();

            //CAPTURAR LAS ORACIONES ACERTADAS Y LAS ORACIONESINCORRECTAS
            $answers = Answer::where('question_id', $questionId)->where('is_correct', true)->pluck('answer')->toArray();
            $responses = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->pluck('answer_user')->toArray();
            $oracionesAcertadas = [];
            $oracionesIncorrectas = [];
            $answersU_count = count($responses);
            //RECORRER CON UN FOR EL ARRAY DE RESPUESTAS CORRECTAS Y EL ARRAY DE RESPUESTAS DEL USUARIO Y LAS QUE COINCIDAN SE GUARDAN EN EL ARRAY
            //DE PALABRAS ACERTADAS Y LAS QUE NO COINCIDAN EN EL ARRAY DE PALABRASINCORRECTAS
            for($i=0; $i<$answersU_count; $i++){
                $comparacion = strcmp($answers[$i], $responses[$i]);
                if($comparacion == 0){
                    array_push($oracionesAcertadas, $responses[$i]);
                }
                else{
                    array_push($oracionesIncorrectas, $responses[$i]);
                }
            }



            //ACTUALIZACION
            //SE ENVIA A LA VISTA EL PUNTAJE DE CADA ENUNCIADO DEL USUARIO PARA EN FUNCION DE ESO MOSTRAR SOLO EL TEXTO DE RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA
            //CORRECTA ORIGINAL, PARA QUE EN LA VISTA EN FUNCION DE SI TIENE 0 DE PUNTAJE, ES DECIR, TIENE ERRORES, LE APAREZCA LA REVISION DEL TEXTO Y LA REVISION DE LA RESPUESTA
            //CORRECTA, CASO CONTRARIO, CUANDO EL PUNTAJE ES DIFERENTE DE CERO, AHI SOLO APARECEN EL ENUNCIADO DE RESPUESTA ORIGINAL Y EL TEXTO CORRECTO ORIGINAL
            $resultadosoracionesoa = DB::table('results')->where('question_id', $questionId)->where('user_id', $userId)->pluck('score')->toArray();
            //COMO QUESTION OA TIENEE 5 RESPUESTAS, SE CAPTURA CADA PUNTAJE EN UNA VARIABLE DIFERENTE
            $resultadooauno = $resultadosoracionesoa[0];
            $resultadooados = $resultadosoracionesoa[1];
            $resultadooatres = $resultadosoracionesoa[2];
            $resultadooacuatro = $resultadosoracionesoa[3];
            $resultadooacinco = $resultadosoracionesoa[4];
           


            ///////////////////////////////////////////////////////////////CODIGO ANALISIS DE ORACION POR ORACION

            //GUARDAR EN UNA VARABIE CADA ORACION DE LAS 5 RESPUESTAS DEL USUARIO
            //CON TRM SE QUITAN LOS ESPACIOS DEL INICIO Y FINAL DE LA ORACION
            $oracionUsuarioUno = trim($oracionuno->answer_user);
            $oracionUsuarioDos = trim($oraciondos->answer_user);
            $oracionUsuarioTres = trim($oraciontres->answer_user);
            $oracionUsuarioCuatro = trim($oracioncuatro->answer_user);
            $oracionUsuarioCinco = trim($oracioncinco->answer_user);

            //GUARDAR EN UNA VARIABLE CADA ORACION CORRECTA
            //CON TRIM SE QUITAN LOS ESPACIOS DEL INICIO Y FINAL DE LAS ORACIONES
            $oracionCorrectaUno = trim($resoracioncorrectauno->answer);
            $oracionCorrectaDos = trim($resoracioncorrectados->answer);
            $oracionCorrectaTres = trim($resoracioncorrectatres->answer);
            $oracionCorrectaCuatro = trim($resoracioncorrectacuatro->answer);
            $oracionCorrectaCinco = trim($resoracioncorrectacinco->answer);

            //VARIABLE QUE MOSTRARA UN MENSAJE EN LA SECCION DE DETALLE DE RESPUESTA
            $respuestaOracionUno = "";
            $respuestaOracionDos = "";
            $respuestaOracionTres = "";
            $respuestaOracionCuatro = "";
            $respuestaOracionCinco = "";

            //COMPROBACION ORACION UNO

            //VARIABLES PARA LA ORACION UNO
            $caracteresCorrectosUno = [];
            $caracteresIncorrectosUno = [];
            $palabrasCorrectasUno = [];
            $palabrasIncorrectasUno = [];
            $seccionesCorrectasUno = [];
            $seccionesIncorrectasUno = [];
            
            

            //LOS SIGUIENTES ARRAYS VAN A CONTENER LO SIGUIENTE
            //EL ARRAY RESULTADOPALABRASINCORRECTASUSUARIOUNO VA A CONTENER LAS PALABRAS DE LA RESPUESTA DEL USUARIO QUE NO TENGAN RELACION CON LA RESPUESTA CORRECTA
            //EL ARRAY RESULTADOSIGNOSINCORRECTOSUSUARIOUNO VA A CONTENER LOS SIGNOS DE LA RESPUESTA DEL USUARIO QUE NO TENGAN RELACION CON LA ORACION CORRECTA
            //EL ARRAY RESULTADOPALABRASQUELEFALTARONALUSUARIOUNO VA A CONTENER LAS PALABRAS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
            //EL ARRAY RESULTADOSIGNOSQUELEFALTARONALUSUARIOUNO VA A CONTENER LOS SIGNOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
            //EN ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO VA A CONTENER LAS SECCIONES DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
            
            $resultadoPalabrasIncorrectasUsuarioUno = [];
            $resultadoSignosIncorrectosUsuarioUno = [];
            $resultadoPalabrasQueLeFaltaronAlUsuarioUno = [];
            $resultadoSignosQueLeFaltaronAlUsuarioUno = [];
            $resultadoSeccionesQueLeFaltaronAlUsuarioUno = [];
            //ACTUALIZACION SE AGREGA ESTE ARRAY PARA PODER PINTAR EN LA VISTA LAS SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS
            $resultadoSeccionesIncorrectasOracionUsuarioUno = [];

            //COMPROBACION ORACION UNO

            //PRIMERO SE DEBE COMPROBAR SI LA ORACION COMPLETA ES IGUAL, ES DECIR, COMPROBAR SI ES CORRECTA O INCORRECTA
            $compararOracionUno = strcmp($oracionCorrectaUno, $oracionUsuarioUno);

            //CON EL IF SE PREGUNTA SI LA COMPARACION ES IGUAL A 0, LO QUE SIGNIFICA QUE LA RESPUESTA ES CORRECTA
            //O SI ES DIFERENTE DE 0, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA
            if($compararOracionUno === 0){
                //SI ES IGUAL A CERO, LA PALABRA DEL USUARIO ES CORRECTA
                $respuestaOracionUno = "Su respuesta al primer enunciado es correcta.";

                $resultadoPalabrasIncorrectasUsuarioUno = [];
                $resultadoSignosIncorrectosUsuarioUno = [];
                $resultadoPalabrasQueLeFaltaronAlUsuarioUno = [];
                $resultadoSignosQueLeFaltaronAlUsuarioUno = [];
                $resultadoSeccionesQueLeFaltaronAlUsuarioUno = [];
                //ACTUALIZACION SE AGREGA ESTE NUEVO ARRAY
                $resultadoSeccionesIncorrectasOracionUsuarioUno = [];
                //ACTUALIZACION SE AGREGA ESTE CAMPO QUE CONTIENE LA RESPUESTA DEL USUARIO
                $stringSeccionesOracionUsuarioUno = $oracionUsuarioUno;
                //ACTUALIZACION, SE ENVIA ESTE CAMPO PARA VER SI HAY ESPACIOS O NO EN LA RESPUESTA
                //COMO EN ESTE CASO NO HAY ESPACIOS ADICIONALES PORQUE LA RESPUESTA ES CORRECTA, SE ENVIA FALSE
                $existenEspaciosOracionUno = false;
                //ACTUALIZACION, SI EL TEXTO ES CORRECTO LA VARIABLE hayUnEspacioEnBlancoEnunciadoDos SE ENVIA FALSE
                $hayUnEspacioEnBlancoOracionUno = false;
                //ACTUALIZACION, LA VARIABLE PARA MOSTRAR EL MENSAJE ES FALSA SI LA RESPUESTA ES CORRECTA
                $mensajeEspacioBlancoOracionUno = false;
            
            }else{

                //SI ES DIFERENTE DE 0, LA ORACION DEL USUARIO ES INCORRECTA
                //HAY 3 CASOS PRINCIPALES PARA QUE UNA ORACION ESTE MAL
                //1. QUE LA CADENA INGRESADA TENGA IGUAL CANTIDAD DE CARACTERES PERO QUE SEAN DIFERENTES
                //2. QUE LA CADENA INGRESADA TENGA MENOS CARACTERES QUE LA ORACION CORRECTA
                //3. QUE LA CADENA INGRESADA TENGA MAS CARACTERES QUE LA ORACION CORRECTA

                //PARA SABER QUE CASO CONVIENE A CADA ORACION, HAY QUE CONTAR CUANTOS CARACTERES HAY EN EL STRING
                //DE LA ORACION CORRECTA Y EN EL STRING DE LA RESPUESTA DEL USUARIO
                //CON EL METODO MB_STRLEN SE CUENTA EL NUMERO DE CARACTERES QUE TIENE LA RESPUESTA DEL USUARIO
                //ESTEE METODO TOMA EN CUENTA LOS ESPACIOS QUE SE DEJAN AL INICIO, AL FINAL Y ENTRE EL ENUNCIADO, POR 
                //ESO A LAS ORACIONES CORRECTAS Y RESPUESTAS SE LES APLICO EL METODO TRIM
                $nroCaracteresOracionUsuarioUno = mb_strlen($oracionUsuarioUno, 'UTF-8');
                $nroCaracteresOracionCorrectaUno = mb_strlen($oracionCorrectaUno, 'UTF-8');
                //SE DEBE HACER UN ARRAY DE LA ORACION CORRECTA Y ORACION DEL USUARIO PARA POSTERIORMENTE REALIZAR LAS COMPROBACIONES
                //ESTOS ARRAY ALMACENAN LOS CARACTERES DE LA RESPUESTA CORRECTA Y RESPUESTA DEL USUARIO
                $arrayCaracteresOracionUsuarioUno = mb_str_split($oracionUsuarioUno);
                $arrayCaracteresOracionCorrectaUno = mb_str_split($oracionCorrectaUno);

                //PARA REALIZAR EL ANALISIS SE NECESITA TAMBIEN CAPTURAR TODAS LAS SECCIONES DE LA RESPUESTA DEL USUARIO Y LA RESPUESTA CORRECTA
                //SEPARADAS POR UN ESPACIO POR EJEMPLO: ¿Cuantos? pregunta: ademas, etc.
                $arraySeccionesOracionCorrectaUno = explode(' ', $oracionCorrectaUno);
                $arraySeccionesOracionUsuarioUno = explode(' ', $oracionUsuarioUno);

                //TAMBIEN PARA EL ANALISIS PALABRA A PALABRA SE NECESITAN CAPTURAR SOLO LAS PALABRAS DE LA RESPUESTA CORRECTA Y LA RESPUESTA DEL USUARIO
                //ELIMINANDO LOS SIGNOS DE PUNTUACION
                $aPalabrasOracionCorrectaUno = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $oracionCorrectaUno);
                $arrayPalabrasOracionCorrectaUno = explode(' ', $aPalabrasOracionCorrectaUno);
                $aPalabrasOracionUsuarioUno = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $oracionUsuarioUno);
                $arrayPalabrasOracionUsuarioUno = explode(' ', $aPalabrasOracionUsuarioUno);


                //FINALMENTE SE VAN A CAPTURAR TODOS LOS SIGNOS ORTOGRAFICOS DE LA ORACION CORRECTA Y DE LA ORACION DEL USUARIO
                //POR ELLO HAY QUE CONTAR EL NUMERO DE ELEMENTOS DE CADA ARRAY DE CARACTERES
                $nroElementosArrayCaracteresOracionUsuarioUno = count($arrayCaracteresOracionUsuarioUno);
                $nroElementosArrayCaracteresOracionCorrectaUno = count($arrayCaracteresOracionCorrectaUno);
                $arraySignosOracionUsuarioUno = [];
                $arraySignosOracionCorrectaUno = [];
                //CON UN FOR SE RECORRE EL ARRAYCARACTERESORACIONUSUARIOUNO Y SE VA GUARDANDO EN EL ARRAYSIGNOSORACIOUSUARIOUNO
                for($i=0; $i<$nroElementosArrayCaracteresOracionUsuarioUno; $i++){
                    if((strcmp($arrayCaracteresOracionUsuarioUno[$i], ',') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], ':') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], ';') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioUno[$i], '-') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '+') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '/') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioUno[$i], '.') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '...') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '....') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioUno[$i], '&') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '!') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '¡') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioUno[$i], '?') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '¿') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '"') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioUno[$i], ')') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '(') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '..') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioUno[$i], '*') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], "'") === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '[') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioUno[$i], ']') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '{') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '}') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioUno[$i], '_') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '^') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '#') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioUno[$i], '<') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '>') === 0) || (strcmp($arrayCaracteresOracionUsuarioUno[$i], '|') === 0)){

                        array_push($arraySignosOracionUsuarioUno, $arrayCaracteresOracionUsuarioUno[$i]);
                    }
                }

                //CON UN FOR SE RECORRE EL ARRAYCARACTERESORACIONCORRECTAUNO Y SE VA GUARDANDO EN EL ARRAYSIGNOSORACIONCORRECTAUNO
                for($m=0; $m<$nroElementosArrayCaracteresOracionCorrectaUno; $m++){
                    if((strcmp($arrayCaracteresOracionCorrectaUno[$m], ',') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], ':') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], ';') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaUno[$m], '-') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '+') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '/') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaUno[$m], '.') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '...') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '....') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaUno[$m], '&') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '!') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '¡') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaUno[$m], '?') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '¿') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '"') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaUno[$m], ')') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '(') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '..') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaUno[$m], '*') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], "'") === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '[') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaUno[$m], ']') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '{') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '}') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaUno[$m], '_') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '^') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '#') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaUno[$m], '<') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '>') === 0) || (strcmp($arrayCaracteresOracionCorrectaUno[$m], '|') === 0)){

                        array_push($arraySignosOracionCorrectaUno, $arrayCaracteresOracionCorrectaUno[$m]);
                    }
                }

                //PARA REALIZAR EL ANALISIS DE PALABRAS SIGNOS Y SECCIONES SE DEBE CONTAR EL NUMERO DE ELEMENTOS QUE TIENE CADA ARRAY
                $nroElementosArrayPalabrasOracionUsuarioUno = count($arrayPalabrasOracionUsuarioUno);
                $nroElementosArrayPalabrasOracionCorrectaUno = count($arrayPalabrasOracionCorrectaUno);
                $nroElementosArraySignosOracionUsuarioUno = count($arraySignosOracionUsuarioUno);
                $nroElementosArraySignosOracionCorrectaUno = count($arraySignosOracionCorrectaUno);
                $nroElementosArraySeccionesOracionUsuarioUno = count($arraySeccionesOracionUsuarioUno);
                $nroElementosArraySeccionesOracionCorrectaUno = count($arraySeccionesOracionCorrectaUno);

                //ENCONTRAR PALABRAS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS
                //SE USA EL ARRAYPALABRASORACIONCORRECTAUNO Y EL ARRAYPALABRASORACIONUSUARIOUNO
                //SE RECORREN TODOS LOS ELEMENTOS DEL ARRAYPALABRASORACIONUSUARIOUNO Y SE COMPARAN CON LAS PALABRAS DEL ARRAYPALABRASORACIONCORRECTAUNO
                //Y LOS ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO SE ENCUENTREN EN LA RESPUESTA CORRECTA SE GUARDAN EN EL ARRAY 
                //RESULTADOPALABRASINCORRECTASUSUARIOUNO
                //$resultadoPalabrasIncorrectasUsuarioUno = [];
                for($e=0; $e<$nroElementosArrayPalabrasOracionUsuarioUno; $e++){
                    if(!in_array($arrayPalabrasOracionUsuarioUno[$e], $arrayPalabrasOracionCorrectaUno)){
                        array_push($resultadoPalabrasIncorrectasUsuarioUno, $arrayPalabrasOracionUsuarioUno[$e]);
                    }
                }


                //ENCONTRAR LOS SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS
                //SE USA EL ARRAYSIGNOSORACIONUSUARIOUNO Y EL ARRAYSIGNOSORACIONCORRECTAUNO
                //SE RECORREN TODOS LOS ELEMENTOS DEL ARRAYSIGNOSORACIONUSUARIOUNO Y SE COMPARAN CON LOS SIGNOS DEL ARRAYSIGNOSORACIONCORRECTAUNO
                //Y LOS ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO COINCIDAN CON LOS ELEMENTOS DE LA RESPUESTA CORRECTA SE GUARDAN EN EL ARRAY
                //RESULTADOSIGNOSINCORRECTOSUSUARIOUNO
                for($r=0; $r<$nroElementosArraySignosOracionUsuarioUno; $r++){
                    if(!in_array($arraySignosOracionUsuarioUno[$r], $arraySignosOracionCorrectaUno)){
                        array_push($resultadoSignosIncorrectosUsuarioUno, $arraySignosOracionUsuarioUno[$r]);
                    }
                }

                //ENCONTRAR LAS PALABRAS DE LA RESPUESTA CORRECTA QUE EL USUARIO NO AGREGO EN SU RESPUESTA
                //SE USA EL ARRAYPALABRASORACIONUSUARIOUNO Y EL ARRAY PALABRASORACIONCORRECTAUNO
                //SE RECORREN TODOS LOS ELEMENTOS DEL ARRAYPALABRASORACIONCORRECTAUNO Y SE COMPARAN CON LAS PALABRAS DEL ARRAYPALABRASORACIONUSUARIOUNO
                //Y LOS ELEMENTOS DE LA RESPUESTA DE LA RESPUESTA CORRECTA QUE NO ESTEN EN LA RESPUESTA DEL USUARIO SE ALMACENAN EN EL ARRAY
                //RESULTADOPALABRASQUELEFALTARONALUSUARIO
                for($f=0; $f<$nroElementosArrayPalabrasOracionCorrectaUno; $f++){
                    if(!in_array($arrayPalabrasOracionCorrectaUno[$f], $arrayPalabrasOracionUsuarioUno)){
                        array_push($resultadoPalabrasQueLeFaltaronAlUsuarioUno, $arrayPalabrasOracionCorrectaUno[$f]);
                    }
                }


                //ENCONTRAR LOS SIGNOS QUE LE FALTARON EN LA RESPUESTA AL USUARIO
                //SE USA EL ARRAYSIGNOSORACIONUSUARIOUNO Y EL ARRAYSIGNOSORACIONCORRECTAUNO
                //SE RECORREEN TODOS LOS ELEMENTOS DEL ARRAYSIGNOSORACIONCORRECTAUNO Y SE COMPARAN CON LOS SIGNOS DEL ARRAYSIGNOSORACIONUSUARIOUNO
                //Y LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO ESTEN EN LA RESPUESTA DEL USUARIO SE ALMACENAN EN EL ARRAY
                //RESULTADOSIGNOSQUELEFALTAONALUSUARIOUNO
                for($j=0; $j<$nroElementosArraySignosOracionCorrectaUno; $j++){
                    if(!in_array($arraySignosOracionCorrectaUno[$j], $arraySignosOracionUsuarioUno)){
                        array_push($resultadoSignosQueLeFaltaronAlUsuarioUno, $arraySignosOracionCorrectaUno[$j]);
                    }
                }

                //ENCONTRAR LAS SECCIONES QUE LE FALTARON AL USUARIO UNO
                //SE USA EL ARRAYSECCIONESORACIONUSUARIOUNO Y EL ARRAYSECCIONESORACIONCORRECTAUNO
                //SE RECORREN TODOS LOS ELEMENTOS DEL ARRAYSECCIONESORACIONCORRECTAUNO Y SE COMPARAN CON LOS SIGNOS DEL ARRAYSECCIONESORACIONUSUARIOUNO
                //Y LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO ESTEN EN LA RESPUESTA DEL USUARIO SE ALMACENAN EN EL ARRAU
                //RESULTADOSSECCIONESQUELEFALTARONALUSUARIOUNO
                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO ORIGINAL
                //for($d=0; $d<$nroElementosArraySeccionesOracionCorrectaUno; $d++){
                //    if(!in_array($arraySeccionesOracionCorrectaUno[$d], $arraySeccionesOracionUsuarioUno)){
                //        array_push($resultadoSeccionesQueLeFaltaronAlUsuarioUno, $arraySeccionesOracionCorrectaUno[$d]);
                //    }
                //}


                //////////////////////////////////////// METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO FINAL

                $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionUno = 0;
                $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionUno = 0;
                for($u=0; $u<$nroElementosArraySeccionesOracionCorrectaUno; $u++){

                    
                    for ($y=0; $y<$nroElementosArraySeccionesOracionCorrectaUno; $y++){
                        $compararoracionuno = strcmp($arraySeccionesOracionCorrectaUno[$u], $arraySeccionesOracionCorrectaUno[$y]);
                        if ($compararoracionuno === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionUno++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesOracionUsuarioUno); $z++){
                        $compararoracionunousuario = strcmp($arraySeccionesOracionCorrectaUno[$u], $arraySeccionesOracionUsuarioUno[$z]);
                        if($compararoracionunousuario === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionUno++;
                        }
                    }

                    if(($contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionUno > $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionUno)){
                        if (!in_array($arraySeccionesOracionCorrectaUno[$u], $resultadoSeccionesQueLeFaltaronAlUsuarioUno)){
                            array_push($resultadoSeccionesQueLeFaltaronAlUsuarioUno, $arraySeccionesOracionCorrectaUno[$u]);
                        }
                        
                    }
                    $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionUno = 0;
                    $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionUno = 0;
                }

                ///////////////////////////////////////// FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO

                //ACTUALIZACION
                //EN EL ARRAY COMENTADO SE AGREGARAN LAS SECCIONES DE ORACION UNO DEL USUARIO QUE NO COINCIDAN CON LAS SECCIONES DE LA ORACION CORRECTA UNO
                // $resultadoSeccionesIncorrectasOracionUsuarioUno = [];
                //PARA LA COMPARACION, CON UN FOR SE RECORRE EL ARRAYSECCIONESORACIONUSUARIOUNO Y SE PREGUNTA SI LA SECCION [I] DE ESE ARRAY NO COINCIDE CON ALGUNA DE LAS SECCIONES DE LA ORACION CORRECTA
                //Y LAS SECCIONES DEL ARRAYSECCIONESORACIONUSUARIOUNO QUE NO COINCIDAN CON ALGUNA SECCION DEL ARRAYSECCIONESORACIONCORRECTAUNO, SE GUARDAN EN EL ARRAY
                //RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO PARA ENVIARLAS A LA VISTA
                
                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO ORIGINAL
                //for($p=0; $p<$nroElementosArraySeccionesOracionUsuarioUno; $p++){
                //
                //    if(!in_array($arraySeccionesOracionUsuarioUno[$p], $arraySeccionesOracionCorrectaUno)){
                //        array_push($resultadoSeccionesIncorrectasOracionUsuarioUno, $arraySeccionesOracionUsuarioUno[$p]);
                //    }
                //}



                //////////////////////////////////////METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL

                //CAPTURAR LAS PALABRAS QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA Y AGREGARLAS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS
                for($b=0; $b<$nroElementosArraySeccionesOracionUsuarioUno; $b++){
                    if(!in_array($arraySeccionesOracionUsuarioUno[$b], $arraySeccionesOracionCorrectaUno)){
                        array_push($resultadoSeccionesIncorrectasOracionUsuarioUno, $arraySeccionesOracionUsuarioUno[$b]);
                    }
                }

                //AGREGAR AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS LAS PALABRAS QUE SI FORMAN PARTE DEL TEXTO CORRECTO, PERO QUE ESTAN AGREGADAS EN DEMASIA
                //ES DECIR, EN EL TEXTO CORRECTO HAY 2 "HOLA" PERO EN LA RESPUESTA DEL USUARIO HAY 3 "HOLA", POR LO TANTO ES UNA PALABRA INCORRECTA.
                //ESTE METODO ESTÁ BASADO EN EL METODO PARA AGREGAR ELEMENTOS AL ARRAY $resultadoSeccionesQueLeFaltaronParrafoUsuario
                //LA DIFERENCIA ES QUE EN LA SECCION FINAL DE ESTE METODO SE CAMBIO EL METODO DE MAYOR QUE A MENOR QUE  

                $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionUno = 0;
                $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionUno = 0;
                for($u=0; $u<$nroElementosArraySeccionesOracionCorrectaUno; $u++){

                    for ($y=0; $y<$nroElementosArraySeccionesOracionCorrectaUno; $y++){
                        $compararoracionuno = strcmp($arraySeccionesOracionCorrectaUno[$u], $arraySeccionesOracionCorrectaUno[$y]);
                        if ($compararoracionuno === 0){
                            $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionUno++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesOracionUsuarioUno); $z++){
                        $compararoracionunousuario = strcmp($arraySeccionesOracionCorrectaUno[$u], $arraySeccionesOracionUsuarioUno[$z]);
                        if($compararoracionunousuario === 0){
                            $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionUno++;
                        }
                    }

                    if(($contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionUno < $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionUno)){
                        if (!in_array($arraySeccionesOracionCorrectaUno[$u], $resultadoSeccionesIncorrectasOracionUsuarioUno)){
                            array_push($resultadoSeccionesIncorrectasOracionUsuarioUno, $arraySeccionesOracionCorrectaUno[$u]);
                        }
                        
                    }
                    $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionUno = 0;
                    $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionUno = 0;

                } 


                ///////////////////////////////////////FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL

                //return $resultadoSeccionesIncorrectasOracionUsuarioUno;



                //ACTUALIZACION
                //A TRAVES DEL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE PUEDE REEMPLAZAR CON "_" LOS ESPACIOS ADICIONALES QUE EL USUARIO HAYA AGREGADO 
                //A SU RESPUESTA, CUANDO LA RESPUESTA DEL USUARIO SEA ERRONEA. POR ESA RAZON EL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE ENVIA A LA VISTA
                //PARA MOSTRARLO CUANDO LAS ORACIONES NO COINCIDAN

                //PRIMERO SE RECORRE EL ARRAY Y CUANDO ENCUENTRE ESPACIOS VACIOS LOS VA A IR REEMPLAZANDO POR "_"
                for($b=0; $b<count($arraySeccionesOracionUsuarioUno); $b++){
                    if($arraySeccionesOracionUsuarioUno[$b] === ""){
                        $arraySeccionesOracionUsuarioUno[$b] = "_";
                    }
                }

                //LUEGO CON EL IMPLDE SE UNE EL ARRAY DE NUEVO PARA ENVIARLO A LA VISTA
                $stringSeccionesOracionUsuarioUno = implode(" ", $arraySeccionesOracionUsuarioUno);
                //A LA VISTA TAMBIEN SEE VA A ENVIAR UNA VARIABLE TIPO BOOLEAN QUE ENVIA FALSE SI NO HAY "_" EN EL 
                //ARRAYSECCIONESENUNCIADOUSUARIOUNO Y DEVUELVE TRUE SI ESQUE SI HAY "_" EN EL ARRAY
                //ESTO SE ENVIA A LA VISTA PARA QUE EN BASE A LO QUE DEVUELVA, APAREZCA EL MENSAJE DE QUE HAY ESPACIOS ADICIONALES
                //EN LA RESPUESTA DEL USUARIO O NO HAY ESPACIOS ADICIONALES EN LA RESPUESTA DEL USUARIO
                $existenEspaciosOracionUno = false;
                if(in_array("_", $arraySeccionesOracionUsuarioUno)){
                    $existenEspaciosOracionUno = true;
                }

                //return $stringSeccionesOracionUsuarioUno;



                //ACTUALIZACION
                //ANTES DE ENVIAR EL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO
                //SE AGREGA ARRAYUNIQUE Y SE REEMPLAZA LOS ESPACIOS VACIOS "" POR LA PALABRA "ESPACIOS VACIOS"
                //EL ARRAYUNIQUE SE REALIZO EN LA VISTA, REVISAR EN LA SECCION DONDE SE RECORRE EL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO
                //EN LA VISTA
                
                for($u=0; $u<count($resultadoSeccionesIncorrectasOracionUsuarioUno); $u++){
                    if($resultadoSeccionesIncorrectasOracionUsuarioUno[$u] === ""){
                        $resultadoSeccionesIncorrectasOracionUsuarioUno[$u] = "Espacios en blanco.";
                    }
                }

                //return $resultadoSeccionesIncorrectasOracionUsuarioUno;

                //EN EL FINAL SE ENVIA LA OBSERVACION A LA RESPUESTA
                //CON EL IF SE PREGUNTA SI NROELEMENTOSARRAYCARACTERESORACIONUNO ES IGUAL MENOR O MAYOR QUE LA RESPUESTA DEL USUARIO
                //Y SE ENVIA LA RESPUESTA SEGUN CORRESPONDA
                if($nroElementosArrayCaracteresOracionCorrectaUno === $nroElementosArrayCaracteresOracionUsuarioUno){
                    $respuestaOracionUno = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresOracionCorrectaUno < $nroElementosArrayCaracteresOracionUsuarioUno){
                    //$respuestaOracionUno = "Su respuesta es incorrecta. Puede contener letras, signos ortográficos incorrectos o más de un espacio entre palabras.";
                    $respuestaOracionUno = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresOracionCorrectaUno > $nroElementosArrayCaracteresOracionUsuarioUno){
                    //$respuestaOracionUno = "Su respuesta es incorrecta. Ha omitido algunos elementos en un respuesta.";
                    $respuestaOracionUno = "Su respuesta es incorrecta.";
                }else{
                    //$respuestaOracionUno = "Su respuesta es incorrecta. Tiene algunos errores que se detallan abajo.";
                    $respuestaOracionUno = "Su respuesta es incorrecta.";
                }



                //ACTUALIZACION
                //SE VERIFICA SI EN EL ARRAY $resultadoSeccionesIncorrectasEnunciadoUsuarioUno TODOS LOS ELEMENTOS SON "Espacios en blanco."
                //SI ES ASI, EN LA VARIABLE $hayUnEspacioEnBlancoEnunciadoUno SE ENVIA TRUE, CASO CONTRARIO SE ENVIA FALSE
               

                $hayUnEspacioEnBlancoOracionUno = false;
                
                //SE RECORRE EL ARRAY DE LAS SECCIONES INCORRECTAS Y SE COMPARA SI TODOS LOS ELEMENTOS SON ESPACIOS EN BLANCO
                $contadorEspaciosOracionUno = 0;
                for($f=0; $f< count($resultadoSeccionesIncorrectasOracionUsuarioUno); $f++){
                    if($resultadoSeccionesIncorrectasOracionUsuarioUno[$f] === "Espacios en blanco."){
                        $contadorEspaciosOracionUno++;
                    }
                }
                if($contadorEspaciosOracionUno === count($resultadoSeccionesIncorrectasOracionUsuarioUno)){
                    $hayUnEspacioEnBlancoOracionUno = true;
                }

                //CON EL IN ARRAY SE COMPRUEBA SI HAY ESPACIOS EN BLANCO EN EL ARRAY DE SECCIONESINCORRECTAS
                //ESTO SIRVE PARA MOSTRAR UN MENSAJE EN LA VISTA DE QUE EL USUARIO TIENE ESPACIOS EN BLANCO
                //Y ADEMAS OTROS ELEMENTOS INCORRECTOS
                $mensajeEspacioBlancoOracionUno = false;
                if(in_array("Espacios en blanco.", $resultadoSeccionesIncorrectasOracionUsuarioUno)){
                    $mensajeEspacioBlancoOracionUno = true;
                }

                //return $mensajeEspacioBlancoOracionUno;

            }



            ////////////////////////////////////////////////////////////////

            //SI LOS ARRAYS DE ARRIBA DAN PROBLEMAS CON LAS PALABRAS REPETIDAS, SE PUEDE TRATAR CON ESTA PARTE
            //DESPUES DEL IF DENTRO DEL CICLO FOR, SE CREO OTRO IF ADICIONAL QUE ALMACENA PALABRAS REPETIDAS

            //$correctArray = ["Me", "gusta", "hacer", "deporte", "el", "futbol", "es", "divertido", "deporte"];

            //$textArray = ["Me", "gusta", "hacer", "deporte", "el", "futbol", "es", "divertido", "deporte"];

            //$finalArray = [];

            //for($i=0; $i<count($textArray); $i++){
            //    if(!in_array($textArray[$i], $correctArray)){
            //        array_push($finalArray, $textArray[$i]);
            //    }
            
            //    // count how many times the string appear in the array
            //    $total_string_in_array = array_count_values($textArray)[$textArray[$i]];
           //     if ($total_string_in_array > 1) {
            //        // check if the duplicate string already exists inside $finalArray
            //        if ( ! in_array($textArray[$i], $finalArray)) {
            //            array_push($finalArray, $textArray[$i]);
            //        }
           //     }
           // }

            
            //return $finalArray;



            ////////////////////////////////////////////////////////////////



            //COMPROBACION ORACION DOS

            //VARIABLES PARA LA ORACION DOS
            $caracteresCorrectosDos = [];
            $caracteresIncorrectosDos = [];
            $palabrasCorrectasDos = [];
            $palabrasIncorrectasDos = [];
            $seccionesCorrectasDos = [];
            $seccionesIncorrectasDos = [];

            $resultadoPalabrasIncorrectasUsuarioDos = [];
            $resultadoSignosIncorrectosUsuarioDos = [];
            $resultadoPalabrasQueLeFaltaronAlUsuarioDos = [];
            $resultadoSignosQueLeFaltaronAlUsuarioDos = [];
            $resultadoSeccionesQueLeFaltaronAlUsuarioDos = [];
            //ACTUALIZACION SE AGREGA ESTE ARRAY PARA PODER PINTAR EN LA VISTA LAS SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS
            $resultadoSeccionesIncorrectasOracionUsuarioDos = [];

            $compararOracionDos = strcmp($oracionCorrectaDos, $oracionUsuarioDos);

            if($compararOracionDos === 0){
                //SI ES IGUAL A CERO, LA PALABRA DEL USUARIO ES CORRECTA
                $respuestaOracionDos = "Su respuesta al segundo enunciado es correcta.";

                $resultadoPalabrasIncorrectasUsuarioDos = [];
                $resultadoSignosIncorrectosUsuarioDos = [];
                $resultadoPalabrasQueLeFaltaronAlUsuarioDos = [];
                $resultadoSignosQueLeFaltaronAlUsuarioDos = [];
                $resultadoSeccionesQueLeFaltaronAlUsuarioDos = [];
                //ACTUALIZACION SE AGREGA ESTE NUEVO ARRAY
                $resultadoSeccionesIncorrectasOracionUsuarioDos = [];
                //ACTUALIZACION SE AGREGA ESTE CAMPO QUE CONTIENE LA RESPUESTA DEL USUARIO
                $stringSeccionesOracionUsuarioDos = $oracionUsuarioDos;
                //ACTUALIZACION, SE ENVIA ESTE CAMPO PARA VER SI HAY ESPACIOS O NO EN LA RESPUESTA
                //COMO EN ESTE CASO NO HAY ESPACIOS ADICIONALES PORQUE LA RESPUESTA ES CORRECTA, SE ENVIA FALSE
                $existenEspaciosOracionDos = false;
                //ACTUALIZACION, SI EL TEXTO ES CORRECTO LA VARIABLE hayUnEspacioEnBlancoEnunciadoDos SE ENVIA FALSE
                $hayUnEspacioEnBlancoOracionDos = false;
                //ACTUALIZACION, LA VARIABLE PARA MOSTRAR EL MENSAJE ES FALSA SI LA RESPUESTA ES CORRECTA
                $mensajeEspacioBlancoOracionDos = false;
            
            }else{

                $nroCaracteresOracionUsuarioDos = mb_strlen($oracionUsuarioDos, 'UTF-8');
                $nroCaracteresOracionCorrectaDos = mb_strlen($oracionCorrectaDos, 'UTF-8');

                $arrayCaracteresOracionUsuarioDos = mb_str_split($oracionUsuarioDos);
                $arrayCaracteresOracionCorrectaDos = mb_str_split($oracionCorrectaDos);

                $arraySeccionesOracionCorrectaDos = explode(' ', $oracionCorrectaDos);
                $arraySeccionesOracionUsuarioDos = explode(' ', $oracionUsuarioDos);

                $aPalabrasOracionCorrectaDos = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $oracionCorrectaDos);
                $arrayPalabrasOracionCorrectaDos = explode(' ', $aPalabrasOracionCorrectaDos);
                $aPalabrasOracionUsuarioDos = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $oracionUsuarioDos);
                $arrayPalabrasOracionUsuarioDos = explode(' ', $aPalabrasOracionUsuarioDos);

                $nroElementosArrayCaracteresOracionUsuarioDos = count($arrayCaracteresOracionUsuarioDos);
                $nroElementosArrayCaracteresOracionCorrectaDos = count($arrayCaracteresOracionCorrectaDos);
                $arraySignosOracionUsuarioDos = [];
                $arraySignosOracionCorrectaDos = [];

                for($i=0; $i<$nroElementosArrayCaracteresOracionUsuarioDos; $i++){
                    if((strcmp($arrayCaracteresOracionUsuarioDos[$i], ',') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], ':') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], ';') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioDos[$i], '-') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '+') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '/') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioDos[$i], '.') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '...') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '....') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioDos[$i], '&') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '!') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '¡') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioDos[$i], '?') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '¿') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '"') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioDos[$i], ')') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '(') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '..') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioDos[$i], '*') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], "'") === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '[') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioDos[$i], ']') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '{') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '}') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioDos[$i], '_') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '^') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '#') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioDos[$i], '<') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '>') === 0) || (strcmp($arrayCaracteresOracionUsuarioDos[$i], '|') === 0)){

                        array_push($arraySignosOracionUsuarioDos, $arrayCaracteresOracionUsuarioDos[$i]);
                    }
                }


                for($m=0; $m<$nroElementosArrayCaracteresOracionCorrectaDos; $m++){
                    if((strcmp($arrayCaracteresOracionCorrectaDos[$m], ',') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], ':') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], ';') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaDos[$m], '-') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '+') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '/') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaDos[$m], '.') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '...') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '....') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaDos[$m], '&') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '!') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '¡') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaDos[$m], '?') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '¿') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '"') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaDos[$m], ')') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '(') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '..') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaDos[$m], '*') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], "'") === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '[') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaDos[$m], ']') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '{') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '}') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaDos[$m], '_') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '^') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '#') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaDos[$m], '<') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '>') === 0) || (strcmp($arrayCaracteresOracionCorrectaDos[$m], '|') === 0)){

                        array_push($arraySignosOracionCorrectaDos, $arrayCaracteresOracionCorrectaDos[$m]);
                    }
                }


                $nroElementosArrayPalabrasOracionUsuarioDos = count($arrayPalabrasOracionUsuarioDos);
                $nroElementosArrayPalabrasOracionCorrectaDos = count($arrayPalabrasOracionCorrectaDos);
                $nroElementosArraySignosOracionUsuarioDos = count($arraySignosOracionUsuarioDos);
                $nroElementosArraySignosOracionCorrectaDos = count($arraySignosOracionCorrectaDos);
                $nroElementosArraySeccionesOracionUsuarioDos = count($arraySeccionesOracionUsuarioDos);
                $nroElementosArraySeccionesOracionCorrectaDos = count($arraySeccionesOracionCorrectaDos);

                for($e=0; $e<$nroElementosArrayPalabrasOracionUsuarioDos; $e++){
                    if(!in_array($arrayPalabrasOracionUsuarioDos[$e], $arrayPalabrasOracionCorrectaDos)){
                        array_push($resultadoPalabrasIncorrectasUsuarioDos, $arrayPalabrasOracionUsuarioDos[$e]);
                    }
                }

                for($r=0; $r<$nroElementosArraySignosOracionUsuarioDos; $r++){
                    if(!in_array($arraySignosOracionUsuarioDos[$r], $arraySignosOracionCorrectaDos)){
                        array_push($resultadoSignosIncorrectosUsuarioDos, $arraySignosOracionUsuarioDos[$r]);
                    }
                }

                for($f=0; $f<$nroElementosArrayPalabrasOracionCorrectaDos; $f++){
                    if(!in_array($arrayPalabrasOracionCorrectaDos[$f], $arrayPalabrasOracionUsuarioDos)){
                        array_push($resultadoPalabrasQueLeFaltaronAlUsuarioDos, $arrayPalabrasOracionCorrectaDos[$f]);
                    }
                }

                for($j=0; $j<$nroElementosArraySignosOracionCorrectaDos; $j++){
                    if(!in_array($arraySignosOracionCorrectaDos[$j], $arraySignosOracionUsuarioDos)){
                        array_push($resultadoSignosQueLeFaltaronAlUsuarioDos, $arraySignosOracionCorrectaDos[$j]);
                    }
                }

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIODOS ORIGINAL
                //for($d=0; $d<$nroElementosArraySeccionesOracionCorrectaDos; $d++){
                //    if(!in_array($arraySeccionesOracionCorrectaDos[$d], $arraySeccionesOracionUsuarioDos)){
                //        array_push($resultadoSeccionesQueLeFaltaronAlUsuarioDos, $arraySeccionesOracionCorrectaDos[$d]);
                //    }
                //}


                //////////////////////////////////////// METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIODOS FINAL

                $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionDos = 0;
                $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionDos = 0;
                for($u=0; $u<$nroElementosArraySeccionesOracionCorrectaDos; $u++){

                    
                    for ($y=0; $y<$nroElementosArraySeccionesOracionCorrectaDos; $y++){
                        $compararoraciondos = strcmp($arraySeccionesOracionCorrectaDos[$u], $arraySeccionesOracionCorrectaDos[$y]);
                        if ($compararoraciondos === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionDos++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesOracionUsuarioDos); $z++){
                        $compararoraciondosusuario = strcmp($arraySeccionesOracionCorrectaDos[$u], $arraySeccionesOracionUsuarioDos[$z]);
                        if($compararoraciondosusuario === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionDos++;
                        }
                    }

                    if(($contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionDos > $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionDos)){
                        if (!in_array($arraySeccionesOracionCorrectaDos[$u], $resultadoSeccionesQueLeFaltaronAlUsuarioDos)){
                            array_push($resultadoSeccionesQueLeFaltaronAlUsuarioDos, $arraySeccionesOracionCorrectaDos[$u]);
                        }
                        
                    }
                    $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionDos = 0;
                    $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionDos = 0;
                }

                ///////////////////////////////////////// FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIODOS


                //ACTUALIZACION
                //EN EL ARRAY COMENTADO SE AGREGARAN LAS SECCIONES DE ORACION UNO DEL USUARIO QUE NO COINCIDAN CON LAS SECCIONES DE LA ORACION CORRECTA UNO
                // $resultadoSeccionesIncorrectasOracionUsuarioUno = [];
                //PARA LA COMPARACION, CON UN FOR SE RECORRE EL ARRAYSECCIONESORACIONUSUARIOUNO Y SE PREGUNTA SI LA SECCION [I] DE ESE ARRAY NO COINCIDE CON ALGUNA DE LAS SECCIONES DE LA ORACION CORRECTA
                //Y LAS SECCIONES DEL ARRAYSECCIONESORACIONUSUARIOUNO QUE NO COINCIDAN CON ALGUNA SECCION DEL ARRAYSECCIONESORACIONCORRECTAUNO, SE GUARDAN EN EL ARRAY
                //RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO PARA ENVIARLAS A LA VISTA

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIODOS ORIGINAL
                //for($p=0; $p<$nroElementosArraySeccionesOracionUsuarioDos; $p++){
                //
                //    if(!in_array($arraySeccionesOracionUsuarioDos[$p], $arraySeccionesOracionCorrectaDos)){
                //        array_push($resultadoSeccionesIncorrectasOracionUsuarioDos, $arraySeccionesOracionUsuarioDos[$p]);
                //    }
                //}

                //////////////////////////////////////METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIODOS FINAL

                //CAPTURAR LAS PALABRAS QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA Y AGREGARLAS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS
                for($b=0; $b<$nroElementosArraySeccionesOracionUsuarioDos; $b++){
                    if(!in_array($arraySeccionesOracionUsuarioDos[$b], $arraySeccionesOracionCorrectaDos)){
                        array_push($resultadoSeccionesIncorrectasOracionUsuarioDos, $arraySeccionesOracionUsuarioDos[$b]);
                    } 
                }

                //AGREGAR AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS LAS PALABRAS QUE SI FORMAN PARTE DEL TEXTO CORRECTO, PERO QUE ESTAN AGREGADAS EN DEMASIA
                //ES DECIR, EN EL TEXTO CORRECTO HAY 2 "HOLA" PERO EN LA RESPUESTA DEL USUARIO HAY 3 "HOLA", POR LO TANTO ES UNA PALABRA INCORRECTA.
                //ESTE METODO ESTÁ BASADO EN EL METODO PARA AGREGAR ELEMENTOS AL ARRAY $resultadoSeccionesQueLeFaltaronParrafoUsuario
                //LA DIFERENCIA ES QUE EN LA SECCION FINAL DE ESTE METODO SE CAMBIO EL METODO DE MAYOR QUE A MENOR QUE  

                $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionDos = 0;
                $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionDos = 0;
                for($u=0; $u<$nroElementosArraySeccionesOracionCorrectaDos; $u++){

                    for ($y=0; $y<$nroElementosArraySeccionesOracionCorrectaDos; $y++){
                        $compararoraciondos = strcmp($arraySeccionesOracionCorrectaDos[$u], $arraySeccionesOracionCorrectaDos[$y]);
                        if ($compararoraciondos === 0){
                            $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionDos++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesOracionUsuarioDos); $z++){
                        $compararoraciondosusuario = strcmp($arraySeccionesOracionCorrectaDos[$u], $arraySeccionesOracionUsuarioDos[$z]);
                        if($compararoraciondosusuario === 0){
                            $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionDos++;
                        }
                    }

                    if(($contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionDos < $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionDos)){
                        if (!in_array($arraySeccionesOracionCorrectaDos[$u], $resultadoSeccionesIncorrectasOracionUsuarioDos)){
                            array_push($resultadoSeccionesIncorrectasOracionUsuarioDos, $arraySeccionesOracionCorrectaDos[$u]);
                        }
                        
                    }
                    $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionDos = 0;
                    $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionDos = 0;

                } 


                ///////////////////////////////////////FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL


                //return $resultadoSeccionesIncorrectasOracionUsuarioDos;



                //ACTUALIZACION
                //A TRAVES DEL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE PUEDE REEMPLAZAR CON "_" LOS ESPACIOS ADICIONALES QUE EL USUARIO HAYA AGREGADO 
                //A SU RESPUESTA, CUANDO LA RESPUESTA DEL USUARIO SEA ERRONEA. POR ESA RAZON EL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE ENVIA A LA VISTA
                //PARA MOSTRARLO CUANDO LAS ORACIONES NO COINCIDAN

                //PRIMERO SE RECORRE EL ARRAY Y CUANDO ENCUENTRE ESPACIOS VACIOS LOS VA A IR REEMPLAZANDO POR "_"
                for($b=0; $b<count($arraySeccionesOracionUsuarioDos); $b++){
                    if($arraySeccionesOracionUsuarioDos[$b] === ""){
                        $arraySeccionesOracionUsuarioDos[$b] = "_";
                    }
                }

                //LUEGO CON EL IMPLDE SE UNE EL ARRAY DE NUEVO PARA ENVIARLO A LA VISTA
                $stringSeccionesOracionUsuarioDos = implode(" ", $arraySeccionesOracionUsuarioDos);
                //A LA VISTA TAMBIEN SEE VA A ENVIAR UNA VARIABLE TIPO BOOLEAN QUE ENVIA FALSE SI NO HAY "_" EN EL 
                //ARRAYSECCIONESENUNCIADOUSUARIOUNO Y DEVUELVE TRUE SI ESQUE SI HAY "_" EN EL ARRAY
                //ESTO SE ENVIA A LA VISTA PARA QUE EN BASE A LO QUE DEVUELVA, APAREZCA EL MENSAJE DE QUE HAY ESPACIOS ADICIONALES
                //EN LA RESPUESTA DEL USUARIO O NO HAY ESPACIOS ADICIONALES EN LA RESPUESTA DEL USUARIO
                $existenEspaciosOracionDos = false;
                if(in_array("_", $arraySeccionesOracionUsuarioDos)){
                    $existenEspaciosOracionDos = true;
                }

                //return $stringSeccionesOracionUsuarioDos;



                //ACTUALIZACION
                //ANTES DE ENVIAR EL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO
                //SE AGREGA ARRAYUNIQUE Y SE REEMPLAZA LOS ESPACIOS VACIOS "" POR LA PALABRA "ESPACIOS VACIOS"
                //EL ARRAYUNIQUE SE REALIZO EN LA VISTA, REVISAR EN LA SECCION DONDE SE RECORRE EL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO
                //EN LA VISTA
                
                for($u=0; $u<count($resultadoSeccionesIncorrectasOracionUsuarioDos); $u++){
                    if($resultadoSeccionesIncorrectasOracionUsuarioDos[$u] === ""){
                        $resultadoSeccionesIncorrectasOracionUsuarioDos[$u] = "Espacios en blanco.";
                    }
                }

                //return $resultadoSeccionesIncorrectasOracionUsuarioDos;


                if($nroElementosArrayCaracteresOracionCorrectaDos === $nroElementosArrayCaracteresOracionUsuarioDos){
                    $respuestaOracionDos = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresOracionCorrectaDos < $nroElementosArrayCaracteresOracionUsuarioDos){
                    //$respuestaOracionDos = "Su respuesta es incorrecta. Puede contener letras, signos ortográficos incorrectos o más de un espacio entre palabras.";
                    $respuestaOracionDos = "Su respuesta es incorrecta.";   
                }
                elseif($nroElementosArrayCaracteresOracionCorrectaDos > $nroElementosArrayCaracteresOracionUsuarioDos){
                    //$respuestaOracionDos = "Su respuesta es incorrecta. Ha omitido algunos elementos en un respuesta.";
                    $respuestaOracionDos = "Su respuesta es incorrecta.";
                }else{
                    //$respuestaOracionDos = "Su respuesta es incorrecta. Tiene algunos errores que se detallan abajo.";
                    $respuestaOracionDos = "Su respuesta es incorrecta.";
                }



                //ACTUALIZACION
                //SE VERIFICA SI EN EL ARRAY $resultadoSeccionesIncorrectasEnunciadoUsuarioUno TODOS LOS ELEMENTOS SON "Espacios en blanco."
                //SI ES ASI, EN LA VARIABLE $hayUnEspacioEnBlancoEnunciadoUno SE ENVIA TRUE, CASO CONTRARIO SE ENVIA FALSE
               

                $hayUnEspacioEnBlancoOracionDos = false;
                
                //SE RECORRE EL ARRAY DE LAS SECCIONES INCORRECTAS Y SE COMPARA SI TODOS LOS ELEMENTOS SON ESPACIOS EN BLANCO
                $contadorEspaciosOracionDos = 0;
                for($f=0; $f< count($resultadoSeccionesIncorrectasOracionUsuarioDos); $f++){
                    if($resultadoSeccionesIncorrectasOracionUsuarioDos[$f] === "Espacios en blanco."){
                        $contadorEspaciosOracionDos++;
                    }
                }
                if($contadorEspaciosOracionDos === count($resultadoSeccionesIncorrectasOracionUsuarioDos)){
                    $hayUnEspacioEnBlancoOracionDos = true;
                }

                //CON EL IN ARRAY SE COMPRUEBA SI HAY ESPACIOS EN BLANCO EN EL ARRAY DE SECCIONESINCORRECTAS
                //ESTO SIRVE PARA MOSTRAR UN MENSAJE EN LA VISTA DE QUE EL USUARIO TIENE ESPACIOS EN BLANCO
                //Y ADEMAS OTROS ELEMENTOS INCORRECTOS
                $mensajeEspacioBlancoOracionDos = false;
                if(in_array("Espacios en blanco.", $resultadoSeccionesIncorrectasOracionUsuarioDos)){
                    $mensajeEspacioBlancoOracionDos = true;
                }

                //return $mensajeEspacioBlancoOracionDos;




            }


            //COMPROBACION ORACION TRES

            //VARIABLES PARA LA ORACION TRES
            $caracteresCorrectosTres = [];
            $caracteresIncorrectosTres = [];
            $palabrasCorrectasTres = [];
            $palabrasIncorrectasTres = [];
            $seccionesCorrectasTres = [];
            $seccionesIncorrectasTres = [];

            $resultadoPalabrasIncorrectasUsuarioTres = [];
            $resultadoSignosIncorrectosUsuarioTres = [];
            $resultadoPalabrasQueLeFaltaronAlUsuarioTres = [];
            $resultadoSignosQueLeFaltaronAlUsuarioTres = [];
            $resultadoSeccionesQueLeFaltaronAlUsuarioTres = [];
            //ACTUALIZACION SE AGREGA ESTE ARRAY PARA PODER PINTAR EN LA VISTA LAS SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS
            $resultadoSeccionesIncorrectasOracionUsuarioTres = [];

            $compararOracionTres = strcmp($oracionCorrectaTres, $oracionUsuarioTres);

            if($compararOracionTres === 0){
                //SI ES IGUAL A CERO, LA PALABRA DEL USUARIO ES CORRECTA
                $respuestaOracionTres = "Su respuesta al tercer enunciado es correcta.";

                $resultadoPalabrasIncorrectasUsuarioTres = [];
                $resultadoSignosIncorrectosUsuarioTres = [];
                $resultadoPalabrasQueLeFaltaronAlUsuarioTres = [];
                $resultadoSignosQueLeFaltaronAlUsuarioTres = [];
                $resultadoSeccionesQueLeFaltaronAlUsuarioTres = [];
                //ACTUALIZACION SE AGREGA ESTE NUEVO ARRAY
                $resultadoSeccionesIncorrectasOracionUsuarioTres = [];
                //ACTUALIZACION SE AGREGA ESTE CAMPO QUE CONTIENE LA RESPUESTA DEL USUARIO
                $stringSeccionesOracionUsuarioTres = $oracionUsuarioTres;
                //ACTUALIZACION, SE ENVIA ESTE CAMPO PARA VER SI HAY ESPACIOS O NO EN LA RESPUESTA
                //COMO EN ESTE CASO NO HAY ESPACIOS ADICIONALES PORQUE LA RESPUESTA ES CORRECTA, SE ENVIA FALSE
                $existenEspaciosOracionTres = false;
                //ACTUALIZACION, SI EL TEXTO ES CORRECTO LA VARIABLE hayUnEspacioEnBlancoEnunciadoDos SE ENVIA FALSE
                $hayUnEspacioEnBlancoOracionTres = false;
                //ACTUALIZACION, LA VARIABLE PARA MOSTRAR EL MENSAJE ES FALSA SI LA RESPUESTA ES CORRECTA
                $mensajeEspacioBlancoOracionTres = false;
            
            }else{

                $nroCaracteresOracionUsuarioTres = mb_strlen($oracionUsuarioTres, 'UTF-8');
                $nroCaracteresOracionCorrectaTres = mb_strlen($oracionCorrectaTres, 'UTF-8');

                $arrayCaracteresOracionUsuarioTres = mb_str_split($oracionUsuarioTres);
                $arrayCaracteresOracionCorrectaTres = mb_str_split($oracionCorrectaTres);

                $arraySeccionesOracionCorrectaTres = explode(' ', $oracionCorrectaTres);
                $arraySeccionesOracionUsuarioTres = explode(' ', $oracionUsuarioTres);

                $aPalabrasOracionCorrectaTres = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $oracionCorrectaTres);
                $arrayPalabrasOracionCorrectaTres = explode(' ', $aPalabrasOracionCorrectaTres);
                $aPalabrasOracionUsuarioTres = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $oracionUsuarioTres);
                $arrayPalabrasOracionUsuarioTres = explode(' ', $aPalabrasOracionUsuarioTres);

                $nroElementosArrayCaracteresOracionUsuarioTres = count($arrayCaracteresOracionUsuarioTres);
                $nroElementosArrayCaracteresOracionCorrectaTres = count($arrayCaracteresOracionCorrectaTres);
                $arraySignosOracionUsuarioTres = [];
                $arraySignosOracionCorrectaTres = [];

                for($i=0; $i<$nroElementosArrayCaracteresOracionUsuarioTres; $i++){
                    if((strcmp($arrayCaracteresOracionUsuarioTres[$i], ',') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], ':') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], ';') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioTres[$i], '-') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '+') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '/') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioTres[$i], '.') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '...') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '....') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioTres[$i], '&') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '!') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '¡') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioTres[$i], '?') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '¿') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '"') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioTres[$i], ')') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '(') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '..') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioTres[$i], '*') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], "'") === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '[') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioTres[$i], ']') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '{') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '}') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioTres[$i], '_') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '^') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '#') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioTres[$i], '<') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '>') === 0) || (strcmp($arrayCaracteresOracionUsuarioTres[$i], '|') === 0)){

                        array_push($arraySignosOracionUsuarioTres, $arrayCaracteresOracionUsuarioTres[$i]);
                    }
                }


                for($m=0; $m<$nroElementosArrayCaracteresOracionCorrectaTres; $m++){
                    if((strcmp($arrayCaracteresOracionCorrectaTres[$m], ',') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], ':') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], ';') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaTres[$m], '-') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '+') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '/') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaTres[$m], '.') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '...') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '....') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaTres[$m], '&') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '!') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '¡') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaTres[$m], '?') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '¿') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '"') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaTres[$m], ')') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '(') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '..') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaTres[$m], '*') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], "'") === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '[') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaTres[$m], ']') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '{') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '}') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaTres[$m], '_') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '^') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '#') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaTres[$m], '<') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '>') === 0) || (strcmp($arrayCaracteresOracionCorrectaTres[$m], '|') === 0)){

                        array_push($arraySignosOracionCorrectaTres, $arrayCaracteresOracionCorrectaTres[$m]);
                    }
                }

                $nroElementosArrayPalabrasOracionUsuarioTres = count($arrayPalabrasOracionUsuarioTres);
                $nroElementosArrayPalabrasOracionCorrectaTres = count($arrayPalabrasOracionCorrectaTres);
                $nroElementosArraySignosOracionUsuarioTres = count($arraySignosOracionUsuarioTres);
                $nroElementosArraySignosOracionCorrectaTres = count($arraySignosOracionCorrectaTres);
                $nroElementosArraySeccionesOracionUsuarioTres = count($arraySeccionesOracionUsuarioTres);
                $nroElementosArraySeccionesOracionCorrectaTres = count($arraySeccionesOracionCorrectaTres);

                for($e=0; $e<$nroElementosArrayPalabrasOracionUsuarioTres; $e++){
                    if(!in_array($arrayPalabrasOracionUsuarioTres[$e], $arrayPalabrasOracionCorrectaTres)){
                        array_push($resultadoPalabrasIncorrectasUsuarioTres, $arrayPalabrasOracionUsuarioTres[$e]);
                    }
                }

                for($r=0; $r<$nroElementosArraySignosOracionUsuarioTres; $r++){
                    if(!in_array($arraySignosOracionUsuarioTres[$r], $arraySignosOracionCorrectaTres)){
                        array_push($resultadoSignosIncorrectosUsuarioTres, $arraySignosOracionUsuarioTres[$r]);
                    }
                }

                for($f=0; $f<$nroElementosArrayPalabrasOracionCorrectaTres; $f++){
                    if(!in_array($arrayPalabrasOracionCorrectaTres[$f], $arrayPalabrasOracionUsuarioTres)){
                        array_push($resultadoPalabrasQueLeFaltaronAlUsuarioTres, $arrayPalabrasOracionCorrectaTres[$f]);
                    }
                }

                for($j=0; $j<$nroElementosArraySignosOracionCorrectaTres; $j++){
                    if(!in_array($arraySignosOracionCorrectaTres[$j], $arraySignosOracionUsuarioTres)){
                        array_push($resultadoSignosQueLeFaltaronAlUsuarioTres, $arraySignosOracionCorrectaTres[$j]);
                    }
                }

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOTRES ORIGINAL
                //for($d=0; $d<$nroElementosArraySeccionesOracionCorrectaTres; $d++){
                //    if(!in_array($arraySeccionesOracionCorrectaTres[$d], $arraySeccionesOracionUsuarioTres)){
                //        array_push($resultadoSeccionesQueLeFaltaronAlUsuarioTres, $arraySeccionesOracionCorrectaTres[$d]);
                //    }
                //}

                //////////////////////////////////////// METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO FINAL

                $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionTres = 0;
                $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionTres = 0;
                for($u=0; $u<$nroElementosArraySeccionesOracionCorrectaTres; $u++){

                    
                    for ($y=0; $y<$nroElementosArraySeccionesOracionCorrectaTres; $y++){
                        $compararoraciontres = strcmp($arraySeccionesOracionCorrectaTres[$u], $arraySeccionesOracionCorrectaTres[$y]);
                        if ($compararoraciontres === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionTres++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesOracionUsuarioTres); $z++){
                        $compararoraciontresusuario = strcmp($arraySeccionesOracionCorrectaTres[$u], $arraySeccionesOracionUsuarioTres[$z]);
                        if($compararoraciontresusuario === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionTres++;
                        }
                    }

                    if(($contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionTres > $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionTres)){
                        if (!in_array($arraySeccionesOracionCorrectaTres[$u], $resultadoSeccionesQueLeFaltaronAlUsuarioTres)){
                            array_push($resultadoSeccionesQueLeFaltaronAlUsuarioTres, $arraySeccionesOracionCorrectaTres[$u]);
                        }
                        
                    }
                    $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionTres = 0;
                    $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionTres = 0;
                }

                ///////////////////////////////////////// FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO



                //ACTUALIZACION
                //EN EL ARRAY COMENTADO SE AGREGARAN LAS SECCIONES DE ORACION UNO DEL USUARIO QUE NO COINCIDAN CON LAS SECCIONES DE LA ORACION CORRECTA UNO
                // $resultadoSeccionesIncorrectasOracionUsuarioUno = [];
                //PARA LA COMPARACION, CON UN FOR SE RECORRE EL ARRAYSECCIONESORACIONUSUARIOUNO Y SE PREGUNTA SI LA SECCION [I] DE ESE ARRAY NO COINCIDE CON ALGUNA DE LAS SECCIONES DE LA ORACION CORRECTA
                //Y LAS SECCIONES DEL ARRAYSECCIONESORACIONUSUARIOUNO QUE NO COINCIDAN CON ALGUNA SECCION DEL ARRAYSECCIONESORACIONCORRECTAUNO, SE GUARDAN EN EL ARRAY
                //RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO PARA ENVIARLAS A LA VISTA

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOTRES ORIGINAL
                //for($p=0; $p<$nroElementosArraySeccionesOracionUsuarioTres; $p++){
                //
                //    if(!in_array($arraySeccionesOracionUsuarioTres[$p], $arraySeccionesOracionCorrectaTres)){
                //        array_push($resultadoSeccionesIncorrectasOracionUsuarioTres, $arraySeccionesOracionUsuarioTres[$p]);
                //    }
                //}

                //return $resultadoSeccionesIncorrectasOracionUsuarioTres;

                //////////////////////////////////////METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL

                //CAPTURAR LAS PALABRAS QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA Y AGREGARLAS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS
                for($b=0; $b<$nroElementosArraySeccionesOracionUsuarioTres; $b++){
                    if(!in_array($arraySeccionesOracionUsuarioTres[$b], $arraySeccionesOracionCorrectaTres)){
                        array_push($resultadoSeccionesIncorrectasOracionUsuarioTres, $arraySeccionesOracionUsuarioTres[$b]);
                    }
                }

                //AGREGAR AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS LAS PALABRAS QUE SI FORMAN PARTE DEL TEXTO CORRECTO, PERO QUE ESTAN AGREGADAS EN DEMASIA
                //ES DECIR, EN EL TEXTO CORRECTO HAY 2 "HOLA" PERO EN LA RESPUESTA DEL USUARIO HAY 3 "HOLA", POR LO TANTO ES UNA PALABRA INCORRECTA.
                //ESTE METODO ESTÁ BASADO EN EL METODO PARA AGREGAR ELEMENTOS AL ARRAY $resultadoSeccionesQueLeFaltaronParrafoUsuario
                //LA DIFERENCIA ES QUE EN LA SECCION FINAL DE ESTE METODO SE CAMBIO EL METODO DE MAYOR QUE A MENOR QUE  

                $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionTres = 0;
                $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionTres = 0;
                for($u=0; $u<$nroElementosArraySeccionesOracionCorrectaTres; $u++){

                    for ($y=0; $y<$nroElementosArraySeccionesOracionCorrectaTres; $y++){
                        $compararoraciontres = strcmp($arraySeccionesOracionCorrectaTres[$u], $arraySeccionesOracionCorrectaTres[$y]);
                        if ($compararoraciontres === 0){
                            $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionTres++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesOracionUsuarioTres); $z++){
                        $compararoraciontresusuario = strcmp($arraySeccionesOracionCorrectaTres[$u], $arraySeccionesOracionUsuarioTres[$z]);
                        if($compararoraciontresusuario === 0){
                            $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionTres++;
                        }
                    }

                    if(($contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionTres < $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionTres)){
                        if (!in_array($arraySeccionesOracionCorrectaTres[$u], $resultadoSeccionesIncorrectasOracionUsuarioTres)){
                            array_push($resultadoSeccionesIncorrectasOracionUsuarioTres, $arraySeccionesOracionCorrectaTres[$u]);
                        }
                        
                    }
                    $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionTres = 0;
                    $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionTres = 0;

                } 


                ///////////////////////////////////////FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL




                //ACTUALIZACION
                //A TRAVES DEL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE PUEDE REEMPLAZAR CON "_" LOS ESPACIOS ADICIONALES QUE EL USUARIO HAYA AGREGADO 
                //A SU RESPUESTA, CUANDO LA RESPUESTA DEL USUARIO SEA ERRONEA. POR ESA RAZON EL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE ENVIA A LA VISTA
                //PARA MOSTRARLO CUANDO LAS ORACIONES NO COINCIDAN

                //PRIMERO SE RECORRE EL ARRAY Y CUANDO ENCUENTRE ESPACIOS VACIOS LOS VA A IR REEMPLAZANDO POR "_"
                for($b=0; $b<count($arraySeccionesOracionUsuarioTres); $b++){
                    if($arraySeccionesOracionUsuarioTres[$b] === ""){
                        $arraySeccionesOracionUsuarioTres[$b] = "_";
                    }
                }

                //LUEGO CON EL IMPLDE SE UNE EL ARRAY DE NUEVO PARA ENVIARLO A LA VISTA
                $stringSeccionesOracionUsuarioTres = implode(" ", $arraySeccionesOracionUsuarioTres);
                //A LA VISTA TAMBIEN SEE VA A ENVIAR UNA VARIABLE TIPO BOOLEAN QUE ENVIA FALSE SI NO HAY "_" EN EL 
                //ARRAYSECCIONESENUNCIADOUSUARIOUNO Y DEVUELVE TRUE SI ESQUE SI HAY "_" EN EL ARRAY
                //ESTO SE ENVIA A LA VISTA PARA QUE EN BASE A LO QUE DEVUELVA, APAREZCA EL MENSAJE DE QUE HAY ESPACIOS ADICIONALES
                //EN LA RESPUESTA DEL USUARIO O NO HAY ESPACIOS ADICIONALES EN LA RESPUESTA DEL USUARIO
                $existenEspaciosOracionTres = false;
                if(in_array("_", $arraySeccionesOracionUsuarioTres)){
                    $existenEspaciosOracionTres = true;
                }

                //return $stringSeccionesOracionUsuarioTres;



                //ACTUALIZACION
                //ANTES DE ENVIAR EL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO
                //SE AGREGA ARRAYUNIQUE Y SE REEMPLAZA LOS ESPACIOS VACIOS "" POR LA PALABRA "ESPACIOS VACIOS"
                //EL ARRAYUNIQUE SE REALIZO EN LA VISTA, REVISAR EN LA SECCION DONDE SE RECORRE EL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO
                //EN LA VISTA
                
                for($u=0; $u<count($resultadoSeccionesIncorrectasOracionUsuarioTres); $u++){
                    if($resultadoSeccionesIncorrectasOracionUsuarioTres[$u] === ""){
                        $resultadoSeccionesIncorrectasOracionUsuarioTres[$u] = "Espacios en blanco.";
                    }
                }

                //return $resultadoSeccionesIncorrectasOracionUsuarioTres;

                if($nroElementosArrayCaracteresOracionCorrectaTres === $nroElementosArrayCaracteresOracionUsuarioTres){
                    $respuestaOracionTres = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresOracionCorrectaTres < $nroElementosArrayCaracteresOracionUsuarioTres){
                    //$respuestaOracionTres = "Su respuesta es incorrecta. Puede contener letras, signos ortográficos incorrectos o más de un espacio entre palabras.";
                    $respuestaOracionTres = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresOracionCorrectaTres > $nroElementosArrayCaracteresOracionUsuarioTres){
                    //$respuestaOracionTres = "Su respuesta es incorrecta. Ha omitido algunos elementos en un respuesta.";
                    $respuestaOracionTres = "Su respuesta es incorrecta.";
                }else{
                    //$respuestaOracionTres = "Su respuesta es incorrecta. Tiene algunos errores que se detallan abajo.";
                    $respuestaOracionTres = "Su respuesta es incorrecta.";
                }



                //ACTUALIZACION
                //SE VERIFICA SI EN EL ARRAY $resultadoSeccionesIncorrectasEnunciadoUsuarioUno TODOS LOS ELEMENTOS SON "Espacios en blanco."
                //SI ES ASI, EN LA VARIABLE $hayUnEspacioEnBlancoEnunciadoUno SE ENVIA TRUE, CASO CONTRARIO SE ENVIA FALSE
               

                $hayUnEspacioEnBlancoOracionTres = false;
                
                //SE RECORRE EL ARRAY DE LAS SECCIONES INCORRECTAS Y SE COMPARA SI TODOS LOS ELEMENTOS SON ESPACIOS EN BLANCO
                $contadorEspaciosOracionTres = 0;
                for($f=0; $f< count($resultadoSeccionesIncorrectasOracionUsuarioTres); $f++){
                    if($resultadoSeccionesIncorrectasOracionUsuarioTres[$f] === "Espacios en blanco."){
                        $contadorEspaciosOracionTres++;
                    }
                }
                if($contadorEspaciosOracionTres === count($resultadoSeccionesIncorrectasOracionUsuarioTres)){
                    $hayUnEspacioEnBlancoOracionTres = true;
                }

                //CON EL IN ARRAY SE COMPRUEBA SI HAY ESPACIOS EN BLANCO EN EL ARRAY DE SECCIONESINCORRECTAS
                //ESTO SIRVE PARA MOSTRAR UN MENSAJE EN LA VISTA DE QUE EL USUARIO TIENE ESPACIOS EN BLANCO
                //Y ADEMAS OTROS ELEMENTOS INCORRECTOS
                $mensajeEspacioBlancoOracionTres = false;
                if(in_array("Espacios en blanco.", $resultadoSeccionesIncorrectasOracionUsuarioTres)){
                    $mensajeEspacioBlancoOracionTres = true;
                }

                //return $mensajeEspacioBlancoOracionTres;



            }


            //COMPROBACION ORACION CUATRO

            //VARIABLES PARA LA ORACION CUATRO
            $caracteresCorrectosCuatro = [];
            $caracteresIncorrectosCuatro = [];
            $palabrasCorrectasCuatro = [];
            $palabrasIncorrectasCuatro = [];
            $seccionesCorrectasCuatro = [];
            $seccionesIncorrectasCuatro = [];

            $resultadoPalabrasIncorrectasUsuarioCuatro = [];
            $resultadoSignosIncorrectosUsuarioCuatro = [];
            $resultadoPalabrasQueLeFaltaronAlUsuarioCuatro = [];
            $resultadoSignosQueLeFaltaronAlUsuarioCuatro = [];
            $resultadoSeccionesQueLeFaltaronAlUsuarioCuatro = [];
            //ACTUALIZACION SE AGREGA ESTE ARRAY PARA PODER PINTAR EN LA VISTA LAS SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS
            $resultadoSeccionesIncorrectasOracionUsuarioCuatro = [];

            $compararOracionCuatro = strcmp($oracionCorrectaCuatro, $oracionUsuarioCuatro);

            if($compararOracionCuatro === 0){
                //SI ES IGUAL A CERO, LA PALABRA DEL USUARIO ES CORRECTA
                $respuestaOracionCuatro = "Su respuesta al cuarto enunciado es correcta.";

                $resultadoPalabrasIncorrectasUsuarioCuatro = [];
                $resultadoSignosIncorrectosUsuarioCuatro = [];
                $resultadoPalabrasQueLeFaltaronAlUsuarioCuatro = [];
                $resultadoSignosQueLeFaltaronAlUsuarioCuatro = [];
                $resultadoSeccionesQueLeFaltaronAlUsuarioCuatro = [];
                //ACTUALIZACION SE AGREGA ESTE NUEVO ARRAY
                $resultadoSeccionesIncorrectasOracionUsuarioCuatro = [];
                //ACTUALIZACION SE AGREGA ESTE CAMPO QUE CONTIENE LA RESPUESTA DEL USUARIO
                $stringSeccionesOracionUsuarioCuatro = $oracionUsuarioCuatro;
                //ACTUALIZACION, SE ENVIA ESTE CAMPO PARA VER SI HAY ESPACIOS O NO EN LA RESPUESTA
                //COMO EN ESTE CASO NO HAY ESPACIOS ADICIONALES PORQUE LA RESPUESTA ES CORRECTA, SE ENVIA FALSE
                $existenEspaciosOracionCuatro = false;
                //ACTUALIZACION, SI EL TEXTO ES CORRECTO LA VARIABLE hayUnEspacioEnBlancoEnunciadoDos SE ENVIA FALSE
                $hayUnEspacioEnBlancoOracionCuatro = false;
                //ACTUALIZACION, LA VARIABLE PARA MOSTRAR EL MENSAJE ES FALSA SI LA RESPUESTA ES CORRECTA
                $mensajeEspacioBlancoOracionCuatro = false;
            
            }else{

                $nroCaracteresOracionUsuarioCuatro = mb_strlen($oracionUsuarioCuatro, 'UTF-8');
                $nroCaracteresOracionCorrectaCuatro = mb_strlen($oracionCorrectaCuatro, 'UTF-8');

                $arrayCaracteresOracionUsuarioCuatro = mb_str_split($oracionUsuarioCuatro);
                $arrayCaracteresOracionCorrectaCuatro = mb_str_split($oracionCorrectaCuatro);

                $arraySeccionesOracionCorrectaCuatro = explode(' ', $oracionCorrectaCuatro);
                $arraySeccionesOracionUsuarioCuatro = explode(' ', $oracionUsuarioCuatro);

                $aPalabrasOracionCorrectaCuatro = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $oracionCorrectaCuatro);
                $arrayPalabrasOracionCorrectaCuatro = explode(' ', $aPalabrasOracionCorrectaCuatro);
                $aPalabrasOracionUsuarioCuatro = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $oracionUsuarioCuatro);
                $arrayPalabrasOracionUsuarioCuatro = explode(' ', $aPalabrasOracionUsuarioCuatro);

                $nroElementosArrayCaracteresOracionUsuarioCuatro = count($arrayCaracteresOracionUsuarioCuatro);
                $nroElementosArrayCaracteresOracionCorrectaCuatro = count($arrayCaracteresOracionCorrectaCuatro);
                $arraySignosOracionUsuarioCuatro = [];
                $arraySignosOracionCorrectaCuatro = [];


                for($i=0; $i<$nroElementosArrayCaracteresOracionUsuarioCuatro; $i++){
                    if((strcmp($arrayCaracteresOracionUsuarioCuatro[$i], ',') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], ':') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], ';') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '-') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '+') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '/') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '.') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '...') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '....') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '&') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '!') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '¡') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '?') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '¿') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '"') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], ')') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '(') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '..') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '*') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], "'") === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '[') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], ']') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '{') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '}') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '_') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '^') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '#') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '<') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '>') === 0) || (strcmp($arrayCaracteresOracionUsuarioCuatro[$i], '|') === 0)){

                        array_push($arraySignosOracionUsuarioCuatro, $arrayCaracteresOracionUsuarioCuatro[$i]);
                    }
                }


                for($m=0; $m<$nroElementosArrayCaracteresOracionCorrectaCuatro; $m++){
                    if((strcmp($arrayCaracteresOracionCorrectaCuatro[$m], ',') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], ':') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], ';') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '-') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '+') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '/') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '.') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '...') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '....') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '&') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '!') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '¡') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '?') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '¿') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '"') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], ')') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '(') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '..') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '*') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], "'") === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '[') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], ']') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '{') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '}') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '_') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '^') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '#') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '<') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '>') === 0) || (strcmp($arrayCaracteresOracionCorrectaCuatro[$m], '|') === 0)){

                        array_push($arraySignosOracionCorrectaCuatro, $arrayCaracteresOracionCorrectaCuatro[$m]);
                    }
                }


                $nroElementosArrayPalabrasOracionUsuarioCuatro = count($arrayPalabrasOracionUsuarioCuatro);
                $nroElementosArrayPalabrasOracionCorrectaCuatro = count($arrayPalabrasOracionCorrectaCuatro);
                $nroElementosArraySignosOracionUsuarioCuatro = count($arraySignosOracionUsuarioCuatro);
                $nroElementosArraySignosOracionCorrectaCuatro = count($arraySignosOracionCorrectaCuatro);
                $nroElementosArraySeccionesOracionUsuarioCuatro = count($arraySeccionesOracionUsuarioCuatro);
                $nroElementosArraySeccionesOracionCorrectaCuatro = count($arraySeccionesOracionCorrectaCuatro);


                for($e=0; $e<$nroElementosArrayPalabrasOracionUsuarioCuatro; $e++){
                    if(!in_array($arrayPalabrasOracionUsuarioCuatro[$e], $arrayPalabrasOracionCorrectaCuatro)){
                        array_push($resultadoPalabrasIncorrectasUsuarioCuatro, $arrayPalabrasOracionUsuarioCuatro[$e]);
                    }
                }

                for($r=0; $r<$nroElementosArraySignosOracionUsuarioCuatro; $r++){
                    if(!in_array($arraySignosOracionUsuarioCuatro[$r], $arraySignosOracionCorrectaCuatro)){
                        array_push($resultadoSignosIncorrectosUsuarioCuatro, $arraySignosOracionUsuarioCuatro[$r]);
                    }
                }

                for($f=0; $f<$nroElementosArrayPalabrasOracionCorrectaCuatro; $f++){
                    if(!in_array($arrayPalabrasOracionCorrectaCuatro[$f], $arrayPalabrasOracionUsuarioCuatro)){
                        array_push($resultadoPalabrasQueLeFaltaronAlUsuarioCuatro, $arrayPalabrasOracionCorrectaCuatro[$f]);
                    }
                }

                for($j=0; $j<$nroElementosArraySignosOracionCorrectaCuatro; $j++){
                    if(!in_array($arraySignosOracionCorrectaCuatro[$j], $arraySignosOracionUsuarioCuatro)){
                        array_push($resultadoSignosQueLeFaltaronAlUsuarioCuatro, $arraySignosOracionCorrectaCuatro[$j]);
                    }
                }

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOCUATRO ORIGINAL
                //for($d=0; $d<$nroElementosArraySeccionesOracionCorrectaCuatro; $d++){
                //    if(!in_array($arraySeccionesOracionCorrectaCuatro[$d], $arraySeccionesOracionUsuarioCuatro)){
                //        array_push($resultadoSeccionesQueLeFaltaronAlUsuarioCuatro, $arraySeccionesOracionCorrectaCuatro[$d]);
                //    }
                //}

                //////////////////////////////////////// METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO FINAL

                $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionCuatro = 0;
                $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionCuatro = 0;
                for($u=0; $u<$nroElementosArraySeccionesOracionCorrectaCuatro; $u++){

                    
                    for ($y=0; $y<$nroElementosArraySeccionesOracionCorrectaCuatro; $y++){
                        $compararoracioncuatro = strcmp($arraySeccionesOracionCorrectaCuatro[$u], $arraySeccionesOracionCorrectaCuatro[$y]);
                        if ($compararoracioncuatro === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionCuatro++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesOracionUsuarioCuatro); $z++){
                        $compararoracioncuatrousuario = strcmp($arraySeccionesOracionCorrectaCuatro[$u], $arraySeccionesOracionUsuarioCuatro[$z]);
                        if($compararoracioncuatrousuario === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionCuatro++;
                        }
                    }

                    if(($contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionCuatro > $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionCuatro)){
                        if (!in_array($arraySeccionesOracionCorrectaCuatro[$u], $resultadoSeccionesQueLeFaltaronAlUsuarioCuatro)){
                            array_push($resultadoSeccionesQueLeFaltaronAlUsuarioCuatro, $arraySeccionesOracionCorrectaCuatro[$u]);
                        }
                        
                    }
                    $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionCuatro = 0;
                    $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionCuatro = 0;
                }

                ///////////////////////////////////////// FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO


                //ACTUALIZACION
                //EN EL ARRAY COMENTADO SE AGREGARAN LAS SECCIONES DE ORACION UNO DEL USUARIO QUE NO COINCIDAN CON LAS SECCIONES DE LA ORACION CORRECTA UNO
                // $resultadoSeccionesIncorrectasOracionUsuarioUno = [];
                //PARA LA COMPARACION, CON UN FOR SE RECORRE EL ARRAYSECCIONESORACIONUSUARIOUNO Y SE PREGUNTA SI LA SECCION [I] DE ESE ARRAY NO COINCIDE CON ALGUNA DE LAS SECCIONES DE LA ORACION CORRECTA
                //Y LAS SECCIONES DEL ARRAYSECCIONESORACIONUSUARIOUNO QUE NO COINCIDAN CON ALGUNA SECCION DEL ARRAYSECCIONESORACIONCORRECTAUNO, SE GUARDAN EN EL ARRAY
                //RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO PARA ENVIARLAS A LA VISTA

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOCUATRO ORIGINAL
                //for($p=0; $p<$nroElementosArraySeccionesOracionUsuarioCuatro; $p++){
                //    
                //    if(!in_array($arraySeccionesOracionUsuarioCuatro[$p], $arraySeccionesOracionCorrectaCuatro)){
                //        array_push($resultadoSeccionesIncorrectasOracionUsuarioCuatro, $arraySeccionesOracionUsuarioCuatro[$p]);
                //    }
                //}

                //return $resultadoSeccionesIncorrectasOracionUsuarioCuatro;

                 //////////////////////////////////////METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL

                //CAPTURAR LAS PALABRAS QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA Y AGREGARLAS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS
                for($b=0; $b<$nroElementosArraySeccionesOracionUsuarioCuatro; $b++){
                    if(!in_array($arraySeccionesOracionUsuarioCuatro[$b], $arraySeccionesOracionCorrectaCuatro)){
                        array_push($resultadoSeccionesIncorrectasOracionUsuarioCuatro, $arraySeccionesOracionUsuarioCuatro[$b]);
                    }
                }

                //AGREGAR AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS LAS PALABRAS QUE SI FORMAN PARTE DEL TEXTO CORRECTO, PERO QUE ESTAN AGREGADAS EN DEMASIA
                //ES DECIR, EN EL TEXTO CORRECTO HAY 2 "HOLA" PERO EN LA RESPUESTA DEL USUARIO HAY 3 "HOLA", POR LO TANTO ES UNA PALABRA INCORRECTA.
                //ESTE METODO ESTÁ BASADO EN EL METODO PARA AGREGAR ELEMENTOS AL ARRAY $resultadoSeccionesQueLeFaltaronParrafoUsuario
                //LA DIFERENCIA ES QUE EN LA SECCION FINAL DE ESTE METODO SE CAMBIO EL METODO DE MAYOR QUE A MENOR QUE  

                $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionCuatro = 0;
                $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionCuatro = 0;
                for($u=0; $u<$nroElementosArraySeccionesOracionCorrectaCuatro; $u++){

                    for ($y=0; $y<$nroElementosArraySeccionesOracionCorrectaCuatro; $y++){
                        $compararoracioncuatro = strcmp($arraySeccionesOracionCorrectaCuatro[$u], $arraySeccionesOracionCorrectaCuatro[$y]);
                        if ($compararoracioncuatro === 0){
                            $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionCuatro++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesOracionUsuarioCuatro); $z++){
                        $compararoracioncuatrousuario = strcmp($arraySeccionesOracionCorrectaCuatro[$u], $arraySeccionesOracionUsuarioCuatro[$z]);
                        if($compararoracioncuatrousuario === 0){
                            $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionCuatro++;
                        }
                    }

                    if(($contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionCuatro < $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionCuatro)){
                        if (!in_array($arraySeccionesOracionCorrectaCuatro[$u], $resultadoSeccionesIncorrectasOracionUsuarioCuatro)){
                            array_push($resultadoSeccionesIncorrectasOracionUsuarioCuatro, $arraySeccionesOracionCorrectaCuatro[$u]);
                        }
                        
                    }
                    $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionCuatro = 0;
                    $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionCuatro = 0;

                } 


                ///////////////////////////////////////FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL




                //ACTUALIZACION
                //A TRAVES DEL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE PUEDE REEMPLAZAR CON "_" LOS ESPACIOS ADICIONALES QUE EL USUARIO HAYA AGREGADO 
                //A SU RESPUESTA, CUANDO LA RESPUESTA DEL USUARIO SEA ERRONEA. POR ESA RAZON EL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE ENVIA A LA VISTA
                //PARA MOSTRARLO CUANDO LAS ORACIONES NO COINCIDAN

                //PRIMERO SE RECORRE EL ARRAY Y CUANDO ENCUENTRE ESPACIOS VACIOS LOS VA A IR REEMPLAZANDO POR "_"
                for($b=0; $b<count($arraySeccionesOracionUsuarioCuatro); $b++){
                    if($arraySeccionesOracionUsuarioCuatro[$b] === ""){
                        $arraySeccionesOracionUsuarioCuatro[$b] = "_";
                    }
                }

                //LUEGO CON EL IMPLDE SE UNE EL ARRAY DE NUEVO PARA ENVIARLO A LA VISTA
                $stringSeccionesOracionUsuarioCuatro = implode(" ", $arraySeccionesOracionUsuarioCuatro);
                //A LA VISTA TAMBIEN SEE VA A ENVIAR UNA VARIABLE TIPO BOOLEAN QUE ENVIA FALSE SI NO HAY "_" EN EL 
                //ARRAYSECCIONESENUNCIADOUSUARIOUNO Y DEVUELVE TRUE SI ESQUE SI HAY "_" EN EL ARRAY
                //ESTO SE ENVIA A LA VISTA PARA QUE EN BASE A LO QUE DEVUELVA, APAREZCA EL MENSAJE DE QUE HAY ESPACIOS ADICIONALES
                //EN LA RESPUESTA DEL USUARIO O NO HAY ESPACIOS ADICIONALES EN LA RESPUESTA DEL USUARIO
                $existenEspaciosOracionCuatro = false;
                if(in_array("_", $arraySeccionesOracionUsuarioCuatro)){
                    $existenEspaciosOracionCuatro = true;
                }

                //return $stringSeccionesOracionUsuarioCuatro;



                //ACTUALIZACION
                //ANTES DE ENVIAR EL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO
                //SE AGREGA ARRAYUNIQUE Y SE REEMPLAZA LOS ESPACIOS VACIOS "" POR LA PALABRA "ESPACIOS VACIOS"
                //EL ARRAYUNIQUE SE REALIZO EN LA VISTA, REVISAR EN LA SECCION DONDE SE RECORRE EL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO
                //EN LA VISTA
                
                for($u=0; $u<count($resultadoSeccionesIncorrectasOracionUsuarioCuatro); $u++){
                    if($resultadoSeccionesIncorrectasOracionUsuarioCuatro[$u] === ""){
                        $resultadoSeccionesIncorrectasOracionUsuarioCuatro[$u] = "Espacios en blanco.";
                    }
                }

                //return $resultadoSeccionesIncorrectasOracionUsuarioCuatro;



                if($nroElementosArrayCaracteresOracionCorrectaCuatro === $nroElementosArrayCaracteresOracionUsuarioCuatro){
                    $respuestaOracionCuatro = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresOracionCorrectaCuatro < $nroElementosArrayCaracteresOracionUsuarioCuatro){
                    //$respuestaOracionCuatro = "Su respuesta es incorrecta. Puede contener letras, signos ortográficos incorrectos o más de un espacio entre palabras.";
                    $respuestaOracionCuatro = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresOracionCorrectaCuatro > $nroElementosArrayCaracteresOracionUsuarioCuatro){
                    //$respuestaOracionCuatro = "Su respuesta es incorrecta. Ha omitido algunos elementos en un respuesta.";
                    $respuestaOracionCuatro = "Su respuesta es incorrecta.";
                }else{
                    //$respuestaOracionCuatro = "Su respuesta es incorrecta. Tiene algunos errores que se detallan abajo.";
                    $respuestaOracionCuatro = "Su respuesta es incorrecta.";
                }



                //ACTUALIZACION
                //SE VERIFICA SI EN EL ARRAY $resultadoSeccionesIncorrectasEnunciadoUsuarioUno TODOS LOS ELEMENTOS SON "Espacios en blanco."
                //SI ES ASI, EN LA VARIABLE $hayUnEspacioEnBlancoEnunciadoUno SE ENVIA TRUE, CASO CONTRARIO SE ENVIA FALSE
               

                $hayUnEspacioEnBlancoOracionCuatro = false;
                
                //SE RECORRE EL ARRAY DE LAS SECCIONES INCORRECTAS Y SE COMPARA SI TODOS LOS ELEMENTOS SON ESPACIOS EN BLANCO
                $contadorEspaciosOracionCuatro = 0;
                for($f=0; $f< count($resultadoSeccionesIncorrectasOracionUsuarioCuatro); $f++){
                    if($resultadoSeccionesIncorrectasOracionUsuarioCuatro[$f] === "Espacios en blanco."){
                        $contadorEspaciosOracionCuatro++;
                    }
                }
                if($contadorEspaciosOracionCuatro === count($resultadoSeccionesIncorrectasOracionUsuarioCuatro)){
                    $hayUnEspacioEnBlancoOracionCuatro = true;
                }

                //CON EL IN ARRAY SE COMPRUEBA SI HAY ESPACIOS EN BLANCO EN EL ARRAY DE SECCIONESINCORRECTAS
                //ESTO SIRVE PARA MOSTRAR UN MENSAJE EN LA VISTA DE QUE EL USUARIO TIENE ESPACIOS EN BLANCO
                //Y ADEMAS OTROS ELEMENTOS INCORRECTOS
                $mensajeEspacioBlancoOracionCuatro = false;
                if(in_array("Espacios en blanco.", $resultadoSeccionesIncorrectasOracionUsuarioCuatro)){
                    $mensajeEspacioBlancoOracionCuatro = true;
                }

                //return $mensajeEspacioBlancoOracionCuatro;



            }



            //COMPROBACION ORACION CINCO

            //VARIABLES PARA LA ORACION CINCO
            $caracteresCorrectosCinco = [];
            $caracteresIncorrectosCinco = [];
            $palabrasCorrectasCinco = [];
            $palabrasIncorrectasCinco = [];
            $seccionesCorrectasCinco = [];
            $seccionesIncorrectasCinco = [];

            $resultadoPalabrasIncorrectasUsuarioCinco = [];
            $resultadoSignosIncorrectosUsuarioCinco = [];
            $resultadoPalabrasQueLeFaltaronAlUsuarioCinco = [];
            $resultadoSignosQueLeFaltaronAlUsuarioCinco = [];
            $resultadoSeccionesQueLeFaltaronAlUsuarioCinco = [];
            //ACTUALIZACION SE AGREGA ESTE ARRAY PARA PODER PINTAR EN LA VISTA LAS SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS
            $resultadoSeccionesIncorrectasOracionUsuarioCinco = [];

            $compararOracionCinco = strcmp($oracionCorrectaCinco, $oracionUsuarioCinco);

            if($compararOracionCinco === 0){
                //SI ES IGUAL A CERO, LA PALABRA DEL USUARIO ES CORRECTA
                $respuestaOracionCinco = "Su respuesta al quinto enunciado es correcta.";

                $resultadoPalabrasIncorrectasUsuarioCinco = [];
                $resultadoSignosIncorrectosUsuarioCinco = [];
                $resultadoPalabrasQueLeFaltaronAlUsuarioCinco = [];
                $resultadoSignosQueLeFaltaronAlUsuarioCinco = [];
                $resultadoSeccionesQueLeFaltaronAlUsuarioCinco = [];
                //ACTUALIZACION SE AGREGA ESTE NUEVO ARRAY
                $resultadoSeccionesIncorrectasOracionUsuarioCinco = [];
                //ACTUALIZACION SE AGREGA ESTE CAMPO QUE CONTIENE LA RESPUESTA DEL USUARIO
                $stringSeccionesOracionUsuarioCinco = $oracionUsuarioCinco;
                //ACTUALIZACION, SE ENVIA ESTE CAMPO PARA VER SI HAY ESPACIOS O NO EN LA RESPUESTA
                //COMO EN ESTE CASO NO HAY ESPACIOS ADICIONALES PORQUE LA RESPUESTA ES CORRECTA, SE ENVIA FALSE
                $existenEspaciosOracionCinco = false;
                //ACTUALIZACION, SI EL TEXTO ES CORRECTO LA VARIABLE hayUnEspacioEnBlancoEnunciadoDos SE ENVIA FALSE
                $hayUnEspacioEnBlancoOracionCinco = false;
                //ACTUALIZACION, LA VARIABLE PARA MOSTRAR EL MENSAJE ES FALSA SI LA RESPUESTA ES CORRECTA
                $mensajeEspacioBlancoOracionCinco = false;
            
            }
            else{

                $nroCaracteresOracionUsuarioCinco = mb_strlen($oracionUsuarioCinco, 'UTF-8');
                $nroCaracteresOracionCorrectaCinco = mb_strlen($oracionCorrectaCinco, 'UTF-8');

                $arrayCaracteresOracionUsuarioCinco = mb_str_split($oracionUsuarioCinco);
                $arrayCaracteresOracionCorrectaCinco = mb_str_split($oracionCorrectaCinco);

                $arraySeccionesOracionCorrectaCinco = explode(' ', $oracionCorrectaCinco);
                $arraySeccionesOracionUsuarioCinco = explode(' ', $oracionUsuarioCinco);

                $aPalabrasOracionCorrectaCinco = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $oracionCorrectaCinco);
                $arrayPalabrasOracionCorrectaCinco = explode(' ', $aPalabrasOracionCorrectaCinco);
                $aPalabrasOracionUsuarioCinco = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $oracionUsuarioCinco);
                $arrayPalabrasOracionUsuarioCinco = explode(' ', $aPalabrasOracionUsuarioCinco);

                $nroElementosArrayCaracteresOracionUsuarioCinco = count($arrayCaracteresOracionUsuarioCinco);
                $nroElementosArrayCaracteresOracionCorrectaCinco = count($arrayCaracteresOracionCorrectaCinco);
                $arraySignosOracionUsuarioCinco = [];
                $arraySignosOracionCorrectaCinco = [];

                for($i=0; $i<$nroElementosArrayCaracteresOracionUsuarioCinco; $i++){
                    if((strcmp($arrayCaracteresOracionUsuarioCinco[$i], ',') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], ':') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], ';') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '-') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '+') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '/') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '.') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '...') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '....') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '&') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '!') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '¡') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '?') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '¿') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '"') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioCinco[$i], ')') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '(') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '..') === 0) || 
                        (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '*') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], "'") === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '[') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioCinco[$i], ']') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '{') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '}') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '_') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '^') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '#') === 0) ||
                        (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '<') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '>') === 0) || (strcmp($arrayCaracteresOracionUsuarioCinco[$i], '|') === 0)){

                        array_push($arraySignosOracionUsuarioCinco, $arrayCaracteresOracionUsuarioCinco[$i]);
                    }
                }

                for($m=0; $m<$nroElementosArrayCaracteresOracionCorrectaCinco; $m++){
                    if((strcmp($arrayCaracteresOracionCorrectaCinco[$m], ',') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], ':') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], ';') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '-') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '+') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '/') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '.') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '...') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '....') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '&') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '!') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '¡') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '?') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '¿') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '"') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaCinco[$m], ')') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '(') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '..') === 0) || 
                        (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '*') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], "'") === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '[') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaCinco[$m], ']') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '{') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '}') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '_') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '^') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '#') === 0) ||
                        (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '<') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '>') === 0) || (strcmp($arrayCaracteresOracionCorrectaCinco[$m], '|') === 0)){

                        array_push($arraySignosOracionCorrectaCinco, $arrayCaracteresOracionCorrectaCinco[$m]);
                    }
                }

                $nroElementosArrayPalabrasOracionUsuarioCinco = count($arrayPalabrasOracionUsuarioCinco);
                $nroElementosArrayPalabrasOracionCorrectaCinco = count($arrayPalabrasOracionCorrectaCinco);
                $nroElementosArraySignosOracionUsuarioCinco = count($arraySignosOracionUsuarioCinco);
                $nroElementosArraySignosOracionCorrectaCinco = count($arraySignosOracionCorrectaCinco);
                $nroElementosArraySeccionesOracionUsuarioCinco = count($arraySeccionesOracionUsuarioCinco);
                $nroElementosArraySeccionesOracionCorrectaCinco = count($arraySeccionesOracionCorrectaCinco);

                for($e=0; $e<$nroElementosArrayPalabrasOracionUsuarioCinco; $e++){
                    if(!in_array($arrayPalabrasOracionUsuarioCinco[$e], $arrayPalabrasOracionCorrectaCinco)){
                        array_push($resultadoPalabrasIncorrectasUsuarioCinco, $arrayPalabrasOracionUsuarioCinco[$e]);
                    }
                }

                for($r=0; $r<$nroElementosArraySignosOracionUsuarioCinco; $r++){
                    if(!in_array($arraySignosOracionUsuarioCinco[$r], $arraySignosOracionCorrectaCinco)){
                        array_push($resultadoSignosIncorrectosUsuarioCinco, $arraySignosOracionUsuarioCinco[$r]);
                    }
                }

                for($f=0; $f<$nroElementosArrayPalabrasOracionCorrectaCinco; $f++){
                    if(!in_array($arrayPalabrasOracionCorrectaCinco[$f], $arrayPalabrasOracionUsuarioCinco)){
                        array_push($resultadoPalabrasQueLeFaltaronAlUsuarioCinco, $arrayPalabrasOracionCorrectaCinco[$f]);
                    }
                }

                for($j=0; $j<$nroElementosArraySignosOracionCorrectaCinco; $j++){
                    if(!in_array($arraySignosOracionCorrectaCinco[$j], $arraySignosOracionUsuarioCinco)){
                        array_push($resultadoSignosQueLeFaltaronAlUsuarioCinco, $arraySignosOracionCorrectaCinco[$j]);
                    }
                }


                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOCINCO ORIGINAL
                //for($d=0; $d<$nroElementosArraySeccionesOracionCorrectaCinco; $d++){
                //    if(!in_array($arraySeccionesOracionCorrectaCinco[$d], $arraySeccionesOracionUsuarioCinco)){
                //        array_push($resultadoSeccionesQueLeFaltaronAlUsuarioCinco, $arraySeccionesOracionCorrectaCinco[$d]);
                //    }
                //}

                //////////////////////////////////////// METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO FINAL

                $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionCinco = 0;
                $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionCinco = 0;
                for($u=0; $u<$nroElementosArraySeccionesOracionCorrectaCinco; $u++){

                    
                    for ($y=0; $y<$nroElementosArraySeccionesOracionCorrectaCinco; $y++){
                        $compararoracioncinco = strcmp($arraySeccionesOracionCorrectaCinco[$u], $arraySeccionesOracionCorrectaCinco[$y]);
                        if ($compararoracioncinco === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionCinco++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesOracionUsuarioCinco); $z++){
                        $compararoracioncincousuario = strcmp($arraySeccionesOracionCorrectaCinco[$u], $arraySeccionesOracionUsuarioCinco[$z]);
                        if($compararoracioncincousuario === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionCinco++;
                        }
                    }

                    if(($contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionCinco > $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionCinco)){
                        if (!in_array($arraySeccionesOracionCorrectaCinco[$u], $resultadoSeccionesQueLeFaltaronAlUsuarioCinco)){
                            array_push($resultadoSeccionesQueLeFaltaronAlUsuarioCinco, $arraySeccionesOracionCorrectaCinco[$u]);
                        }
                        
                    }
                    $contadorSeccionesQueLeFaltaronAlUsuarioUnoOracionCinco = 0;
                    $contadorSeccionesQueLeFaltaronAlUsuarioDosOracionCinco = 0;
                }

                ///////////////////////////////////////// FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO



                //ACTUALIZACION
                //EN EL ARRAY COMENTADO SE AGREGARAN LAS SECCIONES DE ORACION UNO DEL USUARIO QUE NO COINCIDAN CON LAS SECCIONES DE LA ORACION CORRECTA UNO
                // $resultadoSeccionesIncorrectasOracionUsuarioUno = [];
                //PARA LA COMPARACION, CON UN FOR SE RECORRE EL ARRAYSECCIONESORACIONUSUARIOUNO Y SE PREGUNTA SI LA SECCION [I] DE ESE ARRAY NO COINCIDE CON ALGUNA DE LAS SECCIONES DE LA ORACION CORRECTA
                //Y LAS SECCIONES DEL ARRAYSECCIONESORACIONUSUARIOUNO QUE NO COINCIDAN CON ALGUNA SECCION DEL ARRAYSECCIONESORACIONCORRECTAUNO, SE GUARDAN EN EL ARRAY
                //RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO PARA ENVIARLAS A LA VISTA

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOCINCO
                //for($p=0; $p<$nroElementosArraySeccionesOracionUsuarioCinco; $p++){
                //
                //    if(!in_array($arraySeccionesOracionUsuarioCinco[$p], $arraySeccionesOracionCorrectaCinco)){
                //        array_push($resultadoSeccionesIncorrectasOracionUsuarioCinco, $arraySeccionesOracionUsuarioCinco[$p]);
                //    }
                //}

                //return $resultadoSeccionesIncorrectasOracionUsuarioCinco;

                //////////////////////////////////////METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL

                //CAPTURAR LAS PALABRAS QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA Y AGREGARLAS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS
                for($b=0; $b<$nroElementosArraySeccionesOracionUsuarioCinco; $b++){
                    if(!in_array($arraySeccionesOracionUsuarioCinco[$b], $arraySeccionesOracionCorrectaCinco)){
                        array_push($resultadoSeccionesIncorrectasOracionUsuarioCinco, $arraySeccionesOracionUsuarioCinco[$b]);
                    }
                }

                //AGREGAR AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS LAS PALABRAS QUE SI FORMAN PARTE DEL TEXTO CORRECTO, PERO QUE ESTAN AGREGADAS EN DEMASIA
                //ES DECIR, EN EL TEXTO CORRECTO HAY 2 "HOLA" PERO EN LA RESPUESTA DEL USUARIO HAY 3 "HOLA", POR LO TANTO ES UNA PALABRA INCORRECTA.
                //ESTE METODO ESTÁ BASADO EN EL METODO PARA AGREGAR ELEMENTOS AL ARRAY $resultadoSeccionesQueLeFaltaronParrafoUsuario
                //LA DIFERENCIA ES QUE EN LA SECCION FINAL DE ESTE METODO SE CAMBIO EL METODO DE MAYOR QUE A MENOR QUE  

                $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionCinco = 0;
                $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionCinco = 0;
                for($u=0; $u<$nroElementosArraySeccionesOracionCorrectaCinco; $u++){

                    for ($y=0; $y<$nroElementosArraySeccionesOracionCorrectaCinco; $y++){
                        $compararoracioncinco = strcmp($arraySeccionesOracionCorrectaCinco[$u], $arraySeccionesOracionCorrectaCinco[$y]);
                        if ($compararoracioncinco === 0){
                            $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionCinco++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesOracionUsuarioCinco); $z++){
                        $compararoracioncincousuario = strcmp($arraySeccionesOracionCorrectaCinco[$u], $arraySeccionesOracionUsuarioCinco[$z]);
                        if($compararoracioncincousuario === 0){
                            $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionCinco++;
                        }
                    }

                    if(($contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionCinco < $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionCinco)){
                        if (!in_array($arraySeccionesOracionCorrectaCinco[$u], $resultadoSeccionesIncorrectasOracionUsuarioCinco)){
                            array_push($resultadoSeccionesIncorrectasOracionUsuarioCinco, $arraySeccionesOracionCorrectaCinco[$u]);
                        }
                        
                    }
                    $contadorResultadoSeccionesIncorrectasOracionUsuarioUnoOracionCinco = 0;
                    $contadorResultadoSeccionesIncorrectasOracionUsuarioDosOracionCinco = 0;

                } 


                ///////////////////////////////////////FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL



                //ACTUALIZACION
                //A TRAVES DEL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE PUEDE REEMPLAZAR CON "_" LOS ESPACIOS ADICIONALES QUE EL USUARIO HAYA AGREGADO 
                //A SU RESPUESTA, CUANDO LA RESPUESTA DEL USUARIO SEA ERRONEA. POR ESA RAZON EL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE ENVIA A LA VISTA
                //PARA MOSTRARLO CUANDO LAS ORACIONES NO COINCIDAN

                //PRIMERO SE RECORRE EL ARRAY Y CUANDO ENCUENTRE ESPACIOS VACIOS LOS VA A IR REEMPLAZANDO POR "_"
                for($b=0; $b<count($arraySeccionesOracionUsuarioCinco); $b++){
                    if($arraySeccionesOracionUsuarioCinco[$b] === ""){
                        $arraySeccionesOracionUsuarioCinco[$b] = "_";
                    }
                }

                //LUEGO CON EL IMPLDE SE UNE EL ARRAY DE NUEVO PARA ENVIARLO A LA VISTA
                $stringSeccionesOracionUsuarioCinco = implode(" ", $arraySeccionesOracionUsuarioCinco);
                //A LA VISTA TAMBIEN SEE VA A ENVIAR UNA VARIABLE TIPO BOOLEAN QUE ENVIA FALSE SI NO HAY "_" EN EL 
                //ARRAYSECCIONESENUNCIADOUSUARIOUNO Y DEVUELVE TRUE SI ESQUE SI HAY "_" EN EL ARRAY
                //ESTO SE ENVIA A LA VISTA PARA QUE EN BASE A LO QUE DEVUELVA, APAREZCA EL MENSAJE DE QUE HAY ESPACIOS ADICIONALES
                //EN LA RESPUESTA DEL USUARIO O NO HAY ESPACIOS ADICIONALES EN LA RESPUESTA DEL USUARIO
                $existenEspaciosOracionCinco = false;
                if(in_array("_", $arraySeccionesOracionUsuarioCinco)){
                    $existenEspaciosOracionCinco = true;
                }

                //return $stringSeccionesOracionUsuarioCinco;


                //ACTUALIZACION
                //ANTES DE ENVIAR EL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO
                //SE AGREGA ARRAYUNIQUE Y SE REEMPLAZA LOS ESPACIOS VACIOS "" POR LA PALABRA "ESPACIOS VACIOS"
                //EL ARRAYUNIQUE SE REALIZO EN LA VISTA, REVISAR EN LA SECCION DONDE SE RECORRE EL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO
                //EN LA VISTA
                
                for($u=0; $u<count($resultadoSeccionesIncorrectasOracionUsuarioCinco); $u++){
                    if($resultadoSeccionesIncorrectasOracionUsuarioCinco[$u] === ""){
                        $resultadoSeccionesIncorrectasOracionUsuarioCinco[$u] = "Espacios en blanco.";
                    }
                }

                //return $resultadoSeccionesIncorrectasOracionUsuarioCinco;


                if($nroElementosArrayCaracteresOracionCorrectaCinco === $nroElementosArrayCaracteresOracionUsuarioCinco){
                    $respuestaOracionCinco = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresOracionCorrectaCinco < $nroElementosArrayCaracteresOracionUsuarioCinco){
                    //$respuestaOracionCinco = "Su respuesta es incorrecta. Puede contener letras, signos ortográficos incorrectos o más de un espacio entre palabras.";
                    $respuestaOracionCinco = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresOracionCorrectaCinco > $nroElementosArrayCaracteresOracionUsuarioCinco){
                    //$respuestaOracionCinco = "Su respuesta es incorrecta. Ha omitido algunos elementos en un respuesta.";
                    $respuestaOracionCinco = "Su respuesta es incorrecta.";
                }else{
                    //$respuestaOracionCinco = "Su respuesta es incorrecta. Tiene algunos errores que se detallan abajo.";
                    $respuestaOracionCinco = "Su respuesta es incorrecta.";
                }


                //ACTUALIZACION
                //SE VERIFICA SI EN EL ARRAY $resultadoSeccionesIncorrectasEnunciadoUsuarioUno TODOS LOS ELEMENTOS SON "Espacios en blanco."
                //SI ES ASI, EN LA VARIABLE $hayUnEspacioEnBlancoEnunciadoUno SE ENVIA TRUE, CASO CONTRARIO SE ENVIA FALSE
               

                $hayUnEspacioEnBlancoOracionCinco = false;
                
                //SE RECORRE EL ARRAY DE LAS SECCIONES INCORRECTAS Y SE COMPARA SI TODOS LOS ELEMENTOS SON ESPACIOS EN BLANCO
                $contadorEspaciosOracionCinco = 0;
                for($f=0; $f< count($resultadoSeccionesIncorrectasOracionUsuarioCinco); $f++){
                    if($resultadoSeccionesIncorrectasOracionUsuarioCinco[$f] === "Espacios en blanco."){
                        $contadorEspaciosOracionCinco++;
                    }
                }
                if($contadorEspaciosOracionCinco === count($resultadoSeccionesIncorrectasOracionUsuarioCinco)){
                    $hayUnEspacioEnBlancoOracionCinco = true;
                }

                //CON EL IN ARRAY SE COMPRUEBA SI HAY ESPACIOS EN BLANCO EN EL ARRAY DE SECCIONESINCORRECTAS
                //ESTO SIRVE PARA MOSTRAR UN MENSAJE EN LA VISTA DE QUE EL USUARIO TIENE ESPACIOS EN BLANCO
                //Y ADEMAS OTROS ELEMENTOS INCORRECTOS
                $mensajeEspacioBlancoOracionCinco = false;
                if(in_array("Espacios en blanco.", $resultadoSeccionesIncorrectasOracionUsuarioCinco)){
                    $mensajeEspacioBlancoOracionCinco = true;
                }

                //return $mensajeEspacioBlancoOracionCinco;

            }


            //return $resultadoSeccionesQueLeFaltaronAlUsuarioUno;


            //ACTUALIZACION
            //PARA MOSTRAR LAS REGLAS ORTOGRAFICAS ASOCIADAS A LA PREGUNTA CLASIFICADAS POR PALABRAS, PUNTUACION Y ACENTUACION
            //SE DECLARA TRES VARIABLES QUE VAN A A ENVIAR TRUE SI HAY REGLAS ASOCIADAS DE PALABRAS, PUNTUACION O ACENTUACION
            //ESTO SIRVE PARA QUE EN LA VISTA DE MUESTREN LAS SECCIONES SOLO SI HAY REGLAS DE ESE TIPO ASOCIADAS
            
            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 1 CATEGORIES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasencategories = false;
            $hayacentuacionencategories = false;
            $haypuntuacionencategories = false;

            for($a=0; $a<count($questionType->categories); $a++){

                if($questionType->categories[$a]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionencategories = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 2 SECTIONS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasensections = false;
            $hayacentuacionensections = false;
            $haypuntuacionensections = false;

            for($b=0; $b<count($questionType->sections); $b++){

                if($questionType->sections[$b]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionensections = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 3 POSTS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenposts = false;
            $hayacentuacionenposts = false;
            $haypuntuacionenposts = false;

            for($c=0; $c<count($questionType->posts); $c++){

                if($questionType->posts[$c]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenposts = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 4 RULES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenrules = false;
            $hayacentuacionenrules = false;
            $haypuntuacionenrules = false;

            for($d=0; $d<count($questionType->rules); $d++){

                if($questionType->rules[$d]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenrules = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 5 NOTES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasennotes = false;
            $hayacentuacionennotes = false;
            $haypuntuacionennotes = false;

            for($e=0; $e<count($questionType->notes); $e++){

                if($questionType->notes[$e]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionennotes = true;
                }
            }



            //return view('rules.estudiante.displayresults.displayoa', compact('questionType', 'coleccionResults', 'sumaresultados', 'coleccionCorrectas', 'userId', 'evaluationId', 'oracionesAcertadas', 'oracionesIncorrectas'
            //            , 'respuestaOracionUno', 'resultadoPalabrasIncorrectasUsuarioUno', 'resultadoSignosIncorrectosUsuarioUno', 'resultadoPalabrasQueLeFaltaronAlUsuarioUno', 'resultadoSignosQueLeFaltaronAlUsuarioUno'
            //            , 'resultadoSeccionesQueLeFaltaronAlUsuarioUno', 'oracionUsuarioUno', 'oracionCorrectaUno', 'resultadoSeccionesIncorrectasOracionUsuarioUno', 'stringSeccionesOracionUsuarioUno', 'existenEspaciosOracionUno', 'resultadooauno'
            //            , 'respuestaOracionDos', 'resultadoPalabrasIncorrectasUsuarioDos', 'resultadoSignosIncorrectosUsuarioDos', 'resultadoPalabrasQueLeFaltaronAlUsuarioDos', 'resultadoSignosQueLeFaltaronAlUsuarioDos' 
            //            , 'resultadoSeccionesQueLeFaltaronAlUsuarioDos', 'oracionUsuarioDos', 'oracionCorrectaDos', 'resultadoSeccionesIncorrectasOracionUsuarioDos', 'stringSeccionesOracionUsuarioDos', 'existenEspaciosOracionDos', 'resultadooados'
            //            , 'respuestaOracionTres', 'resultadoPalabrasIncorrectasUsuarioTres', 'resultadoSignosIncorrectosUsuarioTres', 'resultadoPalabrasQueLeFaltaronAlUsuarioTres', 'resultadoSignosQueLeFaltaronAlUsuarioTres'
            //            , 'resultadoSeccionesQueLeFaltaronAlUsuarioTres', 'oracionUsuarioTres', 'oracionCorrectaTres', 'resultadoSeccionesIncorrectasOracionUsuarioTres', 'stringSeccionesOracionUsuarioTres', 'existenEspaciosOracionTres', 'resultadooatres'
            //            , 'respuestaOracionCuatro', 'resultadoPalabrasIncorrectasUsuarioCuatro', 'resultadoSignosIncorrectosUsuarioCuatro', 'resultadoPalabrasQueLeFaltaronAlUsuarioCuatro', 'resultadoSignosQueLeFaltaronAlUsuarioCuatro'
            //            , 'resultadoSeccionesQueLeFaltaronAlUsuarioCuatro', 'oracionUsuarioCuatro', 'oracionCorrectaCuatro', 'resultadoSeccionesIncorrectasOracionUsuarioCuatro', 'stringSeccionesOracionUsuarioCuatro', 'existenEspaciosOracionCuatro', 'resultadooacuatro'
            //            , 'respuestaOracionCinco', 'resultadoPalabrasIncorrectasUsuarioCinco', 'resultadoSignosIncorrectosUsuarioCinco', 'resultadoPalabrasQueLeFaltaronAlUsuarioCinco', 'resultadoSignosQueLeFaltaronAlUsuarioCinco'
            //            , 'resultadoSeccionesQueLeFaltaronAlUsuarioCinco', 'oracionUsuarioCinco', 'oracionCorrectaCinco', 'resultadoSeccionesIncorrectasOracionUsuarioCinco', 'stringSeccionesOracionUsuarioCinco', 'existenEspaciosOracionCinco', 'resultadooacinco'
            //        ));



            return view('rules.estudiante.displayresults.displayoa', compact('questionType', 'coleccionResults', 'sumaresultados', 'coleccionCorrectas', 'userId', 'evaluationId', 'oracionesAcertadas', 'oracionesIncorrectas'
                        , 'respuestaOracionUno', 'resultadoPalabrasIncorrectasUsuarioUno', 'resultadoSignosIncorrectosUsuarioUno', 'resultadoPalabrasQueLeFaltaronAlUsuarioUno', 'resultadoSignosQueLeFaltaronAlUsuarioUno'
                        , 'resultadoSeccionesQueLeFaltaronAlUsuarioUno', 'oracionUsuarioUno', 'oracionCorrectaUno', 'resultadoSeccionesIncorrectasOracionUsuarioUno', 'stringSeccionesOracionUsuarioUno', 'existenEspaciosOracionUno', 'resultadooauno'
                        , 'respuestaOracionDos', 'resultadoPalabrasIncorrectasUsuarioDos', 'resultadoSignosIncorrectosUsuarioDos', 'resultadoPalabrasQueLeFaltaronAlUsuarioDos', 'resultadoSignosQueLeFaltaronAlUsuarioDos' 
                        , 'resultadoSeccionesQueLeFaltaronAlUsuarioDos', 'oracionUsuarioDos', 'oracionCorrectaDos', 'resultadoSeccionesIncorrectasOracionUsuarioDos', 'stringSeccionesOracionUsuarioDos', 'existenEspaciosOracionDos', 'resultadooados'
                        , 'respuestaOracionTres', 'resultadoPalabrasIncorrectasUsuarioTres', 'resultadoSignosIncorrectosUsuarioTres', 'resultadoPalabrasQueLeFaltaronAlUsuarioTres', 'resultadoSignosQueLeFaltaronAlUsuarioTres'
                        , 'resultadoSeccionesQueLeFaltaronAlUsuarioTres', 'oracionUsuarioTres', 'oracionCorrectaTres', 'resultadoSeccionesIncorrectasOracionUsuarioTres', 'stringSeccionesOracionUsuarioTres', 'existenEspaciosOracionTres', 'resultadooatres'
                        , 'respuestaOracionCuatro', 'resultadoPalabrasIncorrectasUsuarioCuatro', 'resultadoSignosIncorrectosUsuarioCuatro', 'resultadoPalabrasQueLeFaltaronAlUsuarioCuatro', 'resultadoSignosQueLeFaltaronAlUsuarioCuatro'
                        , 'resultadoSeccionesQueLeFaltaronAlUsuarioCuatro', 'oracionUsuarioCuatro', 'oracionCorrectaCuatro', 'resultadoSeccionesIncorrectasOracionUsuarioCuatro', 'stringSeccionesOracionUsuarioCuatro', 'existenEspaciosOracionCuatro', 'resultadooacuatro'
                        , 'respuestaOracionCinco', 'resultadoPalabrasIncorrectasUsuarioCinco', 'resultadoSignosIncorrectosUsuarioCinco', 'resultadoPalabrasQueLeFaltaronAlUsuarioCinco', 'resultadoSignosQueLeFaltaronAlUsuarioCinco'
                        , 'resultadoSeccionesQueLeFaltaronAlUsuarioCinco', 'oracionUsuarioCinco', 'oracionCorrectaCinco', 'resultadoSeccionesIncorrectasOracionUsuarioCinco', 'stringSeccionesOracionUsuarioCinco', 'existenEspaciosOracionCinco', 'resultadooacinco'
                        , 'haypalabrasencategories', 'hayacentuacionencategories', 'haypuntuacionencategories', 'haypalabrasensections', 'hayacentuacionensections', 'haypuntuacionensections'
                        , 'haypalabrasenposts', 'hayacentuacionenposts', 'haypuntuacionenposts', 'haypalabrasenrules', 'hayacentuacionenrules', 'haypuntuacionenrules'
                        , 'haypalabrasennotes', 'hayacentuacionennotes', 'haypuntuacionennotes'
                        , 'hayUnEspacioEnBlancoOracionUno', 'hayUnEspacioEnBlancoOracionDos', 'hayUnEspacioEnBlancoOracionTres', 'hayUnEspacioEnBlancoOracionCuatro', 'hayUnEspacioEnBlancoOracionCinco'
                        , 'mensajeEspacioBlancoOracionUno', 'mensajeEspacioBlancoOracionDos', 'mensajeEspacioBlancoOracionTres', 'mensajeEspacioBlancoOracionCuatro', 'mensajeEspacioBlancoOracionCinco'));


 



 

            /////////////////////////////////////////////////////////////////////////////FIN DE CODIGO

            //return view('rules.estudiante.displayresults.displayoa', compact('questionType', 'coleccionResults', 'sumaresultados', 'coleccionCorrectas', 'userId', 'evaluationId', 'oracionesAcertadas', 'oracionesIncorrectas'));
        }
        elseif(($questionType->type) === "OI"){

            //CAPTURAR LAS 5 RESPUESTAS DEL USUARIO A LA QUESTION OA MEDIANTE EL USERID Y EVALUATIONID Y SE CREA UN ARRAY CON LOS IDS DE LOS RESULTADOS
            $answersUser = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->pluck('id')->toArray();
            //CON LOS IDS DE LOS RESULTADOS SE BUSCA UNA A UNA LA ORACION ESCRITA POR EL USUARIO EN LA TABLA RESULTS PARA TENERLOS LISTOS COMO STRINGS
            //SE ACCEDE ASI A LA RESPUESTA TIPO STRING: $oracionuno->answer_user;
            $oracionuno = Result::find($answersUser[0]);
            $oraciondos = Result::find($answersUser[1]);
            $oraciontres = Result::find($answersUser[2]);
            $oracioncuatro = Result::find($answersUser[3]);
            $oracioncinco = Result::find($answersUser[4]);

            //GUARDAR LAS RESPUESTAS DEL USUARIO EN UN ARRAY PARA ENVIARLAS A LA VISTA
            $coleccionResults = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->get();

            //CAPTURAR EL PUNTAJE QUE TIENE EL ESTUDIANTE EN LA PREGUNTA ACTUAL
            $resultados = DB::table('results')->where('question_id', $questionId)->where('user_id', $userId)->pluck('score')->toArray();
            $sumaresultados = array_sum($resultados);

            //COMO ES ORACION AUDIO SON 5 ORACIONES DE LA TABLA ANSWERS ENTONCES SE CAPTURA PRIMERO LA COLECCION DE RESPUESTAS
            $resCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->pluck('id')->toArray();
            //CON LOS IDS DE LAS ANSWERS CORRECTAS SE BUSCA UNA A UNA LA RESPUESTA EN LA TABLA ANSWERS PARA TENERMOS LISTOS COMO STRINGS
            //SE ACCEDE ASI A LA ANSWER TIPO STRING: $resoracioncorrectauno->answer;
            $resoracioncorrectauno = Answer::find($resCorrecta[0]);
            $resoracioncorrectados = Answer::find($resCorrecta[1]);
            $resoracioncorrectatres = Answer::find($resCorrecta[2]);
            $resoracioncorrectacuatro = Answer::find($resCorrecta[3]);
            $resoracioncorrectacinco = Answer::find($resCorrecta[4]);

            //GUARDAR LAS ANSWERS CORRECTAS EN UN ARRAY PARA ENVIARLAS A LA VISTA
            $coleccionCorrectas = Answer::where('question_id', $questionId)->where('is_correct', true)->get();

            //CAPTURAR LAS ORACIONES ACERTADAS Y LAS ORACIONESINCORRECTAS
            $answers = Answer::where('question_id', $questionId)->where('is_correct', true)->pluck('answer')->toArray();
            $responses = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->pluck('answer_user')->toArray();
            $oracionesAcertadas = [];
            $oracionesIncorrectas = [];
            $answersU_count = count($responses);
            //RECORRER CON UN FOR EL ARRAY DE RESPUESTAS CORRECTAS Y EL ARRAY DE RESPUESTAS DEL USUARIO Y LAS QUE COINCIDAN SE GUARDAN EN EL ARRAY
            //DE PALABRAS ACERTADAS Y LAS QUE NO COINCIDAN EN EL ARRAY DE PALABRASINCORRECTAS
            for($i=0; $i<$answersU_count; $i++){
                $comparacion = strcmp($answers[$i], $responses[$i]);
                if($comparacion == 0){
                    array_push($oracionesAcertadas, $responses[$i]);
                }
                else{
                    array_push($oracionesIncorrectas, $responses[$i]);
                }
            }


            //ACTUALIZACION
            //SE ENVIA A LA VISTA EL PUNTAJE DE CADA ENUNCIADO DEL USUARIO PARA EN FUNCION DE ESO MOSTRAR SOLO EL TEXTO DE RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA
            //CORRECTA ORIGINAL, PARA QUE EN LA VISTA EN FUNCION DE SI TIENE 0 DE PUNTAJE, ES DECIR, TIENE ERRORES, LE APAREZCA LA REVISION DEL TEXTO Y LA REVISION DE LA RESPUESTA 
            //CORRECTA, CASO CONTRARIO, CUANDO EL PUNTAJE ES DIFERENTE DE CERO, AHI SOLO APARECEN EL ENUNCIADO DE RESPUESTA ORIGINAL Y EL TEXTO CORRECTO ORIGINAL
            $resultadosenunciadosoi = DB::table('results')->where('question_id', $questionId)->where('user_id', $userId)->pluck('score')->toArray();
            //COMO QUESTION OI TIENE 5 RESPUESTAS, SE CAPTURA CADA PUNTAJE EN UNA VARIABLE DIFERENTE
            $resultadooiuno = $resultadosenunciadosoi[0];
            $resultadooidos = $resultadosenunciadosoi[1];
            $resultadooitres = $resultadosenunciadosoi[2];
            $resultadooicuatro = $resultadosenunciadosoi[3];
            $resultadooicinco = $resultadosenunciadosoi[4];
            



            /////////////////////////////////////////////////////////////////////////////CODIGO ANALISIS ORACION POR ORACION //////////////////////////////////////////////////////////

            //GUARDAR EN UNA VARIABLE CADA ORACION DE LAS 5 RESPUESTAS DEL USUARIO
            //CON TRIM SE QUITAN LOS ESPACIOS DEL INICIO Y FINAL DE LA ORACION
            $enunciadoUsuarioUno = trim($oracionuno->answer_user);
            $enunciadoUsuarioDos = trim($oraciondos->answer_user);
            $enunciadoUsuarioTres = trim($oraciontres->answer_user);
            $enunciadoUsuarioCuatro = trim($oracioncuatro->answer_user);
            $enunciadoUsuarioCinco = trim($oracioncinco->answer_user);

            //GUARDAR EN UNA VARIABLA CADA ORACION CORRECTA
            //CON TRIM SE QUITAN LOS ESPACIOS DEL INICIO Y FINAL DE LAS ORACIONES
            $enunciadoCorrectoUno = trim($resoracioncorrectauno->answer);
            $enunciadoCorrectoDos = trim($resoracioncorrectados->answer);
            $enunciadoCorrectoTres = trim($resoracioncorrectatres->answer);
            $enunciadoCorrectoCuatro = trim($resoracioncorrectacuatro->answer);
            $enunciadoCorrectoCinco = trim($resoracioncorrectacinco->answer);

            //VARIABLE QUE MOSTRARA UN MENSAJE EN LA SECCION DE DETALLE DE RESPUESTA
            $respuestaEnunciadoUno = "";
            $respuestaEnunciadoDos = "";
            $respuestaEnunciadoTres = "";
            $respuestaEnunciadoCuatro = "";
            $respuestaEnunciadoCinco = "";


            //COMPROBACION ENUNCIADO UNO
            $caracteresEnunciadoCorrectosUno = [];
            $caracteresEnunciadoIncorrectosUno = [];
            $palabrasEnunciadoCorrectasUno = [];
            $palabrasEnunciadoIncorrectasUno = [];
            $seccionesEnunciadoCorrectasUno = [];
            $seccionesEnunciadoIncorrectasUno = [];

            //LOS SIGUIENTES ARRAYS VAN A CONTENER LO SIGUIENTE
            //EL ARRAY RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO VA A CONTENER LAS PALABRAS DE LA RESPUESTA DEL USUARIO QUE NO TENGAN RELACION CON LA RESPUESTA CORRECTA
            //EL ARRAY RESULTADOENUNCIADOSIGNOSINCORRECTOSUSUARIOUNO VA A CONTENER LOS SIGNOS DE LA RESPUESTA DEL USUARIO QUE NO TENGAN RELACION CON LA ORACION CORRECTA
            //EL ARRAY RESULTADOENUNCIADOPALABRASQUELEFALTARONALUSUARIOUNO VA A CONTENER LAS PALABRAS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
            //EL ARRAY RESULTADOENUNCIADOSIGNOSQUELEFALTARONALUSUARIOUNO VA A CONTENER LOS SIGNOS DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
            //EL ARRAY RESULTADOENUNCIADOSECCIONESQUELEFALTARONALUSUARIOUNO VA A CONTENER LAS SECCIONES DE LA RESPUESTA CORRECTA QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO

            $resultadoEnunciadoPalabrasIncorrectasUsuarioUno = [];
            $resultadoEnunciadoSignosIncorrectosUsuarioUno = [];
            $resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioUno = [];
            $resultadoEnunciadoSignosQueLeFaltaronAlUsuarioUno = [];
            $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioUno = [];
            //ACTUALIZACION SE AGREGA ESTE ARRAY PARA PODER PINTAR EN LA VISTA LAS SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS
            $resultadoSeccionesIncorrectasEnunciadoUsuarioUno = [];
            

            //COMPROBACION ENUNCIADO UNO

            //PRIMERO SE DEBE COMPROBAR SI LA ORACION COMPLETA ES IGUAL, ES DECIR, COMPROBAR SI ES CORRECTA O INCORRECTA
            $compararEnunciadoUno = strcmp($enunciadoCorrectoUno, $enunciadoUsuarioUno);

            //CON EL IF SE PREGUNTA SI LA COMPARACION ES IGUAL A 0, LO QUE SIGNIFICA QUE LA RESPUESTA ES CORRECTA
            //O SI ES DIFERENTE DE 0, LO QUE SIGNIFICA QUE LA RESPUESTA ES INCORRECTA
            if($compararEnunciadoUno === 0){

                //SI ES IGUAL A CERO, LA ORACION DEL USUARIO ES CORRECTA
                $respuestaEnunciadoUno = "Su respuesta al primer enunciado es correcta.";

                $resultadoEnunciadoPalabrasIncorrectasUsuarioUno = [];
                $resultadoEnunciadoSignosIncorrectosUsuarioUno = [];
                $resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioUno = [];
                $resultadoEnunciadoSignosQueLeFaltaronAlUsuarioUno = [];
                $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioUno = [];
                //ACTUALIZACION SE AGREGA ESTE NUEVO ARRAY
                $resultadoSeccionesIncorrectasEnunciadoUsuarioUno = [];
                //ACTUALIZACION SE AGREGA ESTE CAMPO QUE CONTIENE LA RESPUESTA DEL USUARIO
                $stringSeccionesEnunciadoUsuarioUno = $enunciadoUsuarioUno;
                //ACTUALIZACION, SE ENVIA ESTE CAMPO PARA VER SI HAY ESPACIOS O NO EN LA RESPUESTA
                //COMO EN ESTE CASO NO HAY ESPACIOS ADICIONALES PORQUE LA RESPUESTA ES CORRECTA, SE ENVIA FALSE
                $existenEspaciosEnunciadoUno = false;
                //ACTUALIZACION, SI EL TEXTO ES CORRECTO LA VARIABLE hayUnEspacioEnBlancoEnunciadoUno SE ENVIA FALSE
                $hayUnEspacioEnBlancoEnunciadoUno = false;
                //ACTUALIZACION, LA VARIABLE PARA MOSTRAR EL MENSAJE ES FALSA SI LA RESPUESTA ES CORRECTA
                $mensajeEspacioBlancoUno = false;

            }else{

                //SI ES DIFERENTE DE 0, LA ORACION DEL USUARIO ES INCORRECTA
                //HAY 3 CASOS PRINCIPALES PARA QUE UNA ORACION ESTE MAL
                //1. QUE LA CADENA INGRESADA TENGA IGUAL CANTIDAD DE CARACTERES PERO QUE SEAN DIFERENTES
                //2. QUE LA CADENA INGRESADA TENGA MENOS CARACTERES QUE LA ORACION CORRECTA
                //3. QUE LA CADENA INGRESADA TENGA MAS CARACTERES QUE LA ORACION CORRECTA

                //PARA SABER QUE CASO CONVIENE A CADA ORACION, HAY QUE CONTAR CUANTOS CARACTERES HAY EN EL STRING
                //DE LA ORACION CORRECTA Y EN EL STRING DE LA RESPUESTA DEL USUARIO
                //CON EL METODO MB_STRLEN SE CUENTA EL NUMERO DE CARACTERES QUE TIENE LA RESPUESTA DEL USUARIO
                //ESTE METODO TOMA EN CUENTA LOS ESPACIOS QUE SE DEJAN AL INICIO, AL FINAL Y ENTRE EL ENUNCIADO, POR
                //ESO A LAS ORACIONES CORRECTAS Y RESPUESTAS SE LES APLICO EL METODO TRIM
                $nroCaracteresEnunciadoUsuarioUno = mb_strlen($enunciadoUsuarioUno, 'UTF-8');
                $nroCaracteresEnunciadoCorrectoUno = mb_strlen($enunciadoCorrectoUno, 'UTF-8');
                //SE DEBE HACER UN ARRAY DE LA ORACION CORRECTA Y LA ORACION DEL USUARIO PARA POSTERIORMENTE REALIZAR LAS COMPARACIONES
                //ESTOS ARRAY ALMACENAN LOS CARACTERES DE LA RESPUESTA CORRECTA Y RESPUESTA DEL USUARIO
                $arrayCaracteresEnunciadoUsuarioUno = mb_str_split($enunciadoUsuarioUno);
                $arrayCaracteresEnunciadoCorrectoUno = mb_str_split($enunciadoCorrectoUno);

                //PARA REALIZAR EL ANALISIS SE NECESITA TAMBIEN CAPTURAR TODAS LAS SECCIONEES DE LA RESPUESTA DEL USUARIO
                //SEPARADAS POR UN ESPACIO POR EJEMPLO: ¿Cuantos? pregunta: ademas, etc.
                $arraySeccionesEnunciadoCorrectoUno = explode(' ', $enunciadoCorrectoUno);
                $arraySeccionesEnunciadoUsuarioUno = explode(' ', $enunciadoUsuarioUno);

                //TAMBIEN PARA EL ANALISIS PALABRA A PALABRA SE NECESITAN CAPTURAR SOLO LAS PALABRAS DE LA RESPUESTA CORRECTA Y LAS RESPUESTAS DEL USUARIO
                //ELIMINANDO LOS SIGNOS DE PUNTUACION
                $aPalabrasEnunciadoCorrectoUno = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $enunciadoCorrectoUno);
                $arrayPalabrasEnunciadoCorrectoUno = explode(' ', $aPalabrasEnunciadoCorrectoUno);
                $aPalabrasEnunciadoUsuarioUno = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $enunciadoUsuarioUno);
                $arrayPalabrasEnunciadoUsuarioUno = explode(' ', $aPalabrasEnunciadoUsuarioUno);

                //FINALMENTE SE VAN A CAPTURAR TODOS LOS SIGNOS ORTOGRAFICOS DE LA ORACION CORRECTA Y DE LA RESPUESTA DEL USUARIO
                //POR ELLO HAY QUE CONTAR EL NUMERO DE ELEMENTOS DE CADA ARRAY DE CARACTERES
                $nroElementosArrayCaracteresEnunciadoUsuarioUno = count($arrayCaracteresEnunciadoUsuarioUno);
                $nroElementosArrayCaracteresEnunciadoCorrectoUno = count($arrayCaracteresEnunciadoCorrectoUno);
                $arraySignosEnunciadoCorrectoUno = [];
                $arraySignosEnunciadoUsuarioUno = [];
                //CON UN FOR SE RECORRE EL ARRAYCARACTERESENUNCIADOUSUARIOUNO Y SE VA GUARDANDO EN EL ARRAYSIGNOSENUNCIADOUSUARIOUNO
                for($c=0; $c<$nroElementosArrayCaracteresEnunciadoUsuarioUno; $c++){
                    if((strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], ',') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], ':') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], ';') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '-') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '+') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '/') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '.') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '...') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '....') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '&') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '!') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '¡') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '?') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '¿') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '"') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], ')') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '(') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '..') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '*') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], "'") === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '[') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], ']') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '{') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '}') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '_') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '^') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '#') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '<') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '>') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioUno[$c], '|') === 0)){

                        array_push($arraySignosEnunciadoUsuarioUno, $arrayCaracteresEnunciadoUsuarioUno[$c]);
                    }
                }


                //CON UN FOR SE RECORRE EL ARRAYCARACTERESENUNCIADOCORRECTOUNO Y SE VA GUARDANDO EN EL ARRAYSIGNOSENUNCIADOCORRECTOUNO
                for($n=0; $n<$nroElementosArrayCaracteresEnunciadoCorrectoUno; $n++){
                    if((strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], ',') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], ':') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], ';') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '-') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '+') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '/') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '.') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '...') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '....') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '&') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '!') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '¡') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '?') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '¿') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '"') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], ')') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '(') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '..') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '*') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], "'") === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '[') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], ']') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '{') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '}') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '_') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '^') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '#') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '<') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '>') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoUno[$n], '|') === 0)){

                        array_push($arraySignosEnunciadoCorrectoUno, $arrayCaracteresEnunciadoCorrectoUno[$n]);
                    }
                }

                //PARA REALIZAR EL ANALISIS DE PALABRAS, SIGNOS Y SECCIONES SE DEBE CONTAR EL NUMERO DE ELEMENTOS QUE TIENE CADA ARRAY
                $nroElementosArrayPalabrasEnunciadoUsuarioUno = count($arrayPalabrasEnunciadoUsuarioUno);
                $nroElementosArrayPalabrasEnunciadoCorrectoUno = count($arrayPalabrasEnunciadoCorrectoUno);
                $nroElementosArraySignosEnunciadoUsuarioUno = count($arraySignosEnunciadoUsuarioUno);
                $nroElementosArraySignosEnunciadoCorrectoUno = count($arraySignosEnunciadoCorrectoUno);
                $nroElementosArraySeccionesEnunciadoUsuarioUno = count($arraySeccionesEnunciadoUsuarioUno); 
                $nroElementosArraySeccionesEnunciadoCorrectoUno = count($arraySeccionesEnunciadoCorrectoUno);


                //ENCONTRAR PALABRAS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS
                //SE USA EL ARRAYPALABRASENUNCIADOCORRECTOUNO Y EL ARRAYPALABRASENUNCIADOUSUARIOUNO
                //SE RECORREN TODOS LOS ELEMENTOS DEL ARRAYPALABRASENUNCIADOUSUARIOUNO Y SE COMPARAN CON LAS PALABRAS DEL ARRAYPALABRASENUNCIADOCORRECTOUNO
                //Y LOS ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO SE ENCUENTREN EN LA RESPUESTA CORRECTA SE GUARDAN EN EL ARRAY
                //RESULTADOENUNCIADOPALABRASINCORRECTASUSUARIOUNO
                for($k=0; $k<$nroElementosArrayPalabrasEnunciadoUsuarioUno; $k++){
                    if(!in_array($arrayPalabrasEnunciadoUsuarioUno[$k], $arrayPalabrasEnunciadoCorrectoUno)){
                        array_push($resultadoEnunciadoPalabrasIncorrectasUsuarioUno, $arrayPalabrasEnunciadoUsuarioUno[$k]);
                    }
                }


                //ENCONTRAR LOS SIGNOS DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTOS
                //SE USA EL ARRAYSIGNOSENUNCIADOUSUARIOUNO Y EL ARRAYSIGNOSENUNCIADOCORRECTOUNO
                //SE RECORREN TODOS LOS ELEMENTOS DEL ARRAYSIGNOSENUNCIADOUSUARIOUNO Y SE COMPARAN CON LOS SIGNOS DEL ARRAYSIGNOSENUNCIADOCORRECTOUNO
                //Y LOS EELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO COINCIDAN CON LOS ELEMENTOS DE LA RESPUESTA CORRECTA SE GUARDAN EN EL ARRAY
                //RESULTADOSENUNCIADOSIGNOSINCORRECTOSUSUARIOUNO
                for($l=0; $l<$nroElementosArraySignosEnunciadoUsuarioUno; $l++){
                    if(!in_array($arraySignosEnunciadoUsuarioUno[$l], $arraySignosEnunciadoCorrectoUno)){
                        array_push($resultadoEnunciadoSignosIncorrectosUsuarioUno, $arraySignosEnunciadoUsuarioUno[$l]);
                    }
                }


                //ENCONTRAR LAS PALABRAS DE LA RESPUESTA CORRECTA QUE EL USUARIO NO AGREGO EN SU RESPUESTA
                //SE USA EL ARRAYPALABRASENUNCIADOCORRECTOUNO Y EL ARRAYPALABRASENUNCIADOUSUARIOUNO
                //SE RECORREN TODOS LOS ELEMENTOS DEL ARRAYPALABRASENUNCIADOCORRECTOUNO Y SE COMPARAN CON LAS PALABRAS DEL ARRAYPALABRASENUNCIADOUSUARIOUNO
                //Y LOS ELEMENTOS DE LA RESPUESTA DEL USUARIO QUE NO COINCIDAN CON LOS ELEMENTOS DE LA RESPUESTA CORRECTA SE GUARDAN EN EL ARRAY
                //RESULTADOPALABRASQUELEFALTAONALUSUARIOUNO
                for($u=0; $u<$nroElementosArrayPalabrasEnunciadoCorrectoUno; $u++){
                    if(!in_array($arrayPalabrasEnunciadoCorrectoUno[$u], $arrayPalabrasEnunciadoUsuarioUno)){
                        array_push($resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioUno, $arrayPalabrasEnunciadoCorrectoUno[$u]);
                    }
                }


                //ENCONTRAR LOS SIGNOS QUE LE FALTARON EN LA RESPUESTA AL USUARIO
                //SE USA EEL ARRAYSIGNOSENUNCIADOUSUARIOUNO Y EL ARRAYSIGNOSENUNCIADOCORRECTOUNO
                //SE RECORREN TODOS LOS ELEMENTOS DEL ARRAYSIGNOSENUNCIADOCORRECTOUNO Y SE COMPARAN CON LOS SIGNOS DEL ARRAYSIGNOSENUNCIADOUSUARIOUNO
                //Y LOS ELEEMENTOS DE LA RESPUESTA CORRECTA QUE NO ESTEN EN LA RESPUESTA DEL USUARIO SE ALMACENAN EN EL ARRAY
                //RESULTADOENUNCIADOSIGNOSQUELEFALTARONALUSUARIOUNO
                for($g=0; $g<$nroElementosArraySignosEnunciadoCorrectoUno; $g++){
                    if(!in_array($arraySignosEnunciadoCorrectoUno[$g], $arraySignosEnunciadoUsuarioUno)){
                        array_push($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioUno, $arraySignosEnunciadoCorrectoUno[$g]);
                    }
                }


                //ENCONTRAR LAS SECCIONES QUE LE FALTARON AL USUARIO UNO
                //SE USA EL ARRAYSECCIONESENUNCIADOUSUARIOUNO Y EL ARRAYSECCIONESENUNCIADOCORRECTOUNO
                //SE RECORREN TODOS LOS ELEMNTOS DELE ARRAYSECCIONESENUNCIADOCORRECTOUNO Y SE COMPARAN CON LOS ELEMENTOS DEL ARRAYSECCIONESENUNCIADOUSUARIOUNO
                //Y LOS ELEMENTOS DE LA RESPUESTA CORRECTA QUE NO ESTEN EN LA RESPUESTA DEL USUARIO SE ALMACENAN EN EL ARRAY
                //RESULTADOSENUNCIADOSECCIONESQUELEFALTARONALUSUARIOUNO

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOENUNCIADOSECCIONESQUELEFALTARONALUSUARIOUNO ORIGINAL
                //for($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoUno; $y++){
                //    if(!in_array($arraySeccionesEnunciadoCorrectoUno[$y], $arraySeccionesEnunciadoUsuarioUno)){
                //        array_push($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioUno, $arraySeccionesEnunciadoCorrectoUno[$y]);
                //    }
                //}


                //////////////////////////////////////// METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO FINAL

                $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoUno = 0;
                $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoUno = 0;
                for($u=0; $u<$nroElementosArraySeccionesEnunciadoCorrectoUno; $u++){

                    
                    for ($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoUno; $y++){
                        $compararenunciadouno = strcmp($arraySeccionesEnunciadoCorrectoUno[$u], $arraySeccionesEnunciadoCorrectoUno[$y]);
                        if ($compararenunciadouno === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoUno++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesEnunciadoUsuarioUno); $z++){
                        $compararenunciadounousuario = strcmp($arraySeccionesEnunciadoCorrectoUno[$u], $arraySeccionesEnunciadoUsuarioUno[$z]);
                        if($compararenunciadounousuario === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoUno++;
                        }
                    }

                    if(($contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoUno > $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoUno)){
                        if (!in_array($arraySeccionesEnunciadoCorrectoUno[$u], $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioUno)){
                            array_push($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioUno, $arraySeccionesEnunciadoCorrectoUno[$u]);
                        }
                        
                    }
                    $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoUno = 0;
                    $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoUno = 0;
                }

                ///////////////////////////////////////// FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO



                //ACTUALIZACION
                //EN EL ARRAY COMENTADO SE AGREGARAN LAS SECCIONES DE ORACION UNO DEL USUARIO QUE NO COINCIDAN CON LAS SECCIONES DE LA ORACION CORRECTA UNO
                // $resultadoSeccionesIncorrectasEnunciadoUsuarioUno = [];
                //PARA LA COMPARACION, CON UN FOR SE RECORRE EL ARRAYSECCIONESORACIONUSUARIOUNO Y SE PREGUNTA SI LA SECCION [I] DE ESE ARRAY NO COINCIDE CON ALGUNA DE LAS SECCIONES DE LA ORACION CORRECTA
                //Y LAS SECCIONES DEL ARRAYSECCIONESORACIONUSUARIOUNO QUE NO COINCIDAN CON ALGUNA SECCION DEL ARRAYSECCIONESORACIONCORRECTAUNO, SE GUARDAN EN EL ARRAY
                //RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO PARA ENVIARLAS A LA VISTA

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO
                //for($p=0; $p<$nroElementosArraySeccionesEnunciadoUsuarioUno; $p++){
                //
                //    if(!in_array($arraySeccionesEnunciadoUsuarioUno[$p], $arraySeccionesEnunciadoCorrectoUno)){
                //        array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioUno, $arraySeccionesEnunciadoUsuarioUno[$p]);
                //    }
                //}


                //return $resultadoSeccionesIncorrectasEnunciadoUsuarioUno;

                //////////////////////////////////////METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL

                //CAPTURAR LAS PALABRAS QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA Y AGREGARLAS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS
                for($b=0; $b<$nroElementosArraySeccionesEnunciadoUsuarioUno; $b++){
                    if(!in_array($arraySeccionesEnunciadoUsuarioUno[$b], $arraySeccionesEnunciadoCorrectoUno)){
                        array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioUno, $arraySeccionesEnunciadoUsuarioUno[$b]);
                    }
                }

                //AGREGAR AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS LAS PALABRAS QUE SI FORMAN PARTE DEL TEXTO CORRECTO, PERO QUE ESTAN AGREGADAS EN DEMASIA
                //ES DECIR, EN EL TEXTO CORRECTO HAY 2 "HOLA" PERO EN LA RESPUESTA DEL USUARIO HAY 3 "HOLA", POR LO TANTO ES UNA PALABRA INCORRECTA.
                //ESTE METODO ESTÁ BASADO EN EL METODO PARA AGREGAR ELEMENTOS AL ARRAY $resultadoSeccionesQueLeFaltaronParrafoUsuario
                //LA DIFERENCIA ES QUE EN LA SECCION FINAL DE ESTE METODO SE CAMBIO EL METODO DE MAYOR QUE A MENOR QUE  

                $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoUno = 0;
                $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoUno = 0;
                for($u=0; $u<$nroElementosArraySeccionesEnunciadoCorrectoUno; $u++){

                    for ($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoUno; $y++){
                        $compararenunciadouno = strcmp($arraySeccionesEnunciadoCorrectoUno[$u], $arraySeccionesEnunciadoCorrectoUno[$y]);
                        if ($compararenunciadouno === 0){
                            $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoUno++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesEnunciadoUsuarioUno); $z++){
                        $compararenunciadounousuario = strcmp($arraySeccionesEnunciadoCorrectoUno[$u], $arraySeccionesEnunciadoUsuarioUno[$z]);
                        if($compararenunciadounousuario === 0){
                            $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoUno++;
                        }
                    }

                    if(($contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoUno < $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoUno)){
                        if (!in_array($arraySeccionesEnunciadoCorrectoUno[$u], $resultadoSeccionesIncorrectasEnunciadoUsuarioUno)){
                            array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioUno, $arraySeccionesEnunciadoCorrectoUno[$u]);
                        }
                        
                    }
                    $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoUno = 0;
                    $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoUno = 0;

                } 


                ///////////////////////////////////////FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL



                //ACTUALIZACION
                //A TRAVES DEL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE PUEDE REEMPLAZAR CON "_" LOS ESPACIOS ADICIONALES QUE EL USUARIO HAYA AGREGADO 
                //A SU RESPUESTA, CUANDO LA RESPUESTA DEL USUARIO SEA ERRONEA. POR ESA RAZON EL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE ENVIA A LA VISTA
                //PARA MOSTRARLO CUANDO LAS ORACIONES NO COINCIDAN

                //PRIMERO SE RECORRE EL ARRAY Y CUANDO ENCUENTRE ESPACIOS VACIOS LOS VA A IR REEMPLAZANDO POR "_"
                for($b=0; $b<count($arraySeccionesEnunciadoUsuarioUno); $b++){
                    if($arraySeccionesEnunciadoUsuarioUno[$b] === ""){
                        $arraySeccionesEnunciadoUsuarioUno[$b] = "_";
                    }
                }

                //LUEGO CON EL IMPLDE SE UNE EL ARRAY DE NUEVO PARA ENVIARLO A LA VISTA
                $stringSeccionesEnunciadoUsuarioUno = implode(" ", $arraySeccionesEnunciadoUsuarioUno);
                //A LA VISTA TAMBIEN SEE VA A ENVIAR UNA VARIABLE TIPO BOOLEAN QUE ENVIA FALSE SI NO HAY "_" EN EL 
                //ARRAYSECCIONESENUNCIADOUSUARIOUNO Y DEVUELVE TRUE SI ESQUE SI HAY "_" EN EL ARRAY
                //ESTO SE ENVIA A LA VISTA PARA QUE EN BASE A LO QUE DEVUELVA, APAREZCA EL MENSAJE DE QUE HAY ESPACIOS ADICIONALES
                //EN LA RESPUESTA DEL USUARIO O NO HAY ESPACIOS ADICIONALES EN LA RESPUESTA DEL USUARIO
                $existenEspaciosEnunciadoUno = false;
                if(in_array("_", $arraySeccionesEnunciadoUsuarioUno)){
                    $existenEspaciosEnunciadoUno = true;
                }

                //return $existenEspaciosEnunciadoUno;


                //ACTUALIZACION
                //ANTES DE ENVIAR EL ARRYA RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO
                //SE AGREGA ARRAY_UNIQUE Y SE REEMPLAZA LOS ESPACIOS VACIOS "" POR LA PALABRA "ESPACIOS VACIOS"
                //EN ARRAY_UNIQUE SE REALIZA EN LA VISTA, REVISAR EN LA SECCION DONDE SE RECORRE EL ARRAY RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO
                //EN LA VISTA

                for($u=0; $u<count($resultadoSeccionesIncorrectasEnunciadoUsuarioUno); $u++){
                    if($resultadoSeccionesIncorrectasEnunciadoUsuarioUno[$u] === ""){
                        $resultadoSeccionesIncorrectasEnunciadoUsuarioUno[$u] = "Espacios en blanco.";
                    }
                }


                //return $resultadoSeccionesIncorrectasEnunciadoUsuarioUno;


                //EN EL FINAL SE ENVIA LA OBSERVACION A LA RESPUESTA
                //CON EL IF SE PREGUNTA SI NROELEMENTOSARRAYCARACTERESENUNCIADOUNO ES IGUAL, MENOR O MAYOR QUE LA RESPUESTA DEL USUARIO
                //Y SE ENVIA LA RESPUESTA SEGUN CORRESPONDA
                if($nroElementosArrayCaracteresEnunciadoCorrectoUno === $nroElementosArrayCaracteresEnunciadoUsuarioUno){
                    $respuestaEnunciadoUno = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresEnunciadoCorrectoUno < $nroElementosArrayCaracteresEnunciadoUsuarioUno){
                    //$respuestaEnunciadoUno = "Su respuesta es incorrecta. Puede contener letras, signos ortográficos incorrectos o más de un espacio entre palabras.";
                    $respuestaEnunciadoUno = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresEnunciadoCorrectoUno > $nroElementosArrayCaracteresEnunciadoUsuarioUno){
                    //$respuestaEnunciadoUno = "Su respuesta es incorrecta. Ha omitido algunos elementos en su respuesta.";
                    $respuestaEnunciadoUno = "Su respuesta es incorrecta.";
                }
                else{
                    //$respuestaEnunciadoUno = "Su respuesta es incorrecta. Tiene algunos errores que se detallan abajo.";
                    $respuestaEnunciadoUno = "Su respuesta es incorrecta.";
                }


                //ACTUALIZACION
                //SE VERIFICA SI EN EL ARRAY $resultadoSeccionesIncorrectasEnunciadoUsuarioUno TODOS LOS ELEMENTOS SON "Espacios en blanco."
                //SI ES ASI, EN LA VARIABLE $hayUnEspacioEnBlancoEnunciadoUno SE ENVIA TRUE, CASO CONTRARIO SE ENVIA FALSE
               
                $hayUnEspacioEnBlancoEnunciadoUno = false;

                //SE RECORRE EL ARRAY DE LAS SECCIONES INCORRECTAS Y SE COMPARA SI TODOS LOS ELEMENTOS SON ESPACIOS EN BLANCO
                $contadorEspaciosUno = 0;
                for($f=0; $f< count($resultadoSeccionesIncorrectasEnunciadoUsuarioUno); $f++){
                    if($resultadoSeccionesIncorrectasEnunciadoUsuarioUno[$f] === "Espacios en blanco."){
                        $contadorEspaciosUno++;
                    }
                }
                if($contadorEspaciosUno === count($resultadoSeccionesIncorrectasEnunciadoUsuarioUno)){
                    $hayUnEspacioEnBlancoEnunciadoUno = true;
                }

                //return $contadorEspaciosUno;

                //CON EL IN ARRAY SE COMPRUEBA SI HAY ESPACIOS EN BLANCO EN EL ARRAY DE SECCIONESINCORRECTAS
                //ESTO SIRVE PARA MOSTRAR UN MENSAJE EN LA VISTA DE QUE EL USUARIO TIENE ESPACIOS EN BLANCO
                //Y ADEMAS OTROS ELEMENTOS INCORRECTOS
                $mensajeEspacioBlancoUno = false;
                if(in_array("Espacios en blanco.", $resultadoSeccionesIncorrectasEnunciadoUsuarioUno)){
                    $mensajeEspacioBlancoUno = true;
                }

                //return $mensajeEspacioBlancoUno;
                

            }


            //COMPROBACION ENUNCIADO DOS

            $caracteresEnunciadoCorrectosDos = [];
            $caracteresEnunciadoIncorrectosDos = [];
            $palabrasEnunciadoCorrectasDos = [];
            $palabrasEnunciadoIncorrectasDos = [];
            $seccionesEnunciadoCorrectasDos = [];
            $seccionesEnunciadoIncorrectasDos = [];

            $resultadoEnunciadoPalabrasIncorrectasUsuarioDos = [];
            $resultadoEnunciadoSignosIncorrectosUsuarioDos = [];
            $resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioDos = [];
            $resultadoEnunciadoSignosQueLeFaltaronAlUsuarioDos = [];
            $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioDos = [];
            //ACTUALIZACION SE AGREGA ESTE ARRAY PARA PODER PINTAR EN LA VISTA LAS SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS
            $resultadoSeccionesIncorrectasEnunciadoUsuarioDos = [];

            $compararEnunciadoDos = strcmp($enunciadoCorrectoDos, $enunciadoUsuarioDos);


            if($compararEnunciadoDos === 0){

                //SI ES IGUAL A CERO, LA ORACION DEL USUARIO ES CORRECTA
                $respuestaEnunciadoDos = "Su respuesta al segundo enunciado es correcta.";

                $resultadoEnunciadoPalabrasIncorrectasUsuarioDos = [];
                $resultadoEnunciadoSignosIncorrectosUsuarioDos = [];
                $resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioDos = [];
                $resultadoEnunciadoSignosQueLeFaltaronAlUsuarioDos = [];
                $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioDos = [];
                //ACTUALIZACION SE AGREGA ESTE NUEVO ARRAY
                $resultadoSeccionesIncorrectasEnunciadoUsuarioDos = [];
                //ACTUALIZACION SE AGREGA ESTE NUEVO ARRAY
                $resultadoSeccionesIncorrectasEnunciadoUsuarioDos = [];
                //ACTUALIZACION SE AGREGA ESTE CAMPO QUE CONTIENE LA RESPUESTA DEL USUARIO
                $stringSeccionesEnunciadoUsuarioDos = $enunciadoUsuarioDos;
                //ACTUALIZACION, SE ENVIA ESTE CAMPO PARA VER SI HAY ESPACIOS O NO EN LA RESPUESTA
                //COMO EN ESTE CASO NO HAY ESPACIOS ADICIONALES PORQUE LA RESPUESTA ES CORRECTA, SE ENVIA FALSE
                $existenEspaciosEnunciadoDos = false;
                //ACTUALIZACION, SI EL TEXTO ES CORRECTO LA VARIABLE hayUnEspacioEnBlancoEnunciadoDos SE ENVIA FALSE
                $hayUnEspacioEnBlancoEnunciadoDos = false;
                //ACTUALIZACION, LA VARIABLE PARA MOSTRAR EL MENSAJE ES FALSA SI LA RESPUESTA ES CORRECTA
                $mensajeEspacioBlancoDos = false;


            }else{

                $nroCaracteresEnunciadoUsuarioDos = mb_strlen($enunciadoUsuarioDos, 'UTF-8');
                $nroCaracteresEnunciadoCorrectoDos = mb_strlen($enunciadoCorrectoDos, 'UTF-8');

                $arrayCaracteresEnunciadoUsuarioDos = mb_str_split($enunciadoUsuarioDos);
                $arrayCaracteresEnunciadoCorrectoDos = mb_str_split($enunciadoCorrectoDos);

                $arraySeccionesEnunciadoCorrectoDos = explode(' ', $enunciadoCorrectoDos);
                $arraySeccionesEnunciadoUsuarioDos = explode(' ', $enunciadoUsuarioDos);

                $aPalabrasEnunciadoCorrectoDos = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $enunciadoCorrectoDos);
                $arrayPalabrasEnunciadoCorrectoDos = explode(' ', $aPalabrasEnunciadoCorrectoDos);
                $aPalabrasEnunciadoUsuarioDos = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $enunciadoUsuarioDos);
                $arrayPalabrasEnunciadoUsuarioDos = explode(' ', $aPalabrasEnunciadoUsuarioDos);

                $nroElementosArrayCaracteresEnunciadoUsuarioDos = count($arrayCaracteresEnunciadoUsuarioDos);
                $nroElementosArrayCaracteresEnunciadoCorrectoDos = count($arrayCaracteresEnunciadoCorrectoDos);
                $arraySignosEnunciadoCorrectoDos = [];
                $arraySignosEnunciadoUsuarioDos = [];

                for($c=0; $c<$nroElementosArrayCaracteresEnunciadoUsuarioDos; $c++){
                    if((strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], ',') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], ':') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], ';') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '-') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '+') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '/') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '.') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '...') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '....') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '&') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '!') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '¡') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '?') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '¿') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '"') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], ')') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '(') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '..') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '*') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], "'") === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '[') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], ']') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '{') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '}') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '_') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '^') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '#') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '<') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '>') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioDos[$c], '|') === 0)){

                        array_push($arraySignosEnunciadoUsuarioDos, $arrayCaracteresEnunciadoUsuarioDos[$c]);
                    }
                }


                for($n=0; $n<$nroElementosArrayCaracteresEnunciadoCorrectoDos; $n++){
                    if((strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], ',') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], ':') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], ';') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '-') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '+') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '/') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '.') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '...') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '....') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '&') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '!') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '¡') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '?') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '¿') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '"') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], ')') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '(') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '..') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '*') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], "'") === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '[') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], ']') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '{') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '}') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '_') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '^') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '#') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '<') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '>') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoDos[$n], '|') === 0)){

                        array_push($arraySignosEnunciadoCorrectoDos, $arrayCaracteresEnunciadoCorrectoDos[$n]);
                    }
                }

                $nroElementosArrayPalabrasEnunciadoUsuarioDos = count($arrayPalabrasEnunciadoUsuarioDos);
                $nroElementosArrayPalabrasEnunciadoCorrectoDos = count($arrayPalabrasEnunciadoCorrectoDos);
                $nroElementosArraySignosEnunciadoUsuarioDos = count($arraySignosEnunciadoUsuarioDos);
                $nroElementosArraySignosEnunciadoCorrectoDos = count($arraySignosEnunciadoCorrectoDos);
                $nroElementosArraySeccionesEnunciadoUsuarioDos = count($arraySeccionesEnunciadoUsuarioDos); 
                $nroElementosArraySeccionesEnunciadoCorrectoDos = count($arraySeccionesEnunciadoCorrectoDos);


                for($k=0; $k<$nroElementosArrayPalabrasEnunciadoUsuarioDos; $k++){
                    if(!in_array($arrayPalabrasEnunciadoUsuarioDos[$k], $arrayPalabrasEnunciadoCorrectoDos)){
                        array_push($resultadoEnunciadoPalabrasIncorrectasUsuarioDos, $arrayPalabrasEnunciadoUsuarioDos[$k]);
                    }
                }


                for($l=0; $l<$nroElementosArraySignosEnunciadoUsuarioDos; $l++){
                    if(!in_array($arraySignosEnunciadoUsuarioDos[$l], $arraySignosEnunciadoCorrectoDos)){
                        array_push($resultadoEnunciadoSignosIncorrectosUsuarioDos, $arraySignosEnunciadoUsuarioDos[$l]);
                    }
                }


                for($u=0; $u<$nroElementosArrayPalabrasEnunciadoCorrectoDos; $u++){
                    if(!in_array($arrayPalabrasEnunciadoCorrectoDos[$u], $arrayPalabrasEnunciadoUsuarioDos)){
                        array_push($resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioDos, $arrayPalabrasEnunciadoCorrectoDos[$u]);
                    }
                }

                for($g=0; $g<$nroElementosArraySignosEnunciadoCorrectoDos; $g++){
                    if(!in_array($arraySignosEnunciadoCorrectoDos[$g], $arraySignosEnunciadoUsuarioDos)){
                        array_push($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioDos, $arraySignosEnunciadoCorrectoDos[$g]);
                    }
                }

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOENUNCIADOSECCIONESQUELEFALTARONALUSUARIODOS
                //for($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoDos; $y++){
                //    if(!in_array($arraySeccionesEnunciadoCorrectoDos[$y], $arraySeccionesEnunciadoUsuarioDos)){
                //        array_push($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioDos, $arraySeccionesEnunciadoCorrectoDos[$y]);
                //    }
                //}

                //////////////////////////////////////// METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO FINAL

                $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoDos = 0;
                $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoDos = 0;
                for($u=0; $u<$nroElementosArraySeccionesEnunciadoCorrectoDos; $u++){

                    
                    for ($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoDos; $y++){
                        $compararenunciadodos = strcmp($arraySeccionesEnunciadoCorrectoDos[$u], $arraySeccionesEnunciadoCorrectoDos[$y]);
                        if ($compararenunciadodos === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoDos++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesEnunciadoUsuarioDos); $z++){
                        $compararenunciadodosusuario = strcmp($arraySeccionesEnunciadoCorrectoDos[$u], $arraySeccionesEnunciadoUsuarioDos[$z]);
                        if($compararenunciadodosusuario === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoDos++;
                        }
                    }

                    if(($contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoDos > $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoDos)){
                        if (!in_array($arraySeccionesEnunciadoCorrectoDos[$u], $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioDos)){
                            array_push($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioDos, $arraySeccionesEnunciadoCorrectoDos[$u]);
                        }
                        
                    }
                    $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoDos = 0;
                    $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoDos = 0;
                }

                ///////////////////////////////////////// FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO



                //ACTUALIZACION
                //EN EL ARRAY COMENTADO SE AGREGARAN LAS SECCIONES DE ORACION UNO DEL USUARIO QUE NO COINCIDAN CON LAS SECCIONES DE LA ORACION CORRECTA UNO
                // $resultadoSeccionesIncorrectasEnunciadoUsuarioUno = [];
                //PARA LA COMPARACION, CON UN FOR SE RECORRE EL ARRAYSECCIONESORACIONUSUARIOUNO Y SE PREGUNTA SI LA SECCION [I] DE ESE ARRAY NO COINCIDE CON ALGUNA DE LAS SECCIONES DE LA ORACION CORRECTA
                //Y LAS SECCIONES DEL ARRAYSECCIONESORACIONUSUARIOUNO QUE NO COINCIDAN CON ALGUNA SECCION DEL ARRAYSECCIONESORACIONCORRECTAUNO, SE GUARDAN EN EL ARRAY
                //RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO PARA ENVIARLAS A LA VISTA

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIODOS
                //for($p=0; $p<$nroElementosArraySeccionesEnunciadoUsuarioDos; $p++){
                //
                //    if(!in_array($arraySeccionesEnunciadoUsuarioDos[$p], $arraySeccionesEnunciadoCorrectoDos)){
                //        array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioDos, $arraySeccionesEnunciadoUsuarioDos[$p]);
                //    }
                //}


                //return $resultadoSeccionesIncorrectasEnunciadoUsuarioDos;


                //////////////////////////////////////METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL

                //CAPTURAR LAS PALABRAS QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA Y AGREGARLAS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS
                for($b=0; $b<$nroElementosArraySeccionesEnunciadoUsuarioDos; $b++){
                    if(!in_array($arraySeccionesEnunciadoUsuarioDos[$b], $arraySeccionesEnunciadoCorrectoDos)){
                        array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioDos, $arraySeccionesEnunciadoUsuarioDos[$b]);
                    }
                }

                //AGREGAR AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS LAS PALABRAS QUE SI FORMAN PARTE DEL TEXTO CORRECTO, PERO QUE ESTAN AGREGADAS EN DEMASIA
                //ES DECIR, EN EL TEXTO CORRECTO HAY 2 "HOLA" PERO EN LA RESPUESTA DEL USUARIO HAY 3 "HOLA", POR LO TANTO ES UNA PALABRA INCORRECTA.
                //ESTE METODO ESTÁ BASADO EN EL METODO PARA AGREGAR ELEMENTOS AL ARRAY $resultadoSeccionesQueLeFaltaronParrafoUsuario
                //LA DIFERENCIA ES QUE EN LA SECCION FINAL DE ESTE METODO SE CAMBIO EL METODO DE MAYOR QUE A MENOR QUE  

                $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoDos = 0;
                $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoDos = 0;
                for($u=0; $u<$nroElementosArraySeccionesEnunciadoCorrectoDos; $u++){

                    for ($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoDos; $y++){
                        $compararenunciadodos = strcmp($arraySeccionesEnunciadoCorrectoDos[$u], $arraySeccionesEnunciadoCorrectoDos[$y]);
                        if ($compararenunciadodos === 0){
                            $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoDos++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesEnunciadoUsuarioDos); $z++){
                        $compararenunciadodosusuario = strcmp($arraySeccionesEnunciadoCorrectoDos[$u], $arraySeccionesEnunciadoUsuarioDos[$z]);
                        if($compararenunciadodosusuario === 0){
                            $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoDos++;
                        }
                    }

                    if(($contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoDos < $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoDos)){
                        if (!in_array($arraySeccionesEnunciadoCorrectoDos[$u], $resultadoSeccionesIncorrectasEnunciadoUsuarioDos)){
                            array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioDos, $arraySeccionesEnunciadoCorrectoDos[$u]);
                        }
                        
                    }
                    $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoDos = 0;
                    $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoDos = 0;

                } 


                ///////////////////////////////////////FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL




                //ACTUALIZACION
                //A TRAVES DEL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE PUEDE REEMPLAZAR CON "_" LOS ESPACIOS ADICIONALES QUE EL USUARIO HAYA AGREGADO 
                //A SU RESPUESTA, CUANDO LA RESPUESTA DEL USUARIO SEA ERRONEA. POR ESA RAZON EL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE ENVIA A LA VISTA
                //PARA MOSTRARLO CUANDO LAS ORACIONES NO COINCIDAN

                //PRIMERO SE RECORRE EL ARRAY Y CUANDO ENCUENTRE ESPACIOS VACIOS LOS VA A IR REEMPLAZANDO POR "_"
                for($b=0; $b<count($arraySeccionesEnunciadoUsuarioDos); $b++){
                    if($arraySeccionesEnunciadoUsuarioDos[$b] === ""){
                        $arraySeccionesEnunciadoUsuarioDos[$b] = "_";
                    }
                }

                //LUEGO CON EL IMPLDE SE UNE EL ARRAY DE NUEVO PARA ENVIARLO A LA VISTA
                $stringSeccionesEnunciadoUsuarioDos = implode(" ", $arraySeccionesEnunciadoUsuarioDos);
                //A LA VISTA TAMBIEN SEE VA A ENVIAR UNA VARIABLE TIPO BOOLEAN QUE ENVIA FALSE SI NO HAY "_" EN EL 
                //ARRAYSECCIONESENUNCIADOUSUARIOUNO Y DEVUELVE TRUE SI ESQUE SI HAY "_" EN EL ARRAY
                //ESTO SE ENVIA A LA VISTA PARA QUE EN BASE A LO QUE DEVUELVA, APAREZCA EL MENSAJE DE QUE HAY ESPACIOS ADICIONALES
                //EN LA RESPUESTA DEL USUARIO O NO HAY ESPACIOS ADICIONALES EN LA RESPUESTA DEL USUARIO
                $existenEspaciosEnunciadoDos = false;
                if(in_array("_", $arraySeccionesEnunciadoUsuarioDos)){
                    $existenEspaciosEnunciadoDos = true;
                }

                //return $stringSeccionesEnunciadoUsuarioDos;



                //ACTUALIZACION
                //ANTES DE ENVIAR EL ARRYA RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO
                //SE AGREGA ARRAY_UNIQUE Y SE REEMPLAZA LOS ESPACIOS VACIOS "" POR LA PALABRA "ESPACIOS VACIOS"
                //EN ARRAY_UNIQUE SE REALIZA EN LA VISTA, REVISAR EN LA SECCION DONDE SE RECORRE EL ARRAY RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO
                //EN LA VISTA

                for($u=0; $u<count($resultadoSeccionesIncorrectasEnunciadoUsuarioDos); $u++){
                    if($resultadoSeccionesIncorrectasEnunciadoUsuarioDos[$u] === ""){
                        $resultadoSeccionesIncorrectasEnunciadoUsuarioDos[$u] = "Espacios en blanco.";
                    }
                }


                //return $resultadoSeccionesIncorrectasEnunciadoUsuarioDos;



                if($nroElementosArrayCaracteresEnunciadoCorrectoDos === $nroElementosArrayCaracteresEnunciadoUsuarioDos){
                    $respuestaEnunciadoDos = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresEnunciadoCorrectoDos < $nroElementosArrayCaracteresEnunciadoUsuarioDos){
                    //$respuestaEnunciadoDos = "Su respuesta es incorrecta. Puede contener letras, signos ortográficos incorrectos o más de un espacio entre palabras.";
                    $respuestaEnunciadoDos = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresEnunciadoCorrectoDos > $nroElementosArrayCaracteresEnunciadoUsuarioDos){
                    //$respuestaEnunciadoDos = "Su respuesta es incorrecta. Ha omitido algunos elementos en su respuesta.";
                    $respuestaEnunciadoDos = "Su respuesta es incorrecta.";
                }
                else{
                    //$respuestaEnunciadoDos = "Su respuesta es incorrecta. Tiene algunos errores que se detallan abajo.";
                    $respuestaEnunciadoDos = "Su respuesta es incorrecta.";
                }


                //ACTUALIZACION
                //SE VERIFICA SI EN EL ARRAY $resultadoSeccionesIncorrectasEnunciadoUsuarioUno TODOS LOS ELEMENTOS SON "Espacios en blanco."
                //SI ES ASI, EN LA VARIABLE $hayUnEspacioEnBlancoEnunciadoUno SE ENVIA TRUE, CASO CONTRARIO SE ENVIA FALSE
               
                $hayUnEspacioEnBlancoEnunciadoDos = false;

                //SE RECORRE EL ARRAY DE LAS SECCIONES INCORRECTAS Y SE COMPARA SI TODOS LOS ELEMENTOS SON ESPACIOS EN BLANCO
                $contadorEspaciosDos = 0;
                for($f=0; $f< count($resultadoSeccionesIncorrectasEnunciadoUsuarioDos); $f++){
                    if($resultadoSeccionesIncorrectasEnunciadoUsuarioDos[$f] === "Espacios en blanco."){
                        $contadorEspaciosDos++;
                    }
                }
                if($contadorEspaciosDos === count($resultadoSeccionesIncorrectasEnunciadoUsuarioDos)){
                    $hayUnEspacioEnBlancoEnunciadoDos = true;
                }

                //return $hayUnEspacioEnBlancoEnunciadoDos;


                //CON EL IN ARRAY SE COMPRUEBA SI HAY ESPACIOS EN BLANCO EN EL ARRAY DE SECCIONESINCORRECTAS
                //ESTO SIRVE PARA MOSTRAR UN MENSAJE EN LA VISTA DE QUE EL USUARIO TIENE ESPACIOS EN BLANCO
                //Y ADEMAS OTROS ELEMENTOS INCORRECTOS
                $mensajeEspacioBlancoDos = false;
                if(in_array("Espacios en blanco.", $resultadoSeccionesIncorrectasEnunciadoUsuarioDos)){
                    $mensajeEspacioBlancoDos = true;
                }

                //return $mensajeEspacioBlancoDos;



            }


            //COMPROBACION ENUNCIADO TRES

            $caracteresEnunciadoCorrectosTres = [];
            $caracteresEnunciadoIncorrectosTres = [];
            $palabrasEnunciadoCorrectasTres = [];
            $palabrasEnunciadoIncorrectasTres = [];
            $seccionesEnunciadoCorrectasTres = [];
            $seccionesEnunciadoIncorrectasTres = [];

            $resultadoEnunciadoPalabrasIncorrectasUsuarioTres = [];
            $resultadoEnunciadoSignosIncorrectosUsuarioTres = [];
            $resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioTres = [];
            $resultadoEnunciadoSignosQueLeFaltaronAlUsuarioTres = [];
            $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioTres = [];
            //ACTUALIZACION SE AGREGA ESTE ARRAY PARA PODER PINTAR EN LA VISTA LAS SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS
            $resultadoSeccionesIncorrectasEnunciadoUsuarioTres = [];

            $compararEnunciadoTres = strcmp($enunciadoCorrectoTres, $enunciadoUsuarioTres);


            if($compararEnunciadoTres === 0){

                //SI ES IGUAL A CERO, LA ORACION DEL USUARIO ES CORRECTA
                $respuestaEnunciadoTres = "Su respuesta al tercer enunciado es correcta.";

                $resultadoEnunciadoPalabrasIncorrectasUsuarioTres = [];
                $resultadoEnunciadoSignosIncorrectosUsuarioTres = [];
                $resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioTres = [];
                $resultadoEnunciadoSignosQueLeFaltaronAlUsuarioTres = [];
                $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioTres = [];
                //ACTUALIZACION SE AGREGA ESTE NUEVO ARRAY
                $resultadoSeccionesIncorrectasEnunciadoUsuarioTres = [];
                //ACTUALIZACION SE AGREGA ESTE CAMPO QUE CONTIENE LA RESPUESTA DEL USUARIO
                $stringSeccionesEnunciadoUsuarioTres = $enunciadoUsuarioTres;
                //ACTUALIZACION, SE ENVIA ESTE CAMPO PARA VER SI HAY ESPACIOS O NO EN LA RESPUESTA
                //COMO EN ESTE CASO NO HAY ESPACIOS ADICIONALES PORQUE LA RESPUESTA ES CORRECTA, SE ENVIA FALSE
                $existenEspaciosEnunciadoTres = false;
                //ACTUALIZACION, SI EL TEXTO ES CORRECTO LA VARIABLE hayUnEspacioEnBlancoEnunciadoDos SE ENVIA FALSE
                $hayUnEspacioEnBlancoEnunciadoTres = false;
                //ACTUALIZACION, LA VARIABLE PARA MOSTRAR EL MENSAJE ES FALSA SI LA RESPUESTA ES CORRECTA
                $mensajeEspacioBlancoTres = false;


            }else{

                $nroCaracteresEnunciadoUsuarioTres = mb_strlen($enunciadoUsuarioTres, 'UTF-8');
                $nroCaracteresEnunciadoCorrectoTres = mb_strlen($enunciadoCorrectoTres, 'UTF-8');

                $arrayCaracteresEnunciadoUsuarioTres = mb_str_split($enunciadoUsuarioTres);
                $arrayCaracteresEnunciadoCorrectoTres = mb_str_split($enunciadoCorrectoTres);

                $arraySeccionesEnunciadoCorrectoTres = explode(' ', $enunciadoCorrectoTres);
                $arraySeccionesEnunciadoUsuarioTres = explode(' ', $enunciadoUsuarioTres);

                $aPalabrasEnunciadoCorrectoTres = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $enunciadoCorrectoTres);
                $arrayPalabrasEnunciadoCorrectoTres = explode(' ', $aPalabrasEnunciadoCorrectoTres);
                $aPalabrasEnunciadoUsuarioTres = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $enunciadoUsuarioTres);
                $arrayPalabrasEnunciadoUsuarioTres = explode(' ', $aPalabrasEnunciadoUsuarioTres);

                $nroElementosArrayCaracteresEnunciadoUsuarioTres = count($arrayCaracteresEnunciadoUsuarioTres);
                $nroElementosArrayCaracteresEnunciadoCorrectoTres = count($arrayCaracteresEnunciadoCorrectoTres);
                $arraySignosEnunciadoCorrectoTres = [];
                $arraySignosEnunciadoUsuarioTres = [];

                for($c=0; $c<$nroElementosArrayCaracteresEnunciadoUsuarioTres; $c++){
                    if((strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], ',') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], ':') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], ';') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '-') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '+') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '/') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '.') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '...') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '....') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '&') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '!') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '¡') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '?') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '¿') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '"') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], ')') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '(') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '..') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '*') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], "'") === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '[') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], ']') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '{') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '}') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '_') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '^') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '#') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '<') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '>') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioTres[$c], '|') === 0)){

                        array_push($arraySignosEnunciadoUsuarioTres, $arrayCaracteresEnunciadoUsuarioTres[$c]);
                    }
                }


                for($n=0; $n<$nroElementosArrayCaracteresEnunciadoCorrectoTres; $n++){
                    if((strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], ',') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], ':') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], ';') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '-') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '+') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '/') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '.') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '...') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '....') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '&') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '!') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '¡') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '?') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '¿') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '"') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], ')') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '(') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '..') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '*') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], "'") === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '[') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], ']') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '{') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '}') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '_') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '^') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '#') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '<') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '>') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoTres[$n], '|') === 0)){

                        array_push($arraySignosEnunciadoCorrectoTres, $arrayCaracteresEnunciadoCorrectoTres[$n]);
                    }
                }

                $nroElementosArrayPalabrasEnunciadoUsuarioTres = count($arrayPalabrasEnunciadoUsuarioTres);
                $nroElementosArrayPalabrasEnunciadoCorrectoTres = count($arrayPalabrasEnunciadoCorrectoTres);
                $nroElementosArraySignosEnunciadoUsuarioTres = count($arraySignosEnunciadoUsuarioTres);
                $nroElementosArraySignosEnunciadoCorrectoTres = count($arraySignosEnunciadoCorrectoTres);
                $nroElementosArraySeccionesEnunciadoUsuarioTres = count($arraySeccionesEnunciadoUsuarioTres); 
                $nroElementosArraySeccionesEnunciadoCorrectoTres = count($arraySeccionesEnunciadoCorrectoTres);


                for($k=0; $k<$nroElementosArrayPalabrasEnunciadoUsuarioTres; $k++){
                    if(!in_array($arrayPalabrasEnunciadoUsuarioTres[$k], $arrayPalabrasEnunciadoCorrectoTres)){
                        array_push($resultadoEnunciadoPalabrasIncorrectasUsuarioTres, $arrayPalabrasEnunciadoUsuarioTres[$k]);
                    }
                }


                for($l=0; $l<$nroElementosArraySignosEnunciadoUsuarioTres; $l++){
                    if(!in_array($arraySignosEnunciadoUsuarioTres[$l], $arraySignosEnunciadoCorrectoTres)){
                        array_push($resultadoEnunciadoSignosIncorrectosUsuarioTres, $arraySignosEnunciadoUsuarioTres[$l]);
                    }
                }


                for($u=0; $u<$nroElementosArrayPalabrasEnunciadoCorrectoTres; $u++){
                    if(!in_array($arrayPalabrasEnunciadoCorrectoTres[$u], $arrayPalabrasEnunciadoUsuarioTres)){
                        array_push($resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioTres, $arrayPalabrasEnunciadoCorrectoTres[$u]);
                    }
                }

                for($g=0; $g<$nroElementosArraySignosEnunciadoCorrectoTres; $g++){
                    if(!in_array($arraySignosEnunciadoCorrectoTres[$g], $arraySignosEnunciadoUsuarioTres)){
                        array_push($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioTres, $arraySignosEnunciadoCorrectoTres[$g]);
                    }
                }

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOENUNCIADOSECCIONESQUELEFALTARONALUSUARIOTRES ORIGINAL
                //for($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoTres; $y++){
                //    if(!in_array($arraySeccionesEnunciadoCorrectoTres[$y], $arraySeccionesEnunciadoUsuarioTres)){
                //        array_push($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioTres, $arraySeccionesEnunciadoCorrectoTres[$y]);
                //    }
                //}

                //////////////////////////////////////// METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO FINAL

                $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoTres = 0;
                $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoTres = 0;
                for($u=0; $u<$nroElementosArraySeccionesEnunciadoCorrectoTres; $u++){

                    
                    for ($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoTres; $y++){
                        $compararenunciadotres = strcmp($arraySeccionesEnunciadoCorrectoTres[$u], $arraySeccionesEnunciadoCorrectoTres[$y]);
                        if ($compararenunciadotres === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoTres++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesEnunciadoUsuarioTres); $z++){
                        $compararenunciadotresusuario = strcmp($arraySeccionesEnunciadoCorrectoTres[$u], $arraySeccionesEnunciadoUsuarioTres[$z]);
                        if($compararenunciadotresusuario === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoTres++;
                        }
                    }

                    if(($contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoTres > $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoTres)){
                        if (!in_array($arraySeccionesEnunciadoCorrectoTres[$u], $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioTres)){
                            array_push($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioTres, $arraySeccionesEnunciadoCorrectoTres[$u]);
                        }
                        
                    }
                    $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoTres = 0;
                    $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoTres = 0;
                }

                ///////////////////////////////////////// FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO




                //ACTUALIZACION
                //EN EL ARRAY COMENTADO SE AGREGARAN LAS SECCIONES DE ORACION UNO DEL USUARIO QUE NO COINCIDAN CON LAS SECCIONES DE LA ORACION CORRECTA UNO
                // $resultadoSeccionesIncorrectasEnunciadoUsuarioUno = [];
                //PARA LA COMPARACION, CON UN FOR SE RECORRE EL ARRAYSECCIONESORACIONUSUARIOUNO Y SE PREGUNTA SI LA SECCION [I] DE ESE ARRAY NO COINCIDE CON ALGUNA DE LAS SECCIONES DE LA ORACION CORRECTA
                //Y LAS SECCIONES DEL ARRAYSECCIONESORACIONUSUARIOUNO QUE NO COINCIDAN CON ALGUNA SECCION DEL ARRAYSECCIONESORACIONCORRECTAUNO, SE GUARDAN EN EL ARRAY
                //RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO PARA ENVIARLAS A LA VISTA

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOTRES ORIGINAL
                //for($p=0; $p<$nroElementosArraySeccionesEnunciadoUsuarioTres; $p++){
                //
                //    if(!in_array($arraySeccionesEnunciadoUsuarioTres[$p], $arraySeccionesEnunciadoCorrectoTres)){
                //        array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioTres, $arraySeccionesEnunciadoUsuarioTres[$p]);
                //    }
                //}


                //return $resultadoSeccionesIncorrectasEnunciadoUsuarioTres;


                //////////////////////////////////////METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL

                //CAPTURAR LAS PALABRAS QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA Y AGREGARLAS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS
                for($b=0; $b<$nroElementosArraySeccionesEnunciadoUsuarioTres; $b++){
                    if(!in_array($arraySeccionesEnunciadoUsuarioTres[$b], $arraySeccionesEnunciadoCorrectoTres)){
                        array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioTres, $arraySeccionesEnunciadoUsuarioTres[$b]);
                    }
                }

                //AGREGAR AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS LAS PALABRAS QUE SI FORMAN PARTE DEL TEXTO CORRECTO, PERO QUE ESTAN AGREGADAS EN DEMASIA
                //ES DECIR, EN EL TEXTO CORRECTO HAY 2 "HOLA" PERO EN LA RESPUESTA DEL USUARIO HAY 3 "HOLA", POR LO TANTO ES UNA PALABRA INCORRECTA.
                //ESTE METODO ESTÁ BASADO EN EL METODO PARA AGREGAR ELEMENTOS AL ARRAY $resultadoSeccionesQueLeFaltaronParrafoUsuario
                //LA DIFERENCIA ES QUE EN LA SECCION FINAL DE ESTE METODO SE CAMBIO EL METODO DE MAYOR QUE A MENOR QUE  

                $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoTres = 0;
                $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoTres = 0;
                for($u=0; $u<$nroElementosArraySeccionesEnunciadoCorrectoTres; $u++){

                    for ($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoTres; $y++){
                        $compararenunciadotres = strcmp($arraySeccionesEnunciadoCorrectoTres[$u], $arraySeccionesEnunciadoCorrectoTres[$y]);
                        if ($compararenunciadotres === 0){
                            $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoTres++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesEnunciadoUsuarioTres); $z++){
                        $compararenunciadotresusuario = strcmp($arraySeccionesEnunciadoCorrectoTres[$u], $arraySeccionesEnunciadoUsuarioTres[$z]);
                        if($compararenunciadotresusuario === 0){
                            $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoTres++;
                        }
                    }

                    if(($contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoTres < $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoTres)){
                        if (!in_array($arraySeccionesEnunciadoCorrectoTres[$u], $resultadoSeccionesIncorrectasEnunciadoUsuarioTres)){
                            array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioTres, $arraySeccionesEnunciadoCorrectoTres[$u]);
                        }
                        
                    }
                    $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoTres = 0;
                    $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoTres = 0;

                } 


                ///////////////////////////////////////FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL



                //ACTUALIZACION
                //A TRAVES DEL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE PUEDE REEMPLAZAR CON "_" LOS ESPACIOS ADICIONALES QUE EL USUARIO HAYA AGREGADO 
                //A SU RESPUESTA, CUANDO LA RESPUESTA DEL USUARIO SEA ERRONEA. POR ESA RAZON EL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE ENVIA A LA VISTA
                //PARA MOSTRARLO CUANDO LAS ORACIONES NO COINCIDAN

                //PRIMERO SE RECORRE EL ARRAY Y CUANDO ENCUENTRE ESPACIOS VACIOS LOS VA A IR REEMPLAZANDO POR "_"
                for($b=0; $b<count($arraySeccionesEnunciadoUsuarioTres); $b++){
                    if($arraySeccionesEnunciadoUsuarioTres[$b] === ""){
                        $arraySeccionesEnunciadoUsuarioTres[$b] = "_";
                    }
                }

                //LUEGO CON EL IMPLDE SE UNE EL ARRAY DE NUEVO PARA ENVIARLO A LA VISTA
                $stringSeccionesEnunciadoUsuarioTres = implode(" ", $arraySeccionesEnunciadoUsuarioTres);
                //A LA VISTA TAMBIEN SEE VA A ENVIAR UNA VARIABLE TIPO BOOLEAN QUE ENVIA FALSE SI NO HAY "_" EN EL 
                //ARRAYSECCIONESENUNCIADOUSUARIOUNO Y DEVUELVE TRUE SI ESQUE SI HAY "_" EN EL ARRAY
                //ESTO SE ENVIA A LA VISTA PARA QUE EN BASE A LO QUE DEVUELVA, APAREZCA EL MENSAJE DE QUE HAY ESPACIOS ADICIONALES
                //EN LA RESPUESTA DEL USUARIO O NO HAY ESPACIOS ADICIONALES EN LA RESPUESTA DEL USUARIO
                $existenEspaciosEnunciadoTres = false;
                if(in_array("_", $arraySeccionesEnunciadoUsuarioTres)){
                    $existenEspaciosEnunciadoTres = true;
                }

                //return $stringSeccionesEnunciadoUsuarioTres;


                //ACTUALIZACION
                //ANTES DE ENVIAR EL ARRYA RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO
                //SE AGREGA ARRAY_UNIQUE Y SE REEMPLAZA LOS ESPACIOS VACIOS "" POR LA PALABRA "ESPACIOS VACIOS"
                //EN ARRAY_UNIQUE SE REALIZA EN LA VISTA, REVISAR EN LA SECCION DONDE SE RECORRE EL ARRAY RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO
                //EN LA VISTA

                for($u=0; $u<count($resultadoSeccionesIncorrectasEnunciadoUsuarioTres); $u++){
                    if($resultadoSeccionesIncorrectasEnunciadoUsuarioTres[$u] === ""){
                        $resultadoSeccionesIncorrectasEnunciadoUsuarioTres[$u] = "Espacios en blanco.";
                    }
                }


                //return $resultadoSeccionesIncorrectasEnunciadoUsuarioTres;


                if($nroElementosArrayCaracteresEnunciadoCorrectoTres === $nroElementosArrayCaracteresEnunciadoUsuarioTres){
                    $respuestaEnunciadoTres = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresEnunciadoCorrectoTres < $nroElementosArrayCaracteresEnunciadoUsuarioTres){
                    //$respuestaEnunciadoTres = "Su respuesta es incorrecta. Puede contener letras, signos ortográficos incorrectos o más de un espacio entre palabras.";
                    $respuestaEnunciadoTres = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresEnunciadoCorrectoTres > $nroElementosArrayCaracteresEnunciadoUsuarioTres){
                    //$respuestaEnunciadoTres = "Su respuesta es incorrecta. Ha omitido algunos elementos en su respuesta.";
                    $respuestaEnunciadoTres = "Su respuesta es incorrecta.";
                }
                else{
                    //$respuestaEnunciadoTres = "Su respuesta es incorrecta. Tiene algunos errores que se detallan abajo.";
                    $respuestaEnunciadoTres = "Su respuesta es incorrecta.";
                }


                //ACTUALIZACION
                //SE VERIFICA SI EN EL ARRAY $resultadoSeccionesIncorrectasEnunciadoUsuarioUno TODOS LOS ELEMENTOS SON "Espacios en blanco."
                //SI ES ASI, EN LA VARIABLE $hayUnEspacioEnBlancoEnunciadoUno SE ENVIA TRUE, CASO CONTRARIO SE ENVIA FALSE
               
                $hayUnEspacioEnBlancoEnunciadoTres = false;

                //SE RECORRE EL ARRAY DE LAS SECCIONES INCORRECTAS Y SE COMPARA SI TODOS LOS ELEMENTOS SON ESPACIOS EN BLANCO
                $contadorEspaciosTres = 0;
                for($f=0; $f< count($resultadoSeccionesIncorrectasEnunciadoUsuarioTres); $f++){
                    if($resultadoSeccionesIncorrectasEnunciadoUsuarioTres[$f] === "Espacios en blanco."){
                        $contadorEspaciosTres++;
                    }
                }
                if($contadorEspaciosTres === count($resultadoSeccionesIncorrectasEnunciadoUsuarioTres)){
                    $hayUnEspacioEnBlancoEnunciadoTres = true;
                }

                //return $hayUnEspacioEnBlancoEnunciadoTres;

                //CON EL IN ARRAY SE COMPRUEBA SI HAY ESPACIOS EN BLANCO EN EL ARRAY DE SECCIONESINCORRECTAS
                //ESTO SIRVE PARA MOSTRAR UN MENSAJE EN LA VISTA DE QUE EL USUARIO TIENE ESPACIOS EN BLANCO
                //Y ADEMAS OTROS ELEMENTOS INCORRECTOS
                $mensajeEspacioBlancoTres = false;
                if(in_array("Espacios en blanco.", $resultadoSeccionesIncorrectasEnunciadoUsuarioTres)){
                    $mensajeEspacioBlancoTres = true;
                }

                //return $mensajeEspacioBlancoTres;


            }


            //COMPROBACION ENUNCIADO CUATRO

            $caracteresEnunciadoCorrectosCuatro = [];
            $caracteresEnunciadoIncorrectosCuatro = [];
            $palabrasEnunciadoCorrectasCuatro = [];
            $palabrasEnunciadoIncorrectasCuatro = [];
            $seccionesEnunciadoCorrectasCuatro = [];
            $seccionesEnunciadoIncorrectasCuatro = [];

            $resultadoEnunciadoPalabrasIncorrectasUsuarioCuatro = [];
            $resultadoEnunciadoSignosIncorrectosUsuarioCuatro = [];
            $resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioCuatro = [];
            $resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCuatro = [];
            $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCuatro = [];
            //ACTUALIZACION SE AGREGA ESTE ARRAY PARA PODER PINTAR EN LA VISTA LAS SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS
            $resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro = [];

            $compararEnunciadoCuatro = strcmp($enunciadoCorrectoCuatro, $enunciadoUsuarioCuatro);

            if($compararEnunciadoCuatro === 0){

                //SI ES IGUAL A CERO, LA ORACION DEL USUARIO ES CORRECTA
                $respuestaEnunciadoCuatro = "Su respuesta al cuarto enunciado es correcta.";

                $resultadoEnunciadoPalabrasIncorrectasUsuarioCuatro = [];
                $resultadoEnunciadoSignosIncorrectosUsuarioCuatro = [];
                $resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioCuatro = [];
                $resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCuatro = [];
                $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCuatro = [];
                //ACTUALIZACION SE AGREGA ESTE NUEVO ARRAY
                $resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro = [];
                //ACTUALIZACION SE AGREGA ESTE CAMPO QUE CONTIENE LA RESPUESTA DEL USUARIO
                $stringSeccionesEnunciadoUsuarioCuatro = $enunciadoUsuarioCuatro;
                //ACTUALIZACION, SE ENVIA ESTE CAMPO PARA VER SI HAY ESPACIOS O NO EN LA RESPUESTA
                //COMO EN ESTE CASO NO HAY ESPACIOS ADICIONALES PORQUE LA RESPUESTA ES CORRECTA, SE ENVIA FALSE
                $existenEspaciosEnunciadoCuatro = false;
                //ACTUALIZACION, SI EL TEXTO ES CORRECTO LA VARIABLE hayUnEspacioEnBlancoEnunciadoDos SE ENVIA FALSE
                $hayUnEspacioEnBlancoEnunciadoCuatro = false;
                //ACTUALIZACION, LA VARIABLE PARA MOSTRAR EL MENSAJE ES FALSA SI LA RESPUESTA ES CORRECTA
                $mensajeEspacioBlancoCuatro = false;

            }else{

                $nroCaracteresEnunciadoUsuarioCuatro = mb_strlen($enunciadoUsuarioCuatro, 'UTF-8');
                $nroCaracteresEnunciadoCorrectoCuatro = mb_strlen($enunciadoCorrectoCuatro, 'UTF-8');

                $arrayCaracteresEnunciadoUsuarioCuatro = mb_str_split($enunciadoUsuarioCuatro);
                $arrayCaracteresEnunciadoCorrectoCuatro = mb_str_split($enunciadoCorrectoCuatro);

                $arraySeccionesEnunciadoCorrectoCuatro = explode(' ', $enunciadoCorrectoCuatro);
                $arraySeccionesEnunciadoUsuarioCuatro = explode(' ', $enunciadoUsuarioCuatro);

                $aPalabrasEnunciadoCorrectoCuatro = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $enunciadoCorrectoCuatro);
                $arrayPalabrasEnunciadoCorrectoCuatro = explode(' ', $aPalabrasEnunciadoCorrectoCuatro);
                $aPalabrasEnunciadoUsuarioCuatro = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $enunciadoUsuarioCuatro);
                $arrayPalabrasEnunciadoUsuarioCuatro = explode(' ', $aPalabrasEnunciadoUsuarioCuatro);

                $nroElementosArrayCaracteresEnunciadoUsuarioCuatro = count($arrayCaracteresEnunciadoUsuarioCuatro);
                $nroElementosArrayCaracteresEnunciadoCorrectoCuatro = count($arrayCaracteresEnunciadoCorrectoCuatro);
                $arraySignosEnunciadoCorrectoCuatro = [];
                $arraySignosEnunciadoUsuarioCuatro = [];


                for($c=0; $c<$nroElementosArrayCaracteresEnunciadoUsuarioCuatro; $c++){
                    if((strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], ',') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], ':') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], ';') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '-') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '+') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '/') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '.') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '...') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '....') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '&') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '!') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '¡') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '?') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '¿') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '"') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], ')') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '(') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '..') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '*') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], "'") === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '[') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], ']') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '{') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '}') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '_') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '^') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '#') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '<') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '>') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCuatro[$c], '|') === 0)){

                        array_push($arraySignosEnunciadoUsuarioCuatro, $arrayCaracteresEnunciadoUsuarioCuatro[$c]);
                    }
                }



                for($n=0; $n<$nroElementosArrayCaracteresEnunciadoCorrectoCuatro; $n++){
                    if((strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], ',') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], ':') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], ';') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '-') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '+') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '/') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '.') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '...') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '....') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '&') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '!') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '¡') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '?') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '¿') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '"') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], ')') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '(') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '..') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '*') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], "'") === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '[') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], ']') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '{') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '}') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '_') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '^') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '#') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '<') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '>') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCuatro[$n], '|') === 0)){

                        array_push($arraySignosEnunciadoCorrectoCuatro, $arrayCaracteresEnunciadoCorrectoCuatro[$n]);
                    }
                }


                $nroElementosArrayPalabrasEnunciadoUsuarioCuatro = count($arrayPalabrasEnunciadoUsuarioCuatro);
                $nroElementosArrayPalabrasEnunciadoCorrectoCuatro = count($arrayPalabrasEnunciadoCorrectoCuatro);
                $nroElementosArraySignosEnunciadoUsuarioCuatro = count($arraySignosEnunciadoUsuarioCuatro);
                $nroElementosArraySignosEnunciadoCorrectoCuatro = count($arraySignosEnunciadoCorrectoCuatro);
                $nroElementosArraySeccionesEnunciadoUsuarioCuatro = count($arraySeccionesEnunciadoUsuarioCuatro); 
                $nroElementosArraySeccionesEnunciadoCorrectoCuatro = count($arraySeccionesEnunciadoCorrectoCuatro);


                for($k=0; $k<$nroElementosArrayPalabrasEnunciadoUsuarioCuatro; $k++){
                    if(!in_array($arrayPalabrasEnunciadoUsuarioCuatro[$k], $arrayPalabrasEnunciadoCorrectoCuatro)){
                        array_push($resultadoEnunciadoPalabrasIncorrectasUsuarioCuatro, $arrayPalabrasEnunciadoUsuarioCuatro[$k]);
                    }
                }


                for($l=0; $l<$nroElementosArraySignosEnunciadoUsuarioCuatro; $l++){
                    if(!in_array($arraySignosEnunciadoUsuarioCuatro[$l], $arraySignosEnunciadoCorrectoCuatro)){
                        array_push($resultadoEnunciadoSignosIncorrectosUsuarioCuatro, $arraySignosEnunciadoUsuarioCuatro[$l]);
                    }
                }


                for($u=0; $u<$nroElementosArrayPalabrasEnunciadoCorrectoCuatro; $u++){
                    if(!in_array($arrayPalabrasEnunciadoCorrectoCuatro[$u], $arrayPalabrasEnunciadoUsuarioCuatro)){
                        array_push($resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioCuatro, $arrayPalabrasEnunciadoCorrectoCuatro[$u]);
                    }
                }

                for($g=0; $g<$nroElementosArraySignosEnunciadoCorrectoCuatro; $g++){
                    if(!in_array($arraySignosEnunciadoCorrectoCuatro[$g], $arraySignosEnunciadoUsuarioCuatro)){
                        array_push($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCuatro, $arraySignosEnunciadoCorrectoCuatro[$g]);
                    }
                }


                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOENUNCIADOSECCIONESQUELEFALTARONALUSUARIOCUATRO
                //for($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoCuatro; $y++){
                //    if(!in_array($arraySeccionesEnunciadoCorrectoCuatro[$y], $arraySeccionesEnunciadoUsuarioCuatro)){
                //        array_push($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCuatro, $arraySeccionesEnunciadoCorrectoCuatro[$y]);
                //    }
                //}

                //////////////////////////////////////// METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO FINAL

                $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoCuatro = 0;
                $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoCuatro = 0;
                for($u=0; $u<$nroElementosArraySeccionesEnunciadoCorrectoCuatro; $u++){

                    
                    for ($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoCuatro; $y++){
                        $compararenunciadocuatro = strcmp($arraySeccionesEnunciadoCorrectoCuatro[$u], $arraySeccionesEnunciadoCorrectoCuatro[$y]);
                        if ($compararenunciadocuatro === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoCuatro++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesEnunciadoUsuarioCuatro); $z++){
                        $compararenunciadocuatrousuario = strcmp($arraySeccionesEnunciadoCorrectoCuatro[$u], $arraySeccionesEnunciadoUsuarioCuatro[$z]);
                        if($compararenunciadocuatrousuario === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoCuatro++;
                        }
                    }

                    if(($contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoCuatro > $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoCuatro)){
                        if (!in_array($arraySeccionesEnunciadoCorrectoCuatro[$u], $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCuatro)){
                            array_push($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCuatro, $arraySeccionesEnunciadoCorrectoCuatro[$u]);
                        }
                        
                    }
                    $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoCuatro = 0;
                    $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoCuatro = 0;
                }

                ///////////////////////////////////////// FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO



                //ACTUALIZACION
                //EN EL ARRAY COMENTADO SE AGREGARAN LAS SECCIONES DE ORACION UNO DEL USUARIO QUE NO COINCIDAN CON LAS SECCIONES DE LA ORACION CORRECTA UNO
                // $resultadoSeccionesIncorrectasEnunciadoUsuarioUno = [];
                //PARA LA COMPARACION, CON UN FOR SE RECORRE EL ARRAYSECCIONESORACIONUSUARIOUNO Y SE PREGUNTA SI LA SECCION [I] DE ESE ARRAY NO COINCIDE CON ALGUNA DE LAS SECCIONES DE LA ORACION CORRECTA
                //Y LAS SECCIONES DEL ARRAYSECCIONESORACIONUSUARIOUNO QUE NO COINCIDAN CON ALGUNA SECCION DEL ARRAYSECCIONESORACIONCORRECTAUNO, SE GUARDAN EN EL ARRAY
                //RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO PARA ENVIARLAS A LA VISTA

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOCUATRO
                //for($p=0; $p<$nroElementosArraySeccionesEnunciadoUsuarioCuatro; $p++){
                //
                //    if(!in_array($arraySeccionesEnunciadoUsuarioCuatro[$p], $arraySeccionesEnunciadoCorrectoCuatro)){
                //        array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro, $arraySeccionesEnunciadoUsuarioCuatro[$p]);
                //    }
                //}


                //return $resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro;


                //////////////////////////////////////METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL

                //CAPTURAR LAS PALABRAS QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA Y AGREGARLAS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS
                for($b=0; $b<$nroElementosArraySeccionesEnunciadoUsuarioCuatro; $b++){
                    if(!in_array($arraySeccionesEnunciadoUsuarioCuatro[$b], $arraySeccionesEnunciadoCorrectoCuatro)){
                        array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro, $arraySeccionesEnunciadoUsuarioCuatro[$b]);
                    }
                }

                //AGREGAR AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS LAS PALABRAS QUE SI FORMAN PARTE DEL TEXTO CORRECTO, PERO QUE ESTAN AGREGADAS EN DEMASIA
                //ES DECIR, EN EL TEXTO CORRECTO HAY 2 "HOLA" PERO EN LA RESPUESTA DEL USUARIO HAY 3 "HOLA", POR LO TANTO ES UNA PALABRA INCORRECTA.
                //ESTE METODO ESTÁ BASADO EN EL METODO PARA AGREGAR ELEMENTOS AL ARRAY $resultadoSeccionesQueLeFaltaronParrafoUsuario
                //LA DIFERENCIA ES QUE EN LA SECCION FINAL DE ESTE METODO SE CAMBIO EL METODO DE MAYOR QUE A MENOR QUE  

                $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoCuatro = 0;
                $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoCuatro = 0;
                for($u=0; $u<$nroElementosArraySeccionesEnunciadoCorrectoCuatro; $u++){

                    for ($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoCuatro; $y++){
                        $compararenunciadocuatro = strcmp($arraySeccionesEnunciadoCorrectoCuatro[$u], $arraySeccionesEnunciadoCorrectoCuatro[$y]);
                        if ($compararenunciadocuatro === 0){
                            $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoCuatro++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesEnunciadoUsuarioCuatro); $z++){
                        $compararenunciadocuatrousuario = strcmp($arraySeccionesEnunciadoCorrectoCuatro[$u], $arraySeccionesEnunciadoUsuarioCuatro[$z]);
                        if($compararenunciadocuatrousuario === 0){
                            $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoCuatro++;
                        }
                    }

                    if(($contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoCuatro < $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoCuatro)){
                        if (!in_array($arraySeccionesEnunciadoCorrectoCuatro[$u], $resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro)){
                            array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro, $arraySeccionesEnunciadoCorrectoCuatro[$u]);
                        }
                        
                    }
                    $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoCuatro = 0;
                    $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoCuatro = 0;

                } 


                ///////////////////////////////////////FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL



                //ACTUALIZACION
                //A TRAVES DEL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE PUEDE REEMPLAZAR CON "_" LOS ESPACIOS ADICIONALES QUE EL USUARIO HAYA AGREGADO 
                //A SU RESPUESTA, CUANDO LA RESPUESTA DEL USUARIO SEA ERRONEA. POR ESA RAZON EL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE ENVIA A LA VISTA
                //PARA MOSTRARLO CUANDO LAS ORACIONES NO COINCIDAN

                //PRIMERO SE RECORRE EL ARRAY Y CUANDO ENCUENTRE ESPACIOS VACIOS LOS VA A IR REEMPLAZANDO POR "_"
                for($b=0; $b<count($arraySeccionesEnunciadoUsuarioCuatro); $b++){
                    if($arraySeccionesEnunciadoUsuarioCuatro[$b] === ""){
                        $arraySeccionesEnunciadoUsuarioCuatro[$b] = "_";
                    }
                }

                //LUEGO CON EL IMPLDE SE UNE EL ARRAY DE NUEVO PARA ENVIARLO A LA VISTA
                $stringSeccionesEnunciadoUsuarioCuatro = implode(" ", $arraySeccionesEnunciadoUsuarioCuatro);
                //A LA VISTA TAMBIEN SEE VA A ENVIAR UNA VARIABLE TIPO BOOLEAN QUE ENVIA FALSE SI NO HAY "_" EN EL 
                //ARRAYSECCIONESENUNCIADOUSUARIOUNO Y DEVUELVE TRUE SI ESQUE SI HAY "_" EN EL ARRAY
                //ESTO SE ENVIA A LA VISTA PARA QUE EN BASE A LO QUE DEVUELVA, APAREZCA EL MENSAJE DE QUE HAY ESPACIOS ADICIONALES
                //EN LA RESPUESTA DEL USUARIO O NO HAY ESPACIOS ADICIONALES EN LA RESPUESTA DEL USUARIO
                $existenEspaciosEnunciadoCuatro = false;
                if(in_array("_", $arraySeccionesEnunciadoUsuarioCuatro)){
                    $existenEspaciosEnunciadoCuatro = true;
                }

                //return $existenEspaciosEnunciadoCuatro;


                //ACTUALIZACION
                //ANTES DE ENVIAR EL ARRYA RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO
                //SE AGREGA ARRAY_UNIQUE Y SE REEMPLAZA LOS ESPACIOS VACIOS "" POR LA PALABRA "ESPACIOS VACIOS"
                //EN ARRAY_UNIQUE SE REALIZA EN LA VISTA, REVISAR EN LA SECCION DONDE SE RECORRE EL ARRAY RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO
                //EN LA VISTA

                for($u=0; $u<count($resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro); $u++){
                    if($resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro[$u] === ""){
                        $resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro[$u] = "Espacios en blanco.";
                    }
                }


                //return $resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro;


                if($nroElementosArrayCaracteresEnunciadoCorrectoCuatro === $nroElementosArrayCaracteresEnunciadoUsuarioCuatro){
                    $respuestaEnunciadoCuatro = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresEnunciadoCorrectoCuatro < $nroElementosArrayCaracteresEnunciadoUsuarioCuatro){
                    //$respuestaEnunciadoCuatro = "Su respuesta es incorrecta. Puede contener letras, signos ortográficos incorrectos o más de un espacio entre palabras.";
                    $respuestaEnunciadoCuatro = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresEnunciadoCorrectoCuatro > $nroElementosArrayCaracteresEnunciadoUsuarioCuatro){
                    //$respuestaEnunciadoCuatro = "Su respuesta es incorrecta. Ha omitido algunos elementos en su respuesta.";
                    $respuestaEnunciadoCuatro = "Su respuesta es incorrecta.";
                }
                else{
                    //$respuestaEnunciadoCuatro = "Su respuesta es incorrecta. Tiene algunos errores que se detallan abajo.";
                    $respuestaEnunciadoCuatro = "Su respuesta es incorrecta."; 
                }


                //ACTUALIZACION
                //SE VERIFICA SI EN EL ARRAY $resultadoSeccionesIncorrectasEnunciadoUsuarioUno TODOS LOS ELEMENTOS SON "Espacios en blanco."
                //SI ES ASI, EN LA VARIABLE $hayUnEspacioEnBlancoEnunciadoUno SE ENVIA TRUE, CASO CONTRARIO SE ENVIA FALSE
               

                $hayUnEspacioEnBlancoEnunciadoCuatro = false;
                
                //SE RECORRE EL ARRAY DE LAS SECCIONES INCORRECTAS Y SE COMPARA SI TODOS LOS ELEMENTOS SON ESPACIOS EN BLANCO
                $contadorEspaciosCuatro = 0;
                for($f=0; $f< count($resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro); $f++){
                    if($resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro[$f] === "Espacios en blanco."){
                        $contadorEspaciosCuatro++;
                    }
                }
                if($contadorEspaciosCuatro === count($resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro)){
                    $hayUnEspacioEnBlancoEnunciadoCuatro = true;
                }

                //CON EL IN ARRAY SE COMPRUEBA SI HAY ESPACIOS EN BLANCO EN EL ARRAY DE SECCIONESINCORRECTAS
                //ESTO SIRVE PARA MOSTRAR UN MENSAJE EN LA VISTA DE QUE EL USUARIO TIENE ESPACIOS EN BLANCO
                //Y ADEMAS OTROS ELEMENTOS INCORRECTOS
                $mensajeEspacioBlancoCuatro = false;
                if(in_array("Espacios en blanco.", $resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro)){
                    $mensajeEspacioBlancoCuatro = true;
                }

                //return $mensajeEspacioBlancoCuatro;




            }


            //COMPROBACION ENUNCIADO CINCO

            $caracteresEnunciadoCorrectosCinco = [];
            $caracteresEnunciadoIncorrectosCinco = [];
            $palabrasEnunciadoCorrectasCinco = [];
            $palabrasEnunciadoIncorrectasCinco = [];
            $seccionesEnunciadoCorrectasCinco = [];
            $seccionesEnunciadoIncorrectasCinco = [];

            $resultadoEnunciadoPalabrasIncorrectasUsuarioCinco = [];
            $resultadoEnunciadoSignosIncorrectosUsuarioCinco = [];
            $resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioCinco = [];
            $resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCinco = [];
            $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCinco = [];
            //ACTUALIZACION SE AGREGA ESTE ARRAY PARA PODER PINTAR EN LA VISTA LAS SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS
            $resultadoSeccionesIncorrectasEnunciadoUsuarioCinco = [];

            $compararEnunciadoCinco = strcmp($enunciadoCorrectoCinco, $enunciadoUsuarioCinco);

            if($compararEnunciadoCinco === 0){

                //SI ES IGUAL A CERO, LA ORACION DEL USUARIO ES CORRECTA
                $respuestaEnunciadoCinco = "Su respuesta al quinto enunciado es correcta.";

                $resultadoEnunciadoPalabrasIncorrectasUsuarioCinco = [];
                $resultadoEnunciadoSignosIncorrectosUsuarioCinco = [];
                $resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioCinco = [];
                $resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCinco = [];
                $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCinco = [];
                //ACTUALIZACION SE AGREGA ESTE NUEVO ARRAY
                $resultadoSeccionesIncorrectasEnunciadoUsuarioCinco = [];
                //ACTUALIZACION SE AGREGA ESTE CAMPO QUE CONTIENE LA RESPUESTA DEL USUARIO
                $stringSeccionesEnunciadoUsuarioCinco = $enunciadoUsuarioCinco;
                //ACTUALIZACION, SE ENVIA ESTE CAMPO PARA VER SI HAY ESPACIOS O NO EN LA RESPUESTA
                //COMO EN ESTE CASO NO HAY ESPACIOS ADICIONALES PORQUE LA RESPUESTA ES CORRECTA, SE ENVIA FALSE
                $existenEspaciosEnunciadoCinco = false;
                //ACTUALIZACION, SI EL TEXTO ES CORRECTO LA VARIABLE hayUnEspacioEnBlancoEnunciadoDos SE ENVIA FALSE
                $hayUnEspacioEnBlancoEnunciadoCinco = false;
                //ACTUALIZACION, LA VARIABLE PARA MOSTRAR EL MENSAJE ES FALSA SI LA RESPUESTA ES CORRECTA
                $mensajeEspacioBlancoCinco = false;

            }else{

                $nroCaracteresEnunciadoUsuarioCinco = mb_strlen($enunciadoUsuarioCinco, 'UTF-8');
                $nroCaracteresEnunciadoCorrectoCinco = mb_strlen($enunciadoCorrectoCinco, 'UTF-8');

                $arrayCaracteresEnunciadoUsuarioCinco = mb_str_split($enunciadoUsuarioCinco);
                $arrayCaracteresEnunciadoCorrectoCinco = mb_str_split($enunciadoCorrectoCinco);

                $arraySeccionesEnunciadoCorrectoCinco = explode(' ', $enunciadoCorrectoCinco);
                $arraySeccionesEnunciadoUsuarioCinco = explode(' ', $enunciadoUsuarioCinco);

                $aPalabrasEnunciadoCorrectoCinco = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $enunciadoCorrectoCinco);
                $arrayPalabrasEnunciadoCorrectoCinco = explode(' ', $aPalabrasEnunciadoCorrectoCinco);
                $aPalabrasEnunciadoUsuarioCinco = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $enunciadoUsuarioCinco);
                $arrayPalabrasEnunciadoUsuarioCinco = explode(' ', $aPalabrasEnunciadoUsuarioCinco);

                $nroElementosArrayCaracteresEnunciadoUsuarioCinco = count($arrayCaracteresEnunciadoUsuarioCinco);
                $nroElementosArrayCaracteresEnunciadoCorrectoCinco = count($arrayCaracteresEnunciadoCorrectoCinco);
                $arraySignosEnunciadoCorrectoCinco = [];
                $arraySignosEnunciadoUsuarioCinco = [];


                for($c=0; $c<$nroElementosArrayCaracteresEnunciadoUsuarioCinco; $c++){
                    if((strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], ',') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], ':') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], ';') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '-') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '+') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '/') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '.') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '...') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '....') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '&') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '!') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '¡') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '?') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '¿') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '"') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], ')') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '(') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '..') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '*') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], "'") === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '[') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], ']') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '{') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '}') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '_') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '^') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '#') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '<') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '>') === 0) || (strcmp($arrayCaracteresEnunciadoUsuarioCinco[$c], '|') === 0)){

                        array_push($arraySignosEnunciadoUsuarioCinco, $arrayCaracteresEnunciadoUsuarioCinco[$c]);
                    }
                }


                for($n=0; $n<$nroElementosArrayCaracteresEnunciadoCorrectoCinco; $n++){
                    if((strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], ',') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], ':') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], ';') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '-') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '+') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '/') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '.') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '...') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '....') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '&') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '!') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '¡') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '?') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '¿') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '"') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], ')') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '(') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '..') === 0) || 
                        (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '*') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], "'") === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '[') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], ']') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '{') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '}') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '_') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '^') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '#') === 0) ||
                        (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '<') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '>') === 0) || (strcmp($arrayCaracteresEnunciadoCorrectoCinco[$n], '|') === 0)){

                        array_push($arraySignosEnunciadoCorrectoCinco, $arrayCaracteresEnunciadoCorrectoCinco[$n]);
                    }
                }


                $nroElementosArrayPalabrasEnunciadoUsuarioCinco = count($arrayPalabrasEnunciadoUsuarioCinco);
                $nroElementosArrayPalabrasEnunciadoCorrectoCinco = count($arrayPalabrasEnunciadoCorrectoCinco);
                $nroElementosArraySignosEnunciadoUsuarioCinco = count($arraySignosEnunciadoUsuarioCinco);
                $nroElementosArraySignosEnunciadoCorrectoCinco = count($arraySignosEnunciadoCorrectoCinco);
                $nroElementosArraySeccionesEnunciadoUsuarioCinco = count($arraySeccionesEnunciadoUsuarioCinco); 
                $nroElementosArraySeccionesEnunciadoCorrectoCinco = count($arraySeccionesEnunciadoCorrectoCinco);


                for($k=0; $k<$nroElementosArrayPalabrasEnunciadoUsuarioCinco; $k++){
                    if(!in_array($arrayPalabrasEnunciadoUsuarioCinco[$k], $arrayPalabrasEnunciadoCorrectoCinco)){
                        array_push($resultadoEnunciadoPalabrasIncorrectasUsuarioCinco, $arrayPalabrasEnunciadoUsuarioCinco[$k]);
                    }
                }


                for($l=0; $l<$nroElementosArraySignosEnunciadoUsuarioCinco; $l++){
                    if(!in_array($arraySignosEnunciadoUsuarioCinco[$l], $arraySignosEnunciadoCorrectoCinco)){
                        array_push($resultadoEnunciadoSignosIncorrectosUsuarioCinco, $arraySignosEnunciadoUsuarioCinco[$l]);
                    }
                }


                for($u=0; $u<$nroElementosArrayPalabrasEnunciadoCorrectoCinco; $u++){
                    if(!in_array($arrayPalabrasEnunciadoCorrectoCinco[$u], $arrayPalabrasEnunciadoUsuarioCinco)){
                        array_push($resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioCinco, $arrayPalabrasEnunciadoCorrectoCinco[$u]);
                    }
                }

                for($g=0; $g<$nroElementosArraySignosEnunciadoCorrectoCinco; $g++){
                    if(!in_array($arraySignosEnunciadoCorrectoCinco[$g], $arraySignosEnunciadoUsuarioCinco)){
                        array_push($resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCinco, $arraySignosEnunciadoCorrectoCinco[$g]);
                    }
                }

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOENUNCIADOSECCIONESQUELEFALTARONALUSUARIOCINCO ORIGINAL
                //for($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoCinco; $y++){
                //    if(!in_array($arraySeccionesEnunciadoCorrectoCinco[$y], $arraySeccionesEnunciadoUsuarioCinco)){
                //        array_push($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCinco, $arraySeccionesEnunciadoCorrectoCinco[$y]);
                //    }
                //}

                //////////////////////////////////////// METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO FINAL

                $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoCinco = 0;
                $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoCinco = 0;
                for($u=0; $u<$nroElementosArraySeccionesEnunciadoCorrectoCinco; $u++){

                    
                    for ($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoCinco; $y++){
                        $compararenunciadocinco = strcmp($arraySeccionesEnunciadoCorrectoCinco[$u], $arraySeccionesEnunciadoCorrectoCinco[$y]);
                        if ($compararenunciadocinco === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoCinco++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesEnunciadoUsuarioCinco); $z++){
                        $compararenunciadocincousuario = strcmp($arraySeccionesEnunciadoCorrectoCinco[$u], $arraySeccionesEnunciadoUsuarioCinco[$z]);
                        if($compararenunciadocincousuario === 0){
                            $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoCinco++;
                        }
                    }

                    if(($contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoCinco > $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoCinco)){
                        if (!in_array($arraySeccionesEnunciadoCorrectoCinco[$u], $resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCinco)){
                            array_push($resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCinco, $arraySeccionesEnunciadoCorrectoCinco[$u]);
                        }
                        
                    }
                    $contadorSeccionesQueLeFaltaronAlUsuarioUnoEnunciadoCinco = 0;
                    $contadorSeccionesQueLeFaltaronAlUsuarioDosEnunciadoCinco = 0;
                }

                ///////////////////////////////////////// FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONALUSUARIOUNO


                //ACTUALIZACION
                //EN EL ARRAY COMENTADO SE AGREGARAN LAS SECCIONES DE ORACION UNO DEL USUARIO QUE NO COINCIDAN CON LAS SECCIONES DE LA ORACION CORRECTA UNO
                // $resultadoSeccionesIncorrectasEnunciadoUsuarioUno = [];
                //PARA LA COMPARACION, CON UN FOR SE RECORRE EL ARRAYSECCIONESORACIONUSUARIOUNO Y SE PREGUNTA SI LA SECCION [I] DE ESE ARRAY NO COINCIDE CON ALGUNA DE LAS SECCIONES DE LA ORACION CORRECTA
                //Y LAS SECCIONES DEL ARRAYSECCIONESORACIONUSUARIOUNO QUE NO COINCIDAN CON ALGUNA SECCION DEL ARRAYSECCIONESORACIONCORRECTAUNO, SE GUARDAN EN EL ARRAY
                //RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO PARA ENVIARLAS A LA VISTA

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOCINCO ORIGINAL
                //for($p=0; $p<$nroElementosArraySeccionesEnunciadoUsuarioCinco; $p++){
                //
                //    if(!in_array($arraySeccionesEnunciadoUsuarioCinco[$p], $arraySeccionesEnunciadoCorrectoCinco)){
                //        array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioCinco, $arraySeccionesEnunciadoUsuarioCinco[$p]);
                //    }
                //}

                //////////////////////////////////////METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL

                //CAPTURAR LAS PALABRAS QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA Y AGREGARLAS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS
                for($b=0; $b<$nroElementosArraySeccionesEnunciadoUsuarioCinco; $b++){
                    if(!in_array($arraySeccionesEnunciadoUsuarioCinco[$b], $arraySeccionesEnunciadoCorrectoCinco)){
                        array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioCinco, $arraySeccionesEnunciadoUsuarioCinco[$b]);
                    }
                }

                //AGREGAR AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS LAS PALABRAS QUE SI FORMAN PARTE DEL TEXTO CORRECTO, PERO QUE ESTAN AGREGADAS EN DEMASIA
                //ES DECIR, EN EL TEXTO CORRECTO HAY 2 "HOLA" PERO EN LA RESPUESTA DEL USUARIO HAY 3 "HOLA", POR LO TANTO ES UNA PALABRA INCORRECTA.
                //ESTE METODO ESTÁ BASADO EN EL METODO PARA AGREGAR ELEMENTOS AL ARRAY $resultadoSeccionesQueLeFaltaronParrafoUsuario
                //LA DIFERENCIA ES QUE EN LA SECCION FINAL DE ESTE METODO SE CAMBIO EL METODO DE MAYOR QUE A MENOR QUE  

                $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoCinco = 0;
                $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoCinco = 0;
                for($u=0; $u<$nroElementosArraySeccionesEnunciadoCorrectoCinco; $u++){

                    for ($y=0; $y<$nroElementosArraySeccionesEnunciadoCorrectoCinco; $y++){
                        $compararenunciadocinco = strcmp($arraySeccionesEnunciadoCorrectoCinco[$u], $arraySeccionesEnunciadoCorrectoCinco[$y]);
                        if ($compararenunciadocinco === 0){
                            $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoCinco++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesEnunciadoUsuarioCinco); $z++){
                        $compararenunciadocincousuario = strcmp($arraySeccionesEnunciadoCorrectoCinco[$u], $arraySeccionesEnunciadoUsuarioCinco[$z]);
                        if($compararenunciadocincousuario === 0){
                            $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoCinco++;
                        }
                    }

                    if(($contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoCinco < $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoCinco)){
                        if (!in_array($arraySeccionesEnunciadoCorrectoCinco[$u], $resultadoSeccionesIncorrectasEnunciadoUsuarioCinco)){
                            array_push($resultadoSeccionesIncorrectasEnunciadoUsuarioCinco, $arraySeccionesEnunciadoCorrectoCinco[$u]);
                        }
                        
                    }
                    $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioUnoEnunciadoCinco = 0;
                    $contadorResultadoSeccionesIncorrectasEnunciadoUsuarioDosEnunciadoCinco = 0;

                } 


                ///////////////////////////////////////FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESINCORRECTASORACIONUSUARIOUNO FINAL



                //return $resultadoSeccionesIncorrectasEnunciadoUsuarioCinco;


                //ACTUALIZACION
                //A TRAVES DEL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE PUEDE REEMPLAZAR CON "_" LOS ESPACIOS ADICIONALES QUE EL USUARIO HAYA AGREGADO 
                //A SU RESPUESTA, CUANDO LA RESPUESTA DEL USUARIO SEA ERRONEA. POR ESA RAZON EL ARRAYSECCIONESENUNCIADOUSUARIOUNO SE ENVIA A LA VISTA
                //PARA MOSTRARLO CUANDO LAS ORACIONES NO COINCIDAN

                //PRIMERO SE RECORRE EL ARRAY Y CUANDO ENCUENTRE ESPACIOS VACIOS LOS VA A IR REEMPLAZANDO POR "_"
                for($b=0; $b<count($arraySeccionesEnunciadoUsuarioCinco); $b++){
                    if($arraySeccionesEnunciadoUsuarioCinco[$b] === ""){
                        $arraySeccionesEnunciadoUsuarioCinco[$b] = "_";
                    }
                }

                //LUEGO CON EL IMPLDE SE UNE EL ARRAY DE NUEVO PARA ENVIARLO A LA VISTA
                $stringSeccionesEnunciadoUsuarioCinco = implode(" ", $arraySeccionesEnunciadoUsuarioCinco);
                //A LA VISTA TAMBIEN SEE VA A ENVIAR UNA VARIABLE TIPO BOOLEAN QUE ENVIA FALSE SI NO HAY "_" EN EL 
                //ARRAYSECCIONESENUNCIADOUSUARIOUNO Y DEVUELVE TRUE SI ESQUE SI HAY "_" EN EL ARRAY
                //ESTO SE ENVIA A LA VISTA PARA QUE EN BASE A LO QUE DEVUELVA, APAREZCA EL MENSAJE DE QUE HAY ESPACIOS ADICIONALES
                //EN LA RESPUESTA DEL USUARIO O NO HAY ESPACIOS ADICIONALES EN LA RESPUESTA DEL USUARIO
                $existenEspaciosEnunciadoCinco = false;
                if(in_array("_", $arraySeccionesEnunciadoUsuarioCinco)){
                    $existenEspaciosEnunciadoCinco = true;
                }

                //return $stringSeccionesEnunciadoUsuarioCinco;



                //ACTUALIZACION
                //ANTES DE ENVIAR EL ARRYA RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO
                //SE AGREGA ARRAY_UNIQUE Y SE REEMPLAZA LOS ESPACIOS VACIOS "" POR LA PALABRA "ESPACIOS VACIOS"
                //EN ARRAY_UNIQUE SE REALIZA EN LA VISTA, REVISAR EN LA SECCION DONDE SE RECORRE EL ARRAY RESULTADOSECCIONESINCORRECTASENUNCIADOUSUARIOUNO
                //EN LA VISTA

                for($u=0; $u<count($resultadoSeccionesIncorrectasEnunciadoUsuarioCinco); $u++){
                    if($resultadoSeccionesIncorrectasEnunciadoUsuarioCinco[$u] === ""){
                        $resultadoSeccionesIncorrectasEnunciadoUsuarioCinco[$u] = "Espacios en blanco.";
                    }
                }


                //return $resultadoSeccionesIncorrectasEnunciadoUsuarioCinco;


                if($nroElementosArrayCaracteresEnunciadoCorrectoCinco === $nroElementosArrayCaracteresEnunciadoUsuarioCinco){
                    $respuestaEnunciadoCinco = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresEnunciadoCorrectoCinco < $nroElementosArrayCaracteresEnunciadoUsuarioCinco){
                    //$respuestaEnunciadoCinco = "Su respuesta es incorrecta. Puede contener letras, signos ortográficos incorrectos o más de un espacio entre palabras.";
                    $respuestaEnunciadoCinco = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresEnunciadoCorrectoCinco > $nroElementosArrayCaracteresEnunciadoUsuarioCinco){
                    //$respuestaEnunciadoCinco = "Su respuesta es incorrecta. Ha omitido algunos elementos en su respuesta.";
                    $respuestaEnunciadoCinco = "Su respuesta es incorrecta.";
                }
                else{
                    //$respuestaEnunciadoCinco = "Su respuesta es incorrecta. Tiene algunos errores que se detallan abajo.";
                    $respuestaEnunciadoCinco = "Su respuesta es incorrecta.";
                }

                //ACTUALIZACION
                //SE VERIFICA SI EN EL ARRAY $resultadoSeccionesIncorrectasEnunciadoUsuarioUno TODOS LOS ELEMENTOS SON "Espacios en blanco."
                //SI ES ASI, EN LA VARIABLE $hayUnEspacioEnBlancoEnunciadoUno SE ENVIA TRUE, CASO CONTRARIO SE ENVIA FALSE
               

                $hayUnEspacioEnBlancoEnunciadoCinco = false;
                
                //SE RECORRE EL ARRAY DE LAS SECCIONES INCORRECTAS Y SE COMPARA SI TODOS LOS ELEMENTOS SON ESPACIOS EN BLANCO
                $contadorEspaciosCinco = 0;
                for($f=0; $f< count($resultadoSeccionesIncorrectasEnunciadoUsuarioCinco); $f++){
                    if($resultadoSeccionesIncorrectasEnunciadoUsuarioCinco[$f] === "Espacios en blanco."){
                        $contadorEspaciosCinco++;
                    }
                }
                if($contadorEspaciosCinco === count($resultadoSeccionesIncorrectasEnunciadoUsuarioCinco)){
                    $hayUnEspacioEnBlancoEnunciadoCinco = true;
                }

                //CON EL IN ARRAY SE COMPRUEBA SI HAY ESPACIOS EN BLANCO EN EL ARRAY DE SECCIONESINCORRECTAS
                //ESTO SIRVE PARA MOSTRAR UN MENSAJE EN LA VISTA DE QUE EL USUARIO TIENE ESPACIOS EN BLANCO
                //Y ADEMAS OTROS ELEMENTOS INCORRECTOS
                $mensajeEspacioBlancoCinco = false;
                if(in_array("Espacios en blanco.", $resultadoSeccionesIncorrectasEnunciadoUsuarioCinco)){
                    $mensajeEspacioBlancoCinco = true;
                }

                //return $mensajeEspacioBlancoCinco;


            }

            //return $arraySignosEnunciadoCorrectoCinco;



            //ACTUALIZACION
            //PARA MOSTRAR LAS REGLAS ORTOGRAFICAS ASOCIADAS A LA PREGUNTA CLASIFICADAS POR PALABRAS, PUNTUACION Y ACENTUACION
            //SE DECLARA TRES VARIABLES QUE VAN A A ENVIAR TRUE SI HAY REGLAS ASOCIADAS DE PALABRAS, PUNTUACION O ACENTUACION
            //ESTO SIRVE PARA QUE EN LA VISTA DE MUESTREN LAS SECCIONES SOLO SI HAY REGLAS DE ESE TIPO ASOCIADAS
            
            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 1 CATEGORIES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasencategories = false;
            $hayacentuacionencategories = false;
            $haypuntuacionencategories = false;

            for($a=0; $a<count($questionType->categories); $a++){

                if($questionType->categories[$a]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionencategories = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 2 SECTIONS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasensections = false;
            $hayacentuacionensections = false;
            $haypuntuacionensections = false;

            for($b=0; $b<count($questionType->sections); $b++){

                if($questionType->sections[$b]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionensections = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 3 POSTS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenposts = false;
            $hayacentuacionenposts = false;
            $haypuntuacionenposts = false;

            for($c=0; $c<count($questionType->posts); $c++){

                if($questionType->posts[$c]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenposts = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 4 RULES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenrules = false;
            $hayacentuacionenrules = false;
            $haypuntuacionenrules = false;

            for($d=0; $d<count($questionType->rules); $d++){

                if($questionType->rules[$d]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenrules = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 5 NOTES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasennotes = false;
            $hayacentuacionennotes = false;
            $haypuntuacionennotes = false;

            for($e=0; $e<count($questionType->notes); $e++){

                if($questionType->notes[$e]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionennotes = true;
                }
            }






            //return view('rules.estudiante.displayresults.displayoi', compact('questionType', 'coleccionResults', 'sumaresultados', 'coleccionCorrectas', 'userId', 'evaluationId', 'oracionesAcertadas', 'oracionesIncorrectas'
            //            , 'respuestaEnunciadoUno', 'resultadoEnunciadoPalabrasIncorrectasUsuarioUno', 'resultadoEnunciadoSignosIncorrectosUsuarioUno', 'resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioUno', 'resultadoEnunciadoSignosQueLeFaltaronAlUsuarioUno'
            //            , 'resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioUno', 'enunciadoUsuarioUno', 'enunciadoCorrectoUno', 'resultadoSeccionesIncorrectasEnunciadoUsuarioUno', 'stringSeccionesEnunciadoUsuarioUno', 'existenEspaciosEnunciadoUno', 'resultadooiuno'
            //            , 'respuestaEnunciadoDos', 'resultadoEnunciadoPalabrasIncorrectasUsuarioDos', 'resultadoEnunciadoSignosIncorrectosUsuarioDos', 'resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioDos', 'resultadoEnunciadoSignosQueLeFaltaronAlUsuarioDos'
            //            , 'resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioDos', 'enunciadoUsuarioDos', 'enunciadoCorrectoDos', 'resultadoSeccionesIncorrectasEnunciadoUsuarioDos', 'stringSeccionesEnunciadoUsuarioDos', 'existenEspaciosEnunciadoDos', 'resultadooidos'
            //            , 'respuestaEnunciadoTres', 'resultadoEnunciadoPalabrasIncorrectasUsuarioTres', 'resultadoEnunciadoSignosIncorrectosUsuarioTres', 'resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioTres', 'resultadoEnunciadoSignosQueLeFaltaronAlUsuarioTres'
            //            , 'resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioTres', 'enunciadoUsuarioTres', 'enunciadoCorrectoTres', 'resultadoSeccionesIncorrectasEnunciadoUsuarioTres', 'stringSeccionesEnunciadoUsuarioTres', 'existenEspaciosEnunciadoTres', 'resultadooitres'
            //            , 'respuestaEnunciadoCuatro', 'resultadoEnunciadoPalabrasIncorrectasUsuarioCuatro', 'resultadoEnunciadoSignosIncorrectosUsuarioCuatro', 'resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioCuatro', 'resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCuatro'
            //            , 'resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCuatro', 'enunciadoUsuarioCuatro', 'enunciadoCorrectoCuatro', 'resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro', 'stringSeccionesEnunciadoUsuarioCuatro', 'existenEspaciosEnunciadoCuatro', 'resultadooicuatro'
            //            , 'respuestaEnunciadoCinco', 'resultadoEnunciadoPalabrasIncorrectasUsuarioCinco', 'resultadoEnunciadoSignosIncorrectosUsuarioCinco', 'resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioCinco', 'resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCinco'
            //            , 'resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCinco', 'enunciadoUsuarioCinco', 'enunciadoCorrectoCinco', 'resultadoSeccionesIncorrectasEnunciadoUsuarioCinco', 'stringSeccionesEnunciadoUsuarioCinco', 'existenEspaciosEnunciadoCinco', 'resultadooicinco'
            //    ));




            return view('rules.estudiante.displayresults.displayoi', compact('questionType', 'coleccionResults', 'sumaresultados', 'coleccionCorrectas', 'userId', 'evaluationId', 'oracionesAcertadas', 'oracionesIncorrectas'
                        , 'respuestaEnunciadoUno', 'resultadoEnunciadoPalabrasIncorrectasUsuarioUno', 'resultadoEnunciadoSignosIncorrectosUsuarioUno', 'resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioUno', 'resultadoEnunciadoSignosQueLeFaltaronAlUsuarioUno'
                        , 'resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioUno', 'enunciadoUsuarioUno', 'enunciadoCorrectoUno', 'resultadoSeccionesIncorrectasEnunciadoUsuarioUno', 'stringSeccionesEnunciadoUsuarioUno', 'existenEspaciosEnunciadoUno', 'resultadooiuno'
                        , 'respuestaEnunciadoDos', 'resultadoEnunciadoPalabrasIncorrectasUsuarioDos', 'resultadoEnunciadoSignosIncorrectosUsuarioDos', 'resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioDos', 'resultadoEnunciadoSignosQueLeFaltaronAlUsuarioDos'
                        , 'resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioDos', 'enunciadoUsuarioDos', 'enunciadoCorrectoDos', 'resultadoSeccionesIncorrectasEnunciadoUsuarioDos', 'stringSeccionesEnunciadoUsuarioDos', 'existenEspaciosEnunciadoDos', 'resultadooidos'
                        , 'respuestaEnunciadoTres', 'resultadoEnunciadoPalabrasIncorrectasUsuarioTres', 'resultadoEnunciadoSignosIncorrectosUsuarioTres', 'resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioTres', 'resultadoEnunciadoSignosQueLeFaltaronAlUsuarioTres'
                        , 'resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioTres', 'enunciadoUsuarioTres', 'enunciadoCorrectoTres', 'resultadoSeccionesIncorrectasEnunciadoUsuarioTres', 'stringSeccionesEnunciadoUsuarioTres', 'existenEspaciosEnunciadoTres', 'resultadooitres'
                        , 'respuestaEnunciadoCuatro', 'resultadoEnunciadoPalabrasIncorrectasUsuarioCuatro', 'resultadoEnunciadoSignosIncorrectosUsuarioCuatro', 'resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioCuatro', 'resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCuatro'
                        , 'resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCuatro', 'enunciadoUsuarioCuatro', 'enunciadoCorrectoCuatro', 'resultadoSeccionesIncorrectasEnunciadoUsuarioCuatro', 'stringSeccionesEnunciadoUsuarioCuatro', 'existenEspaciosEnunciadoCuatro', 'resultadooicuatro'
                        , 'respuestaEnunciadoCinco', 'resultadoEnunciadoPalabrasIncorrectasUsuarioCinco', 'resultadoEnunciadoSignosIncorrectosUsuarioCinco', 'resultadoEnunciadoPalabrasQueLeFaltaronAlUsuarioCinco', 'resultadoEnunciadoSignosQueLeFaltaronAlUsuarioCinco'
                        , 'resultadoEnunciadoSeccionesQueLeFaltaronAlUsuarioCinco', 'enunciadoUsuarioCinco', 'enunciadoCorrectoCinco', 'resultadoSeccionesIncorrectasEnunciadoUsuarioCinco', 'stringSeccionesEnunciadoUsuarioCinco', 'existenEspaciosEnunciadoCinco', 'resultadooicinco'
                        , 'haypalabrasencategories', 'hayacentuacionencategories', 'haypuntuacionencategories', 'haypalabrasensections', 'hayacentuacionensections', 'haypuntuacionensections'
                        , 'haypalabrasenposts', 'hayacentuacionenposts', 'haypuntuacionenposts', 'haypalabrasenrules', 'hayacentuacionenrules', 'haypuntuacionenrules'
                        , 'haypalabrasennotes', 'hayacentuacionennotes', 'haypuntuacionennotes'
                        , 'hayUnEspacioEnBlancoEnunciadoUno', 'hayUnEspacioEnBlancoEnunciadoDos', 'hayUnEspacioEnBlancoEnunciadoTres', 'hayUnEspacioEnBlancoEnunciadoCuatro', 'hayUnEspacioEnBlancoEnunciadoCinco'
                        , 'mensajeEspacioBlancoUno', 'mensajeEspacioBlancoDos', 'mensajeEspacioBlancoTres', 'mensajeEspacioBlancoCuatro', 'mensajeEspacioBlancoCinco'));

            /////////////////////////////////////////////////////////////////////////////////FIN CODIGO ANALISIS ORACION POR ORACION //////////////////////////////////////////////////

            //return view('rules.estudiante.displayresults.displayoi', compact('questionType', 'coleccionResults', 'sumaresultados', 'coleccionCorrectas', 'userId', 'evaluationId', 'oracionesAcertadas', 'oracionesIncorrectas'));
        } 
        elseif(($questionType->type) === "TA"){

            //CAPTURAR LA RESPUESTA DEL USUARIO A LA QUESTION TA MEDIANTE EL USER ID Y EVALUATION ID
            $answerUser = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->pluck('id')->toArray();
            //SACAR EL ID DE LA RESPUESTA DEL ARRAY
            $idCorrecta = reset($answerUser);
            //CAPTURAR EL REGISTRO DE RESPUESTA DEL USUARIO DE LA TABLA RESULTS
            $resultUser = Result::find($idCorrecta);
            //CAPTURAR EL TEXTO USUARIO
            $textoUsuario = $resultUser->answer_user;

            //CAPTURAR EL PUNTAJE QUE TIENE EL ESTUDIANTE EN LA PREGUNTA ACTUAL
            $resultados = DB::table('results')->where('question_id', $questionId)->where('user_id', $userId)->pluck('score')->toArray();
            $sumaresultados = array_sum($resultados);

            //CAPTURAR EL TEXTO CORRECTO DE LA TABLA ANSWERS
            $resCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->pluck('id')->toArray();
            $idAnswerCorrecta = reset($resCorrecta);
            //YA TENIENDO EL ID DE LA RESPUESTA CORRECTA, SE CAPTURA EL REGISTRO COMPLETO DE ANSWER
            $answerCorrecta = Answer::find($idAnswerCorrecta);
            //SE GUARDA EL TEXTO CORRECTO 
            $textoCorrecto = $answerCorrecta->answer;

            //SE COMPARA SI EL TEXTO CORRECTO ES IGUAL AL TEXTO DEL USUARIO PARA ENVIAR UNA RESPUESTA
            $respuesta = "";
            $comparacion = strcmp($textoCorrecto, $textoUsuario);
            if($comparacion == 0){
                $respuesta = "El texto que ha ingresado es correcto.";
            }
            else{
                $respuesta = "El texto que ha ingresado es incorrecto.";
            }


            //ACTUALIZACION
            //SE ENVIA A LA VISTA EL PUNTAJE DE CADA ITEM DEL USUARIO PARA EN FUNCION DE ESO MOSTRAR SOLO EL TEXTO DE RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL
            //PARA QUE EN LA VISTA EN FUNCION DE SI TIENE 0 DE PUNTAJE, ES DECIR, TIENE ERRORES, LE APAREZCA LA REVISION DEL TEXTO Y LA REVISION DE LA RESPUESTA CORRECTA
            //CASO CONTRARIO, CUANDO ES PUNTAJE ES DIFERENTE DE CERO AHI SOLO APARECEN EN TEXTO DE RESPUESTA ORIGINAL Y EL TEXTO CORRECTO ORIGINAL
            $resultadotextoaudio = DB::table('results')->where('question_id', $questionId)->where('user_id', $userId)->pluck('score')->toArray();
            //COMO QUESTIONTA TIENE SOLO UNA RESPUESTA, SE CAPTURA SOLO EL PRIMER ELEMENTO DEL ARRAY
            $resultadotauno = reset($resultadotextoaudio);
            


            ///////////////////////////////////////////////////////////////////////////////////CODIGO ANALISIS DE TEXTO AUDIO//////////////////////

            //GUARDAR EN UNA VARIABLE EL TEXTO CON LA RESPUESTA DEL USUARIO Y EL TEXTO CORRECTO
            //CON TRIM SE QUITAN LOS ESPACIOS DEL INICIO Y FINAL DEL TEXTO
            $textoUsuarioUno = trim($textoUsuario);
            $textoCorrectoUno = trim($textoCorrecto);

            //VARIABLE QUE MOSTRARA UN MENSAJE EN LA SECCION DE DETALLE DE RESPUESTA
            $respuestaTextoUno = "";

            //COMPROBACION TEXTO

            //VARIABLES 
            $caracteresCorrectosTexto = [];
            $caracteresIncorrectosTexto = [];
            $palabrasCorrectasTexto = [];
            $palabrasIncorrectasTexto = [];
            $seccionesCorrectasTexto = [];
            $seccionesIncorrectasTexto = [];

            //ARRAY QUE VAN A CONTENER LOS DATOS PARA ENVIARLOS A LAS VISTAS
            $resultadoPalabrasIncorrectasTextoUsuario = [];
            $resultadoSignosIncorrectosTextoUsuario = [];
            $resultadoPalabrasQueLeFaltaronTextoUsuario = [];
            $resultadoSignosQueLeFaltaronTextoUsuario = [];
            $resultadoSeccionesQueLeFaltaronTextoUsuario = [];
            //ACTUALIZACION SE AGREGA ESTE ARRAY PARA PODER PINTAR EN LA VISTA LAS SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS
            $resultadoSeccionesTextoUsuarioIncorrectas= [];

            $compararTexto = strcmp($textoCorrectoUno, $textoUsuarioUno);

            if($compararTexto === 0){

                $respuestaTextoUno = "Su respuesta es correcta.";

                $resultadoPalabrasIncorrectasTextoUsuario = [];
                $resultadoSignosIncorrectosTextoUsuario = [];
                $resultadoPalabrasQueLeFaltaronTextoUsuario = [];
                $resultadoSignosQueLeFaltaronTextoUsuario = [];
                $resultadoSeccionesQueLeFaltaronTextoUsuario = [];
                //ACTUALIZACION SE AGREGA ESTE NUEVO ARRAY
                $resultadoSeccionesTextoUsuarioIncorrectas= [];
                //ACTUALIZACION SE AGREGA ESTE CAMPO QUE CONTIENE LA RESPUESTA DEL USUARIO
                $stringseccionestextotausuario = $textoUsuarioUno;
                //ACTUALIZACION SE ENVIA ESTE CAMPO PARA VER SI HAY ESPACIOS O NO EN LA RESPUESTA
                //COMO EN ESTE CASO NO HAY ESPACIOS ADICIONALES PORQUE LA RESPUESTA ES CORRECTA SE ENVIA FALSE
                $existenespacios = false;
                //ACTUALIZACION, SI EL TEXTO ES CORRECTO LA VARIABLE hayUnEspacioEnBlancoEnunciadoDos SE ENVIA FALSE
                $hayUnEspacioEnBlancoTextoAudio = false;
                //ACTUALIZACION, LA VARIABLE PARA MOSTRAR EL MENSAJE ES FALSA SI LA RESPUESTA ES CORRECTA
                $mensajeEspacioBlancoTextoAudio = false;
                
            }else{

                $nroCaracteresTextoUsuario = mb_strlen($textoUsuarioUno, 'UTF-8');
                $nroCaracteresTextoCorrecto = mb_strlen($textoCorrectoUno, 'UTF-8');

                $arrayCaracteresTextoUsuario = mb_str_split($textoUsuarioUno);
                $arrayCaracteresTextoCorrecto = mb_str_split($textoCorrectoUno);

                $arraySeccionesTextoCorrecto = explode(' ', $textoCorrectoUno);
                $arraySeccionesTextoUsuario = explode(' ', $textoUsuarioUno);


                $aPalabrasTextoCorrecto = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $textoCorrectoUno);
                $arrayPalabrasTextoCorrecto = explode(' ', $aPalabrasTextoCorrecto);
                $aPalabrasTextoUsuario = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $textoUsuarioUno);
                $arrayPalabrasTextoUsuario = explode(' ', $aPalabrasTextoUsuario);


                $nroElementosArrayCaracteresTextoUsuario = count($arrayCaracteresTextoUsuario);
                $nroElementosArrayCaracteresTextoCorrecto = count($arrayCaracteresTextoCorrecto);
                $arraySignosTextoUsuario = [];
                $arraySignosTextoCorrecto = [];

                for($i=0; $i<$nroElementosArrayCaracteresTextoUsuario; $i++){
                    if((strcmp($arrayCaracteresTextoUsuario[$i], ',') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], ':') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], ';') === 0) || 
                        (strcmp($arrayCaracteresTextoUsuario[$i], '-') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '+') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '/') === 0) || 
                        (strcmp($arrayCaracteresTextoUsuario[$i], '.') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '...') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '....') === 0) ||
                        (strcmp($arrayCaracteresTextoUsuario[$i], '&') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '!') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '¡') === 0) ||
                        (strcmp($arrayCaracteresTextoUsuario[$i], '?') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '¿') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '"') === 0) || 
                        (strcmp($arrayCaracteresTextoUsuario[$i], ')') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '(') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '..') === 0) || 
                        (strcmp($arrayCaracteresTextoUsuario[$i], '*') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], "'") === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '[') === 0) ||
                        (strcmp($arrayCaracteresTextoUsuario[$i], ']') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '{') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '}') === 0) ||
                        (strcmp($arrayCaracteresTextoUsuario[$i], '_') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '^') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '#') === 0) ||
                        (strcmp($arrayCaracteresTextoUsuario[$i], '<') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '>') === 0) || (strcmp($arrayCaracteresTextoUsuario[$i], '|') === 0)){

                        array_push($arraySignosTextoUsuario, $arrayCaracteresTextoUsuario[$i]);
                    }
                }

                for($m=0; $m<$nroElementosArrayCaracteresTextoCorrecto; $m++){
                    if((strcmp($arrayCaracteresTextoCorrecto[$m], ',') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], ':') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], ';') === 0) || 
                        (strcmp($arrayCaracteresTextoCorrecto[$m], '-') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '+') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '/') === 0) || 
                        (strcmp($arrayCaracteresTextoCorrecto[$m], '.') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '...') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '....') === 0) ||
                        (strcmp($arrayCaracteresTextoCorrecto[$m], '&') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '!') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '¡') === 0) ||
                        (strcmp($arrayCaracteresTextoCorrecto[$m], '?') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '¿') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '"') === 0) || 
                        (strcmp($arrayCaracteresTextoCorrecto[$m], ')') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '(') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '..') === 0) || 
                        (strcmp($arrayCaracteresTextoCorrecto[$m], '*') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], "'") === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '[') === 0) ||
                        (strcmp($arrayCaracteresTextoCorrecto[$m], ']') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '{') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '}') === 0) ||
                        (strcmp($arrayCaracteresTextoCorrecto[$m], '_') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '^') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '#') === 0) ||
                        (strcmp($arrayCaracteresTextoCorrecto[$m], '<') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '>') === 0) || (strcmp($arrayCaracteresTextoCorrecto[$m], '|') === 0)){

                        array_push($arraySignosTextoCorrecto, $arrayCaracteresTextoCorrecto[$m]);
                    }
                }

                $nroElementosArrayPalabrasTextoUsuario = count($arrayPalabrasTextoUsuario);
                $nroElementosArrayPalabrasTextoCorrecto = count($arrayPalabrasTextoCorrecto);
                $nroElementosArraySignosTextoUsuario = count($arraySignosTextoUsuario);
                $nroElementosArraySignosTextoCorrecto = count($arraySignosTextoCorrecto);
                $nroElementosArraySeccionesTextoUsuario = count($arraySeccionesTextoUsuario);
                $nroElementosArraySeccionesTextoCorrecto = count($arraySeccionesTextoCorrecto);

                for($e=0; $e<$nroElementosArrayPalabrasTextoUsuario; $e++){
                    if(!in_array($arrayPalabrasTextoUsuario[$e], $arrayPalabrasTextoCorrecto)){
                        array_push($resultadoPalabrasIncorrectasTextoUsuario, $arrayPalabrasTextoUsuario[$e]);
                    }
                }

                for($r=0; $r<$nroElementosArraySignosTextoUsuario; $r++){
                    if(!in_array($arraySignosTextoUsuario[$r], $arraySignosTextoCorrecto)){
                        array_push($resultadoSignosIncorrectosTextoUsuario, $arraySignosTextoUsuario[$r]);
                    }
                }

                for($f=0; $f<$nroElementosArrayPalabrasTextoCorrecto; $f++){
                    if(!in_array($arrayPalabrasTextoCorrecto[$f], $arrayPalabrasTextoUsuario)){
                        array_push($resultadoPalabrasQueLeFaltaronTextoUsuario, $arrayPalabrasTextoCorrecto[$f]);
                    }
                }

                for($j=0; $j<$nroElementosArraySignosTextoCorrecto; $j++){
                    if(!in_array($arraySignosTextoCorrecto[$j], $arraySignosTextoUsuario)){
                        array_push($resultadoSignosQueLeFaltaronTextoUsuario, $arraySignosTextoCorrecto[$j]);
                    }
                }

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONTEXTOUSUARIO ORIGINAL
                //for($d=0; $d<$nroElementosArraySeccionesTextoCorrecto; $d++){
                //    if(!in_array($arraySeccionesTextoCorrecto[$d], $arraySeccionesTextoUsuario)){
                //        array_push($resultadoSeccionesQueLeFaltaronTextoUsuario, $arraySeccionesTextoCorrecto[$d]);
                //    }
                //} 


                ////////////////////////////////////////////////METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSSECCIONESQUELEFALTARONTEXTOUSUARIO FINAL

                $contadorSeccionesQueLeFaltaronTextoUsuarioUno = 0;
                $contadorSeccionesQueLeFaltaronTextoUsuarioDos = 0;

                for($u=0; $u<$nroElementosArraySeccionesTextoCorrecto; $u++){

                    for ($y=0; $y<$nroElementosArraySeccionesTextoCorrecto; $y++){
                        $compararta = strcmp($arraySeccionesTextoCorrecto[$u], $arraySeccionesTextoCorrecto[$y]);
                        if ($compararta === 0){
                            $contadorSeccionesQueLeFaltaronTextoUsuarioUno++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesTextoUsuario); $z++){
                        $comparartausuario = strcmp($arraySeccionesTextoCorrecto[$u], $arraySeccionesTextoUsuario[$z]);
                        if($comparartausuario === 0){
                            $contadorSeccionesQueLeFaltaronTextoUsuarioDos++;
                        }
                    }

                    if(($contadorSeccionesQueLeFaltaronTextoUsuarioUno > $contadorSeccionesQueLeFaltaronTextoUsuarioDos)){
                        if (!in_array($arraySeccionesTextoCorrecto[$u], $resultadoSeccionesQueLeFaltaronTextoUsuario)){
                            array_push($resultadoSeccionesQueLeFaltaronTextoUsuario, $arraySeccionesTextoCorrecto[$u]);
                        }
                        
                    }
                    $contadorSeccionesQueLeFaltaronTextoUsuarioUno = 0;
                    $contadorSeccionesQueLeFaltaronTextoUsuarioDos = 0;
                }

                /////////////////////////////////////////////FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSSECCIONESQUELEFALTARONTEXTOUSUARIO FINAL


                

                //ACTUALIZACION 
                //EN EL ARRAY COMENTADO SE AGREGARAN LAS SECCIONES DE LA RESPUESTA DEL USUARIO QUE NO COINCIDAN CON LAS SECCIONES DE LA RESPUESTA CORRECTA
                //$resultadoSeccionesTextoUsuarioIncorrectas= [];
                //PARA LA COMPARACION, CON UN FOR SE RECORRE EL ARRAYSECCIONESTEXTOUSUARIO Y SE PREGUNTA SI LA SECCION[I] DE ESE ARRAY NO COINCIDE CON ALGUNA DE LAS SECCIONES DEL TEXTO CORRECTO
                //Y LAS SECCIONES DEL ARRAYSECCIONESTEXTOUSUARIO QUE NO COINCIDAN CON ALGUNA SECCION DEL ARRAYSECCIONESTEXTOCORRECTO, SE GUARDAN EN EL ARRAY
                //RESULTADOSSECCIONESTEXTOUSUARIOINCORRECTAS PARA ENVIARLAS A LA VISTA
                //for($p=0; $p<$nroElementosArraySeccionesTextoUsuario; $p++){
                //    if(!in_array($arraySeccionesTextoUsuario[$p], $arraySeccionesTextoCorrecto)){
                //        array_push($resultadoSeccionesTextoUsuarioIncorrectas, $arraySeccionesTextoUsuario[$p]);
                //    }
                //}

                //return $resultadoSeccionesTextoUsuarioIncorrectas;


                ////////////////////////////////////METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESTEXTOUSUARIOINCORRECTAS

                //CAPTURAR LAS PALABRAS QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA Y AGREGARLAS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS
                for($b=0; $b<$nroElementosArraySeccionesTextoUsuario; $b++){
                    if(!in_array($arraySeccionesTextoUsuario[$b], $arraySeccionesTextoCorrecto)){
                        array_push($resultadoSeccionesTextoUsuarioIncorrectas, $arraySeccionesTextoUsuario[$b]);
                    }
                }

                
                //AGREGAR AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS LAS PALABRAS QUE SI FORMAN PARTE DEL TEXTO CORRECTO, PERO QUE ESTAN AGREGADAS EN DEMASIA
                //ES DECIR, EN EL TEXTO CORRECTO HAY 2 "HOLA" PERO EN LA RESPUESTA DEL USUARIO HAY 3 "HOLA", POR LO TANTO ES UNA PALABRA INCORRECTA.
                //ESTE METODO ESTÁ BASADO EN EL METODO PARA AGREGAR ELEMENTOS AL ARRAY $resultadoSeccionesQueLeFaltaronParrafoUsuario
                //LA DIFERENCIA ES QUE EN LA SECCION FINAL DE ESTE METODO SE CAMBIO EL METODO DE MAYOR QUE A MENOR QUE  

                $contadorResultadoSeccionesTextoUsuarioIncorrectasUno = 0;
                $contadorResultadoSeccionesTextoUsuarioIncorrectasDos = 0;
                for($u=0; $u<$nroElementosArraySeccionesTextoCorrecto; $u++){

                    for ($y=0; $y<$nroElementosArraySeccionesTextoCorrecto; $y++){
                        $compararta = strcmp($arraySeccionesTextoCorrecto[$u], $arraySeccionesTextoCorrecto[$y]);
                        if ($compararta === 0){
                            $contadorResultadoSeccionesTextoUsuarioIncorrectasUno++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesTextoUsuario); $z++){
                        $comparartausuario = strcmp($arraySeccionesTextoCorrecto[$u], $arraySeccionesTextoUsuario[$z]);
                        if($comparartausuario === 0){
                            $contadorResultadoSeccionesTextoUsuarioIncorrectasDos++;
                        }

                    }

                    if(($contadorResultadoSeccionesTextoUsuarioIncorrectasUno < $contadorResultadoSeccionesTextoUsuarioIncorrectasDos)){
                        if (!in_array($arraySeccionesTextoCorrecto[$u], $resultadoSeccionesTextoUsuarioIncorrectas)){
                            array_push($resultadoSeccionesTextoUsuarioIncorrectas, $arraySeccionesTextoCorrecto[$u]);
                        }
                        
                    }
                    $contadorResultadoSeccionesTextoUsuarioIncorrectasUno = 0;
                    $contadorResultadoSeccionesTextoUsuarioIncorrectasDos = 0;

                }

                //return $resultadoSeccionesTextoUsuarioIncorrectas;

                ////////////////////////////////////FIN METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESTEXTOUSUARIOINCORRECTAS


                //ACTUALIZACION 
                //A TRAVES DEL ARRAYSECCIONESTEXTOUSUARIO SE PUEDE REEMPLAZAR CON "_" LOS ESPACIOS ADICIONALES QUE EL USUARIO HAYA AGREGADO
                //A SU RESPUESTA CUANDO LA RESPUESTA DEL USUARIO SEA ERRONEA, POR ESA RAZON EL ARRAYSECCIONESTEXTOUSUARIO SE ENVIA A LA VISTA
                //PARA MOSTRARLO CUANDO LAS ORACIONES NO COINCIDAN

                //PRIMERO SE RECORRE EL ARRAY Y CUANDO ENCUENTRE ESPACIOS VACIOS LOS VA A IR REEMPLAZANDO POR "_"
                for($g=0; $g<count($arraySeccionesTextoUsuario); $g++){
                    if($arraySeccionesTextoUsuario[$g] === ""){
                        $arraySeccionesTextoUsuario[$g] = "_";
                    }
                }
                //LUEGO CON EL IMPLODE SE UNE EL ARRAY DE NUEVO PARA ENVIARLO A LA VSITA
                $stringseccionestextotausuario = implode(" ",$arraySeccionesTextoUsuario);
                //A LA VISTA TAMBIEN SE VA A ENVIAR UNA VARIABLE TIPO BOOLEANO QUE SE ENVIA FALSE SI NO HAY "_" EN EL 
                //ARRAYSECCIONESTEXTOUSUARIO Y DEVUELVE TRUE SI ESQUE SI HAY "_" EN EL ARRAY
                //ESTO SE ENVIA A LA VISTA PARA QUE EN BASE A LO QUE DEVUELVA, APAREZA EL MENSAJE DE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA 
                //DEL USUARIO O NO HAY ESPACIOS ADICIONALES EN LA RESPUESTA DEL USUARIO
                $existenespacios = false;
                if(in_array("_", $arraySeccionesTextoUsuario)){
                    $existenespacios = true;
                }

                //return $existenespacios;
                //return $stringseccionestextotausuario;


                //ACTUALIZACION
                //ANTES DE ENVIAR EL ARRAY RESULTADOSECCIONESTEXTOUSUARIOINCORRECTAS
                //SE AGREGA EL ARRAYUNIQUE Y SE REEMPLAZA LOS ESPACIOS VACIOS "" POR LA PALABRA "ESPACIOS VACIOS"
                //EL ARRAY UNIQUE SE ENVIO EN LA VISTA, REVISAR EN LA SECCION DONDE SE RECORRE EL ARRAY RESULTADOSECCIONESTEXTOUSUARIOINCORRECTAS
                //EN LA VISTA
                for($u=0; $u<count($resultadoSeccionesTextoUsuarioIncorrectas); $u++){
                    if($resultadoSeccionesTextoUsuarioIncorrectas[$u] === ""){
                        $resultadoSeccionesTextoUsuarioIncorrectas[$u] = "Espacios en blanco.";
                    }
                }

                //array_unique($resultadoSeccionesTextoUsuarioIncorrectas);
                //return array_unique($resultadoSeccionesTextoUsuarioIncorrectas);


                if($nroElementosArrayCaracteresTextoCorrecto === $nroElementosArrayCaracteresTextoUsuario){
                    $respuestaTextoUno = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresTextoCorrecto < $nroElementosArrayCaracteresTextoUsuario){
                    //$respuestaTextoUno = "Su respuesta es incorrecta. Puede contener letras, signos ortográficos incorrectos o más de un espacio entre palabras.";
                    $respuestaTextoUno = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresTextoCorrecto > $nroElementosArrayCaracteresTextoUsuario){
                    //$respuestaTextoUno = "Su respuesta es incorrecta. Ha omitido algunos elementos en un respuesta.";
                    $respuestaTextoUno = "Su respuesta es incorrecta.";
                }else{
                    //$respuestaTextoUno = "Su respuesta es incorrecta. Tiene algunos errores que se detallan abajo.";
                    $respuestaTextoUno = "Su respuesta es incorrecta.";
                }


            }



            //ACTUALIZACION
            //PARA MOSTRAR LAS REGLAS ORTOGRAFICAS ASOCIADAS A LA PREGUNTA CLASIFICADAS POR PALABRAS, PUNTUACION Y ACENTUACION
            //SE DECLARA TRES VARIABLES QUE VAN A A ENVIAR TRUE SI HAY REGLAS ASOCIADAS DE PALABRAS, PUNTUACION O ACENTUACION
            //ESTO SIRVE PARA QUE EN LA VISTA DE MUESTREN LAS SECCIONES SOLO SI HAY REGLAS DE ESE TIPO ASOCIADAS
            
            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 1 CATEGORIES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasencategories = false;
            $hayacentuacionencategories = false;
            $haypuntuacionencategories = false;

            for($a=0; $a<count($questionType->categories); $a++){

                if($questionType->categories[$a]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionencategories = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 2 SECTIONS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasensections = false;
            $hayacentuacionensections = false;
            $haypuntuacionensections = false;

            for($b=0; $b<count($questionType->sections); $b++){

                if($questionType->sections[$b]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionensections = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 3 POSTS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenposts = false;
            $hayacentuacionenposts = false;
            $haypuntuacionenposts = false;

            for($c=0; $c<count($questionType->posts); $c++){

                if($questionType->posts[$c]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenposts = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 4 RULES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenrules = false;
            $hayacentuacionenrules = false;
            $haypuntuacionenrules = false;

            for($d=0; $d<count($questionType->rules); $d++){

                if($questionType->rules[$d]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenrules = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 5 NOTES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasennotes = false;
            $hayacentuacionennotes = false;
            $haypuntuacionennotes = false;

            for($e=0; $e<count($questionType->notes); $e++){

                if($questionType->notes[$e]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionennotes = true;
                }
            }


            //ACTUALIZACION
                //SE VERIFICA SI EN EL ARRAY $resultadoSeccionesIncorrectasEnunciadoUsuarioUno TODOS LOS ELEMENTOS SON "Espacios en blanco."
                //SI ES ASI, EN LA VARIABLE $hayUnEspacioEnBlancoEnunciadoUno SE ENVIA TRUE, CASO CONTRARIO SE ENVIA FALSE
               

                $hayUnEspacioEnBlancoTextoAudio = false;
                
                //SE RECORRE EL ARRAY DE LAS SECCIONES INCORRECTAS Y SE COMPARA SI TODOS LOS ELEMENTOS SON ESPACIOS EN BLANCO
                $contadorEspaciosTextoAudio = 0;
                for($f=0; $f< count($resultadoSeccionesTextoUsuarioIncorrectas); $f++){
                    if($resultadoSeccionesTextoUsuarioIncorrectas[$f] === "Espacios en blanco."){
                        $contadorEspaciosTextoAudio++;
                    }
                }
                if($contadorEspaciosTextoAudio === count($resultadoSeccionesTextoUsuarioIncorrectas)){
                    $hayUnEspacioEnBlancoTextoAudio = true;
                }

                //CON EL IN ARRAY SE COMPRUEBA SI HAY ESPACIOS EN BLANCO EN EL ARRAY DE SECCIONESINCORRECTAS
                //ESTO SIRVE PARA MOSTRAR UN MENSAJE EN LA VISTA DE QUE EL USUARIO TIENE ESPACIOS EN BLANCO
                //Y ADEMAS OTROS ELEMENTOS INCORRECTOS
                $mensajeEspacioBlancoTextoAudio = false;
                if(in_array("Espacios en blanco.", $resultadoSeccionesTextoUsuarioIncorrectas)){
                    $mensajeEspacioBlancoTextoAudio = true;
                }

                //return $mensajeEspacioBlancoOracionCinco;


            

            //return view('rules.estudiante.displayresults.displayta', compact('questionType', 'textoUsuario', 'sumaresultados', 'textoCorrecto', 'userId', 'evaluationId', 'respuesta'
            //            , 'resultadoPalabrasIncorrectasTextoUsuario', 'resultadoSignosIncorrectosTextoUsuario', 'resultadoPalabrasQueLeFaltaronTextoUsuario', 'resultadoSignosQueLeFaltaronTextoUsuario'
            //            , 'resultadoSeccionesQueLeFaltaronTextoUsuario', 'respuestaTextoUno', 'resultadoSeccionesTextoUsuarioIncorrectas', 'resultadotauno', 'stringseccionestextotausuario', 'existenespacios'
            //            ));


            

            return view('rules.estudiante.displayresults.displayta', compact('questionType', 'textoUsuario', 'sumaresultados', 'textoCorrecto', 'userId', 'evaluationId', 'respuesta'
                        , 'resultadoPalabrasIncorrectasTextoUsuario', 'resultadoSignosIncorrectosTextoUsuario', 'resultadoPalabrasQueLeFaltaronTextoUsuario', 'resultadoSignosQueLeFaltaronTextoUsuario'
                        , 'resultadoSeccionesQueLeFaltaronTextoUsuario', 'respuestaTextoUno', 'resultadoSeccionesTextoUsuarioIncorrectas', 'resultadotauno', 'stringseccionestextotausuario', 'existenespacios'
                        , 'haypalabrasencategories', 'hayacentuacionencategories', 'haypuntuacionencategories', 'haypalabrasensections', 'hayacentuacionensections', 'haypuntuacionensections'
                        , 'haypalabrasenposts', 'hayacentuacionenposts', 'haypuntuacionenposts', 'haypalabrasenrules', 'hayacentuacionenrules', 'haypuntuacionenrules'
                        , 'haypalabrasennotes', 'hayacentuacionennotes', 'haypuntuacionennotes'
                        , 'hayUnEspacioEnBlancoTextoAudio', 'mensajeEspacioBlancoTextoAudio'));

            /////////////////////////////////////////////////////////////////////////////////////FIN CODIGO

            //return view('rules.estudiante.displayresults.displayta', compact('questionType', 'textoUsuario', 'sumaresultados', 'textoCorrecto', 'userId', 'evaluationId', 'respuesta'));
        }
        elseif(($questionType->type) === "TI"){
 
            //CAPTURAR LA RESPUESTA DEL USUARIO A LA QUESTION TA MEDIANTE EL USER ID Y EVALUATION ID
            $answerUser = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->pluck('id')->toArray();
            //SACAR EL ID DE LA RESPUESTA DEL ARRAY
            $idCorrecta = reset($answerUser);
            //CAPTURAR EL REGISTRO DE RESPUESTA DEL USUARIO DE LA TABLA RESULTS
            $resultUser = Result::find($idCorrecta);
            //CAPTURAR EL TEXTO USUARIO
            $textoUsuario = $resultUser->answer_user;

            //CAPTURAR EL PUNTAJE QUE TIENE EL ESTUDIANTE EN LA PREGUNTA ACTUAL
            $resultados = DB::table('results')->where('question_id', $questionId)->where('user_id', $userId)->pluck('score')->toArray();
            $sumaresultados = array_sum($resultados);

            //CAPTURAR EL TEXTO CORRECTO DE LA TABLA ANSWERS
            $resCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->pluck('id')->toArray();
            $idAnswerCorrecta = reset($resCorrecta);
            //YA TENIENDO EL ID DE LA RESPUESTA CORRECTA, SE CAPTURA EL REGISTRO COMPLETO DE ANSWER
            $answerCorrecta = Answer::find($idAnswerCorrecta);
            //SE GUARDA EL TEXTO CORRECTO 
            $textoCorrecto = $answerCorrecta->answer;

            //SE COMPARA SI EL TEXTO CORRECTO ES IGUAL AL TEXTO DEL USUARIO PARA ENVIAR UNA RESPUESTA
            $respuesta = "";
            $comparacion = strcmp($textoCorrecto, $textoUsuario);
            if($comparacion == 0){
                $respuesta = "El texto que ha ingresado es correcto.";
            }
            else{
                $respuesta = "El texto que ha ingresado es incorrecto.";
            }


            
            //ACTUALIZACION 
            //SE ENVIA A LA VISTA EL PUNTAJE DE CADA ITEM DEL USUARIO PARA EN FUNCION DE ESO MOSTRAR SOLO EL TEXTO DE RESPUESTA DEL USUARIO ORIGINAL Y LA RESPUESTA CORRECTA ORIGINAL
            //PARA QUE EN LA VISTA EN FUNCION DE SI TIENE 0 DE PUNTAJE ES DECIR, TIENE ERRORES, LE APAREZCA LA REVISION DEL TEXTO Y LA REVISION DE LA RESPUESTA CORRECTA
            //CASO CONTRARIO, CUANDO EL PUNTAJE ES DIFERENTE DE CERO AHI SOLO APARECEN EL TEXTO DE RESPUESTA ORIGINAL Y EL TEXTO CORRECTO ORIGINAL
            $resultadotextoimagen = DB::table('results')->where('question_id', $questionId)->where('user_id', $userId)->pluck('score')->toArray();
            //COMO QUESTIONTI TIENE SOLO UNA RESPUESTA, SE CAPTURA SOLO EL PRIMER ELEMENTO
            $resultadotiuno = reset($resultadotextoimagen);
            
            
            ///////////////////////////////////////////////////////////////////////////////////////////CODIGO ANALISIS TEXTO IMAGEN //////////////////////////////////////////////////////////////////

            //GUARDAR EN UNA VARIABLE EL TEXTO CON LA RESPUESTA DEL USUARIO Y EL TEXTO CORRECTO
            //CON TRIM SE QUITAN LOS ESPACIOS DEL INICIO Y FINAL DEL TEXTO
            $parrafoUsuarioUno = trim($textoUsuario);
            $parrafoCorrectoUno = trim($textoCorrecto);

            //VARIABLE QUE MOSTRARA UN MENSAJE EN LA SECCION DE DETALLE DE RESPUESTA
            $respuestaParrafoUno = "";

            
            //COMPROBACION TEXTO

            //VARIABLES 
            $caracteresCorrectosParrafo = [];
            $caracteresIncorrectosParrafo = [];
            $palabrasCorrectasParrafo = [];
            $palabrasIncorrectasParrafo = [];
            $seccionesCorrectasParrafo = [];
            $seccionesIncorrectasParrafo = [];

            //ARRAY QUE VAN A CONTENER LOS DATOS PARA ENVIARLOS A LAS VISTAS
            $resultadoPalabrasIncorrectasParrafoUsuario = [];
            $resultadoSignosIncorrectosParrafoUsuario = [];
            $resultadoPalabrasQueLeFaltaronParrafoUsuario = [];
            $resultadoSignosQueLeFaltaronParrafoUsuario = [];
            $resultadoSeccionesQueLeFaltaronParrafoUsuario = [];
            //ACTUALIZACION SE AGREGA ESTE ARRAY PARA PODER PINTAR EN LA VISTA LAS SECCIONES DE LA RESPUESTA DEL USUARIO QUE SON INCORRECTAS
            $resultadoSeccionesParrafoUsuarioIncorrectas = [];

            $compararParrafo = strcmp($parrafoCorrectoUno, $parrafoUsuarioUno);

            if($compararParrafo === 0){

                $respuestaParrafoUno = "Su respuesta es correcta.";

                $resultadoPalabrasIncorrectasParrafoUsuario = [];
                $resultadoSignosIncorrectosParrafoUsuario = [];
                $resultadoPalabrasQueLeFaltaronParrafoUsuario = [];
                $resultadoSignosQueLeFaltaronParrafoUsuario = [];
                $resultadoSeccionesQueLeFaltaronParrafoUsuario = [];
                //ACTUALIZACION SE AGREGA ESTE NUEVO ARRAY
                $resultadoSeccionesParrafoUsuarioIncorrectas = [];
                //ACTUALIZACION SE AGREGA ESTE CAMPO QUE CONTIENE LA RESPUESTA DEL USUARIO
                $stringseccionestextotiusuario = $parrafoUsuarioUno;
                //ACTUALIZACION SE ENVIA ESTE CAMPO PARA VER SI HAY ESPACIOS O NO EN LA RESPUESTA
                //COMO EN ESTE CASO NO HAY ESPACIOS ADICIONALES PORQUE LA RESPUESTA ES CORRECTA, SE ENVIA FALSE
                $existenespaciosti = false;
                //ACTUALIZACION, SI EL TEXTO ES CORRECTO LA VARIABLE hayUnEspacioEnBlancoEnunciadoDos SE ENVIA FALSE
                $hayUnEspacioEnBlancoTextoImagen = false;
                //ACTUALIZACION, LA VARIABLE PARA MOSTRAR EL MENSAJE ES FALSA SI LA RESPUESTA ES CORRECTA
                $mensajeEspacioBlancoTextoImagen = false;
            }else{

                $nroCaracteresParrafoUsuario = mb_strlen($parrafoUsuarioUno, 'UTF-8');
                $nroCaracteresParrafoCorrecto = mb_strlen($parrafoCorrectoUno, 'UTF-8');

                $arrayCaracteresParrafoUsuario = mb_str_split($parrafoUsuarioUno);
                $arrayCaracteresParrafoCorrecto = mb_str_split($parrafoCorrectoUno);

                $arraySeccionesParrafoCorrecto = explode(' ', $parrafoCorrectoUno);
                $arraySeccionesParrafoUsuario = explode(' ', $parrafoUsuarioUno);


                $aPalabrasParrafoCorrecto = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $parrafoCorrectoUno);
                $arrayPalabrasParrafoCorrecto = explode(' ', $aPalabrasParrafoCorrecto);
                $aPalabrasParrafoUsuario = str_replace(array(',', ':', ';', '-', '+', '/', '.', '...', '....', '&', '!', '¡', '?', '¿', '"'. ')', '(', '..', '*', "'", '[', ']', '{', '}', '/', '_', '^', '#', '<', '>', '|'), '', $parrafoUsuarioUno);
                $arrayPalabrasParrafoUsuario = explode(' ', $aPalabrasParrafoUsuario);


                $nroElementosArrayCaracteresParrafoUsuario = count($arrayCaracteresParrafoUsuario);
                $nroElementosArrayCaracteresParrafoCorrecto = count($arrayCaracteresParrafoCorrecto);
                $arraySignosParrafoUsuario = [];
                $arraySignosParrafoCorrecto = [];


                for($i=0; $i<$nroElementosArrayCaracteresParrafoUsuario; $i++){
                    if((strcmp($arrayCaracteresParrafoUsuario[$i], ',') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], ':') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], ';') === 0) || 
                        (strcmp($arrayCaracteresParrafoUsuario[$i], '-') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '+') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '/') === 0) || 
                        (strcmp($arrayCaracteresParrafoUsuario[$i], '.') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '...') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '....') === 0) ||
                        (strcmp($arrayCaracteresParrafoUsuario[$i], '&') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '!') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '¡') === 0) ||
                        (strcmp($arrayCaracteresParrafoUsuario[$i], '?') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '¿') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '"') === 0) || 
                        (strcmp($arrayCaracteresParrafoUsuario[$i], ')') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '(') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '..') === 0) || 
                        (strcmp($arrayCaracteresParrafoUsuario[$i], '*') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], "'") === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '[') === 0) ||
                        (strcmp($arrayCaracteresParrafoUsuario[$i], ']') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '{') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '}') === 0) ||
                        (strcmp($arrayCaracteresParrafoUsuario[$i], '_') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '^') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '#') === 0) ||
                        (strcmp($arrayCaracteresParrafoUsuario[$i], '<') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '>') === 0) || (strcmp($arrayCaracteresParrafoUsuario[$i], '|') === 0)){

                        array_push($arraySignosParrafoUsuario, $arrayCaracteresParrafoUsuario[$i]);
                    }
                }


                for($m=0; $m<$nroElementosArrayCaracteresParrafoCorrecto; $m++){
                    if((strcmp($arrayCaracteresParrafoCorrecto[$m], ',') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], ':') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], ';') === 0) || 
                        (strcmp($arrayCaracteresParrafoCorrecto[$m], '-') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '+') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '/') === 0) || 
                        (strcmp($arrayCaracteresParrafoCorrecto[$m], '.') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '...') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '....') === 0) ||
                        (strcmp($arrayCaracteresParrafoCorrecto[$m], '&') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '!') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '¡') === 0) ||
                        (strcmp($arrayCaracteresParrafoCorrecto[$m], '?') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '¿') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '"') === 0) || 
                        (strcmp($arrayCaracteresParrafoCorrecto[$m], ')') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '(') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '..') === 0) || 
                        (strcmp($arrayCaracteresParrafoCorrecto[$m], '*') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], "'") === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '[') === 0) ||
                        (strcmp($arrayCaracteresParrafoCorrecto[$m], ']') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '{') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '}') === 0) ||
                        (strcmp($arrayCaracteresParrafoCorrecto[$m], '_') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '^') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '#') === 0) ||
                        (strcmp($arrayCaracteresParrafoCorrecto[$m], '<') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '>') === 0) || (strcmp($arrayCaracteresParrafoCorrecto[$m], '|') === 0)){

                        array_push($arraySignosParrafoCorrecto, $arrayCaracteresParrafoCorrecto[$m]);
                    }
                }


                $nroElementosArrayPalabrasParrafoUsuario = count($arrayPalabrasParrafoUsuario);
                $nroElementosArrayPalabrasParrafoCorrecto = count($arrayPalabrasParrafoCorrecto);
                $nroElementosArraySignosParrafoUsuario = count($arraySignosParrafoUsuario);
                $nroElementosArraySignosParrafoCorrecto = count($arraySignosParrafoCorrecto);
                $nroElementosArraySeccionesParrafoUsuario = count($arraySeccionesParrafoUsuario);
                $nroElementosArraySeccionesParrafoCorrecto = count($arraySeccionesParrafoCorrecto);


                for($e=0; $e<$nroElementosArrayPalabrasParrafoUsuario; $e++){
                    if(!in_array($arrayPalabrasParrafoUsuario[$e], $arrayPalabrasParrafoCorrecto)){
                        array_push($resultadoPalabrasIncorrectasParrafoUsuario, $arrayPalabrasParrafoUsuario[$e]);
                    }
                }

                for($r=0; $r<$nroElementosArraySignosParrafoUsuario; $r++){
                    if(!in_array($arraySignosParrafoUsuario[$r], $arraySignosParrafoCorrecto)){
                        array_push($resultadoSignosIncorrectosParrafoUsuario, $arraySignosParrafoUsuario[$r]);
                    }
                }

                for($f=0; $f<$nroElementosArrayPalabrasParrafoCorrecto; $f++){
                    if(!in_array($arrayPalabrasParrafoCorrecto[$f], $arrayPalabrasParrafoUsuario)){
                        array_push($resultadoPalabrasQueLeFaltaronParrafoUsuario, $arrayPalabrasParrafoCorrecto[$f]);
                    }
                }

                for($j=0; $j<$nroElementosArraySignosParrafoCorrecto; $j++){
                    if(!in_array($arraySignosParrafoCorrecto[$j], $arraySignosParrafoUsuario)){
                        array_push($resultadoSignosQueLeFaltaronParrafoUsuario, $arraySignosParrafoCorrecto[$j]);
                    }
                }

                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONPARRAFOUSUARIO ORIGINAL
                //for($d=0; $d<$nroElementosArraySeccionesParrafoCorrecto; $d++){
                //    if(!in_array($arraySeccionesParrafoCorrecto[$d], $arraySeccionesParrafoUsuario)){
                //        array_push($resultadoSeccionesQueLeFaltaronParrafoUsuario, $arraySeccionesParrafoCorrecto[$d]);
                //    }
                //}

                ///////////////////////////////////////////METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESQUELEFALTARONPARRAFOUSUARIO FINAL

                $arraysiu = [];
                $contadorSeccionesQueLeFaltaronParrafoUsuarioUno = 0;
                $contadorSeccionesQueLeFaltaronParrafoUsuarioDos = 0;
                for($u=0; $u<$nroElementosArraySeccionesParrafoCorrecto; $u++){

                    //array_push($arraysiu, ("La palabra " . $u . " es: " . $arraySeccionesParrafoCorrecto[$u]));

                    for ($y=0; $y<$nroElementosArraySeccionesParrafoCorrecto; $y++){
                        $compararti = strcmp($arraySeccionesParrafoCorrecto[$u], $arraySeccionesParrafoCorrecto[$y]);
                        if ($compararti === 0){
                            $contadorSeccionesQueLeFaltaronParrafoUsuarioUno++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesParrafoUsuario); $z++){
                        $comparartiusuario = strcmp($arraySeccionesParrafoCorrecto[$u], $arraySeccionesParrafoUsuario[$z]);
                        if($comparartiusuario === 0){
                            $contadorSeccionesQueLeFaltaronParrafoUsuarioDos++;
                        }
                    }

                    //array_push($arraysiu, ("La palabra " . $u . " es: " . $arraySeccionesParrafoCorrecto[$u] . " y se repite " . $contadoruno . " veces en el texto correcto."));
                
                    //array_push($arraysiu, ("La palabra " . $u . " es: " . $arraySeccionesParrafoCorrecto[$u] . " y se repite " . $contadordos . " veces en el texto del usuario."));
                
                    //if(($contadoruno < $contadordos) || ($contadoruno > $contadordos)){
                    if(($contadorSeccionesQueLeFaltaronParrafoUsuarioUno > $contadorSeccionesQueLeFaltaronParrafoUsuarioDos)){
                        if (!in_array($arraySeccionesParrafoCorrecto[$u], $resultadoSeccionesQueLeFaltaronParrafoUsuario)){
                            array_push($resultadoSeccionesQueLeFaltaronParrafoUsuario, $arraySeccionesParrafoCorrecto[$u]);
                        }
                        
                    }
                    $contadorSeccionesQueLeFaltaronParrafoUsuarioUno = 0;
                    $contadorSeccionesQueLeFaltaronParrafoUsuarioDos = 0;

                }
                //return $resultadoSeccionesQueLeFaltaronParrafoUsuario;

                //return $arraysiu;





                /////////////////////////////////////////////FIN CODIGO AGREGAR ELEMENTOS AL ARRAY RESULTADOSSECCIONESQUELEFALTARONPARRAFOUSUARIO FINAL
                //return $resultadoSeccionesQueLeFaltaronParrafoUsuario;

                //ACTUALIZACION
                //EN EL ARRAY COMENTADO SE AGREGARAN LAS SECCIONES DE LA RESPUESTA DEL USUARIO QUE NO COINCIDAN CON LAS SECCIONES DE LA RESPUESTA CORRECTA
                //$resultadoSeccionesParrafoUsuarioIncorrectas = [];
                //PARA LA COMPARACION, CON UN FOR SE RECORRE EL ARRAYSECCIONESPARRAFOUSUARIO Y SE PREGUNTA SI LA SECCION [I] DE ESE ARRAY NO COINCIDE CON ALGUNA DE LAS SECCIONES DEL TEXTO CORRECTO
                //Y LAS SECCIONES DEL ARRAY SECCIONES TEXTO USUARIO QUE NO COINCIDAN CON ALGUNA SECCION DEL ARRAYSECCIONESPARRAFOCORRECTO, SE GUARDAN EN EL ARRAY
                //RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS PARA ENVIARLAS A LA VISTA
                
                //METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS ORIGINAL
                //for($b=0; $b<$nroElementosArraySeccionesParrafoUsuario; $b++){
                //    if(!in_array($arraySeccionesParrafoUsuario[$b], $arraySeccionesParrafoCorrecto)){
                //        array_push($resultadoSeccionesParrafoUsuarioIncorrectas, $arraySeccionesParrafoUsuario[$b]);
                //    }
                //}

                /////////////////////////////////METODO PARA AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS FINAL

                //CAPTURAR LAS PALABRAS QUE NO TIENEN NADA QUE VER CON LA RESPUESTA CORRECTA Y AGREGARLAS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS
                for($b=0; $b<$nroElementosArraySeccionesParrafoUsuario; $b++){
                    if(!in_array($arraySeccionesParrafoUsuario[$b], $arraySeccionesParrafoCorrecto)){
                        array_push($resultadoSeccionesParrafoUsuarioIncorrectas, $arraySeccionesParrafoUsuario[$b]);
                    }
                }

                //AGREGAR AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS LAS PALABRAS QUE SI FORMAN PARTE DEL TEXTO CORRECTO, PERO QUE ESTAN AGREGADAS EN DEMASIA
                //ES DECIR, EN EL TEXTO CORRECTO HAY 2 "HOLA" PERO EN LA RESPUESTA DEL USUARIO HAY 3 "HOLA", POR LO TANTO ES UNA PALABRA INCORRECTA.
                //ESTE METODO ESTÁ BASADO EN EL METODO PARA AGREGAR ELEMENTOS AL ARRAY $resultadoSeccionesQueLeFaltaronParrafoUsuario
                //LA DIFERENCIA ES QUE EN LA SECCION FINAL DE ESTE METODO SE CAMBIO EL METODO DE MAYOR QUE A MENOR QUE  

                $contadorResultadoSeccionesParrafoUsuarioIncorrectasUno = 0;
                $contadorResultadoSeccionesParrafoUsuarioIncorrectasDos = 0;
                for($u=0; $u<$nroElementosArraySeccionesParrafoCorrecto; $u++){

                    //array_push($arraysiu, ("La palabra " . $u . " es: " . $arraySeccionesParrafoCorrecto[$u]));

                    for ($y=0; $y<$nroElementosArraySeccionesParrafoCorrecto; $y++){
                        $compararti = strcmp($arraySeccionesParrafoCorrecto[$u], $arraySeccionesParrafoCorrecto[$y]);
                        if ($compararti === 0){
                            $contadorResultadoSeccionesParrafoUsuarioIncorrectasUno++;
                        }
                    }

                    for ($z=0; $z<count($arraySeccionesParrafoUsuario); $z++){
                        $comparartiusuario = strcmp($arraySeccionesParrafoCorrecto[$u], $arraySeccionesParrafoUsuario[$z]);
                        if($comparartiusuario === 0){
                            $contadorResultadoSeccionesParrafoUsuarioIncorrectasDos++;
                        }
                    }

                    //array_push($arraysiu, ("La palabra " . $u . " es: " . $arraySeccionesParrafoCorrecto[$u] . " y se repite " . $contadoruno . " veces en el texto correcto."));
                
                    //array_push($arraysiu, ("La palabra " . $u . " es: " . $arraySeccionesParrafoCorrecto[$u] . " y se repite " . $contadordos . " veces en el texto del usuario."));
                
                    if(($contadorResultadoSeccionesParrafoUsuarioIncorrectasUno < $contadorResultadoSeccionesParrafoUsuarioIncorrectasDos)){
                        if (!in_array($arraySeccionesParrafoCorrecto[$u], $resultadoSeccionesParrafoUsuarioIncorrectas)){
                            array_push($resultadoSeccionesParrafoUsuarioIncorrectas, $arraySeccionesParrafoCorrecto[$u]);
                        }
                        
                    }
                    $contadorResultadoSeccionesParrafoUsuarioIncorrectasUno = 0;
                    $contadorResultadoSeccionesParrafoUsuarioIncorrectasDos = 0;

                }


                /////////////////////////////////////FIN CODIGO AGREGAR ELEMENTOS AL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS FINAL

                //return $resultadoSeccionesParrafoUsuarioIncorrectas;


                //ACTUALIZACION
                //A TRAVES DEL ARRAY SECCIONESTEXTOPARRAFOUSUARIO SE PUEDE REEMPLAZAR CON "_" LOS ESPACIOS ADICIONALES QUE EL USUARIO HAYA AGREGADO
                //A SU RESPUESTA CUANDO LA RESPUESTA DEL USUARIO SEA ERRONEA, POR ESA RAZON EL ARRAYSECCIONESPARRAFOUSUARIO SE ENVIA A LA VISTA 
                //PARA MOSTRARLO COUANDO LAS ORACIONES NO COINCIDAN

                
                //PRIMERO SE RECORRE EL ARRAY Y CUANDO ENCUENTRE ESPACIOS VACIOS ADICIONALES LOS VA A IR REEMPLAZANDO POR "_"
                for($g=0; $g<count($arraySeccionesParrafoUsuario); $g++){
                    if($arraySeccionesParrafoUsuario[$g] === ""){
                        $arraySeccionesParrafoUsuario[$g] = "_";
                    }
                     
                } 
                //LUEGO CON EL IMPLODE SE UNE EL ARRAY DE NUEVO PARA ENVIARLO A LA VISTA
                $stringseccionestextotiusuario = implode(" ", $arraySeccionesParrafoUsuario);
                //A LA VISTA TAMBIEN SE VA A ENVIAR UNA VARIABLE TIPO BOOLEAN QUE SE ENVIA FALSE SI NO HAY "_" EN EL ARRAY
                //ARRAYSECCIONESPARRAFOUSUARIO Y DEVUELVE TRUE SI ESQUE SI HAY "_" EN EL ARRAY
                //ESTO SE ENVIA A LA VISTA PARA QUE EN BASE A LO QUE DEVUELVA, APAREZCA EL MENSAJE DE QUE HAY ESPACIOS ADICIONALES EN LA RESPUESTA
                //DEL USUARIO O NO HAY ESPACIOS ADICIONALES EN LA RESPUESTA DEL USUARIO
                $existenespaciosti = false;
                if(in_array("_", $arraySeccionesParrafoUsuario)){
                    $existenespaciosti = true;
                }

                //return $stringseccionestextotiusuario;


                //ACTUALIZACION
                //ANTES DE ENVIAR EL RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS
                //SE AGREGA EL ARRAYUNIQUE Y SE REEMPLAZA LOS ESPACIOS VACIOS "" POR LA PALABRA "ESPACIOS VACIOS"
                //EL ARRAY UNIQUE SE REALIZA EN LA VISTA, REVISAR EN LA SECCION DONDE SE RECORRE EL ARRAY RESULTADOSECCIONESPARRAFOUSUARIOINCORRECTAS
                //EN LA VISTA
                for($u=0; $u<count($resultadoSeccionesParrafoUsuarioIncorrectas); $u++){
                    if($resultadoSeccionesParrafoUsuarioIncorrectas[$u] === ""){
                        $resultadoSeccionesParrafoUsuarioIncorrectas[$u] = "Espacios en blanco.";
                    }
                }
                //return array_unique($resultadoSeccionesParrafoUsuarioIncorrectas);
                //return $resultadoSeccionesParrafoUsuarioIncorrectas;
                


                if($nroElementosArrayCaracteresParrafoCorrecto === $nroElementosArrayCaracteresParrafoUsuario){
                    $respuestaParrafoUno = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresParrafoCorrecto < $nroElementosArrayCaracteresParrafoUsuario){
                    //$respuestaParrafoUno = "Su respuesta es incorrecta. Puede contener letras, signos ortográficos incorrectos o más de un espacio entre palabras.";
                    $respuestaParrafoUno = "Su respuesta es incorrecta.";
                }
                elseif($nroElementosArrayCaracteresParrafoCorrecto > $nroElementosArrayCaracteresParrafoUsuario){
                    //$respuestaParrafoUno = "Su respuesta es incorrecta. Ha omitido algunos elementos en un respuesta.";
                    $respuestaParrafoUno = "Su respuesta es incorrecta.";
                }else{
                    //$respuestaParrafoUno = "Su respuesta es incorrecta. Tiene algunos errores que se detallan abajo.";
                    $respuestaParrafoUno = "Su respuesta es incorrecta.";
                }
            }



            //ACTUALIZACION
            //PARA MOSTRAR LAS REGLAS ORTOGRAFICAS ASOCIADAS A LA PREGUNTA CLASIFICADAS POR PALABRAS, PUNTUACION Y ACENTUACION
            //SE DECLARA TRES VARIABLES QUE VAN A A ENVIAR TRUE SI HAY REGLAS ASOCIADAS DE PALABRAS, PUNTUACION O ACENTUACION
            //ESTO SIRVE PARA QUE EN LA VISTA DE MUESTREN LAS SECCIONES SOLO SI HAY REGLAS DE ESE TIPO ASOCIADAS
            
            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 1 CATEGORIES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasencategories = false;
            $hayacentuacionencategories = false;
            $haypuntuacionencategories = false;

            for($a=0; $a<count($questionType->categories); $a++){

                if($questionType->categories[$a]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionencategories = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 2 SECTIONS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasensections = false;
            $hayacentuacionensections = false;
            $haypuntuacionensections = false;

            for($b=0; $b<count($questionType->sections); $b++){

                if($questionType->sections[$b]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionensections = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 3 POSTS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenposts = false;
            $hayacentuacionenposts = false;
            $haypuntuacionenposts = false;

            for($c=0; $c<count($questionType->posts); $c++){

                if($questionType->posts[$c]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenposts = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 4 RULES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenrules = false;
            $hayacentuacionenrules = false;
            $haypuntuacionenrules = false;

            for($d=0; $d<count($questionType->rules); $d++){

                if($questionType->rules[$d]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenrules = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 5 NOTES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasennotes = false;
            $hayacentuacionennotes = false;
            $haypuntuacionennotes = false;

            for($e=0; $e<count($questionType->notes); $e++){

                if($questionType->notes[$e]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionennotes = true;
                }
            }


            //ACTUALIZACION
                //SE VERIFICA SI EN EL ARRAY $resultadoSeccionesIncorrectasEnunciadoUsuarioUno TODOS LOS ELEMENTOS SON "Espacios en blanco."
                //SI ES ASI, EN LA VARIABLE $hayUnEspacioEnBlancoEnunciadoUno SE ENVIA TRUE, CASO CONTRARIO SE ENVIA FALSE
               

                $hayUnEspacioEnBlancoTextoImagen = false;
                
                //SE RECORRE EL ARRAY DE LAS SECCIONES INCORRECTAS Y SE COMPARA SI TODOS LOS ELEMENTOS SON ESPACIOS EN BLANCO
                $contadorEspaciosTextoImagen = 0;
                for($f=0; $f< count($resultadoSeccionesParrafoUsuarioIncorrectas); $f++){
                    if($resultadoSeccionesParrafoUsuarioIncorrectas[$f] === "Espacios en blanco."){
                        $contadorEspaciosTextoImagen++;
                    }
                }
                if($contadorEspaciosTextoImagen === count($resultadoSeccionesParrafoUsuarioIncorrectas)){
                    $hayUnEspacioEnBlancoTextoImagen = true;
                }

                //CON EL IN ARRAY SE COMPRUEBA SI HAY ESPACIOS EN BLANCO EN EL ARRAY DE SECCIONESINCORRECTAS
                //ESTO SIRVE PARA MOSTRAR UN MENSAJE EN LA VISTA DE QUE EL USUARIO TIENE ESPACIOS EN BLANCO
                //Y ADEMAS OTROS ELEMENTOS INCORRECTOS
                $mensajeEspacioBlancoTextoImagen = false;
                if(in_array("Espacios en blanco.", $resultadoSeccionesParrafoUsuarioIncorrectas)){
                    $mensajeEspacioBlancoTextoImagen = true;
                }

                //return $mensajeEspacioBlancoOracionCinco;



            //return view('rules.estudiante.displayresults.displayti', compact('questionType', 'textoUsuario', 'sumaresultados', 'textoCorrecto', 'userId', 'evaluationId', 'respuesta'
            //            , 'resultadoPalabrasIncorrectasParrafoUsuario', 'resultadoSignosIncorrectosParrafoUsuario', 'resultadoPalabrasQueLeFaltaronParrafoUsuario', 'resultadoSignosQueLeFaltaronParrafoUsuario'
            //            , 'resultadoSeccionesQueLeFaltaronParrafoUsuario', 'respuestaParrafoUno', 'resultadoSeccionesParrafoUsuarioIncorrectas', 'resultadotiuno', 'stringseccionestextotiusuario', 'existenespaciosti'
            //            ));

            return view('rules.estudiante.displayresults.displayti', compact('questionType', 'textoUsuario', 'sumaresultados', 'textoCorrecto', 'userId', 'evaluationId', 'respuesta'
                        , 'resultadoPalabrasIncorrectasParrafoUsuario', 'resultadoSignosIncorrectosParrafoUsuario', 'resultadoPalabrasQueLeFaltaronParrafoUsuario', 'resultadoSignosQueLeFaltaronParrafoUsuario'
                        , 'resultadoSeccionesQueLeFaltaronParrafoUsuario', 'respuestaParrafoUno', 'resultadoSeccionesParrafoUsuarioIncorrectas', 'resultadotiuno', 'stringseccionestextotiusuario', 'existenespaciosti'
                        , 'haypalabrasencategories', 'hayacentuacionencategories', 'haypuntuacionencategories', 'haypalabrasensections', 'hayacentuacionensections', 'haypuntuacionensections'
                        , 'haypalabrasenposts', 'hayacentuacionenposts', 'haypuntuacionenposts', 'haypalabrasenrules', 'hayacentuacionenrules', 'haypuntuacionenrules'
                        , 'haypalabrasennotes', 'hayacentuacionennotes', 'haypuntuacionennotes'
                        , 'hayUnEspacioEnBlancoTextoImagen', 'mensajeEspacioBlancoTextoImagen'));

            //////////////////////////////////////////////////////////////////////////////////////////////FIN CODIGO ANALISIS TEXTO IMAGEN/////////////////////////////////////////////////////////////


        


            //return view('rules.estudiante.displayresults.displayti', compact('questionType', 'textoUsuario', 'sumaresultados', 'textoCorrecto', 'userId', 'evaluationId', 'respuesta'));
        }
        elseif(($questionType->type) === "JA"){

            //CAPTURAR LA RESPUESTA DEL USUARIO A LA QUESTION JA MEDIANTE EL USER_ID Y EVALUATION ID
            $answerUser = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->pluck('id')->toArray();
            //SACAR EL ID DE LA RESPUESTA DEL ARRAY
            $idCorrecta = reset($answerUser);
            //CAPTURAR EL REGISTRO DE RESPUESTA DEL USUARIO DE LA TABLA RESULTS
            $resultUser = Result::find($idCorrecta);


            //CAPTURAR EL PUNTAJE QUE TIENE EL ESTUDIANTE EN LA PREGUNTA ACTUAL
            $resultados = DB::table('results')->where('question_id', $questionId)->where('user_id', $userId)->pluck('score')->toArray();
            $sumaresultados = array_sum($resultados);


            //COMO ES JUEGO SE DEBE CAPTURAR LA RESPUESTA CORRECTA, PARA ELLO SE TRAE UN ARRAY CON LA COLECCION DE RESPUESTAS CORRECTAS
            //DESDE LA TABLA ANSWER
            $resCorrecta = Answer::where('question_id', $questionId)->where('is_correct', true)->pluck('id')->toArray();
            //COMO ES JUEGO SOLO TIENE UNA RESPUESTA CORRECTA, ENTONCES DEL ARRAY RESCORRECTA SOLO SE CAPTURA EL PRIMER ELEMENTOS
            $idAnswerCorrecta = reset($resCorrecta);
            //YA TIENEN EL ID DE LA RESPUESTA CORRECTA, SE CAPTURA EL REGISTRO COMPLETO DE ANSWERCORRECTA
            $answerCorrecta = Answer::find($idAnswerCorrecta);



            //ACTUALIZACION
            //PARA MOSTRAR LAS REGLAS ORTOGRAFICAS ASOCIADAS A LA PREGUNTA CLASIFICADAS POR PALABRAS, PUNTUACION Y ACENTUACION
            //SE DECLARA TRES VARIABLES QUE VAN A A ENVIAR TRUE SI HAY REGLAS ASOCIADAS DE PALABRAS, PUNTUACION O ACENTUACION
            //ESTO SIRVE PARA QUE EN LA VISTA DE MUESTREN LAS SECCIONES SOLO SI HAY REGLAS DE ESE TIPO ASOCIADAS
            
            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 1 CATEGORIES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasencategories = false;
            $hayacentuacionencategories = false;
            $haypuntuacionencategories = false;

            for($a=0; $a<count($questionType->categories); $a++){

                if($questionType->categories[$a]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionencategories = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 2 SECTIONS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasensections = false;
            $hayacentuacionensections = false;
            $haypuntuacionensections = false;

            for($b=0; $b<count($questionType->sections); $b++){

                if($questionType->sections[$b]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionensections = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 3 POSTS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenposts = false;
            $hayacentuacionenposts = false;
            $haypuntuacionenposts = false;

            for($c=0; $c<count($questionType->posts); $c++){

                if($questionType->posts[$c]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenposts = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 4 RULES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenrules = false;
            $hayacentuacionenrules = false;
            $haypuntuacionenrules = false;

            for($d=0; $d<count($questionType->rules); $d++){

                if($questionType->rules[$d]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenrules = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 5 NOTES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasennotes = false;
            $hayacentuacionennotes = false;
            $haypuntuacionennotes = false;

            for($e=0; $e<count($questionType->notes); $e++){

                if($questionType->notes[$e]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionennotes = true;
                }
            }


            

            
            //return view('rules.estudiante.displayresults.displayja', compact('questionType', 'resultUser', 'sumaresultados', 'answerCorrecta', 'userId', 'evaluationId'));

            return view('rules.estudiante.displayresults.displayja', compact('questionType', 'resultUser', 'sumaresultados', 'answerCorrecta', 'userId', 'evaluationId'
                        , 'haypalabrasencategories', 'hayacentuacionencategories', 'haypuntuacionencategories', 'haypalabrasensections', 'hayacentuacionensections', 'haypuntuacionensections'
                        , 'haypalabrasenposts', 'hayacentuacionenposts', 'haypuntuacionenposts', 'haypalabrasenrules', 'hayacentuacionenrules', 'haypuntuacionenrules'
                        , 'haypalabrasennotes', 'hayacentuacionennotes', 'haypuntuacionennotes'));
        }
        elseif(($questionType->type) === "SL"){

            //CAPTURAR LAS RESPUESTAS DEL USUARIO A LA QUESTION SL MEDIANTE EL USER ID Y EVALUATION ID Y SE CREA UN ARRAY CON LOS IDS DE LOS RESULTADOS
            $answerUser = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->pluck('id')->toArray();

            //GUARDAR LAS RESPUESTAS DEL USUARIO EN UN ARRAY PALABRA ENVIARLAS A LA VISTA
            //$coleccionResults = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->get();
            //ACTUALIZACION
            //EN COLECCION RESULTS SE AGREGA EL METODO PARA QUE SOLO CAPTURE LAS RESPUESTAS QUE TIENEN 0.10 ES DECIR SOLO LAS PALABRAS QUE ENCONTRO EN LA SOPA
            $coleccionResults = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->where('score', 0.10)->get();


            //CAPTURAR EL PUNTAJE QUE TIENE EL ESTUDIANTE EN LA PREGUNTA ACTUAL
            $resultados = DB::table('results')->where('question_id', $questionId)->where('user_id', $userId)->pluck('score')->toArray();
            $sumaresultados = array_sum($resultados);

            //GUARDAR LAS ANSWERS CORRECTAS EN UN ARRAY PARA ENVIARLAS A LA VISTA
            //$coleccionCorrectas = Answer::where('question_id', $questionId)->where('is_correct', true)->get();
            //ACTUALIZACION
            //COMO AHORA SON UN BANCO DE 30 PALABRAS, SE DEBE CAPTURAR LAS 10 PALABRAS RANDOM QUE SE LE ASIGNARON AL USUARIO ACTUAL
            //ENTONCES EN LA VARIABLE $idsAnswersUser SE GUARDAN LOS IDS DE CADA ANSWER QUE EL USUARIO RESPONDIO, LOS IDS SE CAPTURAN DESDE LA TABLA RESULTS
            //PARA LUEGO CON ESOS IDS, BUSCAR EN LA TABLA ANSWERS LAS RESPUESTAS CORRECTAS
            $idsAnswersUser = Result::where('evaluation_id', $evaluationId)->where('question_id', $questionId)->where('user_id', $userId)->pluck('answer_id')->toArray();
            $coleccionCorrectas = Answer::where('question_id', $questionId)->where('is_correct', true)->whereIn('id', $idsAnswersUser)->get();


            

            //ENVIAR EL RESULTADO DE CUANTAS PALABRAS HA ENCONTRADO 
            $respuesta = count($coleccionResults);



            //ACTUALIZACION
            //PARA MOSTRAR LAS REGLAS ORTOGRAFICAS ASOCIADAS A LA PREGUNTA CLASIFICADAS POR PALABRAS, PUNTUACION Y ACENTUACION
            //SE DECLARA TRES VARIABLES QUE VAN A A ENVIAR TRUE SI HAY REGLAS ASOCIADAS DE PALABRAS, PUNTUACION O ACENTUACION
            //ESTO SIRVE PARA QUE EN LA VISTA DE MUESTREN LAS SECCIONES SOLO SI HAY REGLAS DE ESE TIPO ASOCIADAS
            
            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 1 CATEGORIES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasencategories = false;
            $hayacentuacionencategories = false;
            $haypuntuacionencategories = false;

            for($a=0; $a<count($questionType->categories); $a++){

                if($questionType->categories[$a]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionencategories = true;
                }
                elseif($questionType->categories[$a]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionencategories = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 2 SECTIONS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasensections = false;
            $hayacentuacionensections = false;
            $haypuntuacionensections = false;

            for($b=0; $b<count($questionType->sections); $b++){

                if($questionType->sections[$b]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionensections = true;
                }
                elseif($questionType->sections[$b]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionensections = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 3 POSTS ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenposts = false;
            $hayacentuacionenposts = false;
            $haypuntuacionenposts = false;

            for($c=0; $c<count($questionType->posts); $c++){

                if($questionType->posts[$c]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenposts = true;
                }
                elseif($questionType->posts[$c]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenposts = true;
                }
            }


            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 4 RULES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasenrules = false;
            $hayacentuacionenrules = false;
            $haypuntuacionenrules = false;

            for($d=0; $d<count($questionType->rules); $d++){

                if($questionType->rules[$d]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionenrules = true;
                }
                elseif($questionType->rules[$d]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionenrules = true;
                }
            }

            //COMPROBAR SI HAY REGLAS ORTOGRAFICAS DE PALABRAS, ACENTUACION O PUNTUACION DE NIVEL 5 NOTES ASOCIADAS A ESTA PREGUNTA
            $haypalabrasennotes = false;
            $hayacentuacionennotes = false;
            $haypuntuacionennotes = false;

            for($e=0; $e<count($questionType->notes); $e++){

                if($questionType->notes[$e]->type === "Reglas ortográficas de palabras"){
                    $haypalabrasennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de acentuación"){
                    $hayacentuacionennotes = true;
                }
                elseif($questionType->notes[$e]->type === "Reglas ortográficas de puntuación"){
                    $haypuntuacionennotes = true;
                }
            }


            


            //return view('rules.estudiante.displayresults.displaysl', compact('questionType', 'sumaresultados', 'coleccionResults', 'coleccionCorrectas', 'userId', 'evaluationId', 'respuesta'));


            return view('rules.estudiante.displayresults.displaysl', compact('questionType', 'sumaresultados', 'coleccionResults', 'coleccionCorrectas', 'userId', 'evaluationId', 'respuesta'
                        , 'haypalabrasencategories', 'hayacentuacionencategories', 'haypuntuacionencategories', 'haypalabrasensections', 'hayacentuacionensections', 'haypuntuacionensections'
                        , 'haypalabrasenposts', 'hayacentuacionenposts', 'haypuntuacionenposts', 'haypalabrasenrules', 'hayacentuacionenrules', 'haypuntuacionenrules'
                        , 'haypalabrasennotes', 'hayacentuacionennotes', 'haypuntuacionennotes'));
        }

        return $questionType;

    }


    
}
