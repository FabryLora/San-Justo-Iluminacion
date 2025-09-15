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
    </div>

    <div class="h-fit py-10 bg-[#F2EEED]">
        <div class="w-[1224px] mx-auto">
            <h2 class="text-[32px] font-semibold font-custom! pb-5">{{__("¿Qué ofrecemos al canal internacional?")}}</h2>

            <!-- Primera fila: 3 tarjetas -->
            <div class="flex w-full justify-center">
                <div class="grid grid-cols-3 gap-x-20 gap-y-5 w-fit">
                    @foreach ($tarjetas->take(3) as $tarjeta)
                        <div
                            class="flex flex-col h-[350px] py-8 border rounded-sm items-center px-4 justify-between bg-white max-w-[288px] mx-auto">
                            <div class="h-[66px] my-4">
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

                    <!-- Segunda fila: 2 tarjetas centradas -->
                    @if($tarjetas->count() > 3)
                        <div class="col-span-3 flex justify-center gap-x-20">
                            @foreach ($tarjetas->skip(3)->take(2) as $tarjeta)
                                <div
                                    class="flex flex-col h-[341px] py-8 border rounded-sm items-center px-4 justify-between bg-white max-w-[288px]">
                                    <div class="h-[66px] my-4">
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
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div class="mx-auto flex w-full max-w-[1224px] flex-col gap-6 px-4 py-10 md:gap-10 md:px-0 md:py-20">
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
                <div class="flex flex-row gap-4">
                    <div class="w-[68px] h-[68px]">
                        <img src="{{ $comercio->image_seccion_tres_dos }}" class="w-full h-full object-contain" alt="">
                    </div>
                    <div class="w-[68px] h-[68px]">
                        <img src="{{ $comercio->image_seccion_tres_tres }}" class="w-full h-full object-contain" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-seccion-tres :homeInfo="$homeInfo" />

    <x-clientes-slider :clientes="$clientes" :titulo="$titulo" />

@endsection