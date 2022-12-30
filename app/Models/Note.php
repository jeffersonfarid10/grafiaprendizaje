<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'description', 'body', 'example', 'exception', 'rule_id', 'type', 'clasification'];

    //METODO PARA MOSTRAR SLUG
    public function getRouteKeyName()
    {
        return "slug";
    }

    //RELACION MUCHOS A MUCHOS CON WORDS
    public function words(){
        return $this->belongsToMany(Word::class);
    }

    //RELACION MUCHOS A UNO CON RULES
    public function rule(){
        return $this->belongsTo(Rule::class);
    }

    //RELACION MUCHOS A MUCHOS CON QUESTIONS
    public function questions(){
        return $this->belongsToMany(Question::class);
    }
}
