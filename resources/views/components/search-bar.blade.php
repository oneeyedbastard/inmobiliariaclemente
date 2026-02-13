<div class="properties-layout">
    {{-- BARRA LATERAL: Mantiene tu diseño original --}}
    <aside class="filter-container">
        <div class="search-bar-card">
            {{-- Header --}}
            <div class="search-bar-header">
                <h5 class="search-bar-title">
                    <i class="fas fa-filter filter-icon"></i> Filtrar Propiedades
                </h5>
                
                {{-- Badge de filtros activos dinámico --}}
                @php
                    $activeFilters = 0;
                    if($tipo) $activeFilters++;
                    if($localidad) $activeFilters++;
                    if($habitaciones) $activeFilters++;
                    if($banos) $activeFilters++;
                @endphp

                @if($activeFilters > 0)
                    <span class="filter-badge">
                        {{ $activeFilters }}
                    </span>
                @endif
            </div>
            
            <div class="search-bar-body">       
                
                {{-- Grupo: Tipo --}}
                <div class="search-group">
                    <label class="search-label">
                        <i class="fas fa-home search-icon"></i> Tipo de Inmueble
                    </label>
                    <select wire:model.live="tipo" class="search-select">
                        <option value="">Todos</option>
                        @foreach(['casa', 'departamento', 'local', 'cochera', 'terreno', 'oficina'] as $item)
                            <option value="{{ $item }}">{{ ucfirst($item) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Grupo: Localidad --}}
                <div class="search-group">
                    <label class="search-label">
                        <i class="fas fa-map-marker-alt search-icon"></i> Localidad
                    </label>
                    <select wire:model.live="localidad" class="search-select">
                        <option value="">Todas</option>
                        <option value="Villa Elisa">Villa Elisa</option>
                        <option value="City Bell">City Bell</option>
                        <option value="Gonnet">Gonnet</option>
                        <option value="Arturo Segui">Arturo Seguí</option>
                        <option value="Ensenada">Ensenada</option>
                    </select>
                </div>

                {{-- Grupo: Habitaciones --}}
                <div class="search-group">
                    <label class="search-label">
                        <i class="fas fa-bed search-icon"></i> Dormitorios
                    </label>
                    <select wire:model.live="habitaciones" class="search-select">
                        <option value="">Cualquier cantidad</option>
                        @for($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}">{{ $i }}{{ $i == 4 ? '+' : '' }} dorm.</option>
                        @endfor
                    </select>
                </div>

                {{-- Grupo: Baños --}}
                <div class="search-group">
                    <label class="search-label">
                        <i class="fas fa-bath search-icon"></i> Baños
                    </label>
                    <select wire:model.live="banos" class="search-select">
                        <option value="">Cualquier cantidad</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                    </select>
                </div>

                {{-- Botón de Limpiar: Solo aparece si hay filtros --}}
                @if($activeFilters > 0)
                    <div class="search-actions">
                        <button wire:click="$set('tipo', ''); $set('localidad', ''); $set('habitaciones', ''); $set('banos', '')" 
                                class="search-btn search-btn-clear">
                            <i class="fas fa-eraser btn-icon"></i> Limpiar Filtros
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </aside>
    
    {{-- ÁREA DE RESULTADOS --}}
    <main class="properties-grid-area">
        {{-- Indicador de carga --}}
        <div wire:loading class="loading-container">
            <div class="loading-spinner">
                <span class="loading-text">Cargando...</span>
            </div>
        </div>

        @if($propiedades->count() > 0)
            <div class="properties-grid-wrapper" wire:loading.remove>
                @foreach($propiedades as $propiedad)
                    <div class="property-item-wrapper" wire:key="prop-{{ $propiedad->id }}">
                        <x-property-card :propiedad="$propiedad" />
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-properties-message" wire:loading.remove>
                <div class="no-properties-icon">
                    <svg class="search-icon-large" viewBox="0 0 24 24">
                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5z"/>
                    </svg>
                </div>
                <h2 class="no-properties-title">No se encontraron propiedades</h2>
                <p class="no-properties-text">Intenta ajustar los selectores para encontrar lo que buscas.</p>
            </div>
        @endif
    </main>
</div>