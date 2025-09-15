<?php

namespace App\Http\Controllers;

use App\Models\Provincia;
use App\Models\PuntoVenta;
use Illuminate\Http\Request;

class PuntoVentaController extends Controller
{
    // Vista pública del mapa
    public function index(Request $request)
    {
        $provincia = $request->get('provincia');
        $localidad = $request->get('localidad');

        $puntosVenta = PuntoVenta::activos()
            ->porProvincia($provincia)
            ->porLocalidad($localidad)
            ->get();

        $provincias = PuntoVenta::getProvincias();

        $localidades = [];
        if ($provincia) {
            $localidades = PuntoVenta::getLocalidadesPorProvincia($provincia);
        }

        return view('donde-comprar', compact('puntosVenta', 'provincias', 'localidades', 'provincia', 'localidad'));
    }

    // API para obtener puntos de venta (AJAX)
    public function api(Request $request)
    {
        $provincia = $request->get('provincia');
        $localidad = $request->get('localidad');

        $puntosVenta = PuntoVenta::activos()
            ->porProvincia($provincia)
            ->porLocalidad($localidad)
            ->get();

        return response()->json($puntosVenta);
    }

    // API para obtener localidades por provincia
    public function getLocalidades(Request $request)
    {
        $provincia = $request->get('provincia');
        $localidades = PuntoVenta::getLocalidadesPorProvincia($provincia);

        return response()->json($localidades);
    }

    public function indexAdmin()
    {
        $puntosVenta = PuntoVenta::orderBy('nombre')->get();
        $provincias = Provincia::orderBy('name')->with('localidades')->get();
        return inertia('admin/puntosVenta', ['puntosVenta' => $puntosVenta, 'provincias' => $provincias]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|sometimes|string|max:255',
            'direccion' => 'nullable|sometimes|string|max:255',
            'provincia' => 'nullable|sometimes|string|max:255',
            'localidad' => 'nullable|sometimes|string|max:255',
            'latitud' => 'nullable|sometimes|numeric',
            'longitud' => 'nullable|sometimes|numeric',
            'telefono' => 'nullable|sometimes|string|max:50',
            'email' => 'nullable|sometimes|email|max:255',
            'activo' => 'sometimes|boolean',
        ]);



        PuntoVenta::create($data);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|sometimes|string|max:255',
            'direccion' => 'nullable|sometimes|string|max:255',
            'provincia' => 'nullable|sometimes|string|max:255',
            'localidad' => 'nullable|sometimes|string|max:255',
            'latitud' => 'nullable|sometimes|numeric',
            'longitud' => 'nullable|sometimes|numeric',
            'telefono' => 'nullable|sometimes|string|max:50',
            'email' => 'nullable|sometimes|email|max:255',
            'activo' => 'sometimes|boolean',
        ]);



        $puntoVenta = PuntoVenta::find($request->id);
        $puntoVenta->update($data);
    }

    public function destroy(Request $request)
    {
        $puntoVenta = PuntoVenta::find($request->id);
        if ($puntoVenta) {
            $puntoVenta->delete();
        }
    }
}
