@extends('layouts.default')

@section('title', 'SR33')

@section('description', $metadatos->description ?? "")
@section('keywords', $metadatos->keywords ?? "")

@section('content')
    <x-slider :sliders="$sliders" />


    <x-banner-portada :bannerPortada="$bannerPortada" />

@endsection