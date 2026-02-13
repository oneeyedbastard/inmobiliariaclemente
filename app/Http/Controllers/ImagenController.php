<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ImagenController extends Controller
{
    public function store(Request $request, Propiedad $propiedad)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,webp|max:20480', 
        ]);

        $image = $request->file('file');
        $nombre = 'prop-' . $propiedad->id . '-' . Str::random(10) . '.' . $image->extension();
        $image->storeAs('propiedades', $nombre, 'public');

        // LÓGICA NUEVA: Si es la primera imagen, marcarla como principal
        $esLaPrimera = $propiedad->imagenes()->count() === 0;

        $nuevaImagen = $propiedad->imagenes()->create([
            'url' => $nombre,
            'es_principal' => $esLaPrimera
        ]);

        return response()->json([
            'success' => $nombre,
            'id' => $nuevaImagen->id // Devolvemos el ID para poder manipularla en el front
        ]);
    }

    /**
     * Marcar una imagen como principal
     */
    public function setPrincipal(Propiedad $propiedad, Imagen $imagen)
    {
        // 1. Quitamos el check de 'principal' a todas las imágenes de esta propiedad
        $propiedad->imagenes()->update(['es_principal' => false]);

        // 2. Marcamos la imagen seleccionada como principal
        $imagen->update(['es_principal' => true]);

        return back()->with('success', 'Imagen de portada actualizada.');
    }

    public function destroy(Imagen $imagen)
    {
        $propiedad = $imagen->propiedad;
        $eraPrincipal = $imagen->es_principal;

        $imagen->delete();

        // Si borramos la principal, intentamos asignar la corona a la siguiente disponible
        if ($eraPrincipal) {
            $siguiente = $propiedad->imagenes()->first();
            if ($siguiente) {
                $siguiente->update(['es_principal' => true]);
            }
        }

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Imagen eliminada.');
    }
}