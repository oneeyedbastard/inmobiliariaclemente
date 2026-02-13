<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Crear Propiedad</h1>

        {{-- Alertas de Error --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">¡Atención!</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.propiedades.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm rounded-lg p-6 border border-gray-100">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Tipo de Propiedad --}}
                <div class="mb-4">
                    <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de Propiedad</label>
                    <select id="tipo" name="tipo" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        @foreach(['casa', 'departamento', 'local', 'cochera', 'terreno', 'oficina', 'galpon'] as $tipo)
                            <option value="{{ $tipo }}" {{ old('tipo') == $tipo ? 'selected' : '' }}>{{ ucfirst($tipo) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Estado --}}
                <div class="mb-4">
                    <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select id="estado" name="estado" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="venta" {{ old('estado') == 'venta' ? 'selected' : '' }}>Venta</option>
                        <option value="alquiler" {{ old('estado') == 'alquiler' ? 'selected' : '' }}>Alquiler</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Dirección --}}
                <div class="mb-4">
                    <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                    <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                {{-- Localidad --}}
                <div class="mb-4">
                    <label for="localidad" class="block text-sm font-medium text-gray-700">Localidad</label>
                    <input type="text" id="localidad" name="localidad" value="{{ old('localidad') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
            </div>

            {{-- Descripción --}}
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción Detallada</label>
                <textarea id="descripcion" name="descripcion" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>{{ old('descripcion') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Precio --}}
                <div class="mb-4">
                    <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                    <input type="number" step="0.01" id="precio" name="precio" value="{{ old('precio') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                {{-- Metros Cuadrados --}}
                <div class="mb-4">
                    <label for="metros_cuadrados" class="block text-sm font-medium text-gray-700">M² Totales</label>
                    <input type="number" step="0.01" id="metros_cuadrados" name="metros_cuadrados" value="{{ old('metros_cuadrados') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                {{-- Habitaciones --}}
                <div class="mb-4">
                    <label for="habitaciones" class="block text-sm font-medium text-gray-700">Habitaciones</label>
                    <input type="number" id="habitaciones" name="habitaciones" value="{{ old('habitaciones') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                {{-- Baños --}}
                <div class="mb-4">
                    <label for="banos" class="block text-sm font-medium text-gray-700">Baños</label>
                    <input type="number" id="banos" name="banos" value="{{ old('banos') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>

            {{-- Slug --}}
            <div class="mb-4">
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug (URL amigable)</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Se genera automáticamente si se deja vacío">
            </div>

            {{-- Disponibilidad --}}
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" id="disponible" name="disponible" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ old('disponible', '1') == '1' ? 'checked' : '' }}>
                    <label for="disponible" class="ml-2 block text-sm text-gray-700 font-semibold">Publicar inmediatamente</label>
                </div>
            </div>

            <hr class="my-6 border-gray-200">

            {{-- SECCIÓN DE IMÁGENES --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                
                {{-- 1. IMAGEN DE PORTADA --}}
                <div class="p-4 bg-indigo-50 border-2 border-dashed border-indigo-200 rounded-lg">
                    <label for="portada" class="block text-sm font-bold text-indigo-900 mb-2">
                        <i class="fas fa-star mr-1 text-yellow-500"></i> Imagen Principal (Portada)
                    </label>
                    <input type="file" id="portada" name="portada" accept="image/*" 
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer"
                        required>
                    <p class="text-xs text-indigo-600 mt-2 italic font-medium">Obligatorio: Esta es la imagen que se verá en las tarjetas de búsqueda.</p>
                </div>

                {{-- 2. GALERÍA ADICIONAL --}}
                <div class="p-4 bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg">
                    <label for="imagenes" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-images mr-1"></i> Galería de Fotos
                    </label>
                    <input type="file" id="imagenes" name="imagenes[]" multiple accept="image/*" 
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-600 file:text-white hover:file:bg-gray-700 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2 italic">Opcional: Puedes seleccionar múltiples fotos para el carrusel de detalles.</p>
                </div>

            </div>
            
            {{-- Botones de Acción --}}
            <div class="flex items-center justify-between bg-gray-50 -mx-6 -mb-6 p-6 rounded-b-lg border-t border-gray-100">
                <a href="{{ route('admin.propiedades.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800 transition">
                    ← Volver al listado
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Guardar y Finalizar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>