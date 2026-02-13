<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    {{-- Metadatos básicos --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">

    {{-- Título optimizado --}}
    <title>@yield('title', 'Inmobiliaria Clemente - Villa Elisa')</title>

    {{-- SEO Mejorado --}}
    <meta name="description" content="@yield('meta_description', '🏡 Inmobiliaria Clemente en Villa Elisa. 40+ años de experiencia. Propiedades en venta y alquiler. Casas, departamentos, terrenos.')">

    {{-- Keywords modernas --}}
    <meta name="keywords" content="@yield('meta_keywords', 'inmobiliaria villa elisa, casas en venta, alquiler departamentos, terrenos, propiedades, bienes raíces, inmobiliaria clemente')">

    {{-- Autor y derechos --}}
    <meta name="author" content="Inmobiliaria Clemente">
    <meta name="copyright" content="Inmobiliaria Clemente">

    {{-- Robots mejorados --}}
    <meta name="robots" content="index, follow, max-snippet:150, max-image-preview:large, max-video-preview:-1">
    <meta name="googlebot" content="index, follow">

    {{-- Canonical dinámico --}}
    <link rel="canonical" href="{{ Request::url() }}">

    {{-- Open Graph mejorado --}}
    <meta property="og:locale" content="es_AR">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'Inmobiliaria Clemente - Villa Elisa')">
    <meta property="og:description" content="@yield('og_description', '🏡 40+ años de experiencia en Villa Elisa. Propiedades en venta y alquiler.')">
    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:site_name" content="Inmobiliaria Clemente">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Inmobiliaria Clemente - Villa Elisa">

    {{-- Twitter Card mejorada --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@InmobiliariaClemente">
    <meta name="twitter:title" content="@yield('twitter_title', 'Inmobiliaria Clemente - Villa Elisa')">
    <meta name="twitter:description" content="@yield('twitter_description', '🏡 40+ años de experiencia en Villa Elisa. Propiedades en venta y alquiler.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/twitter-card.jpg'))">

    {{-- Datos Estructurados (Schema.org) --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": ["RealEstateAgent", "LocalBusiness"],
        "name": "Inmobiliaria Clemente",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo-schema.png') }}",
        "description": "Más de 40 años de experiencia en Villa Elisa ofreciendo casas, departamentos y terrenos en venta y alquiler.",
        "image": "{{ asset('images/og-image.jpg') }}",
        "telephone": "+54 221 487-1010",
        "email": "info@inmobiliariaclemente.com",
        "priceRange": "$$",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Calle 422 N° 233",
            "addressLocality": "Villa Elisa",
            "addressRegion": "Buenos Aires",
            "postalCode": "1894",
            "addressCountry": "AR"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "-34.8583",
            "longitude": "-58.0814"
        },
        "openingHoursSpecification": [{
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
            "opens": "09:00",
            "closes": "14:00"
        }],
        "sameAs": [
            "https://www.instagram.com/inmobiliariaclemente",
            "https://www.facebook.com/inmobiliariaclemente",
            "https://www.linkedin.com/company/inmobiliariaclemente"
        ],
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.8",
            "reviewCount": "124"
        }
    }
    </script>

    @hasSection('structured_data')
        @yield('structured_data')
    @endif

    {{-- Preconexión crítica --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    {{-- Fuentes --}}
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap"
        as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap">
    </noscript>

    {{-- FAVICONS CORREGIDOS --}}
    {{-- Intentamos cargar primero el .ico que subiste (debe estar en public/favicon.ico) --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v={{ time() }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}?v={{ time() }}" type="image/x-icon">

    {{-- Fallbacks opcionales por si luego agregas PNGs --}}
    <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">

    <meta name="theme-color" content="#0d6efd">

    {{-- Bootstrap 5 --}}
    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        crossorigin="anonymous" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    </noscript>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        crossorigin="anonymous">

    {{-- CSS personalizado --}}
    <link rel="preload" href="{{ asset('css/styles.css') }}" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    </noscript>

    @if (config('app.env') === 'production')
        <script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'GA_MEASUREMENT_ID');
        </script>
    @endif
</head>

<body class="d-flex flex-column min-vh-100">
    <a href="#main-content" class="skip-link visually-hidden-focusable">
        Saltar al contenido principal
    </a>

    <header class="header-centered">
        <div class="header-logo">
            <x-logo />
        </div>
        <div class="header-nav">
            @include('components.navbar')
        </div>
    </header>

    <main>       
        @yield('content')
    </main>
    
    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"
        defer></script>
    @livewireScripts

    @stack('scripts')
</body>

</html>
