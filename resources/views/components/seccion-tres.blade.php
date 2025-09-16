<div class="w-[1224px] mx-auto flex flex-row gap-5 py-9">
    <div class="w-full ">
        <div class="flex flex-col gap-8 pt-16">
            <h2 class="font-semibold text-[32px] font-custom! max-w-[450px] break-words leading-tight">
                {{request('lang') == 'en' ? $homeInfo->title_seccion_tres_en : $homeInfo->title_seccion_tres_es}}
            </h2>
            <p class="text-[20px] max-w-[528px]">
                {!!request('lang') == 'en' ? $homeInfo->text_seccion_tres_en : $homeInfo->text_seccion_tres_es !!}
            </p>
            <a href="/trabaja-con-nosotros"
                class="text-[14px] font-medium h-[42px] border max-w-[225px] rounded-sm border-primary-orange text-primary-orange">{{__("TRABAJA CON NOSOTROS")}}</a>
        </div>
    </div>
    <div class="w-full">
        <script data-b24-form="inline/1/c7h29z" data-skip-moving="true">
            (function (w, d, u) {
                var s = d.createElement('script'); s.async = true; s.src = u + '?' + (Date.now() / 180000 | 0);
                var h = d.getElementsByTagName('script')[0]; h.parentNode.insertBefore(s, h);
            })(window, document, 'https://cdn.bitrix24.es/b7493823/crm/form/loader_1.js');
        </script>
    </div>
</div>