<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GenerateSmallImageSizes extends Command
{
    protected $signature = 'images:generate-small-sizes';
    protected $description = 'Genera tamaños pequeños y medianos para todas las imágenes';

    public function handle()
    {
        $this->info("Generando tamaños pequeños y medianos para imágenes...");

        $imagenes = Imagen::whereNotNull('url')->get();

        if ($imagenes->count() == 0) {
            $this->info("No hay imágenes para procesar.");
            return 0;
        }

        $this->info("Encontradas {$imagenes->count()} imágenes para procesar...");

        $manager = new ImageManager(new Driver());
        
        $processed = 0;
        $errors = 0;
        $skipped = 0;

        foreach ($imagenes as $imagen) {
            $this->info("Procesando imagen ID: {$imagen->id}");

            $originalPath = str_replace('storage/', 'public/', $imagen->url);

            if (!Storage::exists($originalPath)) {
                $this->warn(" [SALTANDO] Archivo no encontrado: {$originalPath}");
                $skipped++;
                continue;
            }

            try {
                $fileContent = Storage::get($originalPath);
                $baseFileName = pathinfo($originalPath, PATHINFO_FILENAME);
                $webpFileName = $baseFileName . '-' . $imagen->id . '.webp';

                $this->info(" Generando archivo: {$webpFileName}");

                // 1. Tamaño pequeño para móviles (280px)
                $smallImage = $manager->read($fileContent)
                    ->scaleDown(280, 373)
                    ->toWebp(75);
                $smallPath = 'public/images/small/' . $webpFileName;
                Storage::put($smallPath, (string) $smallImage);

                // 2. Tamaño medio para tablets (400px)
                $mediumImage = $manager->read($fileContent)
                    ->scaleDown(400, null)
                    ->toWebp(80);
                $mediumPath = 'public/images/medium/' . $webpFileName;
                Storage::put($mediumPath, (string) $mediumImage);

                // ACTUALIZAR base de datos
                $imagen->url_small = 'storage/images/small/' . $webpFileName;
                $imagen->url_medium = 'storage/images/medium/' . $webpFileName;
                $saved = $imagen->save();

                if ($saved) {
                    $this->info(" ✅ IMAGEN {$imagen->id} GUARDADA EN BD");
                    $processed++;
                } else {
                    $this->error(" ❌ IMAGEN {$imagen->id} ERROR AL GUARDAR");
                    $errors++;
                }

            } catch (\Exception $e) {
                $this->error(" ❌ ERROR en imagen {$imagen->id}: " . $e->getMessage());
                $errors++;
            }
        }
        
        $this->info("\n=== RESUMEN ===");
        $this->info("Procesadas: {$processed}");
        $this->info("Errores: {$errors}");
        $this->info("Saltadas: {$skipped}");
        
        // Verificar resultados finales
        $countSmall = Imagen::whereNotNull('url_small')->count();
        $countMedium = Imagen::whereNotNull('url_medium')->count();
        $this->info("Imágenes con url_small: {$countSmall}/{$imagenes->count()}");
        $this->info("Imágenes con url_medium: {$countMedium}/{$imagenes->count()}");
        
        return 0;
    }
}