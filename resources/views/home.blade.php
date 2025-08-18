@extends('layouts.default')

@section('title', 'San Justo Iluminación')

@section('description', $metadatos->description ?? "")
@section('keywords', $metadatos->keywords ?? "")

@section('content')
    <x-slider :sliders="$sliders" />


    <x-banner-portada :bannerPortada="$bannerPortada" />

@endsection