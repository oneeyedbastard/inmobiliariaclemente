<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Propiedades') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">

                @if (session('success'))
                    <div class="flex items-center p-4 mb-6 text-sm text-green-700 bg-green-100 border border-green-300 rounded-md">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="mb-8 text-right">
                    <a href="{{ route('admin.propiedades.create') }}" 
                        class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-gray-800 rounded-md hover:bg-gray-700 transition">
                        <i class="fas fa-plus-circle mr-2"></i> Agregar Propiedad
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <div class="flex items-center">
                            <i class="fas fa-home text-blue-500 text-xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Total</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $propiedades->total() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                        <div class="flex items-center">
                            <i class="fas fa-tags text-green-500 text-xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">En Venta</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $propiedades->where('estado', 'venta')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                        <div class="flex items-center">
                            <i class="fas fa-key text-yellow-500 text-xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">En Alquiler</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $propiedades->where('estado', 'alquiler')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
                        <div class="flex items-center">
                            <i class="fas fa-check-double text-purple-500 text-xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Disponibles</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $propiedades->where('disponible', true)->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-md shadow border border-gray-200">
                    <table class="w-full text-sm text-gray-700 bg-white">
                        <thead class="text-xs text-gray-600 uppercase bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left">Imagen</th>
                                <th class="px-6 py-3 text-left">Tipo</th>
                                <th class="px-6 py-3 text-left">Estado</th>
                                <th class="px-6 py-3 text-left">Dirección</th>
                                <th class="px-6 py-3 text-left">Precio</th>
                                <th class="px-6 py-3 text-left">Disp.</th>
                                <th class="px-6 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($propiedades as $propiedad)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        @if($propiedad->imagenes->isNotEmpty())
                                            <img src="{{ asset('storage/' . $propiedad->imagenes->first()->url) }}" 
                                                class="w-16 h-16 object-cover rounded shadow-sm border" 
                                                alt="Propiedad"
                                                onerror="this.src='https://placehold.co/100x100?text=Error'">
                                        @else
                                            <div class="w-16 h-16 bg-gray-100 rounded border flex items-center justify-center text-gray-400">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 capitalize font-medium">{{ $propiedad->tipo }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-md text-xs font-bold {{ $propiedad->estado == 'venta' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ strtoupper($propiedad->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ Str::limit($propiedad->direccion, 30) }}
                                    </td>
                                    <td class="px-6 py-4 font-bold">
                                        ${{ number_format($propiedad->precio, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <i class="fas {{ $propiedad->disponible ? 'fa-check-circle text-green-500' : 'fa-times-circle text-red-500' }}"></i>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center items-center space-x-3">
                                            <a href="{{ route('admin.propiedades.edit', $propiedad) }}" 
                                                class="text-yellow-600 hover:text-yellow-800 transition" title="Editar">
                                                <i class="fas fa-edit fa-lg"></i>
                                            </a>
                                            
                                            <form action="{{ route('admin.propiedades.destroy', $propiedad) }}" method="POST" 
                                                onsubmit="return confirm('¿Eliminar esta propiedad permanentemente?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                                    <i class="fas fa-trash-alt fa-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500 italic">
                                        No se encontraron propiedades.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6">
                    {{ $propiedades->links() }}
                </div>
            </div> 
        </div>
    </div>
</x-app-layout>