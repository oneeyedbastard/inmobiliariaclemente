{{-- resources/views/components/home/hero.blade.php --}}
<section class="hero-split-section">
    {{-- Imagen de fondo difuminada a la derecha --}}
    <div class="hero-bg-blurred" style="background-image: url('{{ asset('images/propiedades-villa-elisa.webp') }}');"></div>

    <div class="hero-split-container">
        {{-- Columna de texto --}}
        <div class="hero-split-content">
            <span class="hero-badge">
                <svg class="me-2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="7"/>
                    <polygon points="12 2 14 7 19 7 15 10 17 15 12 12 7 15 9 10 5 7 10 7 12 2"/>
                </svg>
                Desde 1980 en Villa Elisa
            </span>

            <h1 class="hero-title">
                Encontrá tu lugar con Inmobiliaria
                <span class="text-serif">Clemente.</span>
            </h1>

            <p class="hero-subtitle">
                Más de 40 años conectando familias con sus hogares ideales. 
                Experiencia, transparencia y confianza en cada operación.
            </p>

            <div class="hero-actions">
                <a href="{{ route('sales.index') }}" class="hero-btn primary">
                    <svg class="me-2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 2l-2 2m-7.5 7.5L19 4"/>
                        <circle cx="8" cy="16" r="4"/>
                        <path d="M4 16l4-4 4 4"/>
                    </svg>
                    Ver Ventas
                </a>
                <a href="{{ route('rentals.index') }}" class="hero-btn outline">
                    <svg class="me-2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 21h18"/>
                        <path d="M3 7v14h6V7a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v14h6V7a6 6 0 0 0-6-6H9a6 6 0 0 0-6 6z"/>
                        <path d="M12 12h.01"/>
                    </svg>
                    Ver Alquileres
                </a>
            </div>
        </div>

        {{-- Columna vacía (solo para mantener la estructura grid, el fondo ya está puesto) --}}
        <div class="hero-split-image"></div>
    </div>
</section>