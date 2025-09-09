<div style="background-image: url({{$homeInfo->image_seccion_dos}})"
    class="w-full flex items-center h-[520px] bg-no-repeat bg-cover bg-center">
    <div class="h-[218px] bg-black/60 flex flex-col justify-center gap-3 w-full items-center">
        <h2 class="text-[32px] font-semibold font-custom! text-white leading-tight">
            {{request('lang') == 'en' ? $homeInfo->title_seccion_dos_en : $homeInfo->title_seccion_dos_es}}
        </h2>
        <p class="text-[20px] text-white max-w-[642px] text-center leading-tight">
            {{request('lang') == 'en' ? $homeInfo->text_seccion_dos_en : $homeInfo->text_seccion_dos_es}}
        </p>
        <a href="#"
            class="flex items-center justify-center text-[14px] text-white font-medium py-2 px-3 bg-primary-orange rounded-sm">{{__("CONOCENOS")}}</a>
    </div>
</div>