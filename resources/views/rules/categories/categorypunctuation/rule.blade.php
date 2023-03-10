<x-app-layout>


    <!-- NUEVA VISTA REGLAS ORTOGRAFICAS DE PUNTUACION NIVEL 1 CATEGORIES -->

    <!-- SE CREA UN DIV PADRE QUE VA A SER DE COLOR BLANCO -->
    <div class="bg-white">

        <!-- SE CREA UN DIV HIJO CON CLASS CONTAINER QUE DEBE TENER OBLIGATORIAMENTE UN PT-24  PORQUE SINO EL NAVBAR FIXED VA A OCULTAR LA INFORMACION-->
        <div class="container mx-auto pt-24 p-12">
            <!-- TITULO -->
            <h1 class="mb-4 text-3xl font-extrabold md:text-5xl lg:text-6xl text-center font-anton tracking-wide"><span class="text-green-700">{{$categorypunctuation->name}}</span></h1>
        </div>
        
            <!-- SE CREA UN GRID CON LA NAVEGACION DE REGRESAR A  SE DEBE AGREGAR LA CLASE INLINE-BLOCK A CADA ETIQUETA A, PORQUE SINO NO VA A APARECER LAS REGLAS EN LA MISMA LINEA-->
            <div class="container">
                Selecciona alguna categoría anterior para regresar a ella: 
                <br>
                
                <div>
                    <!-- REGLA PRINCIPAL -->
                    <a href="/estudiante/punctuation" class="inline-block">
                        <p class="leading-relaxed font-sora font-semibold text-gray-800">{{$categorypunctuation->type}}</p>
                    </a>
                </div>
            </div>


            <!-- SE CREA UN GRID CON 3 COLUMNAS, 2 COLUMNAS PARA EL CONTENIDO DE LA REGLA ORTOGRAFICA Y UNA COLUMNA PARA LAS REGLAS RELACIONADAS -->
            <div class="grid md:grid-cols-3 gap-6">
                <!-- DIV HIJO QUE CONTIENE LA INFORMACION DE LA REGLA ORTOGRAFICA QUE OCUPA 1 COLUMNA POR DEFECTO Y DOS COLUMAS PANTALLAS MD PARA ARRIBA -->
                <div class="col-span-1 md:col-span-2">
                    
                    <!-- IMAGEN -->
                    <!-- COMPROBAR SI EL CAMPO IMAGE TIENE CONTENIDO, SI TIENE CONTENIDO MUESTRA EL DIV, PERO SI EL CAMPO IMAGE ES NULL NO SE MUESTRA NADA -->
                    @isset($categorypunctuation->image)
                        <div class="container mx-auto p-10">
                            <div class="w-4/5 mx-auto">
                                <!-- IMPORTANTE PONER LA LINEA DIAGONAL AL INICIO DE LA RUTA EN LAS IMAGENES DE LAS REGLAS DE NIVEL UNO PARA ADELANTE PORQUE SINO NO VA A APARECER LA IMAGEN -->
                                <img id="image" name="image" src="/storage/{{$categorypunctuation->image}}" alt="" class="w-full h-full object-cover object-center rounded-lg ">
                            </div>
                        </div> 
                    @endisset

                    <!-- GLOSARIO DE TERMINOS -->
                    <!-- COMPROBAR SI LA REGLA NIVEL 1 (CATEGORIES) CONTIENE WORDS, SI ES ASI MUESTRA EL DIV, CASO CONTRARIO NO -->
                    @if (count($categorypunctuation->words) > 0)
                        <div class="container mx-auto p-10 bg-amber-200 rounded-xl mt-10">
                            <!-- DIV QUE CONTIENE TODOS LOS TERMINOS DISPONIBLES PARA ESTA REGLA, AL FINAL SE PONE OVERFLOW-AUTO PARA QUE NO SE DESBORDE EL CONTENIDO DEL CONTAINER -->
                            <h3 class="font-anton text-red-400 pb-5 tracking-wide">Términos que pueden ser de ayuda:</h3>
                            <div class="overflow-auto">

                                <!-- RECORRER LA COLECCION DE WORDS -->
                                @foreach ($categorypunctuation->words as $word)
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
                            {!!$categorypunctuation->body!!}
                        </div>

                        <!-- BIBLIOGRAFIA -->
                        <h4><strong>Bibliografía:</strong></h4>
                        <p>RAE (Real Academia Española) y ASALE (Asociación de Academias de la Lengua Española). (2012). Ortografía básica de la lengua española. Espasa.</p>

                    </div>


                    <!-- COMPROBAR SI EL CAMPO EXAMPLE TIENE CONTENIDO, SI TIENE CONTENIDO SE MUESTRA EL CONTENIDO, CASO CONTRARIO NO SE MUESTRA NADA -->
                    <!-- CAMPO EXAMPLE -->
                    @isset($categorypunctuation->example)
                        <div class="container mx-auto p-10">
                            <!-- PARA MOSTRAR EL TEXTO DE CK EDITOR CON LOS ESTILOS SE CORRE EL SIGUIENTE COMANDO -->
                            {{-- npm install -D @tailwindcss/typography --}}
                            <!-- Y SE DEBE CREAR UN DIV CON LA CLASE:  class="prose lg:prose-xl" -->
                            <div class="p-4 ml-5 md:ml-10 lg:ml-20 overflow-auto prose lg:prose-2xl text-justify">
                                {!!$categorypunctuation->example!!}
                            </div>
                        </div>
                    @endisset


                    <!-- CAMPO EXCEPTION -->    
                    @isset($categorypunctuation->exception)
                        <div class="container mx-auto p-10">
                            <!-- PARA MOSTRAR EL TEXTO DE CK EDITOR CON LOS ESTILOS SE CORRE EL SIGUIENTE COMANDO -->
                            {{-- npm install -D @tailwindcss/typography --}}
                            <!-- Y SE DEBE CREAR UN DIV CON LA CLASE:  class="prose lg:prose-xl" -->
                            <div class="p-4 ml-5 md:ml-10 lg:ml-20 overflow-auto prose lg:prose-2xl text-justify">
                                {!!$categorypunctuation->exception!!}
                            </div>
                        </div> 
                    @endisset


                    <!-- REGLAS DE NIVEL 2 ASOCIADAS -->
                    <!-- COMPROBAR SI TIENE REGLAS DE NIVEL 2 (SECTIONS ASOCIADAS) -->
                    <!-- SI TIENE REGLAS DE NIVEL 2 SECTIONS ENTONCES QUE SE MUESTREN -->
                    @if(count($categorypunctuation->sections) > 0)
                        <div class="container mx-auto p-10 bg-rose-200 rounded-2xl">
                            <h3 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton m-5">Reglas ortográficas asociadas</h3>
                            <p class="text-xl font-sora m-5 font-semibold">Haz click en la regla ortográfica de tu interés para acceder a información más detallada.</p>

                                <div class="container px-5 py-4 mx-auto">
                                    <div class="grid grid-cols-1 divide-y divide-slate-800">
                                        <!-- SE RECORRE LA COLECCION DE REGLAS ASOCIADAS -->
                                        @foreach ($categorypunctuation->sections as $sectionpunctuation)
                                                <!-- REGLAS ORTOGRAFICAS DISPONIBLES -->
    
                                                    <!-- EN LA RUTA SE ENVIA EL SLUG DE LA REGLA NIVEL 1 (CATEGORY) Y EL SLUG DE LA REGLA NIVEL 2 (SECTIONS) -->
                                                    {{--<a href="/estudiante/letters/{{$categoryword->id}}/{{$sectionword->id}}">--}}
                                                    <a href="/estudiante/punctuation/{{$categorypunctuation->slug}}/{{$sectionpunctuation->slug}}">
                                                        <div class="py-8 flex flex-wrap md:flex-nowrap">
                                                            <div class="md:flex-grow">
                                                                <h2 class="text-2xl font-bold text-red-500 title-font font-sora mb-2">{{$sectionpunctuation->name}}</h2>
                                                                <!-- CON EL ISSET SE MUESTRA LA DESCRIPTION QUE ES OPCION PARA LAS REGLAS DE NIVEL 2 -->
                                                                @isset($sectionpunctuation->description)
                                                                    <p>{!!$sectionpunctuation->description!!}</p>
                                                                @endisset
                                                            </div>
                                                        </div>
                                                    </a>
                                        @endforeach
                                    </div>
                                </div>
                        </div>
                    @endif
                    

                </div>

                <!-- TERCERA COLUMNA DONDE VAN LAS SUGERENCIAS DE REGLAS ORTOGRAFICAS -->
                <div class="col-span-1">
                    <!-- CONTENEDOR QUE OCUPA TODO EL LARGO DE LA COLUMNA Y DEL ANCHO -->
                    <div class="bg-slate-900 h-full rounded-3xl px-5 py-10">
                        
                        <!-- REGLAS NIVEL 1 SIMILARES -->
                        @if (count($sugerenciasniveluno) > 0)
                            <div class="bg-blue-700 rounded-xl mb-4">
                                <h2 class="pl-3 pt-3 text-white font-semibold font-sora">Más reglas ortográficas de: " {{$categorypunctuation->type}} "</h2>
                                <div class="p-3 grid grid-cols-1 divide-y divide-yellow-400">

                                    <!-- SE RECORREN LAS REGLAS SIMILARES -->
                                    @foreach ($sugerenciasniveluno as $sugerencia)

                                        <a href="{{route('estudiante.punctuationlevelone.show', $sugerencia)}}">
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

                        @endif 
                        
                    </div>
                </div>
            </div>



    </div>


    <!-- //////////////////////////////////////////////FINAL NUEVA VISTA REGLAS ORTOGRAFICAS DE PUNTUACION NIVEL 1 CATEGORIES//////////////////////////////////////// -->



    
</x-app-layout>