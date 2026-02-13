{{-- resources/views/components/home/featured.blade.php --}}
<section class="featured-section">
    <div class="featured-container">
        {{-- Header de Sección --}}
        <div class="featured-header">
            <h2 class="featured-title">Propiedades Destacadas</h2>
        </div>

        <div class="featured-grid">
            @forelse($propiedades as $propiedad)
                <div class="featured-grid-item">
                    <x-property-card :propiedad="$propiedad" />
                </div>
            @empty
                <div class="featured-empty">
                    <div class="featured-empty-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                    <h4 class="featured-empty-title">Catálogo en actualización</h4>
                    <p class="featured-empty-text">Estamos seleccionando nuevas oportunidades.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>