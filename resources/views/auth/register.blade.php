<x-guest-layout>

    <div class="grid grid-cols-1 lg:grid-cols-2">
        <div class="col-span-1">
            
            {{--<img src="{{asset('/imagenesapp/portadalogin.jpg')}}" class="object-cover object-center shadow-2xl w-0 h-0 lg:w-full lg:h-full">--}}
            {{--<img src="{{asset('/imagenesapp/portadados.png')}}" class="object-fill object-center shadow-2xl w-0 h-0 lg:w-full lg:h-screen">--}}
            <div class="grid-flow-col">
                <a href="#" class="items-center border-double border-8 border-sky-500 rounded block lg:block p-4 bg-teal-400">
                    <div class="text-center">
                        <span class="text-white pl-2 text-5xl">Grafi<strong class="text-white pr-2">Aprendizaje</strong></span>
                    </div>
                </a>
    
                <div class="bg-slate-900 p-10 rounded-3xl my-5">
                    
                    <p class="text-lg text-justify md:text-xl text-white font-sora p-5">
                        GrafiAprendizaje es una aplicación orientada a promover el uso de reglas ortográficas del idioma español.
                        <br>
                        <br>
                        Al acceder a esta aplicación, tiene a su disposición información acerca del correcto empleo de las reglas ortográficas.
                        <br>
                        <br>
                        Además, actividades para poner en práctica sus conocimientos sobre:
                        <br>
                            <li class="text-lg text-justify md:text-xl text-white font-sora pl-20">Escritura de palabras</li>
                            <li class="text-lg text-justify md:text-xl text-white font-sora pl-20">Acentuación de palabras</li>
                            <li class="text-lg text-justify md:text-xl text-white font-sora pl-20">Uso de los signos de puntuación</li>
                    </p>

                    <div class="bg-green-600 my-4 rounded-3xl">
                        <p class="text-lg md:text-lg font-sora p-8 font-bold text-center text-white">
                            ¡Inicie sesión o regístrese y acceda a la aplicación web!
                        </p>
                    </div>
                </div>
                
            </div>

        </div>
        <div class="col-span-1">
            <x-jet-authentication-card>
                <!-- LOGO -->
                <x-slot name="logo">
                    {{--<x-jet-authentication-card-logo />--}}
                    <a href="#" class="items-center border-double border-8 border-sky-500 rounded block lg:block p-4 bg-teal-400">
                        <span class="text-white pl-2 text-5xl">Grafi<strong class="text-white pr-2">Aprendizaje</strong></span>
                    </a>
                </x-slot>
        
                <x-jet-validation-errors class="mb-4" />
        
                <form method="POST" action="{{ route('register') }}">
                    @csrf
        
                    <div>
                        {{--<x-jet-label for="name" value="{{ __('Name') }}" />--}}
                        <x-jet-label for="name" value="{{ __('Nombre y apellido') }}" />
                        <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>
        
                    <div class="mt-4">
                        <x-jet-label for="email" value="{{ __('Correo electrónico institucional (utn.edu.ec)') }}" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    </div>
        
                    <!-- CAMPO PASSWORD -->
                    {{--<div class="mt-4">
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>--}}
                    <!-- NUEVO CAMPO CONTRASEÑA -->
                    <div class="mt-4" x-data="{ show: false }">
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <input id="password" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" />
                        <!-- BOTON TAPAR CONTRASEÑA -->
                        <button type="button" @click="show = !show" :class="{ 'hidden': !show, 'block': show}" class="inline-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg> 
                            <span class="text-sm pl-2 pt-1">Ocultar contraseña</h6>
                        </button>
                        <!-- BOTON MOSTRAR CONTRASEÑA -->
                        <button type="button" @click="show = !show" :class="{ 'hidden': show, 'block': !show}" class="inline-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                            
                            <span class="text-sm pl-2 pt-1">Ver contraseña</h6>
                        </button>
                    </div>
        
                    <!-- CAMPO PASSWORD CONFIRMATION -->
                    {{--<div class="mt-4">
                        <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>--}}

                    <!-- NUEVO CAMPO CONFIRMAR CONTRASEÑA -->
                    <div class="mt-4" x-data="{ show: false }">
                        <x-jet-label for="password_confirmation" value="{{ __('Password') }}" />
                        <input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" :type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" />
                        <!-- BOTON TAPAR CONTRASEÑA -->
                        <button type="button" @click="show = !show" :class="{ 'hidden': !show, 'block': show}" class="inline-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg> 
                            <span class="text-sm pl-2 pt-1">Ocultar contraseña</h6>
                        </button>
                        <!-- BOTON MOSTRAR CONTRASEÑA -->
                        <button type="button" @click="show = !show" :class="{ 'hidden': show, 'block': !show}" class="inline-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                            
                            <span class="text-sm pl-2 pt-1">Ver contraseña</h6>
                        </button>
                    </div>
        
                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-jet-label for="terms">
                                <div class="flex items-center">
                                    <x-jet-checkbox name="terms" id="terms"/>
        
                                    <div class="ml-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-jet-label>
                        </div>
                    @endif
        
                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm  hover:text-gray-900 text-red-500 font-bold" href="{{ route('login') }}">
                            {{ __('¿Ya se registró? Iniciar Sesión') }}
                        </a>
        
                        <x-jet-button class="ml-4">
                            {{ __('Register') }}
                        </x-jet-button>
                    </div>
                </form>
            </x-jet-authentication-card>
        </div>
    </div>
    
</x-guest-layout>
