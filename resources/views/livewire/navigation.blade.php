  <nav class=" bg-sky-700 fixed w-full z-10 p-4" x-data="{ open: false}">

    <!-- IMPORTANTE NUEVO NAVBAR  -->

    <!-- NAVBAR ORIGINAL -->
    {{--<div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">--}}
    <div class="mx-auto w-full px-2 sm:px-1 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">

        <!-- DIV DE MENU MOVIL -->
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button-->
          <button x-on:click="open = true" type="button" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <!--
              Icon when menu is closed.
  
              Heroicon name: outline/bars-3
  
              Menu open: "hidden", Menu closed: "block"
            -->
            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <!--
              Icon when menu is open.
  
              Heroicon name: outline/x-mark
  
              Menu open: "block", Menu closed: "hidden"
            -->
            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- DIV CON LAS OPCIONES DE LA IZQUIERDA DEL MENU -->
      {{--<div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">--}}
        <div class="flex flex-1 items-center justify-center sm:justify-start">
            <!-- LOGOTIPO -->
            {{--<a href="/dashboard" class="flex flex-shrink-0 items-center border-double border-4 border-sky-500 rounded">--}}
              <a href="/dashboard" class="items-center border-double border-4 border-sky-500 rounded block sm:hidden lg:block">
                <span class="text-white pl-2">Grafi<strong class="text-white pr-2">Aprendizaje</strong></span>
            </a>
            <!-- OPCIONES DE MENU -->
            <div class="hidden sm:ml-6 sm:block">
                <div class="flex space-x-4">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <!-- COMENTAR NAVEGACION SELECCIONADA -->
                    {{--<a href="{{route('dashboard')}}" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Home</a>--}}
                    <a href="{{route('dashboard')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-1 lg:px-3 py-7 lg:py-4 rounded-md text-sm font-bold lg:text-base">Home</a>
                    <a href="{{route('estudiante.diagnostico')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-1 lg:px-3 py-2 rounded-md text-sm font-bold lg:text-base">Evaluación de diagnóstico</a>
                    <a href="{{route('estudiante.letterslevelone')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-1 lg:px-3 py-2 rounded-md text-sm font-bold lg:text-base">Correcta escritura de palabras</a>
                    <a href="{{route('estudiante.acentuationlevelone')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-1 lg:px-3 py-2 rounded-md text-sm font-bold lg:text-base">Acentuación de palabras</a>
                    <a href="{{route('estudiante.punctuationlevelone')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-1 lg:px-3 py-2 rounded-md text-sm font-bold lg:text-base">Uso de los signos de puntuación</a>
                    <a href="{{route('estudiante.practica')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-1 lg:px-3 py-5 lg:py-2 rounded-md text-sm font-bold lg:text-base">Actividades de práctica</a>
                    <a href="{{route('estudiante.final')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-1 lg:px-3 py-5 lg:py-2 rounded-md text-sm font-bold lg:text-base">Evaluación Final</a>
                    
                </div>
            </div>
        </div>

        <!-- QUE CONTIENE LAS OPCIONES DE USUARIO -->
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
            <!-- BOTON DE NOTIFICACIONES QUITAR -->
            {{--<button type="button" class="rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                <span class="sr-only">View notifications</span>
                <!-- Heroicon name: outline/bell -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            </button>--}}
  
            <!-- MENU DESPLEGABLE CON LAS OPCIONES DE USUARIO -->
            <!-- Profile dropdown -->
            <div class="container" x-data="{ open: false }">
                    <div>
                    <button x-on:click="open = true" type="button" class="flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open user menu</span>
                        <!-- IMAGEN DEL USUARION ACTUAL LOGEADO -->
                        <img class="h-full w-full lg:h-16 lg:w-16 rounded-full" src="{{ auth()->user()->profile_photo_url }}" alt="">
                    </button>
                    </div>
    
                    <!--
                    Dropdown menu, show/hide based on menu state.
        
                    Entering: "transition ease-out duration-100"
                        From: "transform opacity-0 scale-95"
                        To: "transform opacity-100 scale-100"
                    Leaving: "transition ease-in duration-75"
                        From: "transform opacity-100 scale-100"
                        To: "transform opacity-0 scale-95"
                    -->
                    <div x-show="open" x-on:click.away="open = false" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <!-- Active: "bg-gray-100", Not Active: "" -->

                        <!-- REDIRIGIR A LA VISTA DE OPCIONES DE USUARIO DE JETSTREAM -->
                        {{--<a href="{{route('profile.show')}}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Opciones de perfil</a>--}}

                        <!-- HACER QUE EL BOTON PANEL ADMIN DEL MENU SOLO SE MUESTRE A LOS USUARIOS CON ROL ADMIN -->
                        <!-- DENTRO DE LA DIRECTIVA CAN SE PUEDE PONER EL NOMBRE DEL PERMISO -->
                        @can ('admin.evaluation.index')
                        <a href="{{route('admin.evaluation.index')}}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Panel admin</a>
                        @endcan
                        
                        <!-- BOTON DE CERRAR SESION -->
                        <form method="POST" action="{{route('logout')}}">
                            @csrf 
                            <a href="{{route('logout')}}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2" onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar sesión
                            </a>
                        </form>
                        
                    </div>
            </div>
        </div>
      </div>
    </div>
  
    <!-- DIV CON LAS OPCIONES DEL MENU MOVIL -->
    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu" x-show="open" x-on:click.away="open = false">
      <div class="space-y-1 px-2 pt-2 pb-3">
        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
        <a href="{{route('dashboard')}}" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium" aria-current="page">Home</a>
  
        <a href="{{route('estudiante.diagnostico')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Evaluación de diagnóstico</a>
  
        <a href="{{route('estudiante.letterslevelone')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Correcta escritura de palabras</a>
  
        <a href="{{route('estudiante.acentuationlevelone')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Acentuación de palabras</a>

        <a href="{{route('estudiante.punctuationlevelone')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Uso de los signos de puntuación</a>

        <a href="{{route('estudiante.practica')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Actividades de práctica</a>

        <a href="{{route('estudiante.final')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Evaluación final</a>
      </div>
    </div>
</nav>