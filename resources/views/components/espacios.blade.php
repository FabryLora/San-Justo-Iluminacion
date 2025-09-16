<div class="flex flex-col w-[1224px] mx-auto mt-10">
    {{-- Buscar el titulo con las seccion "espacios" --}}
    <h2 class="text-[32px] font-semibold font-custom! mb-6">
        {{request('lang') == 'en' ? $titulo->title_en : $titulo->title_es  }}
    </h2>
    <div class="flex flex-row w-full gap-6">
        @foreach ($espacios as $espacio)
            <div x-data="{ isHovered: false }" @mouseenter="isHovered = true" @mouseleave="isHovered = false"
                style="background-image: url('{{ asset("storage/" . $espacio->image) }}');"
                class="w-[600px] h-[390px] rounded-bl-[70px] rounded-tr-[70px] overflow-hidden relative bg-no-repeat bg-center bg-cover">
                <div class="absolute  -left-[153px] rounded-[50px] rotate-[-16.63deg] bg-primary-orange w-[777px] h-[282px] transition-all duration-300"
                    :class="isHovered ? 'top-[280px]' : 'top-[380px]'">
                    <div class="relative w-full h-full">
                        <h2
                            class="absolute rotate-[16.63deg] top-8 right-8 text-[32px] text-white font-semibold font-custom!">
                            {{ request('lang') == 'en' ? $espacio->name_en : $espacio->name_es }}
                        </h2>

                    </div>
                </div>
                <a href="/productos?espacio={{ $espacio->id }}"
                    class="absolute rounded-sm bottom-12 right-12 text-[14px] font-medium px-3 py-2 bg-white text-primary-orange transition-all duration-300"
                    :class="isHovered ? 'opacity-100' : 'opacity-0'">
                    {{__('VER TODA LA COLECCION')}}
                </a>
            </div>
        @endforeach
    </div>

</div>