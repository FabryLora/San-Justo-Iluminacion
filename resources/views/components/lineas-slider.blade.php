<div class="py-16">
    <div class="flex flex-col gap-9 max-w-[90%] lg:max-w-[1224px] mx-auto">
        <div class="flex ">
            <h2 class="text-[32px] font-semibold font-custom! text-left text-black">
                {{request('lang') == 'en' ? $titulo->title_en : $titulo->title_es}}
            </h2>
        </div>
        <div class="relative" x-data="{
            activeSlide: 0,
            totalSlides: 0,
            autoSlideInterval: null,
            isMobile: window.innerWidth < 1024,
            lineasCount: {{ count($lineas) }},
        
            init() {
                this.calculateTotalSlides();
                this.startAutoSlide();
        
                // Actualizar cuando cambie el tamaño de la ventana
                window.addEventListener('resize', () => {
                    this.isMobile = window.innerWidth < 1024;
                    this.calculateTotalSlides();
                    this.activeSlide = 0; // Reiniciar a la primera diapositiva al cambiar de tamaño
                    this.stopAutoSlide();
                    this.startAutoSlide();
                });
            },
        
            calculateTotalSlides() {
                if (this.isMobile) {
                    this.totalSlides = this.lineasCount;
                } else {
                    this.totalSlides = Math.ceil(this.lineasCount / 3);
                }
                console.log('Total slides:', this.totalSlides, 'Is mobile:', this.isMobile);
            },
        
            startAutoSlide() {
                if (this.totalSlides <= 1) return; // No iniciar si solo hay 1 slide
        
                this.autoSlideInterval = setInterval(() => {
                    this.nextSlide();
                }, this.isMobile ? 3000 : 5000);
            },
        
            stopAutoSlide() {
                if (this.autoSlideInterval) {
                    clearInterval(this.autoSlideInterval);
                    this.autoSlideInterval = null;
                }
            },
        
            nextSlide() {
                if (this.totalSlides <= 1) return;
        
                this.activeSlide = this.activeSlide + 1;
                if (this.activeSlide >= this.totalSlides) {
                    this.activeSlide = 0;
                }
                console.log('Next slide:', this.activeSlide, 'of', this.totalSlides);
            },
        
            prevSlide() {
                if (this.totalSlides <= 1) return;
        
                this.activeSlide = this.activeSlide - 1;
                if (this.activeSlide < 0) {
                    this.activeSlide = this.totalSlides - 1;
                }
            },
        
            goToSlide(index) {
                if (index >= 0 && index < this.totalSlides) {
                    this.activeSlide = index;
                }
            }
        }" @mouseover="stopAutoSlide()" @mouseleave="startAutoSlide()">

            <!-- Carrusel de clientes -->
            <div class="relative">
                <!-- Versión para escritorio (oculta en móvil) -->
                <div class="hidden lg:block overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out"
                        :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">

                        @php
                            $chunkedLineas = $lineas->chunk(3);
                        @endphp

                        @foreach ($chunkedLineas as $chunk)
                            <div class="grid grid-cols-3 justify-between gap-6 min-w-full">
                                @foreach ($chunk as $linea)
                                    <div class="w-[392px] h-[554px] flex flex-col justify-between">
                                        <div
                                            class="w-[392px] min-h-[392px] rounded-tl-[36px] rounded-br-[36px] overflow-hidden">
                                            <img src="{{ asset("storage/" . $linea->image) }}" alt="cliente"
                                                class="w-full h-full object-cover ">
                                        </div>
                                        <div class="flex flex-col h-full pt-5">
                                            <h2 class="text-[24px] font-medium">
                                                {{request('lang') == 'en' ? $linea->name_en : $linea->name_es}}
                                            </h2>
                                            <div class="text-[15px] font-light line-clamp-2 overflow-hidden">
                                                {!! request('lang') == 'en' ? $linea->text_en : $linea->text_es !!}
                                            </div>
                                        </div>
                                        <a class="flex flex-row gap-2 items-center font-medium text-[16px]"
                                            href="/productos?linea={{ $linea->id }}">{{__("Ver productos")}} <span><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 16 16" fill="none">
                                                    <path d="M8 0L6.59 1.41L12.17 7H0V9H12.17L6.59 14.59L8 16L16 8L8 0Z"
                                                        fill="black" />
                                                </svg></span></a>
                                    </div>
                                @endforeach

                                <!-- Agrega divs vacíos para mantener la estructura si hay menos de 3 items en el chunk -->
                                @for ($i = count($chunk); $i < 3; $i++)
                                    <div class="w-[392px] h-[554px]"></div>
                                @endfor
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Versión para móvil (oculta en escritorio) -->
                <div class="lg:hidden overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out"
                        :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">

                        @foreach ($lineas as $linea)
                            <div class="min-w-full flex justify-center">
                                <div class="max-h-[190px] max-w-[300px] w-full bg-white">
                                    <img src="{{ asset("storage/" . $linea->image) }}" alt="cliente"
                                        class="w-full h-full object-cover transition-all duration-300 filter lg:grayscale hover:grayscale-0">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Indicadores de paginación con forma de barras -->
            <template x-if="totalSlides > 1">
                <div class="flex justify-center space-x-2 mt-16">
                    <template x-for="(slide, index) in Array.from({length: totalSlides})" :key="index">
                        <button @click="goToSlide(index)"
                            :class="{ 'bg-gray-800': activeSlide === index, 'bg-gray-300': activeSlide !== index }"
                            class="w-10 h-1.5 rounded-full cursor-pointer transition-colors duration-300 hover:bg-gray-600"></button>
                    </template>
                </div>
            </template>
        </div>
    </div>
</div>