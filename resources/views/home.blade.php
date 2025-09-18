@extends('layouts.default')

@section('title', 'San Justo Iluminación')

@section('description', $metadatos->description ?? "")
@section('keywords', $metadatos->keywords ?? "")

@section('content')
    <x-banner-portada :homeInfo="$homeInfo" />
    <x-espacios :espaciosHome="$espaciosHome" :titulo="collect($titulos)->firstWhere('seccion', 'espacios')" />
    <x-seccion-uno :homeInfo="$homeInfo" />
    @if ($catalogos->count() > 0)
        <x-catalogos :catalogos="$catalogos" :titulo="collect($titulos)->firstWhere('seccion', 'catalogos')" />
    @endif
    <x-lineas-slider :lineas="$lineas" :titulo="collect($titulos)->firstWhere('seccion', 'lineas')" />
    <x-seccion-dos :homeInfo="$homeInfo" />
    <x-seccion-tres :homeInfo="$homeInfo" />
    <x-clientes-slider :clientes="$clientes" :titulo="collect($titulos)->firstWhere('seccion', 'marcas')" />

    <!-- Contenedor para el formulario modal -->
    <div id="dailyFormModal" class="hidden fixed inset-0 bg-black/50 z-[9999] flex justify-center items-center">
        <div class="bg-white  w-[857px] flex flex-row relative h-[493px] overflow-y-auto shadow-2xl">
            <button id="closeFormModal"
                class="absolute top-4 right-5 bg-transparent border-none text-2xl cursor-pointer text-gray-600 hover:text-gray-800 transition-colors duration-200">
                &times;
            </button>
            <div class="w-full justify-center flex items-center" id="formContainer"></div>
            <div class="w-full">
                <img src="{{asset('images/form-image.jpg')}}" class="w-full h-full object-cover" alt="">
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function shouldShowDailyForm() {
                const lastVisit = localStorage.getItem('sanjusto_last_visit');
                const today = new Date().toDateString();

                if (!lastVisit || lastVisit !== today) {
                    localStorage.setItem('sanjusto_last_visit', today);
                    return true;
                }
                return false;
            }

            function loadBitrixForm() {
                // Crear el script del formulario
                const formScript = document.createElement('script');
                formScript.setAttribute('data-b24-form', 'inline/8/akv4xt');
                formScript.setAttribute('data-skip-moving', 'true');

                // Función para cargar el formulario
                (function (w, d, u) {
                    var s = d.createElement('script');
                    s.async = true;
                    s.src = u + '?' + (Date.now() / 180000 | 0);
                    var h = d.getElementsByTagName('script')[0];
                    h.parentNode.insertBefore(s, h);
                })(window, document, 'https://cdn.bitrix24.es/b7493823/crm/form/loader_8.js');

                // Agregar el script al contenedor del formulario
                document.getElementById('formContainer').appendChild(formScript);
            }

            function showModal() {
                const modal = document.getElementById('dailyFormModal');
                modal.style.display = 'flex';

                // Cargar el formulario de Bitrix24
                loadBitrixForm();
            }

            function hideModal() {
                const modal = document.getElementById('dailyFormModal');
                modal.style.display = 'none';
            }

            // Event listener para cerrar el modal
            document.getElementById('closeFormModal').addEventListener('click', hideModal);

            // Cerrar modal al hacer click fuera del contenido
            document.getElementById('dailyFormModal').addEventListener('click', function (e) {
                if (e.target === this) {
                    hideModal();
                }
            });

            // Verificar si debe mostrar el formulario
            if (shouldShowDailyForm()) {
                // Mostrar el modal después de un pequeño delay para que la página cargue
                setTimeout(showModal, 1000);
            }
        });
    </script>

@endsection