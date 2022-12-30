<?php

namespace App\Http\Controllers\Admin\Information;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Note;
use App\Models\Post;
use App\Models\Rule;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Word;
use Illuminate\Support\Facades\Storage;


class NoteWordController extends Controller
{

    //CONTROLADOR PARA CONTROLAR EL ACCESO A LAS RUTAS INDEX,CREATE, EDIT, DESTROY DE UNA RUTA TIPO RESOURCE DE WEB.PHP
    public function __construct()
    {
        //SE INVOCA A UN PERMISO CREADO Y AL METODO QUE VA A PROTEGER ESE PERMISO
        $this->middleware('can:admin.notes.noteword.index')->only('index');
        $this->middleware('can:admin.notes.noteword.create')->only('create', 'store');
        $this->middleware('can:admin.notes.noteword.edit')->only('edit', 'update');
        $this->middleware('can:admin.notes.noteword.show')->only('show');
        $this->middleware('can:admin.notes.noteword.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //IMPORTAR LAS NOTES CUYO CAMPO TYPE SEA PALABRAS
        //$notes = Note::where('type', "Reglas ortográficas de palabras")->get();

        //ACTUALIZACION CONSULTA CON PAGINACION
        $notes = Note::orderBy('id', 'DESC')->where('type', "Reglas ortográficas de palabras")->paginate(10);

        return view('admin.information.notes.noteword.index', compact('notes')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //SE ENVIAN LOS TERMINOS DEL GLOSARIO PARA QUE EL USUARIO PUEDA ESCOGER LOS TERMINOS ADECUADOS
        $words = Word::all();

        //SE CAPTURAN LAS REGLAS DE NIVEL 4 (RULES) CUYO CAMPO TYPE SEA REGLAS DE PALABRAS
        $rules = Rule::where('type', "Reglas ortográficas de palabras")->get();

        return view('admin.information.notes.noteword.create', compact('words', 'rules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;

        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:notes',
            'body' => 'required',
            'rule_id' => 'required'
        ]);


        //GUARDAR REGISTRO
        //CON EL IF SE PREGUNTA SI LA REGLA VIENE CON UNA IMAGEN O SI VIENE SIN IMAGEN
        if($request->file('image')){
            //SI EL POST VIENE CON UNA IMAGEN, SE CREA EL REGISTRO CON EL CAMPO IMAGEN
            
            $noteword = Note::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => Storage::put('reglasnivelcinconotes', $request->file('image')),
                'description' => $request->description,
                'body' => $request->body,
                'example' => $request->example,
                'exception' => $request->exception,
                'type' => "Reglas ortográficas de palabras",
                'clasification' => "Reglas ortográficas de palabras",
                'rule_id' => $request->rule_id
            ]);
        }else{
            
            //SI EL POST NO VIENE CON IMAGEN, SE CREA EL POST DE ESTA MANERA
            $noteword = Note::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => $request->image,
                'description' => $request->description,
                'body' => $request->body,
                'example' => $request->example,
                'exception' => $request->exception,
                'type' => "Reglas ortográficas de palabras",
                'clasification' => "Reglas ortográficas de palabras",
                'rule_id' => $request->rule_id
            ]);
        }

        //CON EL IF SE PREGUNTA SI EL REQUEST TIENE WORDS[]
        if($request->words){
            //SI ES ASI, SE ACCEDE A LA RELACION WORDS() DEL MODELO SECTION QUE ES LA RELACION MUCHOS A MUCHOS CON EL MODELO WORDS
            //Y CON EL METODO ATTACH() SE VA A GUARDAR EN LA TABLA INTERMEDIA SECTION_WORD, LAS WORDS QUE HAYA SELECCIONADO EL USUARIO
            //DENTRO DEL PARENTESIS DE ATTACH() SE PONE REQUEST->WORDS PORQUE AHI ESTAN LAS IDS DE LAS WORDS QUE ESCOGIO EL USUARIO
            $noteword->words()->attach($request->words);
        }

        return redirect()->route('admin.notes.noteword.index')->with('message', 'Regla creada correctamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Note $noteword)
    {
        //CAPTURAR LA RELACION NOTEWORD CON RULE QUE ES LA REGLA DE NIVEL 4 QUE LA CONTIENE
        $rule = $noteword->rule;

        //EN BASE AL CAMPO POST_ID DE LA VARIBLE RULE, BUSCAR EL POST QUE CONTIENE A LAS REGLAS
        $post = Post::find($rule->post_id);

        //EN BASE AL CAMPO SECTION_ID DE LA VARIABLE POST, BUSCAR LA SECTION QUE CONTIENE A LAS REGLAS
        $section = Section::find($post->section_id);

        //EN BASE AL CAMPO CATEGORY_ID DE LA VARIABLE SECTION, BUSCAR LA CATEGORY QUE CONTIENE A LAS REGLAS
        $category = Category::find($section->category_id);


        return view('admin.information.notes.noteword.show', compact('noteword', 'post', 'section', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $noteword)
    {
        //ENVIAR EL NUMERO DE WORDS QUE TIENE EL USUARIO EN LA REGLA CREADA
        $numero = count($noteword->words);

        //SE ENVIAR A LA VISTA DE EDITAR TODAS LAS WORD
        $words = Word::all();

        //SE ENVIA A LA VISTA LOS TERMINOS SELECCIONADOS POR EL USUARIO, SOLO EL CAMPO WORD_ID
        //SE CREA UN ARRAY PARA ALMACENAR LOS IDS Y CON UN FOR SE RECORRE LA RELACION ENTRE WORDS Y POSTS
        //PARA CAPTURAR LOS TERMINOS QUE EL USUARIO HAYA SELECCIONADO EN LA VISTA CREAR Y ENVIARLOS A LA VISTA
        $selectedWords = [];
        for($i=0; $i< count($noteword->words); $i++){
            array_push($selectedWords, $noteword->words[$i]->id);
        }

        //SE ENVIAN LAS REGLAS DE NIVEL 4 (RULES) DONDE SU CAMPO TYPE SE REGLAS ORTOGRAFICAS DE PALABRAS
        $rules = Rule::where('type', "Reglas ortográficas de palabras")->get();
        
        return view('admin.information.notes.noteword.edit', compact('noteword', 'words', 'selectedWords', 'numero', 'rules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $noteword)
    {
        //return $request;

        $request->validate([
            'name' => 'required|string',
            'slug' => "required|unique:notes,slug,$noteword->id",
            'body' => 'required',
            'rule_id' => 'required'
        ]);

        //ACTUALIZAR REGLA NIVEL 4 (RULES)
        //CON EL IF SE PREGUNTA SI EN EL REQUEST SE ESTA ENVIANDO UNA IMAGEN O NO SE ESTA ENVIANDO NADA
        if($request->file('image')){
            //SI EL POST YA TENIA UNA IMAGEN, QUE SE ELIMINE LA IMAGEN ANTERIOR
            //SE PREGUNTA SI EL REGISTRO SECTIONWORD YA TENIA UNA IMAGEN O NO
            if(isset($noteword->image)){
                //SI EL REGISTRO SECTIONWORD YA TENIA UNA IMAGEN, QUE SE ELIMINE LA IMAGEN ANTERIOR
                Storage::delete($noteword->image);
            }
            //SE ACTUALIZA EL REGISTRO NUEVO DE SECTION WORD CON EL NUEVO CAMPO IMAGEN
            $noteword->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => Storage::put('reglasnivelcinconotes', $request->file('image')),
                'description' => $request->description,
                'body' => $request->body,
                'example' => $request->example,
                'exception' => $request->exception,
                'type' => "Reglas ortográficas de palabras",
                'clasification' => "Reglas ortográficas de palabras",
                'rule_id' => $request->rule_id
            ]);
        }else{
            //SI NO SE ESTA ENVIANDO IMAGENES ENTONCES QUE SE ACTUALICEEN LOS DEMAS CAMPOS MENOS LA IMAGEN
            $noteword->update([
                'name' => $request->name,
                'slug' => $request->slug,
                //'image' => Storage::put('reglasnivelcinconotes', $request->file('image')),
                'description' => $request->description,
                'body' => $request->body,
                'example' => $request->example,
                'exception' => $request->exception,
                'type' => "Reglas ortográficas de palabras",
                'clasification' => "Reglas ortográficas de palabras",
                'rule_id' => $request->rule_id
            ]);
        }

        //SE PONE EL METODO SYNC SIN EL IF PARA QUE SE PUEDA AGREGAR MAS WORDS O QUITAR TODAS LAS WORDS PORQUE CON EL IF
        //SI DESMARCABAMOS TODAS LAS WORDS, AL ENTRAR DE NUEVO LA RELACION NO SE QUITABA
        $noteword->words()->sync($request->words);

        return redirect()->route('admin.notes.noteword.index')->with('message', 'Regla actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $noteword)
    {
        //CON EL IF SE PREGUNTA SI EL REGISTRO TIENE UNA IMAGEN
        if(isset($noteword->image)){
            //SI ES ASI, ENTONCES SE ELIMINA LA IMAGEN Y LUEGO EL REGISTRO
            //SE ELIMINA LA IMAGEN ANTES DE ELIMINAR EL REGISTRO
            Storage::delete($noteword->image);
            $noteword->delete();
        }
        else{
            //SI NO ES ASI, ENTONCES SE ELIMINA EL REGISTRO
            $noteword->delete();
        }

        return redirect()->route('admin.notes.noteword.index')->with('message', 'Regla eliminada.');
    }
}
