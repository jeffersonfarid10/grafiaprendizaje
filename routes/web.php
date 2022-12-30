<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AllResultsController;
use App\Http\Controllers\Admin\EvaluationController;
use App\Http\Controllers\Admin\GlossaryController as AdminGlossaryController;
use App\Http\Controllers\Admin\Information\CategoryAcentuationController;
use App\Http\Controllers\Admin\Information\CategoryController;
use App\Http\Controllers\Admin\Information\CategoryPunctuationController;
use App\Http\Controllers\Admin\Information\CategoryWordController;
use App\Http\Controllers\Admin\Information\GlossaryController;
use App\Http\Controllers\Admin\Information\NoteAcentuationController;
use App\Http\Controllers\Admin\Information\NotePunctuationController;
use App\Http\Controllers\Admin\Information\NoteWordController;
use App\Http\Controllers\Admin\Information\PostAcentuationController;
use App\Http\Controllers\Admin\Information\PostPunctuationController;
use App\Http\Controllers\Admin\Information\PostWordController;
use App\Http\Controllers\Admin\Information\RuleAcentuationController;
use App\Http\Controllers\Admin\Information\RulePunctuationController;
use App\Http\Controllers\Admin\Information\RuleWordController;
use App\Http\Controllers\Admin\Information\SectionAcentuationController;
use App\Http\Controllers\Admin\Information\SectionPunctuationController;
use App\Http\Controllers\Admin\Information\SectionWordController;
use App\Http\Controllers\Admin\NotesController;
use App\Http\Controllers\Admin\Question\JuegoController;
use App\Http\Controllers\Admin\Question\OpcionMultipleAController;
use App\Http\Controllers\Admin\Question\OpcionMultipleController;
use App\Http\Controllers\Admin\Question\OpcionMultipleIController;
use App\Http\Controllers\Admin\Question\OracionAudioController;
use App\Http\Controllers\Admin\Question\OracionImagenController;
use App\Http\Controllers\Admin\Question\PalabraCorreccionController;
use App\Http\Controllers\Admin\Question\SopaLetrasController;
use App\Http\Controllers\Admin\Question\TextoAudioController;
use App\Http\Controllers\Admin\Question\TextoImagenController;
use App\Http\Controllers\Admin\ResultsController;
use App\Http\Controllers\Estudiante\EstudianteController;
use App\Http\Controllers\Estudiante\EvaluacionController;
use App\Http\Controllers\Estudiante\RulesLevelFiveController;
use App\Http\Controllers\Estudiante\RulesLevelFourController;
use App\Http\Controllers\Estudiante\RulesLevelOneController;
use App\Http\Controllers\Estudiante\RulesLevelThreeController;
use App\Http\Controllers\Estudiante\RulesLevelTwoController;
use App\Http\Controllers\Estudiante\WelcomeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Runner\ResultCacheExtension;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//RUTAS ORIGINALES PARA EL INICIO DE SESION CON JETSTREAM

//Route::get('/', function () {
//    return view('welcome');
    //return view('layouts.app');
//});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
       
    })->name('dashboard');
});



//NUEVAS RUTAS PARA EL INICIO DE SESION CON JETSTREAM

//RUTA PARA QUE AL LANZAR LA APLICACION ENVIE A LA VISTA DE LOGIN
Route::get('/', function (){
    return view('auth.login');
});

//RUTA PARA QUE AL INICIAR SESION ENVIE A LA VISTA DE WELCOME
//Route::middleware([
//    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified'
//])->group(function () {
//    Route::get('welcome', function () {
//        return view('rules.welcome');
//        
//    })->name('welcome');
//});



//RUTAS PRUEBA

Route::get('welcome', function(){
    return view('rules.welcome');
});

//Route::get('letters', function(){
//    return view('rules.letters');
//});

//Route::get('puntuation', function(){
//    return view('rules.puntuation');
//});

