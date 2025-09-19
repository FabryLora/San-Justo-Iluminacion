<?php

use App\Http\Controllers\ContactoController;
use App\Http\Controllers\DescargarArchivo;
use App\Http\Controllers\HomePages;
use App\Http\Controllers\NovedadesController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PuntoVentaController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SendContactInfoController;
use App\Http\Controllers\TrabajaConNosotrosController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



// routes/web.php
Route::middleware(['LocaleMiddleware'])->group(function () {
    Route::get('/', [HomePages::class, 'home'])->name('home');
    Route::get('/nosotros', [HomePages::class, 'nosotros'])->name('nosotros');
    Route::get('/trabaja-con-nosotros', [HomePages::class, 'trabajaConNosotros'])->name('trabaja.con.nosotros');
    Route::get('/comercio-exterior', [HomePages::class, 'comercioExterior'])->name('comercio.exterior');
    Route::get('/recursos', [HomePages::class, 'recursos'])->name('recursos');
    Route::get('/donde-comprar', [PuntoVentaController::class, 'index'])->name('donde.comprar');
    // En tu archivo web.php o routes/web.php
    Route::get('/api/usos-by-espacio', [ProductoController::class, 'getUsosByEspacio'])->name('api.usos.by.espacio');
    Route::get('/api/ambientes-by-linea', [ProductoController::class, 'getAmbientesByLinea'])->name('api.ambientes.by.linea');

    Route::get('/calidad', [HomePages::class, 'calidad'])->name('calidad');
    Route::get('/novedades', [HomePages::class, 'novedades'])->name('novedades');
    Route::get('/contacto', [HomePages::class, 'contacto'])->name('contacto');
    Route::get('/novedades/{id}', [NovedadesController::class, 'novedadesShow'])->name('novedades');
    Route::post('/contacto/sendemail', [ContactoController::class, 'sendContact'])->name('send.contact');
    Route::post('/trabaja-con-nosotros/enviar', [TrabajaConNosotrosController::class, 'mandarMail'])->name('trabaja.enviar');
    # ---------------------- Rutas de zona pública ---------------------- #
    Route::get('/donde-comprar', [PuntoVentaController::class, 'index'])->name('donde-comprar.index');
    Route::get('/donde-comprar/api', [PuntoVentaController::class, 'api'])->name('donde-comprar.api');
    Route::get('/donde-comprar/localidades', [PuntoVentaController::class, 'getLocalidades'])->name('donde-comprar.localidades');


    Route::get('/productos', [ProductoController::class, 'indexVistaPrevia'])->name('productos');
    Route::get('/productos/{id}', [ProductoController::class, 'show'])->name('producto.show');
    Route::get('/busqueda', [ProductoController::class, 'SearchProducts'])->name('searchproducts');
});



# ------------------------------------------------------------------- #
// Ruta para la API de búsqueda (AJAX)
Route::post('/api/search', [SearchController::class, 'search'])
    ->name('api.search');

// Ruta para la página de resultados completos
Route::get('/buscar', [SearchController::class, 'searchPage'])
    ->name('search.results');






Route::get('/fix-images', [ProductoController::class, 'fixImagePath'])->name('fix.images');

Route::get('/imagenes-prod', [ProductoController::class, 'imagenesProducto']);
Route::get('/agregar-marca', [ProductoController::class, 'agregarMarca']);



// routes/web.php
Route::get('/descargar/archivo/{id}', [DescargarArchivo::class, 'descargarArchivo'])
    ->name('descargar.archivo');



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render(component: 'dashboard');
    })->name('dashboard');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/admin_auth.php';
