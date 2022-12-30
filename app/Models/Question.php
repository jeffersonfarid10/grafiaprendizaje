<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'audio', 'type', 'rule', 'evaluation_id', 'slug'];

    //MOSTRAR SLUG
    public function getRouteKeyName()
    {
        return "slug";
    }

    //RELACION UNO A MUCHOS CON LA TABLA INDICATIONS
    public function indications(){
        return $this->hasMany(Indication::class);
    }

    //RELACION UNO A MUCHOS CON LA TABLA ANSWERS
    public function answers(){
        return $this->hasMany(Answer::class);
    }

    //RELACION MUCHOS A UNO CON LA TABLA EVALUATIONS
    public function evaluation(){
        return $this->belongsTo(Evaluation::class);
    }

    //RELACION UNO A MUCHOS CON LA TABLA JUSTIFICATIONS
    public function justifications(){
        return $this->hasMany(Justification::class);
    }

    //RELACION UNO A MUCHOS CON LA TABLA RESULTS
    public function results(){
        return $this->hasMany(Result::class);
    }

    //RELACION MUCHOS A MUCHOS CON LA TABLA CATEGORIES
    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    //RELACION MUCHOS A MUCHOS CON LA TABLA SECTIONS
    public function sections(){
        return $this->belongsToMany(Section::class);
    }

    //RELACION MUCHOS A MUCHOS CON LA TABLA POSTS
    public function posts(){
        return $this->belongsToMany(Post::class);
    }

    //RELACION MUCHOS A MUCHOS CON LA TABLA RULES
    public function rules(){
        return $this->belongsToMany(Rule::class);
    }

    //RELACION MUCHOS A MUCHOS CON LA TABLA NOTES
    public function notes(){
        return $this->belongsToMany(Note::class);
    }


    //METODO PARA MOSTRAR EN LA VISTA DEL ESTUDIANTE LAS QUESTIONS QUE YA HA RESPONDIDO
    public function hasQuestionAttempted(){
        //SE CREA UN ARRAY QUE VA A CONTENER A LOS REGISTROS DE LA TABLA RESULTS, QUE SON LAS QUESTIONS QUE EL ESTUDIANTE ACTUAL HA RESPONDIDO
        $attemptedQuestion = [];

        //EN LA VARIABLA AUTHUSER SE GUARDA EL ID DEL USUARIO ACTUAL LOGEADO
        $authUser = auth()->user()->id;

        //EN LA VARIABLE USER SE GUARDA LA COLECCION DE REGISTROS QUE SE HAYA ENCONTRADO EN LA TABLA RESULTS, QUE COINCIDAN CON EL ID DEL USUARIO ACTUAL
        //QUE ESTA LOGEADO, ES DECIR LAS PREGUNTAS QUE EL USUARIO ACTUAL YA HA RESPONDIDO
        $user = Result::where('user_id', $authUser)->get();
        //CON EL FOREACH SEE RECORRE LA COLECCION DE PREGUNTAS RESPONDIDAS POR EL USUARIO ACTUAL PARA MOSTRARLAS EN LA VISTA
        foreach($user as $u){
            //CON EL ARRAY_PUSH SE AGREGA EN EL ARRAY ATTEMPTEDQUESTION, LAS PREGUNTAS RESPONDIDAS
            array_push($attemptedQuestion, $u->question_id);
        }

        return $attemptedQuestion;
    }
}
