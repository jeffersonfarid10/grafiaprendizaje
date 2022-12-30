<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //REGRESAR AL PANEL PRINCIPAL
    public function index(){
        return view('admin.evaluation.index');
    }

    //INGRESAR AL PANEL DE EJERCICIOS
    public function indexE(){
        return view('admin.exercise');
    }

    //INGRESAR AL PANEL DE REGLAS ORTOGRAFICA
    public function indexR(){
        return view('admin.rules');
    }


    //INGRESAR AL PANEL DE REGLAS ORTOGRAFICAS NIVEL 1 (CATEGORIES)
    public function indexCategories(){
        return view('admin.niveluno');
    }


    //INGRESAR AL PANEL DE REGLAS ORTOGRAFICAS NIVEL 2 (SECTIONS)
    public function indexSections(){
        return view('admin.niveldos');
    }


    //INGRESAR AL PANEL DE REGLAS ORTOGRAFICAS NIVEL 3 (POSTS)
    public function indexPosts(){
        return view('admin.niveltres');
    }

    //INGRESAR AL PANEL DE REGLAS ORTOGRAFICAS NIVEL 4 (RULES)
    public function indexRules(){
        return view('admin.nivelcuatro');
    }


    //INGRESAR AL PANEL DE REGLAS ORTOGRAFICAS NIVEL 5 (NOTES)
    public function indexNotes(){
        return view('admin.nivelcinco');
    }

    //INGRESAR AL PANEL DE RESULTADOS DE EVALUACIONES
    public function indexResults(){
        return view('admin.results.resultsall.index');
    }
}
