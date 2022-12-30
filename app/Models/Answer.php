<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['answer', 'is_correct', 'visible_answer', 'second_answer', 'question_id'];

    //RELACION UNO A MUCHOS CON LA TABLA JUSTIFICATIONS
    //public function justifications(){
    //    return $this->hasMany(Justification::class);
    //}

    //RELACION UNO A MUCHOS CON LA TABLA RESULTS
    //public function results(){
    //    return $this->hasMany(Result::class);
    //}

    //RELACION MUCHOS A UNO CON LA TABLA QUESTION
    public function question(){
        return $this->belongsTo(Question::class);
    }
    

}
