<?php

use App\Models\Contacto;
use App\Models\Espacio;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Logos;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {

        View::share([
            'contacto' => Contacto::first(),
            'logos' => Logos::first(),
            'espacios' => Espacio::orderBy('order', 'asc')->with('usos')->get(),
        ]);
    }

    public function register() {}
}
