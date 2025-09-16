<div class="flex justify-between gap-6 py-10">

    <div class="w-full overflow-hidden rounded-tl-[70px] rounded-br-[70px] max-h-[440px] border">
        <img class="h-full w-full object-cover" src="{{$homeInfo->image_seccion_uno}}" alt="">
    </div>

    <div class="w-full flex flex-col items-start gap-5 py-5">
        <h2 class="text-[32px] font-semibold font-custom! max-w-[569px]">
            {{request('lang') == 'en' ? $homeInfo->title_seccion_uno_en : $homeInfo->title_seccion_uno_es}}
        </h2>
        <p class="max-w-[569px]">
            {{request('lang') == 'en' ? $homeInfo->text_seccion_uno_en : $homeInfo->text_seccion_uno_es}}
        </p>
        <a href="/trabaja-con-nosotros"
            class="flex justify-center items-center w-[280px] h-[42px] bg-primary-orange rounded-sm font-medium text-[14px] text-white">{{__("DESCUBRI COMO TRABAJAMOS")}}</a>
    </div>

</div>