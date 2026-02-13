<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Propiedad extends Model
{
    use HasFactory;

    protected $table = 'propiedades';

    protected $fillable = [
        'tipo', 'estado', 'localidad', 'descripcion', 'precio',
        'direccion', 'metros_cuadrados', 'habitaciones', 'banos',
        'slug', 'disponible',
    ];

    protected $casts = [
        'disponible' => 'boolean',
        'precio'     => 'decimal:0', // Quita decimales visualmente en precios enteros
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'propiedad_id');
    }

    // RELACIÓN OPTIMIZADA: Trae solo una foto (la más antigua) para listados.
    // Evita cargar todas las fotos en el Home.
    public function imagenPortada()
    {
        return $this->hasOne(Imagen::class)->oldestOfMany();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (Filtros Inteligentes)
    |--------------------------------------------------------------------------
    */

    public function scopeDisponible(Builder $query)
    {
        return $query->where('disponible', true);
    }

    public function scopeVenta(Builder $query)
    {
        return $query->where('estado', 'venta');
    }

    public function scopeAlquiler(Builder $query)
    {
        return $query->where('estado', 'alquiler');
    }

    // Filtro unificado para el Buscador
    public function scopeFiltrar(Builder $query, array $filtros)
    {
        return $query->when($filtros['tipo'] ?? null, function ($q, $tipo) {
                if ($tipo !== 'propiedades' && $tipo !== 'todos') {
                    $q->where('tipo', $tipo);
                }
            })
            ->when($filtros['localidad'] ?? null, function ($q, $localidad) {
                $q->where('localidad', 'like', "%{$localidad}%");
            })
            ->when($filtros['habitaciones'] ?? null, function ($q, $habitaciones) {
                $q->where('habitaciones', '>=', $habitaciones);
            })
            ->when($filtros['banos'] ?? null, function ($q, $banos) {
                $q->where('banos', '>=', $banos);
            })
            ->when($filtros['precio_min'] ?? null, function ($q, $precio) {
                $q->where('precio', '>=', $precio);
            })
            ->when($filtros['precio_max'] ?? null, function ($q, $precio) {
                $q->where('precio', '<=', $precio);
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Helpers
    |--------------------------------------------------------------------------
    */

    public function getPrecioFormateadoAttribute()
    {
        // Venta en USD, Alquiler en Pesos (ajustar según tu lógica de negocio)
        $simbolo = $this->estado === 'venta' ? 'U$D' : '$';
        return $simbolo . ' ' . number_format($this->precio, 0, ',', '.');
    }

    // --- CORRECCIÓN DE IMÁGENES ---
    // Este método genera la URL pública correcta para el navegador.
    public function getUrlPortadaAttribute()
    {
        // 1. Intentamos usar la relación optimizada (si se cargó con 'with')
        if ($this->relationLoaded('imagenPortada') && $this->imagenPortada) {
            $imagen = $this->imagenPortada;
        } else {
            // 2. Si no, buscamos la primera de la colección normal
            $imagen = $this->imagenes->first();
        }

        // 3. Si existe la imagen, construimos la ruta completa
        if ($imagen) {
            // basename() limpia la ruta para obtener solo el nombre del archivo (ej: foto.jpg)
            // asset() agrega http://localhost:8000/storage/...
            return asset('storage/propiedades/' . basename($imagen->url));
        }

        // 4. Fallback: Si no tiene fotos, mostramos una imagen por defecto
        // Asegúrate de tener esta imagen en public/img/
        return asset('img/sin-foto.jpg'); 
    }

    public static function tiposDisponibles($estado = null)
    {
        $tipos = [
            'casa'         => 'Casas',
            'departamento' => 'Departamentos',
            'local'        => 'Locales',
            'cochera'      => 'Cocheras',
            'terreno'      => 'Terrenos',
            'galpon'       => 'Galpones',
            'oficina'      => 'Oficinas',
        ];

        if ($estado === 'alquiler') {
            unset($tipos['terreno']);
        }

        return $tipos;
    }

    /*
    |--------------------------------------------------------------------------
    | Boot (Eventos)
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($propiedad) {
            if (empty($propiedad->slug)) {
                $slugBase = $propiedad->tipo . '-' . $propiedad->direccion . '-' . $propiedad->localidad;
                // Str::slug convierte a minúsculas y guiones, Str::random(4) evita duplicados
                $propiedad->slug = Str::slug($slugBase . '-' . Str::random(4));
            }
        });
    }
}