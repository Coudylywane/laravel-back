<?php

namespace App\Http\Controllers;

use App\Http\Requests\CycleStoreRequest;
use App\Models\Cycle;
use Illuminate\Http\Request;

class CycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /* if($request->has("join") && $request->join=="niveaux") {
           return Cycle::with("niveaux")->get();
         } */

         return Cycle::all();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CycleStoreRequest $request)
    {
        return Cycle::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Récupérer le Cycle avec ses Niveaux
        $cycleWithNiveaux = Cycle::with("niveaux")->find($id);

        if (!$cycleWithNiveaux) {
            return response()->json(['error' => 'Le cycle n\'existe pas.'], 404);
        }

        return $cycleWithNiveaux;
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
