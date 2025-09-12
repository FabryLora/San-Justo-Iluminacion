<div class="w-full h-[376px] bg-[#F2EEED] flex items-center justify-center">
    <div class="flex flex-col gap-5">
        <h2 class="text-[32px] font-semibold font-custom!">
            {{request('lang') == 'en' ? $titulo->title_en : $titulo->title_es}}
        </h2>
        <div class="grid grid-cols-2 gap-12">
            @foreach ($catalogos as $catalogo)
                <div class="bg-white h-[214px] max-w-[392px] rounded-tl-[36px] rounded-br-[36px] flex flex-col  gap-5 p-6">
                    <h3 class="text-[20px] font-bold">{{request('lang') == 'en' ? $catalogo->name_en : $catalogo->name_es}}
                    </h3>
                    <p>{{request('lang') == 'en' ? $catalogo->subtitle_en : $catalogo->subtitle_es}}</p>
                    <div class="flex flex-row gap-6">
                        <a href="{{ "storage/" . $catalogo->archivo }}" target="_blank"
                            class="text-[14px] w-[156px] h-[42px] font-medium border border-primary-orange  rounded-sm text-primary-orange hover:bg-primary-orange hover:text-white transition duration-300 flex items-center justify-center">
                            {{__("VER ONLINE")}}
                        </a>
                        <a href="{{ asset("storage/" . $catalogo->archivo) }}"
                            download="{{ request('lang') == 'en' ? $catalogo->name_en : $catalogo->name_es  }}"
                            class="text-[14px]  text-white font-medium bg-primary-orange w-[156px] h-[42px] rounded-sm hover:border hover:border-primary-orange hover:bg-transparent hover:text-primary-orange transition duration-300 flex items-center justify-center">
                            {{__("DESCARGAR")}}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>