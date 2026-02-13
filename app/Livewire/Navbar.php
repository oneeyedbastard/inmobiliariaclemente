<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Propiedad; // Asegúrate de importar tu modelo
use Illuminate\Support\Facades\DB;

class Navbar extends Component
{
    public $tiposVenta = [];
    public $tiposAlquiler = [];

    public function mount()
    {
        // Obtenemos solo los tipos que tienen propiedades activas en VENTA
        // Usamos distinct para no repetir y pluck para sacar solo la lista de nombres
        $this->tiposVenta = Propiedad::where('estado', 'venta')
            ->distinct()
            ->pluck('tipo')
            ->sort()
            ->values()
            ->all();

        // Lo mismo para ALQUILER
        $this->tiposAlquiler = Propiedad::where('estado', 'alquiler') // o 'alquiler' según tu BD
            ->distinct()
            ->pluck('tipo')
            ->sort()
            ->values()
            ->all();
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}