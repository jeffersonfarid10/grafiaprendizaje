<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'body', 'description', 'example', 'exception', 'category_id', 'type', 'clasification'];

    //METODO PARA SLUG
    public function getRouteKeyName()
    {
        return "slug";
    }

    //RELACION MUCHOS A MUCHOS TABLA WORDS
    public function words(){
        return $this->belongsToMany(Word::class);
    }

    //RELACION UNO A MUCHOS CON LA TABLA POSTS
    public function posts(){
        return $this->hasMany(Post::class);
    }

    //RELACION MUCHOS A UNO CON LA TABLA CATEGORIES
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //RELACION MUCHOS A MUCHOS CON LA TABLA QUESTIONS
    public function questions(){
        return $this->belongsToMany(Question::class);
    }

    
}
