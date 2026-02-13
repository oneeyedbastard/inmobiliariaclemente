<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use App\Models\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PropiedadController extends Controller
{
    // 1. MAPA DE TRADUCCIÓN (URL Plural => BD Singular)
    protected $mapaTipos = [
        'casas'         => 'casa',
        'departamentos' => 'departamento',
        'locales'       => 'local',
        'cocheras'      => 'cochera',
        'terrenos'      => 'terreno',
        'galpones'      => 'galpon',
        'oficinas'      => 'oficina',
    ];

    // --- VISTAS PÚBLICAS ---

    public function home()
    {   
        $propiedades = Propiedad::with('imagenes') 
                        ->where('disponible', true)
                        ->inRandomOrder()
                        ->limit(4) 
                        ->get();

        return view('home', compact('propiedades'));
    }

    public function alquileres(Request $request, $tipo = null)
    {
        // Query base
        $query = Propiedad::with('imagenes')
                    ->where('estado', 'alquiler')
                    ->where('disponible', true);

        // TRADUCCIÓN: Si la URL trae 'casas' (plural), buscamos 'casa' (singular)
        // Si $tipo es null, no entra aquí.
        $tipoDb = $tipo ? ($this->mapaTipos[$tipo] ?? null) : null;

        if ($tipoDb) {
            $query->where('tipo', $tipoDb);
        }

        // Filtros extra (precio, localidad)
        $propiedades = $this->aplicarFiltros($query, $request);
        
        // Retornamos la vista pasando 'tipo' (el plural original) para la URL
        return view('public.rentals.index', compact('propiedades', 'tipo'));
    }

    public function ventas(Request $request, $tipo = null)
    {
        $query = Propiedad::with('imagenes')
                    ->where('estado', 'venta')
                    ->where('disponible', true);

        // TRADUCCIÓN
        $tipoDb = $tipo ? ($this->mapaTipos[$tipo] ?? null) : null;

        if ($tipoDb) {
            $query->where('tipo', $tipoDb);
        }

        $propiedades = $this->aplicarFiltros($query, $request);
        
        return view('public.sales.index', compact('propiedades', 'tipo'));
    }

    public function verAlquiler($slug)
    {
        $propiedad = Propiedad::with('imagenes')
                        ->where('slug', $slug)
                        ->where('estado', 'alquiler')
                        ->firstOrFail();
        return view('public.rentals.show', compact('propiedad'));
    }

    public function verVentas($slug)
    {
        $propiedad = Propiedad::with('imagenes')
                        ->where('slug', $slug)
                        ->where('estado', 'venta')
                        ->firstOrFail();
        return view('public.sales.show', compact('propiedad'));
    }

    // Método privado para limpiar código repetido
    private function aplicarFiltros($query, $request)
    {
        if ($request->filled('localidad')) {
            $query->where('localidad', 'like', "%{$request->localidad}%");
        }
        
        // Ordenamos por más reciente y paginamos
        return $query->latest()->paginate(12);
    }

    // --- CRUD ADMIN ---

    public function dashboard()
    {
        return view('dashboard');
    }

    public function index()
    {
        $propiedades = Propiedad::with('imagenes')->latest()->paginate(10);
        return view('admin.properties.index', compact('propiedades'));
    }

    public function create()
    {
        return view('admin.properties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'direccion'  => 'required|string|max:255',
            'precio'     => 'required|numeric',
            'estado'     => 'required|in:venta,alquiler',
            'tipo'       => 'required',
            'portada'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:12288',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,webp|max:12288'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->direccion . '-' . Str::random(5));
        $data['disponible'] = $request->has('disponible');

        $propiedad = Propiedad::create($data);

        if ($request->hasFile('portada')) {
            $path = $request->file('portada')->store('propiedades', 'public');
            Imagen::create([
                'propiedad_id' => $propiedad->id,
                'url'          => $path,
                'url_main'     => $path,
                'es_portada'   => true
            ]);
        }

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $file) {
                $path = $file->store('propiedades', 'public');
                Imagen::create([
                    'propiedad_id' => $propiedad->id,
                    'url'          => $path,
                    'url_main'     => $path,
                    'es_portada'   => false
                ]);
            }
        }

        return redirect()->route('admin.propiedades.index')->with('success', 'Propiedad creada con éxito.');
    }

    public function edit(Propiedad $propiedad)
    {
        return view('admin.properties.edit', compact('propiedad'));
    }

    public function update(Request $request, Propiedad $propiedad)
    {
        $request->validate([
            'direccion'  => 'required|string|max:255',
            'precio'     => 'required|numeric',
            'estado'     => 'required|in:venta,alquiler',
            'tipo'       => 'required',
            'portada'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:12288',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,webp|max:12288'
        ]);

        $data = $request->all();
        $data['disponible'] = $request->has('disponible');

        if ($propiedad->direccion !== $request->direccion) {
            $data['slug'] = Str::slug($request->direccion . '-' . Str::random(5));
        }

        $propiedad->update($data);

        if ($request->hasFile('portada')) {
            $portadaVieja = $propiedad->imagenes()->where('es_portada', true)->first();
            
            if ($portadaVieja) {
                $portadaVieja->delete(); 
            }

            $path = $request->file('portada')->store('propiedades', 'public');
            Imagen::create([
                'propiedad_id' => $propiedad->id,
                'url'          => $path,
                'url_main'     => $path,
                'es_portada'   => true
            ]);
        }

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $file) {
                $path = $file->store('propiedades', 'public');
                Imagen::create([
                    'propiedad_id' => $propiedad->id,
                    'url'          => $path,
                    'url_main'     => $path,
                    'es_portada'   => false
                ]);
            }
        }

        return redirect()->route('admin.propiedades.index')->with('success', 'Propiedad actualizada correctamente.');
    }

    public function destroy(Propiedad $propiedad)
    {
        foreach ($propiedad->imagenes as $img) {
            $img->delete();
        }

        $propiedad->delete();

        return redirect()->route('admin.propiedades.index')->with('success', 'Propiedad eliminada definitivamente.');
    }
}