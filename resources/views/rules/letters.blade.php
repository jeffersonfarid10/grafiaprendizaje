<x-app-layout>

    <!-- ///////////////////////////////////////////////////////////////NUEVA VISTA REGLAS ORTOGRAFICAS DE PALABRAS //////////////////////////////////////////////////-->


    <!-- VISTA PAGINA DE PALABRAS -->
    <!-- SE CREA UN DIV PADRE QUE VA A SER DE COLOR BLANCO -->
    <div class="bg-white">
        <!-- SE CREA UN DIV HIJO CON CLASS CONTAINER Y QUE DEBE TENER OBLIGATORIAMENTE UN PT-24 PORQUE SINO EL NAVBAR FIXED VA A TAPAR LA INFORMACION -->
        <div class="container mx-auto pt-24 rounded-xl p-12">
            <!-- TITULO CON DEGRADADO -->
            <h1 class="mb-1 text-3xl font-extrabold md:text-5xl lg:text-6xl text-center font-anton tracking-wide"><span class="text-red-700">Reglas ortográficas de palabras</span></h1>
        </div>


        <!-- DIV CON EL CONTENIDO DE LA PAGINA -->
        <div class="container mx-auto p-2">
            <!-- DIV QUE CONTIENE LA DESCRIPCION GENERAL DE LAS REGLAS ORTOGRAFICAS DE PALABRAS, AL FINAL SE PONE OVERFLOW-AUTO PARA QUE SI EL CONTENIDO
            EXCEDE EL DIV, ESTE NO SALGA DE AQUI -->
            <div class="m-10 pt-12 pr-12 pl-12 overflow-auto rounded-xl pb-1">
                <p class="text-sm text-justify md:text-xl font-sora">
                    Las palabras tienen un gran número de reglas o normativas para ser escritas correctamente. En el lenguaje español, especialmente durante la transición de la comunicación oral 
                    a la comunicación escrita, suelen generarse varias dudas al momento de diferenciar las letras correctas para escribir una palabra. Por ejemplo, con letras como la S, C, Z o el dígrafo
                    LL y la letra Y, las cuales bajo determinadas circunstancias suenan igual. Por tal motivo, la correcta escritura de palabras se basa en una serie de normas y recomendaciones las cuales 
                    hay que tomar en cuenta para escribir palabras correctamente.
                    
                </p>
                {{--
                <br>
                
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
            <!-- DIV QUE CONTIENE LA DESCRIPCION GENERAL DE LAS REGLAS ORTOGRAFICAS DE PALABRAS, AL FINAL SE PONE OVERFLOW-AUTO PARA QUE SI EL CONTENIDO
            EXCEDE EL DIV, ESTE NO SALGA DE AQUI -->
            <div class="m-10 mt-1 pb-12 px-12  overflow-auto rounded-xl pt-1">
                <p class="text-sm text-justify md:text-xl font-sora">
                    La correcta escritura de palabras se basa en dos elementos fundamentales: <strong class="text-red-500">las letras y los fonemas.</strong>
                </p>
                <br>
                <p class="text-sm text-justify md:text-xl font-sora">
                    Las <strong class="text-red-500">letras</strong> son representaciones escritas ortográficas indivisibles dentro del lenguaje escrito. La función principal de las letras es representar los fonemas de una 
                    lengua oral y transformarlos a su versión escrita. 
                </p>
                <br>
                <p class="text-sm text-justify md:text-xl font-sora">
                    Los <strong class="text-red-500">fonemas</strong> son sonidos mediante los cuales podemos distinguir una letra de otra o una palabra de otra. En esta aplicación los fonemas o sonidos 
                    se representan con los siguientes símbolos: <strong>/ /</strong> así que, ten en cuenta que, si ves estos símbolos <strong>//</strong> se hace referencia a un sonido de una letra.
                </p>
                <br>
                <p class="text-center font-sora font-bold text-2xl">En la siguiente imagen puedes observar las letras y los fonemas utilizados en el lenguaje español</p>
            </div>
        </div>

        <!-- DIV QUE CONTIENE UNA IMAGEN ACERCA DE LAS REGLAS ORTOGRAFICAS DE PALABRAS -->
        <div class="container mx-auto pt-5">
            <div class="w-full h-full lg:w-3/5 mx-auto">
                <img src="/imagenesapp/palabrasv2final.png" alt="" class="aspect-video object-cover object-center rounded-lg ">
            </div>
        </div>

        <!-- DIV QUE CONTIENE EL LISTADO DE REGLAS ORTOGRAFICAS CATEGORIA 1 DISPONIBLES -->
        <!-- SACADO DE https://tailblocks.cc 3 COMPONENTE DEL TIPO BLOG -->
        <div class="container mx-auto p-10">
            <p class="text-xl font-sora m-5 text-justify">Como habrás notado la imagen, en el lenguaje español: </p>

                <li class="text-xl font-sora m-5 text-justify">Existen letras mayúsculas y minúsculas</li>

                <li class="text-xl font-sora m-5 text-justify">Existen fonemas vocálicos y consonánticos</li>

            <p class="text-xl font-sora m-5 text-justify">Sin embargo, hay algunas curiosidades. Existen fonemas que pueden ser representados de forma escrita por letras diferentes o por dos letras.
                Asimismo, existen letras como la "H" que no tienen un sonido característico, o la "X" que en la mayoría de los casos, es la combinación del fonema o sonido /k/ con el sonido /s/.
                Por tal motivo, suelen generarse dudas para escribir correctamente las palabras que constituyen el lenguaje español, así como emplear correctamente las letras mayúsculas y minúsculas, o demás
                tópicos que son igual de importantes para escribir correctamente. 
            </p>
            <p class="text-xl font-sora m-5 text-justify">A continuación, tienes a tu disposición los contenidos principales disponibles acerca de la correcta escritura de palabras. Puedes hacer click en la categoría 
                de tu interés y mientras más investigues, tendrás a tu disposición más reglas ortográficas y podrás aprender cómo escribir correctamente las palabras que componen el lenguaje español. 
            </p>
            
            <h3 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton text-red-700 m-5 pt-7">Reglas ortográficas de palabras disponibles:</h3>
            
            <!-- REGLAS ORTOGRAFICAS DISPONIBLES -->
            <section class="text-gray-600 body-font overflow-hidden">
                <div class="container px-5 py-6 mx-auto">
                    {{--<div class="-my-8 divide-y-2 divide-red-500">--}}
                    <div class="grid grid-cols-1 divide-y divide-slate-800">

                        <!-- CON EL ISSET SE PREGUNTA SI SE ESTAN ENVIANDO A LA VISTA LAS REGLAS DE NIVEL 1 (CATEGORIES DE LETRAS) -->
                        @isset($categories)
                            @foreach ($categories as $categoryword)
                                <a href="{{route('estudiante.letterslevelone.show', $categoryword)}}">
                                    <div class="py-8 flex flex-wrap md:flex-nowrap">
                                        <div class="md:flex-grow">
                                            <h2 class="text-2xl font-bold text-red-500 title-font font-sora mb-2">{{$categoryword->name}}</h2>
                                            <!-- CON EL ISSET SE MUESTRA LA DESCRIPCION QUE ES OBLIGATORIA PARA LAS REGLAS DE NIVEL 1 -->
                                            @isset($categoryword->description)
                                                <!-- PARA MOSTRAR EL TEXTO DE CK EDITOR CON LOS ESTILOS SE CORRE EL SIGUIENTE COMANDO -->
                                                    {{-- npm install -D @tailwindcss/typography --}}
                                                <!-- Y SE DEBE CREAR UN DIV CON LA CLASE:  class="prose lg:prose-xl" -->
                                                <div class="leading-relaxed text-justify prose lg:prose-xl">{!!$categoryword->description !!}</div>
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



    <!-- ////////////////////////////////////////////////////////////////FIN NUEVA VISTA REGLAS ORTOGRAFICAS DE PALABRAS/////////////////////////////////////////////// -->

    
</x-app-layout>