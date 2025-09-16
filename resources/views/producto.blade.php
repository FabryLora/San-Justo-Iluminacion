@extends('layouts.default')
@section('title', 'San Justo Iluminacion - ' . $producto->code)

@section('description', $producto->name ?? "")


@section('content')

    <div class="flex flex-col gap-10 max-sm:gap-6">
        <!-- Breadcrumb navigation -->
        <div class="absolute top-30 left-1/2 w-[1224px] -translate-x-1/2 flex flex-row gap-1 z-100">
            <a href="/" class="text-black font-medium text-[12px]">{{__('Inicio')}}</a>
            <span class="text-black font-medium text-[12px]">/</span>
            <a href="/productos" class="text-black font-medium text-[12px]">{{__('Productos')}}</a>
            <span class="text-black font-medium text-[12px]">/</span>
            <a href="{{"/productos/" . $producto->code}}"
                class="text-black font-medium text-[12px]">{{$producto->name ?? ""}}</a>
        </div>


        <!-- Main content with sidebar and product detail -->
        <div class="flex flex-col lg:flex-row gap-6 w-[1224px] mx-auto max-sm:w-full max-sm:px-4 max-sm:gap-4 py-20">
            <!-- Sidebar (1/4 width) -->


            <!-- Product Detail (3/4 width) -->
            <div class="w-full max-sm:w-full">
                <div class="flex flex-col md:flex-row gap-5 max-sm:gap-4">
                    <!-- Image Gallery -->
                    <div class="relative w-full flex flex-col gap-5  max-sm:mt-10">

                        <!-- Main Image -->
                        <div class="flex items-center w-full justify-center h-full border rounded-sm">
                            @if ($producto->imagenes->first())
                                <img id="mainImage" class="rounded-sm" src="{{ $producto->imagenes->first()->image }}"
                                    alt="{{ $producto->name }}"
                                    class="w-full h-full object-cover object-center transition-opacity duration-300 ease-in-out">
                            @else
                                <div
                                    class="w-full h-full bg-gray-100 text-gray-400 flex items-center justify-center transition-opacity duration-300 ease-in-out">
                                    <span class="text-sm max-sm:text-xs">Sin imagen disponible</span>
                                </div>
                            @endif
                        </div>
                        <div
                            class="  gap-2 flex flex-row absolute -bottom-24  max-sm:static max-sm:mt-4 max-sm:justify-start max-sm:gap-1.5 max-sm:order-2">
                            @foreach ($producto->imagenes as $imagen)
                                <div class="border border-gray-200 w-[78px] h-[78px] cursor-pointer hover:border-main-color rounded-sm max-sm:w-[60px] max-sm:h-[60px]
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    {{ $loop->first ? 'border-main-color' : '' }}"
                                    onclick="changeMainImage('{{ $imagen->image }}', this)">
                                    <img src="{{ $imagen->image }}" alt="Thumbnail"
                                        class="w-full h-full object-cover rounded-sm">
                                </div>
                            @endforeach
                        </div>

                        <!-- Thumbnails -->

                    </div>

                    <!-- Product Info -->
                    <div class="w-full  flex flex-col min-h-full justify-between max-sm:w-full max-sm:mt-6">
                        <div class="flex flex-col gap-10">
                            <div class="flex flex-col">
                                <h2 class="text-[24px] leading-tight">{{ $producto->code }}</h2>
                                <h2 class="font-semibold text-[32px] leading-tight">{{ $producto->name }}</h2>
                            </div>

                            <div class="flex flex-col gap-2">
                                <div class="flex flex-row text-[16px] justify-between border-b pb-2">
                                    <p class="">{{__("Medidas")}}</p>
                                    <p class="">{{$producto->medidas}}</p>
                                </div>

                                <div class="flex flex-row text-[16px] justify-between border-b pb-2">
                                    <p class="">{{__("Colores")}}</p>

                                    <div class="flex flex-row gap-1">
                                        @foreach ($producto->colores as $color)
                                            <div class="w-[26px] h-[26px] rounded-sm border "
                                                style="background-color: {{ $color->color_hex }}">

                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                <p>Produccion nacional</p>
                                @if ($producto->certificado)
                                    <a href="{{asset('storage/' . $producto->certificado)}}" target="_blank"
                                        download="Certificado de seguridad electrica" class="underline text-[16px]">
                                        {{__("Certificado de seguridad eléctrica")}}
                                    </a>
                                @endif
                            </div>

                        </div>
                        <div class="flex flex-row gap-5">
                            <a href="{{ route('contacto', ['mensaje' => $producto->name]) }}"
                                class="w-full flex justify-center rounded-sm items-center bg-primary-orange text-white font-bold h-[41px] max-sm:h-[36px] max-sm:text-sm">
                                {{__("Consultar")}}
                            </a>
                            @if ($producto->instructivo)
                                <a href="{{ asset('storage/' . $producto->instructivo) }}" target="_blank"
                                    download="Instructivo_{{$producto->code}}"
                                    class="w-full flex justify-center rounded-sm items-center border border-primary-orange text-primary-orange font-bold h-[41px] max-sm:h-[36px] max-sm:text-sm">
                                    {{__("Instructivo")}}
                                </a>
                            @endif

                        </div>

                    </div>
                </div>


                <div class="pt-40 flex flex-row gap-5">
                    <div class="flex flex-col gap-3 w-full">
                        <h2 class="font-semibold text-[32px]">
                            {{request('lang') == 'en' ? $producto->linea->name_en : $producto->linea->name_es}}
                        </h2>
                        <div class="text-[20px] leading-tight">
                            {!! request('lang') == 'en' ? $producto->linea->text_en : $producto->linea->text_es !!}
                        </div>
                    </div>

                    <div class="w-full h-[651px]">
                        <img src="{{ asset("storage/" . $producto->linea->image) }}" alt="{{ $producto->linea->name }}"
                            class="w-full h-full object-cover rounded-tr-[70px] rounded-bl-[70px] ">
                    </div>
                </div>



                <!-- Productos relacionados -->
                <div class="py-20 pt-30 max-sm:py-10">
                    <h2 class="text-[28px] font-bold mb-8 max-sm:text-xl max-sm:mb-6">Productos relacionados</h2>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 max-sm:grid-cols-1 max-sm:gap-4">
                        @forelse($productosRelacionados as $prodRelacionado)
                            <a href="{{ "/productos/" . $prodRelacionado->code }}"
                                class=" 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                min-h-[332px]  flex flex-col w-[288px] max-sm:w-full rounded-sm  border-[#DEDFE0]">
                                <div class="h-full flex flex-col">
                                    @if ($prodRelacionado->imagenes->count() > 0)
                                        <div class="relative min-h-[287px] max-sm:h-[200px]">
                                            <img src="{{ $prodRelacionado->imagenes->first()->image }}"
                                                alt="{{ $prodRelacionado->name }}"
                                                class=" w-full h-full  object-cover rounded-t-sm">
                                            <h2
                                                class="absolute left-3 bottom-2 text-[14px] font-semibold uppercase text-primary-orange">
                                                {{$prodRelacionado->categoria->name ?? ''}}
                                            </h2>
                                        </div>

                                    @else
                                        <div class="relative min-h-[287px] max-sm:h-[200px]">
                                            <img src={{$logos->logo_principal}} alt="{{ $prodRelacionado->name }}"
                                                class=" w-full h-full  object-contain rounded-t-sm">
                                            <h2
                                                class="absolute left-3 bottom-2 text-[14px] font-semibold uppercase text-primary-orange">
                                                {{$prodRelacionado->categoria->name ?? ''}}
                                            </h2>
                                        </div>
                                    @endif

                                    <div class="flex flex-col justify-start   h-full px-1 mt-2">
                                        <h2 class="text-[16px] font-semibold text-primary-orange">{{$prodRelacionado->code}}
                                        </h2>
                                        <p class="overflow-hidden line-clamp-2 text-[20px] font-custom! leading-tight">
                                            {{$prodRelacionado->name}}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-4 py-8 text-center text-gray-500 max-sm:col-span-1 max-sm:py-6">
                                No hay productos relacionados disponibles.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeMainImage(src, thumbnail) {
            const mainImage = document.getElementById('mainImage');

            // Fade out effect
            mainImage.style.opacity = '0';

            // Change image after fade out completes
            setTimeout(() => {
                mainImage.src = src;

                // Fade in the new image
                mainImage.style.opacity = '1';

                // Update thumbnail borders
                document.querySelectorAll('.flex.gap-2 > div').forEach(thumb => {
                    thumb.classList.remove('border-main-color');
                });
                thumbnail.classList.add('border-main-color');
            }, 300);
        }

        // Ensure image is visible on initial load
        document.addEventListener('DOMContentLoaded', () => {
            const mainImage = document.getElementById('mainImage');
            mainImage.style.opacity = '1';
        });
    </script>

    <style>
        #mainImage {
            opacity: 0;
        }
    </style>
@endsection