<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropiedadFactory extends Factory
{
    public function definition(): array
    {
        $estado = fake()->randomElement(['venta', 'alquiler']);
        $tipo = fake()->randomElement(['casa', 'departamento', 'local', 'terreno']);
        
        // Lógica de precios realista
        $precio = ($estado === 'venta') 
            ? fake()->numberBetween(45000, 350000) // Venta: 45k a 350k USD
            : fake()->numberBetween(150000, 800000); // Alquiler: 150k a 800k ARS (ejemplo)

        $localidades = ['Villa Elisa', 'City Bell', 'Gonnet', 'Arturo Segui', 'La Plata'];

        return [
            'tipo' => $tipo,
            'estado' => $estado,
            'localidad' => fake()->randomElement($localidades),
            'descripcion' => fake()->paragraph(3),
            'precio' => $precio,
            'direccion' => fake()->streetAddress(),
            'metros_cuadrados' => fake()->numberBetween(40, 300),
            'habitaciones' => fake()->numberBetween(1, 5),
            'banos' => fake()->numberBetween(1, 3),
            'disponible' => true,
            // El slug se genera automático en el boot del modelo, no hace falta aquí
        ];
    }
}