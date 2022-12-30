<?php

namespace App\Http\Controllers\Admin\Information;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Word;
use App\Models\Section;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;


class PostAcentuationController extends Controller
{

    //CONTROLADOR PARA CONTROLAR EL ACCESO A LAS RUTAS INDEX,CREATE, EDIT, DESTROY DE UNA RUTA TIPO RESOURCE DE WEB.PHP
    public function __construct()
    {
        //SE INVOCA A UN PERMISO CREADO Y AL METODO QUE VA A PROTEGER ESE PERMISO
        $this->middleware('can:admin.posts.postacentuation.index')->only('index');
        $this->middleware('can:admin.posts.postacentuation.create')->only('create', 'store');
        $this->middleware('can:admin.posts.postacentuation.edit')->only('edit', 'update');
        $this->middleware('can:admin.posts.postacentuation.show')->only('show');
        $this->middleware('can:admin.posts.postacentuation.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //IMPORTAR LOS POSTS CUYO CAMPO TYPE SEA PALABRAS
        //$posts = Post::where('type', "Reglas ortográficas de acentuación")->get();

        //ACTUALIZACION CONSULTA CON PAGINACION
        $posts = Post::orderBy('id', 'DESC')->where('type', "Reglas ortográficas de acentuación")->paginate(10);

        return view('admin.information.posts.postacentuation.index', compact('posts'));  
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

        //SE CAPTURAS LAS REGLAS DE NIVEL 2 (SECTIONS) CUYO CAMPO TYPE SEA REGLAS DE PALABRAS
        $sections = Section::where('type', "Reglas ortográficas de acentuación")->get();

        return view('admin.information.posts.postacentuation.create', compact('words', 'sections'));
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
            'slug' => 'required|string|unique:posts',
            'body' => 'required',
            'section_id' => 'required'
        ]);

