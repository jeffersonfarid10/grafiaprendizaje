<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'description', 'body', 'example', 'exception', 'user_id', 'type', 'clasification'];

    //METODO PARA MOSTRAR EL SLUG
    public function getRouteKeyName()
    {
        return "slug";
    }

    //RELACION MUCHOS A MUCHOS CON LA TABLA WORDS
    public function words(){
        return $this->belongsToMany(Word::class);
    }

    //RELACION UNO A MUCHOS CON LA TABLA SECTIONS
    public function sections(){
        return $this->hasMany(Section::class);
    }

    //RELACION MUCHOS A UNO CON LA TABLA USERS
    public function user(){
        return $this->belongsTo(User::class);
    }


    //RELACION MUCHOS A MUCHOS CON LA TABLA QUESTIONS
    public function questions(){
        return $this->belongsToMany(Question::class);
    }
}