//Route::get('acentuation', function(){
//    return view('rules.acentuation');
//});

//Route::get('practice', function(){
//    return view('rules.practice');
//});

//Route::get('final', function(){
//    return view('rules.final');
//});


///////////////////////////////////////////////////////////////////////////////////////////////////////////RUTAS ADMIN////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//EN LAS RUTAS TIPO GET, MEDIANTE EL METODO CAN, SE CONTROLA EL ACCESO A ESAS RUTAS DE ADMIN
//PARA LAS RUTAS TIPO RESOURCE EL CONTROL SE HACE EN CADA CONTROLADOR

//RUTA PARA ACCEDER AL PANEL DE ADMIN LTE
Route::get('admin', [AdminController::class, 'index'])->middleware('auth')->name('admin');

//RUTA PARA MOSTRAR VISTA INDICE DE PREGUNTAS PANEL ADMIN
Route::get('admin/exercise', [AdminController::class, 'indexE'])->middleware('auth')->middleware('can:admin.exercise')->name('admin.exercise');

//RUTA PARA MOSTRAR VISTA INDICE DE REGLAS ORTOGRAFICAS PANEL ADMIN
Route::get('admin/rules', [AdminController::class, 'indexR'])->middleware('auth')->middleware('can:admin.rules')->name('admin.rules');


//RUTA TIPO RESOURCE PARA EL CRUD DE EVALUATION
Route::resource('admin/evaluation', EvaluationController::class)->middleware('auth')->names('admin.evaluation');

//RUTA PARA MOSTRAR EL LISTADO DE PREGUNTAS QUE LE PERTENECEN A UN EXAMEN DESDE EL INDEX DE EVALUATIONS
Route::get('admin/evaluation/{evaluation}/questions', [EvaluationController::class, 'question'])->middleware('can:admin.evaluation.questions')->name('admin.evaluation.questions');

//RUTA PARA MOSTRAR VISTA INDICE DE RESULTADOS PANEL ADMIN
//Route::get('admin/results', [AdminController::class, 'indexResults'])->middleware('auth')->name('admin.results');
Route::get('admin/results', [AllResultsController::class, 'index'])->middleware('auth')->can('admin.results')->name('admin.results');

//RUTA PARA MOSTRAR EL LISTADO DE EXAMENES ASIGNADOS A UN ESTUDIANTE ESPECIFICO MEDIANTE LA VISTA RESULTS
Route::get('admin/results/{user}', [AllResultsController::class, 'showAssignedEvaluations'])->middleware('auth')->middleware('can:admin.results.assignedevaluations')->name('admin.results.assignedevaluations');

//RUTA PARA MOSTRAR EL LISTADO DE RESPUESTAS DEL USUARIO A UNA EVALUACION EN ESPECIFICO MEDIANTE LA VISTA ASSIGNEDEVALUATIONS
Route::get('admin/results/{user}/{evaluation}', [AllResultsController::class, 'showEvaluationResults'])->middleware('auth')->middleware('can:admin.results.assignedquestions')->name('admin.results.assignedquestions');

//RUTA PARA INGRESAR A LA SOLUCION DE UNA RESPUESTA DE UNA EVALUACION ESPECIFICA DE UN USUARIO ESPECIFICO DESDE EL PANEL ADMIN
Route::get('admin/results/{user}/evaluacion/{evaluation}/pregunta/{question}', [AllResultsController::class, 'viewQuestionResults'])->middleware('auth')->middleware('can:admin.results.viewresultquestions')->name('admin.results.viewresultquestions');


//RUTA PARA MOSTRAR LAS NOTAS DE LOS USUARIOS EN LAS PRUEBAS DE DIAGNOSTICO
Route::get('admin/notes/diagnostic', [NotesController::class, 'viewNotesDiagnostic'])->middleware('auth')->middleware('can:admin.notes.diagnostic')->name('admin.notes.diagnostic');

