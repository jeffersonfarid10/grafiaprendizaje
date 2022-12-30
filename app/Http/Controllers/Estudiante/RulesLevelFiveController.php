<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Note;
use App\Models\Post;
use App\Models\Rule;
use App\Models\Section;
use Illuminate\Http\Request;

class RulesLevelFiveController extends Controller
{
    //METODO PARA MOSTRAR EL DETALLE DE UNA REGLA DE NIVEL 5 DE PALABRAS (NOTEWORD)
    //COMO ARGUMENTO SE RECIBEN 5 PARAMETROS
    //$categoryword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 1 (CATEGORIES)
    //$sectionword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 2(SECTIONS)
    //$postword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 3 (POSTS)
    //$ruleword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 4 (RULES)
    //$noteword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 5 (NOTES)
    //EN EL METODO SE RECIBE EL SLUG DE CADA NIVEL DE REGLAS PARA BUSCAR SEGUN EL SLUG EL OBJETO TIPO
    //CATEGORYWORD, SECTIONWORD, POSTWORD, RULEWORD Y NOTEWORD
    public function showNoteWord($categoryword, $sectionword, $postword, $ruleword, $noteword){

        //BUSCAR EN LA TABLA CATEGORIES EL OBJETO TIPO CATEGORYWORD QUE TENGA EL MISMO SLUG QUE CATEGORYWORD
        $categorywordCollection = Category::where('slug', $categoryword)->get();

        //BUSCAR EN LA TABLA SECTIONS EL OBJETO TIPO SECTIONWORD QUE TENGA EL MISMO SLUG QUE SECTIONWORD
        $sectionwordCollection = Section::where('slug', $sectionword)->get();

        //BUSCAR EN LA TABLA POSTS EL OBJETO TIPO POSTWORD QUE TENGA EL MISMO SLUG QUE POSTWORD
        $postwordCollection = Post::where('slug', $postword)->get();

        //BUSCAR EN LA TABLA RULES EL OBJETO TIPO RULEWORD QUE TENGA EL MISMO SLUG QUE RULEWORD
        $rulewordCollection = Rule::where('slug', $ruleword)->get();

        //BUSCAR EN LA TABLA NOTES EL OBJETO TIPO NOTEWORD QUE TENGA EL MISMO SLUG QUE NOTEWORD
        $notewordCollection = Note::where('slug', $noteword)->get();


        //COMO LAS VARIABLES ANTERIORES CONTIENEN COLECCIONES DE ELEMENTOS, SOLO SE NECESITA EL PRIMER ELEMENTO 
        //DE CADA COLECCION
        $categorywordObject = $categorywordCollection->first();
        $sectionwordObject = $sectionwordCollection->first();
        $postwordObject = $postwordCollection->first();
        $rulewordObject = $rulewordCollection->first();
        $notewordObject = $notewordCollection->first();

        //EN LA VARIABLE SUGERENCIASNIVELUNO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        $sugerenciasniveluno = Category::orderByRaw("RAND()")->where('id', '!=', $categorywordObject->id)->where('type', "Reglas ortográficas de palabras")
                                                            ->limit(5)->get();
        
        //EN LA VARIABLE SUGERENCIASNIVELDOS SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        //Y QUE TENGAN EL MISMO CATEGORY_ID
        $sugerenciasniveldos = Section::orderByRaw("RAND()")->where('id', '!=', $sectionwordObject->id)->where('type', "Reglas ortográficas de palabras")
                                                            ->where('category_id', $sectionwordObject->category_id)->limit(5)->get();

        //EN LA VARIABLE SUGERENCIASNIVELTRES SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        //Y QUE TENGAN EL MISMO SECTION_ID
        $sugerenciasniveltres = Post::orderByRaw("RAND()")->where('id', '!=', $postwordObject->id)->where('type', "Reglas ortográficas de palabras")
                                                            ->where('section_id', $postwordObject->section_id)->limit(5)->get();

        //EN LA VARIABLE SUGERENCIASNIVELCUATRO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        //Y QUE TENGAN EL MISMO POST_ID
        $sugerenciasnivelcuatro = Rule::orderByRaw("RAND()")->where('id', '!=', $rulewordObject->id)->where('type', "Reglas ortográficas de palabras")
                                                            ->where('post_id', $rulewordObject->post_id)->limit(5)->get();


        //EN LA VARIABLE SUGERENCIASNIVELCINCO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        //Y QUE TENGAN EL MISMO RULE_ID
        $sugerenciasnivelcinco = Note::orderByRaw("RAND()")->where('id', '!=', $notewordObject->id)->where('type', "Reglas ortográficas de palabras")
                                                            ->where('rule_id', $notewordObject->rule_id)->limit(5)->get();

        return view('rules.notes.noteword.rule', compact('categorywordObject', 'sectionwordObject', 'postwordObject', 'rulewordObject', 'notewordObject'
                    , 'sugerenciasniveluno', 'sugerenciasniveldos', 'sugerenciasniveltres', 'sugerenciasnivelcuatro', 'sugerenciasnivelcinco'));
    }






