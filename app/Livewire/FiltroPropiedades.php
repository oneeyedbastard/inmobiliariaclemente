<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Propiedad;

class FiltroPropiedades extends Component
{

    public $estado; 
    public $tipo = '';
    public $localidad = '';
    public $precioMin = '';
    public $precioMax = '';
    public $habitaciones = ''; 
    public $banos = '';        

    public function mount($estado, $tipo = null)
    {
        $this->estado = $estado;
        if ($tipo) {
            $this->tipo = $tipo;
        }
    }

    public function render()
    {
        $query = Propiedad::with('imagenes')
            ->where('estado', $this->estado)
            ->where('disponible', true);

        // Aplicación de filtros
        if ($this->tipo) $query->where('tipo', $this->tipo);
        if ($this->localidad) $query->where('localidad', $this->localidad);
        if ($this->habitaciones) $query->where('habitaciones', '>=', $this->habitaciones);
        if ($this->banos) $query->where('banos', '>=', $this->banos);
        if ($this->precioMin) $query->where('precio', '>=', $this->precioMin);
        if ($this->precioMax) $query->where('precio', '<=', $this->precioMax);

        return view('livewire.filtro-propiedades', [
            'propiedades' => $query->latest()->get()
        ]);
    }
}