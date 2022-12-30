<x-app-layout>

    <!-- ///////////////////////////////////////////NUEVA VISTA REGLAS ORTOGRAFICAS DE PUNTUACION /////////////////////////////////////////-->


    <!-- VISTA PAGINA DE PUNTUACION -->
    <!-- SE CREA UN DIV PADRE QUE VA A SER DE COLOR BLANCO -->
    <div class="bg-white">
        <!-- SE CREA UN DIV HIJO CON CLASS CONTAINER Y QUE DEBE TENER OBLIGATORIAMENTE UN PT-24 PORQUE SINO EL NAVBAR FIXED VA A TAPAR LA INFORMACION -->
        <div class="container mx-auto pt-24 rounded-xl p-12">
            <!-- TITULO CON DEGRADADO -->
            <h1 class="mb-1 text-3xl font-extrabold md:text-5xl lg:text-6xl text-center font-anton tracking-wide"><span class="text-green-700">Reglas ortográficas de puntuación</span></h1>
        </div>


        <!-- DIV CON EL CONTENIDO DE LA PAGINA -->
        <div class="container mx-auto p-2">
            <!-- DIV QUE CONTIENE LA DESCRIPCION GENERAL DE LAS REGLAS ORTOGRAFICAS DE PALABRAS, AL FINAL SE PONE OVERFLOW-AUTO PARA QUE SI EL CONTENIDO
            EXCEDE EL DIV, ESTE NO SALGA DE AQUI -->
            <div class="m-10 p-12 overflow-auto rounded-xl pb-1">
                <p class="text-sm text-justify md:text-xl font-sora">
                    Los signos de puntuación son marcas gráficas que se utilizan durante la escritura y permiten una mejor interpretación y comprensión de un texto escrito. 
                    Su propósito radica en organizar textos y evitar ambigüedades. Por tal motivo, se han establecido reglas y recomendaciones que se deben tomar en cuenta para utilizar correctamente 
                    los signos de puntuación. 
                    
                </p>
                {{--<br>
                <p class="text-center font-sora font-bold text-2xl">A continuación tienes disponible un vídeo donde se explica más a detalle esta sección y la forma en que puedes acceder a las reglas ortográficas de tu interés.</p>
                --}}
            </div>
        </div>

        <!-- DIV CON UN GRID QUE TIENE EL VIDEO PRINCIPAL -->
        {{--<div class="container mx-auto grid grid-cols-1 pt-5">
            <!-- VIDEO -->
            <div class= "col-span-1 aspect-video p-10 mx-auto">
                <video controls>
                    <source src="/videos/videofondo.mp4" type="video/mp4">
                </video>
            </div>
        </div>--}}

        <!-- DIV CON EL CONTENIDO DE LA PAGINA -->
        <div class="container mx-auto p-2 pt-1">
            <!-- DIV QUE CONTIENE LA DESCRIPCION GENERAL DE LAS REGLAS ORTOGRAFICAS DE PALABRAS, AL FINAL SE PONE OVERFLOW-AUTO PARA QUE SI EL CONTENIDO
            EXCEDE EL DIV, ESTE NO SALGA DE AQUI -->
            <div class="m-10 mt-1 p-12 overflow-auto rounded-xl pt-1">
                <p class="text-sm text-justify md:text-xl font-sora">
                    Los signos de puntuación se dividen en dos categorías: <strong class="text-red-500">signos simples y dobles.</strong>
                </p>
                <br>
                <p class="text-sm text-justify md:text-xl font-sora">
                    <strong class="text-red-500">Signos simples: </strong> punto, coma, punto y coma, dos puntos, puntos suspensivos. 
                </p>
                <br>
                <p class="text-sm text-justify md:text-xl font-sora">
                    <strong class="text-red-500">Signos dobles: </strong> paréntesis, corchetes, comillas, raya, signos de interrogación y exclamación.
                </p>
                <br>
                <p class="text-sm text-justify md:text-xl font-sora">
                    Los signos de puntuación se dividen en dos categorías: <strong class="text-red-500">signos simples y dobles.</strong>
                </p>
                <br>
                <p class="text-sm text-justify md:text-xl font-sora">
                    <strong class="text-red-500">Signos simples: </strong> punto, coma, punto y coma, dos puntos, puntos suspensivos. 
                </p>
                <br>
                <p class="text-sm text-justify md:text-xl font-sora">
                    Los signos simples deben escribirse unidos al elemento que los precede y separados por un espacio del elemento que está a continuación de ellos. Mientras que los signos dobles 
                    se escriben siempre pegados al inicio y al final del elemento o elementos que contienen.
                </p>
                <br>
                <p class="text-center font-sora font-bold text-2xl">En la siguiente imagen puedes observar más detalles sobre los signos simples y dobles</p>
            </div>
        </div>

        <!-- DIV QUE CONTIENE UNA IMAGEN ACERCA DE LAS REGLAS ORTOGRAFICAS DE PALABRAS -->
        <div class="container mx-auto pt-5">
            <div class="w-full h-full lg:w-3/5 mx-auto">
                <img src="/imagenesapp/signospuntuacionfinal.png" alt="" class="aspect-video object-cover object-center rounded-lg ">
            </div>
        </div>

        <!-- DIV QUE CONTIENE EL LISTADO DE REGLAS ORTOGRAFICAS CATEGORIA 1 DISPONIBLES -->
        <!-- SACADO DE https://tailblocks.cc 3 COMPONENTE DEL TIPO BLOG -->
        <div class="container mx-auto p-10">
            <p class="text-xl font-sora m-5 text-justify">Para cada signo simple o doble existen reglas para emplear correctamente dichos signos ortográficos. Al hacer click en cualquiera de las siguientes 
                categorías puedes acceder a las reglas disponibles de cada signo de puntuación. Mientras más investigues, tendrás a tu disposición más reglas ortográficas y aprenderás a como colocar correctamente 
                los signos de puntuación. 
            </p>
            <h3 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton text-green-700 m-5 pt-7">Reglas ortográficas de puntuación disponibles:</h3>
            
            <!-- REGLAS ORTOGRAFICAS DISPONIBLES -->
            <section class="text-gray-600 body-font overflow-hidden">
                <div class="container px-5 py-6 mx-auto">
                    {{--<div class="-my-8 divide-y-2 divide-red-500">--}}
                    <div class="grid grid-cols-1 divide-y divide-slate-800">

                        <!-- CON EL ISSET SE PREGUNTA SI SE ESTAN ENVIANDO A LA VISTA LAS REGLAS DE NIVEL 1 (CATEGORIES DE LETRAS) -->
                        @isset($categories)
                            @foreach ($categories as $categorypunctuation)
                                <a href="{{route('estudiante.punctuationlevelone.show', $categorypunctuation)}}">
                                    <div class="py-8 flex flex-wrap md:flex-nowrap">
                                        <div class="md:flex-grow">
                                            <h2 class="text-2xl font-bold text-green-500 title-font font-sora mb-2">{{$categorypunctuation->name}}</h2>
                                            <!-- CON EL ISSET SE MUESTRA LA DESCRIPCION QUE ES OBLIGATORIA PARA LAS REGLAS DE NIVEL 1 -->
                                            @isset($categorypunctuation->description)
                                                <!-- PARA MOSTRAR EL TEXTO DE CK EDITOR CON LOS ESTILOS SE CORRE EL SIGUIENTE COMANDO -->
                                                    {{-- npm install -D @tailwindcss/typography --}}
                                                <!-- Y SE DEBE CREAR UN DIV CON LA CLASE:  class="prose lg:prose-xl" -->
                                                <div class="leading-relaxed text-justify prose lg:prose-xl">{!!$categorypunctuation->description !!}</div>
                                            @endisset
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endisset

                    </div>
                </div>
              </section>

        </div>
        

        
    </div>



    <!-- //////////////////////////////////////////////FIN NUEVA VISTA REGLAS ORTOGRAFICAS DE PUNTUACION /////////////////////////////////////////// -->

    

</x-app-layout>