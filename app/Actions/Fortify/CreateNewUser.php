<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Models\Evaluation;
//IMPORTAR MODELO ROLE
use Spatie\Permission\Models\Role;
//IMPORTAR MODELO PERMISSIONS
use Spatie\Permission\Models\Permission;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/(.+)@utn\.edu\.ec/'], 
            //'email.regex' => 'Debe ingresar el correo estudiantil con dominio: @utn.edu.ec',
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        //return User::create([
        //    'name' => $input['name'],
        //    'email' => $input['email'],
        //    'password' => Hash::make($input['password']),
        //]);

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);


        //IMPORTANTE
        //BORRAR EL CODIGO DE ABAJO Y PEGAR EL CODIGO QUE ESTA EN EL BLOC DE NOTAS PARA QUE FUNCIONE LA ASIGNACION DE ROLES, PERMISOS Y EVALUACIONES

        /////////////////////CAPTURAR LOS EXAMENES
        
        $d1 = Evaluation::where('type', "D")->where('format', "1")->value('id');
        $pu1 = Evaluation::where('type', "PU")->where('format', "1")->value('id');
        $pd1 = Evaluation::where('type', "PD")->where('format', "1")->value('id');
        $pt1 = Evaluation::where('type', "PT")->where('format', "1")->value('id');
        $f1 = Evaluation::where('type', "F")->where('format', "1")->value('id');

        $d2 = Evaluation::where('type', "D")->where('format', "2")->value('id');
        $pu2 = Evaluation::where('type', "PU")->where('format', "2")->value('id');
        $pd2 = Evaluation::where('type', "PD")->where('format', "2")->value('id');
        $pt2 = Evaluation::where('type', "PT")->where('format', "2")->value('id');
        $f2 = Evaluation::where('type', "F")->where('format', "2")->value('id');

        $d3 = Evaluation::where('type', "D")->where('format', "3")->value('id');
        $pu3 = Evaluation::where('type', "PU")->where('format', "3")->value('id');
        $pd3 = Evaluation::where('type', "PD")->where('format', "3")->value('id');
        $pt3 = Evaluation::where('type', "PT")->where('format', "3")->value('id');
        $f3 = Evaluation::where('type', "F")->where('format', "3")->value('id');

        $d4 = Evaluation::where('type', "D")->where('format', "4")->value('id');
        $pu4 = Evaluation::where('type', "PU")->where('format', "4")->value('id');
        $pd4 = Evaluation::where('type', "PD")->where('format', "4")->value('id');
        $pt4 = Evaluation::where('type', "PT")->where('format', "4")->value('id');
        $f4 = Evaluation::where('type', "F")->where('format', "4")->value('id');

        $d5 = Evaluation::where('type', "D")->where('format', "5")->value('id');
        $pu5 = Evaluation::where('type', "PU")->where('format', "5")->value('id');
        $pd5 = Evaluation::where('type', "PD")->where('format', "5")->value('id');
        $pt5 = Evaluation::where('type', "PT")->where('format', "5")->value('id');
        $f5 = Evaluation::where('type', "F")->where('format', "5")->value('id');

        //CON EL IF SE PREGUNTA SI EL USUARIO ES ID 1 QUE NO SE LE ASIGNE NINGUN EXAMEN Y RETORNE EL USUARIO
        //PERO SI TIENE ID DIFERENTE SE ASIGNAN LOS EXAMENES SEGUN EL ID
        if(($user->id ===1)){

            //CREAR LOS ROLES
            $roladmin = Role::create(['name' => 'Admin']);
            $rolestudiante = Role::create(['name' => 'Estudiante']);

            //CREAR LOS PERMISOS Y ASIGNARLOS AL USUARIO ADMIN

            //LA DESCRIPCION DE CADA LINEA COINCIDE CON LA RUTA DEL ARCHIVO WEB.PHP PARA DARME CUENTA A QUE PERMISO
            //ESTA RELACIONADO CON CADA RUTA

            //////////////////////////////////////////////////RUTAS ADMIN

            //RUTA PARA MOSTRAR LA VISTA INDICE DE PREGUNTAS PANEL ADMIN
            Permission::create(['name' => 'admin.exercise'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTRAR VISTA INDICE DE REGLAS ORTOGRAFICAS PANEL ADMIN
            Permission::create(['name' => 'admin.rules'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA EL CRUD DE EVALUATION
            Permission::create(['name' => 'admin.evaluation.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.evaluation.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.evaluation.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.evaluation.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.evaluation.destroy'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTRAR EL LISTADO DE PREGUNTAS QUE LE PERTENECEN A UN EXAMEN DESDE EL INDEX DE EVALUATIONS
            Permission::create(['name' => 'admin.evaluation.questions'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTRAR VISTA INDICE DE RESULTADOS PANEL ADMIN
            Permission::create(['name' => 'admin.results'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTRAR EL LISTADO DE EXAMENES ASIGNADOS A UN ESTUDIANTE ESPECIFICO MEDIANTE LA VISTA RESULTS
            Permission::create(['name' => 'admin.results.assignedevaluations'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTRAR EL LISTADO DE RESPUESTAS DEL USUARIO A UNA EVALUACION ES ESPECIFICO MEDIANTE LA VISTA ASSIGNED EVALUATIONS
            Permission::create(['name' => 'admin.results.assignedquestions'])->syncRoles([$roladmin]);

            //RUTA PARA INGRESAR A LA SOLUCION DE UNA RESPUESTA DE UNA EVALUACION ESPECIFICA DE UN USUARIO ESPECIFICO DESDE EL PANEL ADMIN
            Permission::create(['name' => 'admin.results.viewresultquestions'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTRAR LAS NOTAS DE LOS USUARIOS EN LAS PRUEBAS DE DIAGNOSTICO
            Permission::create(['name' => 'admin.notes.diagnostic'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTRAR LAS NOTAS DE LOS USUARIOS EN LA PRUEBA DE PRACTICA UNO
            Permission::create(['name' => 'admin.notes.practiceone'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTRAR LAS NOTAS DE LOS USUARIOS EN LA PRUEBA DE PRACTICA DOS
            Permission::create(['name' => 'admin.notes.practicetwo'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTRAR LAS NOTAS DE LOS USUARIOS EN LA PRUEBA DE PRACTICA TRES
            Permission::create(['name' => 'admin.notes.practicethree'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTRAR LAS NOTAS DE LOS USUARIOS EN LA PRUEBA FINAL
            Permission::create(['name' => 'admin.notes.final'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTRAR TODAS LAS NOTAS DE LOS USUARIOS EN UNA SOLA TABLA
            Permission::create(['name' => 'admin.notes.allresults'])->syncRoles([$roladmin]);


            //RUTA TIPO RESOURCE PARA EL CRUD DE OPCION MULTIPLE
            Permission::create(['name' => 'admin.question.opcionmultiple.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.opcionmultiple.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.opcionmultiple.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.opcionmultiple.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.opcionmultiple.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA EL CRUD DE PALABRACORRECCION
            Permission::create(['name' => 'admin.question.palabracorreccion.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.palabracorreccion.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.palabracorreccion.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.palabracorreccion.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.palabracorreccion.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA EL CRUD DE OPCIONMULTIPLE IMAGEN
            Permission::create(['name' => 'admin.question.opcionmultiplei.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.opcionmultiplei.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.opcionmultiplei.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.opcionmultiplei.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.opcionmultiplei.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA EL CRUD DE OPCIONMULTIPLE AUDIO
            Permission::create(['name' => 'admin.question.opcionmultiplea.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.opcionmultiplea.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.opcionmultiplea.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.opcionmultiplea.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.opcionmultiplea.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA EL CRUD DE ORACIONAUDIO
            Permission::create(['name' => 'admin.question.oracionaudio.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.oracionaudio.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.oracionaudio.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.oracionaudio.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.oracionaudio.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA EL CRUD DE ORACIONIMAGEN
            Permission::create(['name' => 'admin.question.oracionimagen.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.oracionimagen.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.oracionimagen.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.oracionimagen.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.oracionimagen.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA EL CRUD DE TEXTOIMAGEN
            Permission::create(['name' => 'admin.question.textoimagen.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.textoimagen.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.textoimagen.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.textoimagen.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.textoimagen.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA EL CRUD DE TEXTO AUDIO
            Permission::create(['name' => 'admin.question.textoaudio.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.textoaudio.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.textoaudio.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.textoaudio.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.textoaudio.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA EL CRUD DE QUESTION JUEGO
            Permission::create(['name' => 'admin.question.juego.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.juego.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.juego.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.juego.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.juego.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA EL CRUD DE QUESTION SOPALETRAS
            Permission::create(['name' => 'admin.question.sopaletras.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.sopaletras.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.sopaletras.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.sopaletras.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.question.sopaletras.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA EL CRUD DE REGLAS NIVEL 1 (CATEGORIES)
            Permission::create(['name' => 'admin.information.category.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.information.category.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.information.category.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.information.category.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.information.category.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA EL CRUD DE GLOSARIO DE TERMINOS
            Permission::create(['name' => 'admin.glossary.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.glossary.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.glossary.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.glossary.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.glossary.destroy'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTRAR LA VISTA DEL INDICE DE REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 1 PANEL ADMIN
            Permission::create(['name' => 'admin.rules.categories'])->syncRoles([$roladmin]);

            //PARA LAS REGLAS NIVEL 1 (CATEGORIES) SE CREA 1 CONTROLADOR POR CADA TIPO DE REGLA: PALABRAS, ACENTUACION Y PUNTUACION

            //RUTA TIPO RESOURCE PARA CATEGORIES NIVEL 1 PALABRAS
            Permission::create(['name' => 'admin.categories.categoryword.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.categories.categoryword.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.categories.categoryword.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.categories.categoryword.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.categories.categoryword.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA CATEGORIES NIVEL 1 ACENTUACION
            Permission::create(['name' => 'admin.categories.categoryacentuation.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.categories.categoryacentuation.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.categories.categoryacentuation.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.categories.categoryacentuation.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.categories.categoryacentuation.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA CATEGORIES NIVEL 1 PUNTUACION
            Permission::create(['name' => 'admin.categories.categorypunctuation.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.categories.categorypunctuation.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.categories.categorypunctuation.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.categories.categorypunctuation.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.categories.categorypunctuation.destroy'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTRAR LA VISTA DEL INDICE DE REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 2 PANEL ADMIN
            Permission::create(['name' => 'admin.rules.sections'])->syncRoles([$roladmin]);

            //PARA LAS REGLAS NIVEL 2 (SECTIONS) SE CREA 1 CONTROLADOR POR CADA TIPO DE REGLA: PALABRAS, ACENTUACION, PUNTUACION
            
            //RUTA TIPO RESOURCE PARA SECTIONS NIVEL 2 PALABRAS
            Permission::create(['name' => 'admin.sections.sectionword.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.sections.sectionword.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.sections.sectionword.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.sections.sectionword.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.sections.sectionword.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA SECTIONS NIVEL 2 ACENTUACION
            Permission::create(['name' => 'admin.sections.sectionacentuation.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.sections.sectionacentuation.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.sections.sectionacentuation.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.sections.sectionacentuation.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.sections.sectionacentuation.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA SECTIONS NIVEL 2 PUNTUACION
            Permission::create(['name' => 'admin.sections.sectionpunctuation.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.sections.sectionpunctuation.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.sections.sectionpunctuation.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.sections.sectionpunctuation.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.sections.sectionpunctuation.destroy'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTRAR LA VISTA DEL INDICE DE REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 3 PANEL ADMIN
            Permission::create(['name' => 'admin.rules.posts'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA POSTS NIVEL 3 PALABRAS
            Permission::create(['name' => 'admin.posts.postword.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.posts.postword.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.posts.postword.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.posts.postword.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.posts.postword.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA POSTS NIVEL 3 ACENTUACION
            Permission::create(['name' => 'admin.posts.postacentuation.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.posts.postacentuation.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.posts.postacentuation.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.posts.postacentuation.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.posts.postacentuation.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA POSTS NIVEL 3 PUNTUACION
            Permission::create(['name' => 'admin.posts.postpunctuation.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.posts.postpunctuation.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.posts.postpunctuation.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.posts.postpunctuation.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.posts.postpunctuation.destroy'])->syncRoles([$roladmin]);

            //RUTA MOSTRAR LA VISTA DEL INDICE DE REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 4 PANEL ADMIN
            Permission::create(['name' => 'admin.rules.rules'])->syncRoles([$roladmin]);

            //PARA LAS REGLAS DE NIVEL 4 (RULES) SE CREA 1 CONTROLADOR POR CADA TIPO DE REGLA: PALABRAS, ACENTUACION, PUNTUACION

            //RUTA TIPO RESOURCE PARA RULES NIVEL 4 PALABRAS
            Permission::create(['name' => 'admin.rules.ruleword.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.rules.ruleword.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.rules.ruleword.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.rules.ruleword.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.rules.ruleword.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA RULES NIVEL 4 ACENTUACION
            Permission::create(['name' => 'admin.rules.ruleacentuation.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.rules.ruleacentuation.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.rules.ruleacentuation.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.rules.ruleacentuation.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.rules.ruleacentuation.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA RULES NIVEL 4 PUNTUACION
            Permission::create(['name' => 'admin.rules.rulepunctuation.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.rules.rulepunctuation.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.rules.rulepunctuation.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.rules.rulepunctuation.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.rules.rulepunctuation.destroy'])->syncRoles([$roladmin]);

            //RUTA PARA MOSTAR LA VISTA DEL INDICE DE REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 5 PANEL ADMIN
            Permission::create(['name' => 'admin.rules.notes'])->syncRoles([$roladmin]);

            //PARA LAS REGLAS DE NIVEL 5 (NOTES) SE CREA 1 CONTROLADOR POR CADA TIPO DE REGLA: PALABRAS, ACENTUACION, PUNTUACION

            //RUTA TIPO RESOURCE PARA RULES NIVEL 5 PALABRAS
            Permission::create(['name' => 'admin.notes.noteword.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.notes.noteword.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.notes.noteword.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.notes.noteword.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.notes.noteword.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA RULES NIVEL 5 ACENTUACION
            Permission::create(['name' => 'admin.notes.noteacentuation.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.notes.noteacentuation.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.notes.noteacentuation.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.notes.noteacentuation.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.notes.noteacentuation.destroy'])->syncRoles([$roladmin]);

            //RUTA TIPO RESOURCE PARA RULES NIVEL 5 PUNTUACION
            Permission::create(['name' => 'admin.notes.notepunctuation.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.notes.notepunctuation.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.notes.notepunctuation.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.notes.notepunctuation.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.notes.notepunctuation.destroy'])->syncRoles([$roladmin]);


            //RUTA TIPO RESOURCE PARA CURD DE ASIGNAR ROLES A LOS USUARIOS Y PODER ELIMINAR USUARIOS
            Permission::create(['name' => 'admin.user.index'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.user.create'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.user.show'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.user.edit'])->syncRoles([$roladmin]);
            Permission::create(['name' => 'admin.user.destroy'])->syncRoles([$roladmin]);



            //ASIGNAR ROL ADMIN AL USUARIO CON ID 1
            $user->assignRole('Admin');

            return $user;

            //return $user;
        }
        elseif(($user->id ===6) || ($user->id ===11) || ($user->id ===16) || ($user->id ===21) || ($user->id ===26) || ($user->id ===31) || ($user->id ===36) || ($user->id ===41) || ($user->id ===46)){
            $user->evaluations()->attach($d1);
            $user->evaluations()->attach($pu1);
            $user->evaluations()->attach($pd1);
            $user->evaluations()->attach($pt1);
            $user->evaluations()->attach($f1);
        
            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===2) || ($user->id ===7) || ($user->id ===12) || ($user->id ===17) || ($user->id ===22) || ($user->id ===27) || ($user->id ===32) || ($user->id ===37) || ($user->id ===42) || ($user->id ===47)){
            $user->evaluations()->attach($d2);
            $user->evaluations()->attach($pu2);
            $user->evaluations()->attach($pd2);
            $user->evaluations()->attach($pt2);
            $user->evaluations()->attach($f2);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===3) || ($user->id ===8) || ($user->id ===13) || ($user->id ===18) || ($user->id ===23) || ($user->id ===28) || ($user->id ===33) || ($user->id ===38) || ($user->id ===43) || ($user->id ===48)){
            $user->evaluations()->attach($d3);
            $user->evaluations()->attach($pu3);
            $user->evaluations()->attach($pd3);
            $user->evaluations()->attach($pt3);
            $user->evaluations()->attach($f3);


            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===4) || ($user->id ===9) || ($user->id ===14) || ($user->id ===19) || ($user->id ===24) || ($user->id ===29) || ($user->id ===34) || ($user->id ===39) || ($user->id ===44) || ($user->id ===49)){
            $user->evaluations()->attach($d4);
            $user->evaluations()->attach($pu4);
            $user->evaluations()->attach($pd4);
            $user->evaluations()->attach($pt4);
            $user->evaluations()->attach($f4);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===5) || ($user->id ===10) || ($user->id ===15) || ($user->id ===20) || ($user->id ===25) || ($user->id ===30) || ($user->id ===35) || ($user->id ===40) || ($user->id ===45) || ($user->id ===50)){
            $user->evaluations()->attach($d5);
            $user->evaluations()->attach($pu5);
            $user->evaluations()->attach($pd5);
            $user->evaluations()->attach($pt5);
            $user->evaluations()->attach($f5);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===51) || ($user->id ===56) || ($user->id ===61) || ($user->id ===66) || ($user->id ===71) || ($user->id ===76) || ($user->id ===81) || ($user->id ===86) || ($user->id ===91) || ($user->id ===96)){
            $user->evaluations()->attach($d1);
            $user->evaluations()->attach($pu1);
            $user->evaluations()->attach($pd1);
            $user->evaluations()->attach($pt1);
            $user->evaluations()->attach($f1);
        
            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===52) || ($user->id ===57) || ($user->id ===62) || ($user->id ===67) || ($user->id ===72) || ($user->id ===77) || ($user->id ===82) || ($user->id ===87) || ($user->id ===92) || ($user->id ===97)){
            $user->evaluations()->attach($d2);
            $user->evaluations()->attach($pu2);
            $user->evaluations()->attach($pd2);
            $user->evaluations()->attach($pt2);
            $user->evaluations()->attach($f2);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===53) || ($user->id ===58) || ($user->id ===63) || ($user->id ===68) || ($user->id ===73) || ($user->id ===78) || ($user->id ===83) || ($user->id ===88) || ($user->id ===93) || ($user->id ===98)){
            $user->evaluations()->attach($d3);
            $user->evaluations()->attach($pu3);
            $user->evaluations()->attach($pd3);
            $user->evaluations()->attach($pt3);
            $user->evaluations()->attach($f3);


            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===54) || ($user->id ===59) || ($user->id ===64) || ($user->id ===69) || ($user->id ===74) || ($user->id ===79) || ($user->id ===84) || ($user->id ===89) || ($user->id ===94) || ($user->id ===99)){
            $user->evaluations()->attach($d4);
            $user->evaluations()->attach($pu4);
            $user->evaluations()->attach($pd4);
            $user->evaluations()->attach($pt4);
            $user->evaluations()->attach($f4);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===55) || ($user->id ===60) || ($user->id ===65) || ($user->id ===70) || ($user->id ===75) || ($user->id ===80) || ($user->id ===85) || ($user->id ===90) || ($user->id ===95) || ($user->id ===100)){
            $user->evaluations()->attach($d5);
            $user->evaluations()->attach($pu5);
            $user->evaluations()->attach($pd5);
            $user->evaluations()->attach($pt5);
            $user->evaluations()->attach($f5);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===101) || ($user->id ===106) || ($user->id ===111) || ($user->id ===116) || ($user->id ===121) || ($user->id ===126) || ($user->id ===131) || ($user->id ===136) || ($user->id ===141) || ($user->id ===146)){
            $user->evaluations()->attach($d1);
            $user->evaluations()->attach($pu1);
            $user->evaluations()->attach($pd1);
            $user->evaluations()->attach($pt1);
            $user->evaluations()->attach($f1);
        
            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===102) || ($user->id ===107) || ($user->id ===112) || ($user->id ===117) || ($user->id ===122) || ($user->id ===127) || ($user->id ===132) || ($user->id ===137) || ($user->id ===142) || ($user->id ===147)){
            $user->evaluations()->attach($d2);
            $user->evaluations()->attach($pu2);
            $user->evaluations()->attach($pd2);
            $user->evaluations()->attach($pt2);
            $user->evaluations()->attach($f2);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===103) || ($user->id ===108) || ($user->id ===113) || ($user->id ===118) || ($user->id ===123) || ($user->id ===128) || ($user->id ===133) || ($user->id ===138) || ($user->id ===143) || ($user->id ===148)){
            $user->evaluations()->attach($d3);
            $user->evaluations()->attach($pu3);
            $user->evaluations()->attach($pd3);
            $user->evaluations()->attach($pt3);
            $user->evaluations()->attach($f3);


            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===104) || ($user->id ===109) || ($user->id ===114) || ($user->id ===119) || ($user->id ===124) || ($user->id ===129) || ($user->id ===134) || ($user->id ===139) || ($user->id ===144) || ($user->id ===149)){
            $user->evaluations()->attach($d4);
            $user->evaluations()->attach($pu4);
            $user->evaluations()->attach($pd4);
            $user->evaluations()->attach($pt4);
            $user->evaluations()->attach($f4);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===105) || ($user->id ===110) || ($user->id ===115) || ($user->id ===120) || ($user->id ===125) || ($user->id ===130) || ($user->id ===135) || ($user->id ===140) || ($user->id ===145) || ($user->id ===150)){
            $user->evaluations()->attach($d5);
            $user->evaluations()->attach($pu5);
            $user->evaluations()->attach($pd5);
            $user->evaluations()->attach($pt5);
            $user->evaluations()->attach($f5);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===151) || ($user->id ===156) || ($user->id ===161) || ($user->id ===166) || ($user->id ===171) || ($user->id ===176) || ($user->id ===181) || ($user->id ===186) || ($user->id ===191) || ($user->id ===196)){
            $user->evaluations()->attach($d1);
            $user->evaluations()->attach($pu1);
            $user->evaluations()->attach($pd1);
            $user->evaluations()->attach($pt1);
            $user->evaluations()->attach($f1);
        
            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===152) || ($user->id ===157) || ($user->id ===162) || ($user->id ===167) || ($user->id ===172) || ($user->id ===177) || ($user->id ===182) || ($user->id ===187) || ($user->id ===192) || ($user->id ===197)){
            $user->evaluations()->attach($d2);
            $user->evaluations()->attach($pu2);
            $user->evaluations()->attach($pd2);
            $user->evaluations()->attach($pt2);
            $user->evaluations()->attach($f2);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===153) || ($user->id ===158) || ($user->id ===163) || ($user->id ===168) || ($user->id ===173) || ($user->id ===178) || ($user->id ===183) || ($user->id ===188) || ($user->id ===193) || ($user->id ===198)){
            $user->evaluations()->attach($d3);
            $user->evaluations()->attach($pu3);
            $user->evaluations()->attach($pd3);
            $user->evaluations()->attach($pt3);
            $user->evaluations()->attach($f3);


            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===154) || ($user->id ===159) || ($user->id ===164) || ($user->id ===169) || ($user->id ===174) || ($user->id ===179) || ($user->id ===184) || ($user->id ===189) || ($user->id ===194) || ($user->id ===199)){
            $user->evaluations()->attach($d4);
            $user->evaluations()->attach($pu4);
            $user->evaluations()->attach($pd4);
            $user->evaluations()->attach($pt4);
            $user->evaluations()->attach($f4);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===155) || ($user->id ===160) || ($user->id ===165) || ($user->id ===170) || ($user->id ===175) || ($user->id ===180) || ($user->id ===185) || ($user->id ===190) || ($user->id ===195) || ($user->id ===200)){
            $user->evaluations()->attach($d5);
            $user->evaluations()->attach($pu5);
            $user->evaluations()->attach($pd5);
            $user->evaluations()->attach($pt5);
            $user->evaluations()->attach($f5);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===201) || ($user->id ===206) || ($user->id ===211) || ($user->id ===216) || ($user->id ===221) || ($user->id ===226) || ($user->id ===231) || ($user->id ===236) || ($user->id ===241) || ($user->id ===246)){
            $user->evaluations()->attach($d1);
            $user->evaluations()->attach($pu1);
            $user->evaluations()->attach($pd1);
            $user->evaluations()->attach($pt1);
            $user->evaluations()->attach($f1);
        
            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===202) || ($user->id ===207) || ($user->id ===212) || ($user->id ===217) || ($user->id ===222) || ($user->id ===227) || ($user->id ===232) || ($user->id ===237) || ($user->id ===242) || ($user->id ===247)){
            $user->evaluations()->attach($d2);
            $user->evaluations()->attach($pu2);
            $user->evaluations()->attach($pd2);
            $user->evaluations()->attach($pt2);
            $user->evaluations()->attach($f2);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===203) || ($user->id ===208) || ($user->id ===213) || ($user->id ===218) || ($user->id ===223) || ($user->id ===228) || ($user->id ===233) || ($user->id ===238) || ($user->id ===243) || ($user->id ===248)){
            $user->evaluations()->attach($d3);
            $user->evaluations()->attach($pu3);
            $user->evaluations()->attach($pd3);
            $user->evaluations()->attach($pt3);
            $user->evaluations()->attach($f3);


            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===204) || ($user->id ===209) || ($user->id ===214) || ($user->id ===219) || ($user->id ===224) || ($user->id ===229) || ($user->id ===234) || ($user->id ===239) || ($user->id ===244) || ($user->id ===249)){
            $user->evaluations()->attach($d4);
            $user->evaluations()->attach($pu4);
            $user->evaluations()->attach($pd4);
            $user->evaluations()->attach($pt4);
            $user->evaluations()->attach($f4);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===205) || ($user->id ===210) || ($user->id ===215) || ($user->id ===220) || ($user->id ===225) || ($user->id ===230) || ($user->id ===235) || ($user->id ===240) || ($user->id ===245) || ($user->id ===250)){
            $user->evaluations()->attach($d5);
            $user->evaluations()->attach($pu5);
            $user->evaluations()->attach($pd5);
            $user->evaluations()->attach($pt5);
            $user->evaluations()->attach($f5);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===251) || ($user->id ===256) || ($user->id ===261) || ($user->id ===266) || ($user->id ===271) || ($user->id ===276) || ($user->id ===281) || ($user->id ===286) || ($user->id ===291) || ($user->id ===296)){
            $user->evaluations()->attach($d1);
            $user->evaluations()->attach($pu1);
            $user->evaluations()->attach($pd1);
            $user->evaluations()->attach($pt1);
            $user->evaluations()->attach($f1);
        
            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===252) || ($user->id ===257) || ($user->id ===262) || ($user->id ===267) || ($user->id ===272) || ($user->id ===277) || ($user->id ===282) || ($user->id ===287) || ($user->id ===292) || ($user->id ===297)){
            $user->evaluations()->attach($d2);
            $user->evaluations()->attach($pu2);
            $user->evaluations()->attach($pd2);
            $user->evaluations()->attach($pt2);
            $user->evaluations()->attach($f2);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===253) || ($user->id ===258) || ($user->id ===263) || ($user->id ===268) || ($user->id ===273) || ($user->id ===278) || ($user->id ===283) || ($user->id ===288) || ($user->id ===293) || ($user->id ===298)){
            $user->evaluations()->attach($d3);
            $user->evaluations()->attach($pu3);
            $user->evaluations()->attach($pd3);
            $user->evaluations()->attach($pt3);
            $user->evaluations()->attach($f3);


            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===254) || ($user->id ===259) || ($user->id ===264) || ($user->id ===269) || ($user->id ===274) || ($user->id ===279) || ($user->id ===284) || ($user->id ===289) || ($user->id ===294) || ($user->id ===299)){
            $user->evaluations()->attach($d4);
            $user->evaluations()->attach($pu4);
            $user->evaluations()->attach($pd4);
            $user->evaluations()->attach($pt4);
            $user->evaluations()->attach($f4);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===255) || ($user->id ===260) || ($user->id ===265) || ($user->id ===270) || ($user->id ===275) || ($user->id ===280) || ($user->id ===285) || ($user->id ===290) || ($user->id ===295) || ($user->id ===300)){
            $user->evaluations()->attach($d5);
            $user->evaluations()->attach($pu5);
            $user->evaluations()->attach($pd5);
            $user->evaluations()->attach($pt5);
            $user->evaluations()->attach($f5);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===301) || ($user->id ===306) || ($user->id ===311) || ($user->id ===316) || ($user->id ===321) || ($user->id ===326) || ($user->id ===331) || ($user->id ===336) || ($user->id ===341) || ($user->id ===346)){
            $user->evaluations()->attach($d1);
            $user->evaluations()->attach($pu1);
            $user->evaluations()->attach($pd1);
            $user->evaluations()->attach($pt1);
            $user->evaluations()->attach($f1);
        
            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===302) || ($user->id ===307) || ($user->id ===312) || ($user->id ===317) || ($user->id ===322) || ($user->id ===327) || ($user->id ===332) || ($user->id ===337) || ($user->id ===342) || ($user->id ===347)){
            $user->evaluations()->attach($d2);
            $user->evaluations()->attach($pu2);
            $user->evaluations()->attach($pd2);
            $user->evaluations()->attach($pt2);
            $user->evaluations()->attach($f2);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===303) || ($user->id ===308) || ($user->id ===313) || ($user->id ===318) || ($user->id ===323) || ($user->id ===328) || ($user->id ===333) || ($user->id ===338) || ($user->id ===343) || ($user->id ===348)){
            $user->evaluations()->attach($d3);
            $user->evaluations()->attach($pu3);
            $user->evaluations()->attach($pd3);
            $user->evaluations()->attach($pt3);
            $user->evaluations()->attach($f3);


            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===304) || ($user->id ===309) || ($user->id ===314) || ($user->id ===319) || ($user->id ===324) || ($user->id ===329) || ($user->id ===334) || ($user->id ===339) || ($user->id ===344) || ($user->id ===349)){
            $user->evaluations()->attach($d4);
            $user->evaluations()->attach($pu4);
            $user->evaluations()->attach($pd4);
            $user->evaluations()->attach($pt4);
            $user->evaluations()->attach($f4);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===305) || ($user->id ===310) || ($user->id ===315) || ($user->id ===320) || ($user->id ===325) || ($user->id ===330) || ($user->id ===335) || ($user->id ===340) || ($user->id ===345) || ($user->id ===350)){
            $user->evaluations()->attach($d5);
            $user->evaluations()->attach($pu5);
            $user->evaluations()->attach($pd5);
            $user->evaluations()->attach($pt5);
            $user->evaluations()->attach($f5);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===351) || ($user->id ===356) || ($user->id ===361) || ($user->id ===366) || ($user->id ===371) || ($user->id ===376) || ($user->id ===381) || ($user->id ===386) || ($user->id ===391) || ($user->id ===396)){
            $user->evaluations()->attach($d1);
            $user->evaluations()->attach($pu1);
            $user->evaluations()->attach($pd1);
            $user->evaluations()->attach($pt1);
            $user->evaluations()->attach($f1);
        
            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===352) || ($user->id ===357) || ($user->id ===362) || ($user->id ===367) || ($user->id ===372) || ($user->id ===377) || ($user->id ===382) || ($user->id ===387) || ($user->id ===392) || ($user->id ===397)){
            $user->evaluations()->attach($d2);
            $user->evaluations()->attach($pu2);
            $user->evaluations()->attach($pd2);
            $user->evaluations()->attach($pt2);
            $user->evaluations()->attach($f2);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===353) || ($user->id ===358) || ($user->id ===363) || ($user->id ===368) || ($user->id ===373) || ($user->id ===378) || ($user->id ===383) || ($user->id ===388) || ($user->id ===393) || ($user->id ===398)){
            $user->evaluations()->attach($d3);
            $user->evaluations()->attach($pu3);
            $user->evaluations()->attach($pd3);
            $user->evaluations()->attach($pt3);
            $user->evaluations()->attach($f3);


            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===354) || ($user->id ===359) || ($user->id ===364) || ($user->id ===369) || ($user->id ===374) || ($user->id ===379) || ($user->id ===384) || ($user->id ===389) || ($user->id ===394) || ($user->id ===399)){
            $user->evaluations()->attach($d4);
            $user->evaluations()->attach($pu4);
            $user->evaluations()->attach($pd4);
            $user->evaluations()->attach($pt4);
            $user->evaluations()->attach($f4);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===355) || ($user->id ===360) || ($user->id ===365) || ($user->id ===370) || ($user->id ===375) || ($user->id ===380) || ($user->id ===385) || ($user->id ===390) || ($user->id ===395) || ($user->id ===400)){
            $user->evaluations()->attach($d5);
            $user->evaluations()->attach($pu5);
            $user->evaluations()->attach($pd5);
            $user->evaluations()->attach($pt5);
            $user->evaluations()->attach($f5);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===401) || ($user->id ===406) || ($user->id ===411) || ($user->id ===416) || ($user->id ===421) || ($user->id ===426) || ($user->id ===431) || ($user->id ===436) || ($user->id ===441) || ($user->id ===446)){
            $user->evaluations()->attach($d1);
            $user->evaluations()->attach($pu1);
            $user->evaluations()->attach($pd1);
            $user->evaluations()->attach($pt1);
            $user->evaluations()->attach($f1);
        
            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===402) || ($user->id ===407) || ($user->id ===412) || ($user->id ===417) || ($user->id ===422) || ($user->id ===427) || ($user->id ===432) || ($user->id ===437) || ($user->id ===442) || ($user->id ===447)){
            $user->evaluations()->attach($d2);
            $user->evaluations()->attach($pu2);
            $user->evaluations()->attach($pd2);
            $user->evaluations()->attach($pt2);
            $user->evaluations()->attach($f2);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===403) || ($user->id ===408) || ($user->id ===413) || ($user->id ===418) || ($user->id ===423) || ($user->id ===428) || ($user->id ===433) || ($user->id ===438) || ($user->id ===443) || ($user->id ===448)){
            $user->evaluations()->attach($d3);
            $user->evaluations()->attach($pu3);
            $user->evaluations()->attach($pd3);
            $user->evaluations()->attach($pt3);
            $user->evaluations()->attach($f3);


            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===404) || ($user->id ===409) || ($user->id ===414) || ($user->id ===419) || ($user->id ===424) || ($user->id ===429) || ($user->id ===434) || ($user->id ===439) || ($user->id ===444) || ($user->id ===449)){
            $user->evaluations()->attach($d4);
            $user->evaluations()->attach($pu4);
            $user->evaluations()->attach($pd4);
            $user->evaluations()->attach($pt4);
            $user->evaluations()->attach($f4);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===405) || ($user->id ===410) || ($user->id ===415) || ($user->id ===420) || ($user->id ===425) || ($user->id ===430) || ($user->id ===435) || ($user->id ===440) || ($user->id ===445) || ($user->id ===450)){
            $user->evaluations()->attach($d5);
            $user->evaluations()->attach($pu5);
            $user->evaluations()->attach($pd5);
            $user->evaluations()->attach($pt5);
            $user->evaluations()->attach($f5);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===451) || ($user->id ===456) || ($user->id ===461) || ($user->id ===466) || ($user->id ===471) || ($user->id ===476) || ($user->id ===481) || ($user->id ===486) || ($user->id ===491) || ($user->id ===496)){
            $user->evaluations()->attach($d1);
            $user->evaluations()->attach($pu1);
            $user->evaluations()->attach($pd1);
            $user->evaluations()->attach($pt1);
            $user->evaluations()->attach($f1);
        
            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===452) || ($user->id ===457) || ($user->id ===462) || ($user->id ===467) || ($user->id ===472) || ($user->id ===477) || ($user->id ===482) || ($user->id ===487) || ($user->id ===492) || ($user->id ===497)){
            $user->evaluations()->attach($d2);
            $user->evaluations()->attach($pu2);
            $user->evaluations()->attach($pd2);
            $user->evaluations()->attach($pt2);
            $user->evaluations()->attach($f2);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        elseif(($user->id ===453) || ($user->id ===458) || ($user->id ===463) || ($user->id ===468) || ($user->id ===473) || ($user->id ===478) || ($user->id ===483) || ($user->id ===488) || ($user->id ===493) || ($user->id ===498)){
            $user->evaluations()->attach($d3);
            $user->evaluations()->attach($pu3);
            $user->evaluations()->attach($pd3);
            $user->evaluations()->attach($pt3);
            $user->evaluations()->attach($f3);


            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===454) || ($user->id ===459) || ($user->id ===464) || ($user->id ===469) || ($user->id ===474) || ($user->id ===479) || ($user->id ===484) || ($user->id ===489) || ($user->id ===494) || ($user->id ===499)){
            $user->evaluations()->attach($d4);
            $user->evaluations()->attach($pu4);
            $user->evaluations()->attach($pd4);
            $user->evaluations()->attach($pt4);
            $user->evaluations()->attach($f4);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        } 
        elseif(($user->id ===455) || ($user->id ===460) || ($user->id ===465) || ($user->id ===470) || ($user->id ===475) || ($user->id ===480) || ($user->id ===485) || ($user->id ===490) || ($user->id ===495) || ($user->id ===500)){
            $user->evaluations()->attach($d5);
            $user->evaluations()->attach($pu5);
            $user->evaluations()->attach($pd5);
            $user->evaluations()->attach($pt5);
            $user->evaluations()->attach($f5);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }
        else{
            $user->evaluations()->attach($d5);
            $user->evaluations()->attach($pu5);
            $user->evaluations()->attach($pd5);
            $user->evaluations()->attach($pt5);
            $user->evaluations()->attach($f5);

            //ASIGNAR ROL
            $user->assignRole('Estudiante');
            return $user;
        }

    



       

    }
}
