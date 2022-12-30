<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use App\Models\Post;

class RulesLevelThreeController extends Controller
{
    //METODO PARA MOSTRAR EL DETALLE DE UNA REGLA DE NIVEL 3 DE PALABRAS (POSTWORD)
    //COMO ARGUMENTO SE RECIBEN 3 PARAMETROS:
    //$categoryword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 1 (CATEGORIES)
    //$sectionword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 2 (SECTIONS)
    //$postword QUE CONTIENE EL SLUG DE LA REGLA ACTUAL (POST)
    //EN EL METODO SEE RECIBE EL SLUG DE CADA NIVEL DE REGLAS PARA BUSCAR SEGUN EL SLUG EL OBJETO TIPO
    //CATEGORYWORD, SECTIONWORD Y POSTWORD
    public function showPostWord($categoryword, $sectionword, $postword){

        
        //BUSCAR EN LA TABLA CATEGORIES EL OBJETO TIPO CATEGORYWORD QUE TENGA EL MISMO SLUG QUE $CATEGORYWORD
        $categorywordCollection = Category::where('slug', $categoryword)->get();

        //BUSCAR EN LA TABLA SECTIONS EL OBJETO TIPO SECTIONWORD QUE TENGA EL MISMO SLUG QUE $SECTIONWORD
        $sectionwordCollection = Section::where('slug', $sectionword)->get();

        //BUSCAR EN LA TABLA POSTS EL OBJETO TIPO POSTWORD QUE TENGA EL MISMO SLUG QUE $POSTWORD
        $postwordCollection = Post::where('slug', $postword)->get();

        //COMO LAS VARIABLES ANTERIORES CONTIENEN COLECCIONES DE ELEMENTOS, SOLO SE NECESITA EL PRIMER ELEMENTO
        //DE CADA COLECCION
        $categorywordObject = $categorywordCollection->first();
        $sectionwordObject = $sectionwordCollection->first();
        $postwordObject = $postwordCollection->first();

        //EN LA VARIABLE SUGERENCIASNIVELUNO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL, Y DEL MISMO TYPE
        $sugerenciasniveluno = Category::orderByRaw("RAND()")->where('id', '!=', $categorywordObject->id)->where('type', "Reglas ortográficas de palabras")
                                                            ->limit(5)->get();

        //EN LA VARIABLE SUGERENCIASNIVELODOS SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL, DEL MISMO TYPE Y QUE
        //TENGAN EL MISMO CATEGORY_ID
        $sugerenciasniveldos = Section::orderByRaw("RAND()")->where('id', '!=', $sectionwordObject->id)->where('type', "Reglas ortográficas de palabras")
                                                            ->where('category_id', $sectionwordObject->category_id)->limit(5)->get();

        //EN LA VARIABLE SUGERENCIASNIVELTREES SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL, DEL MISMO TYPE Y QUE 
        //TENGAN EL MISMO SECTION_ID
        $sugerenciasniveltres = Post::orderByRaw("RAND()")->where('id', '!=', $postwordObject->id)->where('type', "Reglas ortográficas de palabras")
                                                        ->where('section_id', $postwordObject->section_id)->limit(5)->get();

        return view('rules.posts.postword.rule', compact('categorywordObject', 'sectionwordObject', 'postwordObject', 'sugerenciasniveluno', 'sugerenciasniveldos', 'sugerenciasniveltres'));
    }




    //METODO PARA MOSTRAR EL DETALLE DE UNA  REGLA DE NIVEL 3 DE ACENTUACION (POSTACENTUATION)
    //COMO ARGUMENTO SE RECIBEN 3 PARAMETROS:
    //$categoryword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 1 (CATEGORIES)
    //$sectionword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 2 (SECTIONS)
    //$postword QUE CONTIENE EL SLUG DE LA REGLA ACTUAL (POST)
    //EN EL METODO SEE RECIBE EL SLUG DE CADA NIVEL DE REGLAS PARA BUSCAR SEGUN EL SLUG EL OBJETO TIPO
    //CATEGORYWORD, SECTIONWORD Y POSTWORD
    public function showPostAcentuation($categoryacentuation, $sectionacentuation, $postacentuation){

        
        //BUSCAR EN LA TABLA CATEGORIES EL OBJETO TIPO CATEGORYWORD QUE TENGA EL MISMO SLUG QUE $CATEGORYWORD
        $categoryacentuationCollection = Category::where('slug', $categoryacentuation)->get();

        //BUSCAR EN LA TABLA SECTIONS EL OBJETO TIPO SECTIONWORD QUE TENGA EL MISMO SLUG QUE $SECTIONWORD
        $sectionacentuationCollection = Section::where('slug', $sectionacentuation)->get();

        //BUSCAR EN LA TABLA POSTS EL OBJETO TIPO POSTWORD QUE TENGA EL MISMO SLUG QUE $POSTWORD
        $postacentuationCollection = Post::where('slug', $postacentuation)->get();

        //COMO LAS VARIABLES ANTERIORES CONTIENEN COLECCIONES DE ELEMENTOS, SOLO SE NECESITA EL PRIMER ELEMENTO
        //DE CADA COLECCION
        $categoryacentuationObject = $categoryacentuationCollection->first();
        $sectionacentuationObject = $sectionacentuationCollection->first();
        $postacentuationObject = $postacentuationCollection->first();

        //EN LA VARIABLE SUGERENCIASNIVELUNO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL, Y DEL MISMO TYPE
        $sugerenciasniveluno = Category::orderByRaw("RAND()")->where('id', '!=', $categoryacentuationObject->id)->where('type', "Reglas ortográficas de acentuación")
                                                            ->limit(5)->get();

        //EN LA VARIABLE SUGERENCIASNIVELODOS SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL, DEL MISMO TYPE Y QUE
        //TENGAN EL MISMO CATEGORY_ID
        $sugerenciasniveldos = Section::orderByRaw("RAND()")->where('id', '!=', $sectionacentuationObject->id)->where('type', "Reglas ortográficas de acentuación")
                                                            ->where('category_id', $sectionacentuationObject->category_id)->limit(5)->get();

        //EN LA VARIABLE SUGERENCIASNIVELTREES SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL, DEL MISMO TYPE Y QUE 
        //TENGAN EL MISMO SECTION_ID
        $sugerenciasniveltres = Post::orderByRaw("RAND()")->where('id', '!=', $postacentuationObject->id)->where('type', "Reglas ortográficas de acentuación")
                                                        ->where('section_id', $postacentuationObject->section_id)->limit(5)->get();

        return view('rules.posts.postacentuation.rule', compact('categoryacentuationObject', 'sectionacentuationObject', 'postacentuationObject', 'sugerenciasniveluno', 'sugerenciasniveldos', 'sugerenciasniveltres'));
    }




