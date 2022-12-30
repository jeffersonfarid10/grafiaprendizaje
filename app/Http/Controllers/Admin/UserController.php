<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Result;
//IMPORTAR MODELO ROLE PARA LA ASIGNACION DE ROLES
use Spatie\Permission\Models\Role;


class UserController extends Controller
{

    //CONTROLADOR PARA CONTROLAR EL ACCESO A LAS RUTAS INDEX,CREATE, EDIT, DESTROY DE UNA RUTA TIPO RESOURCE DE WEB.PHP
    public function __construct()
    {
        //SE INVOCA A UN PERMISO CREADO Y AL METODO QUE VA A PROTEGER ESE PERMISO
        $this->middleware('can:admin.user.index')->only('index');
        $this->middleware('can:admin.user.create')->only('create', 'store');
        $this->middleware('can:admin.user.edit')->only('edit', 'update');
        $this->middleware('can:admin.user.show')->only('show');
        $this->middleware('can:admin.user.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //ENVIAR A LA VISTA QUE TIENE EL LISTADO DE USUARIOS
        $users = User::orderBy('id', 'DESC')->paginate(10);

        return view('admin.roles.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(User $user)
    {
        //CAPTURAR EL LISTADO DE TODOS LOS ROLES DISPONIBLES
        $roles = Role::all();

        //SE ENVIAR A LA VISTA LOS ROLES QUE HAN SIDO ASIGNADOS AL USUARIO
        //SE CREA UN ARRAY PARA ALMACENAR LOS IDS Y CON UN FOR SE RECORRE LA RELACION ENTRE EL USUARIO
        //Y LOS ROLES QUE TIENE ASIGNADOS
        //PARA CAPTURAR LOS ROLES QUE EL USUARIO TIENE ASIGNADOS Y ENVIARLOS A LA VISTA
        $selectedRoles = [];
        for($i=0; $i<count($user->roles); $i++){
            array_push($selectedRoles, $user->roles[$i]->id);
        }

        
        return view('admin.roles.edit', compact('user', 'roles', 'selectedRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //return $request;

        //ASIGNAR ROLES AL USUARIO SELECCIONADO
        //SE ASIGNA UN NUEVO ROL AL USUARIO EN LA TABLA MODEL_HAS_ROLES MEDIANTE LA SIGUIENTE LINEA
        $user->roles()->sync($request->rolesseleccionados);

        return redirect()->route('admin.user.index')->with('message', 'Roles asignados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //CONTROLAR QUE SI UN USUARIO HA RESPONDIDO EXAMENES, ENTONCES NO SE PUEDA BORRAR EL USUARIO
        $wasUserResponse = Result::where('user_id', $user->id)->exists();

        //SI WASUSERRESPONSE ES TRUE, SIGNIFICA QUE ESE USUARIO YA RESPONDIO A ALGUN EXAMEN, ENTONCES NO SE PUEDE ELIMINAR
        //PERO SI ES FALSE ENTONCES SE ELIMINA EL USUARIO
        if($wasUserResponse === true){
            return redirect()->route('admin.user.index')->with('message', 'El usuario ha respondido preguntas, no se puede eliminar');
        }
        else{

            $user->delete();

            return redirect()->route('admin.user.index')->with('message', 'Usuario eliminado');
        }
    }
}
