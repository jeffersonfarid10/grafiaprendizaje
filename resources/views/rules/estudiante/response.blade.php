<x-app-layout>
    <div>
        @if (($question->type) === "OM")
            <!--CARD-->
            <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
                <!--CARD HEADER-->
                <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                    <div class="text-2xl font-bold mb-2">
                        {{$question->title}}
                        <br>
                        <div class="text-2xl font-bold mb-2">
                            <h4><strong>Indicaciones:</strong></h4>
                            <br>
                            <ul>
                                @foreach ($question->indications as $key=>$indication)
                                    <li>{{$key+1}}. {{$indication->indication}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- CARDBODY -->
                <div class="text-gray-800 leading-relaxed mb-6 ">
                    <!-- FORMULARIO PARA CAPTURAR LA RESPUESTA DEL USUARIO -->
                    <form action="{{route('estudiante.save.om')}}" method="POST">
                        @csrf 
                        <!-- OPCIONES DE RESPUESTA -->
                        @foreach ($question->answers as $key=>$answer)
                            <br>
                            <label class="cols-2"><strong>{{$key+1}}. {{$answer->answer}}</strong></label>
                            <input type="radio" name="answer_user" value="{{$answer->answer}}" required> 
                            <br>    
                        @endforeach

                        <!-- ID PREGUNTA ACTUAL -->
                        <input type="hidden" name="question_id" value="{{$question->id}}">
                        <br>
                        <!-- BOTON FORMULARIO -->
                        <button class="px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all ext-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
                            Guardar respuesta
                        </button>
                    </form>
                </div>
            </div>
        @elseif (($question->type) === "PC")
            <!--CARD-->
                <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
                    <!-- CARD HEADER -->
                    <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                        <div class="text-2xl font-bold mb-2">
                            {{$question->title}}
                            <br>
                    <div class="text-2xl font-bold mb-2">
                        <h4><strong>Indicaciones:</strong></h4>
                        <br>
                        <ul>
                            @foreach ($question->indications as $key=>$indication)
                                <li>{{$key+1}}. {{$indication->indication}}</li>
                            @endforeach
                        </ul>
                    </div>
                        </div>
                    </div>
                    <!-- CARD BODY -->
                    <div class="text-gray-800 leading-relaxed mb-6 ">
                        <!-- FORMULARIO PARA CAPTURAR LAS RESPUESTAS DEL USUARIO -->
                        <form action="{{route('estudiante.save.pc')}}" method="POST">
                            @csrf 
                            
                            <!-- RESPUESTA USUARIO -->
                            <div class="form-group">
                                <!-- RECORRER LAS VISIBLE ANSWERS QUE EL USUARIO DEBE CORREGIR -->
                                @foreach ($question->answers as $key=>$answer)
                                    <div class="row-span-2">
                                        <br>
                                        <div class="col-span-1">
                                            <label name="visible_answer">{{$answer->visible_answer}}</label>
                                        </div>
                                        <div class="col-span-1">
                                            <input type="text" name="fanswers[]" placeholder="Ingrese la respuesta {{$key+1}}" value="{{old('answer_user')}}" required>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- ID DE LA PREGUNTA ACTUAL -->
                            <input type="hidden" name="question_id" value="{{$question->id}}">
                            <br>
                            <!-- BOTON FORMULARIO -->
                            <button class="px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all ext-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
                                Guardar respuesta
                            </button>
                        </form>
                    </div>
                </div>
        @elseif(($question->type) === "OMI")
            <!--CARD-->
            <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
                <!--CARD HEADER-->
                <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                    <div class="text-2xl font-bold mb-2">
                        {{$question->title}}
                        <br>
                        <div class="text-2xl font-bold mb-2">
                            <h4><strong>Indicaciones:</strong></h4>
                            <br>
                            <ul>
                                @foreach ($question->indications as $key=>$indication)
                                    <li>{{$key+1}}. {{$indication->indication}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- IMAGE -->
                <div>
                    <img id="image" name="image" src="/storage/{{$question->image}}" alt="" height="400px" width="700px">
                </div>
                <!-- CARDBODY -->
                <div class="text-gray-800 leading-relaxed mb-6 ">
                    <!-- FORMULARIO PARA CAPTURAR LA RESPUESTA DEL USUARIO -->
                    <form action="{{route('estudiante.save.omi')}}" method="POST">
                        @csrf 
                        <!-- OPCIONES DE RESPUESTA -->
                        @foreach ($question->answers as $key=>$answer)
                            <br>
                            <label class="cols-2"><strong>{{$key+1}}. {{$answer->answer}}</strong></label>
                            <input type="radio" name="answer_user" value="{{$answer->answer}}" required> 
                            <br>    
                        @endforeach

                        <!-- ID PREGUNTA ACTUAL -->
                        <input type="hidden" name="question_id" value="{{$question->id}}">
                        <br>
                        <!-- BOTON FORMULARIO -->
                        <button class="px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all ext-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
                            Guardar respuesta
                        </button>
                    </form>
                </div>
            </div>
        @elseif(($question->type) === "OMA")
            <!--CARD-->
            <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
                <!--CARD HEADER-->
                <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                    <div class="text-2xl font-bold mb-2">
                        {{$question->title}}
                        <br>
                        <div class="text-2xl font-bold mb-2">
                            <h4><strong>Indicaciones:</strong></h4>
                            <br>
                            <ul>
                                @foreach ($question->indications as $key=>$indication)
                                    <li>{{$key+1}}. {{$indication->indication}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- IMAGE -->
                <div>
                    <img id="image" name="image" src="/storage/{{$question->image}}" alt="" height="400px" width="700px">
                </div>
                <!-- AUDIO -->
                <div>
                    <label>Reproduzca el audio</label>
                    <br>
                    <audio id="audio" name="audio" controls src="/storage/{{$question->audio}}" type="audio">Tu navegador no soporta este elemento, utiliza otro navegador.</audio>
                </div>
                <!-- CARDBODY -->
                <div class="text-gray-800 leading-relaxed mb-6 ">
                    <!-- FORMULARIO PARA CAPTURAR LA RESPUESTA DEL USUARIO -->
                    <form action="{{route('estudiante.save.oma')}}" method="POST">
                        @csrf 
                        <!-- OPCIONES DE RESPUESTA -->
                        @foreach ($question->answers as $key=>$answer)
                            <br>
                            <label class="cols-2"><strong>{{$key+1}}. {{$answer->answer}}</strong></label>
                            <input type="radio" name="answer_user" value="{{$answer->answer}}" required> 
                            <br>    
                        @endforeach

                        <!-- ID PREGUNTA ACTUAL -->
                        <input type="hidden" name="question_id" value="{{$question->id}}">
                        <br>
                        <!-- BOTON FORMULARIO -->
                        <button class="px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all ext-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
                            Guardar respuesta
                        </button>
                    </form>
                </div>
            </div>
        @elseif(($question->type) === "OA")
            <!--CARD-->
            <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
                <!--CARD HEADER-->
                <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                    <div class="text-2xl font-bold mb-2">
                        {{$question->title}}
                        <br>
                        <div class="text-2xl font-bold mb-2">
                            <h4><strong>Indicaciones:</strong></h4>
                            <br>
                            <ul>
                                @foreach ($question->indications as $key=>$indication)
                                    <li>{{$key+1}}. {{$indication->indication}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- IMAGE -->
                <div>
                    <img id="image" name="image" src="/storage/{{$question->image}}" alt="" height="400px" width="700px">
                </div>
                <br>
                <!-- AUDIO -->
                <div>
                    <label class="py-3">Reproduzca el audio:</label>
                    <br>
                    <audio id="audio" name="audio" controls src="/storage/{{$question->audio}}" type="audio">Tu navegador no soporta este elemento, utiliza otro navegador.</audio>
                </div>
                <br>
                <!-- CARDBODY -->
                <div class="text-gray-800 leading-relaxed mb-6 ">
                    <!-- FORMULARIO PARA CAPTURAR LA RESPUESTA DEL USUARIO -->
                    <form action="{{route('estudiante.save.oa')}}" method="POST">
                        @csrf 
                        
                        <!-- RESPUESTA USUARIO -->
                        <div class="form-group">
                            
                            <!-- MOSTRAR 5 INPUTS PARA QUE EL ESTUDIANTE INGRESE LAS ORACIONES -->
                            @for($i=0; $i<5; $i++)
                                <br>
                                <label>Respuesta a la oración {{$i+1}} :</label>
                                <br>
                                <input type="text" name="fanswers[]" placeholder="Ingrese la oracion correctamente escrita {{$i+1}}" value="{{old('answer_user')}}" required class="form-control">
                            @endfor
                        </div>

                        <!-- ID PREGUNTA ACTUAL -->
                        <input type="hidden" name="question_id" value="{{$question->id}}">
                        <br>
                        <!-- BOTON FORMULARIO -->
                        <button class="px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all ext-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
                            Guardar respuesta
                        </button>
                    </form>
                </div>
            </div>

        @elseif(($question->type) === "OI")
            <!--CARD-->
            <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
                <!--CARD HEADER-->
                <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                    <div class="text-2xl font-bold mb-2">
                        {{$question->title}}
                        <br>
                        <div class="text-2xl font-bold mb-2">
                            <h4><strong>Indicaciones:</strong></h4>
                            <br>
                            <ul>
                                @foreach ($question->indications as $key=>$indication)
                                    <li>{{$key+1}}. {{$indication->indication}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- IMAGE -->
                <div>
                    <img id="image" name="image" src="/storage/{{$question->image}}" alt="" height="400px" width="700px">
                </div>
                <br>

                <!-- CARDBODY -->
                <div class="text-gray-800 leading-relaxed mb-6 ">
                    <!-- FORMULARIO PARA CAPTURAR LA RESPUESTA DEL USUARIO -->
                    <form action="{{route('estudiante.save.oi')}}" method="POST">
                        @csrf 
                        
                        <!-- RESPUESTA USUARIO -->
                        <div class="form-group">
                            
                            <!-- MOSTRAR 5 INPUTS PARA QUE EL ESTUDIANTE INGRESE LAS ORACIONES -->
                            @for($i=0; $i<5; $i++)
                                <br>
                                <label>Respuesta a la oración {{$i+1}} :</label>
                                <br>
                                <input type="text" name="fanswers[]" placeholder="Ingrese la oracion correctamente escrita {{$i+1}}" value="{{old('answer_user')}}" required class="form-control">
                            @endfor
                        </div>

                        <!-- ID PREGUNTA ACTUAL -->
                        <input type="hidden" name="question_id" value="{{$question->id}}">
                        <br>
                        <!-- BOTON FORMULARIO -->
                        <button class="px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all ext-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
                            Guardar respuesta
                        </button>
                    </form>
                </div>
            </div>
        @elseif(($question->type) === "TI")
        <!--CARD-->
        <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
            <!--CARD HEADER-->
            <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                <div class="text-2xl font-bold mb-2">
                    {{$question->title}}
                    <br>
                    <div class="text-2xl font-bold mb-2">
                        <h4><strong>Indicaciones:</strong></h4>
                        <br>
                        <ul>
                            @foreach ($question->indications as $key=>$indication)
                                <li>{{$key+1}}. {{$indication->indication}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!-- IMAGE -->
            <div>
                <img id="image" name="image" src="/storage/{{$question->image}}" alt="" height="400px" width="700px">
            </div>
            <br>

            <!-- CARDBODY -->
            <div class="text-gray-800 leading-relaxed mb-6 ">
                <!-- FORMULARIO PARA CAPTURAR LA RESPUESTA DEL USUARIO -->
                <form action="{{route('estudiante.save.ti')}}" method="POST">
                    @csrf 
                    
                    <!-- RESPUESTA USUARIO -->
                    <div class="form-group">
                        <!-- MOSTRAR TEXT AREA PARA QUE EL USUARIO ESCRIBA EL PARRAFO -->
                        <textarea name="answer_user" id="answer_user" value={{old('answer_user')}} cols="50" rows="10" class="form-control"></textarea>
                    </div>

                    <!-- ID PREGUNTA ACTUAL -->
                    <input type="hidden" name="question_id" value="{{$question->id}}">
                    <br>
                    <!-- BOTON FORMULARIO -->
                    <button class="px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all ext-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
                        Guardar respuesta
                    </button>
                </form>
            </div>
        </div>

        @elseif(($question->type) === "TA")

        <!--CARD-->
        <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
            <!--CARD HEADER-->
            <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                <div class="text-2xl font-bold mb-2">
                    {{$question->title}}
                    <br>
                    <div class="text-2xl font-bold mb-2">
                        <h4><strong>Indicaciones:</strong></h4>
                        <br>
                        <ul>
                            @foreach ($question->indications as $key=>$indication)
                                <li>{{$key+1}}. {{$indication->indication}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!-- IMAGE -->
            <div>
                <img id="image" name="image" src="/storage/{{$question->image}}" alt="" height="400px" width="700px">
            </div>
            <br>

            <!-- AUDIO -->
            <div>
                <label class="py-3">Reproduzca el audio:</label>
                <br>
                <audio id="audio" name="audio" controls src="/storage/{{$question->audio}}" type="audio">Tu navegador no soporta este elemento, utiliza otro navegador.</audio>
            </div>
            <br>

            <!-- CARDBODY -->
            <div class="text-gray-800 leading-relaxed mb-6 ">
                <!-- FORMULARIO PARA CAPTURAR LA RESPUESTA DEL USUARIO -->
                <form action="{{route('estudiante.save.ta')}}" method="POST">
                    @csrf 
                    
                    <!-- RESPUESTA USUARIO -->
                    <div class="form-group">
                        <!-- MOSTRAR TEXT AREA PARA QUE EL USUARIO ESCRIBA EL PARRAFO -->
                        <textarea name="answer_user" id="answer_user" value={{old('answer_user')}} cols="50" rows="10" class="form-control"></textarea>
                    </div>

                    <!-- ID PREGUNTA ACTUAL -->
                    <input type="hidden" name="question_id" value="{{$question->id}}">
                    <br>
                    <!-- BOTON FORMULARIO -->
                    <button class="px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all ext-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
                        Guardar respuesta
                    </button>
                </form>
            </div>
        </div>

        @elseif(($question->type) === "JA")
        <!-- CARD -->
        <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
            <!-- CARD HEADER -->
            <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                <div class="text-2xl font-bold mb-2">
                    {{$question->title}}
                    <!-- INPUT HIDDEN DONDE SE GUARDA LA RESPUESTA DEL JUEGO QUE SE VA A JS -->
                    <!-- AQUI NO SE PONE ID = ANSWER COMO EN LAS DEMAS PREGUNTAS SINO QUE SE CAMBIA EL NOMBRE DE LA VARIABLE
                    PORQUE SINO DA ERROR AL LEER LAS DEMAS PREGUNTAS -->
                    @foreach ($question->answers as $answer)
                        <input type="text" name="answerjuego" id="answerjuego" value="{{$answer->answer}}">
                    @endforeach
                    <br>
                    <div class="text-2xl font-bold mb-2">
                        <h4><strong>Indicaciones:</strong></h4>
                        <br>
                        <ul>
                            @foreach ($question->indications as $key=>$indication)
                                <li>{{$key+1}}. {{$indication->indication}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!-- CARD BODY -->
            <div class="bg-cyan-700 flex m-auto p-5 gap-8" width="80%">
                <!-- MOSTRAR LA ORACION VISIBLE -->
                @foreach ($question->answers as $answer)
                    <h3><strong>{{$answer->visible_answer}}</strong></h3>
                @endforeach
                <br>

                <!-- IMAGEN INICIAL JUEGO -->
                <img src="/img/img0.png" id="imagen_juego" alt="" width="200px">


                <!-- DIV QUE CONTIENE LOS ELEMENTOS PARA JUGAR EL JUEGO -->
                <div>
                    <p id="palabra_adivinar" class="h-12 m-4">
                        	<!-- AQUI SE VAN A MOSTRAR LOS GUIONES Y LAS LETRAS DE LA PALABRA SEGUN EL USUARIO VAYA JUGANDO -->
                    </p>

                    <!-- BOTON PARA INICIAR EL JUEGO -->
                    <button id="iniciar_juego" class="m-4 px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all text-white bg-blue-500 hover:bg-blue-700 ring-blue-300 focus:ring">
                        Iniciar Juego
                    </button>

                    <br>
                    <!-- MOSTRAR UN MENSAJE DE SI EL USUARIO HA GANADO O PERDIDO -->
                    <p id="resultado"></p>

                    <!-- DIV CON LOS BOTONES PARA QUE EL USUARIO HAGA CLICK EN EL BOTON -->
                    <div id="letras" class="flex flex-wrap gap-2">

                        <!-- LETRAS MINUSCULAS -->
                        <strong class="text-amber-800">Letras Minúsculas</strong>
                        <br>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">a</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">b</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">c</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">d</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">e</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">f</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">g</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">h</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">i</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">j</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">k</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">l</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">m</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">n</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">ñ</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">o</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">p</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">q</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">r</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">s</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">t</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">u</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">v</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">w</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">x</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">y</button>
                        <button class="px-0 py-1 text-center w-6 bg-slate-500 rounded">z</button>
                        

                        <br>
                        <strong class="text-cyan-600">Vocales con acentuación y diéresis</strong>
                        <br>
                        <button class="px-0 py-1 text-center w-6 bg-sky-400 rounded">á</button>
                        <button class="px-0 py-1 text-center w-6 bg-sky-400 rounded">é</button>
                        <button class="px-0 py-1 text-center w-6 bg-sky-400 rounded">í</button>
                        <button class="px-0 py-1 text-center w-6 bg-sky-400 rounded">ó</button>
                        <button class="px-0 py-1 text-center w-6 bg-sky-400 rounded">ú</button>
                        <button class="px-0 py-1 text-center w-6 bg-sky-400 rounded">ü</button>

                        <br>
                        <strong class="text-green-800">Letras Mayúsculas</strong>
                        <br>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">A</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">B</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">C</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">D</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">E</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">F</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">G</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">H</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">I</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">J</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">K</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">L</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">M</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">N</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">Ñ</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">O</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">P</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">Q</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">R</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">S</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">T</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">U</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">V</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">W</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">X</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">Y</button>
                        <button class="px-0 py-1 text-center w-6 bg-amber-200 rounded">Z</button>

                        


                    </div>
                </div>

                <br>

                <!-- FORMULARIO QUE CAPTURA LA RESPUESTA DEEL USUARIO SI GANO O PERDIO DESDE JS -->
                <div>
                    <form action="{{route('estudiante.save.ja')}}" method="POST">
                        @csrf 
                        <!-- CAPTURAR SI LA RESPUESTA ES CORRECTA O INCORRECTA -->
                        <div>
                            <input type="hidden" name="answer_user" id="answer_user" value="{{old('answer_user')}}">

                            <!-- ID DE LA PREGUNTA ACTUAL -->
                            <input type="hidden" name="question_id" value="{{$question->id}}">
                            <br>
                            <!-- BOTON FORMULARIO -->
                            <button id="guardar_respuesta" class="m-4 px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all text-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
                                Salir
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @elseif(($question->type) === "SL")

        <!-- CARD -->
        <div class="bg-gray-200 rounded-xl p-6 overflow-hidden">
            <!-- CARD HEADER -->
            <div class="border-b border-gray-300 pb-4 mb-3 flex items-center justify-between">
                <div class="text-2xl font-bold mb-2">
                    {{$question->title}}

                    <div class="text-2xl font-bold mb-2">
                        <h4><strong>Indicaciones:</strong></h4>
                        <br>
                        <ul>
                            @foreach ($question->indications as $key=>$indication)
                                <li>{{$key+1}}. {{$indication->indication}}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- EN ESTA SECCION SE ENVIAN AL SCRIPT DE JS LAS PALABRAS PARA LA SOPA DE LETRAS -->
                    <!-- AQUI NO SE PONE ID = ANSWER COMO EN LAS DEMAS PREGUNTAS SINO QUE SE CAMBIA EL NOMBRE DE LA VARIABLE
                    PORQUE SINO DA ERROR AL LEER LAS DEMAS PREGUNTAS -->
                    <div class="row">
                        <div class="col" id="palabras_correctas">
                            {{--<h4>Palabras correctas</h4>--}}
                            @foreach ($question->answers as $key=>$answer)
                                <input type="hidden" name="answer" id="answer" value="{{$answer->answer}}">
                            @endforeach
                        </div>
                        <div class="col" id="palabras_incorrectas">
                            {{--<h4>Palabras incorrectas</h4>--}}
                            @foreach ($question->answers as $key=>$visible)
                                <input type="hidden" name="visible_answer" id="visible_answer" value="{{$visible->visible_answer}}">
                            @endforeach
                        </div>
                        {{--<div class="col" id="oraciones_palabras">
                            <h4>Oraciones</h4>
                            @foreach ($question->answers as $key=>$oracion)
                                <input type="text" name="second_answer" id="second_answer" value="{{$oracion}}">
                            @endforeach
                        </div>--}}
                    </div>


                </div>
            </div>
            <!-- CARD BODY -->
            <div class="text-gray-800 leading-relaxed mb-6 ">

                <!-- ORACIONES -->
                <div>
                    <strong class="text-red-500">Cada oración tiene una palabra escrita incorrectamente, encuentre la palabra correcta en la sopa de letras:</strong>
                    @foreach ($question->answers as $key=>$oracion)
                        <ul>{{$key+1}}. {{$oracion->second_answer}}</ul>
                        <br>
                    @endforeach
                </div>

                <!-- BOTON DE INICIAR JUEGO -->
                <button id="empezar_juego" class="m-4 px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all text-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
                    Empezar juego
                </button>


                <br>
                <!-- LUGAR DONDE SE VA A CREAR LA SOPA DE LETRAS -->
                {{--<div id="espaciosp" class="bg-yellow-300 my-0 mx-auto text-center" width="256px" height="256px" >--}}
                <div id="espacios">
                    <br>
                    {{--<h2 id="mensaje"></h2>--}}
                    <br>
                    <div id="tabla"></div>
                    <br>
                    {{--<div id="palabras" class="text-center text-3xl"></div>--}}
                    <br> 
                </div>
            </div>

            <!-- LISTADO DE PALABRAS A ENCONTRAR -->
            {{--<div>
                <strong class="text-red-500 ml-10">Encuentre las siguientes palabras:</strong>
                <div id="palabras" class="text-center text-3xl"></div>
            </div>--}}

            <!-- LUGAR DONDE VAN A APARECER LAS PALABRAS QUE EL USUARIO ENCUENTRE -->
            <!-- EL DIV CON ID LISTADO_PALABRAS SE PONE DENTRO DE UN DIV PADRE
            Y FUERA DEL DIV CON ID LISTADO_PALABRAS SE AGREGA EL TITULO Y MENSAJES PORQUE SINO DA ERROR -->
            <div>
                <h2 id="mensaje"></h2>
                <strong class="text-red-500">Palabras Encontradas:</strong>
                <li id="listado_palabras"></li>
                
                
            </div>
            

            <!-- BOTON PARA FINALIZAR EL JUEGO Y MOSTRAR LA SOLUCION AL USUARIO -->
            <button id="ver_respuesta" class="m-4 px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all text-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
                Finalizar Juego
            </button>


            <!-- FORMULARIO QUE CAPTURA LA RESPUESTA DEL USUARIO -->
            <div>
                <form action="{{route('estudiante.save.sl')}}" method="POST">
                    @csrf 
                    <!-- RESPUESTAS USUARIO -->
                    <div>
                        <input type="hidden" name="answer_user" id="answer_user" value="{{old('answer_user')}}">

                        <!-- ID DE LA PREGUNTA ACTUAL -->
                        <input type="hidden" name="question_id" value="{{$question->id}}">

                        <!-- ID DEL TOTAL DE PALABRAS QUE HA ENCONTRADO -->
                        <input type="hidden" name="totalpalabras" id="totalpalabras" value="{{old('totalpalabras')}}">

                        <!-- INPUT DONDE SE VAN A ALMACENAR LAS PALABRAS QUE VA ENCONTRANDO EL USUARIO -->
                        <input type="hidden" name="palabra_encontrada" id="palabra_encontrada" value="{{old('palabra_encontrada')}}"> 

                        <!-- INPUT DONDE SE GUARDA EL NUMERO TOTAL DE PALABRAS QUE INGRESARON MEDIANTE EL ALGORITMO A LA SOPA DE LETRAS -->
                        <input type="hidden" name="numeropalabrasasignadas" id="numeropalabrasasignadas" value="{{old('numeropalabrasasignadas')}}">

                        <!-- BOTON FORMULARIO -->
                        <button id="guardar_respuesta_sl" class="m-4 px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all text-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
                            Salir
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>

    <!-- SCRIPT JUEGO -->
    <script src="{{asset('/js/juegoahorcado.js')}}"></script>
    <!-- SCRIPT SOPA LETRAS -->
    <script src="{{asset('/js/sopaletraseventos.js')}}"></script>
</x-app-layout>