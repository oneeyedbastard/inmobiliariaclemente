<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropiedadController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ImagenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. VISTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/', [PropiedadController::class, 'home'])->name('home');
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto.index');
Route::post('/contacto', [ContactoController::class, 'send'])->name('contacto.send');

// Filtro estricto para tipos de propiedad
$tiposPermitidos = 'casa|departamento|local|cochera|terreno';

// Listados
Route::get('/alquileres/{tipo?}', [PropiedadController::class, 'alquileres'])
    ->where('tipo', $tiposPermitidos)
    ->name('rentals.index');

Route::get('/ventas/{tipo?}', [PropiedadController::class, 'ventas'])
    ->where('tipo', $tiposPermitidos)
    ->name('sales.index');

// Detalles (Se mantienen abajo de los listados para no pisar las rutas con {tipo})
Route::get('/ventas/{slug}', [PropiedadController::class, 'verVentas'])->name('sales.show');
Route::get('/alquileres/{slug}', [PropiedadController::class, 'verAlquiler'])->name('rentals.show');

/*
/*
/*
|--------------------------------------------------------------------------
| 2. PANEL ADMINISTRATIVO (Rutas Protegidas)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard estándar (URL: /dashboard | Nombre: dashboard)
    Route::get('/dashboard', function () { 
        return view('dashboard'); 
    })->name('dashboard');

    // Todo lo que sea gestión administrativa (URL: admin/... | Nombre: admin. ...)
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // CRUD de Propiedades (admin.propiedades.*)
        Route::resource('propiedades', PropiedadController::class)->parameters([
            'propiedades' => 'propiedad'
        ]);
        
        // Gestión de Imágenes
        // Esta será: admin.propiedades.imagenes.store
        Route::post('/propiedades/{propiedad}/imagenes', [ImagenController::class, 'store'])->name('propiedades.imagenes.store');
        
        // Esta será: admin.imagenes.destroy (LA QUE TE DABA ERROR)
        Route::delete('/imagenes/{id}', [ImagenController::class, 'destroy'])->name('imagenes.destroy');
    });
});
/*
|--------------------------------------------------------------------------
| 3. PERFIL Y AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Autenticación de Laravel (Breeze/Jetstream)
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| 4. FALLBACK (Siempre al final)
|--------------------------------------------------------------------------
*/

Route::fallback(fn() => abort(404));

Route::get('/test-503', function () {
    abort(503);
});