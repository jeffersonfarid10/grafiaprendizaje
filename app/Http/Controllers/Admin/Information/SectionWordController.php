<?php

namespace App\Http\Controllers\Admin\Information;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class SectionWordController extends Controller
{
    //CONTROLADOR PARA CONTROLAR EL ACCESO A LAS RUTAS INDEX,CREATE, EDIT, DESTROY DE UNA RUTA TIPO RESOURCE DE WEB.PHP
    public function __construct()
    {
        //SE INVOCA A UN PERMISO CREADO Y AL METODO QUE VA A PROTEGER ESE PERMISO
        $this->middleware('can:admin.sections.sectionword.index')->only('index');
        $this->middleware('can:admin.sections.sectionword.create')->only('create', 'store');
        $this->middleware('can:admin.sections.sectionword.edit')->only('edit', 'update');
        $this->middleware('can:admin.sections.sectionword.show')->only('show');
        $this->middleware('can:admin.sections.sectionword.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //IMPORTAR LAS SECTIONS CUYO CAMPO TYPE SEA PALABRAS
        //$sections = Section::where('type', "Reglas ortográficas de palabras")->get();

        //ACTUALIZACION CONSULTA CON PAGINACION
        $sections = Section::orderBy('id', 'DESC')->where('type', "Reglas ortográficas de palabras")->paginate(10);


        return view('admin.information.sections.sectionword.index', compact('sections'));
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

        //SE CAPTURAN LAS REGLAS DE NIVEL 1 (CATEGORIES) CUYO CAMPO TYPE SEA REGLAS DE PALABRAS
        $categories = Category::where('type', "Reglas ortográficas de palabras")->get();

        return view('admin.information.sections.sectionword.create', compact('words', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //return $request->file('image');
        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:sections',
            'body' => 'required',
            'category_id' => 'required'
        ]);


        //GUARDAR REGISTRO
        //CON EL IF SE PREGUNTA SI LA REGLA VIENE CON UNA IMAGEN O SI VIENE SIN IMAGEN
        if($request->file('image')){
            //SI EL POST VIENE CON UNA IMAGEN, SE CREA EL REGISTRO CON EL CAMPO IMAGEN
            
            $sectionword = Section::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => Storage::put('reglasniveldossections', $request->file('image')),
                'description' => $request->description,
                'body' => $request->body,
                'example' => $request->example,
                'exception' => $request->exception,
                'type' => "Reglas ortográficas de palabras",
                'clasification' => "Reglas ortográficas de palabras",
                'category_id' => $request->category_id
            ]);
        }else{
            
            //SI EL POST NO VIENE CON IMAGEN, SE CREA EL POST DE ESTA MANERA
            $sectionword = Section::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => $request->image,
                'description' => $request->description,
                'body' => $request->body,
                'example' => $request->example,
                'exception' => $request->exception,
                'type' => "Reglas ortográficas de palabras",
                'clasification' => "Reglas ortográficas de palabras",
                'category_id' => $request->category_id
            ]);
        }


        //CON EL IF SE PREGUNTA SI EL REQUEST TIENE WORDS[]
        if($request->words){
            //SI ES ASI, SE ACCEDE A LA RELACION WORDS() DEL MODELO SECTION QUE ES LA RELACION MUCHOS A MUCHOS CON EL MODELO WORDS
            //Y CON EL METODO ATTACH() SE VA A GUARDAR EN LA TABLA INTERMEDIA SECTION_WORD, LAS WORDS QUE HAYA SELECCIONADO EL USUARIO
            //DENTRO DEL PARENTESIS DE ATTACH() SE PONE REQUEST->WORDS PORQUE AHI ESTAN LAS IDS DE LAS WORDS QUE ESCOGIO EL USUARIO
            $sectionword->words()->attach($request->words);
        }

        return redirect()->route('admin.sections.sectionword.index')->with('message', 'Regla creada correctamente');
    } 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Section $sectionword)
    {
        //CAPTURARR LA RELACION DE SECTIONWORD CON CATEGORYWORD QUE ES LA REGLA DE NIVEL SUPERIOR QUE LA CONTIENE
        $category = $sectionword->category;

        return view('admin.information.sections.sectionword.show', compact('sectionword', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $sectionword)
    {
        //ENVIAR EL NUMERO DE WORDS QUE TIENE EL USUARIO EN LA REGLA CREADA
        $numero = count($sectionword->words);

        //SE ENVIA A LA VISTA DE EDITAR TODAS LAS WORDS
        $words = Word::all();
        //SE ENVIA A LA VISTA LOS TERMINOS SELECCIONADOS POR EL USUARIO, SOLO EL CAMPO WORD_ID
        //SE CREA UN ARRAY PARA ALMACENAR LOS IDS Y CON UN FOR SE RECORRE LA RELACION ENTRE WORDS Y SECTIONS
        //PARA CAPTURAR LOS TERMINOS QUE EL USUARIO HAYA SELECCIONADO EN LA VISTA CREAR Y ENVIARLOS A LA VISTA
        $selectedWords = [];
        for($i=0; $i< count($sectionword->words); $i++){
            array_push($selectedWords, $sectionword->words[$i]->id);
        }

        //SE ENVIAN LAS REGLAS DE NIVEL 1 (CATEGORIES) DONDE SU CAMPO TYPE SEA REGLAS ORTOGRAFICAS DE PALABRAS
        $categories = Category::where('type', "Reglas ortográficas de palabras")->get();

        return view('admin.information.sections.sectionword.edit', compact('sectionword', 'words', 'numero', 'selectedWords', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $sectionword)
    {
        $request->validate([
            'name' => 'required|string',
            'slug' => "required|unique:sections,slug,$sectionword->id",
            'body' => 'required',
            'category_id' => 'required'
        ]);


        //ACTUALIZAR REGLA NIVEL 2 (SECTION)
        //CON EL IF SE PREGUNTA SI EN EL REQUEST SE ESTA ENVIANDO UNA IMAGEN O NO SE ESTA ENVIANDO NADA
        if($request->file('image')){
            //SI EL POST YA TENIA UNA IMAGEN, QUE SE ELIMINE LA IMAGEN ANTERIOR
            //SE PREGUNTA SI EL REGISTRO SECTIONWORD YA TENIA UNA IMAGEN O NO
            if(isset($sectionword->image)){
                //SI EL REGISTRO SECTIONWORD YA TENIA UNA IMAGEN, QUE SE ELIMINE LA IMAGEN ANTERIOR
                Storage::delete($sectionword->image);
            }
            //SE ACTUALIZA EL REGISTRO NUEVO DE SECTION WORD CON EL NUEVO CAMPO IMAGEN
            $sectionword->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => Storage::put('reglasniveldossections', $request->file('image')),
                'description' => $request->description,
                'body' => $request->body,
                'example' => $request->example,
                'exception' => $request->exception,
                'type' => "Reglas ortográficas de palabras",
                'clasification' => "Reglas ortográficas de palabras",
                'category_id' => $request->category_id
            ]);
        }else{
            //SI NO SE ESTA ENVIANDO IMAGENES ENTONCES QUE SE ACTUALICEEN LOS DEMAS CAMPOS MENOS LA IMAGEN
            $sectionword->update([
                'name' => $request->name,
                'slug' => $request->slug,
                //'image' => Storage::put('reglasniveldossections', $request->file('image')),
                'description' => $request->description,
                'body' => $request->body,
                'example' => $request->example,
                'exception' => $request->exception,
                'type' => "Reglas ortográficas de palabras",
                'clasification' => "Reglas ortográficas de palabras",
                'category_id' => $request->category_id
            ]);
        }


        //SE PONE EL METODO SYNC SIN EL IF PARA QUE SE PUEDA AGREGAR MAS WORDS O QUITAR TODAS LAS WORDS PORQUE CON EL IF
        //SI DESMARCABAMOS TODAS LAS WORDS, AL ENTRAR DE NUEVO LA RELACION NO SE QUITABA
        $sectionword->words()->sync($request->words);

        return redirect()->route('admin.sections.sectionword.index')->with('message', 'Regla actualizada correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $sectionword)
    {
        
        //CON EL IF SE PREGUNTA SI EL REGISTRO TIENE UNA IMAGEN
        if(isset($sectionword->image)){
            //SI ES ASI, ENTONCES SE ELIMINA LA IMAGEN Y LUEGO EL REGISTRO
            //SE ELIMINA LA IMAGEN ANTES DE ELIMINAR EL REGISTRO
            Storage::delete($sectionword->image);
            $sectionword->delete();
        }
        else{
            //SI NO ES ASI, ENTONCES SE ELIMINA EL REGISTRO
            $sectionword->delete();
        }

        return redirect()->route('admin.sections.sectionword.index')->with('message', 'Regla eliminada.');
    }
}