//RUTA PARA MOSTRAR LAS NOTAS DE LOS USUARIOS EN LA PRUEBA DE PRACTICA UNO
Route::get('admin/notes/practiceone', [NotesController::class, 'viewNotesOne'])->middleware('auth')->middleware('can:admin.notes.practiceone')->name('admin.notes.practiceone');

//RUTA PARA MOSTRAR LAS NOTAS DE LOS USUARIOS EN LA PRUEBA DE PRACTICA DOS
Route::get('admin/notes/practicetwo', [NotesController::class, 'viewNotesTwo'])->middleware('auth')->middleware('can:admin.notes.practicetwo')->name('admin.notes.practicetwo');

//RUTA PARA MOSTRAR LAS NOTAS DE LOS USUARIOS EN LA PRUEBA DE PRACTICA TRES
Route::get('admin/notes/practicethree', [NotesController::class, 'viewNotesThree'])->middleware('auth')->middleware('can:admin.notes.practicethree')->name('admin.notes.practicethree');

//RUTA PARA MOSTRAR LAS NOTAS DE LOS USUARIOS EN LA PRUEBA FINAL
Route::get('admin/notes/final', [NotesController::class, 'viewNotesFinal'])->middleware('auth')->middleware('can:admin.notes.final')->name('admin.notes.final');

//RUTA PARA MOSTRAR TODAS LAS NOTAS DE LOS USUARIOS EN UNA SOLA TABLA
Route::get('admin/notes/reportevaluations', [NotesController::class, 'viewAllResults'])->middleware('auth')->middleware('can:admin.notes.allresults')->name('admin.notes.allresults');

//RUTA TIPO RESOURCE PARA CRUD DE ASIGNAR ROLES A LOS USUARIOS Y PODER ELIMINAR USUARIOS
Route::resource('admin/user', UserController::class)->middleware('auth')->names('admin.user');

//////////////////////////////////////////////////////PREGUNTAS///////////////////////////////////////////////////////////////

//RUTA TIPO RESOURCE PARA EL CRUD DE OPCIONMULTIPLE
Route::resource('admin/question/opcionmultiple', OpcionMultipleController::class)->middleware('auth')->names('admin.question.opcionmultiple');

//RUTA TIPO RESOURCE PARA EL CRUD DE PALABRACORRECCION
Route::resource('admin/question/palabracorreccion', PalabraCorreccionController::class)->middleware('auth')->names('admin.question.palabracorreccion');

//RUTA TIPO RESOURCE PARA EL CRUD DE OPCIONMULTIPLEIMAGEN
Route::resource('admin/question/opcionmultiplei', OpcionMultipleIController::class)->middleware('auth')->names('admin.question.opcionmultiplei');

//RUTA TIPO RESOURCE PARA EL CRUD DE OPCIONMULTIPLEAUDIO 
Route::resource('admin/question/opcionmultiplea', OpcionMultipleAController::class)->middleware('auth')->names('admin.question.opcionmultiplea');

//RUTA TIPO RESOURCE PARA EL CRUD DE ORACIONAUDIO
Route::resource('admin/question/oracionaudio', OracionAudioController::class)->middleware('auth')->names('admin.question.oracionaudio');

//RUTA TIPO RESOURCE PARA EL CRUD DE ORACIONIMAGEN
Route::resource('admin/question/oracionimagen', OracionImagenController::class)->middleware('auth')->names('admin.question.oracionimagen');

//RUTA TIPO RESOURCE PARA EL CRUD DE TEXTO IMAGEN
Route::resource('admin/question/textoimagen', TextoImagenController::class)->middleware('auth')->names('admin.question.textoimagen');

//RUTA TIPO RESOURCE PARA EL CRUD DE TEXTO AUDIO
Route::resource('admin/question/textoaudio', TextoAudioController::class)->middleware('auth')->names('admin.question.textoaudio');

