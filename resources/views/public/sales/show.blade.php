@extends('layouts.main')

@section('title', $propiedad->direccion . ' | Inmobiliaria Clemente')

@section('content')
    <div class="property-detail-page"> {{-- Cambié container por property-detail-page para usar el CSS definido --}}
        {{-- GALERÍA DE IMÁGENES --}}
        <section class="property-gallery">
            <img id="mainGalleryImage"
                src="{{ $propiedad->imagenes->isNotEmpty() ? asset('storage/' . $propiedad->imagenes[0]->url) : asset('img/no-photo.jpg') }}"
                class="main-gallery-image" alt="{{ $propiedad->direccion }}"
                onerror="this.src='{{ asset('img/no-photo.jpg') }}'">

            <a href="#" class="view-all-photos" data-bs-toggle="modal" data-bs-target="#galleryModal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 3h6v6M14 10L21 3M5 3H3v2M3 8v2M3 15v2M3 21h2M8 21h2M15 21h6v-6M21 14v-2"/>
                    <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" fill="none"/>
                </svg>
                Ver todas las fotos
            </a>

            <div class="gallery-count">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                    <circle cx="12" cy="13" r="4"/>
                </svg>
                {{ count($propiedad->imagenes) }} fotos
            </div>

            @if (count($propiedad->imagenes) > 1)
                <div class="gallery-thumbnails">
                    @foreach ($propiedad->imagenes->slice(0, 5) as $index => $imagen)
                        <div class="gallery-thumb {{ $index === 0 ? 'active' : '' }}"
                            onclick="changeMainImage('{{ asset('storage/' . $imagen->url) }}', this)">
                            <img src="{{ asset('storage/' . $imagen->url) }}" alt="Miniatura {{ $index + 1 }}"
                                onerror="this.src='{{ asset('img/no-photo.jpg') }}'">
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- HEADER DE LA PROPIEDAD --}}
        <header class="property-header">
            <span class="property-category">
                {{ ucfirst($propiedad->tipo) }} en {{ ucfirst($propiedad->estado) }}
            </span>

            <h1 class="property-address">{{ $propiedad->direccion }}</h1>

            <div class="property-price">
                {{ $propiedad->estado === 'venta' ? 'U$D' : '$' }}{{ number_format($propiedad->precio, 0, ',', '.') }}
            </div>

            <div class="property-period">
                {{ $propiedad->estado === 'venta' ? 'Precio de venta' : 'Alquiler mensual' }}
            </div>

            <div class="property-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $propiedad->habitaciones }}</span>
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="stat-icon">
                        <path d="M4 12v8a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-8M2 10l10-7 10 7"/>
                        <rect x="8" y="12" width="8" height="8" stroke="currentColor" fill="none"/>
                        <circle cx="15" cy="7" r="1" fill="currentColor"/>
                    </svg>
                    <span class="stat-label">Dormitorios</span>
                </div>

                <div class="stat-item">
                    <span class="stat-number">{{ $propiedad->banos }}</span>
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="stat-icon">
                        <path d="M8 6v2m8-2v2M2 12h20M4 12v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6M6 8h12a2 2 0 0 1 2 2v2H4v-2a2 2 0 0 1 2-2z"/>
                        <circle cx="8" cy="5" r="1" fill="currentColor"/>
                        <circle cx="16" cy="5" r="1" fill="currentColor"/>
                    </svg>
                    <span class="stat-label">Baños</span>
                </div>

                @if ($propiedad->metros_cuadrados)
                    <div class="stat-item">
                        <span class="stat-number">{{ $propiedad->metros_cuadrados }}</span>
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="stat-icon">
                            <path d="M3 3v18h18V3H3zM9 3v18M15 3v18M3 9h18M3 15h18"/>
                            <circle cx="7.5" cy="7.5" r="1.5" fill="currentColor"/>
                            <circle cx="16.5" cy="16.5" r="1.5" fill="currentColor"/>
                        </svg>
                        <span class="stat-label">Metros²</span>
                    </div>
                @endif
            </div>
        </header>

        {{-- CONTENIDO PRINCIPAL Y SIDEBAR --}}
        <div class="content-wrapper">
            <main class="main-content">
                <div class="content-section">
                    <div class="content-header">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" fill="none"/>
                            <path d="M8 10h8M8 14h6"/>
                        </svg>
                        <h2 class="content-title">Descripción</h2>
                    </div>

                    <div class="content-body">
                        <div class="description-text">
                            @if ($propiedad->descripcion)
                                {!! nl2br(e($propiedad->descripcion)) !!}
                            @else
                                <p class="text-empty">
                                    Esta propiedad está disponible a través de Inmobiliaria Clemente.
                                    Contáctanos para más detalles.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </main>

            <aside class="sidebar-wrapper">
                <div class="sidebar-sticky-container">
                    <div class="agent-card">
                        <div class="agent-header">
                            <div class="avatar-wrapper">
                                <img src="{{ asset('images/icono_clemente.png') }}" alt="Inmobiliaria Clemente"
                                    class="agent-avatar logo-fit">
                                <span class="online-status"></span>
                            </div>
                            <h5 class="agent-title">¿Te interesa esta propiedad?</h5>
                            <p class="agent-subtitle">Hablemos, soy un asesor experto.</p>
                        </div>

                        <div class="agent-body">
                            <div class="ref-container">
                                <span class="ref-label">Referencia:</span>
                                <span class="ref-badge">
                                    #{{ str_pad($propiedad->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>

                            <div class="action-buttons">
                          
                                {{-- Botón de WhatsApp (ya existente) --}}
                                <a href="https://wa.me/5492215408272?text=Hola,%20estoy%20viendo%20la%20propiedad%20Ref:%20{{ $propiedad->id }}%20en%20{{ urlencode($propiedad->direccion) }}%20y%20quisiera%20m%C3%A1s%20informaci%C3%B3n."
                                    target="_blank" class="btn-whatsapp">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                    </svg>
                                    WhatsApp
                                </a>

                                {{-- Botón de email --}}
                                <a href="mailto:inmobiliariaclemente@hotmail.com" class="btn-email">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                        <polyline points="22,6 12,13 2,6"/>
                                    </svg>
                                    Enviar email
                                </a>
                            </div>                            
                        </div>
                    </div>
                </div>
            </aside>
        </div>

        {{-- MODAL DE GALERÍA --}}
        <div class="modal fade gallery-modal" id="galleryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-black border-0">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title text-white">{{ $propiedad->direccion }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-center p-0 overflow-hidden">
                        <div id="carouselProperty" class="carousel slide w-100 h-100">
                            <div class="carousel-inner h-100">
                                @foreach ($propiedad->imagenes as $index => $imagen)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }} h-100">
                                        <div class="d-flex align-items-center justify-content-center h-100 w-100 p-3">
                                            <img src="{{ asset('storage/' . $imagen->url) }}"
                                                class="img-fluid mw-100 mh-100 shadow-lg"
                                                style="object-fit: contain; max-height: 85vh;"
                                                alt="Imagen {{ $index + 1 }}"
                                                onerror="this.src='{{ asset('img/no-photo.jpg') }}'">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if (count($propiedad->imagenes) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselProperty"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon p-3 bg-dark"></span> {{-- Eliminado rounded-circle --}}
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselProperty"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon p-3 bg-dark"></span> {{-- Eliminado rounded-circle --}}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function changeMainImage(imageUrl, element) {
            const mainImage = document.getElementById('mainGalleryImage');
            mainImage.style.opacity = '0.6';

            setTimeout(() => {
                mainImage.src = imageUrl;
                mainImage.onload = function() {
                    mainImage.style.opacity = '1';
                };
            }, 100);

            document.querySelectorAll('.gallery-thumb').forEach(thumb => {
                thumb.classList.remove('active');
            });
            element.classList.add('active');
        }
    </script>
@endpush