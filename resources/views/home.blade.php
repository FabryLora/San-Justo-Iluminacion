@extends('layouts.default')

@section('title', 'San Justo Iluminación')

@section('description', $metadatos->description ?? "")
@section('keywords', $metadatos->keywords ?? "")

@section('content')
    <x-banner-portada :homeInfo="$homeInfo" />
    <x-seccion-uno :homeInfo="$homeInfo" />
    <x-catalogos :catalogos="$catalogos" />
    <x-seccion-dos :homeInfo="$homeInfo" />
    <x-seccion-tres :homeInfo="$homeInfo" />

@endsection