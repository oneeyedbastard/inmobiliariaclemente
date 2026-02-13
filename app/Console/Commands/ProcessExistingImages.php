<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProcessExistingImages extends Command
{
    protected $signature = 'images:process-existing';
    protected $description = 'Re-procesa TODAS las imágenes para generar los nuevos tamaños';

    public function handle()
    {
        $this->info("Iniciando re-procesamiento de TODAS las imágenes...");

        // Procesar TODAS las imágenes
        $imagenes = Imagen::whereNotNull('url')->get();

        if ($imagenes->count() == 0) {
            $this->info("No hay imágenes para procesar.");
            return 0;
        }

        $this->info("Encontradas {$imagenes->count()} imágenes para procesar...");

        $manager = new ImageManager(new Driver());
        $bar = $this->output->createProgressBar($imagenes->count());
        $bar->start();

        foreach ($imagenes as $imagen) {
            $originalPath = str_replace('storage/', 'public/', $imagen->url);

            if (!Storage::exists($originalPath)) {
                $this->warn(" [Saltando] Archivo no encontrado: " . $originalPath);
                $bar->advance();
                continue;
            }

            try {
                $fileContent = Storage::get($originalPath);
                $baseFileName = pathinfo($originalPath, PATHINFO_FILENAME);
                $webpFileName = $baseFileName . '-' . $imagen->id . '.webp';

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

                // 3. Imagen principal (1200px)
                $mainImage = $manager->read($fileContent)
                    ->scaleDown(1200, null)
                    ->toWebp(85);
                $mainPath = 'public/images/main/' . $webpFileName;
                Storage::put($mainPath, (string) $mainImage);

                // 4. Miniatura (400x300)
                $thumbImage = $manager->read($fileContent)
                    ->cover(400, 300)
                    ->toWebp(80);
                $thumbPath = 'public/images/thumbnails/' . $webpFileName;
                Storage::put($thumbPath, (string) $thumbImage);

                // ACTUALIZAR con TODOS los tamaños
                $imagen->update([
                    'url_small' => 'storage/images/small/' . $webpFileName,
                    'url_medium' => 'storage/images/medium/' . $webpFileName,
                    'url_main' => 'storage/images/main/' . $webpFileName,
                    'url_thumb' => 'storage/images/thumbnails/' . $webpFileName,
                ]);

                $this->info(" ✅ Imagen ID {$imagen->id} procesada");

            } catch (\Exception $e) {
                $this->error(" ❌ Error en imagen ID {$imagen->id}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->info("\n¡Procesamiento completado!");
        
        // Verificar resultados
        $countSmall = Imagen::whereNotNull('url_small')->count();
        $countMedium = Imagen::whereNotNull('url_medium')->count();
        $this->info("Imágenes con url_small: {$countSmall}/{$imagenes->count()}");
        $this->info("Imágenes con url_medium: {$countMedium}/{$imagenes->count()}");
        
        return 0;
    }
}