    //METODO PARA MOSTRAR EL DETALLE DE UNA REGLA DE NIVEL 5 DE ACENTUACION (NOTEACENTUATION)
    //COMO ARGUMENTO SE RECIBEN 5 PARAMETROS
    //$categoryword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 1 (CATEGORIES)
    //$sectionword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 2(SECTIONS)
    //$postword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 3 (POSTS)
    //$ruleword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 4 (RULES)
    //$noteword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 5 (NOTES)
    //EN EL METODO SE RECIBE EL SLUG DE CADA NIVEL DE REGLAS PARA BUSCAR SEGUN EL SLUG EL OBJETO TIPO
    //CATEGORYWORD, SECTIONWORD, POSTWORD, RULEWORD Y NOTEWORD
    public function showNoteAcentuation($categoryacentuation, $sectionacentuation, $postacentuation, $ruleacentuation, $noteacentuation){

        //BUSCAR EN LA TABLA CATEGORIES EL OBJETO TIPO CATEGORYWORD QUE TENGA EL MISMO SLUG QUE CATEGORYWORD
        $categoryacentuationCollection = Category::where('slug', $categoryacentuation)->get();

        //BUSCAR EN LA TABLA SECTIONS EL OBJETO TIPO SECTIONWORD QUE TENGA EL MISMO SLUG QUE SECTIONWORD
        $sectionacentuationCollection = Section::where('slug', $sectionacentuation)->get();

        //BUSCAR EN LA TABLA POSTS EL OBJETO TIPO POSTWORD QUE TENGA EL MISMO SLUG QUE POSTWORD
        $postacentuationCollection = Post::where('slug', $postacentuation)->get();

        //BUSCAR EN LA TABLA RULES EL OBJETO TIPO RULEWORD QUE TENGA EL MISMO SLUG QUE RULEWORD
        $ruleacentuationCollection = Rule::where('slug', $ruleacentuation)->get();

        //BUSCAR EN LA TABLA NOTES EL OBJETO TIPO NOTEWORD QUE TENGA EL MISMO SLUG QUE NOTEWORD
        $noteacentuationCollection = Note::where('slug', $noteacentuation)->get();


        //COMO LAS VARIABLES ANTERIORES CONTIENEN COLECCIONES DE ELEMENTOS, SOLO SE NECESITA EL PRIMER ELEMENTO 
        //DE CADA COLECCION
        $categoryacentuationObject = $categoryacentuationCollection->first();
        $sectionacentuationObject = $sectionacentuationCollection->first();
        $postacentuationObject = $postacentuationCollection->first();
        $ruleacentuationObject = $ruleacentuationCollection->first();
        $noteacentuationObject = $noteacentuationCollection->first();

        //EN LA VARIABLE SUGERENCIASNIVELUNO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        $sugerenciasniveluno = Category::orderByRaw("RAND()")->where('id', '!=', $categoryacentuationObject->id)->where('type', "Reglas ortográficas de acentuación")
                                                            ->limit(5)->get();
        
        //EN LA VARIABLE SUGERENCIASNIVELDOS SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        //Y QUE TENGAN EL MISMO CATEGORY_ID
        $sugerenciasniveldos = Section::orderByRaw("RAND()")->where('id', '!=', $sectionacentuationObject->id)->where('type', "Reglas ortográficas de acentuación")
                                                            ->where('category_id', $sectionacentuationObject->category_id)->limit(5)->get();

        //EN LA VARIABLE SUGERENCIASNIVELTRES SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        //Y QUE TENGAN EL MISMO SECTION_ID
        $sugerenciasniveltres = Post::orderByRaw("RAND()")->where('id', '!=', $postacentuationObject->id)->where('type', "Reglas ortográficas de acentuación")
                                                            ->where('section_id', $postacentuationObject->section_id)->limit(5)->get();

        //EN LA VARIABLE SUGERENCIASNIVELCUATRO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        //Y QUE TENGAN EL MISMO POST_ID
        $sugerenciasnivelcuatro = Rule::orderByRaw("RAND()")->where('id', '!=', $ruleacentuationObject->id)->where('type', "Reglas ortográficas de acentuación")
                                                            ->where('post_id', $ruleacentuationObject->post_id)->limit(5)->get();


        //EN LA VARIABLE SUGERENCIASNIVELCINCO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        //Y QUE TENGAN EL MISMO RULE_ID
        $sugerenciasnivelcinco = Note::orderByRaw("RAND()")->where('id', '!=', $noteacentuationObject->id)->where('type', "Reglas ortográficas de acentuación")
                                                            ->where('rule_id', $noteacentuationObject->rule_id)->limit(5)->get();

        return view('rules.notes.noteacentuation.rule', compact('categoryacentuationObject', 'sectionacentuationObject', 'postacentuationObject', 'ruleacentuationObject', 'noteacentuationObject'
                    , 'sugerenciasniveluno', 'sugerenciasniveldos', 'sugerenciasniveltres', 'sugerenciasnivelcuatro', 'sugerenciasnivelcinco'));
    }



