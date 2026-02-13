@extends('layouts.main')

@section('title', 'Página no encontrada - Inmobiliaria Clemente')

@section('content')
    <main class="error-container">
        <div class="error-wrapper">
            <span class="error-code">404</span>
            <h1 class="error-title">Página no encontrada</h1>
            <p class="error-message">
                Lo sentimos, la propiedad que estás buscando no existe o ha sido retirada del mercado.
                Te invitamos a seguir explorando nuestras oportunidades exclusivas.
            </p>
            <div class="error-actions">
                <a href="{{ route('home') }}" class="btn-error primary">Volver al inicio</a>
                <a href="{{ route('contacto.index') }}" class="btn-error outline">Contactar</a>
            </div>
        </div>
    </main>
@endsection
