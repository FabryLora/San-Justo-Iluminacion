@extends('layouts.default')

@section('title', 'San Justo Iluminación')

@section('description', $metadatos->description ?? "")
@section('keywords', $metadatos->keywords ?? "")

@section('content')
    <x-banner-portada :homeInfo="$homeInfo" />
    <x-espacios :espacios="$espacios" :titulo="collect($titulos)->firstWhere('seccion', 'espacios')" />
    <x-seccion-uno :homeInfo="$homeInfo" />
    <x-catalogos :catalogos="$catalogos" :titulo="collect($titulos)->firstWhere('seccion', 'catalogos')" />
    <x-lineas-slider :lineas="$lineas" :titulo="collect($titulos)->firstWhere('seccion', 'lineas')" />
    <x-seccion-dos :homeInfo="$homeInfo" />
    <x-seccion-tres :homeInfo="$homeInfo" />
    <x-clientes-slider :clientes="$clientes" :titulo="collect($titulos)->firstWhere('seccion', 'marcas')" />

@endsection