//RUTA TIPO RESOURCE PARA EL CRUD DE QUESTION JUEGO
Route::resource('admin/question/juego', JuegoController::class)->middleware('auth')->names('admin.question.juego');

//RUTA TIPO RESOURCE PARA EL CRUD DE QUESTION SOPALETRAS
Route::resource('admin/question/sopaletra', SopaLetrasController::class)->middleware('auth')->names('admin.question.sopaletras');


/////////////////////////////////////////////////////////////REGLAS ORTOGRAFICAS SEGUN NIVELES ////////////////////////////////////////////////////////////////////////


//RUTA TIPO RESOURCE PARA EL CRUD DE REGLAS NIVEL 1 (CATEGORIES)
Route::resource('admin/information/category', CategoryController::class)->middleware('auth')->names('admin.information.category');

//RUTA TIPO RESOURCE PARA EL CRUD DE GLOSARIO DE TERMINOS
Route::resource('admin/glossary', AdminGlossaryController::class)->middleware('auth')->names('admin.glossary');

///////////////////////ACTUALIZACION///////////////////////////////////////////////////////////////////////////////////////////////////////////

//POR CADA NIVEL DE REGLAS ORTOGRAFICAS: NIVEL 1, NIVEL 2, NIVEL 3, NIVEL 4, NIVEL 5
//SEA CREA 3 CRUDS POR CADA NIVEL: 1 PARA REGLAS DE LETRAS, 1 PARA REGLAS DE ACENTUACION Y 1 PARA REGLAS DE PUNTUACION

//RUTA PARA MOSTRAR LA VISTA DEL INDICE DE REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 1 PANEL ADMIN
Route::get('admin/rules/categories', [AdminController::class, 'indexCategories'])->middleware('auth')->middleware('can:admin.rules.categories')->name('admin.rules.categories');
//PARA LAS REGLAS NIVEL 1 (CATEGORIES) SE CREA 1 CONTROLADOR POR CADA TIPO DE REGLA: PALABRAS, ACENTUACION, PUNTUACION
Route::resource('admin/rules/categories/categoryword', CategoryWordController::class)->middleware('auth')->names('admin.categories.categoryword');
Route::resource('admin/rules/categories/categoryacentuation', CategoryAcentuationController::class)->middleware('auth')->names('admin.categories.categoryacentuation');
Route::resource('admin/rules/categories/categorypunctuation', CategoryPunctuationController::class)->middleware('auth')->names('admin.categories.categorypunctuation');

//RUTA PARA MOSTRAR LA VISTA DEL INDICE DE REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 2 PANEL ADMIN
Route::get('admin/rules/sections', [AdminController::class, 'indexSections'])->middleware('auth')->middleware('can:admin.rules.sections')->name('admin.rules.sections');
//PARA LAS REGLAS NIVEL 2 (SECTIONS) SE CREA 1 CONTROLADOR POR CADA TIPO DE REGLA: PALABRAS, ACENTUACION, PUNTUACION
Route::resource('admin/rules/sections/sectionword', SectionWordController::class)->middleware('auth')->names('admin.sections.sectionword');
Route::resource('admin/rules/sections/sectionacentuation', SectionAcentuationController::class)->middleware('auth')->names('admin.sections.sectionacentuation');
Route::resource('admin/rules/sections/sectionpunctuation', SectionPunctuationController::class)->middleware('auth')->names('admin.sections.sectionpunctuation');

//RUTA PARA MOSTRAR LA VISTA DEL INDICE DE REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 3 PANEL ADMIN
Route::get('admin/rules/posts', [AdminController::class, 'indexPosts'])->middleware('auth')->middleware('can:admin.rules.posts')->name('admin.rules.posts');
//PARA LAS REGLAS NIVEL 3 (POSTS) SE CREA 1 CONTROLADOR POR CADA TIPO DE REGLA: PALABRAS, ACENTUACION, PUNTUACION
Route::resource('admin/rules/posts/postword', PostWordController::class)->middleware('auth')->names('admin.posts.postword');
Route::resource('admin/rules/posts/postacentuation', PostAcentuationController::class)->middleware('auth')->names('admin.posts.postacentuation');
Route::resource('admin/rules/posts/postpunctuation', PostPunctuationController::class)->middleware('auth')->names('admin.posts.postpunctuation');

