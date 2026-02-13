<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Propiedad;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PropiedadSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpiar la carpeta de imágenes para empezar de cero
        $path = storage_path('app/public/propiedades');
        
        // Si no existe la carpeta, la creamos
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        // 2. Lista de URLs ACTUALIZADA y Verificada (Casas y Departamentos)
        $imageUrls = [
            'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=800&q=80', // Casa Cottage
            'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=800&q=80', // Casa Pequeña
            'https://images.unsplash.com/photo-1580587771525-78b9dba3b91d?w=800&q=80', // Casa Familiar
            'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80', // Mansión Jardín
            'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&q=80', // Geométrica Blanca
            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80', // Interior Living
            'https://images.unsplash.com/photo-1480074568708-e7b720bb3f09?w=800&q=80', // Casa Azul
            'https://images.unsplash.com/photo-151358468e774-c688b055a446?w=800&q=80', // Ventanal
        ];

        $localImages = [];

        $this->command->info('Descargando imágenes de muestra...');

        // 3. Descarga con manejo de errores (Try-Catch)
        foreach ($imageUrls as $index => $url) {
            $filename = "casa-demo-{$index}.jpg";
            
            try {
                // Intentamos descargar (silenciamos warnings con @ para capturarlos en el catch si es necesario, 
                // pero file_get_contents lanza error que el try captura)
                $contents = file_get_contents($url);

                if ($contents !== false) {
                    Storage::disk('public')->put("propiedades/{$filename}", $contents);
                    $localImages[] = "propiedades/{$filename}";
                    $this->command->info("✔ Imagen {$index} descargada.");
                }
            } catch (\Exception $e) {
                // Si falla una, solo avisamos y seguimos
                $this->command->warn("⚠ Falló la imagen {$index}: " . $e->getMessage());
            }
        }

        // Si no se descargó ninguna, paramos
        if (count($localImages) === 0) {
            $this->command->error('❌ No se pudo descargar ninguna imagen. Revisa tu conexión a internet.');
            return;
        }

        $this->command->info('Creando propiedades en la base de datos...');

        // 4. Crear Propiedades
        // Creamos 20 propiedades
        Propiedad::factory(20)->create()->each(function ($propiedad) use ($localImages) {
            
            // Asignamos entre 1 y 4 fotos aleatorias de las que logramos descargar
            // random() falla si le pides más items de los que tiene el array, así que controlamos el máximo.
            $cantidadFotos = rand(1, min(4, count($localImages)));
            $fotosAsignadas = collect($localImages)->random($cantidadFotos);

            foreach ($fotosAsignadas as $fotoPath) {
                Imagen::create([
                    'propiedad_id' => $propiedad->id,
                    'url' => $fotoPath 
                ]);
            }
        });

        $this->command->info('✅ ¡Base de datos poblada con éxito!');
    }
}