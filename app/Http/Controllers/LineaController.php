<?php

namespace App\Http\Controllers;

use App\Models\Ambiente;
use App\Models\Linea;
use App\Models\LineaAmbiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class LineaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $query = Linea::query()->with('ambientes')->orderBy('order', direction: 'asc');

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        $lineas = $query->paginate($perPage);
        $ambientes = Ambiente::orderBy('order', 'asc')->get();


        return inertia('admin/lineasAdmin', [
            'lineas' => $lineas,
            'ambientes' => $ambientes,
        ]);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order' => 'sometimes|nullable|string|max:255',
            'text_es' => 'required|string',
            'name_es' => 'required|string|max:255',
            'text_en' => 'required|string',
            'name_en' => 'required|string|max:255',
            'image' => 'required|file',

        ]);

        $otherData = $request->validate([

            'ambientes' => 'required|array',
            'ambientes.*' => 'exists:ambientes,id',
        ]);



        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $linea = Linea::create($data);


        if ($request->has('ambientes')) {
            foreach ($otherData['ambientes'] as $ambienteId) {
                LineaAmbiente::create([
                    'linea_id' => $linea->id,
                    'ambiente_id' => $ambienteId,
                ]);
            }
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $data = $request->validate([
            'order' => 'sometimes|nullable|string|max:255',
            'name_es' => 'sometimes|nullable|string|max:255',
            'text_es' => 'sometimes|nullable|string',
            'name_en' => 'sometimes|nullable|string|max:255',
            'text_en' => 'sometimes|nullable|string',
            'image' => 'sometimes|nullable|file',

        ]);


        $otherData = $request->validate([
            'ambientes' => 'sometimes|nullable|array',
            'ambientes.*' => 'exists:ambientes,id',
        ]);



        /* si la imagen ya eiste borrala y crea otra */
        if ($request->hasFile('image')) {
            if ($request->image) {
                Storage::disk('public')->delete($request->image);
            }
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $linea = Linea::findOrFail($request->id);

        $linea->update($data);
        /* actualizar ambientes */
        if ($request->has('ambientes')) {

            // Eliminar las relaciones existentes
            LineaAmbiente::where('linea_id', $linea->id)->delete();
            // Crear nuevas relaciones
            foreach ($otherData['ambientes'] as $ambienteId) {
                LineaAmbiente::create([
                    'linea_id' => $linea->id,
                    'ambiente_id' => $ambienteId,
                ]);
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $linea = Linea::firstOrFail($request->id);
        $linea->delete();
    }
}
