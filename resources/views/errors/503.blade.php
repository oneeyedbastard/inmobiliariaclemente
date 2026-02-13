@extends('layouts.main')

@section('title', 'Mantenimiento en curso - Inmobiliaria Clemente')

@section('content')
    <main class="error-container maintenance">
        <div class="error-wrapper">
            <span class="error-code">503</span>
            <h1 class="error-title">Estamos mejorando para vos</h1>
            <p class="error-message">
                En este momento estamos realizando tareas de mantenimiento en nuestra plataforma.
                Volveremos a estar en línea en unos minutos para ofrecerte la mejor experiencia inmobiliaria.
            </p>
            <div class="error-actions">
                <a href="javascript:location.reload()" class="btn-error">
                    Reintentar ahora
                </a>
                <a href="https://wa.me/5492215408272?text={{ urlencode('Hola Inmobiliaria Clemente, estoy intentando acceder a la web pero se encuentra en mantenimiento. Quisiera realizar una consulta general. Gracias!') }}"
                    target="_blank" class="btn-whatsapp">
                    <i class="fab fa-whatsapp"></i>
                    CONTACTAR POR WHATSAPP
                </a>
            </div>
        </div>
    </main>
@endsection
