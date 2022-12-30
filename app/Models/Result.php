<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['answer_user', 'score', 'user_id', 'question_id', 'evaluation_id', 'answer_id'];

    //RELACION MUCHOS A UNO CON ANSWER
    //public function answer(){
   //     return $this->belongsTo(Answer::class);
    //}

    //RELACION UNO A MUCHOS CON LA TABLA QUESTION
    public function question(){
        return $this->belongsTo(Question::class);
    }
}
