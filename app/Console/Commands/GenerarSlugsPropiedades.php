<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Propiedad;
use Illuminate\Support\Str;

class GenerarSlugsPropiedades extends Command
{
    protected $signature = 'app:generar-slugs-propiedades';
    protected $description = 'Genera slugs únicos y amigables para todas las propiedades que aún no los tienen.';

    public function handle()
    {
        $propiedades = Propiedad::whereNull('slug')->get();

        if ($propiedades->isEmpty()) {
            $this->info('✔️ No hay propiedades sin slug. Todo está actualizado.');
            return;
        }

        foreach ($propiedades as $propiedad) {
            // Validaciones básicas para evitar errores
            if (!$propiedad->tipo || !$propiedad->localidad || !$propiedad->direccion) {
                $this->warn("❗ Propiedad ID {$propiedad->id} tiene datos incompletos. Saltada.");
                continue;
            }

            // Limpiar dirección: sin símbolos extraños, sin múltiples espacios
            $direccion = Str::limit($propiedad->direccion, 60, '');
            $direccion = preg_replace('/[^A-Za-z0-9\s\-]/u', '', $direccion); // solo letras, números, espacios y guiones
            $direccion = preg_replace('/\s+/', ' ', $direccion); // colapsar espacios

            // Construir partes del slug
            $partes = [
                $propiedad->tipo,
                $propiedad->localidad,
                $direccion,
                $propiedad->id,
            ];

            // Generar slug SEO-friendly
            $slug = Str::slug(implode(' ', $partes), '-');

            $propiedad->slug = $slug;
            $propiedad->save();

            $this->info("✅ Slug generado para propiedad ID {$propiedad->id}: {$slug}");
        }

        $this->info('🎉 Slugs generados correctamente para todas las propiedades pendientes.');
    }
}
