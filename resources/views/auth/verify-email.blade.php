<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{--<x-jet-authentication-card-logo />--}}
            <a href="#" class="items-center border-double border-8 border-sky-500 rounded block lg:block p-4 bg-teal-400">
                <span class="text-white pl-2 text-5xl">Grafi<strong class="text-white pr-2">Aprendizaje</strong></span>
            </a>
        </x-slot>

        <div class="mb-4 text-lg text-gray-600">
            {{--{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}--}}
            {{ __('Verifique su dirección de correo electrónico para completar el registro. Revise en su bandeja de entrada o carpeta de spam y haga click en el enlace enviado. Si no recibió el mensaje, haga click en el botón que se encuentra a continuación.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-jet-button type="submit">
                        {{ __('Resend Verification Email') }}
                    </x-jet-button>
                </div>
            </form>

            <div>
                {{--<a
                    href="{{ route('profile.show') }}"
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                >
                    {{ __('Edit Profile') }}</a>--}}

                {{--<form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf

                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 ml-2">
                        {{ __('Log Out') }}
                    </button>
                </form>--}}
            </div>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
