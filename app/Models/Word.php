<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'meaning', 'font'];


    //RELACION MUCHOS A MUCHOS CON CATEGORIES
    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    //RELACION MUCHOS A MUCHOS CON SECTIONS
    public function sections(){
        return $this->belongsToMany(Section::class);
    }

    //RELACION MUCHOS A MUCHOS CON POSTS
    public function posts(){
        return $this->belongsToMany(Post::class);
    }

    //RELACION MUCHOS A MUCHOS CON RULES
    public function rules(){
        return $this->belongsToMany(Rule::class);
    }

    //RELACION MUCHOS A MUCHOS CON NOTES
    public function notes(){
        return $this->belongsToMany(Note::class);
    }
}
