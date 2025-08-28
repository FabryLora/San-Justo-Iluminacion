<?php

namespace App\Http\Controllers;

use App\Models\Linea;
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

        $query = Linea::query()->orderBy('order', direction: 'asc');

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        $lineas = $query->paginate($perPage);



        return inertia('admin/lineasAdmin', [
            'lineas' => $lineas,
        ]);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order' => 'sometimes|nullable|string|max:255',
            'text' => 'required|string',
            'name' => 'required|string|max:255',
            'image' => 'required|file',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        Linea::create($data);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'order' => 'sometimes|nullable|string|max:255',
            'name' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'sometimes|nullable|file',
        ]);

        /* si la imagen ya eiste borrala y crea otra */
        if ($request->hasFile('image')) {
            if ($request->image) {
                Storage::disk('public')->delete($request->image);
            }
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        Linea::findOrFail($request->id)->update($data);
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
