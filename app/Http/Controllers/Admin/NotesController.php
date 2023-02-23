<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Result;
//LIBRERIAS PARA PAGINACION
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class NotesController extends Controller
{

    //FUNCION PARA PAGINAR ARRAYS
    public function paginate($items, $perPage = 10, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow ,$total ,$perPage);
    }


    //INGRESAR A LA VISTA DE LISTADO DE NOTAS DE DIAGNOSTICO
    public function viewNotesDiagnostic(){

        //CAPTURAR EL LISTADO DE TODOS LOS USUARIOS MENOS EL USUARIO CON ID 1 = ADMIN
        $users = User::all();

        //return $users[1];

        //CREAR UN NUEVO ARRAY QUE CONTENDRA EL NOMBRE DEL USUARIO, EL NOMBRE DE LA EVALUACION DE DIAGNOSTICO, Y LA NOTA QUE TIENE EN LA EVALUACION
        $arrayNotasDiagnostico = [];
        //CREAR UN NUEVO ARRAY QUE VA A CAPTURAR LOS CAMPOS NOMBREESTUDIANTE, NOTA Y NOMBRE EVALUACION DE CADA USUARIO
        $arrayPrueba = [];

        //$arrayPrueba = [
        //    'Estudiante' => $users[0]->name,
        //    'Nota' => 10,
        //    'Nombre evaluación' => 'Prueba de diagnostico'
        //];

        //return $arrayNotasDiagnostico['Nota'];

        //array_push($arrayNotasDiagnostico, $arrayPrueba);

        //$arrayPrueba = [
        //    'Estudiante' => $users[1]->name,
        //    'Nota' => 8,
        //    'Nombre evaluación' => 'Prueba de diagnostico dos'
        //];

        //array_push($arrayNotasDiagnostico, $arrayPrueba);

        //CON UN FOR SE RECORRE LA COLECCION DE TODOS LOS USUARIOS Y SE CAPTURA EL NOMBRE DE LA EVALUACION DE DIAGNOSTICO ASIGNADA
        //Y LA NOTA QUE TIENE EL USUARIO EN ESA EVALUACION
        for($i=0; $i<count($users);$i++){

            //ENCONTRAR LA EVALUACION DE DIAGNOSTICO ASIGNADA AL ESTUDIANTE ACTUAL

            //EN LA VARIABLE ASIGNEDEVALUATIONSID SE VA A TOMAR SOLO EL CAMPO EVALUATION_ID DE LA TABLA INTERMEDIA EVALUATION_USER DE LOS
            //EXAMENES QUE ESTEN ASIGNADOS AL USUARIO ACTUAL
            $assignedEvaluationsId = DB::table('evaluation_user')->where('user_id', $users[$i]->id)->pluck('evaluation_id')->toArray();
            //EN LA VARIABLE EVALUATIONS SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE DIAGNOSTICO ASIGNADA AL ESTUDIANTE ACTUAL QUE SE ENCUENTRA EN 
            //LA TABLA EVALUATIONS
            $evaluationsDiagnostic = Evaluation::whereIn('id', $assignedEvaluationsId)->where('type', "D")->get(); 
            //EN LA VARIABLE DIAGNOSTICO SE CAPTURA EL PRIMER ELEMENTO DE LA COLECCION DE EVALUATIONS DIAGNOSTIC
            $diagnostico = $evaluationsDiagnostic->first();
            //EN LA VARIABLE EXISTEDIAGNOSTICO SE VA A COMPROBAR SI EXISTE UNA PRUEBA DE DIAGNOSTICO ASIGNADA AL USUARIO ACTUAL
            $existeDiagnostico = DB::table('evaluations')->whereIn('id', $assignedEvaluationsId)->where('type', "D")->exists();
            //EN LA VARIABLE RESULTADOEVALUACION SE VA A ENVIAR EL NOMBRE DE LA EVALUACION O UNA CADENA DE TEXTO SI EL USUARIO
            //NO TIENE EVALUACION DE DIAGNOSTICO ASIGNADA
            $resultadoEvaluacion = "";
            //SI LA VARIABLE EXISTEDIAGNOSTICO ES TRUE SIGNIFICA QUE EL USUARIO TIENE UNA PRUEBA DE DIAGNOSTICO ASIGNADA
            //ENTONCES SE ENVIA EL NOMBRE DE LA EVALUACION, PERO SI NO TIENE EVALUACION DE DIAGNOSTICO ASIGNADA SE ENVIA LA CADENA NO TIENE EVALUACION
            if($existeDiagnostico === true){
                $resultadoEvaluacion = $diagnostico->name;
            }else{
                $resultadoEvaluacion = "No tiene evaluación de diagnóstico asignada";
            }


            //CALCULAR LA NOTA DEL USUARIO DE LA EVALUACION DE DIAGNOSTICO 

            //PRIMERO SE DECLARA LA VARIABLE NOTAFINAL QUE ES LA VARIABLE QUE SE VA A PASAR AL ARRAY
            $notaFinalDiagnostico = 0;

            //SE COLOCA UN IF PARA QUE SI LA VARIABLE EXISTE DIAGNOSTICO ES TRUE ENTONCES CALCULE LA NOTA DE LA EVALUACION DE DIAGNOSTICO
            //PERO SI ES FALSE, ENTONCES QUE LA NOTA SEA CERO
            if($existeDiagnostico === true){
                
                //EN LA VARIABLE EXISTEN RESPUESTAS DIAGNOSTICO SE VA A VERIFICAR SI EN LA TABLA RESULTS, EXISTEN REGISTRO QUE TENGAN
                //EL USER_ID DEL USUARIO ACTUAL Y LA EVALUATION_ID DE LA EVALUACION DE DIAGNOSTICO ACTUAL
                $existenRespuestasDiagnostico = DB::table('results')->where('evaluation_id', $diagnostico->id)->where('user_id', $users[$i]->id)->exists();
                //CON EL IF SE PREGUNTA SI LA VARIABLE EXISTENRESPUESTASDIAGNOSTICO ES TRUE, LO QUE SIGNIFICA QUE HAY RESPUESTAS DEL USUARIO A LA 
                //EVALUACION DE DIAGNOSTICO ASIGNADA, PERO SI ES FALSE ENTONCES SE ENVIA COMO NOTAFINAL = 0;
                if($existenRespuestasDiagnostico === true){
                    //CALCULAR EL PUNTAJE DEL USUARIO A LA EVALUACION DE DIAGNOSTICO

                    //EN LA VARIABLE PUNTAJES SE CAPTURA LA COLECCION DE RESPUESTAS DE LA TABLA RESULTS, SOLO EL CAMPO SCORE
                    $puntajes = Result::where('user_id', $users[$i]->id)->where('evaluation_id', $diagnostico->id)->pluck('score')->toArray();
                    //EN LA VARIABLE NOTA FINAL SE SUMA LOS PUNTAJES OBTENIDOS DE LA TABLA RESULTS DE LA EVALUACION DE DIAGNOSTICO ACTAL
                    $notaFinalDiagnostico = array_sum($puntajes);

                }else{
                    $notaFinalDiagnostico = 0;
                }
            }
            else{
                $notaFinalDiagnostico = 0;
            }
            

            $arrayPrueba = [
                'Estudiante' => $users[$i]->name,
                //AGREGAR CAMPO CORREO ELECTRONICO
                'Correo' => $users[$i]->email,
                'Evaluacion' => $resultadoEvaluacion,
                'Nota' => $notaFinalDiagnostico,
                
            ];
            array_push($arrayNotasDiagnostico, $arrayPrueba);

        }

        
        //CONVERTIR ARRAY PARA PAGINACION
        //EN LOS ARGUMENTOS VA EL ARRAY DE DATOS Y CUANTOS DATOS QUIERO QUE SE MUESTREN POR PAGINA
        $coleccionNotasDiagnostico = $this->paginate($arrayNotasDiagnostico, 10);
        //VARIABLE PARA QUE MUESTRE LAS DEMAS PAGINAS DE LA TABLA PORQUE SINO SOLO MUESTRA UNA
        $coleccionNotasDiagnostico->withPath('');
        

        return view('admin.notes.notesdiagnostic', compact('arrayNotasDiagnostico', 'coleccionNotasDiagnostico'));


    }

    




    //INGRESAR A LA VISTA DE LISTADO DE NOTAS DE EVALUACION DE PRACTICA UNO
    public function viewNotesOne(){

        //CAPTURAR EL LISTADO DE TODOS LOS USUARIO
        $users = User::all();

        //CREAR UN NUEVO ARRAY QUE CONTENDRA EL NOMBRE DEL USUARIO, EL NOMBRE DE LA EVALUACION DE PRACTICA UNO Y LA NOTA A LA EVALUACION
        $arrayNotasPracticaUno = [];
        //CREAR UN NUEVO ARRAY QUE VA A CAPTURAR LOS CAMPOS NOMBRE ESTUDIANTE, NOMBRE EVALUACION Y NOTA EVALUACION
        $arrayPrueba = [];


        //$assignedEvaluationsId = DB::table('evaluation_user')->where('user_id', $users[16]->id)->pluck('evaluation_id')->toArray();
        //$evaluationsPracticeOne = Evaluation::whereIn('id', $assignedEvaluationsId)->where('type', "PU")->get();
        //$practicauno = $evaluationsPracticeOne->first();
        //return $practicauno;

        //CON UN FOR SE RECORRE LA COLECCION DE TODOS LOS USUARIOS Y SE CAPTURAR EL NOMBRE DE LA EVALUACION DE PRACTICA UNO ASIGNADA
        //Y LA NOTA QUE TIENE EL USUARIO EN ESA EVALUACION 
        for($i=0; $i<count($users); $i++){

            //ENCONTRAR LA EVALUACION DE PRACTICA UNO ASIGNADA AL ESTUDIANTE ACTUAL

            //EN LA VARIABLE ASSIGNEDEVALUATIONSID SE VA A TOMAR SOLO EL CAMPO EVALUATION_ID DE LA TABLA INTERMEDIA EVALUATION_USER DE LOS
            //EXAMENES ASIGNADOS AL USUARIO ACTUAL
            $assignedEvaluationsId = DB::table('evaluation_user')->where('user_id', $users[$i]->id)->pluck('evaluation_id')->toArray();
            //EN LA VARIABLE EVALUATIONSPRACTICE SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA UNO ASIGNADA AL ESTUDIANTE ACTUAL QUE SE
            //ENCUENTRA EN LA TABLA EVALUATIONS
            $evaluationsPracticeOne = Evaluation::whereIn('id', $assignedEvaluationsId)->where('type', "PU")->get();
            //EN LA VARIABLE EVALUATIONS SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA UNO ASIGNADA AL USUARIO ACTUAL
            $practicauno = $evaluationsPracticeOne->first();
            //EN LA VARIABLE EXISTEPRACTICAUNO SE VA A COMPROBAR SI EXISTE UNA PRUEBA DE PRACTICA UNO ASIGNADA AL USUARIO
            $existePracticaUno = DB::table('evaluations')->whereIn('id', $assignedEvaluationsId)->where('type', "PU")->exists();
            //EN LA VARIABLE RESULTADOEVALUACION SE VA A ENVIAR EL NOMBRE DE LA EVALUACION O UNA CADENA DE TEXTO SI EL USUARIO
            //NO TIENE EVALUACION DE DIAGNOSTICO ASIGNADA
            $resultadoEvaluacion = "";
            //SI LA VARIABLE EXISTEPRACTICAUNO ES TRUE SIGNIFICA QUE EL USUARIO TIENE UNA PRUEBA DE PRACTICA UNO ASIGNADA
            //ENTONCES SE ENVIA EL NOMBRE DE LA EVALUACION, PERO SI NO TIENE EVALUACION DE PRACTICA UNO ASIGNADA SE ENVIA LA CADENA NO TIENE EVALUACION
            if($existePracticaUno === true){
                $resultadoEvaluacion = $practicauno->name;
            }else{
                $resultadoEvaluacion = "No tiene evaluación de práctica uno asignada";
            }


            //CALCULAR LA NOTA DEL USUARIO DE LA EVALUACION DE PRACTICA UNO 

            //PRIMERO SE DECLARA LA VARIABLE NOTAFINAL QUE ES LA VARIABLE QUE SE VA A PASAR AL ARRAY
            $notaFinalPracticaUno = 0;

            //SE COLOCA UN IF PARA QUE SI LA VARIABLE EXISTE PRACTICA UNO ES TRUE ENTONCES CALCULE LA NOTA DE LA EVALUACION DE PRACTICA UNO
            //PERO SI ES FALSE, ENTONCES QUE LA NOTA SEA CERO
            if($existePracticaUno === true){
                
                //EN LA VARIABLE EXISTEN RESPUESTAS PRACTICA UNO SE VA A VERIFICAR SI EN LA TABLA RESULTS, EXISTEN REGISTRO QUE TENGAN
                //EL USER_ID DEL USUARIO ACTUAL Y LA EVALUATION_ID DE LA EVALUACION DE PRACTICA UNO ACTUAL
                $existenRespuestasPracticaUno = DB::table('results')->where('evaluation_id', $practicauno->id)->where('user_id', $users[$i]->id)->exists();
                //CON EL IF SE PREGUNTA SI LA VARIABLE EXISTENRESPUESTASPRACTICAUNO ES TRUE, LO QUE SIGNIFICA QUE HAY RESPUESTAS DEL USUARIO A LA 
                //EVALUACION DE PRACTICAUNO ASIGNADA, PERO SI ES FALSE ENTONCES SE ENVIA COMO NOTAFINAL = 0;
                if($existenRespuestasPracticaUno === true){
                    //CALCULAR EL PUNTAJE DEL USUARIO A LA EVALUACION DE PRACTICA UNO

                    //EN LA VARIABLE PUNTAJES SE CAPTURA LA COLECCION DE RESPUESTAS DE LA TABLA RESULTS, SOLO EL CAMPO SCORE
                    $puntajes = Result::where('user_id', $users[$i]->id)->where('evaluation_id', $practicauno->id)->pluck('score')->toArray();
                    //EN LA VARIABLE NOTA FINAL SE SUMA LOS PUNTAJES OBTENIDOS DE LA TABLA RESULTS DE LA EVALUACION DE DIAGNOSTICO ACTAL
                    $notaFinalPracticaUno = array_sum($puntajes);

                }else{
                    $notaFinalPracticaUno = 0;
                }
            }
            else{
                $notaFinalPracticaUno = 0;
            }


            $arrayPrueba = [
                'Estudiante' => $users[$i]->name,
                //AGREGAR CAMPO CORREO ELECTRONICO
                'Correo' => $users[$i]->email,
                'Evaluacion' => $resultadoEvaluacion,
                'Nota' => $notaFinalPracticaUno,
                
            ];
            array_push($arrayNotasPracticaUno, $arrayPrueba);

        }



        //CONVERTIR ARRAY PARA PAGINACION
        //EN LOS ARGUMENTOS VA EL ARRAY DE DATOS Y CUANTOS DATOS QUIERO QUE SE MUESTREN POR PAGINA
        $coleccionNotasPracticaUno = $this->paginate($arrayNotasPracticaUno, 10);
        //VARIABLE PARA QUE MUESTRE LAS DEMAS PAGINAS DE LA TABLA PORQUE SINO SOLO MUESTRA UNA
        $coleccionNotasPracticaUno->withPath('');

        
        return view('admin.notes.notespracticeone', compact('arrayNotasPracticaUno', 'coleccionNotasPracticaUno'));
    }





    //INGRESAR A LA VISTA DE LISTADO DE NOTAS DE EVALUACION DE PRACTICA DOS
    public function viewNotesTwo(){

        //CAPTURAR EL LISTADO DE TODOS LOS USUARIOS
        $users = User::all();

        //CREAR UN NUEVO ARRAY QUE CONTENDRA EL NOMBRE DEL USUARIO, EL NOMBRE DE LA EVALUACION DE PRACTICA DOS Y LA NOTA A LA EVALUACION
        $arrayNotasPracticaDos = [];
        //CREAR UN NUEVO ARRAY QUE VA A CAPTURAR LOS CAMPOS NOMBRE ESTUDIANTE, NOMBRE EVALUACION Y NOTA EVALUACION
        $arrayPrueba = [];


        //$assignedEvaluationsId = DB::table('evaluation_user')->where('user_id', $users[16]->id)->pluck('evaluation_id')->toArray();
        //$evaluationsPracticeOne = Evaluation::whereIn('id', $assignedEvaluationsId)->where('type', "PU")->get();
        //$practicauno = $evaluationsPracticeOne->first();
        //return $practicauno;

        //CON UN FOR SE RECORRE LA COLECCION DE TODOS LOS USUARIOS Y SE CAPTURAR EL NOMBRE DE LA EVALUACION DE PRACTICA DOS ASIGNADA
        //Y LA NOTA QUE TIENE EL USUARIO EN ESA EVALUACION 
        for($i=0; $i<count($users); $i++){

            //ENCONTRAR LA EVALUACION DE PRACTICA DOS ASIGNADA AL ESTUDIANTE ACTUAL

            //EN LA VARIABLE ASSIGNEDEVALUATIONSID SE VA A TOMAR SOLO EL CAMPO EVALUATION_ID DE LA TABLA INTERMEDIA EVALUATION_USER DE LOS
            //EXAMENES ASIGNADOS AL USUARIO ACTUAL
            $assignedEvaluationsId = DB::table('evaluation_user')->where('user_id', $users[$i]->id)->pluck('evaluation_id')->toArray();
            //EN LA VARIABLE EVALUATIONSPRACTICE SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA DOS ASIGNADA AL ESTUDIANTE ACTUAL QUE SE
            //ENCUENTRA EN LA TABLA EVALUATIONS
            $evaluationsPracticeTwo = Evaluation::whereIn('id', $assignedEvaluationsId)->where('type', "PD")->get();
            //EN LA VARIABLE EVALUATIONS SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA DOS ASIGNADA AL USUARIO ACTUAL
            $practicados = $evaluationsPracticeTwo->first();
            //EN LA VARIABLE EXISTEPRACTICADOS SE VA A COMPROBAR SI EXISTE UNA PRUEBA DE PRACTICA DOS ASIGNADA AL USUARIO
            $existePracticaDos = DB::table('evaluations')->whereIn('id', $assignedEvaluationsId)->where('type', "PD")->exists();
            //EN LA VARIABLE RESULTADOEVALUACION SE VA A ENVIAR EL NOMBRE DE LA EVALUACION O UNA CADENA DE TEXTO SI EL USUARIO
            //NO TIENE EVALUACION DE DIAGNOSTICO ASIGNADA
            $resultadoEvaluacion = "";
            //SI LA VARIABLE EXISTEPRACTICADOS ES TRUE SIGNIFICA QUE EL USUARIO TIENE UNA PRUEBA DE PRACTICA DOS ASIGNADA
            //ENTONCES SE ENVIA EL NOMBRE DE LA EVALUACION, PERO SI NO TIENE EVALUACION DE PRACTICA DOS ASIGNADA SE ENVIA LA CADENA NO TIENE EVALUACION
            if($existePracticaDos === true){
                $resultadoEvaluacion = $practicados->name;
            }else{
                $resultadoEvaluacion = "No tiene evaluación de práctica dos asignada";
            }


            //CALCULAR LA NOTA DEL USUARIO DE LA EVALUACION DE PRACTICA DOS

            //PRIMERO SE DECLARA LA VARIABLE NOTAFINAL QUE ES LA VARIABLE QUE SE VA A PASAR AL ARRAY
            $notaFinalPracticaDos = 0;

            //SE COLOCA UN IF PARA QUE SI LA VARIABLE EXISTE PRACTICA DOS ES TRUE ENTONCES CALCULE LA NOTA DE LA EVALUACION DE PRACTICA DOS
            //PERO SI ES FALSE, ENTONCES QUE LA NOTA SEA CERO
            if($existePracticaDos === true){
                
                //EN LA VARIABLE EXISTEN RESPUESTAS PRACTICA DOS SE VA A VERIFICAR SI EN LA TABLA RESULTS, EXISTEN REGISTRO QUE TENGAN
                //EL USER_ID DEL USUARIO ACTUAL Y LA EVALUATION_ID DE LA EVALUACION DE PRACTICA DOS ACTUAL
                $existenRespuestasPracticaDos = DB::table('results')->where('evaluation_id', $practicados->id)->where('user_id', $users[$i]->id)->exists();
                //CON EL IF SE PREGUNTA SI LA VARIABLE EXISTENRESPUESTASPRACTICADOS ES TRUE, LO QUE SIGNIFICA QUE HAY RESPUESTAS DEL USUARIO A LA 
                //EVALUACION DE PRACTICADOS ASIGNADA, PERO SI ES FALSE ENTONCES SE ENVIA COMO NOTAFINAL = 0;
                if($existenRespuestasPracticaDos === true){
                    //CALCULAR EL PUNTAJE DEL USUARIO A LA EVALUACION DE PRACTICA DOS

                    //EN LA VARIABLE PUNTAJES SE CAPTURA LA COLECCION DE RESPUESTAS DE LA TABLA RESULTS, SOLO EL CAMPO SCORE
                    $puntajes = Result::where('user_id', $users[$i]->id)->where('evaluation_id', $practicados->id)->pluck('score')->toArray();
                    //EN LA VARIABLE NOTA FINAL SE SUMA LOS PUNTAJES OBTENIDOS DE LA TABLA RESULTS DE LA EVALUACION DE DIAGNOSTICO ACTAL
                    $notaFinalPracticaDos = array_sum($puntajes);

                }else{
                    $notaFinalPracticaDos = 0;
                }
            }
            else{
                $notaFinalPracticaDos = 0;
            }


            $arrayPrueba = [
                'Estudiante' => $users[$i]->name,
                //AGREGAR CAMPO CORREO ELECTRONICO
                'Correo' => $users[$i]->email,
                'Evaluacion' => $resultadoEvaluacion,
                'Nota' => $notaFinalPracticaDos,
                
            ];
            array_push($arrayNotasPracticaDos, $arrayPrueba);

        }


        //CONVERTIR ARRAY PARA PAGINACION
        //EN LOS ARGUMENTOS VA EL ARRAY DE DATOS Y CUANTOS DATOS QUIERO QUE SE MUESTREN POR PAGINA
        $coleccionNotasPracticaDos = $this->paginate($arrayNotasPracticaDos, 10);
        //VARIABLE PARA QUE MUESTRE LAS DEMAS PAGINAS DE LA TABLA PORQUE SINO SOLO MUESTRA UNA
        $coleccionNotasPracticaDos->withPath('');

        
        return view('admin.notes.notespracticetwo', compact('arrayNotasPracticaDos', 'coleccionNotasPracticaDos'));

    }


    //INGRESAR A LA VISTA DE LISTADO DE NOTAS DE EVALUACION PRACTICA TRES
    public function viewNotesThree(){

        //CAPTURAR EL LISTADO DE TODOS LOS USUARIOS
        $users = User::all();

        //CREAR UN NUEVO ARRAY QUE CONTENDRA EL NOMBRE DEL USUARIO, EL NOMBRE DE LA EVALUACION DE PRACTICA TRES Y LA NOTA A LA EVALUACION
        $arrayNotasPracticaTres = [];
        //CREAR UN NUEVO ARRAY QUE VA A CAPTURAR LOS CAMPOS NOMBRE ESTUDIANTE, NOMBRE EVALUACION Y NOTA EVALUACION
        $arrayPrueba = [];


        //$assignedEvaluationsId = DB::table('evaluation_user')->where('user_id', $users[16]->id)->pluck('evaluation_id')->toArray();
        //$evaluationsPracticeOne = Evaluation::whereIn('id', $assignedEvaluationsId)->where('type', "PU")->get();
        //$practicauno = $evaluationsPracticeOne->first();
        //return $practicauno;

        //CON UN FOR SE RECORRE LA COLECCION DE TODOS LOS USUARIOS Y SE CAPTURAR EL NOMBRE DE LA EVALUACION DE PRACTICA TRES ASIGNADA
        //Y LA NOTA QUE TIENE EL USUARIO EN ESA EVALUACION 
        for($i=0; $i<count($users); $i++){

            //ENCONTRAR LA EVALUACION DE PRACTICA TRES ASIGNADA AL ESTUDIANTE ACTUAL

            //EN LA VARIABLE ASSIGNEDEVALUATIONSID SE VA A TOMAR SOLO EL CAMPO EVALUATION_ID DE LA TABLA INTERMEDIA EVALUATION_USER DE LOS
            //EXAMENES ASIGNADOS AL USUARIO ACTUAL
            $assignedEvaluationsId = DB::table('evaluation_user')->where('user_id', $users[$i]->id)->pluck('evaluation_id')->toArray();
            //EN LA VARIABLE EVALUATIONSPRACTICE SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA TRES ASIGNADA AL ESTUDIANTE ACTUAL QUE SE
            //ENCUENTRA EN LA TABLA EVALUATIONS
            $evaluationsPracticeThree = Evaluation::whereIn('id', $assignedEvaluationsId)->where('type', "PT")->get();
            //EN LA VARIABLE EVALUATIONS SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA TRES ASIGNADA AL USUARIO ACTUAL
            $practicatres = $evaluationsPracticeThree->first();
            //EN LA VARIABLE EXISTEPRACTICATRES SE VA A COMPROBAR SI EXISTE UNA PRUEBA DE PRACTICA TRES ASIGNADA AL USUARIO
            $existePracticaTres = DB::table('evaluations')->whereIn('id', $assignedEvaluationsId)->where('type', "PT")->exists();
            //EN LA VARIABLE RESULTADOEVALUACION SE VA A ENVIAR EL NOMBRE DE LA EVALUACION O UNA CADENA DE TEXTO SI EL USUARIO
            //NO TIENE EVALUACION DE DIAGNOSTICO ASIGNADA
            $resultadoEvaluacion = "";
            //SI LA VARIABLE EXISTEPRACTICADOS ES TRUE SIGNIFICA QUE EL USUARIO TIENE UNA PRUEBA DE PRACTICA TRES ASIGNADA
            //ENTONCES SE ENVIA EL NOMBRE DE LA EVALUACION, PERO SI NO TIENE EVALUACION DE PRACTICA TRES ASIGNADA SE ENVIA LA CADENA NO TIENE EVALUACION
            if($existePracticaTres === true){
                $resultadoEvaluacion = $practicatres->name;
            }else{
                $resultadoEvaluacion = "No tiene evaluación de práctica tres asignada";
            }


            //CALCULAR LA NOTA DEL USUARIO DE LA EVALUACION DE PRACTICA TRES

            //PRIMERO SE DECLARA LA VARIABLE NOTAFINAL QUE ES LA VARIABLE QUE SE VA A PASAR AL ARRAY
            $notaFinalPracticaTres = 0;

            //SE COLOCA UN IF PARA QUE SI LA VARIABLE EXISTE PRACTICA TRES ES TRUE ENTONCES CALCULE LA NOTA DE LA EVALUACION DE PRACTICA TRES
            //PERO SI ES FALSE, ENTONCES QUE LA NOTA SEA CERO
            if($existePracticaTres === true){
                
                //EN LA VARIABLE EXISTEN RESPUESTAS PRACTICA TRES SE VA A VERIFICAR SI EN LA TABLA RESULTS, EXISTEN REGISTRO QUE TENGAN
                //EL USER_ID DEL USUARIO ACTUAL Y LA EVALUATION_ID DE LA EVALUACION DE PRACTICA TRES ACTUAL
                $existenRespuestasPracticaTres = DB::table('results')->where('evaluation_id', $practicatres->id)->where('user_id', $users[$i]->id)->exists();
                //CON EL IF SE PREGUNTA SI LA VARIABLE EXISTENRESPUESTASPRACTICATRES ES TRUE, LO QUE SIGNIFICA QUE HAY RESPUESTAS DEL USUARIO A LA 
                //EVALUACION DE PRACTICATRES ASIGNADA, PERO SI ES FALSE ENTONCES SE ENVIA COMO NOTAFINAL = 0;
                if($existenRespuestasPracticaTres === true){
                    //CALCULAR EL PUNTAJE DEL USUARIO A LA EVALUACION DE PRACTICA TRES

                    //EN LA VARIABLE PUNTAJES SE CAPTURA LA COLECCION DE RESPUESTAS DE LA TABLA RESULTS, SOLO EL CAMPO SCORE
                    $puntajes = Result::where('user_id', $users[$i]->id)->where('evaluation_id', $practicatres->id)->pluck('score')->toArray();
                    //EN LA VARIABLE NOTA FINAL SE SUMA LOS PUNTAJES OBTENIDOS DE LA TABLA RESULTS DE LA EVALUACION DE DIAGNOSTICO ACTAL
                    $notaFinalPracticaTres = array_sum($puntajes);

                }else{
                    $notaFinalPracticaTres = 0;
                }
            }
            else{
                $notaFinalPracticaTres = 0;
            }


            $arrayPrueba = [
                'Estudiante' => $users[$i]->name,
                //AGREGAR CAMPO CORREO ELECTRONICO
                'Correo' => $users[$i]->email,
                'Evaluacion' => $resultadoEvaluacion,
                'Nota' => $notaFinalPracticaTres,
                
            ];
            array_push($arrayNotasPracticaTres, $arrayPrueba);

        }



         //CONVERTIR ARRAY PARA PAGINACION
        //EN LOS ARGUMENTOS VA EL ARRAY DE DATOS Y CUANTOS DATOS QUIERO QUE SE MUESTREN POR PAGINA
        $coleccionNotasPracticaTres = $this->paginate($arrayNotasPracticaTres, 10);
        //VARIABLE PARA QUE MUESTRE LAS DEMAS PAGINAS DE LA TABLA PORQUE SINO SOLO MUESTRA UNA
        $coleccionNotasPracticaTres->withPath('');
        
        return view('admin.notes.notespracticethree', compact('arrayNotasPracticaTres', 'coleccionNotasPracticaTres'));


    }





    //INGRESAR A LA VISTA DE LISTADO DE NOTAS DE EVALUACION PRACTICA FINAL
    public function viewNotesFinal(){


        //CAPTURAR EL LISTADO DE TODOS LOS USUARIOS
        $users = User::all();

        //CREAR UN NUEVO ARRAY QUE CONTENDRA EL NOMBRE DEL USUARIO, EL NOMBRE DE LA EVALUACION DE PRACTICA FINAL Y LA NOTA A LA EVALUACION
        $arrayNotasPracticaFinal = [];
        //CREAR UN NUEVO ARRAY QUE VA A CAPTURAR LOS CAMPOS NOMBRE ESTUDIANTE, NOMBRE EVALUACION Y NOTA EVALUACION
        $arrayPrueba = [];


        //$assignedEvaluationsId = DB::table('evaluation_user')->where('user_id', $users[16]->id)->pluck('evaluation_id')->toArray();
        //$evaluationsPracticeOne = Evaluation::whereIn('id', $assignedEvaluationsId)->where('type', "PU")->get();
        //$practicauno = $evaluationsPracticeOne->first();
        //return $practicauno;

        //CON UN FOR SE RECORRE LA COLECCION DE TODOS LOS USUARIOS Y SE CAPTURAR EL NOMBRE DE LA EVALUACION DE PRACTICA FINAL ASIGNADA
        //Y LA NOTA QUE TIENE EL USUARIO EN ESA EVALUACION 
        for($i=0; $i<count($users); $i++){

            //ENCONTRAR LA EVALUACION DE PRACTICA FINAL ASIGNADA AL ESTUDIANTE ACTUAL

            //EN LA VARIABLE ASSIGNEDEVALUATIONSID SE VA A TOMAR SOLO EL CAMPO EVALUATION_ID DE LA TABLA INTERMEDIA EVALUATION_USER DE LOS
            //EXAMENES ASIGNADOS AL USUARIO ACTUAL
            $assignedEvaluationsId = DB::table('evaluation_user')->where('user_id', $users[$i]->id)->pluck('evaluation_id')->toArray();
            //EN LA VARIABLE EVALUATIONSPRACTICE SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA FINAL ASIGNADA AL ESTUDIANTE ACTUAL QUE SE
            //ENCUENTRA EN LA TABLA EVALUATIONS
            $evaluationsPracticeFinal = Evaluation::whereIn('id', $assignedEvaluationsId)->where('type', "F")->get();
            //EN LA VARIABLE EVALUATIONS SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA FINAL ASIGNADA AL USUARIO ACTUAL
            $practicafinal = $evaluationsPracticeFinal->first();
            //EN LA VARIABLE EXISTEPRACTICAFINAL SE VA A COMPROBAR SI EXISTE UNA PRUEBA DE PRACTICA FINAL ASIGNADA AL USUARIO
            $existePracticaFinal = DB::table('evaluations')->whereIn('id', $assignedEvaluationsId)->where('type', "F")->exists();
            //EN LA VARIABLE RESULTADOEVALUACION SE VA A ENVIAR EL NOMBRE DE LA EVALUACION O UNA CADENA DE TEXTO SI EL USUARIO
            //NO TIENE EVALUACION DE DIAGNOSTICO ASIGNADA
            $resultadoEvaluacion = "";
            //SI LA VARIABLE EXISTEPRACTICAFINAL ES TRUE SIGNIFICA QUE EL USUARIO TIENE UNA PRUEBA DE PRACTICA FINAL ASIGNADA
            //ENTONCES SE ENVIA EL NOMBRE DE LA EVALUACION, PERO SI NO TIENE EVALUACION DE PRACTICA FINAL ASIGNADA SE ENVIA LA CADENA NO TIENE EVALUACION
            if($existePracticaFinal === true){
                $resultadoEvaluacion = $practicafinal->name;
            }else{
                $resultadoEvaluacion = "No tiene evaluación final asignada";
            }


            //CALCULAR LA NOTA DEL USUARIO DE LA EVALUACION DE PRACTICA FINAL

            //PRIMERO SE DECLARA LA VARIABLE NOTAFINAL QUE ES LA VARIABLE QUE SE VA A PASAR AL ARRAY
            $notaFinalPracticaFinal = 0;

            //SE COLOCA UN IF PARA QUE SI LA VARIABLE EXISTE PRACTICA FINAL ES TRUE ENTONCES CALCULE LA NOTA DE LA EVALUACION DE PRACTICA FINAL
            //PERO SI ES FALSE, ENTONCES QUE LA NOTA SEA CERO
            if($existePracticaFinal === true){
                
                //EN LA VARIABLE EXISTEN RESPUESTAS PRACTICA FINAL SE VA A VERIFICAR SI EN LA TABLA RESULTS, EXISTEN REGISTRO QUE TENGAN
                //EL USER_ID DEL USUARIO ACTUAL Y LA EVALUATION_ID DE LA EVALUACION DE PRACTICA FINAL ACTUAL
                $existenRespuestasPracticaFinal = DB::table('results')->where('evaluation_id', $practicafinal->id)->where('user_id', $users[$i]->id)->exists();
                //CON EL IF SE PREGUNTA SI LA VARIABLE EXISTENRESPUESTASPRACTICAFINAL ES TRUE, LO QUE SIGNIFICA QUE HAY RESPUESTAS DEL USUARIO A LA 
                //EVALUACION DE PRACTICATRES ASIGNADA, PERO SI ES FALSE ENTONCES SE ENVIA COMO NOTAFINAL = 0;
                if($existenRespuestasPracticaFinal === true){
                    //CALCULAR EL PUNTAJE DEL USUARIO A LA EVALUACION DE PRACTICA TRES

                    //EN LA VARIABLE PUNTAJES SE CAPTURA LA COLECCION DE RESPUESTAS DE LA TABLA RESULTS, SOLO EL CAMPO SCORE
                    $puntajes = Result::where('user_id', $users[$i]->id)->where('evaluation_id', $practicafinal->id)->pluck('score')->toArray();
                    //EN LA VARIABLE NOTA FINAL SE SUMA LOS PUNTAJES OBTENIDOS DE LA TABLA RESULTS DE LA EVALUACION DE DIAGNOSTICO ACTAL
                    $notaFinalPracticaFinal = array_sum($puntajes);

                }else{
                    $notaFinalPracticaFinal = 0;
                }
            }
            else{
                $notaFinalPracticaFinal = 0;
            }


            $arrayPrueba = [
                'Estudiante' => $users[$i]->name,
                //AGREGAR CAMPO CORREO ELECTRONICO
                'Correo' => $users[$i]->email,
                'Evaluacion' => $resultadoEvaluacion,
                'Nota' => $notaFinalPracticaFinal,
                
            ];
            array_push($arrayNotasPracticaFinal, $arrayPrueba);

        }


        //CONVERTIR ARRAY PARA PAGINACION
        //EN LOS ARGUMENTOS VA EL ARRAY DE DATOS Y CUANTOS DATOS QUIERO QUE SE MUESTREN POR PAGINA
        $coleccionNotasPracticaFinal = $this->paginate($arrayNotasPracticaFinal, 10);
        //VARIABLE PARA QUE MUESTRE LAS DEMAS PAGINAS DE LA TABLA PORQUE SINO SOLO MUESTRA UNA
        $coleccionNotasPracticaFinal->withPath('');

        
        return view('admin.notes.notesfinal', compact('arrayNotasPracticaFinal', 'coleccionNotasPracticaFinal'));

    }




    //METODO PARA MOSTRAR EN UNA SOLA TABLA TODAS LAS EVALUACIONES DEL USUARIO Y LAS NOTAS DE TODAS LAS EVALUACIONES
    public function viewAllResults(){

        //CAPTURAR EL LISTADO DE TODOS LOS USUARIOS
        $users = User::all();

        //CREAR UN NUEVO ARRAY QUE CONTENDRA EL NOMBRE DEL USUARIO, EL NOMBRE DE TODAS LAS EVALUACIONES Y LAS NOTAS DE TODAS LAS EVALUACIONES
        $arrayNotas = [];
        //CREAR UN NUEVO ARRAY QUE VA A CAPTURAR LOS CAMPOS DE NOMBRE DE LAS EVALUACIONES Y NOTAS DE TODAS LAS EVALUACIONES
        $arrayPrueba = [];


        //CON UN FOR SE RECORRE LA COLECCION DE TODOS LOS USUARIOS Y SE CAPTURA EL NOMBRE DE LA EVALUACION DE DIAGNOSTICO ASIGNADA
        //Y LA NOTA QUE TIENE EL USUARIO EN ESA EVALUACION
        for($i=0; $i<count($users);$i++){

            /////////////////////////////////////////////////ENCONTRAR LA EVALUACION DE DIAGNOSTICO ASIGNADA AL ESTUDIANTE ACTUAL

            //EN LA VARIABLE ASIGNEDEVALUATIONSID SE VA A TOMAR SOLO EL CAMPO EVALUATION_ID DE LA TABLA INTERMEDIA EVALUATION_USER DE LOS
            //EXAMENES QUE ESTEN ASIGNADOS AL USUARIO ACTUAL
            $assignedEvaluationsId = DB::table('evaluation_user')->where('user_id', $users[$i]->id)->pluck('evaluation_id')->toArray();
            //EN LA VARIABLE EVALUATIONS SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE DIAGNOSTICO ASIGNADA AL ESTUDIANTE ACTUAL QUE SE ENCUENTRA EN 
            //LA TABLA EVALUATIONS
            $evaluationsDiagnostic = Evaluation::whereIn('id', $assignedEvaluationsId)->where('type', "D")->get(); 
            //EN LA VARIABLE DIAGNOSTICO SE CAPTURA EL PRIMER ELEMENTO DE LA COLECCION DE EVALUATIONS DIAGNOSTIC
            $diagnostico = $evaluationsDiagnostic->first();
            //EN LA VARIABLE EXISTEDIAGNOSTICO SE VA A COMPROBAR SI EXISTE UNA PRUEBA DE DIAGNOSTICO ASIGNADA AL USUARIO ACTUAL
            $existeDiagnostico = DB::table('evaluations')->whereIn('id', $assignedEvaluationsId)->where('type', "D")->exists();
            //EN LA VARIABLE RESULTADOEVALUACION SE VA A ENVIAR EL NOMBRE DE LA EVALUACION O UNA CADENA DE TEXTO SI EL USUARIO
            //NO TIENE EVALUACION DE DIAGNOSTICO ASIGNADA
            $resultadoEvaluacionDiagnostico = "";
            //SI LA VARIABLE EXISTEDIAGNOSTICO ES TRUE SIGNIFICA QUE EL USUARIO TIENE UNA PRUEBA DE DIAGNOSTICO ASIGNADA
            //ENTONCES SE ENVIA EL NOMBRE DE LA EVALUACION, PERO SI NO TIENE EVALUACION DE DIAGNOSTICO ASIGNADA SE ENVIA LA CADENA NO TIENE EVALUACION
            if($existeDiagnostico === true){
                $resultadoEvaluacionDiagnostico = $diagnostico->name;
            }else{
                $resultadoEvaluacionDiagnostico = "No tiene evaluación de diagnóstico asignada";
            }


            //CALCULAR LA NOTA DEL USUARIO DE LA EVALUACION DE DIAGNOSTICO 

            //PRIMERO SE DECLARA LA VARIABLE NOTAFINAL QUE ES LA VARIABLE QUE SE VA A PASAR AL ARRAY
            $notaFinalDiagnostico = 0;

            //SE COLOCA UN IF PARA QUE SI LA VARIABLE EXISTE DIAGNOSTICO ES TRUE ENTONCES CALCULE LA NOTA DE LA EVALUACION DE DIAGNOSTICO
            //PERO SI ES FALSE, ENTONCES QUE LA NOTA SEA CERO
            if($existeDiagnostico === true){
                
                //EN LA VARIABLE EXISTEN RESPUESTAS DIAGNOSTICO SE VA A VERIFICAR SI EN LA TABLA RESULTS, EXISTEN REGISTRO QUE TENGAN
                //EL USER_ID DEL USUARIO ACTUAL Y LA EVALUATION_ID DE LA EVALUACION DE DIAGNOSTICO ACTUAL
                $existenRespuestasDiagnostico = DB::table('results')->where('evaluation_id', $diagnostico->id)->where('user_id', $users[$i]->id)->exists();
                //CON EL IF SE PREGUNTA SI LA VARIABLE EXISTENRESPUESTASDIAGNOSTICO ES TRUE, LO QUE SIGNIFICA QUE HAY RESPUESTAS DEL USUARIO A LA 
                //EVALUACION DE DIAGNOSTICO ASIGNADA, PERO SI ES FALSE ENTONCES SE ENVIA COMO NOTAFINAL = 0;
                if($existenRespuestasDiagnostico === true){
                    //CALCULAR EL PUNTAJE DEL USUARIO A LA EVALUACION DE DIAGNOSTICO

                    //EN LA VARIABLE PUNTAJES SE CAPTURA LA COLECCION DE RESPUESTAS DE LA TABLA RESULTS, SOLO EL CAMPO SCORE
                    $puntajesdiagnostico = Result::where('user_id', $users[$i]->id)->where('evaluation_id', $diagnostico->id)->pluck('score')->toArray();
                    //EN LA VARIABLE NOTA FINAL SE SUMA LOS PUNTAJES OBTENIDOS DE LA TABLA RESULTS DE LA EVALUACION DE DIAGNOSTICO ACTAL
                    $notaFinalDiagnostico = array_sum($puntajesdiagnostico);

                }else{
                    $notaFinalDiagnostico = 0;
                }
            }
            else{
                $notaFinalDiagnostico = 0;
            }



            ///////////////////////////////ENCONTRAR LA EVALUACION DE PRACTICA UNO ASIGNADA AL ESTUDIANTE ACTUAL

            //EN LA VARIABLE ASSIGNEDEVALUATIONSID SE VA A TOMAR SOLO EL CAMPO EVALUATION_ID DE LA TABLA INTERMEDIA EVALUATION_USER DE LOS
            //EXAMENES ASIGNADOS AL USUARIO ACTUAL
            //$assignedEvaluationsId = DB::table('evaluation_user')->where('user_id', $users[$i]->id)->pluck('evaluation_id')->toArray();
            //EN LA VARIABLE EVALUATIONSPRACTICE SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA UNO ASIGNADA AL ESTUDIANTE ACTUAL QUE SE
            //ENCUENTRA EN LA TABLA EVALUATIONS
            $evaluationsPracticeOne = Evaluation::whereIn('id', $assignedEvaluationsId)->where('type', "PU")->get();
            //EN LA VARIABLE EVALUATIONS SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA UNO ASIGNADA AL USUARIO ACTUAL
            $practicauno = $evaluationsPracticeOne->first();
            //EN LA VARIABLE EXISTEPRACTICAUNO SE VA A COMPROBAR SI EXISTE UNA PRUEBA DE PRACTICA UNO ASIGNADA AL USUARIO
            $existePracticaUno = DB::table('evaluations')->whereIn('id', $assignedEvaluationsId)->where('type', "PU")->exists();
            //EN LA VARIABLE RESULTADOEVALUACION SE VA A ENVIAR EL NOMBRE DE LA EVALUACION O UNA CADENA DE TEXTO SI EL USUARIO
            //NO TIENE EVALUACION DE DIAGNOSTICO ASIGNADA
            $resultadoEvaluacionUno = "";
            //SI LA VARIABLE EXISTEPRACTICAUNO ES TRUE SIGNIFICA QUE EL USUARIO TIENE UNA PRUEBA DE PRACTICA UNO ASIGNADA
            //ENTONCES SE ENVIA EL NOMBRE DE LA EVALUACION, PERO SI NO TIENE EVALUACION DE PRACTICA UNO ASIGNADA SE ENVIA LA CADENA NO TIENE EVALUACION
            if($existePracticaUno === true){
                $resultadoEvaluacionUno = $practicauno->name;
            }else{
                $resultadoEvaluacionUno = "No tiene evaluación de práctica uno asignada";
            }


            //CALCULAR LA NOTA DEL USUARIO DE LA EVALUACION DE PRACTICA UNO 

            //PRIMERO SE DECLARA LA VARIABLE NOTAFINAL QUE ES LA VARIABLE QUE SE VA A PASAR AL ARRAY
            $notaFinalPracticaUno = 0;

            //SE COLOCA UN IF PARA QUE SI LA VARIABLE EXISTE PRACTICA UNO ES TRUE ENTONCES CALCULE LA NOTA DE LA EVALUACION DE PRACTICA UNO
            //PERO SI ES FALSE, ENTONCES QUE LA NOTA SEA CERO
            if($existePracticaUno === true){
                
                //EN LA VARIABLE EXISTEN RESPUESTAS PRACTICA UNO SE VA A VERIFICAR SI EN LA TABLA RESULTS, EXISTEN REGISTRO QUE TENGAN
                //EL USER_ID DEL USUARIO ACTUAL Y LA EVALUATION_ID DE LA EVALUACION DE PRACTICA UNO ACTUAL
                $existenRespuestasPracticaUno = DB::table('results')->where('evaluation_id', $practicauno->id)->where('user_id', $users[$i]->id)->exists();
                //CON EL IF SE PREGUNTA SI LA VARIABLE EXISTENRESPUESTASPRACTICAUNO ES TRUE, LO QUE SIGNIFICA QUE HAY RESPUESTAS DEL USUARIO A LA 
                //EVALUACION DE PRACTICAUNO ASIGNADA, PERO SI ES FALSE ENTONCES SE ENVIA COMO NOTAFINAL = 0;
                if($existenRespuestasPracticaUno === true){
                    //CALCULAR EL PUNTAJE DEL USUARIO A LA EVALUACION DE PRACTICA UNO

                    //EN LA VARIABLE PUNTAJES SE CAPTURA LA COLECCION DE RESPUESTAS DE LA TABLA RESULTS, SOLO EL CAMPO SCORE
                    $puntajesuno = Result::where('user_id', $users[$i]->id)->where('evaluation_id', $practicauno->id)->pluck('score')->toArray();
                    //EN LA VARIABLE NOTA FINAL SE SUMA LOS PUNTAJES OBTENIDOS DE LA TABLA RESULTS DE LA EVALUACION DE DIAGNOSTICO ACTAL
                    $notaFinalPracticaUno = array_sum($puntajesuno);

                }else{
                    $notaFinalPracticaUno = 0;
                }
            }
            else{
                $notaFinalPracticaUno = 0;
            }




            /////////////////////////////////ENCONTRAR LA EVALUACION DE PRACTICA DOS ASIGNADA AL ESTUDIANTE ACTUAL

            //EN LA VARIABLE ASSIGNEDEVALUATIONSID SE VA A TOMAR SOLO EL CAMPO EVALUATION_ID DE LA TABLA INTERMEDIA EVALUATION_USER DE LOS
            //EXAMENES ASIGNADOS AL USUARIO ACTUAL
            //$assignedEvaluationsId = DB::table('evaluation_user')->where('user_id', $users[$i]->id)->pluck('evaluation_id')->toArray();
            //EN LA VARIABLE EVALUATIONSPRACTICE SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA DOS ASIGNADA AL ESTUDIANTE ACTUAL QUE SE
            //ENCUENTRA EN LA TABLA EVALUATIONS
            $evaluationsPracticeTwo = Evaluation::whereIn('id', $assignedEvaluationsId)->where('type', "PD")->get();
            //EN LA VARIABLE EVALUATIONS SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA DOS ASIGNADA AL USUARIO ACTUAL
            $practicados = $evaluationsPracticeTwo->first();
            //EN LA VARIABLE EXISTEPRACTICADOS SE VA A COMPROBAR SI EXISTE UNA PRUEBA DE PRACTICA DOS ASIGNADA AL USUARIO
            $existePracticaDos = DB::table('evaluations')->whereIn('id', $assignedEvaluationsId)->where('type', "PD")->exists();
            //EN LA VARIABLE RESULTADOEVALUACION SE VA A ENVIAR EL NOMBRE DE LA EVALUACION O UNA CADENA DE TEXTO SI EL USUARIO
            //NO TIENE EVALUACION DE DIAGNOSTICO ASIGNADA
            $resultadoEvaluacionDos = "";
            //SI LA VARIABLE EXISTEPRACTICADOS ES TRUE SIGNIFICA QUE EL USUARIO TIENE UNA PRUEBA DE PRACTICA DOS ASIGNADA
            //ENTONCES SE ENVIA EL NOMBRE DE LA EVALUACION, PERO SI NO TIENE EVALUACION DE PRACTICA DOS ASIGNADA SE ENVIA LA CADENA NO TIENE EVALUACION
            if($existePracticaDos === true){
                $resultadoEvaluacionDos = $practicados->name;
            }else{
                $resultadoEvaluacionDos = "No tiene evaluación de práctica dos asignada";
            }


            //CALCULAR LA NOTA DEL USUARIO DE LA EVALUACION DE PRACTICA DOS

            //PRIMERO SE DECLARA LA VARIABLE NOTAFINAL QUE ES LA VARIABLE QUE SE VA A PASAR AL ARRAY
            $notaFinalPracticaDos = 0;

            //SE COLOCA UN IF PARA QUE SI LA VARIABLE EXISTE PRACTICA DOS ES TRUE ENTONCES CALCULE LA NOTA DE LA EVALUACION DE PRACTICA DOS
            //PERO SI ES FALSE, ENTONCES QUE LA NOTA SEA CERO
            if($existePracticaDos === true){
                
                //EN LA VARIABLE EXISTEN RESPUESTAS PRACTICA DOS SE VA A VERIFICAR SI EN LA TABLA RESULTS, EXISTEN REGISTRO QUE TENGAN
                //EL USER_ID DEL USUARIO ACTUAL Y LA EVALUATION_ID DE LA EVALUACION DE PRACTICA DOS ACTUAL
                $existenRespuestasPracticaDos = DB::table('results')->where('evaluation_id', $practicados->id)->where('user_id', $users[$i]->id)->exists();
                //CON EL IF SE PREGUNTA SI LA VARIABLE EXISTENRESPUESTASPRACTICADOS ES TRUE, LO QUE SIGNIFICA QUE HAY RESPUESTAS DEL USUARIO A LA 
                //EVALUACION DE PRACTICADOS ASIGNADA, PERO SI ES FALSE ENTONCES SE ENVIA COMO NOTAFINAL = 0;
                if($existenRespuestasPracticaDos === true){
                    //CALCULAR EL PUNTAJE DEL USUARIO A LA EVALUACION DE PRACTICA DOS

                    //EN LA VARIABLE PUNTAJES SE CAPTURA LA COLECCION DE RESPUESTAS DE LA TABLA RESULTS, SOLO EL CAMPO SCORE
                    $puntajesdos = Result::where('user_id', $users[$i]->id)->where('evaluation_id', $practicados->id)->pluck('score')->toArray();
                    //EN LA VARIABLE NOTA FINAL SE SUMA LOS PUNTAJES OBTENIDOS DE LA TABLA RESULTS DE LA EVALUACION DE DIAGNOSTICO ACTAL
                    $notaFinalPracticaDos = array_sum($puntajesdos);

                }else{
                    $notaFinalPracticaDos = 0;
                }
            }
            else{
                $notaFinalPracticaDos = 0;
            }




             //////////////////////////////////////ENCONTRAR LA EVALUACION DE PRACTICA TRES ASIGNADA AL ESTUDIANTE ACTUAL

            //EN LA VARIABLE ASSIGNEDEVALUATIONSID SE VA A TOMAR SOLO EL CAMPO EVALUATION_ID DE LA TABLA INTERMEDIA EVALUATION_USER DE LOS
            //EXAMENES ASIGNADOS AL USUARIO ACTUAL
            //$assignedEvaluationsId = DB::table('evaluation_user')->where('user_id', $users[$i]->id)->pluck('evaluation_id')->toArray();
            //EN LA VARIABLE EVALUATIONSPRACTICE SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA TRES ASIGNADA AL ESTUDIANTE ACTUAL QUE SE
            //ENCUENTRA EN LA TABLA EVALUATIONS
            $evaluationsPracticeThree = Evaluation::whereIn('id', $assignedEvaluationsId)->where('type', "PT")->get();
            //EN LA VARIABLE EVALUATIONS SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA TRES ASIGNADA AL USUARIO ACTUAL
            $practicatres = $evaluationsPracticeThree->first();
            //EN LA VARIABLE EXISTEPRACTICATRES SE VA A COMPROBAR SI EXISTE UNA PRUEBA DE PRACTICA TRES ASIGNADA AL USUARIO
            $existePracticaTres = DB::table('evaluations')->whereIn('id', $assignedEvaluationsId)->where('type', "PT")->exists();
            //EN LA VARIABLE RESULTADOEVALUACION SE VA A ENVIAR EL NOMBRE DE LA EVALUACION O UNA CADENA DE TEXTO SI EL USUARIO
            //NO TIENE EVALUACION DE DIAGNOSTICO ASIGNADA
            $resultadoEvaluacionTres = "";
            //SI LA VARIABLE EXISTEPRACTICADOS ES TRUE SIGNIFICA QUE EL USUARIO TIENE UNA PRUEBA DE PRACTICA TRES ASIGNADA
            //ENTONCES SE ENVIA EL NOMBRE DE LA EVALUACION, PERO SI NO TIENE EVALUACION DE PRACTICA TRES ASIGNADA SE ENVIA LA CADENA NO TIENE EVALUACION
            if($existePracticaTres === true){
                $resultadoEvaluacionTres = $practicatres->name;
            }else{
                $resultadoEvaluacionTres = "No tiene evaluación de práctica tres asignada";
            }


            //CALCULAR LA NOTA DEL USUARIO DE LA EVALUACION DE PRACTICA TRES

            //PRIMERO SE DECLARA LA VARIABLE NOTAFINAL QUE ES LA VARIABLE QUE SE VA A PASAR AL ARRAY
            $notaFinalPracticaTres = 0;

            //SE COLOCA UN IF PARA QUE SI LA VARIABLE EXISTE PRACTICA TRES ES TRUE ENTONCES CALCULE LA NOTA DE LA EVALUACION DE PRACTICA TRES
            //PERO SI ES FALSE, ENTONCES QUE LA NOTA SEA CERO
            if($existePracticaTres === true){
                
                //EN LA VARIABLE EXISTEN RESPUESTAS PRACTICA TRES SE VA A VERIFICAR SI EN LA TABLA RESULTS, EXISTEN REGISTRO QUE TENGAN
                //EL USER_ID DEL USUARIO ACTUAL Y LA EVALUATION_ID DE LA EVALUACION DE PRACTICA TRES ACTUAL
                $existenRespuestasPracticaTres = DB::table('results')->where('evaluation_id', $practicatres->id)->where('user_id', $users[$i]->id)->exists();
                //CON EL IF SE PREGUNTA SI LA VARIABLE EXISTENRESPUESTASPRACTICATRES ES TRUE, LO QUE SIGNIFICA QUE HAY RESPUESTAS DEL USUARIO A LA 
                //EVALUACION DE PRACTICATRES ASIGNADA, PERO SI ES FALSE ENTONCES SE ENVIA COMO NOTAFINAL = 0;
                if($existenRespuestasPracticaTres === true){
                    //CALCULAR EL PUNTAJE DEL USUARIO A LA EVALUACION DE PRACTICA TRES

                    //EN LA VARIABLE PUNTAJES SE CAPTURA LA COLECCION DE RESPUESTAS DE LA TABLA RESULTS, SOLO EL CAMPO SCORE
                    $puntajestres = Result::where('user_id', $users[$i]->id)->where('evaluation_id', $practicatres->id)->pluck('score')->toArray();
                    //EN LA VARIABLE NOTA FINAL SE SUMA LOS PUNTAJES OBTENIDOS DE LA TABLA RESULTS DE LA EVALUACION DE DIAGNOSTICO ACTAL
                    $notaFinalPracticaTres = array_sum($puntajestres);

                }else{
                    $notaFinalPracticaTres = 0;
                }
            }
            else{
                $notaFinalPracticaTres = 0;
            }




            /////////////////////////////////////////ENCONTRAR LA EVALUACION DE PRACTICA FINAL ASIGNADA AL ESTUDIANTE ACTUAL

            //EN LA VARIABLE ASSIGNEDEVALUATIONSID SE VA A TOMAR SOLO EL CAMPO EVALUATION_ID DE LA TABLA INTERMEDIA EVALUATION_USER DE LOS
            //EXAMENES ASIGNADOS AL USUARIO ACTUAL
            //$assignedEvaluationsId = DB::table('evaluation_user')->where('user_id', $users[$i]->id)->pluck('evaluation_id')->toArray();
            //EN LA VARIABLE EVALUATIONSPRACTICE SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA FINAL ASIGNADA AL ESTUDIANTE ACTUAL QUE SE
            //ENCUENTRA EN LA TABLA EVALUATIONS
            $evaluationsPracticeFinal = Evaluation::whereIn('id', $assignedEvaluationsId)->where('type', "F")->get();
            //EN LA VARIABLE EVALUATIONS SE VA A CAPTURAR EL REGISTRO DE LA PRUEBA DE PRACTICA FINAL ASIGNADA AL USUARIO ACTUAL
            $practicafinal = $evaluationsPracticeFinal->first();
            //EN LA VARIABLE EXISTEPRACTICAFINAL SE VA A COMPROBAR SI EXISTE UNA PRUEBA DE PRACTICA FINAL ASIGNADA AL USUARIO
            $existePracticaFinal = DB::table('evaluations')->whereIn('id', $assignedEvaluationsId)->where('type', "F")->exists();
            //EN LA VARIABLE RESULTADOEVALUACION SE VA A ENVIAR EL NOMBRE DE LA EVALUACION O UNA CADENA DE TEXTO SI EL USUARIO
            //NO TIENE EVALUACION DE DIAGNOSTICO ASIGNADA
            $resultadoEvaluacionFinal = "";
            //SI LA VARIABLE EXISTEPRACTICAFINAL ES TRUE SIGNIFICA QUE EL USUARIO TIENE UNA PRUEBA DE PRACTICA FINAL ASIGNADA
            //ENTONCES SE ENVIA EL NOMBRE DE LA EVALUACION, PERO SI NO TIENE EVALUACION DE PRACTICA FINAL ASIGNADA SE ENVIA LA CADENA NO TIENE EVALUACION
            if($existePracticaFinal === true){
                $resultadoEvaluacionFinal = $practicafinal->name;
            }else{
                $resultadoEvaluacionFinal = "No tiene evaluación final asignada";
            }


            //CALCULAR LA NOTA DEL USUARIO DE LA EVALUACION DE PRACTICA FINAL

            //PRIMERO SE DECLARA LA VARIABLE NOTAFINAL QUE ES LA VARIABLE QUE SE VA A PASAR AL ARRAY
            $notaFinalPracticaFinal = 0;

            //SE COLOCA UN IF PARA QUE SI LA VARIABLE EXISTE PRACTICA FINAL ES TRUE ENTONCES CALCULE LA NOTA DE LA EVALUACION DE PRACTICA FINAL
            //PERO SI ES FALSE, ENTONCES QUE LA NOTA SEA CERO
            if($existePracticaFinal === true){
                
                //EN LA VARIABLE EXISTEN RESPUESTAS PRACTICA FINAL SE VA A VERIFICAR SI EN LA TABLA RESULTS, EXISTEN REGISTRO QUE TENGAN
                //EL USER_ID DEL USUARIO ACTUAL Y LA EVALUATION_ID DE LA EVALUACION DE PRACTICA FINAL ACTUAL
                $existenRespuestasPracticaFinal = DB::table('results')->where('evaluation_id', $practicafinal->id)->where('user_id', $users[$i]->id)->exists();
                //CON EL IF SE PREGUNTA SI LA VARIABLE EXISTENRESPUESTASPRACTICAFINAL ES TRUE, LO QUE SIGNIFICA QUE HAY RESPUESTAS DEL USUARIO A LA 
                //EVALUACION DE PRACTICATRES ASIGNADA, PERO SI ES FALSE ENTONCES SE ENVIA COMO NOTAFINAL = 0;
                if($existenRespuestasPracticaFinal === true){
                    //CALCULAR EL PUNTAJE DEL USUARIO A LA EVALUACION DE PRACTICA TRES

                    //EN LA VARIABLE PUNTAJES SE CAPTURA LA COLECCION DE RESPUESTAS DE LA TABLA RESULTS, SOLO EL CAMPO SCORE
                    $puntajesfinal = Result::where('user_id', $users[$i]->id)->where('evaluation_id', $practicafinal->id)->pluck('score')->toArray();
                    //EN LA VARIABLE NOTA FINAL SE SUMA LOS PUNTAJES OBTENIDOS DE LA TABLA RESULTS DE LA EVALUACION DE DIAGNOSTICO ACTAL
                    $notaFinalPracticaFinal = array_sum($puntajesfinal);

                }else{
                    $notaFinalPracticaFinal = 0;
                }
            }
            else{
                $notaFinalPracticaFinal = 0;
            }


            $arrayPrueba = [
                'Estudiante' => $users[$i]->name,
                'Diagnostico' => $resultadoEvaluacionDiagnostico,
                'NotaDiagnostico' => $notaFinalDiagnostico,
                'Uno' => $resultadoEvaluacionUno,
                'NotaUno' => $notaFinalPracticaUno,
                'Dos' => $resultadoEvaluacionDos,
                'NotaDos' => $notaFinalPracticaDos,
                'Tres' => $resultadoEvaluacionTres,
                'NotaTres' => $notaFinalPracticaTres,
                'Final' => $resultadoEvaluacionFinal,
                'NotaFinal'=> $notaFinalPracticaFinal,

                
            ];
            array_push($arrayNotas, $arrayPrueba);

        }


        //CONVERTIR ARRAY PARA PAGINACION
        //EN LOS ARGUMENTOS VA EL ARRAY DE DATOS Y CUANTOS DATOS QUIERO QUE SE MUESTREN POR PAGINA
        $coleccionNotas = $this->paginate($arrayNotas, 10);
        //VARIABLE PARA QUE MUESTRE LAS DEMAS PAGINAS DE LA TABLA PORQUE SINO SOLO MUESTRA UNA
        $coleccionNotas->withPath('');


        return view('admin.notes.allnotesfinal', compact('arrayNotas', 'coleccionNotas'));

    }

} 
