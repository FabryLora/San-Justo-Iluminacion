<?php

namespace App\Http\Controllers;

use App\Models\BannerPortada;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class BannerPortadaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner = BannerPortada::first();

        return Inertia::render('admin/bannerPortadaAdmin', ['banner' => $banner]);
    }





    public function update(Request $request)
    {
        $data = $request->validate([
            'title_banner_es' => 'nullable|sometimes|string|max:255',
            'title_banner_en' => 'nullable|sometimes|string|max:255',
            'text_banner_es' => 'nullable|sometimes|string',
            'text_banner_en' => 'nullable|sometimes|string',
            'image' => 'nullable|sometimes|file', // Máximo 2MB
            'title_seccion_uno_es' => 'nullable|sometimes|string|max:255',
            'title_seccion_uno_en' => 'nullable|sometimes|string|max:255',
            'text_seccion_uno_es' => 'nullable|sometimes|string',
            'text_seccion_uno_en' => 'nullable|sometimes|string',
            'title_seccion_dos_es' => 'nullable|sometimes|string|max:255',
            'title_seccion_dos_en' => 'nullable|sometimes|string|max:255',
            'text_seccion_dos_es' => 'nullable|sometimes|string',
            'text_seccion_dos_en' => 'nullable|sometimes|string',
            'title_seccion_tres_es' => 'nullable|sometimes|string|max:255',
            'title_seccion_tres_en' => 'nullable|sometimes|string|max:255',
            'text_seccion_tres_es' => 'nullable|sometimes|string',
            'text_seccion_tres_en' => 'nullable|sometimes|string',
            'image_seccion_dos' => 'nullable|sometimes|file', // Máximo 2MB
        ]);

        $bannerPortada = BannerPortada::first();

        // Si no existe, lo creamos
        if (!$bannerPortada) {
            if ($request->hasFile('image_banner')) {
                $data['image_banner'] = $request->file('image_banner')->store('images', 'public');
            }
            if ($request->hasFile('image_seccion_uno')) {
                $data['image_seccion_uno'] = $request->file('image_seccion_uno')->store('images', 'public');
            }
            if ($request->hasFile('image_seccion_dos')) {
                $data['image_seccion_dos'] = $request->file('image_seccion_dos')->store('images', 'public');
            }


            BannerPortada::create($data);

            return redirect()->back()->with('success', 'Banner creado correctamente');
        }

        // Si existe y se sube nueva imagen, eliminamos la anterior
        if ($request->hasFile('image_banner')) {
            if ($bannerPortada->getRawOriginal('image_banner')) {
                Storage::disk('public')->delete($bannerPortada->getRawOriginal('image_banner'));
            }
            $data['image_banner'] = $request->file('image_banner')->store('images', 'public');
        }
        if ($request->hasFile('image_seccion_uno')) {
            if ($bannerPortada->getRawOriginal('image_seccion_uno')) {
                Storage::disk('public')->delete($bannerPortada->getRawOriginal('image_seccion_uno'));
            }
            $data['image_seccion_uno'] = $request->file('image_seccion_uno')->store('images', 'public');
        }
        if ($request->hasFile('image_seccion_dos')) {
            if ($bannerPortada->getRawOriginal('image_seccion_dos')) {
                Storage::disk('public')->delete($bannerPortada->getRawOriginal('image_seccion_dos'));
            }
            $data['image_seccion_dos'] = $request->file('image_seccion_dos')->store('images', 'public');
        }


        $bannerPortada->update($data);

        return redirect()->back()->with('success', 'Banner actualizado correctamente');
    }
}