    //METODO PARA MOSTRAR EL DETALLE DE UNA  REGLA DE NIVEL 3 DE PUNTUACION (POSTPUNCTUATION)
    //COMO ARGUMENTO SE RECIBEN 3 PARAMETROS:
    //$categoryword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 1 (CATEGORIES)
    //$sectionword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 2 (SECTIONS)
    //$postword QUE CONTIENE EL SLUG DE LA REGLA ACTUAL (POST)
    //EN EL METODO SEE RECIBE EL SLUG DE CADA NIVEL DE REGLAS PARA BUSCAR SEGUN EL SLUG EL OBJETO TIPO
    //CATEGORYWORD, SECTIONWORD Y POSTWORD
    public function showPostPunctuation($categorypunctuation, $sectionpunctuation, $postpunctuation){

        
        //BUSCAR EN LA TABLA CATEGORIES EL OBJETO TIPO CATEGORYWORD QUE TENGA EL MISMO SLUG QUE $CATEGORYWORD
        $categorypunctuationCollection = Category::where('slug', $categorypunctuation)->get();

        //BUSCAR EN LA TABLA SECTIONS EL OBJETO TIPO SECTIONWORD QUE TENGA EL MISMO SLUG QUE $SECTIONWORD
        $sectionpunctuationCollection = Section::where('slug', $sectionpunctuation)->get();

        //BUSCAR EN LA TABLA POSTS EL OBJETO TIPO POSTWORD QUE TENGA EL MISMO SLUG QUE $POSTWORD
        $postpunctuationCollection = Post::where('slug', $postpunctuation)->get();

        //COMO LAS VARIABLES ANTERIORES CONTIENEN COLECCIONES DE ELEMENTOS, SOLO SE NECESITA EL PRIMER ELEMENTO
        //DE CADA COLECCION
        $categorypunctuationObject = $categorypunctuationCollection->first();
        $sectionpunctuationObject = $sectionpunctuationCollection->first();
        $postpunctuationObject = $postpunctuationCollection->first();

        //EN LA VARIABLE SUGERENCIASNIVELUNO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL, Y DEL MISMO TYPE
        $sugerenciasniveluno = Category::orderByRaw("RAND()")->where('id', '!=', $categorypunctuationObject->id)->where('type', "Reglas ortográficas de puntuación")
                                                            ->limit(5)->get();

        //EN LA VARIABLE SUGERENCIASNIVELODOS SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL, DEL MISMO TYPE Y QUE
        //TENGAN EL MISMO CATEGORY_ID
        $sugerenciasniveldos = Section::orderByRaw("RAND()")->where('id', '!=', $sectionpunctuationObject->id)->where('type', "Reglas ortográficas de puntuación")
                                                            ->where('category_id', $sectionpunctuationObject->category_id)->limit(5)->get();

        //EN LA VARIABLE SUGERENCIASNIVELTREES SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL, DEL MISMO TYPE Y QUE 
        //TENGAN EL MISMO SECTION_ID
        $sugerenciasniveltres = Post::orderByRaw("RAND()")->where('id', '!=', $postpunctuationObject->id)->where('type', "Reglas ortográficas de puntuación")
                                                        ->where('section_id', $postpunctuationObject->section_id)->limit(5)->get();

        return view('rules.posts.postpunctuation.rule', compact('categorypunctuationObject', 'sectionpunctuationObject', 'postpunctuationObject', 'sugerenciasniveluno', 'sugerenciasniveldos', 'sugerenciasniveltres'));
    }
}
 