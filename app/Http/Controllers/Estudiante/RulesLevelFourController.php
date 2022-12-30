<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Rule;


class RulesLevelFourController extends Controller
{
    //METODO PARA MOSTRAR EL DETALLE DE UNA REGLA DE NIVEL 4 DE PALABRAS (RULEWORD)
    //COMO ARGUMENTO SE RECIBEN 4 PARAMETROS
    //$categoryword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 1 (CATEGORIES)
    //$sectionword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 2(SECTIONS)
    //$postword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 3 (POSTS)
    //$ruleword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 4 (RULES)
    //EN EL METODO SE RECIBE EL SLUG DE CADA NIVEL DE REGLAS PARA BUSCAR SEGUN EL SLUG EL OBJETO TIPO
    //CATEGORYWORD, SECTIONWORD, POSTWORD Y RULEWORD
    public function showRuleWord($categoryword, $sectionword, $postword, $ruleword){

        //BUSCAR EN LA TABLA CATEGORIES EL OBJETO TIPO CATEGORYWORD QUE TENGA EL MISMO SLUG QUE $CATEGORYWORD
        $categorywordCollection = Category::where('slug', $categoryword)->get();

        //BUSCAR EN LA TABLA SECTIONS EL OBJETO TIPO SECTIONWORD QUE TENGA EL MISMO SLUG QUE $SECTIONWORD
        $sectionwordCollection = Section::where('slug', $sectionword)->get();

        //BUSCAR EN LA TABLA POSTS EL OBJETO TIPO POSTWORD QUE TENGA EL MISMO SLUG QUE $POSTWORD
        $postwordCollection = Post::where('slug', $postword)->get();

        //BUSCAR EN LA TABLA RULES EL OBJETO TIPO RULEWORD QUE TENGA EL MISMO SLUG DE $RULEWORD
        $rulewordCollection = Rule::where('slug', $ruleword)->get();


        //COMO LAS VARIABLES ANTERIORES CONTIENEN COLECCION DE ELEMENTOS, SOLO SE NECESITA EL PRIMER ELEMENTO 
        //DE CADA COLECCION 
        $categorywordObject = $categorywordCollection->first();
        $sectionwordObject = $sectionwordCollection->first();
        $postwordObject = $postwordCollection->first();
        $rulewordObject = $rulewordCollection->first();

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

        
        return view('rules.rules.ruleword.rule', compact('categorywordObject', 'sectionwordObject', 'postwordObject', 'rulewordObject', 'sugerenciasniveluno', 'sugerenciasniveldos'
                    , 'sugerenciasniveltres', 'sugerenciasnivelcuatro'));

    }



    //METODO PARA MOSTRAR EL DETALLE DE UNA REGLA DE NIVEL 4 DE ACENTUACION (RULEACENTUATION)
    //COMO ARGUMENTO SE RECIBEN 4 PARAMETROS
    //$categoryword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 1 (CATEGORIES)
    //$sectionword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 2(SECTIONS)
    //$postword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 3 (POSTS)
    //$ruleword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 4 (RULES)
    //EN EL METODO SE RECIBE EL SLUG DE CADA NIVEL DE REGLAS PARA BUSCAR SEGUN EL SLUG EL OBJETO TIPO
    //CATEGORYWORD, SECTIONWORD, POSTWORD Y RULEWORD
    public function showRuleAcentuation($categoryacentuation, $sectionacentuation, $postacentuation, $ruleacentuation){

        //BUSCAR EN LA TABLA CATEGORIES EL OBJETO TIPO CATEGORYWORD QUE TENGA EL MISMO SLUG QUE $CATEGORYWORD
        $categoryacentuationCollection = Category::where('slug', $categoryacentuation)->get();

        //BUSCAR EN LA TABLA SECTIONS EL OBJETO TIPO SECTIONWORD QUE TENGA EL MISMO SLUG QUE $SECTIONWORD
        $sectionacentuationCollection = Section::where('slug', $sectionacentuation)->get();

        //BUSCAR EN LA TABLA POSTS EL OBJETO TIPO POSTWORD QUE TENGA EL MISMO SLUG QUE $POSTWORD
        $postacentuationCollection = Post::where('slug', $postacentuation)->get();

        //BUSCAR EN LA TABLA RULES EL OBJETO TIPO RULEWORD QUE TENGA EL MISMO SLUG DE $RULEWORD
        $ruleacentuationCollection = Rule::where('slug', $ruleacentuation)->get();


        //COMO LAS VARIABLES ANTERIORES CONTIENEN COLECCION DE ELEMENTOS, SOLO SE NECESITA EL PRIMER ELEMENTO 
        //DE CADA COLECCION 
        $categoryacentuationObject = $categoryacentuationCollection->first();
        $sectionacentuationObject = $sectionacentuationCollection->first();
        $postacentuationObject = $postacentuationCollection->first();
        $ruleacentuationObject = $ruleacentuationCollection->first();

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

        
        return view('rules.rules.ruleacentuation.rule', compact('categoryacentuationObject', 'sectionacentuationObject', 'postacentuationObject', 'ruleacentuationObject', 'sugerenciasniveluno', 'sugerenciasniveldos'
                    , 'sugerenciasniveltres', 'sugerenciasnivelcuatro'));

    }


