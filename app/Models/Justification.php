<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Justification extends Model
{
    use HasFactory;

    protected $fillable = ['reason', 'rule', 'question_id'];

    //RELACION MUCHOS A UNO CON ANSWER
    //public function answer(){
    //    return $this->belongsTo(Answer::class);
    //}

    //RELACION MUCHOS A UNO CON QUESTION
    public function question(){
        return $this->belongsTo(Question::class);
    }
}
