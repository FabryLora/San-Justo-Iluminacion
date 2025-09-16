@extends('layouts.default')
@section('title', 'Productos - San Justo Iluminacion')

@section('description', $metadatos->description ?? "")
@section('keywords', $metadatos->keywords ?? "")

@section('content')
    <div class="absolute top-30 left-1/2 w-[1224px] -translate-x-1/2 flex flex-row gap-1 z-100">
        <a href="/" class="text-black font-medium text-[12px]">{{__('Inicio')}}</a>
        <span class="text-black font-medium text-[12px]">/</span>
        <span class="text-black font-medium text-[12px]">{{__('Productos')}}</span>
    </div>
    <div class="flex flex-col gap-10 max-sm:gap-6 py-20">



        <x-search-bar :espacios="$espacios" :lineas="$lineas" :usos="$usos" :ambientes="$ambientes" :espacio="$espacio"
            :linea="$linea" :ambiente="$ambiente" :uso="$uso" :code="$code" />

        <!-- Main content with sidebar and products -->
        <div class="flex flex-col lg:flex-row gap-6 max-sm:gap-4 w-[1224px] max-sm:w-full max-sm:px-4 mx-auto">

            {{-- Sidebar with categories --}}


            <div class="w-full mb-10">
                <div class="grid grid-cols-1 md:grid-cols-4 max-sm:grid-cols-1 gap-6 max-sm:gap-4">
                    @forelse($productos as $producto)
                        <a href="{{ "/productos/" . $producto->code }}"
                            class=" 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        min-h-[332px]  flex flex-col w-[288px] max-sm:w-full rounded-sm  border-[#DEDFE0]">
                            <div class="h-full flex flex-col">
                                @if ($producto->imagenes->count() > 0)
                                    <div class="relative min-h-[287px] max-sm:h-[200px]">
                                        <img src="{{ $producto->imagenes->first()->image }}" alt="{{ $producto->name }}"
                                            class=" w-full h-full  object-cover rounded-t-sm">
                                        <h2
                                            class="absolute left-3 bottom-2 text-[14px] font-semibold uppercase text-primary-orange">
                                            {{$producto->categoria->name ?? ''}}
                                        </h2>
                                    </div>

                                @else
                                    <div class="relative min-h-[287px] max-sm:h-[200px]">
                                        <img src={{$logos->logo_principal}} alt="{{ $producto->name }}"
                                            class=" w-full h-full  object-contain rounded-t-sm">
                                        <h2
                                            class="absolute left-3 bottom-2 text-[14px] font-semibold uppercase text-primary-orange">
                                            {{$producto->categoria->name ?? ''}}
                                        </h2>
                                    </div>
                                @endif

                                <div class="flex flex-col justify-start   h-full px-1 mt-2">
                                    <h2 class="text-[16px] font-semibold text-primary-orange">{{$producto->code}}</h2>
                                    <p class="overflow-hidden line-clamp-2 text-[20px] font-custom! leading-tight">
                                        {{$producto->name}}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-3 max-sm:col-span-1 py-8 max-sm:py-6 text-center text-gray-500">
                            No hay productos disponibles en esta categoría.
                        </div>
                    @endforelse
                </div>

                {{-- Enlaces de paginación --}}
                @if($productos->hasPages())
                    <div class="mt-8 max-sm:mt-6 flex flex-col justify-center my-10">
                        <div class="pagination-wrapper">
                            {{ $productos->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection