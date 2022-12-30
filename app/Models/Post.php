<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'description', 'body', 'example', 'exception', 'section_id', 'type', 'clasification'];

    //METODO PARA SLUG
    public function getRouteKeyName()
    {
        return "slug";
    }

    //RELACION MUCHOS A MUCHOS CON WORDS
    public function words(){
        return $this->belongsToMany(Word::class);
    }

    //RELACION UNO A MUCHOS CON RULES
    public function rules(){
        return $this->hasMany(Rule::class);
    }
    
    //RELACION MUCHOS A UNO CON SECTIONS
    public function section(){
        return $this->belongsTo(Section::class);
    }

    //RELACION MUCHOS A MUCHOS CON QUESTIONS
    public function questions(){
        return $this->belongsToMany(Question::class);
    }
}
