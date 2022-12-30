<x-app-layout>


    <!-- ////////////////////////////////////////////////NUEVA VISTA REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 5 NOTES/////////////////////////////////////// -->


    <!-- SE CREA UN DIV PADRE QUE VA A SER DE COLOR BLANCO -->
    <div class="bg-white">

        <!-- SE CREA UN DIV HIJO CON CLASS CONTAINER Y QUE DEBE TENER OBLIGATORIAMENTE UN PT-24 PORQUE SINO EL NAVBAR FIXED VA A TAPAR LA INFORMACION -->
        <div class="container mx-auto pt-24 rounded-xl p-12">
            <!-- TITULO CON DEGRADADO -->
            <h1 class="mb-4 text-3xl font-extrabold md:text-5xl lg:text-6xl text-center font-anton tracking-wide"><span class="text-red-700">{{$notewordObject->name}}</span></h1>
        </div>


        <!-- SE CREA UN GRID CON LA NAVEGACION DE REGRESAR A  SE DEBE AGREGAR LA CLASE INLINE-BLOCK A CADA ETIQUETA A, PORQUE SINO NO VA A APARECER LAS REGLAS EN LA MISMA LINEA-->
        <div class="container">
            Selecciona alguna categoría anterior para regresar a ella: 
            <br>
            
            <div>
                <!-- REGLA PRINCIPAL -->
                <a href="/estudiante/letters" class="inline-block">
                    <p class="leading-relaxed font-sora font-semibold text-gray-800">{{$categorywordObject->type}}</p>
                </a>
                >
                <!-- REGLA NIVEL UNO -->
                <a href="/estudiante/letters/{{$categorywordObject->slug}}" class="inline-block">
                    <p class="leading-relaxed font-sora font-semibold text-gray-800">{{$categorywordObject->name}}</p>
                </a>
                >
                <!-- REGLA NIVEL DOS -->
                <a href="/estudiante/letters/{{$categorywordObject->slug}}/{{$sectionwordObject->slug}}" class="inline-block">
                    <p class="leading-relaxed font-sora font-semibold text-gray-800">{{$sectionwordObject->name}}</p>
                </a>
                >
                <!-- REGLA NIVEL TRES -->
                <a href="/estudiante/letters/{{$categorywordObject->slug}}/{{$sectionwordObject->slug}}/{{$postwordObject->slug}}" class="inline-block">
                    <p class="leading-relaxed font-sora font-semibold text-gray-800">{{$postwordObject->name}}</p>
                </a>
                >
                <!-- REGLA NIVEL CUATRO -->
                <a href="/estudiante/letters/{{$categorywordObject->slug}}/{{$sectionwordObject->slug}}/{{$postwordObject->slug}}/{{$rulewordObject->slug}}" class="inline-block">
                    <p class="leading-relaxed font-sora font-semibold text-gray-800">{{$rulewordObject->name}}</p>
                </a>
            </div>
        </div>


        <!-- SE CREA UN GRID CON 3 COLUMNAS, 2 COLUMNAS PARA EL CONTENIDO DE LA REGLA ORTOGRAFICA Y UNA COLUMNA PARA LAS REGLAS RELACIONADAS -->
        <div class="grid md:grid-cols-3 gap-6">
            <!-- DIV HIJO QUE CONTIENE LA INFORMACION DE LA REGLA ORTOGRAFICA QUE OCUPA 1 COLUMNA POR DEFECTO Y DOS COLUMAS PANTALLAS MD PARA ARRIBA -->
            <div class="col-span-1 md:col-span-2">
                
                <!-- IMAGEN -->
                <!-- COMPROBAR SI EL CAMPO IMAGE TIENE CONTENIDO, SI TIENE CONTENIDO MUESTRA EL DIV, PERO SI EL CAMPO IMAGE ES NULL NO SE MUESTRA NADA -->
                @isset($notewordObject->image)
                    <div class="container mx-auto p-10">
                        <div class="w-4/5 mx-auto">
                            <!-- IMPORTANTE PONER LA LINEA DIAGONAL AL INICIO DE LA RUTA EN LAS IMAGENES DE LAS REGLAS DE NIVEL UNO PARA ADELANTE PORQUE SINO NO VA A APARECER LA IMAGEN -->
                            <img id="image" name="image" src="/storage/{{$notewordObject->image}}" alt="" class="w-full h-full object-cover object-center rounded-lg ">
                        </div>
                    </div> 
                @endisset

                <!-- GLOSARIO DE TERMINOS -->
                <!-- COMPROBAR SI LA REGLA NIVEL 1 (CATEGORIES) CONTIENE WORDS, SI ES ASI MUESTRA EL DIV, CASO CONTRARIO NO -->
                @if (count($notewordObject->words) > 0)
                    <div class="container mx-auto p-10 bg-amber-200 rounded-xl mt-10">
                        <!-- DIV QUE CONTIENE TODOS LOS TERMINOS DISPONIBLES PARA ESTA REGLA, AL FINAL SE PONE OVERFLOW-AUTO PARA QUE NO SE DESBORDE EL CONTENIDO DEL CONTAINER -->
                        <h3 class="font-anton text-red-400 pb-5 tracking-wide">Términos que pueden ser de ayuda:</h3>
                        <div class="overflow-auto">

                            <!-- RECORRER LA COLECCION DE WORDS -->
                            @foreach ($notewordObject->words as $word)
                                <!--  TERMINOS-->
                                <h3 class="font-sora text-red-700 font-semibold">{{$word->name}}</h3>
                                <p class="leading-relaxed text-justify p-2">{{$word->meaning}}</p>
                            @endforeach

                        </div>
                    </div>
                @endif
                

                <!-- CAMPO BODY -->
                <div class="container mx-auto p-10">
                    <!-- PARA MOSTRAR EL TEXTO DE CK EDITOR CON LOS ESTILOS SE CORRE EL SIGUIENTE COMANDO -->
                    {{-- npm install -D @tailwindcss/typography --}}
                    <!-- Y SE DEBE CREAR UN DIV CON LA CLASE:  class="prose lg:prose-xl" -->
                    <div class="p-4 ml-5 md:ml-10 lg:ml-20 overflow-auto prose lg:prose-2xl text-justify">
                        {!!$notewordObject->body!!}
                    </div>
                </div>


                <!-- COMPROBAR SI EL CAMPO EXAMPLE TIENE CONTENIDO, SI TIENE CONTENIDO SE MUESTRA EL CONTENIDO, CASO CONTRARIO NO SE MUESTRA NADA -->
                <!-- CAMPO EXAMPLE -->
                @isset($notewordObject->example)
                    <div class="container mx-auto p-10">
                        <!-- PARA MOSTRAR EL TEXTO DE CK EDITOR CON LOS ESTILOS SE CORRE EL SIGUIENTE COMANDO -->
                        {{-- npm install -D @tailwindcss/typography --}}
                        <!-- Y SE DEBE CREAR UN DIV CON LA CLASE:  class="prose lg:prose-xl" -->
                        <div class="p-4 ml-5 md:ml-10 lg:ml-20 overflow-auto prose lg:prose-2xl text-justify">
                            {!!$notewordObject->example!!}
                        </div>
                    </div>
                @endisset


                <!-- CAMPO EXCEPTION -->    
                @isset($notewordObject->exception)
                    <div class="container mx-auto p-10">
                        <!-- PARA MOSTRAR EL TEXTO DE CK EDITOR CON LOS ESTILOS SE CORRE EL SIGUIENTE COMANDO -->
                        {{-- npm install -D @tailwindcss/typography --}}
                        <!-- Y SE DEBE CREAR UN DIV CON LA CLASE:  class="prose lg:prose-xl" -->
                        <div class="p-4 ml-5 md:ml-10 lg:ml-20 overflow-auto prose lg:prose-2xl text-justify">
                            {!!$notewordObject->exception!!}
                        </div>
                    </div> 
                @endisset

                

            </div>

            <!-- TERCERA COLUMNA DONDE VAN LAS SUGERENCIAS DE REGLAS ORTOGRAFICAS -->
            <div class="col-span-1">
                <!-- CONTENEDOR QUE OCUPA TODO EL LARGO DE LA COLUMNA Y DEL ANCHO -->
                <div class="bg-slate-900 h-full rounded-3xl px-5 py-10">
                    

                    <!-- REGLAS NIVEL 5 SIMILARES (NOTES) -->
                    <div class="bg-indigo-300 rounded-xl mb-4">
                        <h2 class="pl-3 pt-3 text-black font-semibold font-sora">Más reglas ortográficas de: " {{$rulewordObject->name}} "</h2>
                        <div class="p-3 grid grid-cols-1 divide-y divide-yellow-400">

                            <!-- SE RECORREN LAS REGLAS SIMILARES -->
                            @foreach ($sugerenciasnivelcinco as $sugerencia)

                                <a href="/estudiante/letters/{{$categorywordObject->slug}}/{{$sectionwordObject->slug}}/{{$postwordObject->slug}}/{{$sugerencia->rule->slug}}/{{$sugerencia->slug}}">
                                    <div class="py-8 flex flex-wrap md:flex-nowrap">
                                        <div class="md:flex-grow">
                                            <h2 class="text-xl font-bold text-black title-font font-sora mb-1">{{$sugerencia->name}}</h2>
                                            <!-- CON EL ISSET SE MUESTRA LA DESCRIPCION SI ESTA EXISTE -->
                                            {{--@isset($sugerencia->description)
                                            <div class="prose lg:prose-m text-white">{!!$sugerencia->description!!}</div>
                                            @endisset--}}
                                        </div>
                                    </div>
                                </a>

                            @endforeach
                            
                        </div>
                    </div>


                    <!-- REGLAS NIVEL 4 SIMILARES (RULES) -->
                    <div class="bg-green-300 rounded-xl mb-4">
                        <h2 class="pl-3 pt-3 text-black font-semibold font-sora">Más reglas ortográficas de: " {{$postwordObject->name}} "</h2>
                        <div class="p-3 grid grid-cols-1 divide-y divide-yellow-400">

                            <!-- SE RECORREN LAS REGLAS SIMILARES -->
                            @foreach ($sugerenciasnivelcuatro as $sugerencia)

                                <a href="/estudiante/letters/{{$categorywordObject->slug}}/{{$sectionwordObject->slug}}/{{$sugerencia->post->slug}}/{{$sugerencia->slug}}">
                                    <div class="py-8 flex flex-wrap md:flex-nowrap">
                                        <div class="md:flex-grow">
                                            <h2 class="text-xl font-bold text-black title-font font-sora mb-1">{{$sugerencia->name}}</h2>
                                            <!-- CON EL ISSET SE MUESTRA LA DESCRIPCION SI ESTA EXISTE -->
                                            {{--@isset($sugerencia->description)
                                            <div class="prose lg:prose-m text-white">{!!$sugerencia->description!!}</div>
                                            @endisset--}}
                                        </div>
                                    </div>
                                </a>

                            @endforeach
                            
                        </div>
                    </div>

                    <!-- REGLAS NIVEL 3 SIMILARES (POSTS) -->
                    <div class="bg-amber-200 rounded-xl mb-4">
                        <h2 class="pl-3 pt-3 text-black font-semibold font-sora">Más reglas ortográficas de: " {{$sectionwordObject->name}} "</h2>
                        <div class="p-3 grid grid-cols-1 divide-y divide-gray-400">

                            <!-- SE RECORREN LAS REGLAS SIMILARES -->
                            @foreach ($sugerenciasniveltres as $sugerencia)

                                <a href="/estudiante/letters/{{$categorywordObject->slug}}/{{$sugerencia->section->slug}}/{{$sugerencia->slug}}">
                                    <div class="py-8 flex flex-wrap md:flex-nowrap">
                                        <div class="md:flex-grow">
                                            <h2 class="text-xl font-bold text-black title-font font-sora mb-1">{{$sugerencia->name}}</h2>
                                            <!-- CON EL ISSET SE MUESTRA LA DESCRIPCION SI ESTA EXISTE -->
                                            {{--@isset($sugerencia->description)
                                            <div class="prose lg:prose-m text-white">{!!$sugerencia->description!!}</div>
                                            @endisset--}}
                                        </div>
                                    </div>
                                </a>

                            @endforeach
                            
                        </div>
                    </div>


                    <!-- REGLAS NIVEL 2 SIMILARES (SECTIONS) -->
                    <div class="bg-rose-400 rounded-xl mb-4">
                        <h2 class="pl-3 pt-3 text-black font-semibold font-sora">Más reglas ortográficas de: " {{$categorywordObject->name}} "</h2>
                        <div class="p-3 grid grid-cols-1 divide-y divide-yellow-400">

                            <!-- SE RECORREN LAS REGLAS SIMILARES -->
                            @foreach ($sugerenciasniveldos as $sugerencia)

                                <a href="/estudiante/letters/{{$sugerencia->category->slug}}/{{$sugerencia->slug}}">
                                    <div class="py-8 flex flex-wrap md:flex-nowrap">
                                        <div class="md:flex-grow">
                                            <h2 class="text-xl font-bold text-black title-font font-sora mb-1">{{$sugerencia->name}}</h2>
                                            <!-- CON EL ISSET SE MUESTRA LA DESCRIPCION SI ESTA EXISTE -->
                                            {{--@isset($sugerencia->description)
                                            <div class="prose lg:prose-m text-white">{!!$sugerencia->description!!}</div>
                                            @endisset--}}
                                        </div>
                                    </div>
                                </a>

                            @endforeach
                            
                        </div>
                    </div>

                    <!-- REGLAS NIVEL 1 SIMILARES (CATEGORIES) -->
                    <div class="bg-blue-700 rounded-xl mb-4">
                        <h2 class="pl-3 pt-3 text-white font-semibold font-sora">Más reglas ortográficas de: " {{$categorywordObject->type}} "</h2>
                        <div class="p-3 grid grid-cols-1 divide-y divide-yellow-400">

                            <!-- SE RECORREN LAS REGLAS SIMILARES -->
                            @foreach ($sugerenciasniveluno as $sugerencia)

                                <a href="{{route('estudiante.letterslevelone.show', $sugerencia)}}">
                                    <div class="py-8 flex flex-wrap md:flex-nowrap">
                                        <div class="md:flex-grow">
                                            <h2 class="text-xl font-bold text-white title-font font-sora mb-1">{{$sugerencia->name}}</h2>
                                            <!-- CON EL ISSET SE MUESTRA LA DESCRIPCION SI ESTA EXISTE -->
                                            {{--@isset($sugerencia->description)
                                            <div class="prose lg:prose-m text-white">{!!$sugerencia->description!!}</div>
                                            @endisset--}}
                                        </div>
                                    </div>
                                </a>

                            @endforeach
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>





    </div>




    <!-- /////////////////////////////////////////////////////////FIN NUEVA VISTA REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 5 NOTES////////////////////////////////////// -->


    <!-- VISTA REGLAS ORTOGRAFICAS DE PALABRAS NIVEL 5 NOTES ORIGINAL -->


    <!-- NOMBRE DE LA REGLA POST -->
    <h1 class="bg-red-900 text-6xl text-white text-center"><strong>{{$notewordObject->name}}</strong></h1>

    <!-- DIV QUE TIENE 3 COLUMNAS 2 PARA LA REGLA Y 1 PARA MOSTRAR LAS REGLAS DE NIVEL 1, NIVEL 2, NIVEL 3, NIVEL 4 Y NIVEL 5 -->
    <div class="grid grid-cols-3 gap-6">

        <!-- DIV PARA REGRESAR ENTRE CATEGORIAS, COMO ES LA REGLA NIVEL CUATRO SE PUEDE REGRESAR A LA NIVEL TRES, NIVEL DOS, NIVEL UNO Y PAGINA PRINCIPAL -->
        <div>
            Regresar a: 
            <br>
            <a href="/estudiante/letters"><strong class="text-amber-600">{{$categorywordObject->type}}</strong></a>
            <br>
            <a href="/estudiante/letters/{{$categorywordObject->slug}}"><strong class="text-cyan-700">{{$categorywordObject->name}}</strong></a>
            <br>
            <a href="/estudiante/letters/{{$categorywordObject->slug}}/{{$sectionwordObject->slug}}"><strong class="text-green-700">{{$sectionwordObject->name}}</strong></a>
            <br>
            <a href="/estudiante/letters/{{$categorywordObject->slug}}/{{$sectionwordObject->slug}}/{{$postwordObject->slug}}"><strong class="text-pink-600">{{$postwordObject->name}}</strong></a>
            <br>
            <a href="/estudiante/letters/{{$categorywordObject->slug}}/{{$sectionwordObject->slug}}/{{$postwordObject->slug}}/{{$rulewordObject->slug}}"><strong class="text-emerald-500">{{$rulewordObject->name}}</strong></a>

        </div>

        <br>

            <!-- DIV QUE CONTIENE LA REEGLA ORTOGRAFICA -->
            <div class="col-span-2">

                <!-- COMPROBAR SI EL CAMPO IMAGE TIENE CONTENIDO, SI TIENE CONTENIDO SE MUESTRA EL DIV, PERO SI ES NULL NO SE MUESTRA NADA -->
                @isset($notewordObject->image)
                    <img id="image" name="image" src="/storage/{{$notewordObject->image}}" alt="" height="400px" width="700px">
                @endisset

                <br>


                <!-- COMPROBAR SI LA REGLA NIVEL 3 (POSTS) CONTIENE WORDS, SI ES ASI SE MUESTRA EL DIV CASO CONTRARIO NO -->
                @if (count($notewordObject->words) > 0)
                    <div class="bg-gray-400">
                        <strong class="text-violet-500">Glosario de términos:</strong>
                        <br>
                        @foreach ($notewordObject->words as $word)
                            
                            <div>
                                <strong class="text-red-500">{{$word->name}}</strong>
                                <br>
                                <p>{{$word->meaning}}</p>
                            </div>
                            <br>
                        @endforeach
                    </div>
                @endif

                <br>

                <!-- MOSTRAR EL CAMPO BODY -->
                <div>
                    <!-- PARA MOSTRAR EL TEXTO DE CK EDITOR CON LOS ESTILOS SE CORRE EL SIGUIENTE COMANDO -->
                    {{-- npm install -D @tailwindcss/typography --}}
                    <!-- Y SE DEBE CREAR UN DIV CON LA CLASE:  class="prose lg:prose-xl" -->
                    <div class="prose lg:prose-xl">{!!$notewordObject->body!!}</div>
                </div>

                <!-- COMPROBAR SI EL CAMPO EXAMPLE TIENE CONTENIDO, SI TIENE CONTENIDO SE MUESTRA EL CONTENIDO, SI NO TIENE CONTENIDO NO SE MUESTRA NADA -->
                @isset($notewordObject->example)
                    <div>
                        <!-- PARA MOSTRAR EL TEXTO DE CK EDITOR CON LOS ESTILOS SE CORRE EL SIGUIENTE COMANDO -->
                        {{-- npm install -D @tailwindcss/typography --}}
                        <!-- Y SE DEBE CREAR UN DIV CON LA CLASE:  class="prose lg:prose-xl" -->
                        <div class="prose lg:prose-xl">{!!$notewordObject->example!!}</div>
                    </div>
                @endisset

                <!-- COMPROBAR SI EL CAMPO EXCEPTION TIENE CONTENIDO, SI NO TIENE NO MUESTRA NADA -->
                @isset($notewordObject->exception)
                    <!-- PARA MOSTRAR EL TEXTO DE CK EDITOR CON LOS ESTILOS SE CORRE EL SIGUIENTE COMANDO -->
                    {{-- npm install -D @tailwindcss/typography --}}
                    <!-- Y SE DEBE CREAR UN DIV CON LA CLASE:  class="prose lg:prose-xl" -->
                    <div class="prose lg:prose-xl">{!!$notewordObject->exception!!}</div>
                @endisset


            </div>


            <!-- ASIDE PARA MOSTRAR EN LA DERECHA DE LA PANTALLA LAS REGLAS DE NIVEL 1 (CATEGORIES) REGLAS SIMILARES DE NIVEL 2 (SECTIONS) 
            REGLAS SIMILARES DE NIVEL 3 (POSTS) REGLAS SIMILARES DE NIVEL 4 (RULES) Y REGLAS SIMILARES DE NIVEL 5 (NOTES) -->
            <aside>

                <!-- SUGERENCIA DE REGLAS DE NIVEL 5 SIMILARES (NOTES) -->
                <div class="bg-amber-300">

                    <strong class="text-red-500 my-3">Más reglas ortográficas de: "{{$rulewordObject->name}}"</strong>
                    <br>
                    @foreach ($sugerenciasnivelcinco as $sugerencia)
                        <div class="mb-4">
                            <!-- EN LA HREF SE ENVIA EL SLUG DE LA CATEGORIA NIVEL 1 (CATEGORY) A LA QUE PERTENECE ESTA REGLA NIVEL 2 (SECTION) 
                            EL SLUG DE LAS REGLAS NIVEL 2 (SECTION) SIMILARES, EL SLUG DE LAS REGLAS DEE NIVEL 3 (POSTS) Y EL SLUG DE LAS REGLAS
                            NIVEL 4 (RULES) Y EL SLUG DE LAS REGLAS DE NIVEL 5 (NOTES) -->
                            <a href="/estudiante/letters/{{$categorywordObject->slug}}/{{$sectionwordObject->slug}}/{{$postwordObject->slug}}/{{$sugerencia->rule->slug}}/{{$sugerencia->slug}}">
                                <strong class="text-lime-500">{{$sugerencia->name}}</strong>
                                <br>
                                <!-- CON EL ISSET SE MUESTRA LA DESCRIPTION QUE ES OPCIONAL PARA LAS REGLAS DE NIVEL 2 -->
                                @isset($sugerencia->description)
                                    <div class="prose lg:prose-xl">
                                        {!!$sugerencia->description!!}
                                    </div>
                                @endisset
                            </a>
                        </div>
                    @endforeach
                </div>


                <!-- SUGERENCIA DE REGLAS DE NIVEL 4 SIMILARES (RULES) -->
                <div class="bg-teal-300">
                    <strong class="text-red-500 my-5">Más reglas ortográficas de: "{{$postwordObject->name}}"</strong>
                    <br>
                    @foreach ($sugerenciasnivelcuatro as $sugerencia)
                        <div class="mb-4">
                            <!-- EN LA HREF SE ENVIA EL SLUG DE LA CATEGORIA NIVEL 1 (CATEGORY) A LA QUE PERTENECE ESTA REGLA NIVEL 2 (SECTION) 
                            EL SLUG DE LAS REGLAS NIVEL 2 (SECTION) SIMILARES, EL SLUG DE LAS REGLAS DE NIVEL 3 (POSTS) Y EL SLUG DE LAS REGLAS
                            NIVEL 4 (RULES) -->
                            <a href="/estudiante/letters/{{$categorywordObject->slug}}/{{$sectionwordObject->slug}}/{{$sugerencia->post->slug}}/{{$sugerencia->slug}}">
                                <strong class="text-orange-500">{{$sugerencia->name}}</strong>
                                <br>
                                <!-- CON EL ISSET SE MUESTRA LA DESCRIPTION QUE ES OPCIONAL PARA LAS REGLAS DE NIVEL 2 -->
                                @isset($sugerencia->description)
                                    <div class="prose lg:prose-xl">
                                        {!!$sugerencia->description!!}
                                    </div>
                                @endisset
                            </a>
                        </div>
                    @endforeach

                </div>


                <!-- SUGERENCIA DE REGLAS DE NIVEL 3 SIMILARES (POSTS) -->
                <div class="bg-sky-300">
                    <strong class="text-red-500 my-5">Más reglas ortográficas de: "{{$sectionwordObject->name}}"</strong>
                    <br>
                    @foreach ($sugerenciasniveltres as $sugerencia)
                        <div class="mb-4">
                            <!-- EN LA HREF SE ENVIA EL SLUG DE LA CATEGORIA NIVEL 1 (CATEGORY) A LA QUE PERTENECE ESTA REGLA NIVEL 2 (SECTION)
                            EL SLUG DE LAS REGLAS NIVEL 2 (SECTIONS) SIMILARES Y EL SLUG DE LAS REGLAS DE NIVEL 3 (POST) SIMILARES -->
                            <a href="/estudiante/letters/{{$categorywordObject->slug}}/{{$sugerencia->section->slug}}/{{$sugerencia->slug}}">
                                <strong class="text-indigo-400">{{$sugerencia->name}}</strong>
                                <br>
                                <!-- CON EL ISSET SE MUESTRA LA DESCRIPTION QUE ES OPCIONAL PARA LAS REGLAS DE NIVEL 2 -->
                                @isset($sugerencia->description)
                                    <div class="prose lg:prose-xl">
                                        {!!$sugerencia->description!!}
                                    </div>
                                @endisset
                            </a>

                            
                        </div>
                    @endforeach
                </div>


                <!-- SUGERENCIAS DE REGLAS DE NIVEL 2 SIMILARES (SECTIONS) -->
                <div class="bg-orange-200">
                    <strong class="text-red-500 my-5">Más reglas ortográficas de: "{{$categorywordObject->name}}"</strong>
                    <br>
                    @foreach ($sugerenciasniveldos as $sugerencia)
                        <div class="mb-4">
                            <!-- EN LA HREF SE ENVIA EL SLUG DE LA CATEGORIA NIVEL 1 (CATEGORY) A LA QUE PERTENECE ESTA REGLA NIVEL 2 (SECTION)
                            Y EL SLUG DE LAS REGLAS NIVEL 2 (SECTIONS) SIMILARES -->
                            <a href="/estudiante/letters/{{$sugerencia->category->slug}}/{{$sugerencia->slug}}">
                                <strong class="text-indigo-400">{{$sugerencia->name}}</strong>
                                <br>
                                <!-- CON EL ISSET SE MUESTRA LA DESCRIPTION QUE ES OPCIONAL PARA LAS REGLAS DE NIVEL 2 -->
                                @isset($sugerencia->description)
                                    <div class="prose lg:prose-xl">
                                        {!!$sugerencia->description!!}
                                    </div>
                                @endisset
                            </a>

                            
                        </div>
                    @endforeach
                </div>


                 <!-- SUGERENCIA DE REGLAS NIVEL 1 SIMILARES (CATEGORIES) -->
                <div class="bg-amber-200">
                    <strong class="text-red-500 my-5">Más reglas ortográficas de: "{{$categorywordObject->type}}"</strong>
                    <br>
                    @foreach ($sugerenciasniveluno as $sugerencia)
                        <div class="mb-4">
                            <!-- EN LA HREF SE ENVIA LA SUGERENCIA AL METODO ESTUDIANTE.LETTERSLEVELONE CON EL OBJETO TIPO SUGERENCIA -->
                            <a href="{{route('estudiante.letterslevelone.show', $sugerencia)}}">
                                <strong class="text-lime-700">{{$sugerencia->name}}</strong>
                                <br>
                                <!-- CON EL ISSET SE MUESTRA LA DESCRIPTION QUE ES OPCIONAL PARA LAS REGLAS DE NIVEL 1 -->
                                @isset($sugerencia->description)
                                    <div class="prose lg:prose-m">
                                        {!!$sugerencia->description!!}
                                    </div>
                                @endisset
                            </a>
                        </div>
                    @endforeach
                </div>

            </aside>


    
    </div>
</x-app-layout>