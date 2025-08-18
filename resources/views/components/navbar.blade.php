@php
    $location = request()->path();
    $isHome = $location === '/';
    $isPrivate = str_contains($location, 'privada');

    $defaultLinks = [

        ['title' => 'PRODUCTOS', 'href' => '/productos'],
        ['title' => 'NOSOTROS', 'href' => '/nosotros'],
        ['title' => 'TRABAJÁ CON NOSOTROS', 'href' => '/calidad'],
        ['title' => 'DONDE COMPRAR', 'href' => '/novedades'],
        ['title' => 'COMERCIO EXTERIOR', 'href' => '/contacto'],
        ['title' => 'CONTACTO', 'href' => '/contacto'],
    ];
    $privateLinks = [
        ['title' => 'Productos', 'href' => '/privada/productos'],
        ['title' => 'Carrito', 'href' => '/privada/carrito'],
        ['title' => 'Mis pedidos', 'href' => '/privada/mispedidos'],
        ['title' => 'Lista de precios', 'href' => '/privada/listadeprecios'],
    ];
@endphp

<div x-data="{
        showModal: false,
        modalType: 'login',
        scrolled: false,
        searchOpen: false,
        mobileMenuOpen: false,
        logoPrincipal: '{{ $logos->logo_principal ?? '' }}',
        logoSecundario: '{{ $logos->logo_secundario ?? '' }}',
        switchToLogin() {
            this.modalType = 'login';
        },
        switchToRegister() {
            this.modalType = 'register';
        },
        openModal(type = 'login') {
            this.modalType = type;
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        toggleMobileMenu() {
            this.mobileMenuOpen = !this.mobileMenuOpen;
        }
    }" x-init="
        @if ($isHome)
            window.addEventListener('scroll', () => {
                scrolled = window.scrollY > 0;
            });
        @else
            scrolled = true;
        @endif
    " :class="{
        'bg-white shadow-md': scrolled || !{{ $isHome ? 'true' : 'false' }},
        'bg-transparent': !scrolled && {{ $isHome ? 'true' : 'false' }},
        'fixed top-0': {{ $isHome ? 'true' : 'false' }},
        'sticky top-0': {{ $isHome ? 'false' : 'true' }}
    }" class="z-50 sticky top-0 w-full transition-colors duration-300 h-[100px] max-sm:h-auto flex flex-col">

    <!-- Franja superior -->

    <!-- Contenido principal navbar -->
    <div class="mx-auto flex h-[96px] w-[1224px] items-center justify-between">
        <!-- Logo -->
        <div class="flex flex-row items-end h-fit gap-10 w-full justify-between">

            <a class="min-w-[258px] min-h-[57px] " href="/">
                <img class="w-full h-full object-contain" :src="scrolled ? logoSecundario : logoPrincipal" alt="Logo" />
            </a>



            <!-- Navegación desktop -->
            <div class="flex flex-col items-end justify-between text-white leading-none h-full gap-5 max-w-full">
                <div class="flex flex-row gap-4 items-center shrink-0" :class="scrolled ? 'text-black' : 'text-white'">
                    <p class="m-0 leading-none">en</p>
                    <span>|</span>
                    <button class="border  rounded-sm  text-[14px] leading-none w-[136px] h-[42px]"
                        :class="scrolled ? 'border-black text-black' : 'border-white text-white'">
                        ÁREA CLIENTE
                    </button>
                </div>
                <div class="flex gap-6 items-end flex-wrap">
                    @foreach(($isPrivate ? $privateLinks : $defaultLinks) as $link)
                        <a href="{{ $link['href'] }}" :class="scrolled ? 'text-black' : 'text-white'"
                            class="text-[15px] max-xl:text-[15px] font-normal hover:text-primary-orange transition-colors duration-300 whitespace-nowrap leading-none {{ Request::is(ltrim($link['href'], '/')) ? 'font-bold' : '' }}">
                            {{ $link['title'] }}
                        </a>
                    @endforeach
                </div>
            </div>

        </div>





    </div>

    <!-- Menú móvil -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="lg:hidden absolute w-full bg-white border-t border-gray-200 shadow-lg z-40"
        @click.away="mobileMenuOpen = false">
        <div class="py-2 max-h-[calc(100vh-60px)] overflow-y-auto">
            @foreach(($isPrivate ? $privateLinks : $defaultLinks) as $link)
                <a href="{{ $link['href'] }}"
                    class="block px-4 py-3 max-sm:px-3 max-sm:py-2 text-sm max-sm:text-xs text-gray-700 hover:bg-gray-50 hover:text-primary-orange transition-colors duration-300 border-b border-gray-100 last:border-b-0
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            {{ Request::is(ltrim($link['href'], '/')) ? 'font-bold bg-orange-50 text-primary-orange' : '' }}"
                    @click="mobileMenuOpen = false">
                    {{ $link['title'] }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Overlay del modal -->
    <div x-show="showModal" x-transition.opacity x-cloak class="fixed inset-0 bg-black/50 z-50" @click="closeModal()">
    </div>





</div>