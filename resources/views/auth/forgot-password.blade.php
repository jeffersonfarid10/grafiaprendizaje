<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{--<x-jet-authentication-card-logo />--}}
            <a href="#" class="items-center border-double border-8 border-sky-500 rounded block lg:block p-4 bg-teal-400">
                <span class="text-white pl-2 text-5xl">Grafi<strong class="text-white pr-2">Aprendizaje</strong></span>
            </a>
        </x-slot>

        <div class="mb-4 text-lg text-gray-600">
            {{--{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}--}}
            {{ __('Si ha olvidado su contraseña ingrese su correo electrónico en la siguiente casilla. Se enviará un enlace a su correo para reestablecer la contraseña de su cuenta.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Email Password Reset Link') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
