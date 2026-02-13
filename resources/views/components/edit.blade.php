<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Propiedad') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Mensaje de error de validación -->
                    @if ($errors->any())
                        <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Mensajes de éxito o error -->
                    @if (session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 bg-green-100 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Imágenes actuales -->
                    <div class="flex flex-wrap gap-4 mt-4">
                        @foreach($propiedad->imagenes as $imagen)
                            <div class="imagen-item">
                                <img src="{{ asset($imagen->url) }}" alt="Imagen" class="w-48 h-48 object-cover rounded shadow-lg">
                                <form action="{{ route('imagenes.destroy', $imagen->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta imagen?');" class="text-center mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <!-- Formulario de Edición -->
                    <form action="{{ route('propiedades.update', $propiedad->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Campos del formulario de edición -->
                        <div class="mb-4">
                            <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                            <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                <option value="casa" {{ $propiedad->tipo == 'casa' ? 'selected' : '' }}>Casa</option>
                                <option value="departamento" {{ $propiedad->tipo == 'departamento' ? 'selected' : '' }}>Departamento</option>
                                <option value="local" {{ $propiedad->tipo == 'local' ? 'selected' : '' }}>Local</option>
                                <option value="terreno" {{ $propiedad->tipo == 'terreno' ? 'selected' : '' }}>Terreno</option>
                                <option value="cochera" {{ $propiedad->tipo == 'cochera' ? 'selected' : '' }}>Cochera</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                <option value="alquiler" {{ $propiedad->estado == 'alquiler' ? 'selected' : '' }}>Alquiler</option>
                                <option value="venta" {{ $propiedad->estado == 'venta' ? 'selected' : '' }}>Venta</option>
                            </select>
                        </div>

                        <!-- Checkbox disponible con hidden -->
                        <div class="mb-4">
                            <label for="disponible" class="inline-flex items-center">
                                <input type="hidden" name="disponible" value="0">
                                <input type="checkbox" 
                                       id="disponible" 
                                       name="disponible" 
                                       value="1"
                                       {{ $propiedad->disponible ? 'checked' : '' }}
                                       class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out">
                                <span class="ml-2 text-sm text-gray-700">Disponible</span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                            <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $propiedad->direccion) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                            <textarea id="descripcion" name="descripcion" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>{{ old('descripcion', $propiedad->descripcion) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                            <input type="number" id="precio" name="precio" value="{{ old('precio', $propiedad->precio) }}" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="localidad" class="block text-sm font-medium text-gray-700">Ubicación</label>
                            <input type="text" id="localidad" name="localidad" value="{{ old('localidad', $propiedad->localidad) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="metros_cuadrados" class="block text-sm font-medium text-gray-700">Metros Cuadrados</label>
                            <input type="number" id="metros_cuadrados" name="metros_cuadrados" value="{{ old('metros_cuadrados', $propiedad->metros_cuadrados) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="habitaciones" class="block text-sm font-medium text-gray-700">Habitaciones</label>
                            <input type="number" id="habitaciones" name="habitaciones" value="{{ old('habitaciones', $propiedad->habitaciones) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="banos" class="block text-sm font-medium text-gray-700">Baños</label>
                            <input type="number" id="banos" name="banos" value="{{ old('banos', $propiedad->banos) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- Formulario para agregar imágenes -->
                        <div class="mb-4">
                            <input type="file" name="imagenes[]" multiple class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex items-center justify-between mt-4">
                            <button type="submit" class="btn">
                                Actualizar
                            </button>
                            <a href="{{ route('propiedades.index') }}" class="inline-block px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">
                                Cancelar
                            </a>
                        </div>
                    </form>
                
                </div>
            </div>
        </div>
    </div>
</div>