    //METODO PARA MOSTRAR EL DETALLE DE UNA REGLA DE NIVEL 5 DE PUNTUACION (NOTEPUNCTUATION)
    //COMO ARGUMENTO SE RECIBEN 5 PARAMETROS
    //$categoryword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 1 (CATEGORIES)
    //$sectionword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 2(SECTIONS)
    //$postword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 3 (POSTS)
    //$ruleword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 4 (RULES)
    //$noteword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 5 (NOTES)
    //EN EL METODO SE RECIBE EL SLUG DE CADA NIVEL DE REGLAS PARA BUSCAR SEGUN EL SLUG EL OBJETO TIPO
    //CATEGORYWORD, SECTIONWORD, POSTWORD, RULEWORD Y NOTEWORD
    public function showNotePunctuation($categorypunctuation, $sectionpunctuation, $postpunctuation, $rulepunctuation, $notepunctuation){

        //BUSCAR EN LA TABLA CATEGORIES EL OBJETO TIPO CATEGORYWORD QUE TENGA EL MISMO SLUG QUE CATEGORYWORD
        $categorypunctuationCollection = Category::where('slug', $categorypunctuation)->get();

        //BUSCAR EN LA TABLA SECTIONS EL OBJETO TIPO SECTIONWORD QUE TENGA EL MISMO SLUG QUE SECTIONWORD
        $sectionpunctuationCollection = Section::where('slug', $sectionpunctuation)->get();

        //BUSCAR EN LA TABLA POSTS EL OBJETO TIPO POSTWORD QUE TENGA EL MISMO SLUG QUE POSTWORD
        $postpunctuationCollection = Post::where('slug', $postpunctuation)->get();

        //BUSCAR EN LA TABLA RULES EL OBJETO TIPO RULEWORD QUE TENGA EL MISMO SLUG QUE RULEWORD
        $rulepunctuationCollection = Rule::where('slug', $rulepunctuation)->get();

        //BUSCAR EN LA TABLA NOTES EL OBJETO TIPO NOTEWORD QUE TENGA EL MISMO SLUG QUE NOTEWORD
        $notepunctuationCollection = Note::where('slug', $notepunctuation)->get();


        //COMO LAS VARIABLES ANTERIORES CONTIENEN COLECCIONES DE ELEMENTOS, SOLO SE NECESITA EL PRIMER ELEMENTO 
        //DE CADA COLECCION
        $categorypunctuationObject = $categorypunctuationCollection->first();
        $sectionpunctuationObject = $sectionpunctuationCollection->first();
        $postpunctuationObject = $postpunctuationCollection->first();
        $rulepunctuationObject = $rulepunctuationCollection->first();
        $notepunctuationObject = $notepunctuationCollection->first();

        //EN LA VARIABLE SUGERENCIASNIVELUNO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        $sugerenciasniveluno = Category::orderByRaw("RAND()")->where('id', '!=', $categorypunctuationObject->id)->where('type', "Reglas ortográficas de puntuación")
                                                            ->limit(5)->get();
        
        //EN LA VARIABLE SUGERENCIASNIVELDOS SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        //Y QUE TENGAN EL MISMO CATEGORY_ID
        $sugerenciasniveldos = Section::orderByRaw("RAND()")->where('id', '!=', $sectionpunctuationObject->id)->where('type', "Reglas ortográficas de puntuación")
                                                            ->where('category_id', $sectionpunctuationObject->category_id)->limit(5)->get();

        //EN LA VARIABLE SUGERENCIASNIVELTRES SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        //Y QUE TENGAN EL MISMO SECTION_ID
        $sugerenciasniveltres = Post::orderByRaw("RAND()")->where('id', '!=', $postpunctuationObject->id)->where('type', "Reglas ortográficas de puntuación")
                                                            ->where('section_id', $postpunctuationObject->section_id)->limit(5)->get();

        //EN LA VARIABLE SUGERENCIASNIVELCUATRO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        //Y QUE TENGAN EL MISMO POST_ID
        $sugerenciasnivelcuatro = Rule::orderByRaw("RAND()")->where('id', '!=', $rulepunctuationObject->id)->where('type', "Reglas ortográficas de puntuación")
                                                            ->where('post_id', $rulepunctuationObject->post_id)->limit(5)->get();


        //EN LA VARIABLE SUGERENCIASNIVELCINCO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL Y DEL MISMO TYPE
        //Y QUE TENGAN EL MISMO RULE_ID
        $sugerenciasnivelcinco = Note::orderByRaw("RAND()")->where('id', '!=', $notepunctuationObject->id)->where('type', "Reglas ortográficas de puntuación")
                                                            ->where('rule_id', $notepunctuationObject->rule_id)->limit(5)->get();

        return view('rules.notes.notepunctuation.rule', compact('categorypunctuationObject', 'sectionpunctuationObject', 'postpunctuationObject', 'rulepunctuationObject', 'notepunctuationObject'
                    , 'sugerenciasniveluno', 'sugerenciasniveldos', 'sugerenciasniveltres', 'sugerenciasnivelcuatro', 'sugerenciasnivelcinco'));
    }

}
