@extends('layouts.default')

@section('title', 'Contacto -  San Justo Iluminacion')

@section('description', $metadatos->description ?? "")
@section('keywords', $metadatos->keywords ?? "")

@push('head')
    <meta name="description" content="{{ $metadatos->description ?? '' }}">
    <meta name="keywords" content="{{ $metadatos->keywords ?? '' }}">
@endpush

@section('content')

    <div class="mx-auto flex w-full max-w-[1224px] flex-col gap-6 px-4 py-10 md:gap-10 md:px-0 md:py-20">

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path
                                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">¡Éxito!</p>
                        <p class=" text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Mensaje de error general --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path
                                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm1.41-1.41A8 8 0 1 0 15.66 4.34 8 8 0 0 0 4.34 15.66zm9.9-8.49L11.41 10l2.83 2.83-1.41 1.41L10 11.41l-2.83 2.83-1.41-1.41L8.59 10 5.76 7.17l1.41-1.41L10 8.59l2.83-2.83 1.41 1.41z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Error</p>
                        <p class="text-sm">Por favor, revisa los campos del formulario.</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="absolute top-30 left-1/2 w-[1224px] -translate-x-1/2 flex flex-row gap-1 z-100">
            <a href="/" class="text-black font-medium text-[12px]">{{__('Inicio')}}</a>
            <span class="text-black font-medium text-[12px]">/</span>
            <span class="text-black font-medium text-[12px]">{{__('Contacto')}}</span>
        </div>

        <div class="flex flex-col mb-10">
            <h2 class="text-[32px] font-semibold font-custom!">
                {{request('lang') == 'en' ? $contacto->title_en : $contacto->title_es}}</h2>
            <p class="text-[20px]! max-w-[903px]">{!! request('lang') == 'en' ? $contacto->text_en : $contacto->text_es !!}
            </p>
        </div>

        <div class="flex flex-col gap-8 md:flex-row md:gap-0">
            {{-- Contacto info --}}

            <div class="mb-6 flex w-full flex-col gap-4 md:mb-0 md:w-1/3">
                @php
                    $datos = [
                        [
                            'name' => $contacto->location ?? "",
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <path d="M18.3332 9.16667C18.3332 14.6667 10.9998 20.1667 10.9998 20.1667C10.9998 20.1667 3.6665 14.6667 3.6665 9.16667C3.6665 7.22175 4.43912 5.35649 5.81439 3.98122C7.18965 2.60595 9.05492 1.83334 10.9998 1.83334C12.9448 1.83334 14.81 2.60595 16.1853 3.98122C17.5606 5.35649 18.3332 7.22175 18.3332 9.16667Z" stroke="#0992C9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <path d="M11 11.9167C12.5188 11.9167 13.75 10.6854 13.75 9.16666C13.75 7.64788 12.5188 6.41666 11 6.41666C9.48122 6.41666 8.25 7.64788 8.25 9.16666C8.25 10.6854 9.48122 11.9167 11 11.9167Z" stroke="#0992C9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </svg>',
                            'href' => 'https://maps.google.com/?q=' . urlencode($contacto->location)
                        ],
                        [
                            'name' => $contacto->mail ?? "",
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="23" viewBox="0 0 22 23" fill="none">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <path d="M18.3335 3.83333H3.66683C2.65431 3.83333 1.8335 4.69145 1.8335 5.75V17.25C1.8335 18.3085 2.65431 19.1667 3.66683 19.1667H18.3335C19.346 19.1667 20.1668 18.3085 20.1668 17.25V5.75C20.1668 4.69145 19.346 3.83333 18.3335 3.83333Z" stroke="#0992C9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <path d="M20.1668 6.70833L11.9443 12.1708C11.6613 12.3562 11.3341 12.4545 11.0002 12.4545C10.6662 12.4545 10.339 12.3562 10.056 12.1708L1.8335 6.70833" stroke="#0992C9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </svg>',
                            'href' => 'mailto:' . $contacto->mail ?? ''
                        ],
                        [
                            'name' => $contacto->phone ?? "",
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <g clip-path="url(#clip0_9428_3266)">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <path d="M11.5265 13.8067C11.6986 13.8857 11.8925 13.9038 12.0762 13.8579C12.26 13.812 12.4226 13.7049 12.5373 13.5542L12.8332 13.1667C12.9884 12.9597 13.1897 12.7917 13.4211 12.676C13.6526 12.5602 13.9078 12.5 14.1665 12.5H16.6665C17.1085 12.5 17.5325 12.6756 17.845 12.9882C18.1576 13.3007 18.3332 13.7246 18.3332 14.1667V16.6667C18.3332 17.1087 18.1576 17.5326 17.845 17.8452C17.5325 18.1577 17.1085 18.3333 16.6665 18.3333C12.6883 18.3333 8.87295 16.753 6.0599 13.9399C3.24686 11.1269 1.6665 7.31158 1.6665 3.33333C1.6665 2.8913 1.8421 2.46738 2.15466 2.15482C2.46722 1.84226 2.89114 1.66667 3.33317 1.66667H5.83317C6.2752 1.66667 6.69912 1.84226 7.01168 2.15482C7.32424 2.46738 7.49984 2.8913 7.49984 3.33333V5.83333C7.49984 6.09207 7.43959 6.34726 7.32388 6.57869C7.20817 6.81011 7.04016 7.01142 6.83317 7.16667L6.44317 7.45917C6.29018 7.57598 6.18235 7.74215 6.138 7.92946C6.09364 8.11676 6.11549 8.31364 6.19984 8.48666C7.33874 10.7999 9.21186 12.6707 11.5265 13.8067Z" stroke="#0992C9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              </g>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <defs>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <clipPath id="clip0_9428_3266">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <rect width="20" height="20" fill="white"/>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </clipPath>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              </defs>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </svg>',
                            'href' => 'tel:' . preg_replace('/\s+/', '', $contacto->phone)
                        ],


                    ];
                @endphp
                <h2 class="text-[26px] font-semibold font-custom!">{{__("Dónde podés encontrarnos")}}</h2>
                @foreach ($datos as $dato)
                    <a href="{{ $dato['href'] }}" target="_blank"
                        class="flex flex-row items-center gap-3 transition-opacity hover:opacity-80">
                        {!! $dato['icon'] !!}
                        <p class="text-base ">{{ $dato['name'] }}
                        </p>
                    </a>
                @endforeach
            </div>

            {{-- Formulario --}}
            <form id="contactForm" method="POST" action="{{ route('send.contact') }}"
                class="grid w-full grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-x-5 sm:gap-y-10 md:w-2/3">
                @csrf
                <div class="flex flex-col gap-2 sm:gap-3">
                    <label for="name" class="text-base ">{{__("Nombre")}} *</label>
                    <input required type="text" name="name" id="name"
                        class="h-[44px] w-full border border-[#EEEEEE] pl-3 rounded-sm" value="{{ old('name') }}">
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-2 sm:gap-3">
                    <label for="apellido" class="text-base ">{{__("Apellido")}} *</label>
                    <input required type="text" name="apellido" id="apellido"
                        class="h-[44px] w-full border border-[#EEEEEE] pl-3 rounded-sm" value="{{ old('apellido') }}">
                    @error('apellido') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-2 sm:gap-3">
                    <label for="telefono" class="text-base ">{{__("Empresa / Ocupación")}} *</label>
                    <input required type="text" name="empresa" id="empresa"
                        class="h-[44px] w-full border border-[#EEEEEE] pl-3 rounded-sm" value="{{ old('empresa') }}">
                    @error('empresa') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-2 sm:gap-3">
                    <label for="email" class="text-base ">{{__("Correo electrónico")}} *</label>
                    <input required type="text" name="email" id="email"
                        class="h-[44px] w-full border border-[#EEEEEE] pl-3 rounded-sm" value="{{ old('email') }}">
                    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-2 sm:gap-3">
                    <label for="telefono" class="text-base ">{{__("Telefono")}} *</label>
                    <input required type="text" name="telefono" id="telefono"
                        class="h-[44px] w-full border border-[#EEEEEE] pl-3 rounded-sm" value="{{ old('telefono') }}">
                    @error('telefono') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-2 sm:gap-3">
                    <label for="como_llegaste" class="text-base ">{{__("¿Cómo llegaste a nosotros?")}} *</label>
                    <select class="h-[44px] w-full border border-[#EEEEEE] pl-3 rounded-sm" name="como_llegaste"
                        id="como_llegaste">
                        <option value="">{{__("Seleccione una opción")}}</option>
                        <option value="buscador">{{__("Buscador")}}</option>
                        <option value="redes_sociales">{{__("Redes Sociales")}}</option>
                        <option value="recomendacion">{{__("Recomendación")}}</option>
                        <option value="otro">{{__("Otro")}}</option>
                    </select>
                    @error('como_llegaste') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-2  sm:gap-3 col-span-2">
                    <label for="mensaje" class="text-base ">{{__("Comentario")}} </label>
                    <textarea required name="mensaje" id="mensaje"
                        class="h-[150px] w-full border border-[#EEEEEE] pt-2 pl-3 rounded-sm">{{ $mensaje ? "Buenas tardes queria recibir informacion acerca de " . $mensaje : '' }}</textarea>
                    @error('mensaje') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>


                <p class="text-base ">*{{__("Campos obligatorios")}}</p>
                <button form="contactForm" type="submit"
                    class="bg-primary-orange text-bold min-h-[41px] w-full text-[16px] text-white rounded-sm">{{__("Enviar")}}</button>

            </form>
        </div>

        {{-- Mapa --}}

    </div>



    <div class=" w-full">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3273.4154200822118!2d-58.667692900000006!3d-34.8709133!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcc7765b66b581%3A0xbd9833c2577c9817!2sSan%20Justo%20Iluminaci%C3%B3n!5e0!3m2!1ses-419!2sar!4v1757606049575!5m2!1ses-419!2sar"
            class="w-full h-[500px] rounded-sm" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <script>
        // Auto-cerrar mensaje después de 5 segundos
        setTimeout(function () {
            const successAlert = document.querySelector('.bg-green-100');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
        }, 5000);
    </script>
@endsection