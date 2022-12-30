<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class RulesLevelOneController extends Controller
{

    //////////////CATEGORIES 1 DE PALABRAS

    //METODO PARA ENVIAR A LA VISTA DEL ESTUDIANTE RULES.LETTERS EL LISTADO DE REGLAS DE PALABRAS NIVEL 1 (CATEGORIES)
    public function indexCategoryWord(){

        //CAPTURAR EL LISTADO DE REGLAS DE PALABRAS NIVEL 1 (CATEGORIES)
        $categories = Category::where('type', "Reglas ortográficas de palabras")->get();

        return view('rules.letters', compact('categories'));
    }


    //METODO PARA MOSTRAR EL DETALLE DE UNA REGLA DE NIVEL 1 DE PALABRAS (CATEGORYWORD)
    public function showCategoryWord(Category $categoryword){

        //EN LA VARIABLE SUGERENCIASNIVELUNO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL
        $sugerenciasniveluno = Category::where('id', '!=', $categoryword->id)->where('type', "Reglas ortográficas de palabras")
                                        ->take(5)->get();

        return view('rules.categories.categoryword.rule', compact('categoryword', 'sugerenciasniveluno'));
    }


    ///////////////////////CATEGORIES 1 DE ACENTUACION 


    //METODO PARA ENVIAR A LA VISTA DEL ESTUDIANTE RULES.ACENTUATION EL LISTADO DE REGLAS DE ACENTUACION NIVEL 1 (CATEGORIES)
    public function indexCategoryAcentuation(){

        
        //CAPTURAR EL LISTADO DE REGLAS DE PALABRAS NIVEL 1 (CATEGORIES)
        $categories = Category::where('type', "Reglas ortográficas de acentuación")->get();

        return view('rules.acentuation', compact('categories'));
    }

    //METODO PARA MOSTRAR EL DETALLE DE UNA REGLA DE NIVEL 1 DE ACENTUACION (CATEGORYACENTUATION)
    public function showCategoryAcentuation(Category $categoryacentuation){

        //EN LA VARIABLE SUGERENCIASNIVELUNO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL
        $sugerenciasniveluno = Category::where('id', '!=', $categoryacentuation->id)->where('type', "Reglas ortográficas de acentuación")
                                        ->take(5)->get();

        return view('rules.categories.categoryacentuation.rule', compact('categoryacentuation', 'sugerenciasniveluno'));
    }


    ///////////////////////////CATEGORIES 1 DE PUNTUACION

    //METODO PARA ENVIAR A LA VISTA DEL ESTUDIANTE RULES.ACENTUATION EL LISTADO DE REGLAS DE ACENTUACION NIVEL 1 (CATEGORIES)
    public function indexCategoryPunctuation(){

        
        //CAPTURAR EL LISTADO DE REGLAS DE PALABRAS NIVEL 1 (CATEGORIES)
        $categories = Category::where('type', "Reglas ortográficas de puntuación")->get();

        return view('rules.puntuation', compact('categories'));
    }

    //METODO PARA MOSTRAR EL DETALLE DE UNA REGLA DE NIVEL 1 DE ACENTUACION (CATEGORYACENTUATION)
    public function showCategoryPunctuation(Category $categorypunctuation){

        //EN LA VARIABLE SUGERENCIASNIVELUNO SE ENVIAN UN MAXIMO DE 5 SUGERENCIAS DE REGLAS DEL MISMO NIVEL
        $sugerenciasniveluno = Category::where('id', '!=', $categorypunctuation->id)->where('type', "Reglas ortográficas de puntuación")
                                        ->take(5)->get();

        return view('rules.categories.categorypunctuation.rule', compact('categorypunctuation', 'sugerenciasniveluno'));
    }

}
