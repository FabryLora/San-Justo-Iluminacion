<?php

namespace App\Http\Controllers;

use App\Models\Uso;
use Illuminate\Http\Request;

class UsoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $query = Uso::query()->orderBy('order', direction: 'asc');

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        $usos = $query->paginate($perPage);

        return inertia('admin/usosAdmin', [
            'usos' => $usos,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'nullable|sometimes|integer',
        ]);

        Uso::create($validatedData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'nullable|sometimes|string',
        ]);

        Uso::findOrFail($request->id)->update($validatedData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Uso::firstOrFail($request->id)->delete();
    }
}
