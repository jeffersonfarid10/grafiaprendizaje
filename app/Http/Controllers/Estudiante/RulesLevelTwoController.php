<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Category;

class RulesLevelTwoController extends Controller
{
    //METODO PARA MOSTRAR EL DETALLE DE UNA REGLA DE NIVEL 2 DE PALABRAS (SECTIONWORD)
    
    //public function showSectionWord(Category $categoryword, Section $sectionword){
    //public function showSectionWord(Section $sectionword){
    //EN EL METODO SE RECIBE EL SLUG DE CATEGORY WORD Y EL SLUG DE SECTION WORD
    //PARA BUSCAR SEGUN EL SLUG EL OBJETO TIPO CATEGORYWORD Y SECTIONWORD RESPECTIVOS
    public function showSectionWord($categoryword, $sectionword){
        
        
        //BUSCAR EN LA TABLA CATEGORIES EL OBJETO TIPO CATEGORYWORD QUE TENGA EL MISMO SLUG QUE $categoryword
        $categorywordCollection = Category::where('slug', $categoryword)->get();
        
        //BUSCAR EN LA TABLA SECTIONS EL OBJETO TIPO SECTIONWORD QUE TENGA EL MISMO SLUG QUE $sectionword
        $sectionwordCollection = Section::where('slug', $sectionword)->get();

        
        //COMO EN CATEGORYWORDCOLLECTION Y SECTIONWORDCOLLECTION VIENEN COLECCIONES DE ELEMENTOS, SOLO SE NECESITA EL PRIMER ELEMENTO YA QUE EN 
        //LA COLECCION SOLO VIENE UN ELEMENTO
        $categorywordObject = $categorywordCollection->first();
        $sectionwordObject = $sectionwordCollection->first();

        //EN LA VARIABLE SUGERENCIASNIVELDOS SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL, DEL MISMO TYPE Y QUE TENGAN EL MISMO CATEGORY_ID
        //$sugerenciasniveldos = Section::where('id', '!=', $sectionwordObject->id)->where('type', "Reglas ortográficas de palabras")
        //                                ->where('category_id', $sectionwordObject->category_id)->take(5)->get();

        $sugerenciasniveldos = Section::orderByRaw("RAND()")->where('id', '!=', $sectionwordObject->id)->where('type', "Reglas ortográficas de palabras")
                                            ->where('category_id', $sectionwordObject->category_id)->limit(5)->get();

        //return $sugerenciasniveldos;

        //EN LA VARIABLE SUGERENCIASNIVELUNO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DE NIVEL 1, DEL MISMO TUPE
        $sugerenciasniveluno = Category::orderByRaw("RAND()")->where('id', '!=', $categorywordObject->id)->where('type', "Reglas ortográficas de palabras")
                                                            ->limit(5)->get();

        

        return view('rules.sections.sectionword.rule', compact('sectionwordObject', 'sugerenciasniveldos', 'sugerenciasniveluno', 'categorywordObject'));
    }




    //METODO PARA MOSTRAR EL DETALLE DE UNA REGLA DE NIVEL 2 DE ACENTUACION (SECTIONACENTUATION)


