<?php

namespace App\Http\Controllers;

use App\Http\Requests\NiveauStoreRequest;
use Illuminate\Http\Request;
use App\Models\Niveau;

class NiveauController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Utilisez la méthode select pour exclure la colonne 'cycle_id' de la requête
        return Niveau::select('id', 'libelle')
                        ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NiveauStoreRequest $request)
    {
        $validatedData = $request->validated();
        $niveau = Niveau::create($validatedData);

        return response()->json($niveau, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Niveau::find($id);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
