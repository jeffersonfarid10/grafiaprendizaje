<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indication extends Model
{
    use HasFactory;

    protected $fillable = ['indication', 'question_id'];

    //RELACION MUCHOS A UNO CON LA TABLA QUESTION
    public function question(){
        return $this->belongsTo(Question::class);
    }


}
