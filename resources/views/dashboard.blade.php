<x-app-layout>

    <!-- ANTIGUA VISTA DASHBOARD -->
{{--<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
--}}               {{--<x-jet-welcome />--}}
{{--            </div>
        </div>
    </div>
    hola dashboard
--}}

    <!-- //////////////////////////////////////////////////////////IMPORTANTE NUEVO DASHBOARD///////////////////////////////// -->


    <!-- VISTA DE PAGINA DASHBOARD -->
    <!-- SE CREA UN DIV PADRE QUE VA A SER DE COLOR BLANCO -->
    <div class="bg-white">
        <!-- SE CREA UN DIV HIJO CON CLASS CONTAINER Y QUE DEBE TENER OBLIGATORIAMENTE UN PT-24 PORQUE SINO EL NAVBAR FIXED VA A TAPAR LA INFORMACION -->
        <div class="container mx-auto pt-24 bg-sky-200 rounded-xl p-12">
            <!-- TITULO CON DEGRADADO -->
            <h1 class="mb-4 text-3xl font-extrabold md:text-5xl lg:text-6xl text-center font-anton tracking-wide border-white border-8 rounded"><span class="text-transparent bg-clip-text bg-gradient-to-r to-purple-700 from-blue-800">Bienvenido a GrafiAprendizaje</span></h1>
        </div>



        <!-- GRID QUE CONTIENE 2 COLUMNAS 1 PARA EL VIDEO Y OTRA PARA UNA IMAGEN CON UN LOGOTIPO -->
        {{--<div class="container mx-auto grid grid-cols-1 lg:grid-cols-2 p-10">

            <!-- VIDEO -->
            <div class= "col-span-1 aspect-video p-10">
                <video controls>
                    <source src="/videos/videofondo.mp4" type="video/mp4">
                </video>
            </div>
            <!-- IMAGEN CON FRASE DE ORTOGRAFIA: MEJORA TUS CONOCIMIENTOS DE ORTOGRAFIA CON SPELLGRAPHY -->
            <div>
                <img src="imagenesapp/imagenuno.jpg" alt="" class="object-cover object-center w-full h-full rounded-lg">
            </div>
        </div>--}}

        <!-- NUEVO GRID QUE CONTIENE SOLO LA IMAGEN -->
        {{--<div class="container mx-auto p-10 lg:pl-96">
            <!-- IMAGEN CON FRASE DE ORTOGRAFIA: MEJORA TUS CONOCIMIENTOS DE ORTOGRAFIA CON SPELLGRAPHY -->
            <div>
                <img src="imagenesapp/imagenuno.jpg" alt="" class="object-cover object-center w-full h-full lg:w-3/5 lg:h-5/5 rounded-lg">
            </div>
        </div>--}}

        <!-- CONTENEDOR QUE VA A CONTENER LA DESCRIPCION DE LA APLICACION -->
        <div class="container mx-auto p-10 ">
            <h3 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton text-slate-700">Sobre esta aplicación:</h3>

            <!-- DIV QUE CONTIENE LA DESCRIPCION DE LA PAGINA, AL FINAL SE PONE OVERFLOW-AUTO PARA QUE SI EL CONTENIDO
            EXCEDE EL DIV, ESTE NO SALGA DE AQUI -->
            <div class="bg-slate-400 m-10 p-12 overflow-auto rounded-xl">
                <p class="text-sm text-justify md:text-xl font-sora">
                    GrafiAprendizaje es una aplicación web orientada a promover el uso correcto de las reglas ortográficas, las cuales son
                    parte fundamental para la correcta escritura de textos en el lenguaje español. A través de esta aplicación tendrás
                    disponible información sobre reglas ortográficas para la correcta escritura de palabras, la correcta colocación de los signos de acentuación 
                    y signos de puntuación; así como actividades que te harán reforzar tus conocimientos o aprender nuevos contenidos sobre la ortografía. 
                    
                </p>
                <br>
                    <p class="text-center text-2xl font-sans font-bold">GrafiAprendizaje se divide en varias secciones que se detallan a continuación.</p>
            </div>
        </div>

        <!-- CONTENEDOR CON LAS SECCIONES A DE EVALUACIONES A LAS QUE PUEDE INGRESAR -->
        <div class="container mx-auto p-10">
            <h3 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton text-slate-700 m-5">Sección de actividades:</h3>
            <p class="text-xl font-sora m-5">En esta sección, tienes a tu disposición las actividades que puedes realizar en GrafiAprendizaje. Puedes ingresar a la página de tu interés desde
                esta sección o desde el menú de navegación que se encuentra en la parte superior.
            </p>
            <!-- CONTENEDOR CON 2 CARD 1 PARA LA EVALUACION DE DIAGNOSTICO Y UNA PARA LA EVALUACION FINAL -->
            <div class="container mx-auto py-16 bg-gray-800 rounded-xl w-full">
                <div class="mx-auto grid gap-6 md:w-3/4 lg:w-full lg:grid-cols-3">
                    <!-- CARD UNO -->
                    <div class="bg-white rounded-2xl shadow-xl px-8 py-12 sm:px-12 lg:px-8 m-10 transform  hover:scale-125 transition duration-300">
                        <div class="mb-12 space-y-4">
                            <h3 class="text-2xl font-semibold text-blue-600 font-anton">Evaluación de diagnóstico</h3>
                            <p class="mb-6 text-justify">Al hacer click en el botón ingresar, te dirigirás a la página de tu evaluación de diagnóstico asignada, donde deberás responder algunas preguntas, 
                                para desbloquear las siguientes secciones de la aplicación. ¡Comencemos! </p>
                            <a href="{{route('estudiante.diagnostico')}}">
                                <!-- BOTON DE INGRESO -->
                                <button type="button" class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                                    Ingresar
                                </button>
                            </a>
                            
                        </div>
                    </div>
                    <!-- CARD DOS--> 
                    <div class="bg-white rounded-2xl shadow-xl px-8 py-12 sm:px-12 lg:px-8 m-10 transform  hover:scale-125 transition duration-300">
                        <div class="mb-12 space-y-4">
                            <h3 class="text-2xl font-semibold text-rose-500 font-anton">Actividades de práctica</pre></h3>
                            <p class="mb-6 text-justify">Al hacer click en el botón ingresar, tendrás a tu disposición varias actividades de práctica. ¡Vamos por ello!</p>
                            <a href="{{route('estudiante.practica')}}">
                                <!-- BOTON DE INGRESO -->
                                <button type="button" class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                                    Ingresar
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- CARD TRES--> 
                    <div class="bg-white rounded-2xl shadow-xl px-8 py-12 sm:px-12 lg:px-8 m-10 transform  hover:scale-125 transition duration-300">
                        <div class="mb-12 space-y-4">
                            <h3 class="text-2xl font-semibold text-purple-700 font-anton">Evaluación final</h3>
                            <p class="mb-6 text-justify">Una vez que hayas culminado con la evaluación de diágnostico y las actividades de práctica, estás listo para realizar la evaluación final de la aplicación web. ¡Empecemos!</p>
                            <a href="{{route('estudiante.final')}}">
                                <!-- BOTON DE INGRESO -->
                                <button type="button" class="border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                                    Ingresar
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- CONTENEDOR CON SECCION DE REGLAS ORTOGRAFICAS -->
        <div class="container mx-auto p-10">
            <h3 class="text-2xl sm:text-3xl md:text-4xl text-left font-anton text-slate-700 m-5">Sección de reglas ortográficas:</h3>
            <p class="text-xl font-sora m-5">En esta sección tienes a tu disposición una gran cantidad de reglas ortográficas divididas en tres categorías: palabras, acentuación y puntuación. Puedes ingresar a la categoría 
                de tu interés desde esta sección o desde el menú de navegación que se encuentra en la parte superior.
            </p>
            <!-- CONTENEDOR CON 3 CARD 1 PARA CADA TIPO DE REGLA ORTOGRAFICA-->
            <div class="container mx-auto py-16 bg-cyan-500 rounded-xl w-full">
                <div class="mx-auto grid gap-6 md:w-3/4 lg:w-full lg:grid-cols-3">
                    <!-- CARD UNO -->
                    <div class="bg-white rounded-2xl shadow-xl px-8 py-12 sm:px-12 lg:px-8 m-10 transform  hover:scale-125 transition duration-300">
                        <div class="mb-12 space-y-4">
                            <h3 class="text-2xl font-semibold text-red-700 font-anton">Reglas ortográficas de palabras</h3>
                            <p class="mb-6 font-sora text-justify">En esta categoría podrás encontrar las reglas ortográficas destinadas a la correcta escritura de palabras.</p>
                            <a href="{{route('estudiante.letterslevelone')}}">
                                <!-- BOTON DE INGRESO -->
                                <button type="button" class="border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline">
                                    Acceder
                                </button>
                            </a>
                            
                        </div>
                    </div>
                    <!-- CARD DOS-->
                    <div class="bg-white rounded-2xl shadow-xl px-8 py-12 sm:px-12 lg:px-8 m-10 transform  hover:scale-125 transition duration-300">
                        <div class="mb-12 space-y-4">
                            <h3 class="text-2xl font-semibold text-blue-700 font-anton">Reglas ortográficas de acentuación</h3>
                            <p class="mb-6 font-sora text-justify">En esta categoría podrás encontrar las reglas ortográficas correspondientes al uso correcto de la tilde.</p>
                            <a href="{{route('estudiante.acentuationlevelone')}}">
                                <!-- BOTON DE INGRESO -->
                                <button type="button" class="border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline">
                                    Acceder
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- CARD TRES -->
                    <!-- CARD DOS-->
                    <div class="bg-white rounded-2xl shadow-xl px-8 py-12 sm:px-12 lg:px-8 m-10 transform  hover:scale-125 transition duration-300">
                        <div class="mb-12 space-y-4">
                            <h3 class="text-2xl font-semibold text-green-700 font-anton">Reglas ortográficas de puntuación</h3>
                            <p class="mb-6 font-sora text-justify">En esta categoría podrás encontrar las reglas ortográficas que rigen el uso correcto de los signos de puntuación en un texto.</p>
                            <a href="{{route('estudiante.punctuationlevelone')}}">
                                <!-- BOTON DE INGRESO -->
                                <button type="button" class="border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline">
                                    Acceder
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- ////////////////////////////////////////////////////////////////////FIN NUEVO DASHBOARD///////////////////////////////////// -->
</x-app-layout>
