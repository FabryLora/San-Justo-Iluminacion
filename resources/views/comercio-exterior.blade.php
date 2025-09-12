@extends('layouts.default')

@section('title', 'Calidad - San Justo Iluminacion')

@section('description', $metadatos->description ?? "")
@section('keywords', $metadatos->keywords ?? "")

@section('content')
    <div class="absolute top-30 left-1/2 w-[1224px] -translate-x-1/2 flex flex-row gap-1 z-100">
        <a href="/" class="text-black font-medium text-[12px]">{{__('Inicio')}}</a>
        <span class="text-black font-medium text-[12px]">/</span>
        <span class="text-black font-medium text-[12px]">{{__('Comercio exterior')}}</span>
    </div>
    <div class="mx-auto flex w-full max-w-[1224px] flex-col gap-6 px-4 py-10 md:gap-10 md:px-0 md:py-20">
        <div class="flex flex-col mb-10">
            <h2 class="text-[32px] font-semibold font-custom!">
                {{request('lang') == 'en' ? $comercio->title_seccion_uno_en : $comercio->title_seccion_uno_es}}
            </h2>
            <p class="text-[20px]! max-w-[903px]">
                {!! request('lang') == 'en' ? $comercio->text_seccion_uno_en : $comercio->text_seccion_uno_es !!}
            </p>
        </div>

        <div class="flex flex-row  ">
            <div class="w-full rounded-tl-[70px] rounded-br-[70px] h-[440px] overflow-hidden">
                <img src="{{$comercio->image_seccion_dos}}" class="w-full h-full object-cover" alt="">
            </div>
            <div class="w-full flex flex-col px-10 py-4 gap-5">
                <h2 class="text-[32px] font-semibold font-custom! leading-tight max-w-[560px]">
                    {{request('lang') == 'en' ? $comercio->title_seccion_dos_en : $comercio->title_seccion_dos_es}}
                </h2>
                <div class="text-[20px]! max-w-[560px]! break-words">
                    {!! request('lang') == 'en' ? $comercio->text_seccion_dos_en : $comercio->text_seccion_dos_es !!}
                </div>
            </div>
        </div>

        <div class="flex flex-row  ">
            <div class="w-full rounded-tl-[70px] rounded-br-[70px] h-[440px] overflow-hidden">
                <img src="{{$comercio->image_seccion_tres}}" class="w-full h-full object-cover" alt="">
            </div>
            <div class="w-full flex flex-col px-10 py-4 gap-5">
                <h2 class="text-[32px] font-semibold font-custom! leading-tight max-w-[560px]">
                    {{request('lang') == 'en' ? $comercio->title_seccion_tres_en : $comercio->title_seccion_tres_es}}
                </h2>
                <div class="text-[20px]! max-w-[560px]! break-words">
                    {!! request('lang') == 'en' ? $comercio->text_seccion_tres_en : $comercio->text_seccion_tres_es !!}
                </div>
            </div>
        </div>
    </div>
@endsection