@extends('layouts.main')
@section('content')
    <livewire:filtro-propiedades estado="alquiler" :tipo="$tipo" />
@endsection