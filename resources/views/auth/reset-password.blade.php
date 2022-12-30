<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{--<x-jet-authentication-card-logo />--}}
            <a href="#" class="items-center border-double border-8 border-sky-500 rounded block lg:block p-4 bg-teal-400">
                <span class="text-white pl-2 text-5xl">Grafi<strong class="text-white pr-2">Aprendizaje</strong></span>
            </a>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <!-- PASSWORD ORIGINAL -->
            {{--<div class="mt-4">
                <x-jet-label for="password" value="{{ __('New Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>--}}

            <!-- NUEVO CAMPO CONTRASEÑA -->
            <div class="mt-4" x-data="{ show: false }">
                <x-jet-label for="password" value="{{ __('Nueva contraseña') }}" />
                <input id="password" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" />
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

            <!-- CONFIRMAR CONTRASEÑA ORIGINAL -->
            {{--<div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Vuelva a escribir la nueva contraseña') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>--}}

            <!-- NUEVO CAMPO CONFIRMAR CONTRASEÑA -->
            <div class="mt-4" x-data="{ show: false }">
                <x-jet-label for="password_confirmation" value="{{ __('Vuelva a escribir la nueva contraseña') }}" />
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

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Reset Password') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
