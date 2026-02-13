@extends('layouts.main')

@section('title', 'Inmobiliaria Clemente - Expertos en Villa Elisa y City Bell')
@section('meta_description', 'Agencia inmobiliaria líder en Zona Norte de La Plata. Venta, alquiler y tasaciones con 40
    años de experiencia en Villa Elisa.')

@section('content')

    {{-- section hero --}}
    <x-home.hero />
    
    {{-- section values --}}
    <x-home.values />

    {{-- section featured --}}
    <x-home.featured :propiedades="$propiedades" />

@endsection
