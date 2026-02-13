@props(['propiedad'])

@php
    $esVenta = $propiedad->estado === 'venta';
    $nombreRuta = $esVenta ? 'sales.show' : 'rentals.show';
    $ruta = route($nombreRuta, ['slug' => $propiedad->slug]);
    
    $simbolo = $esVenta ? 'U$D' : '$';
    $precioFormateado = $simbolo . ' ' . number_format($propiedad->precio, 0, ',', '.');
    $imagenPrincipal = $propiedad->imagenes->first();
@endphp

<div class="property-card" data-id="{{ $propiedad->id }}">
    
    <a href="{{ $ruta }}" class="card-full-overlay">
        <div class="rect-action-btn">
            <span>Ver Detalles</span>
        </div>
    </a>

    <div class="card-media">
        <img 
            src="{{ $imagenPrincipal ? asset('storage/propiedades/' . basename($imagenPrincipal->url)) : asset('img/sin-foto.jpg') }}" 
            class="card-image"
            alt="{{ $propiedad->tipo }} en {{ $propiedad->localidad }}"
            loading="lazy"
            onerror="this.src='{{ asset('img/sin-foto.jpg') }}'"
        >
        
        @if($propiedad->imagenes->count() > 1)
            <div class="photo-counter">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                </svg>
                <span>{{ $propiedad->imagenes->count() }}</span>
            </div>
        @endif
    </div>

    <div class="card-content">
        <div class="card-header">
            <span class="card-badge badge-{{ $propiedad->estado }}">
                {{ ucfirst($propiedad->estado) }}
            </span>
            <span class="property-type">
                {{ ucfirst($propiedad->tipo) }}
            </span>
        </div>

        <div class="price-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-primary); margin-right: 6px;">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                <line x1="7" y1="7" x2="7.01" y2="7"></line>
            </svg>         
            <span class="price-value">{{ $precioFormateado }}</span>
        </div>

        <div class="location-info">
            <h3 class="property-address">
                {{ Str::limit($propiedad->direccion, 35) }}
            </h3>
            <div class="city-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; opacity: 0.8;">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                <span>{{ Str::limit($propiedad->localidad, 25) }}</span>
            </div>
        </div>
    </div>
</div>