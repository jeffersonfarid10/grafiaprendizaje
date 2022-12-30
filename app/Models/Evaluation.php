<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Result;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'type', 'format', 'slug'];

    //MOSTRAR SLUG
    public function getRouteKeyName()
    {
        return "slug";
    }


    //RELACION MUCHOS A MUCHOS CON LA TABLA USERS
    public function users(){
        return $this->belongsToMany(User::class);
    }

    //RELACION UNO A MUCHOS CON QUESTIONS
    public function questions(){
        return $this->hasMany(Question::class);
    }


    //METODO PARA MOSTRAR EN LA VISTA DEL ESTUDIANTE LOS EXAMENES QUE YA HA RESPONDIDO
    public function hasEvaluationAttempted(){
        //SE CREA UN ARRAY QUE VA A CONTENER A LOS REGISTROS DE LA TABLA RESULTS, QUE SON LOS EXAMENES QUE EL ESTUDIANTE ACTUAL HA RESPONDIDO
        $attemptedEvaluation = [];

        //EN LA VARIABLE AUTHUSER SE GUARDA EL ID DEL USUARIO ACTUAL LOGEADO
        $authUser = auth()->user()->id;

        //EN LA VARIABLE USER SE GUARDAR LA COLECCION DE REGISTROS QUE SE HAYA ENCONTRADO EN LA TABLA RESULTS, QUE COINCIDAN CON EL ID DEL USUARIO
        //QUE ESTA LOGEADO, ES DECIR, LOS EXAMENES QUE EL USUARIO ACTUAL YA HA RESPONDIDO
        $user = Result::where('user_id', $authUser)->get();
        //CON EL FOREACH SE RECORRE LA COLECCION DE EXAMENES RESUELTOS POR EL USUARIO ACTUAL PARA MOSTRARLOS EN LA VISTA
        foreach($user as $u){
            //CON EL ARRAY_PUSH SE AGREGA EN EL ARRAY ATTEMPTEDEVALUATION, LOS EXAMANES RESPONDIDOS
            array_push($attemptedEvaluation, $u->evaluation_id);
        }

        return $attemptedEvaluation;
    }
}