    //METODO PARA MOSTRAR EL DETALLE DE UNA REGLA DE NIVEL 4 DE PUNTUACION (RULEPUNCTUATION)
    //COMO ARGUMENTO SE RECIBEN 4 PARAMETROS
    //$categoryword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 1 (CATEGORIES)
    //$sectionword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 2(SECTIONS)
    //$postword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 3 (POSTS)
    //$ruleword QUE CONTIENE EL SLUG DE LA REGLA NIVEL 4 (RULES)
    //EN EL METODO SE RECIBE EL SLUG DE CADA NIVEL DE REGLAS PARA BUSCAR SEGUN EL SLUG EL OBJETO TIPO
    //CATEGORYWORD, SECTIONWORD, POSTWORD Y RULEWORD
    public function showRulePunctuation($categorypunctuation, $sectionpunctuation, $postpunctuation, $rulepunctuation){

        //BUSCAR EN LA TABLA CATEGORIES EL OBJETO TIPO CATEGORYWORD QUE TENGA EL MISMO SLUG QUE $CATEGORYWORD
        $categorypunctuationCollection = Category::where('slug', $categorypunctuation)->get();

        //BUSCAR EN LA TABLA SECTIONS EL OBJETO TIPO SECTIONWORD QUE TENGA EL MISMO SLUG QUE $SECTIONWORD
        $sectionpunctuationCollection = Section::where('slug', $sectionpunctuation)->get();

        //BUSCAR EN LA TABLA POSTS EL OBJETO TIPO POSTWORD QUE TENGA EL MISMO SLUG QUE $POSTWORD
        $postpunctuationCollection = Post::where('slug', $postpunctuation)->get();

        //BUSCAR EN LA TABLA RULES EL OBJETO TIPO RULEWORD QUE TENGA EL MISMO SLUG DE $RULEWORD
        $rulepunctuationCollection = Rule::where('slug', $rulepunctuation)->get();


        //COMO LAS VARIABLES ANTERIORES CONTIENEN COLECCION DE ELEMENTOS, SOLO SE NECESITA EL PRIMER ELEMENTO 
        //DE CADA COLECCION 
        $categorypunctuationObject = $categorypunctuationCollection->first();
        $sectionpunctuationObject = $sectionpunctuationCollection->first();
        $postpunctuationObject = $postpunctuationCollection->first();
        $rulepunctuationObject = $rulepunctuationCollection->first();

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

        
        return view('rules.rules.rulepunctuation.rule', compact('categorypunctuationObject', 'sectionpunctuationObject', 'postpunctuationObject', 'rulepunctuationObject', 'sugerenciasniveluno', 'sugerenciasniveldos'
                    , 'sugerenciasniveltres', 'sugerenciasnivelcuatro'));

    }
}
