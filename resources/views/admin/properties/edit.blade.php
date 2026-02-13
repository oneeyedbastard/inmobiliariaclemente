<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Propiedad') }}: <span class="text-blue-600">{{ $propiedad->direccion }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if ($errors->any())
                        <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg" role="alert">
                            <ul class="list-disc ml-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 bg-green-100 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.propiedades.update', $propiedad) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-10">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Gestión de Galería</h3>
                            @if($propiedad->imagenes->count() > 0)
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                                    @foreach($propiedad->imagenes as $imagen)
                                        <div class="relative flex flex-col items-center bg-gray-50 p-2 rounded-xl border-2 transition-all {{ $imagen->es_portada ? 'border-blue-500 bg-blue-50 shadow-md' : 'border-gray-200' }}">
                                            
                                            <a href="{{ asset('storage/' . $imagen->url) }}" target="_blank" class="w-full">
                                                <img src="{{ asset('storage/' . $imagen->url) }}" alt="Propiedad" class="w-full h-32 object-cover rounded-lg mb-3">
                                            </a>
                                            
                                            <label class="flex items-center cursor-pointer group w-full justify-center pb-1">
                                                <input type="radio" 
                                                       name="foto_portada_id" 
                                                       value="{{ $imagen->id }}" 
                                                       class="form-radio h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                                       {{ $imagen->es_portada ? 'checked' : '' }}>
                                                <span class="ml-2 text-xs font-black uppercase {{ $imagen->es_portada ? 'text-blue-700' : 'text-gray-500' }}">
                                                    {{ $imagen->es_portada ? 'Portada' : 'Elegir' }}
                                                </span>
                                            </label>

                                            </div>
                                    @endforeach
                                </div>
                                <p class="text-xs text-blue-600 mt-4 font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Selecciona una imagen y presiona "Actualizar Propiedad" para cambiar la portada.
                                </p>
                            @else
                                <div class="bg-gray-100 p-8 rounded-lg text-center border-2 border-dashed border-gray-300">
                                    <p class="text-gray-500 italic">No hay imágenes cargadas aún.</p>
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <div>
                                    <label for="tipo" class="block text-sm font-semibold text-gray-700 mb-1">Tipo de Propiedad</label>
                                    <select id="tipo" name="tipo" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                                        @foreach(['casa', 'departamento', 'local', 'terreno', 'cochera', 'oficina', 'galpon'] as $tipo)
                                            <option value="{{ $tipo }}" {{ $propiedad->tipo == $tipo ? 'selected' : '' }}>{{ ucfirst($tipo) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="estado" class="block text-sm font-semibold text-gray-700 mb-1">Estado (Operación)</label>
                                    <select id="estado" name="estado" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                                        <option value="alquiler" {{ $propiedad->estado == 'alquiler' ? 'selected' : '' }}>Alquiler</option>
                                        <option value="venta" {{ $propiedad->estado == 'venta' ? 'selected' : '' }}>Venta</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="direccion" class="block text-sm font-semibold text-gray-700 mb-1">Dirección</label>
                                    <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $propiedad->direccion) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                                </div>

                                <div>
                                    <label for="localidad" class="block text-sm font-semibold text-gray-700 mb-1">Ubicación / Localidad</label>
                                    <input type="text" id="localidad" name="localidad" value="{{ old('localidad', $propiedad->localidad) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                                </div>

                                <div>
                                    <label for="slug" class="block text-sm font-semibold text-gray-700 mb-1">Slug (URL)</label>
                                    <input type="text" id="slug" name="slug" value="{{ old('slug', $propiedad->slug) }}" 
                                           class="w-full px-3 py-2 border border-gray-200 bg-gray-50 rounded-md text-gray-500 text-sm">
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label for="precio" class="block text-sm font-semibold text-gray-700 mb-1">Precio</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                                        <input type="number" id="precio" name="precio" value="{{ old('precio', $propiedad->precio) }}" step="0.01" 
                                               class="w-full pl-7 px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">M²</label>
                                        <input type="number" name="metros_cuadrados" value="{{ old('metros_cuadrados', $propiedad->metros_cuadrados) }}" class="w-full border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Hab.</label>
                                        <input type="number" name="habitaciones" value="{{ old('habitaciones', $propiedad->habitaciones) }}" class="w-full border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase">Baños</label>
                                        <input type="number" name="banos" value="{{ old('banos', $propiedad->banos) }}" class="w-full border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <label class="flex items-center p-4 border rounded-md cursor-pointer hover:bg-gray-50 transition">
                                        <input type="hidden" name="disponible" value="0">
                                        <input type="checkbox" id="disponible" name="disponible" value="1" {{ $propiedad->disponible ? 'checked' : '' }}
                                               class="h-5 w-5 text-blue-600 border-gray-300 rounded">
                                        <div class="ml-3">
                                            <span class="block text-sm font-bold text-gray-800">Publicar Propiedad</span>
                                            <span class="block text-xs text-gray-500">Si está marcado, será visible en la web.</span>
                                        </div>
                                    </label>
                                </div>

                                <div class="mt-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 text-blue-700">Añadir más fotos</label>
                                    <input type="file" name="imagenes[]" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-2">Descripción Detallada</label>
                            <textarea id="descripcion" name="descripcion" rows="5" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" 
                                      required>{{ old('descripcion', $propiedad->descripcion) }}</textarea>
                        </div>

                        <div class="flex items-center justify-between mt-10 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.propiedades.index') }}" 
                               class="text-sm font-bold text-gray-500 hover:text-gray-700 transition">
                                <i class="fas fa-arrow-left mr-1"></i> Volver al listado
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 shadow-lg active:transform active:scale-95 transition">
                                <i class="fas fa-save mr-2 text-lg"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>

                    @foreach($propiedad->imagenes as $imagen)
                        <form id="delete-form-{{ $imagen->id }}" action="{{ route('admin.imagenes.destroy', $imagen->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteImagen(id) {
            if(confirm('¿Seguro que quieres eliminar esta imagen permanentemente?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
</x-app-layout>