//RUTA PARA MOSTRAR LA VISTA DEL INDICE DE REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 4 PANEL ADMIN
Route::get('admin/rules/rules', [AdminController::class, 'indexRules'])->middleware('auth')->middleware('can:admin.rules.rules')->name('admin.rules.rules');
//PARA LAS REGLAS DE NIVEL 4 (RULES) SE CREA 1 CONTROLADOR POR CADA TIPO DE REGLA: PALABRAS, ACENTUACION, PUNTUACION
Route::resource('admin/rules/rules/ruleword', RuleWordController::class)->middleware('auth')->names('admin.rules.ruleword');
Route::resource('admin/rules/rules/ruleacentuation', RuleAcentuationController::class)->middleware('auth')->names('admin.rules.ruleacentuation');
Route::resource('admin/rules/rules/rulepunctuation', RulePunctuationController::class)->middleware('auth')->names('admin.rules.rulepunctuation');

//RUTA PARA MOSTRAR LA VISTA DEL INDICE DE REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 5 PANEL ADMIN
Route::get('admin/rules/notes', [AdminController::class, 'indexNotes'])->middleware('auth')->middleware('can:admin.rules.notes')->name('admin.rules.notes');
//PARA LAS REGLAS DE NIVEL 5 (RULES) SE CREA 1 CONTROLADOR POR CADA TIPO DE REGLA: PALABRAS, ACENTUACION, PUNTUACION
Route::resource('admin/rules/notes/noteword', NoteWordController::class)->middleware('auth')->names('admin.notes.noteword');
Route::resource('admin/rules/notes/noteacentuation', NoteAcentuationController::class)->middleware('auth')->names('admin.notes.noteacentuation');
Route::resource('admin/rules/notes/notepunctuation', NotePunctuationController::class)->middleware('auth')->names('admin.notes.notepunctuation');


//////////////////////////////////////////////////////////////////////////////////////////////////////////////RUTAS ESTUDIANTE///////////////////////////////////////////////////////////////////////////////////////////////////////////////

//RUTA PARA MOSTRAR EVALUACION DE DIAGNOSTICO AL ESTUDIANTE ACTUAL
//Route::get('estudiante/diagnostico', [EstudianteController::class, 'pruebadiagnostico'])->middleware('auth')->name('estudiante.diagnostico');
Route::get('estudiante/diagnostico', [EstudianteController::class, 'pruebadiagnosticomod'])->middleware('auth')->name('estudiante.diagnostico');

//RUTA PARA MOSTRAR EVALUACIONES DE PRACTICA AL ESTUDIANTE ACTUAL
//Route::get('estudiante/practica', [EstudianteController::class, 'pruebaspractica'])->middleware('auth')->name('estudiante.practica');
Route::get('estudiante/practica', [EstudianteController::class, 'pruebaspracticamod'])->middleware('auth')->name('estudiante.practica');

//RUTA PARA MOSTRAR EVALUACION FINAL AL ESTUDIANTE ACTUAL
//Route::get('estudiante/final', [EstudianteController::class, 'pruebafinal'])->middleware('auth')->name('estudiante.final');
Route::get('estudiante/final', [EstudianteController::class, 'pruebafinalmod'])->middleware('auth')->name('estudiante.final');

//RUTA PARA OBTENER LAS PREGUNTAS DE LA EVALUACION QUE EL ESTUDIANTE DEBE RESPONDER
Route::get('estudiante/evaluacion/{evaluation}', [EvaluacionController::class, 'getEvaluationQuestions'])->middleware('auth')->name('estudiante.preguntasevaluacion');

