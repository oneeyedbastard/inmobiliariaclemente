<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Imagen extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     */
    protected $table = 'imagenes';

    /**
     * Atributos que se pueden asignar masivamente.
     * 'es_portada' determina si esta imagen es la principal de la propiedad.
     */
    protected $fillable = [
        'propiedad_id',
        'url',        // Imagen original
        'url_main',   // Versión principal (optimizada)
        'url_thumb',  // Miniatura
        'es_portada'  // ¿Es la imagen de portada?
    ];

    /**
     * Conversiones de tipos de datos.
     */
    protected $casts = [
        'es_portada' => 'boolean',
    ];

    /**
     * Eventos del modelo (model events).
     */
    protected static function booted()
    {
        /**
         * Al guardar una imagen (crear o actualizar):
         * Si esta imagen se marca como portada, se asegura que sea la única portada
         * de la propiedad.
         */
        static::saving(function ($imagen) {
            if ($imagen->es_portada) {
                // Desmarcar cualquier otra imagen como portada de esta propiedad
                static::where('propiedad_id', $imagen->propiedad_id)
                    ->where('id', '!=', $imagen->id)
                    ->update(['es_portada' => false]);
            }
        });

        /**
         * Al eliminar una imagen:
         * 1. Elimina los archivos físicos del almacenamiento
         * 2. Si se eliminó la portada, opcionalmente se podría asignar
         *    automáticamente una nueva portada (lógica pendiente si es necesaria)
         */
        static::deleted(function ($imagen) {
            // Eliminar archivos físicos
            $atributos = ['url', 'url_main', 'url_thumb'];

            foreach ($atributos as $attr) {
                if ($imagen->$attr && Storage::disk('public')->exists('propiedades/' . basename($imagen->$attr))) {
                    Storage::disk('public')->delete('propiedades/' . basename($imagen->$attr));
                }
            }

            // Lógica opcional: Si se eliminó la portada, asignar una nueva
            // if ($imagen->es_portada) {
            //     $nuevaPortada = static::where('propiedad_id', $imagen->propiedad_id)
            //         ->first();
            //     
            //     if ($nuevaPortada) {
            //         $nuevaPortada->update(['es_portada' => true]);
            //     }
            // }
        });
    }

    /**
     * Relación: Una imagen pertenece a una propiedad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class);
    }

    /**
     * Scope para obtener solo las imágenes de portada.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePortada($query)
    {
        return $query->where('es_portada', true);
    }

    /**
     * Scope para obtener imágenes por propiedad.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $propiedadId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDePropiedad($query, $propiedadId)
    {
        return $query->where('propiedad_id', $propiedadId);
    }

    /**
     * Método para establecer esta imagen como portada.
     * Actualiza el modelo y limpia otras portadas automáticamente.
     *
     * @return bool
     */
    public function establecerComoPortada()
    {
        return $this->update(['es_portada' => true]);
    }

    /**
     * Método para quitar el estatus de portada.
     *
     * @return bool
     */
    public function quitarComoPortada()
    {
        return $this->update(['es_portada' => false]);
    }

    /**
     * Verifica si esta imagen es la portada.
     *
     * @return bool
     */
    public function esPortada()
    {
        return $this->es_portada === true;
    }
}