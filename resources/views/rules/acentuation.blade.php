<x-app-layout>
    
    
    <!-- //////////////////////////////////////////////NUEVA VISTA REGLAS ORTOGRAFICAS DE ACENTUACION //////////////////////////////////////-->

    <!-- VISTA PAGINA DE ACENTUACION -->
    <!-- SE CREA UN DIV PADRE QUE VA A SER DE COLOR BLANCO -->
    <div class="bg-white">
        <!-- SE CREA UN DIV HIJO CON CLASS CONTAINER Y QUE DEBE TENER OBLIGATORIAMENTE UN PT-24 PORQUE SINO EL NAVBAR FIXED VA A TAPAR LA INFORMACION -->
        <div class="container mx-auto pt-24 rounded-xl p-12">
            <!-- TITULO CON DEGRADADO -->
            <h1 class="mb-1 text-3xl font-extrabold md:text-5xl lg:text-6xl text-center font-anton tracking-wide"><span class="text-blue-700">Reglas ortográficas de acentuación</span></h1>
        </div>

        <!-- DIV CON EL CONTENIDO DE LA PAGINA -->
        <div class="container mx-auto p-2">
            <!-- DIV QUE CONTIENE LA DESCRIPCION GENERAL DE LAS REGLAS ORTOGRAFICAS DE PALABRAS, AL FINAL SE PONE OVERFLOW-AUTO PARA QUE SI EL CONTENIDO
            EXCEDE EL DIV, ESTE NO SALGA DE AQUI -->
            <div class="m-10 p-12 overflow-auto rounded-xl pb-1">
                <p class="text-sm text-justify md:text-xl font-sora">
                    Las reglas de acentuación se fundamentan en la correcta colocación de la tilde. La tilde se define 
                    como un signo en forma de raya que siempre debe descender de derecha a izquierda, el cual, ubicado sobre 
                    una vocal, indica que la sílaba a la que pertenece esa vocal posee acento y se diferencia de las demás sílabas de la palabra que no poseen acento. 
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
        <div class="container mx-auto p-2">
            <!-- DIV QUE CONTIENE LA DESCRIPCION GENERAL DE LAS REGLAS ORTOGRAFICAS DE ACENTUACION, AL FINAL SE PONE OVERFLOW-AUTO PARA QUE SI EL CONTENIDO
            EXCEDE EL DIV, ESTE NO SALGA DE AQUI -->
            <div class="m-10 mt-1 p-12 pt-1 overflow-auto rounded-xl">
                <p class="text-sm text-justify md:text-xl font-sora">
                    En el idioma español, la tilde tiene dos funciones: <strong class="text-red-500">la función prosódica y la función diacrítica.</strong>
                </p>
                <br>
                <p class="text-sm text-justify md:text-xl font-sora">
                    <strong class="text-red-500">Función prosódica:</strong> donde la función de la tilde es señalar la sílaba de la palabra que posee acento prosódico, es decir tiene acento.
                </p>
                <br>
                <p class="text-sm text-justify md:text-xl font-sora">
                    <strong class="text-red-500">Función diacrítica:</strong> cuando la tilde permite diferenciar palabras tónicas de otras palabras que contienen las mismas letras, pero son átonas, es decir, no tienen acento y tienen 
                    diferente significado.
                </p>
                <br>
                <p class="text-center font-sora font-bold text-2xl">En la siguiente imagen puedes observar ejemplos de la función prosódica y función diacrítica.</p>
            </div>
        </div>

        <!-- DIV QUE CONTIENE UNA IMAGEN ACERCA DE LAS REGLAS ORTOGRAFICAS DE PALABRAS -->
        <div class="container mx-auto pt-5">
            <div class="w-full h-full lg:w-3/5 mx-auto">
                <img src="/imagenesapp/acentuacion.png" alt="" class="aspect-video object-cover object-center rounded-lg ">
            </div>
        </div>

        <div class="container mx-auto p-2 my-3 overflow-auto lg:prose-2xl text-justify bg-amber-200 rounded-sm">
            <h4 class="font-bold">Bibliografía/Referencias</h4>
            <p>RAE (Real Academia Española) y ASALE (Asociación de Academias de la Lengua Española). (2012). Ortografía básica de la lengua española. Espasa.</p>
            <p>"Acento ortográfico". Autor: Natalia Ribas. De: Argentina. Para: Concepto.de. Disponible en: <a href="https://www.ejemplos.co/100-ejemplos-de-acento-ortografico/">https://www.ejemplos.co/100-ejemplos-de-acento-ortografico/</a> . Última edición: 6 de junio de 2022. Consultado: 24 de octubre de 2022</p>
            <p>Fuente: <a href="https://www.ejemplos.co/100-ejemplos-de-acento-ortografico/#ixzz80HnKQUVQ">https://www.ejemplos.co/100-ejemplos-de-acento-ortografico/#ixzz80HnKQUVQ</a></p>
        </div>

        <!-- DIV QUE CONTIENE EL LISTADO DE REGLAS ORTOGRAFICAS CATEGORIA 1 DISPONIBLES -->
        <!-- SACADO DE https://tailblocks.cc 3 COMPONENTE DEL TIPO BLOG -->
        <div class="container mx-auto p-10">
            <p class="text-xl font-sora m-5 text-justify">El uso de la tilde, según las funciones detalladas anteriormente, está regido por las siguientes reglas ortográficas que son de aplicación obligatoria. 
                Puedes hacer click en la categoría de tu interés y, mientras más investigues, tendrás a tu disposición más reglas ortográficas y podrás aprender a cómo utilizar correctamente la tilde.
            </p>
            <h3 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton text-blue-700 m-5 pt-7">Reglas ortográficas de acentuación disponibles:</h3>
            
            <!-- REGLAS ORTOGRAFICAS DISPONIBLES -->
            <section class="text-gray-600 body-font overflow-hidden">
                <div class="container px-5 py-6 mx-auto">
                    {{--<div class="-my-8 divide-y-2 divide-red-500">--}}
                    <div class="grid grid-cols-1 divide-y divide-slate-800">

                        <!-- CON EL ISSET SE PREGUNTA SI SE ESTAN ENVIANDO A LA VISTA LAS REGLAS DE NIVEL 1 (CATEGORIES DE LETRAS) -->
                        @isset($categories)
                            @foreach ($categories as $categoryacentuation)
                                <a href="{{route('estudiante.acentuationlevelone.show', $categoryacentuation)}}">
                                    <div class="py-8 flex flex-wrap md:flex-nowrap">
                                        <div class="md:flex-grow">
                                            <h2 class="text-2xl font-bold text-blue-500 title-font font-sora mb-2">{{$categoryacentuation->name}}</h2>
                                            <!-- CON EL ISSET SE MUESTRA LA DESCRIPCION QUE ES OBLIGATORIA PARA LAS REGLAS DE NIVEL 1 -->
                                            @isset($categoryacentuation->description)
                                                <!-- PARA MOSTRAR EL TEXTO DE CK EDITOR CON LOS ESTILOS SE CORRE EL SIGUIENTE COMANDO -->
                                                    {{-- npm install -D @tailwindcss/typography --}}
                                                <!-- Y SE DEBE CREAR UN DIV CON LA CLASE:  class="prose lg:prose-xl" -->
                                                <div class="leading-relaxed text-justify prose lg:prose-xl">{!!$categoryacentuation->description !!}</div>
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


    <!-- ///////////////////////////////////////////////////FIN NUEVA VISTA REGLAS ORTOGRAFICAS DE ACENTUACION//////////////////////////////////-->


    
</x-app-layout>