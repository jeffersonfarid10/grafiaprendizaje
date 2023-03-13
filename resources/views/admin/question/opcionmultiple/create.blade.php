@extends('adminlte::page')

@section('title', 'Crear pregunta')

@section('content_header')
    <h1 class="text-danger"><strong> Crear pregunta opción multiple</strong></h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="text-danger"><strong> Rellene los siguientes campos:</strong></h5>
        <div class="bg-dark text-white font-bold rounded">
            <a href="{{route('admin.question.opcionmultiple.index')}}"><button class="btn btn-info m-3">Volver al menú principal</button></a>
        </div>
    </div>
    	<!-- MENSAJE DE SESION -->
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{Session::get('message')}}
        </div>
    @endif

    <div class="card-body">
        <form action="{{route('admin.question.opcionmultiple.store')}}" method="POST">
            @csrf 

            <div class="form-group">
                <label>Enunciado de pregunta:</label>
                <input type="text" name="title" id="title" placeholder="Ingrese el enunciado de pregunta" value="{{old('title')}}" class="form-control" required>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('title')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Slug pregunta:</label>
                <input type="text" name="slug" id="slug" placeholder="Slug de la pregunta" value="{{old('slug')}}" class="form-control" required readonly>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('slug')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Seleccione un examen:</label>
                <select name="evaluation_id" id="evaluation_id" class="form-control" required>
                    @foreach ($evaluations as $evaluation)
                        <option value="{{$evaluation->id}}">{{$evaluation->name}}</option>
                    @endforeach
                </select>

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('evaluation_id')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <!-- ACTUALIZACION 
            SE AGREGO EL CAMPO RULE EN LA TABLA QUESTIONS QUE SIRVE PARA AGREGAR LAS REGLAS ORTOGRAFICAS
            QUE SE ESTAN ANALIZANDO EN LAS ACTIVIDADES DE PRACTICA -->
            <div class="form-group">
                <label>Información:</label>
                <textarea name="rule" id="rule" class="form-control" value="{{old('rule')}}"></textarea>
                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('rule')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Ingrese las opciones de respuesta:</label>
                @for($i=0; $i<4; $i++)
                    <br>
                    <input type="text" name="opciones[]" class="form-control" placeholder="Ingrese la opción de respuesta {{$i+1}}" value="{{old('answer')}}" required>
                    <input type="radio" name="correct_answer" value="{{$i}}">
                    <span>Respuesta correcta</span> 
                    <br>  
                @endfor

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('opciones')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            

            <div class="form-group">
                <label>Ingrese las indicaciones:</label>
                @for($j=0; $j<10; $j++)
                    <input type="text" name="indicaciones[]" class="form-control" placeholder="Indicación {{$j+1}}" value="{{old('indication')}}">
                    <br>
                @endfor

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('indicaciones')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Ingrese las justificaciones de pregunta:</label>
                @for($k=0; $k<10; $k++)
                    <input type="text" name="justificaciones[]" class="form-control" placeholder="Justificación {{$k+1}}" value="{{old('reason')}}">
                    <input type="text" name="reglas[]" class="form-control" placeholder="Clasificación {{$k+1}}" value="{{old('rule')}}">
                    <br>
                @endfor

                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('justificaciones')
                    <small class="text-danger">{{$message}}</small>
                @enderror
                <!-- MENSAJE DE ERROR DE VALIDACION -->
                @error('reglas')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <!-- CAPTURAR REGLAS ORTOGRAFICAS DE PALABRAS-->
            <div class="form-group">
                <label>Seleccione las reglas ortográficas de palabras</label>
                <br>
                <div class="row">
                    <!-- CON LOS IF SE VA COMPROBANDO SI LOS ARRAYS TIENEN MAS DE UN OBJETO, SI ES ASI SE CARGA LA COLUMNA, CASO CONTRARIO NO -->
                    @if (count($palabrasniveluno) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de palabras nivel uno</strong>
                            <br>
                            @foreach ($palabrasniveluno as $categoryword)
                                <ul>
                                    <input type="checkbox" name="categorywords[]" value="{{$categoryword->id}}">
                                    {{$categoryword->name}}
                                </ul>
                            @endforeach
                        </div>
                    @endif

                    @if (count($palabrasniveldos) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de palabras nivel dos</strong>
                            <br>
                            @foreach ($palabrasniveldos as $sectionword)
                                <ul>
                                    <input type="checkbox" name="sectionwords[]" value="{{$sectionword->id}}">
                                    {{$sectionword->name}}
                                </ul>
                            @endforeach
                        </div>
                    @endif

                    @if (count($palabrasniveltres) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de palabras nivel tres</strong>
                            <br>
                            @foreach ($palabrasniveltres as $postword)
                                <ul>
                                    <input type="checkbox" name="postwords[]" value="{{$postword->id}}">
                                    {{$postword->name}}
                                </ul>
                            @endforeach
                        </div>
                    @endif

                    @if (count($palabrasnivelcuatro) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de palabras nivel cuatro</strong>
                            <br>
                            @foreach ($palabrasnivelcuatro as $ruleword)
                                <ul>
                                    <input type="checkbox" name="rulewords[]" value="{{$ruleword->id}}">
                                    {{$ruleword->name}}
                                </ul>
                            @endforeach
                        </div>
                    @endif

                    @if (count($palabrasnivelcinco) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de palabras nivel cinco</strong>
                            <br>
                            @foreach ($palabrasnivelcinco as $noteword)
                                <ul>
                                    <input type="checkbox" name="notewords[]" value="{{$noteword->id}}">
                                    {{$noteword->name}}
                                </ul>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>


            <!-- CAPTURAR REGLAS ORTOGRAFICAS DE ACENTUACION-->
            <div class="form-group">
                <label>Seleccione las reglas ortográficas de acentuación</label>
                <br>
                <div class="row">
                    <!-- CON LOS IF SE VA COMPROBANDO SI LOS ARRAYS TIENEN MAS DE UN OBJETO, SI ES ASI SE CARGA LA COLUMNA, CASO CONTRARIO NO -->
                    @if (count($acentuacionniveluno) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de acentuación nivel uno</strong>
                            <br>
                            @foreach ($acentuacionniveluno as $categoryacentuation)
                                <ul>
                                    <input type="checkbox" name="categoryacentuations[]" value="{{$categoryacentuation->id}}">
                                    {{$categoryacentuation->name}}
                                </ul>
                            @endforeach
                        </div>
                    @endif

                    @if (count($acentuacionniveldos) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de acentuación nivel dos</strong>
                            <br>
                            @foreach ($acentuacionniveldos as $sectionacentuation)
                                <ul>
                                    <input type="checkbox" name="sectionacentuations[]" value="{{$sectionacentuation->id}}">
                                    {{$sectionacentuation->name}}
                                </ul>
                            @endforeach
                        </div>
                    @endif

                    @if (count($acentuacionniveltres) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de acentuación nivel tres</strong>
                            <br>
                            @foreach ($acentuacionniveltres as $postacentuation)
                                <ul>
                                    <input type="checkbox" name="postacentuations[]" value="{{$postacentuation->id}}">
                                    {{$postacentuation->name}}
                                </ul>
                            @endforeach
                        </div>
                    @endif

                    @if (count($acentuacionnivelcuatro) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de acentuación nivel cuatro</strong>
                            <br>
                            @foreach ($acentuacionnivelcuatro as $ruleacentuation)
                                <ul>
                                    <input type="checkbox" name="ruleacentuations[]" value="{{$ruleacentuation->id}}">
                                    {{$ruleacentuation->name}}
                                </ul>
                            @endforeach
                        </div>
                    @endif

                    @if (count($acentuacionnivelcinco) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de acentuación nivel cinco</strong>
                            <br>
                            @foreach ($acentuacionnivelcinco as $noteacentuation)
                                <ul>
                                    <input type="checkbox" name="noteacentuations[]" value="{{$noteacentuation->id}}">
                                    {{$noteacentuation->name}}
                                </ul>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>


            <!-- CAPTURAR REGLAS ORTOGRAFICAS DE PUNTUACION-->
            <div class="form-group">
                <label>Seleccione las reglas ortográficas de puntuación</label>
                <br>
                <div class="row">
                    <!-- CON LOS IF SE VA COMPROBANDO SI LOS ARRAYS TIENEN MAS DE UN OBJETO, SI ES ASI SE CARGA LA COLUMNA, CASO CONTRARIO NO -->
                    @if (count($puntuacionniveluno) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de puntuación nivel uno</strong>
                            <br>
                            @foreach ($puntuacionniveluno as $categorypunctuation)
                                <ul>
                                    <input type="checkbox" name="categorypunctuations[]" value="{{$categorypunctuation->id}}">
                                    {{$categorypunctuation->name}}
                                </ul>
                            @endforeach
                        </div>
                    @endif

                    @if (count($puntuacionniveldos) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de puntuación nivel dos</strong>
                            <br>
                            @foreach ($puntuacionniveldos as $sectionpunctuation)
                                <ul>
                                    <input type="checkbox" name="sectionpunctuations[]" value="{{$sectionpunctuation->id}}">
                                    {{$sectionpunctuation->name}}
                                </ul>
                            @endforeach
                        </div>
                    @endif

                    @if (count($puntuacionniveltres) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de puntuación nivel tres</strong>
                            <br>
                            @foreach ($puntuacionniveltres as $postpunctuation)
                                <ul>
                                    <input type="checkbox" name="postpunctuations[]" value="{{$postpunctuation->id}}">
                                    {{$postpunctuation->name}}
                                </ul>
                            @endforeach
                        </div>
                    @endif

                    @if (count($puntuacionnivelcuatro) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de puntuación nivel cuatro</strong>
                            <br>
                            @foreach ($puntuacionnivelcuatro as $rulepunctuation)
                                <ul>
                                    <input type="checkbox" name="rulepunctuations[]" value="{{$rulepunctuation->id}}">
                                    {{$rulepunctuation->name}}
                                </ul>
                            @endforeach
                        </div>
                    @endif

                    @if (count($puntuacionnivelcinco) > 0)
                        <div class="col">
                            <strong class="text-red">Reglas de puntuación nivel cinco</strong>
                            <br>
                            @foreach ($puntuacionnivelcinco as $notepunctuation)
                                <ul>
                                    <input type="checkbox" name="notepunctuations[]" value="{{$notepunctuation->id}}">
                                    {{$notepunctuation->name}}
                                </ul>
                            @endforeach
                        </div> 
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-primary my-3">Crear pregunta</button>
        </form>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

<!--PLUGIN STRING TO SLUG-->
@section('js')
    
    <script src="{{asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js')}}"></script>
    <!-- LLAMAR A CKEDITOR QUE ESTA EN PUBLIC -->
    <script src="{{asset('ckeditor/ckeditor5-build-classic/ckeditor.js')}}"></script>

    <script>
        $(document).ready( function() {
            $("#title").stringToSlug({
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                space: '-'
            });
        });


        //REEMPLAZAR TEXTARE DEL BODY CON CKEDITOR
        ClassicEditor
        .create( document.querySelector( '#rule' ) )
        .catch( error => {
            console.error( error );
        } );

    </script>
@stop