//Route::get('student/evaluation/{evaluation}', [EvaluationController::class, 'getEvaluationQuestions'])->middleware('auth')->name('student.questionsevaluation');
//RUTA PARA ENVAR A CADA PREGUNTA INDIVIDUAL PARA QUE EL USUARIO RESPONDA
Route::get('estudiante/evaluacion/{evaluacionId}/question/{questionId}', [EvaluacionController::class, 'responseQuestion'])->middleware('auth');

 
//////////////////////////////////////////RUTAS PARA MOSTRAR LAS REGLAS ORTOGRAFICAS AL ESTUDIANTE SEGUN NIVELES

//////////////RUTAS PARA MOSTRAR LAS REGLAS ORTOGRAFICAS DE PALABRAS

//RUTA PARA MOSTRAR LA VISTA PRINCIPAL DE LAS REGLAS DE PALABRAS CON EL LISTADO DE REGLAS DE NIVEL 1 (CATEGORIES) DE PALABRAS
Route::get('estudiante/letters', [RulesLevelOneController::class, 'indexCategoryWord'])->middleware('auth')->name('estudiante.letterslevelone');
//RUTA PARA INGRESAR A UNA REGLA DE PALABRAS DE NIVEL 1  (CATEGORIES) EN ESPECIFICO
Route::get('estudiante/letters/{categoryword}', [RulesLevelOneController::class, 'showCategoryWord'])->middleware('auth')->name('estudiante.letterslevelone.show');
//RUTA PARA INGRESAR A UNA REGLA DE PALABRAS NIVEL 2 (SECTIONS) EN ESPECIFICO
Route::get('estudiante/letters/{categoryword}/{sectionword}', [RulesLevelTwoController::class, 'showSectionWord'])->middleware('auth')->name('estudiante.lettersleveltwo.show');
//RUTA PARA INGRESAR A UNA REGLA DE PALABRAS NIVEL 3 (POSTS) EN ESPECIFICO
Route::get('estudiante/letters/{categoryword}/{sectionword}/{postword}', [RulesLevelThreeController::class, 'showPostWord'])->middleware('auth')->name('estudiante.letterslevelthree.show');
//RUTA PARA INGRESAR A UNA REGLA DE PALABRAS NIVEL 4 (RULES) EN ESPECIFICO
Route::get('estudiante/letters/{categoryword}/{sectionword}/{postword}/{ruleword}', [RulesLevelFourController::class, 'showRuleWord'])->middleware('auth')->name('estudiante.letterslevelfour.show');
//RUTA PARA INGRESAR A UNA REGLA DE PALABRAS NIVEL 5 (NOTES) EN ESPECIFICO
Route::get('estudiante/letters/{categoryword}/{sectionword}/{postword}/{ruleword}/{noteword}', [RulesLevelFiveController::class, 'showNoteWord'])->middleware('auth')->name('estudiante.letterslevelfive.show');


//////////////////RUTAS PARA MOSTRAR LAS REGLAS ORTOGRAFICAS DE ACENTUACION

