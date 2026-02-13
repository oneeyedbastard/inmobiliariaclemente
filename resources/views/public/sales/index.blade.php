@extends('layouts.main')
@section('content')
    <livewire:filtro-propiedades estado="venta" :tipo="$tipo" />
@endsection