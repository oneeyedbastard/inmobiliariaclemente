<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropiedadRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado.
     * Ponelo en true, si no te dará error 403.
     */
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Reglas de validación centralizadas.
     */
    public function rules(): array
    {
        return [
            'tipo' => 'required|in:casa,departamento,terreno,local,cochera,oficina,galpon',
            'estado' => 'required|in:venta,alquiler',
            'descripcion' => 'required|string|min:10',
            'direccion' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'localidad' => 'required|string|max:255',
            'habitaciones' => 'nullable|integer|min:0',
            'banos' => 'nullable|integer|min:0',
            'metros_cuadrados' => 'nullable|integer|min:0',
            'disponible' => 'nullable|boolean', // Puede venir como "on", "1" o null
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,webp|max:40960', // Valida cada imagen individualmente
        ];
    }

    /**
     * Mensajes personalizados (Opcional, pero recomendado para el usuario final).
     */
    public function messages(): array
    {
        return [
            'tipo.required' => 'Debes seleccionar el tipo de propiedad.',
            'precio.required' => 'El precio es obligatorio.',
            'imagenes.*.image' => 'Los archivos deben ser imágenes válidas.',
            'imagenes.*.max' => 'Cada imagen no puede pesar más de 40MB.',
        ];
    }
}