//RUTA PARA MOSTRAR LA VISTA PRINCIPAL DE LAS REGLAS DE ACENTUACION CON EL LISTADO DE REGLAS NIVEL 1 (CATEGORIES) DE ACENTUACION
Route::get('estudiante/acentuation', [RulesLevelOneController::class, 'indexCategoryAcentuation'])->middleware('auth')->name('estudiante.acentuationlevelone');
//RUTA PARA INGRESAR A UNA REGLA DE ACENTUACION DE NIVEL 1 (CATEGORIES) EN ESPECIFICO
Route::get('estudiante/acentuation/{categoryacentuation}', [RulesLevelOneController::class, 'showCategoryAcentuation'])->middleware('auth')->name('estudiante.acentuationlevelone.show');
//RUTA PARA INGRESAR A UNA REGLA DE ACENTUACION DE NIVEL 2 (SECTIONS) EN ESPECIFICO
Route::get('estudiante/acentuation/{categoryacentuation}/{sectionacentuation}', [RulesLevelTwoController::class, 'showSectionAcentuation'])->middleware('auth')->name('estudiante.acentuationleveltwo.show');
//RUTA PARA INGRESAR A UNA REGLA DE ACENTUACION DE NIVEL 3 (POSTS) EN ESPECIFICO
Route::get('estudiante/acentuation/{categoryacentuation}/{sectionacentuation}/{postacentuation}', [RulesLevelThreeController::class, 'showPostAcentuation'])->middleware('auth')->name('estudiante.acentuationlevelthree.show');
//RUTA PARA INGRESAR A UNA REGLA DE ACENTUACION DE NIVEL 4 (RULES) EN ESPECIFICO
Route::get('estudiante/acentuation/{categoryacentuation}/{sectionacentuation}/{postacentuation}/{ruleacentuation}', [RulesLevelFourController::class, 'showRuleAcentuation'])->middleware('auth')->name('estudiante.acentuationlevelfour.show');
//RUTA PARA INGRESAR A UNA REGLA DE ACENTUACION DE NIVEL 5 (NOTES) EN ESPECIFICO
Route::get('estudiante/acentuation/{categoryacentuation}/{sectionacentuation}/{postacentuation}/{ruleacentuation}/{noteacentuation}', [RulesLevelFiveController::class, 'showNoteAcentuation'])->middleware('auth')->name('estudiante.acentuationlevelfive.show');


/////////////////////RUTAS PARA MOSTRAR LAS REGLAS ORTOGRAFICAS DE PUNTUACION

//RUTA PARA MOSTRAR LA VISTA PRINCIPAL DE LAS REGLAS DE PUNTUACION CON EL LISTADO DE REGLAS NIVEL 1 (CATEGORIES) DE PUNTUACION
Route::get('estudiante/punctuation', [RulesLevelOneController::class, 'indexCategoryPunctuation'])->middleware('auth')->name('estudiante.punctuationlevelone');
//RUTA PARA INGRESAR A UNA REGLA DE PUNTUACION DE NIVEL 1 (CATEGORIES) EN ESPECIFICO
Route::get('estudiante/punctuation/{categorypunctuation}', [RulesLevelOneController::class, 'showCategoryPunctuation'])->middleware('auth')->name('estudiante.punctuationlevelone.show');
//RUTA PARA INGRESAR A UNA REGLA DE PUNTUACION DE NIVEL 2 (SECTIONS) EN ESPECIFICO
Route::get('estudiante/punctuation/{categorypunctuation}/{sectionpunctuation}', [RulesLevelTwoController::class, 'showSectionPunctuation'])->middleware('auth')->name('estudiante.punctuationleveltwo.show');
//RUTA PARA INGRESAR A UNA REGLA DE PUNTUACION DE NIVEL 3 (POSTS) EN ESPECIFICO
Route::get('estudiante/punctuation/{categorypunctuation}/{sectionpunctuation}/{postpunctuation}', [RulesLevelThreeController::class, 'showPostPunctuation'])->middleware('auth')->name('estudiante.punctuationlevelthree.show');
//RUTA PARA INGRESAR A UNA REGLA DE PUNTUACION DE NIVEL 4 (RULES) EN ESPECIFICO
Route::get('estudiante/punctuation/{categorypunctuation}/{sectionpunctuation}/{postpunctuation}/{rulepunctuation}', [RulesLevelFourController::class, 'showRulePunctuation'])->middleware('auth')->name('estudiante.punctuationlevelfour.show');
//RUTA PARA INGRESAR A UNA REGLA DE PUNTUACION DE NIVEL 5 (NOTES) EN ESPECIFICO
Route::get('estudiante/punctuation/{categorypunctuation}/{sectionpunctuation}/{postpunctuation}/{rulepunctuation}/{notepunctuation}', [RulesLevelFiveController::class, 'showNotePunctuation'])->middleware('auth')->name('estudiante.punctuationlevelfive.show');

