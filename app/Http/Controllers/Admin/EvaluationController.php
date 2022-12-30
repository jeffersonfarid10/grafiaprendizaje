<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Result;

class EvaluationController extends Controller
{


    //CONTROLADOR PARA CONTROLAR EL ACCESO A LAS RUTAS INDEX,CREATE, EDIT, DESTROY DE UNA RUTA TIPO RESOURCE DE WEB.PHP
    public function __construct()
    {
        //SE INVOCA A UN PERMISO CREADO Y AL METODO QUE VA A PROTEGER ESE PERMISO
        $this->middleware('can:admin.evaluation.index')->only('index');
        $this->middleware('can:admin.evaluation.create')->only('create', 'store');
        $this->middleware('can:admin.evaluation.edit')->only('edit', 'update');
        $this->middleware('can:admin.evaluation.show')->only('show');
        $this->middleware('can:admin.evaluation.destroy')->only('destroy');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$evaluations = Evaluation::all();

        //ACTUALIZACION ENVIAR LA COLECCION EVALUATIONS CON PAGINACION
        $evaluations = Evaluation::orderBy('id', 'DESC')->paginate(10);

        return view('admin.evaluation.index', compact('evaluations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.evaluation.create');
    }
 
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string',
            'description' => 'required',
            'type' => 'required|string',
            'format' => 'required|string'
        ]);

        Evaluation::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'type' => $request->type,
            'format' => $request->format
        ]);

        return redirect()->route('admin.evaluation.index')->with('message', 'Evaluación creada con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Evaluation $evaluation)
    {
        //CAPTURAR EL TYPE Y FORMAT DE LA EVALUACION ACTUAL
        $evaluationType = Evaluation::where('id', $evaluation->id)->value('type');
        $evaluationFormat = Evaluation::where('id', $evaluation->id)->value('format');

        return view('admin.evaluation.edit', compact('evaluationType', 'evaluationFormat', 'evaluation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'name' => 'required|string',
            'slug' => "required|unique:evaluations,slug,$evaluation->id",
            'description' => 'required',
            'type' => 'required|string',
            'format' => 'required|string'
        ]);

        $evaluation->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'type' => $request->type,
            'format' => $request->format
        ]);

        return redirect()->route('admin.evaluation.index')->with('message', 'Evaluación actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evaluation $evaluation)
    {
        //$evaluation->delete();
        //return redirect()->route('admin.evaluation.index')->with('message', 'Evaluación eliminada.');

        //ACTUALIZACION
        //CONTROLAR QUE SI UN EXAMEN YA HA SIDO RESPONDIDO ENTONCES QUE NO SE PUEDA BORRAR EL EXAMEN

        //EN LA VARIABLE WASEVALUATIONRESPONSE SE CONSULTA SI EXISTEN REGISTROS EN LA TABLA RESULTS CON EL EVALUATION ID
        //DE LA EVALUACION ACTUAL
        $wasEvaluationResponse = Result::where('evaluation_id', $evaluation->id)->exists();

        //SI WASEVALUATIONCOMPLETED ES TRUE, SIGNIFICA QUE ALGUIEN YA RESPONDIO A ESTA EVALUACION, ENTONCES NO SE PUEDE ELIMINAR
        //PERO SI ES FALSE ENTONCES SE ELIMINA EL REGISTRO
        if($wasEvaluationResponse === true){
            return redirect()->route('admin.evaluation.index')->with('message', 'La evaluación ha sido respondida, no se puede eliminar');
        }
        else{
            $evaluation->delete();
            return redirect()->route('admin.evaluation.index')->with('message', 'Evaluación eliminada.');
        }


        
    }


    //METODO PARA MOSTRAR LAS PREGUNTAS DE UN EXAMEN ESPECIFICO DESDE EL INDEX DE EVALUATIONS
    public function question(Evaluation $evaluation){
        
        //MEDIANTE LA RELACION QUESTIONS DEL MODELO EVALUATION, CAPTURAR LAS QUESTIONS QUE LE PERTENEZCAN A LA EVALUATION ACTUAL
        $questions = Question::where('evaluation_id', $evaluation->id)->get();
        

        return view('admin.evaluation.questions', compact('questions', 'evaluation'));
    }
}