        //GUARDAR REGISTRO
        //CON EL IF SE PREGUNTA SI LA REGLA VIENE CON UNA IMAGEN O SI VIENE SIN IMAGEN
        if($request->file('image')){
            //SI EL POST VIENE CON UNA IMAGEN, SE CREA EL REGISTRO CON EL CAMPO IMAGEN
            
            $postacentuation = Post::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => Storage::put('reglasniveltresposts', $request->file('image')),
                'description' => $request->description,
                'body' => $request->body,
                'example' => $request->example,
                'exception' => $request->exception,
                'type' => "Reglas ortográficas de acentuación",
                'clasification' => "Reglas ortográficas de acentuación",
                'section_id' => $request->section_id
            ]);
        }else{
            
            //SI EL POST NO VIENE CON IMAGEN, SE CREA EL POST DE ESTA MANERA
            $postacentuation = Post::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => $request->image,
                'description' => $request->description,
                'body' => $request->body,
                'example' => $request->example,
                'exception' => $request->exception,
                'type' => "Reglas ortográficas de acentuación",
                'clasification' => "Reglas ortográficas de acentuación",
                'section_id' => $request->section_id
            ]);
        }

        //CON EL IF SE PREGUNTA SI EL REQUEST TIENE WORDS[]
        if($request->words){
            //SI ES ASI, SE ACCEDE A LA RELACION WORDS() DEL MODELO SECTION QUE ES LA RELACION MUCHOS A MUCHOS CON EL MODELO WORDS
            //Y CON EL METODO ATTACH() SE VA A GUARDAR EN LA TABLA INTERMEDIA SECTION_WORD, LAS WORDS QUE HAYA SELECCIONADO EL USUARIO
            //DENTRO DEL PARENTESIS DE ATTACH() SE PONE REQUEST->WORDS PORQUE AHI ESTAN LAS IDS DE LAS WORDS QUE ESCOGIO EL USUARIO
            $postacentuation->words()->attach($request->words);
        }

        return redirect()->route('admin.posts.postacentuation.index')->with('message', 'Regla creada correctamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $postacentuation)
    {
        //CAPTURAR LA RELACION DE POSTWORD CON SECTION QUE ES LA REGLA NIVEL 2 QUE LA CONTIENE
        $section = $postacentuation->section;
        //EN BASE A LA CATEGORY_ID BUSCAR LA CATEGORIA NIVEL 1 A LA QUE PERTENECE ESTA REGLA NIVEL 3 WORD
        $category = Category::find($section->category_id);

        
        return view('admin.information.posts.postacentuation.show', compact('postacentuation', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $postacentuation)
    {
        //ENVIAR EL NUMERO DE WORDS QUE TIENE EL USUARIO EN LA REGLA CREADA
        $numero = count($postacentuation->words);

        //SE ENVIA A LA VISTA DE EDITAR TODAS LAS WORDS
        $words = Word::all();
        //SE ENVIA A LA VISTA LOS TERMINOS SELECCIONADOS POR EL USUARIO, SOLO EL CAMPO WORD_ID
        //SE CREA UN ARRAY PARA ALMACENAR LOS IDS Y CON UN FOR SE RECORRE LA RELACION ENTRE WORDS Y POSTS
        //PARA CAPTURAR LOS TERMINOS QUE EL USUARIO HAYA SELECCIONADO EN LA VISTA CREAR Y ENVIARLOS A LA VISTA
        $selectedWords = [];
        for($i=0; $i< count($postacentuation->words); $i++){
            array_push($selectedWords, $postacentuation->words[$i]->id);
        }

        //SE ENVIAN LAS REGLAS DE NIVEL 2 (SECTIONS) DONDE SU CAMPO TYPE SEA REGLAS ORTOGRAFICAS DE PALABRAS
        $sections = Section::where('type', "Reglas ortográficas de acentuación")->get();

        return view('admin.information.posts.postacentuation.edit', compact('postacentuation', 'words', 'selectedWords', 'numero', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $postacentuation)
    {
        $request->validate([
            'name' => 'required|string',
            'slug' => "required|unique:posts,slug,$postacentuation->id",
            'body' => 'required',
            'section_id' => 'required'
        ]);

        //ACTUALIZAR REGLA NIVEL 3 (POST)
        //CON EL IF SE PREGUNTA SI EN EL REQUEST SE ESTA ENVIANDO UNA IMAGEN O NO SE ESTA ENVIANDO NADA
        if($request->file('image')){
            //SI EL POST YA TENIA UNA IMAGEN, QUE SE ELIMINE LA IMAGEN ANTERIOR
            //SE PREGUNTA SI EL REGISTRO SECTIONWORD YA TENIA UNA IMAGEN O NO
            if(isset($postacentuation->image)){
                //SI EL REGISTRO SECTIONWORD YA TENIA UNA IMAGEN, QUE SE ELIMINE LA IMAGEN ANTERIOR
                Storage::delete($postacentuation->image);
            }
            //SE ACTUALIZA EL REGISTRO NUEVO DE SECTION WORD CON EL NUEVO CAMPO IMAGEN
            $postacentuation->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => Storage::put('reglasniveltresposts', $request->file('image')),
                'description' => $request->description,
                'body' => $request->body,
                'example' => $request->example,
                'exception' => $request->exception,
                'type' => "Reglas ortográficas de acentuación",
                'clasification' => "Reglas ortográficas de acentuación",
                'section_id' => $request->section_id
            ]);
        }else{
            //SI NO SE ESTA ENVIANDO IMAGENES ENTONCES QUE SE ACTUALICEEN LOS DEMAS CAMPOS MENOS LA IMAGEN
            $postacentuation->update([
                'name' => $request->name,
                'slug' => $request->slug,
                //'image' => Storage::put('reglasniveltresposts', $request->file('image')),
                'description' => $request->description,
                'body' => $request->body,
                'example' => $request->example,
                'exception' => $request->exception,
                'type' => "Reglas ortográficas de acentuación",
                'clasification' => "Reglas ortográficas de acentuación",
                'section_id' => $request->section_id
            ]);
        }

        //SE PONE EL METODO SYNC SIN EL IF PARA QUE SE PUEDA AGREGAR MAS WORDS O QUITAR TODAS LAS WORDS PORQUE CON EL IF
        //SI DESMARCABAMOS TODAS LAS WORDS, AL ENTRAR DE NUEVO LA RELACION NO SE QUITABA
        $postacentuation->words()->sync($request->words);

        return redirect()->route('admin.posts.postacentuation.index')->with('message', 'Regla actualizada correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $postacentuation)
    {
        //CON EL IF SE PREGUNTA SI EL REGISTRO TIENE UNA IMAGEN
        if(isset($postacentuation->image)){
            //SI ES ASI, ENTONCES SE ELIMINA LA IMAGEN Y LUEGO EL REGISTRO
            //SE ELIMINA LA IMAGEN ANTES DE ELIMINAR EL REGISTRO
            Storage::delete($postacentuation->image);
            $postacentuation->delete();
        }
        else{
            //SI NO ES ASI, ENTONCES SE ELIMINA EL REGISTRO
            $postacentuation->delete();
        }

        return redirect()->route('admin.posts.postacentuation.index')->with('message', 'Regla eliminada.');
    }
}