    //EN EL METODO SE RECIBE EL SLUG DE CATEGORY WORD Y EL SLUG DE SECTION WORD
    //PARA BUSCAR SEGUN EL SLUG EL OBJETO TIPO CATEGORYWORD Y SECTIONWORD RESPECTIVOS
    public function showSectionAcentuation($categoryacentuation, $sectionacentuation){
        
        
        //BUSCAR EN LA TABLA CATEGORIES EL OBJETO TIPO CATEGORYWORD QUE TENGA EL MISMO SLUG QUE $categoryword
        $categoryacentuationCollection = Category::where('slug', $categoryacentuation)->get();
        
        //BUSCAR EN LA TABLA SECTIONS EL OBJETO TIPO SECTIONWORD QUE TENGA EL MISMO SLUG QUE $sectionword
        $sectionacentuationCollection = Section::where('slug', $sectionacentuation)->get();

        
        //COMO EN CATEGORYWORDCOLLECTION Y SECTIONWORDCOLLECTION VIENEN COLECCIONES DE ELEMENTOS, SOLO SE NECESITA EL PRIMER ELEMENTO YA QUE EN 
        //LA COLECCION SOLO VIENE UN ELEMENTO
        $categoryacentuationObject = $categoryacentuationCollection->first();
        $sectionacentuationObject = $sectionacentuationCollection->first();

        //EN LA VARIABLE SUGERENCIASNIVELDOS SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL, DEL MISMO TYPE Y QUE TENGAN EL MISMO CATEGORY_ID
        //$sugerenciasniveldos = Section::where('id', '!=', $sectionwordObject->id)->where('type', "Reglas ortográficas de palabras")
        //                                ->where('category_id', $sectionwordObject->category_id)->take(5)->get();

        $sugerenciasniveldos = Section::orderByRaw("RAND()")->where('id', '!=', $sectionacentuationObject->id)->where('type', "Reglas ortográficas de acentuación")
                                            ->where('category_id', $sectionacentuationObject->category_id)->limit(5)->get();

        //return $sugerenciasniveldos;

        //EN LA VARIABLE SUGERENCIASNIVELUNO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DE NIVEL 1, DEL MISMO TUPE
        $sugerenciasniveluno = Category::orderByRaw("RAND()")->where('id', '!=', $categoryacentuationObject->id)->where('type', "Reglas ortográficas de acentuación")
                                                            ->limit(5)->get();

        

        return view('rules.sections.sectionacentuation.rule', compact('sectionacentuationObject', 'sugerenciasniveldos', 'sugerenciasniveluno', 'categoryacentuationObject'));
    }



    //METODO PARA MOSTRAR EL DETALLE DE UNA REGLA DE NIVEL 2 DE PUNTUACION (SECTIONPUNCTUATION)


    //EN EL METODO SE RECIBE EL SLUG DE CATEGORY WORD Y EL SLUG DE SECTION WORD
    //PARA BUSCAR SEGUN EL SLUG EL OBJETO TIPO CATEGORYWORD Y SECTIONWORD RESPECTIVOS
    public function showSectionPunctuation($categorypunctuation, $sectionpunctuation){
        
        
        //BUSCAR EN LA TABLA CATEGORIES EL OBJETO TIPO CATEGORYWORD QUE TENGA EL MISMO SLUG QUE $categoryword
        $categorypunctuationCollection = Category::where('slug', $categorypunctuation)->get();
        
        //BUSCAR EN LA TABLA SECTIONS EL OBJETO TIPO SECTIONWORD QUE TENGA EL MISMO SLUG QUE $sectionword
        $sectionpunctuationCollection = Section::where('slug', $sectionpunctuation)->get();

        
        //COMO EN CATEGORYWORDCOLLECTION Y SECTIONWORDCOLLECTION VIENEN COLECCIONES DE ELEMENTOS, SOLO SE NECESITA EL PRIMER ELEMENTO YA QUE EN 
        //LA COLECCION SOLO VIENE UN ELEMENTO
        $categorypunctuationObject = $categorypunctuationCollection->first();
        $sectionpunctuationObject = $sectionpunctuationCollection->first();

        //EN LA VARIABLE SUGERENCIASNIVELDOS SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL, DEL MISMO TYPE Y QUE TENGAN EL MISMO CATEGORY_ID
        //$sugerenciasniveldos = Section::where('id', '!=', $sectionwordObject->id)->where('type', "Reglas ortográficas de palabras")
        //                                ->where('category_id', $sectionwordObject->category_id)->take(5)->get();

        $sugerenciasniveldos = Section::orderByRaw("RAND()")->where('id', '!=', $sectionpunctuationObject->id)->where('type', "Reglas ortográficas de puntuación")
                                            ->where('category_id', $sectionpunctuationObject->category_id)->limit(5)->get();

        //return $sugerenciasniveldos;

        //EN LA VARIABLE SUGERENCIASNIVELUNO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DE NIVEL 1, DEL MISMO TUPE
        $sugerenciasniveluno = Category::orderByRaw("RAND()")->where('id', '!=', $categorypunctuationObject->id)->where('type', "Reglas ortográficas de puntuación")
                                                            ->limit(5)->get();

        

        return view('rules.sections.sectionpunctuation.rule', compact('sectionpunctuationObject', 'sugerenciasniveldos', 'sugerenciasniveluno', 'categorypunctuationObject'));
    }

}
