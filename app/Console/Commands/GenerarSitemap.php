<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Propiedad;

class GenerarSitemap extends Command
{
    protected $signature = 'app:generar-sitemap';
    protected $description = 'Genera el archivo sitemap.xml con todas las rutas visibles del sitio.';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Rutas principales
        $sitemap->add(Url::create('/'));
        $sitemap->add(Url::create('/ventas'));
        $sitemap->add(Url::create('/alquileres'));

        // Subcategorías de ventas
        foreach (['casa', 'departamento', 'local', 'cochera', 'terreno'] as $tipo) {
            $sitemap->add(Url::create("/ventas?tipo={$tipo}"));
        }

        // Subcategorías de alquileres
        foreach (['casa', 'departamento', 'local', 'cochera'] as $tipo) {
            $sitemap->add(Url::create("/alquileres?tipo={$tipo}"));
        }

        // Propiedades individuales
        foreach (Propiedad::all() as $propiedad) {
            if (!empty($propiedad->slug)) {
                $sitemap->add(Url::create("/propiedades/{$propiedad->slug}"));
            }
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ sitemap.xml generado correctamente sin /contacto.');
    }
}

