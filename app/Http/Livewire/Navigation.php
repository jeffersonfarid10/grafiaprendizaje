<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Navigation extends Component
{
    public function render()
    {
        $mcategories = ['Bienvenido', 'Letras', 'Acentuación', 'Puntuación', 'Práctica', 'Final'];

        return view('livewire.navigation', compact('mcategories'));
    }
}
