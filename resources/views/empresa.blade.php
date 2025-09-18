@extends('layouts.default')

@section('title', 'Nosotros - San Justo Iluminacion')

@section('description', $metadatos->description ?? "")
@section('keywords', $metadatos->keywords ?? "")

@section('content')
    <div class="relative w-full h-[559px]">
        <div class="absolute top-5 left-1/2 w-[1224px] -translate-x-1/2 flex flex-row gap-1 z-100">
            <a href="/" class="text-white font-medium text-[12px]">{{__('Inicio')}}</a>
            <span class="text-white font-medium text-[12px]">/</span>
            <span class="text-white font-medium text-[12px]">{{__('Nosotros')}}</span>
        </div>
        <div class="w-full h-full ">
            @php $ext = pathinfo($banner->media, PATHINFO_EXTENSION); @endphp
            @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                <img src="{{ asset($banner->media) }}" alt="Slider Image" class="w-full h-full object-cover"
                    data-duration="6000">
            @elseif (in_array($ext, ['mp4', 'webm', 'ogg']))
                <video class="w-full h-full object-cover object-center" autoplay loop muted onended="nextSlide()">
                    <source src="{{ asset($banner->media) }}" type="video/{{ $ext }}">
                    {{ __('Tu navegador no soporta el formato de video.') }}
                </video>
            @endif
        </div>
    </div>

    <div class="w-[1224px] mx-auto py-15 flex flex-col gap-10">
        @foreach ($secciones as $seccion)
            <div class="flex flex-row  {{ $loop->even ? 'flex-row-reverse' : '' }}">
                <div
                    class="w-full {{ $loop->even ? 'rounded-tr-[70px] rounded-bl-[70px]' : 'rounded-tl-[70px] rounded-br-[70px]' }} h-[440px] overflow-hidden">
                    <img src="{{$seccion->image}}" class="w-full h-full object-cover" alt="">
                </div>
                <div class="w-full flex flex-col px-10 py-4 gap-5">
                    <h2 class="text-[32px] font-semibold font-custom! leading-tight max-w-[560px]">
                        {{request('lang') == 'en' ? $seccion->name_en : $seccion->name_es}}
                    </h2>
                    <div class="text-[20px]! max-w-[560px]! break-words">
                        {!! request('lang') == 'en' ? $seccion->text_en : $seccion->text_es !!}
                    </div>
                </div>
            </div>
        @endforeach
        <div class="flex flex-col gap-5">
            <h2 class="font-semibold text-[32px] font-custom!">{{__('Como hacemos las cosas')}}</h2>
            <div class="grid grid-cols-4 gap-5">
                @foreach ($tarjetas as $tarjeta)
                    <div class="flex flex-col h-[278px] pt-6 border rounded-sm items-center px-4  ">
                        <div class="h-[66px]">
                            <img class="w-full h-full object-cover" src="{{ $tarjeta->image }}" alt="">
                        </div>
                        <h2 class="text-[20px] text-center font-semibold font-custom! py-4">
                            {{request('lang') == 'en' ? $tarjeta->name_en : $tarjeta->name_es}}
                        </h2>
                        <div class="text-[16px]! text-center! break-words w-full">
                            {!! request('lang') == 'en' ? $tarjeta->text_en : $tarjeta->text_es !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>





@endsection