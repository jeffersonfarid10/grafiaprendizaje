<x-app-layout>
    Vista de welcome
    <br>

    Haga click aqui para ingresar al examen de diagnostico
    <br>
    {{--<!-- MENSAJE DE SESION QUE APARECE CUANDO UN ESTUDIANTE NO TIENE ASIGNADO UN EXAMEN O UNA PREGUNTA A LA QUE TRATA DE INGRESAR -->

    <div>
        <!--MENSAJE DE SESION-->
        @if (Session::has('message'))
            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                <p class="font-bold">Alerta</p>
                {{Session::get('message')}}
            </div>
        @endif
    </div>--}}
    <br>

    <a href="{{route('estudiante.diagnostico')}}">
        <button class="px-4 py-2 rounded shadow focus:shadow-md focus:outline-none transition-all text-white bg-green-500 hover:bg-green-700 ring-green-300 focus:ring">
            Evaluacion de Diagnóstico
        </button>
    </a>

    {{--<div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
        <p class="font-bold">Be Warned</p>
        <p>Something not ideal might be happening.</p>
      </div>--}}
</x-app-layout>

