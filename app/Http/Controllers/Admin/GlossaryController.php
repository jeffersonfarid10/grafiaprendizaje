<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Word;

class GlossaryController extends Controller
{

    //CONTROLADOR PARA CONTROLAR EL ACCESO A LAS RUTAS INDEX,CREATE, EDIT, DESTROY DE UNA RUTA TIPO RESOURCE DE WEB.PHP
    public function __construct()
    {
        //SE INVOCA A UN PERMISO CREADO Y AL METODO QUE VA A PROTEGER ESE PERMISO
        $this->middleware('can:admin.glossary.index')->only('index');
        $this->middleware('can:admin.glossary.create')->only('create', 'store');
        $this->middleware('can:admin.glossary.edit')->only('edit', 'update');
        $this->middleware('can:admin.glossary.show')->only('show');
        $this->middleware('can:admin.glossary.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //INGRESAR AL INDEX DEL GLOSARIO
    public function index()
    {

        //$glossaries = Word::all();

        //ACTUALIZACION CONSULTA CON PAGINACION
        $glossaries = Word::orderBy('id', 'DESC')->paginate(10);

        return view('admin.glossary.index', compact('glossaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.glossary.create');
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
            'meaning' => 'required|string',
        ]);


        Word::create([
            'name' => $request->name,
            'meaning' => $request->meaning,
            'font' => $request->font
        ]);

        return redirect()->route('admin.glossary.index')->with('message', 'Término creado correctamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Word $glossary)
    {
        return view('admin.glossary.show', compact('glossary'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Word $glossary)
    {
        return view('admin.glossary.edit', compact('glossary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Word $glossary)
    {
        $request->validate([
            'name' => 'required|string',
            'meaning' => 'required|string',
        ]);

        $glossary->update([
            'name' => $request->name,
            'meaning' => $request->meaning,
            'font' => $request->font
        ]);

        return redirect()->route('admin.glossary.index')->with('message', 'Término actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Word $glossary)
    {
        $glossary->delete();

        return redirect()->route('admin.glossary.index')->with('message', 'Término eliminado.');
    }
}
