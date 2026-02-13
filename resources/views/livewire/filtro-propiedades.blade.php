<div class="filter-section">
    <div class="filter-container">
        
        {{-- FILA SUPERIOR: Tipo, Localidad y PRECIO --}}
        <div class="filter-row filter-row-top">
            
            {{-- 1. Tipo de Inmueble --}}
            <div class="filter-group">
                <select wire:model.live="tipo" class="filter-select">
                    <option value="">🏠 Tipo (Todos)</option>
                    @foreach(['casa', 'departamento', 'local', 'cochera', 'terreno'] as $item)
                        <option value="{{ $item }}">{{ ucfirst($item) }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 2. Localidad --}}
            <div class="filter-group">
                <select wire:model.live="localidad" class="filter-select">
                    <option value="">📍 Localidad (Todas)</option>
                    <option value="Villa Elisa">Villa Elisa</option>
                    <option value="City Bell">City Bell</option>
                    <option value="Gonnet">Gonnet</option>
                    <option value="Arturo Segui">Arturo Seguí</option>
                </select>
            </div>

            {{-- 3. Rango de Precios --}}
            <div class="filter-group filter-price-group">
                <div class="price-inputs">
                    <div class="price-input-wrapper">
                        <span class="price-currency">$</span>
                        <input wire:model.live.debounce.500ms="precioMin" 
                               type="number" 
                               class="filter-input price-input" 
                               placeholder="Mín">
                    </div>
                    <span class="price-separator">-</span>
                    <div class="price-input-wrapper">
                        <span class="price-currency">$</span>
                        <input wire:model.live.debounce.500ms="precioMax" 
                               type="number" 
                               class="filter-input price-input" 
                               placeholder="Máx">
                    </div>
                </div>
            </div>
        </div>

        {{-- FILA INFERIOR: Dormitorios, Baños y Botón Reset --}}
        <div class="filter-row filter-row-bottom">
            
            {{-- Dormitorios --}}
            <div class="filter-group">
                <span class="filter-group-label">Dormitorios</span>
                <div class="filter-pills">
                    <button wire:click="$set('habitaciones', '')" 
                            class="filter-pill {{ $habitaciones === '' ? 'active' : '' }}">
                        Todos
                    </button>
                    @foreach([1, 2, 3, 4] as $cant)
                        <button wire:click="$set('habitaciones', {{ $cant }})" 
                                class="filter-pill {{ $habitaciones == $cant ? 'active' : '' }}">
                            {{ $cant }}+
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Baños --}}
            <div class="filter-group">
                <span class="filter-group-label">Baños</span>
                <div class="filter-pills">
                    <button wire:click="$set('banos', '')" 
                            class="filter-pill {{ $banos === '' ? 'active' : '' }}">
                        Todos
                    </button>
                    <button wire:click="$set('banos', 1)" class="filter-pill {{ $banos == 1 ? 'active' : '' }}">1+</button>
                    <button wire:click="$set('banos', 2)" class="filter-pill {{ $banos == 2 ? 'active' : '' }}">2+</button>
                </div>
            </div>

            {{-- Botón Limpiar --}}
            @if($tipo || $localidad || $habitaciones || $banos || $precioMin || $precioMax)
                <div class="filter-group filter-reset-group">
                    <button wire:click="$set('tipo', ''); $set('localidad', ''); $set('habitaciones', ''); $set('banos', ''); $set('precioMin', ''); $set('precioMax', '')" 
                            class="filter-reset-btn">
                        <svg class="filter-reset-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                        Limpiar filtros
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- Área de resultados --}}
    <main class="properties-area">
        <div wire:loading class="properties-loading">
            <div class="spinner"></div>
            <p class="loading-text">Buscando las mejores opciones...</p>
        </div>
       
        @if($propiedades->count() > 0)
            <div class="properties-grid" wire:loading.remove>
                @foreach($propiedades as $propiedad)
                    <div class="property-card-wrapper" wire:key="prop-{{ $propiedad->id }}">
                        <x-property-card :propiedad="$propiedad" />
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-results" wire:loading.remove>
                <div class="no-results-content">
                    <div class="no-results-icon"></div>
                    <h2 class="no-results-title">No hay coincidencias exactas</h2>
                    <p class="no-results-text">
                        Ajusta los filtros o expande tu búsqueda para encontrar la propiedad ideal en nuestra cartera.
                    </p>
                    
                    <div class="no-results-actions">
                        <button wire:click="$set('tipo', ''); $set('localidad', ''); $set('habitaciones', ''); $set('banos', ''); $set('precioMin', ''); $set('precioMax', '')" 
                                class="btn-reset-large">
                            REESTABLECER TODOS LOS FILTROS
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </main>
</div>