/////////////////////RUTA PARA MOSTRAR LA PAGINA DE BIENVENIDA

//RUTA PARA MOSTRAR LA PAGINA DE WELCOME



///////////////////////////////////RUTAS PARA GUARDAR RESPUESTAS ESTUDIANTE

//RUTA PARA GUARDAR LAS RESPUESTAS DE OPCION MULTIPLE
Route::post('estudiante/saveom', [EvaluacionController::class, 'storeResponseOM'])->middleware('auth')->name('estudiante.save.om');

//RUTA PARA GUARDAR LAS RESPUESTAS DE PALABRA CORRECCION
Route::post('estudiante/savepc', [EvaluacionController::class, 'storeResponsePC'])->middleware('auth')->name('estudiante.save.pc');

//RUTA PARA GUARDAR LAS RESPUESTA DE OPCION MULTIPLE IMAGEN
Route::post('estudiante/saveomi', [EvaluacionController::class, 'storeResponseOMI'])->middleware('auth')->name('estudiante.save.omi');

//RUTA PARA GUARDAR LAS RESPUESTAS DE OPCION MULTIPLE AUDIO
Route::post('estudiante/saveoma', [EvaluacionController::class, 'storeResponseOMA'])->middleware('auth')->name('estudiante.save.oma');

//RUTA PARA GUARDAR LAS RESPUESTAS DE ORACION AUDIO
Route::post('estudiante/saveoa', [EvaluacionController::class, 'storeResponseOA'])->middleware('auth')->name('estudiante.save.oa');

//RUTA PARA GUARDAR LAS RESPUESTAS DE ORACION IMAGEN
Route::post('estudiante/saveoi', [EvaluacionController::class, 'storeResponseOI'])->middleware('auth')->name('estudiante.save.oi');

//RUTA PARA GUARDAR LAS RESPUESTAS DE TEXTO IMAGEN
Route::post('estudiante/saveti', [EvaluacionController::class, 'storeResponseTI'])->middleware('auth')->name('estudiante.save.ti');

//RUTA PARA GUARDAR LAS RESPUESTAS DE TEXTO AUDIO
Route::post('estudiante/saveta', [EvaluacionController::class, 'storeResponseTA'])->middleware('auth')->name('estudiante.save.ta');

//RUTA PARA GUARDAR LAS RESPUESTAS DE JUEGO AHORCADO
Route::post('estudiante/saveja', [EvaluacionController::class, 'storeResponseJA'])->middleware('auth')->name('estudiante.save.ja');

//RUTA PARA GUARDAR LAS RESPUESTAS DE JUEGO SOPA LETRAS
Route::post('estudiante/savesl', [EvaluacionController::class, 'storeResponseSL'])->middleware('auth')->name('estudiante.save.sl');


//RUTA PARA MOSTRAR LOS RESULTADOS DE UN EXAMEN ESPECIFICO A UN ESTUDIANTE
//Route::get('estudiante/resultado/{userId}/evaluacion/{evaluationId}', [EvaluacionController::class, 'viewResultDiagnostic'])->middleware('auth')->name('estudiante.resultados');

Route::get('estudiante/resultado/{userId}/evaluacion/{evaluationId}', [EvaluacionController::class, 'viewResult'])->middleware('auth')->name('estudiante.resultados');
//RUTA PARA INGRESAR A LA SOLUCION DE LA RESPUESTA
Route::get('estudiante/{userId}/evaluacion/{evaluationId}/resultadopregunta/{questionId}', [EvaluacionController::class, 'viewQuestionResults'])->middleware('auth')->name('estudiante.resultadospregunta');