<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles de la Propiedad') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Mensaje de éxito -->
                    @if (session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 bg-green-100 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Información de la Propiedad -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $propiedad->titulo }}</h3>
                        <p class="mt-2 text-sm text-gray-600">Tipo: {{ ucfirst($propiedad->tipo) }}</p>
                        <p class="text-sm text-gray-600">Estado: {{ ucfirst($propiedad->estado) }}</p>
                        <p class="text-sm text-gray-600">Ubicación: {{ $propiedad->ubicacion }}</p>
                        <p class="text-sm text-gray-600">Descripción: {{ $propiedad->descripcion }}</p>
                        <p class="text-sm text-gray-600">Precio: ${{ number_format($propiedad->precio, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-600">Metros Cuadrados: {{ $propiedad->metros_cuadrados ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">Habitaciones: {{ $propiedad->habitaciones ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">Baños: {{ $propiedad->banos ?? 'N/A' }}</p>
                            @if ($propiedad->imagenes->isNotEmpty())
                                <div class="mt-4 grid grid-cols-2 gap-2">
                                    @foreach ($propiedad->imagenes as $imagen)
                                        <img src="{{ asset($imagen->url) }}" alt="Imagen de la Propiedad" class="w-full h-auto rounded-md shadow-sm" style="width: 400px; height: 300px; object-fit: cover;">
                                    @endforeach
                                </div>
                            @else
                                <p class="mt-4">No hay imágenes disponibles.</p>
                            @endif

                    </div>

                    <!-- Botones de Acción -->
                    <div class="mt-6">
                        <a href="{{ route('propiedades.edit', $propiedad->id) }}" class="inline-block px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                            Editar
                        </a>

                        <form action="{{ route('propiedades.destroy', $propiedad->id) }}" method="POST" class="inline ml-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">
                                Eliminar
                            </button>
                        </form>

                        <a href="{{ route('propiedades.index') }}" class="inline-block px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600 ml-4">
                            Volver a la lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
